<?php
session_start();
//require 'includes/config_session.inc.php';
//session_unset();
require_once "network.php";
// Debugging: Log the request method and POST data
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("POST Data: " . print_r($_POST, true));
// Add these headers at the top of the PHP script
header('Access-Control-Allow-Origin: *'); // Allow all origins (for development)
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$fileSystem = [
    "/" => [
        "Documents" => [
            "directory" => [
                "permissions" => "drw-r--r--",
                "owner" => "user",
                "group" => "group",
                "created" => "2025-02-27 01:24:04",
                "modified" => "2025-02-27 01:24:04",
                "size" => 648,
            ],
            "BirchTree.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 648,
                    "content" => [
                        "I could be my best if I spoke my own head for you",
                        "You could see me now if you told yourself how you knew me",
                        "And oh, as I sit by the bitch tree"
                    ]
                ]
            ],
            "penguin.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 585,
                    "content" => [
                        "Penguins are cool"
                    ]
                ]
            ],
            "hello.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 148,
                    "content" => [
      "  ___                                      .-~. /_\"-._",
      "`-._~-.                                  / /_ \"~o\\  :Y",
      "      \\  \\                                / : \\~x.  ` ')",
      "      ]  Y                              /  |  Y< ~-.__j",
      "     /   !                        _.--~T : l  l<  /.-~",
      "    /   /                 ____.--~ .   ` l /~\\ \\<|Y",
      "   /   /             .-~~\"        /| .    ',-~\\ \\L| .... ROARRR!",
      "  /   /             /     .^   \\ Y~Y \\.^>/l_   \"--'",
      " /   Y           .-\"(  .  l__  j_j l_/ /~_.-~    .",
      "Y    l          /    \\  )    ~~~.\" / `/\"~ / \\.__/l_",
      "|     \\     _.-\"      ~-{__     l  :  l._Z~-.___.--~",
      "|      ~---~           /   ~~\"---\\_  ' __[>",
      "l  .                _.^   ___     _>-y~",
      " \\  \\     .      .-~   .-~   ~>--\"  /",
      "  \\  ~---\"            /     ./  _.-'",
      "   \"-.,_____.,_  _.--~\\     _.-~",
      "               ~~     (   _}  ",
      "                      `. ~(",
      "                        )  \\",
      "                  /,`--'~\\--'~\\",
                    ]
                ]
            ],
            "Subfolder" => [
                "something.txt" => [
                    "file" => [
                        "permissions" => "-rw-r--r--",
                        "owner" => "user",
                        "group" => "group",
                        "created" => "2025-02-27 01:24:04",
                        "modified" => "2025-02-27 01:24:04",
                        "size" => 12,
                        "content" => ["Hello World!"]
                    ]
                ]
            ]
        ],
        "Pictures" => [
            "photo.jpg" => [
                "file.txt" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 0,
                    "content" => []
                ]
            ]
        ],
        "Videos" => [],
        "Projects" => [
            "project1" => [],
            "file2.txt" => [
                "file" => [
                    "permissions" => "-rw-r--r--",
                    "owner" => "user",
                    "group" => "group",
                    "created" => "2025-02-27 01:24:04",
                    "modified" => "2025-02-27 01:24:04",
                    "size" => 0,
                    "content" => []
                ]
            ]
        ]
    ]
];

if (!isset($_SESSION['fileSystem'])) {
    // Initialize new session with file system
    $_SESSION['fileSystem'] = $fileSystem;
    $_SESSION['currentDirectory'] = "/";
}
function process_echo(&$fileSystem, $currentDirectory, $arg, $operator, $file): string {
    if (empty($operator) && empty($file)) {
        return $arg . "\n";
    }
    
    if ($operator && $file) {
        $currentDirectory = rtrim($currentDirectory, "/");
        $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
        $currentLevel = &$fileSystem["/"];
        
        foreach ($pathParts as $part) {
            if (!isset($currentLevel[$part])) {
                return "Error: Invalid directory path.\n";
            }
            $currentLevel = &$currentLevel[$part];
        }
        
        if ($operator === '>' || $operator === '>>') {
            // Create the file if it doesn't exist using `touch`
            if (!isset($currentLevel[$file])) {
                $touchResult = process_touch($fileSystem, $currentDirectory, $file);
                if (str_starts_with($touchResult, "Error")) {
                    return $touchResult; // Propagate errors (e.g., invalid extension)
                }
            }
            
            // Check if target is a directory
            if (is_array($currentLevel[$file]) && !isset($currentLevel[$file]['file'])) {
                return "Error: '$file' is a directory.\n";
            }
            
            // Update content (now guaranteed to be in array format)
            $fileContent = &$currentLevel[$file]['file']['content'];
            if ($operator === '>') {
                $fileContent = [$arg]; // Overwrite with new content
            } else { // >>
                $fileContent[] = $arg; // Append new line
            }
            
            // Update metadata
            $currentLevel[$file]['file']['modified'] = date("Y-m-d H:i:s");
            $contentString = implode("\n", $fileContent);
            $currentLevel[$file]['file']['size'] = strlen($contentString);
            
            $_SESSION['fileSystem'] = $fileSystem;
            return "";
        }
    }
    return $arg . "\n";
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

function format_directory_contents(array $contents): string {
    if (empty($contents)) {
        return "This directory is empty.\n";
    }
    $output = [];
    foreach ($contents as $name => $content) {
            if ($name === "directory") continue; //skip the directory meta data
            //if its an array that doesnt end with a .txt then its a directory
            if (is_array($content) && !str_ends_with($name, ".txt")) {
                $output[] = $name . "/";
            }
            else {
                $output[] = $name;
            }
        }
    sort($output);
    return implode(" ", $output) . "\n";
}

function process_touch(&$fileSystem, $currentDirectory, $arg) {   
    $GLOBALS['commandSuccess'] = false;
    if (!str_ends_with($arg, ".txt")) {
        return "Error: Files must end in .txt";
    }
    // Handle root directory special case 
    if ($currentDirectory === "/") {
        if (isset($fileSystem["/"][$arg])) {
            return "Error: '$arg' already exists\n";
        }
        // Create new file with metadata
        $fileSystem["/"][$arg] = [
            "file" => [
                "permissions" => "-rw-r--r--",
                "owner" => "user",
                "group" => "group",
                "created" => date("Y-m-d H:i:s"),
                "modified" => date("Y-m-d H:i:s"),
                "size" => 0,
                "content" => []
            ]
        ];
        $_SESSION['fileSystem'] = $fileSystem;
        $GLOBALS['commandSuccess'] = true;
        return "";
    }


    // Remove trailing slash if present
    $currentDirectory = rtrim($currentDirectory, "/");
    // Split path into components
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    // Start from root and maintain reference
    $currentLevel = &$fileSystem["/"];
    // Navigate to current directory
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || $part === 'file' || !is_array($currentLevel[$part])) {
            return "Error: Directory not found\n";
        }
        $currentLevel = &$currentLevel[$part];
    }

    // Check if file already exists
    if (isset($currentLevel[$arg])) {
        return "Error: '$arg' already exists\n";
    }
 
    // Create new empty file with metadata
    $currentLevel[$arg] = [
        "file" => [
            "permissions" => "-rw-r--r--",
            "owner" => "user",
            "group" => "group",
            "created" => date("Y-m-d H:i:s"),
            "modified" => date("Y-m-d H:i:s"),
            "size" => 0,
            "content" => []
        ]
    ];
    
    // Make sure changes are saved to session
    $_SESSION['fileSystem'] = $fileSystem;
    $GLOBALS['commandSuccess'] = true; 
}

function process_ls_l($fileSystem, $currentDirectory) : string { 
    // Navigate to the target directory
    if ($currentDirectory === "/") {
        $currentLevel = $fileSystem["/"];
    } else {
        $currentDirectory = rtrim($currentDirectory, "/");
        $path = array_filter(explode("/", $currentDirectory), 'strlen');
        $currentLevel = $fileSystem["/"];
        foreach ($path as $part) {
            if (!isset($currentLevel[$part])) {
                return "Directory not found.\n";
            }
            $currentLevel = $currentLevel[$part];
        }
    }

    $output = "";
    foreach ($currentLevel as $name => $content) {
        // Files: Use metadata from 'file' key
        if (is_array($content) && isset($content['file'])) {
            $file = $content['file'];
            $line = sprintf(
                "%s %s %s %s %d %s\n",
                $file['permissions'],
                $file['owner'],
                $file['group'],
                $file['modified'],
                $file['size'],
                $name
            );
        } 
        // Directories: Default metadata
        else {
            $line = sprintf(
                "drw-r--r-- user group %s 4096 %s/\n",
                date("Y-m-d H:i:s"), // Placeholder timestamp
                $name
            );
        }
        $output .= $line;
    }
    return $output;
}

function process_cd(&$currentDirectory, $fileSystem, $dir): string {
    $GLOBALS['commandSuccess'] = false;

    // Handle root directory access: cd /
    if ($dir === "/") {
        $currentDirectory = "/";
        $GLOBALS['commandSuccess'] = true;
        return "";
    }

    // Convert relative path into an array
    $newPath = explode("/", trim($dir, "/"));
    $pathParts = explode("/", trim($currentDirectory, "/"));

    foreach ($newPath as $part) {
        if ($part === "..") {
            if (!empty($pathParts)) {
                array_pop($pathParts); // Move up one directory
            }
        } else {
            $pathParts[] = $part; // Move into the next directory
        }
    }

    // Resolve final path
    $resolvedPath = implode("/", $pathParts);
    if ($resolvedPath === "/") {
        $resolvedPath = "/";
    }

    // Traverse filesystem to validate the path
    $currentLevel = &$fileSystem["/"];
    $traversePath = array_filter(explode("/", trim($resolvedPath, "/")), 'strlen');

    foreach ($traversePath as $part) {
        if (str_ends_with($part, ".txt") || !isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: '$part' is not a directory.\n";
        }
        $currentLevel = &$currentLevel[$part];
    }

    // If successful, update current directory
    $currentDirectory = $resolvedPath;
    $GLOBALS['commandSuccess'] = true;
    return "";
}



function process_pwd($currentDirectory) : string {
    return $currentDirectory . "\n";
}
function process_mkdir(&$fileSystem, $currentDirectory, $newdir): string {
    $GLOBALS['commandSuccess'] = false;
    // Remove any trailing slashes from the directory name
    $newdir = rtrim($newdir, "/");
    
    
    $special_chars = ['$', '~', '!', '@', '#', '%', '^', '&', '*', '(', ')', '-', '_', '+', '=', '|', '{', '}', ':', ';', '"', ',', '<', '>', '.', '?', '/', '\''];
    // Check if directory name is empty after removing slashes

    foreach($special_chars as $chars) {
        if (str_contains($newdir, $chars)) {
            return "Error: Special Characters Not Allowed To Make Directory";
        }
    }

    if (empty($newdir) || str_ends_with($newdir, ".txt")) {
        return "Invalid directory name\n";
    }
    
    // Traverse to the current directory in the file system
    $path = array_filter(explode("/", trim($currentDirectory, "/")), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Start from root
    
    // Traverse the path to reach the current directory
    foreach ($path as $part) {
        if (!array_key_exists($part, $currentLevel)) {
            return "Error: Invalid Path\n";
        }
        $currentLevel = &$currentLevel[$part];
    }
    
    // Check if the directory already exists
    if (array_key_exists($newdir, $currentLevel)) {
        return "Error: directory already exists: $newdir\n";
    }
    
    // Create the new directory
    $currentLevel[$newdir] = [];
    $GLOBALS['commandSuccess'] = true;
    return "\n";
}

function process_cat(&$filesystem, $currentDirectory, $file): string {
    $GLOBALS['commandSuccess'] = false;
    $currentDirectory = rtrim($currentDirectory, "/");
    $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = $filesystem["/"];
    
    // Navigate to target directory
    foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: Invalid directory path.\n";
        }
        $currentLevel = $currentLevel[$part];
    }

    // Check if file exists
    if (!isset($currentLevel[$file])) {
        return "Error: File not found.\n";
    }

    // Handle directories
    if (is_array($currentLevel[$file]) && !isset($currentLevel[$file]['file'])) {
        return "Error: '$file' is a directory.\n";
    }

    // Extract content based on format
    if (isset($currentLevel[$file]['file']['content'])) {
        // New metadata format
        $GLOBALS['commandSuccess'] = true;
        return implode("\n", $currentLevel[$file]['file']['content']) . "\n";
    } elseif (is_string($currentLevel[$file])) {
        // Legacy string format
        $GLOBALS['commandSuccess'] = true;
        return $currentLevel[$file] . "\n";
    }
    return "";
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

    $_SESSION['fileSystem'] = unserialize(serialize($fileSystem)); // Reset the file system
    $_SESSION['currentDirectory'] = "/";  // Reset to root directory

    return "File system has been reset to default.\n";
}

function process_rm(&$fileSystem, &$currentDirectory, $argument): string {
    $GLOBALS['commandSuccess'] = false;
    // Trim and split the current directory path
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Reference to root

    // Traverse to the current directory
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the file exists
    if (!array_key_exists($argument, $currentLevel)) {
        return "Error: File '$argument' not found.\n";
    }

    // Check if the target is a directory
    if ((!str_ends_with($argument, ".txt"))) {
        return "Error: '$argument' is a directory. Use 'rmdir' to remove directories.\n";
    }

    // Remove the file
    unset($currentLevel[$argument]);
    $GLOBALS['commandSuccess'] = true;
    return "File '$argument' has been removed.\n"; // Removed incorrect session save
}

function process_rmdir(&$fileSystem, &$currentDirectory, $argument): string {
    $GLOBALS['commandSuccess'] = false;
    // Prevent deleting parent directory with "rmdir .."
    if ($argument === "..") { 
        return "Error: Cannot remove parent directory.\n";
    }
    //ignore the arguement trail slash
    $argument = rtrim($argument, "/");
    // Trim and split the current directory path
    $currentDirectory = rtrim($currentDirectory, "/");
    $path = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = &$fileSystem["/"]; // Reference to root

    // Traverse to the current directory
    foreach ($path as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: Directory '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the target directory exists
    if (!isset($currentLevel[$argument])) {
        return "Error: Directory '$argument' not found.\n";
    }

    // Check if it's actually a directory
    if (!is_array($currentLevel[$argument])) {
        return "Error: '$argument' is not a directory.\n";
    }

    // Check if the directory is empty before deleting
    if (!empty($currentLevel[$argument])) {
        return "Error: Directory '$argument' is not empty. Try 'rm -rf'\n";
    }

    // Otherwise remove the empty directory or file
    unset($currentLevel[$argument]);
    $GLOBALS['commandSuccess'] = true;
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
            return "Error: Directory '$part' not found.\n";
        }
        $currentLevel = &$currentLevel[$part]; // Maintain reference
    }

    // Check if the target exists
    if (!isset($currentLevel[$argument])) {
        return "Error: '$argument' not found.\n";
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
    // Navigate to the target directory
    $path = $currentDirectory === '/' ? [] : explode('/', trim($currentDirectory, '/'));
    $current = &$fileSystem['/'];
    foreach ($path as $part) {
        if (!isset($current[$part]) || !is_array($current[$part])) {
            return "Directory not found.\n";
        }
        $current = &$current[$part];
    }

    // Check if the target is a valid file (not a directory)
    if (
        !isset($current[$targetFile]) || 
        (is_array($current[$targetFile]) && !isset($current[$targetFile]['file']))
    ) {
        return "File not found or is a directory.\n";
    }

    // Update permissions (no need for legacy conversion; files use 'file' key)
    $file = &$current[$targetFile]['file'];
    $permissions = str_split($file['permissions']);
    
    switch ($argument) {
        case 'u+x':
            $permissions[3] = 'x'; // User execute (e.g., -rwxr--r--
            break;
        case 'g-w':
            $permissions[5] = '-'; // Remove group write (e.g., -rw-r-----
            break;
        case 'o=r':
            $permissions[7] = 'r';
            $permissions[8] = '-';
            $permissions[9] = '-';
            break;
        default:
            return "Invalid chmod argument.\n";
    }

    $file['permissions'] = implode('', $permissions);
    $file['modified'] = date("Y-m-d H:i:s");
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


function process_grep($fileSystem, $currentDirectory, $flag, $pattern, $file) : string {
    $currentDirectory = rtrim($currentDirectory, "/");
    $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
    $currentLevel = $fileSystem["/"];
    $line_numbers = 0;
    $count = 0;

    // Navigate to current directory
    foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part]) || !is_array($currentLevel[$part])) {
            return "Error: Invalid directory path.\n";
        }
        $currentLevel = $currentLevel[$part];
    }

    $results = [];

    if ($file === "*.txt") {
        foreach ($currentLevel as $name => $entry) {
            if (str_ends_with($name, ".txt") && isset($entry['file']['content'])) { 
                $lines = $entry['file']['content']; 
                $line_numbers = 0;
                
                foreach ($lines as $line) {
                    $line_numbers++;
                    // Flag logic
                    if ($flag === "-n") {
                        if (strpos($line, $pattern) !== false) {
                            $results[] = "$name | Line: $line_numbers: $line";
                        }
                    } 
                    elseif ($flag === "-c") {
                        if (strpos($line, $pattern) !== false) $count++; 
                    }
                    elseif ($flag === "-i") {
                        if (stripos($line, $pattern) !== false) {
                            $results[] = $line;
                        }
                    }
                    else {
                        if (strpos($line, $pattern) !== false) {
                            $results[] = "$name: $line";
                        }
                    }
                }
            }
        }
    }
    
    else {
        if (!isset($currentLevel[$file])) {
            return "Error: File not found.\n";
        }
        if (!str_ends_with($file, ".txt") || !isset($currentLevel[$file]['file']['content'])) {
            return "Error: Not a .txt file.\n";
        }

        $lines = $currentLevel[$file]['file']['content'];
        $line_numbers = 0;

        foreach ($lines as $line) {
            $line_numbers++;
            // Flag logic
            if ($flag === "-n") {
                if (strpos($line, $pattern) !== false) {
                    $results[] = "Line: $line_numbers | $line";
                }
            } 
            elseif ($flag === "-c") {
                if (strpos($line, $pattern) !== false) $count++;
            }
            elseif ($flag === "-i") {
                if (stripos($line, $pattern) !== false) {
                    $results[] = $line;
                }
            }
            else {
                if (strpos($line, $pattern) !== false) {
                    $results[] = "Line: $line_numbers | $line";
                }
            }
        }
    }

    // Return results
    if ($flag === "-c") return ($count > 0) ? "$count\n" : "0\n";
    return empty($results) ? "No matches found\n" : implode("\n", $results) . "\n";
}


function retrieve_files_from_argument($fileSystem, $currentDirectory, $expression): array {
    $files = [];
    $searchPath = rtrim($currentDirectory, "/");
    $pathParts = array_filter(explode("/", ltrim($searchPath, "/")), 'strlen');
    $currentLevel = $fileSystem["/"];

    // Navigate to target directory
    foreach ($pathParts as $part) {
        if (!isset($currentLevel[$part])) {
            return [];
        }
        $currentLevel = $currentLevel[$part];
    }

    foreach ($currentLevel as $name => $entry) {
        $fullPath = $searchPath . "/" . $name;

        // Handle directories (arrays without 'file' key)
        if (is_array($entry) && !isset($entry['file'])) {
            $files = array_merge(
                $files,
                retrieve_files_from_argument($fileSystem, $fullPath, $expression)
            );
        } 
        // Handle files (arrays with 'file' key)
        elseif (is_array($entry) && isset($entry['file'])) {
            if (fnmatch($expression, $name)) {
                $files[$fullPath] = $entry['file']['content'];
            }
        }
    }

    return $files;
}

function process_find($fileSystem, $currentDirectory, $path, $expression): string {
    $expression = trim($expression, "\"'");
    $files = retrieve_files_from_argument($fileSystem, $path, $expression);
    return empty($files) ? "No files found.\n" : implode("\n", array_keys($files)) . "\n";
}

function process_ping($host) : string {
    if ($host != "google.com") return "Invalid Ping Command: Try Host Name 'google.com'";
        $output = $GLOBALS['ping'];
        $lines = explode("\n", $output);
        $result = "";
        
        for ($i = 0; $i < count($lines); $i++) {
                $result .= $lines[$i] . "\n";
                flush();
        }
	return $result;
}

function process_ip($flag) : string {
    if ($flag === "a" || $flag === "addr") {
    return $GLOBALS['ip'] . "\n";
    }
    elseif ($flag === "route") {
    return $GLOBALS['route'] . "\n";
    }
    else return "";
}

function process_traceroute($host) : string {
    if ($host != "google.com") return "Invalid traceroute Command: Try Host Name 'google.com'";
    $output = $GLOBALS['traceroute'];
    $lines = explode("\n", $output);
    $result = "";
    
    for ($i = 0; $i < count($lines); $i++) {
            $result .= $lines[$i] . "\n";
            flush();
    }
return $result;
}

function process_nslookup($host) : string {
    if ($host != "google.com") return "Invalid nslookup Command: Try Host Name 'google.com'";
    return $GLOBALS['nslookup'];
}

function process_dig($host) : string {
    if ($host != "google.com") return "Invalid dig Command: Try Host Name 'google.com'";
    return $GLOBALS['dig'];
}

function process_host($host) : string {
    if ($host != "google.com") return "Invalid host Command: Try Host Name 'google.com'";
    return $GLOBALS['host'];
}

function process_curl($host) : string {
    if ($host !== "https://www.apple.com/" && $host !== "https://www.weather_api/") return "Invalid curl command: Try a valid host name";
    if ($host === "https://www.apple.com/") return $GLOBALS['curl']; 
    else return $GLOBALS['curl_api'];
}
function process_wget(&$fileSystem, $currentDirectory, $host) : string {
    if ($host != "http://example.com") {
        return "Invalid wget Command: Try Host Name 'http://example.com'";
    }
    
    // Create index.html using the touch function
    $result = process_touch($fileSystem, $currentDirectory, "index.html");
    
    // Check if the file was created successfully
    if (strpos($result, "Successfully") === false) {
        return $result; // Return the error message
    }
    
    // Now update the content of the file we just created
    $currentDirectory = rtrim($currentDirectory, "/");
    $pathParts = array_filter(explode("/", $currentDirectory), 'strlen');
    
    // Initialize current level at root
    if ($currentDirectory === "/" || empty($pathParts)) {
        $currentLevel = &$fileSystem["/"];
    } else {
        $currentLevel = &$fileSystem["/"];
        // Navigate to the current directory
        foreach ($pathParts as $part) {
            if (!isset($currentLevel[$part])) {
                return "Error: Directory not found\n";
            }
            $currentLevel = &$currentLevel[$part];
        }
    }
    
    // Update the file with the HTML content
    if (isset($currentLevel["index.html"]) && isset($currentLevel["index.html"]["file"])) {
        $currentLevel["index.html"]["file"]["content"] = $GLOBALS['index'];
        $currentLevel["index.html"]["file"]["size"] = strlen($GLOBALS['index']);
        $currentLevel["index.html"]["file"]["modified"] = date("Y-m-d H:i:s");
        
        // Save changes to session
        $_SESSION['fileSystem'] = $fileSystem;
        
        // Return wget output to show the download was successful
        return $GLOBALS['wget'];
    } else {
        return "Error: Failed to update index.html\n";
    }
}

function process_date() : string {
    return date('Y-m-d H:i:s');
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
    $arg3 = $args[3] ?? '';
    $output = "";
    $json = '';
    $isCorrect = false;
    $jsonString = file_get_contents('src/testAPI/lessons.json');
    $jsonData = json_decode($jsonString, true);
    // Check for JSON parsing errors
    if (json_last_error() !== JSON_ERROR_NONE) {
      $output = "JSON Error: " . json_last_error_msg();
    }
    
    function GetCurrentLesson() : int {
        $jsonUser = file_get_contents('src/testAPI/userInfo.json');
        // Decode the JSON into a PHP array
        $userData = json_decode($jsonUser, true);
        $value = (int)$userData[0]['lesson'];
        return $value;
    }
    $GLOBALS['commandSuccess'] = false;
 
switch ($cmd) {
        case 'echo':
            $GetLine = "";
            $operator = "";
            $file = "";   
        // Process args to handle redirection
        for ($i = 0; $i < count($args); $i++) {
            $word = $args[$i];
            if ($word === $cmd) continue;    
            // Check for redirection operators
            if ($word === '>' || $word === '>>') {
                $operator = $word;
                if (isset($args[$i + 1])) {
                    $file = $args[$i + 1];
                        }
            break;  // Stop adding to GetLine once we hit operator
                    }
                $GetLine .= $word . " ";
                }
                $GetLine = rtrim($GetLine);  // Remove trailing space
                 $json = $jsonData['basics'][1]['answer'] . "\n";  // or [2], or find the correct index 
                $full_command = $cmd . " " . $GetLine;
                // Trim and normalize the strings before comparing
                $normalizedJson = trim($json);
               
        if (strtolower($normalizedJson) === strtolower($normalizedCommand)) {
                //we need change and override the is completed key variable in the json file to true
                //Update the completed status in the JSON data
                $jsonData['basics'][1]['completed'] = true;
                 // Convert the updated data back to JSON
                $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
                // Write the updated JSON back to the file
                file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
                //if we are in this first lesson then send the bool
                if (GetCurrentLesson() === 3) {
                    $isCorrect = true;
                }   
            }   
             $output = process_echo($fileSystem, $currentDir, $GetLine, $operator, $file);
            break;   
        case 'touch':
                $output = process_touch($fileSystem, $currentDir, $arg);    
                $jsonData['File Navigation'][7]['completed'] = true;
                 // Convert the updated data back to JSON
                $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
                // Write the updated JSON back to the file
                file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
                if (GetCurrentLesson() === 13 && $GLOBALS['commandSuccess'] && $arg === "linux.txt") {
                    $isCorrect = true;
                }
            break;
        case 'ls':
            if ($arg === '-l') {
                $output = process_ls_l($fileSystem, $currentDir);
                break;
            }
                
            $jsonData['basics'][4]['completed'] = true;
             // Convert the updated data back to JSON
            $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
            // Write the updated JSON back to the file
            file_put_contents('src/testAPI/lessons.json', $updatedJsonString);          
            
            if (GetCurrentLesson() === 6) {
                $isCorrect = true;
            }
            $output = process_ls($fileSystem, $currentDir);
            break;
        case 'cd':
                 $output = process_cd($currentDir, $fileSystem, $arg);
            if ($arg === "..") {
                 $jsonData['basics'][6]['completed'] = true;
                 //Convert the updated data back to JSON
                 $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
                 //Write the updated JSON back to the file
                 file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
                 
                if (GetCurrentLesson() === 9) {
                    $isCorrect = true;
                }
                 break;
            } else {
                if ($GLOBALS['commandSuccess']) {
                 // Convert the updated data back to JSON
                 $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
                 //Write the updated JSON back to the file
                 file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
                 $jsonData['basics'][5]['completed'] = true;
                if (GetCurrentLesson() === 7) {
                    $isCorrect = true;
                }
               }
            }
            break;
        case 'date':
                 $jsonData['basics'][2]['completed'] = true;
                if (GetCurrentLesson() === 4) {
                    $isCorrect = true;
                }
                $output = process_date();
            break;
        case 'cat':
                   $output = process_cat($fileSystem, $currentDir, $arg);
                   //Convert the updated data back to JSON
                   $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
                   //Write the updated JSON back to the file
                   file_put_contents('src/testAPI/lessons.json', $updatedJsonString);
                if (GetCurrentLesson() === 8 && $GLOBALS['commandSuccess'] && $arg === "hello.txt") {
                    $isCorrect = true;
                }
            break;
        case 'pwd':
                 $jsonData['basics'][3]['completed'] = true;
                if (GetCurrentLesson() === 5) {
                    $isCorrect = true;
                }
                 $output = process_pwd($currentDir);
            break;
        case 'mkdir':
            $output = process_mkdir($fileSystem, $currentDir, $arg);
            if (GetCurrentLesson() == 14 && $GLOBALS['commandSuccess'] && ($arg === "ubuntu/" || $arg === "ubuntu")) {
                    $isCorrect = true;
            }
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
                if (GetCurrentLesson() === 15 && $GLOBALS['commandSuccess'] && $arg === "penguin.txt") {
                    $isCorrect = true;
                }
        }
            break;
        case 'rmdir':
            $output = process_rmdir( $fileSystem, $currentDir, $arg);
            if (GetCurrentLesson() === 16 && $GLOBALS['commandSuccess'] && ($arg === "project1/" || $arg === "project1")) {
                $isCorrect = true; 
            }
            break;
        case 'refresh':
            $output = process_refresh();
            break;
        case 'chmod':
            $output = process_chmod($fileSystem, $currentDir, $arg, $arg2);
            break;
        case 'grep':
            $flag = ($arg && str_starts_with($arg, "-")) ? $arg : "";
            $pattern = $flag ? $arg2 : $arg;
            $file = $flag ? $arg3 : $arg2;
            //$output = "flag: $flag\n pattern: $pattern\n file: $file";
            $output = process_grep($fileSystem, $currentDir, $flag, $pattern, $file);
            break;
        case 'find':
                // Parse "find <path> -name <pattern>"
        if (count($args) < 3) {
            $output = "Usage: find <path> -name \"<pattern>\"\n";
            break;
            }
            $path = $args[1];
            $expression = $args[count($args) - 1];
            // If "-name" is provided, adjust path and expression
            if ($args[2] === '-name' && count($args) >= 4) {
            $path = $args[1];
            $expression = $args[3];
            }
            // Trim quotes from the expression (e.g., "*.txt" → *.txt)
            $expression = trim($expression, "\"'");
            $output = process_find($fileSystem, $currentDir, $path, $expression);
            break;
	case 'ping':
        $output = process_ping($arg);
        break;
    case 'ip': 
            $flag = $arg;
            if ($flag === "a" || $flag === "addr" || $flag === "route") {
                $output = process_ip($flag);
          	} else {
        	    $output = "Invalid command. Only 'ip a' and 'ip addr' are allowed.\n";
		    }
    case 'traceroute':
        $output = process_traceroute($arg);
	    break;
	case 'nslookup':
        $output = process_nslookup($arg);
        break;
    case 'dig':
        $output = process_dig($arg);
        break;
    case 'host';
        $output = process_host($arg);
        break;
    case 'curl':
        $output = process_curl($arg);
        break;
    case 'wget':
        $output = process_wget($fileSystem, $currentDir, $arg);
        break;
    default:
            $output = "Command not recognized: $cmd\n";
            break;
    }

    // Return the output as JSON
    echo json_encode([
        'output' => $output,
        'commandSuccess' => $isCorrect,
        'currentDirectory' => $currentDir
    ]);
} 
