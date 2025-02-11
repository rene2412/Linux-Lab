<?php
require 'includes/config_session.inc.php';
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
            "WhatWouldIdo.txt" => "
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
Without someone like you",
    
            	 "BirchTree.txt" => "
I could be my best if I spoke my own head for you
You could see me now if you told yourself how you knew me
Oh, are you not lonely?
And oh, as you sit by the birch tree
Come to the tree, bring a birthday card for you
Seem a bit shocked, but crack a brief smile
I notice
Oh, you're not lonely
And oh, as we sit by the birch tree
As she goes in again
I look at my own head
Back from the blue, I know it's nothing new
I know we're pretty young but I see what people grow into
'Cause two years ahead I can see that you might not know me
Oh, I could be lonely
And oh, as I sit by the bitch tree",
	    
	 "WithoutYou.txt" => "
Do you really have to talk
About the things you do with him?
Do you really have to talk about it love?
Do you really have to talk
About the way that you love him?
Do you really have to talk about your love?
Nah-nah-nah-nah...
Living my life without you
Nah-nah-nah-nah...
Living my life without you
Did you really have to do
Those things you knew that could hurt me?
Did you really have to do those things to me?
But I know that I can't be
The one you love that's in your life
But I know that I can't be the one you love",

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

function process_ls($fileSystem, $currentDirectory): string {
    if ($currentDirectory === "/") {
        $currentLevel = $fileSystem["/"];
        return format_directory_contents($currentLevel);
    }
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = $fileSystem["/"];
    foreach ($path as $part) {
        if (!isset($currentLevel[$part])) {
             return "Directory not found.\n";
        }
        if (!is_array($currentLevel[$part])) {
            return "Not a directory.\n";
        }
        $currentLevel = $currentLevel[$part]; 
    }
    return format_directory_contents($currentLevel);
}
function process_ls_l($fileSystem, $currentDirectory) : string { 
       // Handle root directory special case
    if ($currentDirectory === "/") {
        $currentLevel = $fileSystem["/"];
        return format_directory_contents($currentLevel);
    }
    // Remove trailing slash if present
    $currentDirectory = rtrim($currentDirectory, "/");
    
    // Split path into components
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    // Start from root
    $currentLevel = $fileSystem["/"];
    // Traverse the path
    foreach ($path as $part) {
        if (!isset($currentLevel[$part])) {
             return "Directory not found.\n";
        }
        //if (!is_array($currentLevel[$part])) {
          //  return "Not a directory.\n";
       // }
      $currentLevel = $currentLevel[$part]; 
    }
        // Prepare output to hold directory contents
    $output = "";
    foreach ($currentLevel as $name => $content) {
        // Skip metadata and files inside it
        if ($name === "metadata") {
            continue;
        }
        
        // Build the ls -l format
        $line = "";
        
        // Check for metadata for files and directories
        if (isset($content['metadata'])) {
        // If it's a directory (or any array with metadata), display the metadata
        $metadata = $content['metadata'];
        $line .= $metadata['permissions'] . " ";
        $line .= $metadata['owner'] . " ";
        $line .= $metadata['group'] . " ";
        $line .= $metadata['created'] . " ";
        $line .= $metadata['modified'] . " ";
        $line .= $name . "\n";
        } elseif (is_string($content)) {
        // If it's a file (content is a string), display default file metadata
        $line .= "-rw-r--r-- "; // Default permissions for files
        $line .= "user "; // Default owner
        $line .= "group "; // Default group
        $line .= "2025-02-01 10:00:00 "; // Default created timestamp
        $line .= "2025-02-01 10:10:00 "; // Default modified timestamp
        $line .= $name . "\n";
}
        // Append the line to the output
        $output .= $line . "\n";
    }

    return $output;
}


function format_directory_contents(array $contents): string {
    if (empty($contents)) {
        return "This directory is empty.\n";
    }
    $output = [];
    foreach ($contents as $name => $content) {
        if (is_array($content)) {
            if ($name === "metadata") continue;
            $output[] = $name . "/";
        } else {
            $output[] = $name;
        }
    }
    sort($output);
    return implode(" ", $output) . "\n";
}

function process_cd(&$currentDirectory, $fileSystem, $dir): string  {
    if ($dir === "..") {
        if ($currentDirectory !== "/") {
            $pathParts = explode("/", trim($currentDirectory, "/"));
            array_pop($pathParts); 
            $currentDirectory = "/" . implode("/", $pathParts);
            if ($currentDirectory === "") {
                $currentDirectory = "/";
            }
        }
        return "";
    }  
        
    $targetPath = trim($dir, "/");
    $pathParts = explode("/", $targetPath);

    // Handle the chaining of cd, ex: cd Documents/Subfolder/temp
     if (count($pathParts) > 1) {
        // Start from the root if it's an absolute path, otherwise start from the current directory
        $newDirectory = (substr($dir, 0, 1) === "/") ? "/" : rtrim($currentDirectory, "/");
        // Split current directory into parts
        $path = array_filter(explode("/", trim($newDirectory, "/")), 'strlen');
        // Start from the root of the file system
        $currentLevel = $fileSystem["/"]; //basically initialzing to zero
        // Traverse the file system to the current directory
        foreach ($path as $part) {
            if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
                return "Error: Invalid directory path.\n";
            }
            $currentLevel = &$currentLevel[$part];
        }
        
        //for every directory in the path
        foreach ($pathParts as $part) {
                // Check if the directory exists
                if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
                    return "ErroR: Directory '$part' not found.\n";
                }
                $currentLevel = &$currentLevel[$part];
                $newDirectory = rtrim($newDirectory, "/") . "/" . $part;
            }
        // Update the current directory
        $currentDirectory = $newDirectory;    
    }
    else {    
        $path = array_filter(explode("/", trim($currentDirectory, "/")), 'strlen');
        // Start from the root of the file system
        $currentLevel = $fileSystem["/"];
        // Traverse the file system to the current directory
        foreach ($path as $part) {
            if (!isset($currentLevel[$part]) || $part === 'metadata') {
                return "Error: Directory not found.\n";
            }
                $currentLevel = $currentLevel[$part];
        }
        // Check if the target directory exists
        if ($dir === "metadata" || !isset($currentLevel[$dir]) || !is_array($currentLevel[$dir])) {
            return "Error: Directory not found.\n";
        }
        // Update the current directory path
        $currentDirectory = rtrim($currentDirectory, "/") . "/" . $dir;
    }
    return "";
}

function process_pwd($currentDirectory) : string {
    return $currentDirectory . "\n";
}
function process_mkdir(&$fileSystem, $currentDirectory, $newdir): string {
    // Traverse to the current directory in the file system
    $path = array_filter(explode("/", trim($currentDirectory, "/")), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Start from root

    // Traverse the path to reach the current directory
    foreach ($path as $part) {
        $currentLevel = &$currentLevel[$part];
    // Check if the directory already exists
    if (isset($currentLevel[$newdir])) {
        return "Directory already exists: $newdir\n";
        }
    }
    // Create the new directory
    $currentLevel[$newdir] = [];
    return $newdir . "\n";
}
function process_cat(&$filesystem, $currentDirectory, $file): string {
    $currentDirectory = rtrim($currentDirectory, "/");
    $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = $filesystem["/"];
    foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: Invalid directory path.\n";
        }
        $currentLevel = $currentLevel[$part];
    }
    if (!isset($currentLevel[$file])) {
        return "Error: File not found.\n";
    }
    if (is_array($currentLevel[$file])) {
        return "Error: '$file' is a directory.\n";
    }
    return ($currentLevel[$file] ?? "[Empty File]") . "\n";
}
function process_mv(&$filesystem, $currentDirectory, $oldname, $newname): string {
    // Helper to resolve absolute paths
    $resolvePath = function ($baseDir, $path) {
        $isAbsolute = (substr($path, 0, 1) === '/');
        $parts = $isAbsolute ? [] : explode('/', trim($baseDir, '/'));
        foreach (explode('/', $path) as $part) {
            if ($part === '..') {
                if (!empty($parts)) array_pop($parts);
            } elseif ($part !== '.' && $part !== '') {
                $parts[] = $part;
            }
        }
        return '/' . implode('/', $parts);
    };

    // Resolve full source and target paths
    $sourcePath = $resolvePath($currentDirectory, $oldname);
    $targetPath = $resolvePath($currentDirectory, $newname);

    // Navigate to source directory
    $sourceDir = dirname($sourcePath);
    $sourceName = basename($sourcePath);
    $sourceParts = array_filter(explode('/', trim($sourceDir, '/')), 'strlen');
    $sourceLevel = &$filesystem['/'];
    foreach ($sourceParts as $part) {
        if (!array_key_exists($part, $sourceLevel) || !is_array($sourceLevel[$part])) {
            return "Error: Source path invalid.";
        }
        $sourceLevel = &$sourceLevel[$part];
    }

    // Check if source exists
    if (!array_key_exists($sourceName, $sourceLevel)) {
        return "Error: '$oldname' not found.";
    }

    // Navigate to target directory
    $targetDir = dirname($targetPath);
    $targetName = basename($targetPath);
    $targetParts = array_filter(explode('/', trim($targetDir, '/')), 'strlen');
    $targetLevel = &$filesystem['/'];
    foreach ($targetParts as $part) {
        if (!array_key_exists($part, $targetLevel) || !is_array($targetLevel[$part])) {
            return "Error: Target directory does not exist.";
        }
        $targetLevel = &$targetLevel[$part];
    }

    // If target is a directory, append source name (e.g., mv file.txt dir/)
    if (array_key_exists($targetName, $targetLevel) && is_array($targetLevel[$targetName])) {
        $targetLevel = &$targetLevel[$targetName];
        $targetName = $sourceName;
    }

    // Check for conflicts
    if (array_key_exists($targetName, $targetLevel)) {
        return "Error: '$targetName' already exists.";
    }

    // Perform the move/rename
    $targetLevel[$targetName] = $sourceLevel[$sourceName];
    unset($sourceLevel[$sourceName]);

    return "Successfully moved '$oldname' to '$newname'.";
}


function process_refresh() : string {
    // Reinitialize session variables to restore the default file system
    global $fileSystem; // Access the original file system structure

    $_SESSION['fileSystem'] = &$fileSystem; // Reset the file system
    $_SESSION['currentDirectory'] = "/";  // Reset to root directory

    return "File system has been reset to default.\n";
}

function process_rm(&$fileSystem, &$currentDirectory, $argument): string {
    // Trim and split the current directory path
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Reference to root

    // Traverse to the current directory
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "ERror: '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the file exists
    if (!array_key_exists($argument, $currentLevel)) {
        return "Error: File '$argument' not found.\n";
    }

    // Check if the target is a directory
    if (is_array($currentLevel[$argument])) {
        return "Error: '$argument' is a directory. Use 'rmdir' to remove directories.\n";
    }

    // Remove the file
    unset($currentLevel[$argument]);
    return "File '$argument' has been removed.\n"; // Removed incorrect session save
}

function process_rmdir(&$fileSystem, &$currentDirectory, $argument): string {
    // Prevent deleting parent directory with "rmdir .."
    if ($argument === "..") {
        return "Error: Cannot remove parent directory.\n";
    }

    // Trim and split the current directory path
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Reference to root

    // Traverse to the current directory
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "ErRor: Directory '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the target directory exists
    if (!isset($currentLevel[$argument])) {
        return "ErRor: Directory '$argument' not found.\n";
    }

    // Check if it's actually a directory
    if (!is_array($currentLevel[$argument])) {
        return "Eror: '$argument' is not a directory.\n";
    }

    // Check if the directory is empty before deleting
    if (!empty($currentLevel[$argument])) {
        return "Error: Directory '$argument' is not empty. Try 'rm -rf'\n";
    }

    // Otherwise remove the empty directory or file
    unset($currentLevel[$argument]);

    return "'$argument' has been removed.\n";
}

function process_rm_rf(&$fileSystem, &$currentDirectory, $argument): string {
    // Prevent deleting parent directory with "rm -rf .."
    if ($argument === "..") {
        return "Error: Cannot remove parent directory.\n";
    }

    // Trim and split the current directory path
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Reference to root

    // Traverse to the current directory (without checking $argument yet)
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "ErRor: Directory '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the target exists
    if (!isset($currentLevel[$argument])) {
        return "ErrRr: '$argument' not found.\n";
    }

    // Recursively delete if it's a directory
    if (is_array($currentLevel[$argument])) {
        delete_recursive($currentLevel[$argument]); // recursively delete
    }

    // Remove the target (file or now-empty directory)
    unset($currentLevel[$argument]);

    return "'$argument' has been removed recursively.\n";
}

 // Helper function to recursively delete a directory's contents.
function delete_recursive(&$directory) {
    foreach ($directory as $key => &$content) {
        if (is_array($content)) {
            delete_recursive($content); // 🔁 Recursive call for subdirectories
        }
        unset($directory[$key]); // Delete files or now-empty directories
    }
}

function process_chmod(&$fileSystem, $currentDirectory, $argument, $targetFile) : string {
    // Navigate to the target directory in $fileSystem
    $path = $currentDirectory === '/' ? [] : explode('/', trim($currentDirectory, '/'));
    $current = &$fileSystem['/']; // Start at root

    foreach ($path as $part) {
        if (!isset($current[$part]) || !is_array($current[$part])) {
            return "Directory not found.\n";
        }
        $current = &$current[$part];
    }

    // Check if the target file exists and is a file
    if (!isset($current[$targetFile]) || is_array($current[$targetFile])) {
        return "File not found or is a directory.\n";
    }

    // Ensure metadata exists (convert string content to array with metadata)
    if (is_string($current[$targetFile])) {
        $content = $current[$targetFile];
        $current[$targetFile] = [
            'content' => $content,
            'metadata' => [
                'permissions' => '-rw-r--r--',
                'owner' => 'user',
                'group' => 'group',
                'created' => '2025-02-01 10:00:00',
                'modified' => '2025-02-01 10:10:00'
            ]
        ];
    }

    // Update permissions based on $argument
    $permissions = str_split($current[$targetFile]['metadata']['permissions']);
    switch ($argument) {
        case 'u+x':
            $permissions[3] = 'x'; // Set user execute
            break;
        case 'g-w':
            $permissions[5] = '-'; // Remove group write
            break;
        case 'o=r':
            // Set others to read-only: r-- (positions 7-9)
            $permissions[7] = 'r';
            $permissions[8] = '-';
            $permissions[9] = '-';
            break;
        // Add other cases as needed...
        default:
            return "Invalid chmod argument.\n";
    }

    $current[$targetFile]['metadata']['permissions'] = implode('', $permissions);
    return "Permissions updated for $targetFile.\n";
}


function retrieve_files_from_directory($fileSystem, $currentDirectory) : array {
        $files = []; // will hold all the files in current directory, the key will hold the file name and value will be its content
         $currentDirectory = rtrim($currentDirectory, "/");
        $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
        $currentLevel = $fileSystem["/"];
        foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return [];
                }
        $currentLevel = $currentLevel[$part];
        }
        //for every thing in the current directory
        foreach($currentLevel as $name => $content) {
        //if the content is a directory, skip it
        if (!is_array($content)) {
                $files[$name] = $content;
                }
        }
        return $files;
}



function process_grep($fileSystem, $currentDirectory, $pattern, $file) : string {
    $currentDirectory = rtrim($currentDirectory, "/");
    $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = $fileSystem["/"];
    foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: Invalid directory path.\n";
        }
        $currentLevel = $currentLevel[$part];
    }
    $results = [];
    //look for the pattern in every txt file in the current directory 
    if ($file === "*.txt") {
        $files = retrieve_files_from_directory($fileSystem, $currentDirectory); // check if .txt files exist    
        foreach($files as $name => $content) {
                if (str_ends_with($name, ".txt")) {
                        $lines = explode("\n", trim($content));
                        foreach($lines as $line) {
                                if (strpos($line, $pattern) !== false) {
                                        $results[] = "$name: $line";
                                }
                        }
                }
          }
    }
    else {
     if (!isset($currentLevel[$file])) {
        return "Error: File not found.\n";
      }
    if (is_array($currentLevel[$file])) {
         return "Error: '$file' is a directory.\n";
      }
    //split the file into lines 
    $lines = explode("\n", trim($currentLevel[$file]));
    //for every word in our lines, search for the pattern
    foreach($lines as $line) {
        if (strpos($line, $pattern) !== false) {
                $results[] = $line;
                }
           }
    }
        return empty($results) ? "No matches found\n" : implode("\n", $results);
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
            if (str_starts_with($arg, '"')) continue; //ignore the sttring quotes
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
