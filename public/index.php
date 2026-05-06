<?php

$app = require __DIR__.'/../core/app.php';

const USERS_PER_PAGE = 15;

$searchName = isset($_GET['name']) ? trim($_GET['name']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
	$page = 1;
}

$conditions = array();
if ($searchName !== '') {
	$conditions['name'] = array('like' => '%'.$searchName.'%');
}

$totalRecords = User::countWhere($app->db, $conditions);
$perPage = USERS_PER_PAGE;
$totalPages = $totalRecords > 0 ? (int)ceil($totalRecords / $perPage) : 1;
if ($page > $totalPages) {
	$page = $totalPages;
}

$offset = ($page - 1) * $perPage;
$showingFrom = $totalRecords > 0 ? $offset + 1 : 0;
$showingTo = $totalRecords > 0 ? min($offset + $perPage, $totalRecords) : 0;

$buildPageHref = function ($targetPage) use ($searchName) {
	$parts = array();
	if ($searchName !== '') {
		$parts['name'] = $searchName;
	}
	if ($targetPage > 1) {
		$parts['page'] = $targetPage;
	}
	$q = http_build_query($parts, '', '&', PHP_QUERY_RFC3986);
	return '?' . $q;
};

$paginationPages = array();
if ($totalRecords > 0) {
	if ($totalPages <= 7) {
		for ($i = 1; $i <= $totalPages; $i++) {
			$paginationPages[] = array('type' => 'page', 'n' => $i, 'href' => $buildPageHref($i));
		}
	} else {
		$candidates = array(1, 2, $page - 1, $page, $page + 1, $totalPages - 1, $totalPages);
		$nums = array();
		foreach ($candidates as $n) {
			if ($n >= 1 && $n <= $totalPages) {
				$nums[$n] = true;
			}
		}
		$nums = array_keys($nums);
		sort($nums, SORT_NUMERIC);
		$prev = null;
		foreach ($nums as $n) {
			if ($prev !== null && $n > $prev + 1) {
				$paginationPages[] = array('type' => 'ellipsis');
			}
			$paginationPages[] = array('type' => 'page', 'n' => $n, 'href' => $buildPageHref($n));
			$prev = $n;
		}
	}
}

$pagination = array(
	'page' => $page,
	'perPage' => $perPage,
	'totalRecords' => $totalRecords,
	'totalPages' => $totalPages,
	'showingFrom' => $showingFrom,
	'showingTo' => $showingTo,
	'hasPrev' => $page > 1,
	'hasNext' => $page < $totalPages,
	'prevHref' => $buildPageHref($page - 1),
	'nextHref' => $buildPageHref($page + 1),
	'pages' => $paginationPages,
);

$userModels = User::find($app->db, '*', $conditions, array('id' => 'DESC'), array($offset, $perPage));
$users = array();
foreach ($userModels as $user) {
	$users[] = array(
		'id' => $user->getId(),
		'name' => $user->getName(),
		'email' => $user->getEmail(),
		'city' => $user->getCity(),
		'phone' => $user->getPhone(),
	);
}

$app->renderView('users/index', array(
	'users' => $users,
	'searchName' => $searchName,
	'pagination' => $pagination,
));
