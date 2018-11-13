<?php
   include "connect.php";

if(isset($_POST['submit'])){

//$x = mysql_escape_string($_POST['ii']);



  $x=$_POST['ii']; 
  $a=$_POST['name'];
 	$b=$_POST['date'];
 	$e=$_POST['product'];
 	$f=$_POST['inf'];
 	$c=$_POST['m'];
 	$d=$_POST['discounted'];
  $p=$_POST['costt'];
  $q=$_POST['qtyy'];
 	
 	
      $arr_str  = implode(",",$e);
      $arr_str1  = implode(",",$f);
      $arr_str2  = implode(",",$p);
      $arr_str3  = implode(",",$q);

     $result=mysql_query("UPDATE `information` SET `name`='$a',`date`='$b',`product`='$arr_str',`inf`='$arr_str1',`total`='$c',`discounted`='$d',`cost`='$arr_str2',`qty`='$arr_str3'  where `no` LIKE '%$x%'");
     if($result)
     {
     	header("Location: list.php");
     }
     else
     {
     	echo "not";
     }
   } 
 ?>