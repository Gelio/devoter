<?php

	include "config.inc.php";


	$wyjscie = array();
	
	if (empty($_GET['startFrom']) || !is_numeric($_GET['startFrom']))
		$startFrom = 0;
	else
		$startFrom = $_GET['startFrom'];
	
	if (empty($_GET['limitTo']) || !is_numeric($_GET['limitTo']))
		$limitTo = 3;
	else
		$limitTo = $_GET['limitTo'];
	
	$ip = $_SERVER['REMOTE_ADDR'];
	
	try
	{
		$pdo = new PDO('mysql:host='.$database['ip'].';dbname='.$database['db'].';port='.$database['port'], 
		$database['user'], $database['password']);
	}
	catch (PDOException $e)
	{
		$wyjscie['error'] = array(
        'code' => 1,
        'message' => "Can't connect to the database"
		);
		die(json_encode($output));
	}
	
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) 
	{
		$ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	}

	$priv = 0;
	$getPolls = $pdo -> prepare("SELECT * FROM polls WHERE private = :private AND expire_date >= NOW() ORDER BY total_votes DESC
	LIMIT :startFrom, :limitTo;");
	$getPolls->bindParam(':private', $priv, PDO::PARAM_INT);
	$getPolls->bindParam(':startFrom', intval($startFrom), PDO::PARAM_INT);
	$getPolls->bindParam(':limitTo', intval($limitTo), PDO::PARAM_INT);
	$getPolls->execute();
	
	while(($poll = $getPolls -> fetch(PDO::FETCH_ASSOC)) !==false)
	{
		
		$expDate = new DateTime($poll['expire_date']);
		$wynik = array(
		'id' => $poll['id'],
		'name' => $poll['name'],
		'private' => $poll['private'],
		'expDate' => $expDate->getTimestamp(),
		'options' => array()
		);
		
		$getOptions = $pdo->prepare("SELECT * FROM options WHERE poll_id = :pollID;");
		$getOptions->bindParam(':pollID', $poll['id'], PDO::PARAM_INT);
		$getOptions->execute();
		
		while(($option = $getOptions -> fetch(PDO::FETCH_ASSOC)) !== false)
		{
			array_push($wynik['options'], $option);
		}
		
		$checkQuery = $pdo->prepare("SELECT id FROM ip_voted WHERE poll_id = :pollID AND IP = :IP LIMIT 1;");
		$checkQuery->bindParam(':pollID', $poll['id'], PDO::PARAM_INT);
		$checkQuery->bindParam(':IP', $ip, PDO::PARAM_STR);
		$checkQuery->execute();

		if($checkQuery->rowCount() == 0)
			$wynik['hasVoted'] = false;
		else
			$wynik['hasVoted'] = true;

		array_push($wyjscie, $wynik);
	}
	
	echo json_encode($wyjscie);
?>
