<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

$usersFile = '../data/users.json';
$users = json_decode(file_get_contents($usersFile), true) ?? [];

$user = array_filter($users, function($u) use ($email) {
    return $u['email'] === $email;
});

$user = reset($user);

if ($user && password_verify($password, $user['password'])) {
    unset($user['password']);
    echo json_encode([
        'success' => true, 
        'user' => $user
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Невірний email або пароль'
    ]);
}