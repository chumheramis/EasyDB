<p class="msgHeader">Connect to database</p>
<?php
$edb=new edb('localhost', 'test', 'root', '');
echo "<p class='message'>Establishing database connection: ";
if($edb->isConnected()){
    echo "<span class='success'>Success</span>";
}else{
    echo "<span class='error'>Failed</span>";
}
echo "</p>";
