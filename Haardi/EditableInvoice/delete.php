<?php
   include "connect.php";
$ino=$_REQUEST['id1'];
     $result=mysql_query("DELETE from `information` where no LIKE '%$ino%'");

     if($result)
     {
     	header("Location: list.php");
     }
     else
     {
     	echo mysql_error();
     }
     ?>