<?php

$app = require "./core/app.php";

header('Content-Type: application/json; charset=utf-8');

function respondWithJson($statusCode, $payload) {
	http_response_code($statusCode);
	echo json_encode($payload);
	exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Allow: POST');
	respondWithJson(405, array(
		'status' => 'error',
		'message' => 'Method not allowed.'
	));
}

$attributes = array(
	'name' => isset($_POST['name']) ? $_POST['name'] : null,
	'email' => isset($_POST['email']) ? $_POST['email'] : null,
	'city' => isset($_POST['city']) ? $_POST['city'] : null
);

$result = User::create($app->db, $attributes);
$user = $result['model'];
$errors = $result['errors'];

if (!empty($errors)) {
	respondWithJson(422, array(
		'status' => 'error',
		'message' => 'Validation failed.',
		'errors' => $errors
	));
}

$totalUsers = count(User::find($app->db, array('id')));

respondWithJson(201, array(
	'status' => 'ok',
	'message' => 'User created successfully.',
	'user' => array(
		'id' => $user->getId(),
		'name' => $user->getName(),
		'email' => $user->getEmail(),
		'city' => $user->getCity()
	),
	'totalUsers' => $totalUsers
));