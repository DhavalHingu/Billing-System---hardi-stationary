<?php
 include('connect.php');


      
       $username = $_POST['username'];
       $password = $_POST['password'];
         
    $sqlquery = mysql_query("SELECT * FROM `login` WHERE name='$username' && password='$password'");
    $row=mysql_fetch_array($sqlquery);
    $count = mysql_num_rows($sqlquery);
  if($count==1)
  {
    
    
       header("Location: EditableInvoice\index.php");
       
  }
  else
  {
    header("Location: index.html");
  }

    






?>