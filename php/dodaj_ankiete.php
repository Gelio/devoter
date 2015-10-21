<?php
	include 'config.inc.php';
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);
	
	$name = $_POST['name'];
	$option_number = $_POST['options'];
	
	$private = $_POST['private'];
	$expire_date=$_POST['expDate'];
	$convdate=date("Y-m-d h:i:s" ,$expire_date);
	//data validation
	$opcount=0;
	$pusty=false;
foreach($option_number as $current=>$opname) 
{
	if(empty($option_number[$opcount]["name"]))
	{
		$pusty=true;
		break;
	}
	$opcount++;
}
if(strlen($name)>4 && strlen($name)<101 && !$pusty && $opcount>1 &&$opcount<11&& $expire_date>time())
{
	try
	{
		$pdo = new PDO("mysql:host=".$database['ip'].";
		dbname=".$database['db'].";port=".$database['port'].";
		encoding=utf8",$database['user'],$database['password'] ,
		array(PDO::ATTR_EMULATE_PREPARES => false,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	 
		//dodanie ankiety
		$stmt=$pdo->query('SELECT id FROM polls;') ;
		$id= $stmt->rowCount()+1;
	
		$stmt = $pdo->prepare('INSERT INTO `polls` (  `name`, `total_votes`,`private`,`expire_date`)	VALUES(
			:name,
			:total_votes,
			:private,
			:expire_date)');
				 
			
	
			$stmt -> bindValue(':name', $name, PDO::PARAM_STR);
			$stmt -> bindValue(':total_votes',0 , PDO::PARAM_INT);
			$stmt -> bindValue(':private', $private, PDO::PARAM_INT);
			$stmt -> bindValue(':expire_date', $convdate, PDO::PARAM_STR);
			$stmt -> execute();

		//dodanie opcji
		$i=0;
		foreach($option_number as $current=>$opname)
		{
			$stmt = $pdo -> prepare('INSERT INTO `options` (  `poll_id`, `name`,`amount`)	VALUES(
				:poll_id,
				:name,
				:amount)');
				$stmt -> bindValue(':poll_id', $id, PDO::PARAM_INT);
				$stmt -> bindValue(':name', $option_number[$i]["name"] , PDO::PARAM_STR);
				$stmt -> bindValue(':amount', 0, PDO::PARAM_INT);
				$stmt -> execute();
			$i++;
	
		}

		json_encode($id);
	}
    
	catch(PDOException $e)
	{
		$erro ='Connection could not be created: ' . $e->getMessage();
		json_encode($e);
		json_encode($erro);
	}
}
elseif(strlen($name)<5) json_encode($erro='Poll title too short (less than five chars) !');
elseif(strlen($name)>100) json_encode($erro='Poll title too long (more than a hundred chars)!');
elseif($pusty) json_encode($erro='One of options is empty!');
elseif($opcount<2) json_encode($erro='Not enough (less than two) options!');
elseif($opcount>10) json_encode($erro='Too many (more than ten) options!');
elseif($expire_date<=time()) json_encode($erro='Set expire date in the future!');
?>
