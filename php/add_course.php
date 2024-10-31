<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$description = $data['description'];
$author = $data['author'];

$coursesFile = '../data/courses.json';
$courses = json_decode(file_get_contents($coursesFile), true) ?? [];

$newCourse = [
    'id' => uniqid(),
    'title' => $title,
    'description' => $description,
    'author' => $author
];

$courses[] = $newCourse;
file_put_contents($coursesFile, json_encode($courses, JSON_PRETTY_PRINT));

echo json_encode(['success' => true]);