<?php

/**
 * Session flash messages (Rails-style): write before a redirect, read once on the next request.
 */

/**
 * @param string $message User-visible text (plain; escape when outputting HTML)
 */
function flash_set($message) {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	if (!isset($_SESSION['_flash']) || !is_array($_SESSION['_flash'])) {
		$_SESSION['_flash'] = array();
	}
	$_SESSION['_flash'][] = $message;
}

/**
 * @return array<int, string|array<string, mixed>> legacy entries may still be array with `message` key
 */
function flash_take_all() {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	if (empty($_SESSION['_flash']) || !is_array($_SESSION['_flash'])) {
		return array();
	}
	$messages = $_SESSION['_flash'];
	unset($_SESSION['_flash']);
	return $messages;
}
