package com.linuxlab.backend;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Map;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestHeader;
import org.springframework.web.bind.annotation.RestController;

import com.fasterxml.jackson.databind.ObjectMapper;

@RestController
public class UserController {

    private String fetchUserJsonFromPhp(Map<String, String> headers) throws Exception {
        String cookieHeader = headers.get("cookie");
        URL url = new URL("http://localhost/Linux-Lab/src/user/user.php");
        HttpURLConnection conn = (HttpURLConnection) url.openConnection();
        conn.setRequestMethod("GET");
        if (cookieHeader != null) {
            conn.setRequestProperty("Cookie", cookieHeader);
        }

        BufferedReader in = new BufferedReader(new InputStreamReader(conn.getInputStream()));
        StringBuilder response = new StringBuilder();
        String inputLine;
        while ((inputLine = in.readLine()) != null) {
            response.append(inputLine);
        }
        in.close();

        return response.toString();
    }

    @GetMapping("/api/user")
    public User getUser(@RequestHeader Map<String, String> headers) {
        try {
            String userJson = fetchUserJsonFromPhp(headers);
            System.out.println("Raw JSON from PHP: " + userJson);
            // Use Jackson ObjectMapper to parse JSON string into User
            ObjectMapper mapper = new ObjectMapper();

            // If JSON keys differ from field names, use @JsonProperty annotations on User fields
            User user = mapper.readValue(userJson, User.class);

            return user;
        } catch (Exception e) {
            e.printStackTrace();
            return new User(); // fallback empty user
        }
    }
}

