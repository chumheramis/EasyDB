<?php
$sql="INSERT INTO `test`.`user` (`id`,`userlevel`,`username`,`password`,`firstname`,`midname`,`lastname`,`age`,`email`, `gender`) VALUES ('1', '2', 'user1', '1234', 'firstname1', 'a', 'lastname1', '2', 'email2', '1'), ('2', '2', 'user2', '1234', 'firstname2', 'a', 'lastname2', '6', 'email2', '1');";
$edb=new edb('localhost', 'test', 'root', '');
$args=array(
    'tblname'=>'user',
    'columns'=>array(
        'username',
        'password',
        'firstname',
        'lastname',
        'midname',
        'age',
        'email',
        'gender'
    ),
    'value'=>array()
);
for($i=0;$i<10;$i++){
    $args['value'][]=array(
        'test'.$i,
        '123',
        'test'.$i.'firstname',
        'test'.$i.'lastname',
        chr(rand(64,128)),
        rand(18,50),
        'test'.$i.'@email.com',
        rand(0,1)
    );
}
$edb->insertData($args);