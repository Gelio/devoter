<?php
	
	if (empty($_GET['startFrom']))
		$startFrom = 0;
	else
		$startFrom = $_GET['startFrom'];
	
	if (empty($_GET['limitTo']))
		$limitTo = 3;
	else
		$limitTo = $_GET['limitTo'];

	$ip = $_SERVER['REMOTE_ADDR'];
	if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
		$ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	}
	include "config.inc.php";
	try
	{
		$pdo = new PDO('mysql:host='.$database['ip'].';dbname='.$database['db'].';port='.$database['port'], 
		$database['user'], $database['password'] );
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->query("SELECT id, name, total_votes, private, expire_date FROM polls WHERE private = 0 AND expire_date >= NOW() ORDER BY total_votes DESC
		LIMIT $startFrom, $limitTo");
		
		$wynik = array();
		while($row = $stmt -> fetch())
		{
			$number = "SELECT COUNT(*) FROM ip_voted WHERE IP = $ip, poll_id = 'id'";
			if($number !=0)
			{
				
				$wynik[$row['id']] = array(
					'id' => $row['id'], 
					'name' => $row['name'],
					'options' => array(),
					'expDate' => $row['expire_date'],
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
					'hasVoted' => false
				);
			}
			//$wynik[$row['id']]['expDate'] = new DateTime($wynik[$row['id']]['expDate'])->getTimestamp();
			
		}
		$stmt -> closeCursor();
		
		$stmt = $pdo -> query('SELECT id, name, amount, poll_id FROM options ORDER BY poll_id, id');
		
		
		while($row = $stmt -> fetch())
		{
			if (!array_key_exists($row['poll_id'], $wynik))
				continue;
			if($number != 0 || $limitTo = 3)
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
		
		$nowy_wynik;
		$i =0;
		foreach($wynik as $element)
		{
			$nowy_wynik[$i] = $element;
			$i++;
		}
		
		echo json_encode($nowy_wynik);		
	}
	catch(PDOException $e)
	{
		echo 'UPS...SOMETHING WENT WRONG :(<br />'.$e; 
	}
	?>
	