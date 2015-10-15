<?php
$nazwa = $_POST['name'];
$opcje = $_POST['options'];
for($i=0;$i<=$opcje;$i++)
{
$op_nazw[i]=$_POST["opname_$i"];
}
//kod sanituj¹cy - php pod
//po³¹cz z baz¹
insert into polls values($id,$nazwa,0,$date);
$id++;
for($i=0;$i<=$opcje;$i++)
{
insert into options values($id,$oid,$op_nazw[i],0);
$oid++;
}
?>
