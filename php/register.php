<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

$usersFile = '../data/users.json';
$users = json_decode(file_get_contents($usersFile), true) ?? [];

// Перевірка чи існує вже користувач
$userExists = array_filter($users, function($user) use ($email) {
    return $user['email'] === $email;
});

if (!empty($userExists)) {
    echo json_encode(['success' => false, 'message' => 'Користувач з таким email вже існує']);
    exit;
}

$newUser = [
    'id' => uniqid(),
    'name' => $name,
    'email' => $email,
    'password' => $password
];

$users[] = $newUser;
file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

echo json_encode(['success' => true]);