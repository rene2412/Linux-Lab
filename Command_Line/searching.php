<?php

function process_grep($filesystem, $currentDirectory, $pattern, $file) : string {
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
    $output = $currentLevel[$file];
    //split the file into lines 
    $lines = explode("\n", trim($output));
    //for every word in our lines, search for the pattern
    $results = [];
    foreach($lines as $line) {
        if (strpos($line, $pattern) !== false) {
                $results[] = $line;
                        }
                }
        return empty($results) ? "No matches found\n" : implode("\n", $results);
}
