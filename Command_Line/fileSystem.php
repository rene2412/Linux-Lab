<?php

// Simulated file system
$fileSystem = [
    "/" => [
        "Documents" => [
            "metadata" => [
                 "0",
                "permissions" => "drwxr-xr-x", // Directory permissions
                "owner" => "user",
                "group" => "group",
                "created" => "2025-02-01 10:00:00",
                "modified" => "2025-02-01 10:05:00"
            ],
            "strawberryguy.txt" => "
            I can tell that the grass is greener
            On the other side, with you
            I wouldn't know, what to do without you
            Stay by my side eternally
            
            What would I do
            Without someone like you?
            What would I do
            Without someone like you?
            What would I do?
            
            I can tell, that the waters clearer
            On the other side, with you
            I know you care, about the faults in my life
            Just promise me this, stay with me
            
            What would I do
            Without someone like you
            ",
            "dino.txt" => "
                     __ 
                    / _) .. ROAR!!!
           _.----._/ /
          /          /
     __/  (  |  (  |
    /__.-'|_|--|__|
    ",
            "metadata" => [
                "1",
                "permissions" => "-rw-r--r--", // File permissions
                "owner" => "user",
                "group" => "group",
                "created" => "2025-02-01 10:00:00",
                "modified" => "2025-02-01 10:10:00",
                "size" => 1234 // file size in bytes
                ],
                "Subfolder" => [
                    "metadata" => [
                        "2",
                        "permissions" => "drwxr-xr-x",
                        "owner" => "user1",
                        "group" => "group1",
                        "created" => "2025-02-01 10:05:00",
                        "modified" => "2025-02-01 10:07:00"
                    ],
                    "file1.txt" => [
                        "metadata" => [
                            "3",
                            "permissions" => "-rw-r--r--",
                            "owner" => "user1",
                            "group" => "group1",
                            "created" => "2025-02-01 10:05:00",
                            "modified" => "2025-02-01 10:06:00",
                            "size" => 234
                        ]
                    ]
                ]
            ],
            "Pictures" => [
                "metadata" => [
                    "4",
                    "permissions" => "drwxr-xr-x",
                    "owner" => "user2",
                    "group" => "group2",
                    "created" => "2025-02-01 10:10:00",
                    "modified" => "2025-02-01 10:12:00"
                ],
                "photo.jpg" => [
                    "metadata" => [
                        "5",
                        "permissions" => "-rw-r--r--",
                        "owner" => "user2",
                        "group" => "group2",
                        "created" => "2025-02-01 10:10:00",
                        "modified" => "2025-02-01 10:11:00",
                        "size" => 789
                    ]
                ]
            ],
            "Videos" => [
                "metadata" => [
                    "6",
                    "permissions" => "drwxr-xr-x",
                    "owner" => "user3",
                    "group" => "group3",
                    "created" => "2025-02-01 10:15:00",
                    "modified" => "2025-02-01 10:16:00"
                ],
            ],
            "Projects" => [
                "metadata" => [
                    "7",
                    "permissions" => "drwxr-xr-x",
                    "owner" => "user1",
                    "group" => "group1",
                    "created" => "2025-02-01 10:20:00",
                    "modified" => "2025-02-01 10:21:00"
                ],
                "project1" => [
                    "metadata" => [
                        "8",
                        "permissions" => "drwxr-xr-x",
                        "owner" => "user1",
                        "group" => "group1",
                        "created" => "2025-02-01 10:20:00",
                        "modified" => "2025-02-01 10:21:00"
                    ],
                    "file2.txt" => [
                        "metadata" => [
                            "9",
                            "permissions" => "-rw-r--r--",
                            "owner" => "user1",
                            "group" => "group1",
                            "created" => "2025-02-01 10:20:00",
                            "modified" => "2025-02-01 10:21:00",
                            "size" => 1012
                        ]
                    ]
                ]
            ]
        ]
    ];
    
if (!isset($_SESSION['fileSystem'])) {
    $_SESSION['fileSystem'] = $fileSystem;
}

if (!isset($_SESSION['currentDirectory'])) {
    $_SESSION['currentDirectory'] = "/";
}