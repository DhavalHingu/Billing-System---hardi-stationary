<?php
include("connect.php");

 $result=mysql_query("select * from `information`");
 ?>
 <html>
<head>
	<title>Invoice</title>
	<link rel="stylesheet" href="bootstrap.min.css">
     <!--<link rel="stylesheet" href="style.css">!-->
     
	<style type="text/css">
		body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 0;
			margin: 0;
		}
		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
		}

		h1 {
			margin: 25px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 14px;
			min-width: 537px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: right;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
	</style>
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
<br><br>


	<h1>Invoices</h1>
	<table class="data-table">
		<caption class="title">Sales Data of Stationary Division</caption>
		<thead>
			<tr>
				<th>NO</th>
				<th>CUSTOMER</th>
				<th>DATE</th>
				<th>AMOUNT</th>
				<th>DISCOUNTED</th>
			</tr>
		</thead>
		<tbody>
		<?php
$total 	= 0;
		   while ($row = mysql_fetch_array($result))
		{
			
			 echo "<tr>";
		  
echo "<td><a href='view.php?id=" . $row['no'] . "'>".$row['no']."</a>
<a href='delete.php?id1=" .$row['no'] ."'>Delete</a></td>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['date']."</td>";
			echo "<td>".$row['total']."</td>";
			echo "<td>".$row['Discounted']."</td>";
			
			echo "</tr>";
			$total += $row['Discounted'];
			
		}?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="6">TOTAL</th>
				<th><?=$total?></th>
			</tr>
		</tfoot>
	</table>
</body>
</html>