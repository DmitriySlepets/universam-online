<?php
	$server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
	mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
	mysqli_set_charset($server_bd,"utf8");
?>
<?php if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html'){ ?>
<?php }else{ ?>
<?php
	//////////////////////////////////////////////////////////////////////	
	$query_new = "SELECT * FROM kk_newhits WHERE priznak=1 LIMIT 0, 2";
	$res_new = mysqli_query($server_bd, $query_new) or die(mysqli_error($server_bd)); 
	$list_new = array();
	while($row_new = mysqli_fetch_assoc($res_new)){$list_new[] = $row_new;}
	//////////////////////////////////////////////////////////////////////
	$query_hits = "SELECT * FROM kk_newhits WHERE priznak=2 LIMIT 0, 2";
	$res_hits = mysqli_query($server_bd, $query_hits ) or die(mysqli_error($server_bd)); 
	$list_hits = array();
	while($row_hits = mysqli_fetch_assoc($res_hits)){$list_hits [] = $row_hits;}	
	//////////////////////////////////////////////////////////////////////	
?>
<?php }//if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/index.html') ?>
<?php
	mysqli_close($server_bd);
?>