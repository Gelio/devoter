<?php
	include "config.inc.php";
	
	$wyjscie = array();
	
	if (empty($_GET['id']) || !is_numeric($_GET['id']))
	{
		$wyjscie['error'] = array (
			'code' => 11,
			'message' => "Wrong poll ID"
		);
		die(json_encode($wyjscie));	
	}
	else
		$id = $_GET['id'];
	
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) 
	{
		$ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	}
	
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
		die(json_encode($wyjscie));
	}
	
	$getPoll = $pdo -> prepare("SELECT * FROM polls WHERE id = :pollID AND expire_date >= NOW() LIMIT 1;");
	$getPoll->bindParam(':pollID', $id, PDO::PARAM_INT);
	$getPoll->execute();
	if($getPoll->rowCount() == 0) 
	{
		$output['error'] = array(
			'code' => 10,
			'message' => "Poll does not exist"
		);
		die(json_encode($wyjscie));
	}
	
	$poll = $getPoll -> fetch(PDO::FETCH_ASSOC);
		
		$expDate = new DateTime($poll['expire_date']);
		
		$wynik = array(
		'id' => $poll['id'],
		'name' => $poll['name'],
		'private' => $poll['private'],
		'expDate' => $expDate->getTimestamp(),
		'options' => array()
		);
		
		$getOptions = $pdo->prepare("SELECT * FROM options WHERE poll_id = :pollID;");
		$getOptions->bindParam(':pollID', $id, PDO::PARAM_INT);
		$getOptions->execute();
		
		while(($option = $getOptions -> fetch(PDO::FETCH_ASSOC)) !== false)
		{
			array_push($wynik['options'], $option);
		}
		
		$checkIp = $pdo->prepare("SELECT id FROM ip_voted WHERE poll_id = :pollID AND IP = :IP LIMIT 1;");
		$checkIp->bindParam(':pollID', $id, PDO::PARAM_INT);
		$checkIp->bindParam(':IP', $ipAddress, PDO::PARAM_STR);
		$checkIp->execute();

		if($checkIp->rowCount() == 0)
			$wynik['hasVoted'] = false;
		else
			$wynik['hasVoted'] = true;

		//array_push($wyjscie, $wynik);
	
	
	echo json_encode($wynik);
?>
