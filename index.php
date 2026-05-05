<?php

// Init app instance
$app = require "./core/app.php";

$searchName = isset($_GET['name']) ? trim($_GET['name']) : '';
$conditions = array();
if ($searchName !== '') {
	$conditions['name'] = array('like' => '%'.$searchName.'%');
}
$userModels = User::find($app->db, '*', $conditions, array('id' => 'DESC'));
$users = array();
foreach ($userModels as $user) {
	$users[] = array(
		'id' => $user->getId(),
		'name' => $user->getName(),
		'email' => $user->getEmail(),
		'city' => $user->getCity(),
		'phone' => $user->getPhone()
	);
}
$totalUsers = count(User::find($app->db, '*'));

$isAjax = (
	isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
);

if ($isAjax) {
	$app->renderJson(array(
		'status' => 'ok',
		'users' => $users,
		'totalUsers' => $totalUsers
	));
}

// Render view 'views/index.php' and pass users variable there
$app->renderView('index', array(
	'users' => $users,
	'searchName' => $searchName,
	'totalUsers' => $totalUsers
));
