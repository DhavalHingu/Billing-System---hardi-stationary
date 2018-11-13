<?php
include("connect.php");
 if(isset($_POST['submit']))
 {
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
  //$sqlquery="INSERT INTO `products`(`product`) VALUES ('{$arr_str}')";


 $sqlquery = "INSERT INTO `information`(`name`,`date`,`product`,`inf`,`total`,`discounted`,`cost`,`qty`) 
            VALUES ('$a','$b','$arr_str','$arr_str1','$c','$d','$arr_str2','$arr_str3')";

       $result=mysql_query($sqlquery);
 if($result)

  
  
  {
    
            
    header("Location: list.php");
  }
       
  else
  {
       echo "<script type='text/javascript'>alert('Invoice Not Saved!')</script>";
  }
}

 ?>