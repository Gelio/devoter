
<?php
	include 'config.inc.php';

$output= array();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);

	$ip = $_SERVER['REMOTE_ADDR'];
if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
    $ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
}

if (filter_var($ip, FILTER_VALIDATE_IP))
{
	try
   {
		$pdo = new PDO("mysql:host=".$database['ip'].";
		dbname=".$database['db'].";port=".$database['port'].";
		encoding=utf8",$database['user'],$database['password'] ,
		array(PDO::ATTR_EMULATE_PREPARES => false,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);
		
		$option =$_POST['optionID'];
		$poll=$_POST['id'];
	
		$stmt = $pdo->prepare('SELECT * FROM ip_voted WHERE poll_id=:poll AND IP=:ip');
			$stmt -> bindValue(':poll', $poll, PDO::PARAM_INT);
			$stmt -> bindValue(':ip', $ip , PDO::PARAM_STR);
			$stmt -> execute();
		$ilosc=$stmt->rowCount();
		
		if(!$ilosc)
		{
			//ADDING IP TO VOTED LIST
			$stmt= $pdo -> prepare("INSERT INTO `ip_voted` (  `poll_id`, `IP`) VALUES(:poll,:ip)");
			$stmt -> bindValue(':poll', $poll, PDO::PARAM_INT);
			$stmt -> bindValue(':ip', $ip , PDO::PARAM_STR);
			$stmt -> execute();
			//UPDATING POLL SCORE
			$stmt= $pdo -> prepare("UPDATE polls SET total_votes=total_votes+1 WHERE id=:id");
			$stmt -> bindValue(':id', $poll, PDO::PARAM_INT);
			$stmt -> execute();
			//UPDATING OPTION SCORE
			$stmt =$pdo -> prepare("UPDATE options SET amount=amount+1 WHERE id=:opt");
			$stmt -> bindValue(':opt', $option, PDO::PARAM_INT);
			$stmt -> execute();
			
			$succesful=true;
			echo json_encode($succesful);
			
		}
		else 
		{
			$output['error']= array
		(
			'code' => 8,
			'message' => "You already DeVoted for some option!"
		);
		echo json_encode($output['error']);
		}
   }
	
	catch(PDOException $e)
   {
	    $output['error']= array
		(
			'code' => 1,
			'message' => 'Connection could not be created: ' . $e->getMessage()
		);
		echo json_encode($output['error']);
   }

}
else
{
	$output['error']= array
		(
			'code' => 1,
			'message' => "Your IP couldn't be validated!"
		);
	echo json_encode($output['error']);
	
}
?>