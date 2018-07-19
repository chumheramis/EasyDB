<?php
$user_table = [
	'tblname' => 'user',
	'columns' => [
		[
			'name'          => 'id',
			'type'          => 'int',
			'primary'       => true,
			'unique'        => true,
			'autoincrement' => true,
			'notnull'       => true
		],
		[
			'name'    => 'userlevel',
			'type'    => 'int',
			'length'  => 1,
			'default' => '2'
		],
		[
			'name'    => 'username',
			'type'    => 'varchar',
			'length'  => 45,
			'unique'  => true,
			'notnull' => true
		],
		[
			'name'    => 'password',
			'type'    => 'varchar',
			'length'  => 20,
			'notnull' => true
		],
		[
			'name'   => 'firstname',
			'type'   => 'varchar',
			'length' => 45
		],
		[
			'name'   => 'midname',
			'type'   => 'varchar',
			'length' => 1,
		],
		[
			'name'   => 'lastname',
			'type'   => 'varchar',
			'length' => 45
		],
		[
			'name'   => 'age',
			'type'   => 'int',
			'length' => 2
		],
		[
			'name' => 'email',
			'type' => 'varchar'
		],
		[
			'name'   => 'gender',
			'type'   => 'varchar',
			'length' => 6
		]
	]
];