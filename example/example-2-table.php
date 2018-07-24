<?php
// Here we just include a php file which forms arrays
// in which to create into table. please check the files
// and tell me what you think.
$post_table = array(
  'tblname'=>'post',
  'columns'=>array(
    array(
      'name'=>'id',
      'type'=>'int',
      'autoincrement'=>true,
      'notnull'=>true,
      'unique'=>true,
      'primary'=>true
    ),
    array(
      'name'=>'title',
      'type'=>'varchar',
      'length'=>65,
      'notnull'=>true
    ),
    array(
      'name'=>'content',
      'type'=>'text',
    ),
    array(
      'name'=>'date',
      'type'=>'date'
    ),
    // And so on...
  )
);

/*
 I've kept this example short to keep it simple.
 If you want, feel free to play with it for the mean time.
*/


$user_table = array(
    'tblname'=>'user',
    'columns'=>array(
        array(
            'name'=>'id',
            'type'=>'int',
            'primary'=>true,
            'unique'=>true,
            'autoincrement'=>true,
            'notnull'=>true
        ),
        array(
            'name'=>'userlevel',
            'type'=>'int',
            'length'=>1,
            'default'=>'2'
        ),
        array(
            'name'=>'username',
            'type'=>'varchar',
            'length'=>45,
            'unique'=>true,
            'notnull'=>true
        ),
        array(
            'name'=>'password',
            'type'=>'varchar',
            'length'=>20,
            'notnull'=>true
        ),
        array(
            'name'=>'firstname',
            'type'=>'varchar',
            'length'=>45
        ),
        array(
            'name'=>'midname',
            'type'=>'varchar',
            'length'=>1,
        ),
        array(
            'name'=>'lastname',
            'type'=>'varchar',
            'length'=>45
        ),
        array(
            'name'=>'age',
            'type'=>'int',
            'length'=>2
        ),
        array(
            'name'=>'email',
            'type'=>'varchar'
        ),
        array(
            'name'=>'gender',
            'type'=>'varchar',
            'length'=>6
        )
    )
);
/**
 * @class edb
 * @function hasTable
 * @params string tblname the table name to check in the database.
 * Check if a given table exists in the database. returns true if the table
 * exists and return false otherwise.
 * @return boolean
 */
if(!$edb->hasTable($user_table['tblname'])){
  /**
   * @class edb
   * @function createTable
   * @params array option the array in which to form into table.
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
  if($op_res){
    // table create success
    print_r($user_table['tblname'].' created succesfully'.PHP_EOL);
  }else{
    // table was not created succesfully due to some errors.

    print_r($user_table['tblname'].' was not created'.PHP_EOL);
  }
}else{
  print_r($user_table['tblname'].' is already created'.PHP_EOL);
}

if(!$edb->hasTable($post_table['tblname'])){
  $op_res = $edb->createTable($post_table);
  if($op_res){
    // table created succesfully
    print_r($post_table['tblname'].' created succesfully' . PHP_EOL);
  }else{
    // table was not created succesfully due to some errors.
  }
}else{
  print_r($post_table['tblname'].' is already created' . PHP_EOL);
}


