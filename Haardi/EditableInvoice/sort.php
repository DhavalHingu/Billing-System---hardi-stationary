<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice</title>
<link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script>

  <style type="text/css">
.navbar {
    margin-bottom: 0;
    background-color: #f4511e;
    z-index: 9999;
    border: 0;
    font-size: 12px !important;
    line-height: 1.42857143 !important;
    letter-spacing: 4px;
    border-radius: 0;
}

.navbar li a, .navbar .navbar-brand {
    color: #fff !important;
}

.navbar-nav li a:hover, .navbar-nav li.active a {
    color: #f4511e !important;
    background-color: #fff !important;
}

.navbar-default .navbar-toggle {
    border-color: transparent;
    color: #fff !important;
}

</style>

</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="http://dhaval7030.wixsite.com/ankur-tailor">DhavalHinguBlog.com</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">Home</a></li>
        <li><a href="list.php">Invoice_List</a></li>
        <li><a href="sort.php">Filter_Invoice</a></li>
        <li><a href="../index.html">Logout</a></li>
        
      </ul>
    </div>
  </div>
</nav>
<br><br><br>
<form action="sort.php" method="post">
From: <input name="from" type="text" class="tcal"/>
To: <input name="to" type="text" class="tcal"/>
<input name="submit" type="submit" value="Search" />
</form><br />
Total Sales: Rs.  
<?php
include("../connect.php");

function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
}
if(isset($_POST['submit'])){		
$a=$_POST['from'];
$b=$_POST['to'];
$result1 = mysql_query("SELECT sum(discounted) FROM information where date BETWEEN '$a' AND '$b'");
	while($row = mysql_fetch_array($result1))
	{
		$rrr=$row['sum(discounted)'];
		echo formatMoney($rrr, true);
	}
}
?>

</body>
</html>
