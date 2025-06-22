<?php

/**
 * This is used only by the built-in PHP server (php spark serve).
 * It is copied into writable/rewrite.php when the server is started.
 */

$uri = urldecode(
	parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/../../../../public' . $uri)) {
	return false;
}

require_once __DIR__ . '/../../../../public/index.php';
