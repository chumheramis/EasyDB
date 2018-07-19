<?php
include_once('config.php');
/**
 * Here we go. Just include a php file in form of arrays
 * in which to create into table. Thus, check the files
 * and tell me what you think. olrayt
 */
include_once('user_table.php');
include_once('post_table.php');
/**
 * @class    edb
 * @function hasTable
 *
 * @params   string tblname the table name to check in the database.
 * Check if a given table exists in the database. returns true if the table
 * exists and return false otherwise.
 *
 * @return boolean
 */
if (!$edb->hasTable($user_table['tblname'])) {
	/**
	 * @class    edb
	 * @function createTable
	 *
	 * @params   array option the array in which to form into table.
	 * create a table from a fromatted array object. see the format below:
	 * <pre>
	 * array(
	 *    'tblname'=>'thetablename',
	 *    'columns'=>array(
	 *      array(
	 *        'name'=>'columnname',
	 *        'type'=>'varchar',
	 *        'length'=>45,
	 *        // and so on...
	 *      )
	 *    )
	 * )
	 * </pre>
	 * check the example files:
	 * user_table.php, post_table.php
	 * for more information.
	 */
	$op_res = $edb->createTable($user_table);
	if ($op_res) {
		// table create success
		echo "<p>" . $user_table['tblname'] . " created succesfully</p>";
	}
	else {
		// table was not created succesfully due to some errors.
		echo "<p>" . $user_table['tblname'] . " was not created</p>";
	}
}
else {
	echo "<p>" . $user_table['tblname'] . " is already created</p>";
}

if (!$edb->hasTable($post_table['tblname'])) {
	$op_res = $edb->createTable($post_table);
	if ($op_res) {
		// table created succesfully
		echo "<p>" . $post_table['tblname'] . " created succesfully</p>";
	}
	else {
		echo "Error occured. Call Mark Heramis @ markheramis@github.com";
		// table was not created succesfully due to some errors.
	}
}
else {
	echo "<p>" . $post_table['tblname'] . " is already created<p>";
}
