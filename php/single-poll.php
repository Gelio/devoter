<?php
	include "config.inc.php";
	if (empty($_GET['id']))
			$id = 1;
		else
			$id = $_GET['id'];
	try
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		
		
		
		$pdo = new PDO('mysql:host='.$database['ip'].';dbname='.$database['db'].';port='.$database['port'], 
		$database['user'], $database['password'] );
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->query("SELECT id, name, total_votes, private, expire_date FROM polls WHERE id = $id");
		$wynik = array();
		$number = "SELECT COUNT(*) FROM ip_voted WHERE IP = $ip AND poll_id = $id";
		$row = $stmt -> fetch();
		if($number !=0)
		{
			$wynik = array(
				'id' => $row['id'], 
				'name' => $row['name'],
				'options' => array(),
				'expDate' => $row['expire_date'],
				'private' => $row['private'],
				'hasVoted' => true
				);
		}
		
		if($number == 0)
		{
			$wynik = array(
				'id' => $row['id'], 
				'name' => $row['name'],
				'options' => array(),
				'expDate' => $row['expire_date'],
				'private' => $row['private'],
				'hasVoted' => false
				);
		}
		$stmt -> closeCursor();
		
		$stmt = $pdo -> query("SELECT id, name, amount, poll_id FROM options WHERE poll_id = $id ORDER BY id " );
		
		while($row = $stmt -> fetch())
		{
			if($number != 0)
			{
				$wynik['options'][] = array(
					'id' => $row['id'], 
					'name' => $row['name'],
					'amount' => $row['amount']
				);
			}
			else
			{
				$wynik['options'][] = array(
					'id' => $row['id'], 
					'name' => $row['name'],
					'amount' => 0
				);
			}
			
		}
		$stmt -> closeCursor();
		
		echo json_encode($wynik);
	}
	
	catch(PDOException $e)
	{
		echo 'UPS...SOMETHING WENT WRONG :(<br />'.$e; 
	}
	?>