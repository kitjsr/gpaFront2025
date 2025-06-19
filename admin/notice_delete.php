<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$id=$_GET['id'];
deleteNotice($id);
header('Location:notices.php');
?>