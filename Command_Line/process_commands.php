<?php
require_once '../includes/config_session.inc.php';
require 'Navigation.php';
require 'FileManagement.php';
require 'permissions.php';
require 'searching.php';
// Debugging: Log the request method and POST data
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("POST Data: " . print_r($_POST, true));
// Add these headers at the top of the PHP script
header('Access-Control-Allow-Origin: *'); // Allow all origins (for development)
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

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


// Handle the command
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = trim($_POST['command'] ?? '');
    
    // Improved argument parsing with quote handling
    preg_match_all('/"([^"]*)"|\'([^\']*)\'|(\S+)/', $command, $matches);
    $args = [];
    foreach ($matches[0] as $match) {
        $trimmed = trim($match, "'\"");
        if (!empty($trimmed)) {
            $args[] = $trimmed;
        }
    }

    $fileSystem = &$_SESSION['fileSystem'];
    $currentDir = &$_SESSION['currentDirectory'];

    $cmd = $args[0] ?? '';
    $arg = $args[1] ?? '';
    $arg2 = $args[2] ?? '';
    $output = "";

 switch ($cmd) {
        case 'ls':
            if ($arg === '-l') {
                $output = process_ls_l($fileSystem, $currentDir);
            }
            else $output = process_ls($fileSystem, $currentDir);
            break;
        case 'cd':
            $output = process_cd($currentDir, $fileSystem, $arg);
            break;
        case 'cat':
            $output = process_cat($fileSystem, $currentDir, $arg);
            break;
        case 'pwd':
            $output = process_pwd($currentDir);
            break;
        case 'mkdir':
            $output = process_mkdir($fileSystem, $currentDir, $arg);
            break;
        case 'mv':
            $output = process_mv($fileSystem, $currentDir, $arg, $arg2);
            break;
        case 'rm':
            if ($arg == "-rf") {
                $output = process_rm_rf($fileSystem, $currentDir, $arg2);
            }
            else {
            $output = process_rm($fileSystem, $currentDir, $arg);
            }
            break;
        case 'rmdir':
            $output = process_rmdir( $fileSystem, $currentDir, $arg);
            break;
        case 'refresh':
            $output = process_refresh();
            break;
        case 'chmod':
            $output = process_chmod($fileSystem, $currentDir, $arg, $arg2);
            break;
        case 'grep':
          //  if (str_starts_with($arg, '"')) continue; //ignore the sttring quotes
            $output = process_grep($fileSystem, $currentDir, $arg, $arg2);
            break;
        default:
            $output = "Command not recognized: $cmd\n";
            break;
    }

    // Return the output as JSON
    echo json_encode([
        'output' => $output,
        'currentDirectory' => $currentDir
    ]);
} 
