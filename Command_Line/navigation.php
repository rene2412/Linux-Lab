<?php
require_once 'helpers.php';

/*
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
*/

function process_ls($fileSystem, $currentDirectory): string {
    if (!is_array($fileSystem)) {
        return "Filesystem is not initialized.\n"; // Prevent NULL error
    }

    if (!isset($fileSystem["/"]) || !is_array($fileSystem["/"])) {
        return "Filesystem root not found.\n"; // Handle missing root
    }

    if ($currentDirectory === "/") {
        return format_directory_contents($fileSystem["/"]);
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


function process_pwd($currentDirectory): string {
    return $currentDirectory . "\n";
}

echo "ran successfully\n";