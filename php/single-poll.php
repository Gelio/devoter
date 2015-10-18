<?php
	include "config.inc.php";
	try
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$id = $_GET['id'];
		
		$pdo = new PDO('mysql:host='.$database['ip'].';dbname='.$database['db'].';port='.$database['port'], 
		$database['user'], $database['password'] );
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->query("SELECT id, name, total_votes, private, expire_date FROM polls WHERE id = $id");
		$wynik = array();
		$number = "SELECT COUNT(*) FROM ip_voted WHERE IP = $ip, poll_id = $id";
		while($row = $stmt -> fetch())
		{
			if($number !=0)
			{
				$wynik[$row['id']] = array(
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
				$wynik[$row['id']] = array(
			'id' => $row['id'], 
			'name' => $row['name'],
			'options' => array(),
			'expDate' => $row['expire_date'],
			'private' => $row['private'],
			'hasVoted' => false
			);
			}
			
		}
		$stmt -> closeCursor();
		
		$stmt = $pdo -> query("SELECT id, name, amount, poll_id FROM options ORDER BY id" );
		
		while($row = $stmt -> fetch())
		{
			if (!array_key_exists($row['poll_id'], $wynik))
				continue;
			if($number != 0)
			{
				$wynik[$row['poll_id']]['options'][] = array(
					'id' => $row['id'], 
					'name' => $row['name'],
					'amount' => $row['amount']
				);
			}
			else
			{
				$wynik[$row['poll_id']]['options'][] = array(
					'id' => $row['id'], 
					'name' => $row['name'],
					'amount' => 0
				);
			}
			
		}
		$stmt -> closeCursor();
		
		echo json_encode($wynik);
		echo '</br></br>';
		
		$wynik = json_encode($wynik);
		var_dump(json_decode($wynik));
		
	}
	
	catch(PDOException $e)
	{
		echo 'UPS...SOMETHING WENT WRONG :(<br />'.$e; 
	}
	?>