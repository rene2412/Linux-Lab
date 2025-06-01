<?php 
$json = file_get_contents('../../testAPI/lessons.json'); // or from a DB row
$data = json_decode($json, true); 
//echo "<pre>";
//print_r($data);
//echo "</pre>";

//will return the basics module
$basics = $data['The Basics'] ?? null;
$firstLessonBasics = null;
foreach ($basics as $item) {
    if (isset($item["id"])) {
        $firstLessonBasics= $item;
        break;
    }
}
if ($firstLessonBasics) {
     $idBasics = $firstLessonBasics['id'];
     $parentBasics = urlencode($firstLessonBasics['parent']);
     // Generate a link to the real lesson.html page
     echo "<a href='/Linux-Lab/src/pages/lesson_page/lesson.html?parent=$parentBasics&id=$idBasics'>The Basics Module</a><br>";
     echo "\n";
    }
    echo "The Basics first lesson ID: " . $firstLessonBasics['id'] . "<br>";
    



//will return the networks module 
$networking = $data['Networking'] ?? null;
$firstLessonNetworking = null;

foreach ($networking as $item) {
    if (isset($item["id"])) {
        $firstLessonNetworking = $item;
        break;
    }
}
if ($firstLessonNetworking) {
    $idNetworking = $firstLessonNetworking['id'];
    $parentNetworking = urlencode($firstLessonNetworking['parent']);
  // Generate a link to the real lesson.html page
  echo "<a href='/Linux-Lab/src/pages/lesson_page/lesson.html?parent=$parentNetworking&id=$idNetworking'>Start Networking Module</a>";
} else {
    echo "No networking lessons found.";
}