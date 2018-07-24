<?php
$newData = [
	'tblname' => 'user',
	'columns' => [
		'userlevel',
		'username',
		'password',
		'firstname',
		'midname',
		'lastname',
		'age',
		'email',
		'gender'
	],
	'value' => [
		1,
		'theusername',
		md5('thepassword'),
		'First',
		'Mid',
		'Last',
		25,
		'email@admin.com',
		'm'
	]	
];

if($edb->insertData($newData)){
	print_r('insert success' . PHP_EOL);
}else{
	print_r('insert failed' . PHP_EOL);
}
