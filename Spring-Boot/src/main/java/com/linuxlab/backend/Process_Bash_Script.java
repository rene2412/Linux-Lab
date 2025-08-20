package com.linuxlab.backend;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.TimeUnit;

import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/api")
@CrossOrigin(origins = "*") // Add CORS support
public class Process_Bash_Script {

    @PostMapping("/script")
    @SuppressWarnings("CallToPrintStackTrace")
    public ResponseEntity<Map<String, Object>> runScript(@RequestBody Map<String, String> body) {
        String scriptContent = body.get("script");
        Map<String, Object> result = new HashMap<>();
        
        // Add debugging
        System.out.println("Received script content: " + scriptContent);
        
        if (scriptContent == null || scriptContent.trim().isEmpty()) {
            result.put("error", "Script content is empty");
            return ResponseEntity.badRequest().body(result);
        }
        
        long startTime = System.currentTimeMillis();
        Path scriptPath = null;
        
        try {
            // Create temporary script file
            scriptPath = Files.createTempFile("user-script-", ".sh");
            Files.write(scriptPath, scriptContent.getBytes());
            scriptPath.toFile().setExecutable(true);
            
            System.out.println("Created script file: " + scriptPath.toString());
            
            // Create process with proper environment
            ProcessBuilder pb = new ProcessBuilder("bash", scriptPath.toString());
            pb.redirectErrorStream(false); // Keep stdout and stderr separate
            
            // Set working directory and environment
            pb.directory(scriptPath.getParent().toFile());
            Map<String, String> env = pb.environment();
            env.put("PATH", "/usr/local/bin:/usr/bin:/bin");
            
            Process process = pb.start();
            
            // Set timeout for process execution (30 seconds)
            boolean finished = process.waitFor(30, TimeUnit.SECONDS);
            
            if (!finished) {
                process.destroyForcibly();
                result.put("error", "Script execution timed out after 30 seconds");
                result.put("output", "");
                return ResponseEntity.ok(result);
            }
            
            // Read output streams
            StringBuilder outputBuilder = new StringBuilder();
            StringBuilder errorBuilder = new StringBuilder();
            
            // Read stdout
            try (BufferedReader reader = new BufferedReader(new InputStreamReader(process.getInputStream()))) {
                String line;
                while ((line = reader.readLine()) != null) {
                    outputBuilder.append(line).append("\n");
                }
            }
            
            // Read stderr
            try (BufferedReader errorReader = new BufferedReader(new InputStreamReader(process.getErrorStream()))) {
                String line;
                while ((line = errorReader.readLine()) != null) {
                    errorBuilder.append(line).append("\n");
                }
            }
            
            String output = outputBuilder.toString();
            String errorOutput = errorBuilder.toString();
            int exitCode = process.exitValue();
            
            // Debug output
            System.out.println("Exit code: " + exitCode);
            System.out.println("Output: [" + output + "]");
            System.out.println("Error: [" + errorOutput + "]");
            
            // Calculate execution time
            long executionTime = System.currentTimeMillis() - startTime;
            
            result.put("output", output.trim());
            result.put("error", errorOutput.trim());
            result.put("exitCode", exitCode);
            result.put("executionTime", executionTime);
            result.put("success", exitCode == 0);
            
            return ResponseEntity.ok(result);
            
        } catch (IOException e) {
            System.err.println("IOException: " + e.getMessage());
            e.printStackTrace();
            result.put("error", "IO Error: " + e.getMessage());
            result.put("output", "");
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body(result);
            
        } catch (InterruptedException e) {
            System.err.println("InterruptedException: " + e.getMessage());
            Thread.currentThread().interrupt();
            result.put("error", "Process was interrupted: " + e.getMessage());
            result.put("output", "");
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body(result);
            
        } finally {
            // Clean up temporary file
            if (scriptPath != null) {
                try {
                    Files.deleteIfExists(scriptPath);
                } catch (IOException e) {
                    System.err.println("Failed to delete temporary file: " + e.getMessage());
                }
            }
        }
    }
}