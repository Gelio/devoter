<?php
/**
 * @author Grzegorz Rozdzialik <voreny.gelio@gmail.com>
 */

include_once('config.inc.php');

$output = array();


// Check ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $output['error'] = array(
        'code' => 11,
        'message' => "Wrong poll ID"
    );
    die(json_encode($output));
}
$id = $_GET['id'];


// Connect to the DB
try {
    $db = new PDO("mysql:dbname=".$database['db'].";host=".$database['ip'].";port=".$database['port'],
        $database['user'], $database['password']);
}
catch (PDOException $e) {
    $output['error'] = array(
        'code' => 1,
        'message' => "Can't connect to the database"
    );
    die(json_encode($output));
}


// Fetch overall info
$getQuery = $db->prepare('SELECT * FROM polls WHERE id = :pollID AND expire_date >= NOW() LIMIT 1;');
$getQuery->bindParam(':pollID', $id, PDO::PARAM_INT);;
$getQuery->execute();

if($getQuery->rowCount() == 0) {
    $output['error'] = array(
        'code' => 10,
        'message' => "Poll does not exist"
    );
    die(json_encode($output));
}
$pollData = $getQuery->fetch(PDO::FETCH_ASSOC);

$output['id'] = $pollData['id'];
$output['name'] = $pollData['name'];
$output['private'] = $pollData['private'];
$output['expDate'] = $pollData['expire_date'];
$output['options'] = array();


// Fetch options
$optionsQuery = $db->prepare("SELECT * FROM options WHERE poll_id = :pollID;");
$optionsQuery->bindParam(':pollID', $id, PDO::PARAM_INT);
$optionsQuery->execute();

while(($option = $optionsQuery->fetch(PDO::FETCH_ASSOC)) !== false) {
    array_push($output['options'], $option);
}


// Check if the user has already voted
$ipAddress = $_SERVER['REMOTE_ADDR'];
if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
    $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
}

$checkQuery = $db->prepare("SELECT id FROM ip_voted WHERE poll_id = :pollID AND IP = :IP LIMIT 1;");
$checkQuery->bindParam(':pollID', $id, PDO::PARAM_INT);
$checkQuery->bindParam(':IP', $ipAddress, PDO::PARAM_STR);
$checkQuery->execute();

if($checkQuery->rowCount() == 0)
    $output['hasVoted'] = false;
else
    $output['hasVoted'] = true;


// Output information
echo json_encode($output);

?>