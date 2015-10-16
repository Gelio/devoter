<?php
$nazwa = $_POST['name'];
$opcje = $_POST['options'];
$prywatne = $_POST['private'];
$czas_trwania=$_POST['expDate'];
try
   {
      $pdo = new PDO('mysql:host=localhost;dbname=devot;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  

$stmt=$pdo->query('SELECT id FROM polls') ;
$id= $stmt->rowCount()+1;
$stmt = $pdo -> prepare('INSERT INTO `polls` (`id`,  `name`, `total_votes`,`private`,`expire_date`)	VALUES(
				:id,
				:name,
				:total_votes,
				:private,
				:expire_date)');
				$stmt -> bindValue(':id', $id, PDO::PARAM_INT); 
			$stmt -> bindValue(':name', $nazwa, PDO::PARAM_STR);
			$stmt -> bindValue(':total_votes',0 , PDO::PARAM_INT);
			$stmt -> bindValue(':private', $prywatne, PDO::PARAM_INT);
			$stmt -> bindValue(':expDate', $czas_trwania, PDO::PARAM_LOB);
			$stmt -> execute();

$stmt=$pdo->query('SELECT id FROM options');
$oid= $stmt->rowCount()+1;
foreach($opcje as $obecna)
{
	$stmt = $pdo -> prepare('INSERT INTO `options` (`id`,  `poll_id`, `name`,`amount`)	VALUES(
				:id,
				:poll_id,
				:name,
				:amount)');
				$stmt -> bindValue(':id', $oid, PDO::PARAM_INT); 
			$stmt -> bindValue(':poll_id', $id, PDO::PARAM_INT);
			$stmt -> bindValue(':name',$obecna , PDO::PARAM_STR);
			$stmt -> bindValue(':amount', 0, PDO::PARAM_INT);
	
			$stmt -> execute();
	
	$oid++;
	
}
echo "Ankieta została utworzona. </br> ID ankiety wynosi $id";
   }
    
   catch(PDOException $e)
   {
      echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
   }

?>
