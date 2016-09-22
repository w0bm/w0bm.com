<?php
return [

	'identified_by' => ['username', 'email'],

	// The Super Admin role
	// (returns true for all permissions)
	'super_admin' => 'Super Admin',

	// DB prefix for tables
	'prefix' => '',

	// Define Models if you extend them
	'models' => [
		'user' => 'App\Models\User',
		'role' => 'App\Models\Role',
		'permission' => 'Toddish\Verify\Models\Permission',
	],

	'crud_permissions' => [
		'create_', 'read_', 'update_', 'delete_'
	]

];
