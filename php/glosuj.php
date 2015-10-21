
<?php
	include 'config.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);

	$ip = getenv('HTTP_CLIENT_IP')?:
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
	  dbname=".$database['db']." ;port=".$database['port'].";
	  charset=utf8,".$database['user'].",".$database['password'] ,
	  array(PDO::ATTR_EMULATE_PREPARES => false,
	  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  		
		$option =$_POST['optionID'];
		$poll=$_POST['id'];
		$stmt= $pdo -> query("SELECT * FROM ip_voted WHERE poll_id=$poll AND IP=$ip");
		$ilosc=$stmt->rowCount();
		
		$stmt= $pdo -> query("SELECT * FROM ip_voted");
		$idv=$stmt->rowCount()+1;
		
		if(!$ilosc)
		{
			$stmt= $pdo -> exec("insert into ip_voted values($idv,$poll,$ip)");
			$stmt= $pdo -> exec("update polls set total_votes=total_votes+1 where id=$poll");
			$stmt =$pdo -> exec("update options set answers=answers+1 where id=$option;");
			$idv++;
		}
		else 
		{
			echo "You already DeVoted for some option!";
		}
	}
	catch(PDOException $e)
   {
      echo 'Connection could not be created: ' . $e->getMessage();
	  echo json_encode($e);
   }

}
else
{
	$erro="Your IP couldn't be validated!";
	
	echo  $erro;
	echo json_encode($erro);
	
}
?>