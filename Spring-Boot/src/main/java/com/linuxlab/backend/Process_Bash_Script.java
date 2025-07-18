package com.linuxlab.backend;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.Map;
import java.util.stream.Collectors;

import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/api")
public class Process_Bash_Script {

@PostMapping("/script")
public ResponseEntity<String> runScript(@RequestBody Map<String, String> body) {
    String scriptContent = body.get("script");

    try {
        Path scriptPath = Files.createTempFile("user-", ".sh");
        Files.write(scriptPath, scriptContent.getBytes());
        scriptPath.toFile().setExecutable(true);

        ProcessBuilder pb = new ProcessBuilder("docker", "run", "--rm", "-v",
            scriptPath.toAbsolutePath() + ":/script.sh", "bash", "/script.sh");

        Process process = pb.start();

        BufferedReader reader = new BufferedReader(new InputStreamReader(process.getInputStream()));
        String output = reader.lines().collect(Collectors.joining("\n"));

        return ResponseEntity.ok(output);
    } catch (IOException e) {
        return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("Script execution failed.");
        }
    }
}

