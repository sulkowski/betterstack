<?php

$app = require __DIR__.'/../core/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
	header('Allow: DELETE');
	$app->renderJson(array(
		'status' => 'error',
		'message' => 'Method not allowed.'
	), 405);
}

$input = array();
parse_str(file_get_contents('php://input'), $input);
$id = isset($input['id']) ? (int)$input['id'] : null;
if ($id === null) {
	$app->renderJson(array(
		'status' => 'error',
		'message' => 'User id is required.'
	), 422);
}

$user = User::findFirst($app->db, '*', array('id' => $id));
if (!$user) {
	$app->renderJson(array(
		'status' => 'error',
		'message' => 'User not found.'
	), 404);
}

$name = $user->getName();
$user->delete();

flash_set('User "'.$name.'" was removed successfully.');

$app->renderJson(array(
	'status' => 'ok',
	'location' => '/'
), 200);
