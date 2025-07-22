package com.linuxlab.backend;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Map;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestHeader;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class Fetch_User_Data {

    @GetMapping("/api/user")
    public String getUserData(@RequestHeader Map<String, String> headers) {
        try {
            // Grab PHPSESSID from the original request (if it exists)
            String cookieHeader = headers.get("cookie");

            URL url = new URL("http://localhost/Linux-Lab/src/user/user.php");
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setRequestMethod("GET");

            // Forward the original cookie (includes PHPSESSID)
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

            return response.toString();  // Pass PHP's response back to frontend
        } catch (Exception e) {
            e.printStackTrace();
            return "{\"error\":\"Failed to fetch user data from PHP\"}";
        }
    }
}

