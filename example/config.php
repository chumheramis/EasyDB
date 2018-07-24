<?php
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','easydb');
include ("../class-EasyDB.php");
/**
 * This is how you can connect to the database using EasyDB. To create a database connection
 * we need to instantiate the EasyDB class and provide the following parameters.
 * @params string DBHOST DBHOST is the host name or ip address of the database server.
 * @params string DBNAME DBNAME is the name of the database which will be used.
 * @params string DBUSER the database username which would be used for authentication.
 * @params string DBPASS the database password which would be used for authentication.
 */
$edb=new edb(DBHOST,DBNAME,DBUSER,DBPASS);