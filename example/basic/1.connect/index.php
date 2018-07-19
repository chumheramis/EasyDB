<?php include_once('config.php'); ?>
	<p class="msgHeader">Connect to database</p>

<?php

echo "<p class='message'>Establishing database connection: ";
if ($edb->isConnected()) {
	echo "<span class='success'>Success</span>";
}
else {
	echo "<span class='error'>Failed</span>";
}
echo "</p>";