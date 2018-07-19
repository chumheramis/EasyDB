<?php
$post_table = [
	'tblname' => 'post',
	'columns' => [
		[
			'name'          => 'id',
			'type'          => 'int',
			'autoincrement' => true,
			'notnull'       => true,
			'unique'        => true,
			'primary'       => true
		],
		[
			'name'    => 'title',
			'type'    => 'varchar',
			'length'  => 65,
			'notnull' => true
		],
		[
			'name' => 'content',
			'type' => 'text',
		],
		[
			'name' => 'date',
			'type' => 'date'
		],
		// And so on...
	]
];

/*
 I've kept this example short to keep it simple.
 If you want, feel free to play with it for the mean time.
*/