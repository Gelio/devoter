<?php
	include 'config.inc.php';
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);
	$name = $_POST['name'];
	$option_number = $_POST['options'];
	$private = $_POST['private'];
	$expire_date=$_POST['expDate'];

	
try
{
     $pdo = new PDO("mysql:host=".$database['ip'].";
	  dbname=".$database['db']." ;port=".$database['port'].";
	  charset=utf8,".$database['user'].",".$database['password'] ,
	  array(PDO::ATTR_EMULATE_PREPARES => false,
	  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  

	$stmt=$pdo->query('SELECT id FROM polls;') ;
	$id= $stmt->rowCount()+1;

	$stmt = $pdo -> prepare('INSERT INTO `polls` (`id`,  `name`, `total_votes`,`private`,`expire_date`)	VALUES(
			:id,
			:name,
			:total_votes,
			:private,
			:expire_date)');
		$stmt -> bindValue(':id', $id, PDO::PARAM_INT); 
		$stmt -> bindValue(':name', $name, PDO::PARAM_STR);
		$stmt -> bindValue(':total_votes',0 , PDO::PARAM_INT);
		$stmt -> bindValue(':private', $private, PDO::PARAM_INT);
		$stmt -> bindValue(':expDate', $expire_date, PDO::PARAM_LOB);
		$stmt -> execute();

	$stmt=$pdo->query('SELECT id FROM options');
	$oid= $stmt->rowCount()+1;

	$i=0;
	foreach($option_number as $current=>$opname)
	{
		$stmt = $pdo -> prepare('INSERT INTO `options` (`id`,  `poll_id`, `name`,`amount`)	VALUES(
				:id,
				:poll_id,
				:name,
				:amount)');
			$stmt -> bindValue(':id', $oid, PDO::PARAM_INT); 
			$stmt -> bindValue(':poll_id', $id, PDO::PARAM_INT);
			$stmt -> bindValue(':name',$option_number[$i] , PDO::PARAM_STR);
			$stmt -> bindValue(':amount', 0, PDO::PARAM_INT);
			$stmt -> execute();
		$i++;
		$oid++;
	
	}

	echo json_encode($id);
}
    
catch(PDOException $e)
{
      echo 'Connection could not be created: ' . $e->getMessage();
	  echo json_encode($e);
}

?>
