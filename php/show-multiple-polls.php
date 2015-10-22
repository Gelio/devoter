<?php
/**
 * @author Grzegorz Rozdzialik <voreny.gelio@gmail.com>
 */

include_once('config.inc.php');

$output = array();


// Check parameters
if(!isset($_GET['startFrom']) || !is_numeric($_GET['startFrom']))
    $_GET['startFrom'] = 0;

if(!isset($_GET['limitTo']) || !is_numeric($_GET['startFrom']))
    $_GET['limitTo'] = 3;

$startFrom = $_GET['startFrom'];
$limitTo = $_GET['limitTo'];


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

// Check the IP address
$ipAddress = $_SERVER['REMOTE_ADDR'];
if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
    $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
}


// Fetch overall info
$getQuery = $db->prepare('SELECT * FROM polls WHERE private = 0 AND expire_date >= NOW() ORDER BY total_votes DESC LIMIT '.$startFrom.', '.$limitTo.';');
$getQuery->execute();

while(($pollData = $getQuery->fetch(PDO::FETCH_ASSOC)) !== false) {
    $pollOutput = array();

    $pollOutput['id'] = $pollData['id'];
    $pollOutput['name'] = $pollData['name'];
    $pollOutput['private'] = $pollData['private'];
    $pollOutput['expDate'] = $pollData['expire_date'];
    $pollOutput['options'] = array();


    // Fetch options
    $optionsQuery = $db->prepare("SELECT * FROM options WHERE poll_id = :pollID;");
    $optionsQuery->bindParam(':pollID', $pollData['id'], PDO::PARAM_INT);
    $optionsQuery->execute();

    while(($option = $optionsQuery->fetch(PDO::FETCH_ASSOC)) !== false) {
        array_push($pollOutput['options'], $option);
    }


    // Check if the user has already voted
    $checkQuery = $db->prepare("SELECT id FROM ip_voted WHERE poll_id = :pollID AND IP = :IP LIMIT 1;");
    $checkQuery->bindParam(':pollID', $pollData['id'], PDO::PARAM_INT);
    $checkQuery->bindParam(':IP', $ipAddress, PDO::PARAM_STR);
    $checkQuery->execute();

    if($checkQuery->rowCount() == 0)
        $pollOutput['hasVoted'] = false;
    else
        $pollOutput['hasVoted'] = true;

    array_push($output, $pollOutput);
}

/*echo "<pre>";
var_dump($output);
echo "</pre>";*/


// Output information
echo json_encode($output);

?>