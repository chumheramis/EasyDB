<?php include_once('config.php'); ?>
<p class="msgHeader">Connect to database</p>

<?php
/**
 * This is how you can connect to the database using EasyDB. To create a database connection
 * we need to instantiate the EasyDB class and provide the following parameters.
 * @params string dbhost dbhost is the host name or ip address of the database server.
 * @params string dbname dbname is the name of the database which will be used.
 * @params string dbuser the database username which would be used for authentication.
 * @params string dbpass the database password which would be used for authentication.
 */
$edb=new edb(dbhost,dbname,dbuser,dbpass);
echo "<p class='message'>Establishing database connection: ";
if($edb->isConnected()){
    echo "<span class='success'>Success</span>";
}else{
    echo "<span class='error'>Failed</span>";
}
echo "</p>";