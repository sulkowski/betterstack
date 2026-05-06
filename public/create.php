<?php

$app = require __DIR__.'/../core/app.php';

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
$errors = $result['errors'];

if (!empty($errors)) {
	$app->renderJson(array(
		'status' => 'error',
		'message' => 'Validation failed.',
		'errors' => $errors
	), 422);
}

$created = $result['model'];

flash_set('User "'.$created->getName().'" was created successfully.');

http_response_code(201);
header('Location: /');
exit;
