<?php
define('dbhost','localhost');
define('dbuser','easydb');
define('dbpass','m4rkh3r4m15');
define('dbname','easydb');
include "../../../class-EasyDB.php";
/**
 * This is how you can connect to the database using EasyDB. To create a database connection
 * we need to instantiate the EasyDB class and provide the following parameters.
 * @params string dbhost dbhost is the host name or ip address of the database server.
 * @params string dbname dbname is the name of the database which will be used.
 * @params string dbuser the database username which would be used for authentication.
 * @params string dbpass the database password which would be used for authentication.
 */
$edb=new edb(dbhost,dbname,dbuser,dbpass);