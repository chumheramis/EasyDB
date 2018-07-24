<?php
$updateData = [
	'tblname' => 'user',
	'set' => [
		'firstname' => 'NewFirstname',
		'lastname' => 'NewLastName'
	],
	'where' => [
		[
			'fieldname' => 'id',
			'operator' => '=',
			'value' => 1
		]
	]
];

if($edb->update($updateData)){
	print_r('update success' . PHP_EOL);
}else{
	print_r('update failed' . PHP_EOL);
}