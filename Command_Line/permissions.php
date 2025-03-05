<?php

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
