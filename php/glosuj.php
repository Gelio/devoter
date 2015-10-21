
<?php
	include 'config.inc.php';

	$ip =getenv('HTTP_CLIENT_IP')?:
	getenv('HTTP_X_FORWARDED_FOR')?:
	getenv('HTTP_X_FORWARDED')?:
	getenv('HTTP_FORWARDED_FOR')?:
	getenv('HTTP_FORWARDED')?:
	getenv('REMOTE_ADDR');

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
			
			
			$erro= array
			(
				'error' => 0,
				'message' => ""
			);
			echo json_encode($erro);
		}
		else 
		{
			$erro= array
		(
			'error' => 8,
			'message' => "You already DeVoted for some option!"
		);
		echo json_encode($erro);
		}
   }
	
	catch(PDOException $e)
   {
	    $erro= array
		(
			'error' => 1,
			'message' => 'Connection could not be created: ' . $e->getMessage()
		);
		echo json_encode($erro);
   }

}
else
{
	$erro= array
		(
			'error' => 0,
			'message' => "Your IP couldn't be validated!"
		);
	echo json_encode($erro);
	
}
?>