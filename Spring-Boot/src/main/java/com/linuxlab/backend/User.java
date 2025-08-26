package com.linuxlab.backend;
import com.fasterxml.jackson.annotation.JsonIgnoreProperties;

@JsonIgnoreProperties(ignoreUnknown = true)
public class User {
    private int userId;
    private String username;

    public User() {
        this.userId = 0;
        this.username = "";
    }

    public User(int userId, String username, String currentModule) {
        this.userId = userId;
        this.username = username;
    }

    public int getUserId() { return userId; }
    public void setUserId(int userId) { this.userId = userId; }

    public String getUsername() { return username; }
    public void setUsername(String username) { this.username = username; }

}
