<?php

$app = require "./core/app.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Allow: POST');
	$app->renderJson(array(
		'status' => 'error',
		'message' => 'Method not allowed.'
	), 405);
}

$attributes = array(
	'name' => isset($_POST['name']) ? $_POST['name'] : null,
	'email' => isset($_POST['email']) ? $_POST['email'] : null,
	'city' => isset($_POST['city']) ? $_POST['city'] : null,
	'phone' => isset($_POST['phone']) ? $_POST['phone'] : null
);

$result = User::create($app->db, $attributes);
$user = $result['model'];
$errors = $result['errors'];

if (!empty($errors)) {
	$app->renderJson(array(
		'status' => 'error',
		'message' => 'Validation failed.',
		'errors' => $errors
	), 422);
}

$totalUsers = count(User::find($app->db, '*'));

$app->renderJson(array(
	'status' => 'ok',
	'message' => 'User created successfully.',
	'user' => array(
		'id' => $user->getId(),
		'name' => $user->getName(),
		'email' => $user->getEmail(),
		'city' => $user->getCity(),
		'phone' => $user->getPhone()
	),
	'totalUsers' => $totalUsers
), 201);