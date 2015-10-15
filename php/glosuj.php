Vote
<?php
$ip = $_POST['IP'];
//po³¹cz z baz¹
$opcja =$_POST['option'];
$ankieta=$_POST['poll'];
if(!select count * from ip_voted where poll_id=$ankieta and IP=$ip)
update polls set total_votes=total_votes+1 where id=$ankieta;
update options set answers=answers+1 where id=$opcja;
insert into ip_voted values($idv,$ankieta,$ip);
$idv++
?>