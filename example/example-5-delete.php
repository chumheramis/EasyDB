<?php
$delete = [
	'tblname' => 'user',
	'where' => [
		[
			'fieldname' => 'id',
			'operator' => '=',
			'value' => 1
		]
	]
];

if($edb->deleteData($delete)){
	print_r('delete success'. PHP_EOL);
}else{
	print_r('delete failed' . PHP_EOL);
}