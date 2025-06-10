<?php

require __DIR__ . '/inc/database/esr-database.class.php';
require __DIR__ . '/inc/enums/esr-role.enum.php';

if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit('MEHEHE');
}

$database = new ESR_Database();
$database->database_uninstall();

$roles = new ESR_Role();
foreach ($roles->getItems() as $key => $role) {
	remove_role($role['key']);
}