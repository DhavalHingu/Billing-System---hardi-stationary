<?php
 include("connect.php");

    if (isset($_POST['submit'])){
      
       $username = $_POST['username'];
       $password = $_POST['password'];
         
    $sqlquery = mysql_query("SELECT * FROM `login` WHERE name='$username' && password='$password'");
    $row=mysql_fetch_array($sqlquery);
    $count = mysql_num_rows($sqlquery);
  if($count==1)
  {
    
    
       header("Location: invoice\m.html");
  }
  else
  {
    header("Location: index.html");
  }
}
    






?>