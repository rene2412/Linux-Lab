<?php
require_once 'helpers.php';
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
