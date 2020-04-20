<?php

require_once('bdd.php');
//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['location'])){

	$title = $_POST['title'];
	$location = $_POST['location'];
	$start = $_POST['start'];
	$end = $_POST['end'];


	$sql = "INSERT INTO events(title,location, start, end) values ('$title','$location', '$start', '$end')";
	//$req = $bdd->prepare($sql);
	//$req->execute();

	echo $sql;

	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Error prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Error execute');
	}

}
header('Location: '.$_SERVER['HTTP_REFERER']);


?>
