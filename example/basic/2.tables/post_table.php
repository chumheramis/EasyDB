<?php
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