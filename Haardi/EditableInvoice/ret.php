<?php
include("connect.php");

$result=mysql_query("select * from information where no=11");
while ($row = mysql_fetch_array($result))
		{
			
			
			

$numbers = $row['product'];

$i=explode(",",$numbers);


echo $i[0];
echo $i[1];
}
?>