<?php
// TODO: set the limit to be passed in by $_GET parameter (limitTo) as suggested in the API-info
	$ip = $_SERVER['REMOTE_ADDR'];
	include "config.inc.php";
	try
	{
		$pdo = new PDO('mysql:host='.$database['ip'].';dbname='.$database['db'].';port='.$database['port'], 
		$database['user'], $database['password'] );
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->query("SELECT id, name, total_votes, private, expire_date FROM polls ORDER BY total_votes DESC 
		LIMIT 3");
		
		$wynik = array();
		while($row = $stmt -> fetch())
		{
			$wynik[$row['id']] = array(
			'id' => $row['id'], 
			'name' => $row['name'],
			'options' => array(),
			'expDate' => $row['expire_date'],
			'private' => $row['private']
			);
		}
			
		$stmt -> closeCursor();
		
		$stmt = $pdo -> query('SELECT id, name, amount, poll_id FROM options ORDER BY poll_id, id');
		
		while($row = $stmt -> fetch())
		{
			if (!array_key_exists($row['poll_id'], $wynik))
				continue;
			$wynik[$row['poll_id']]['options'][] = array(
				'id' => $row['id'], 
				'name' => $row['name'],
				'amount' => $row['amount']
			);
			
		}
		$stmt -> closeCursor();
		
		echo json_encode($wynik);
		
	}
	catch(PDOException $e)
	{
		echo 'UPS...SOMETHING WENT WRONG :(<br />'.$e; 
	}
	?>
	
	