
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Editable Invoice</title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
  <!--<link rel="stylesheet" href="style.css">!-->
  <link rel="stylesheet" href="bootstrap.min.css">
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<!--<script type='text/javascript' src='js/example.js'></script>-->
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
<script type="text/javascript">
	function print_today() {
  // ***********************************************
  // AUTHOR: Dhaval Hingu
  // URL: http://www.dhavalhingublog.com
  //  // ***********************************************
  var now = new Date();
  var months = new Array('01','02','03','04','05','06','07','08','09','10','11','12');
  var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
  function fourdigits(number) {
    return (number < 1000) ? number + 1900 : number;
  }
  var today =  months[now.getMonth()] + " " + date + ", " + (fourdigits(now.getYear()));
  var today = (fourdigits(now.getYear())) + "-"+ months[now.getMonth()] + "-" + date;
  return today;
}

// from http://www.mediacollege.com/internet/javascript/number/round.html
function roundNumber(number,decimals) {
  var newString;// The new rounded number
  decimals = Number(decimals);
  if (decimals < 1) {
    newString = (Math.round(number)).toString();
  } else {
    var numString = number.toString();
    if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
      numString += ".";// give it one at the end
    }
    var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
    var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
    var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
    if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
      if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
        while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
          if (d1 != ".") {
            cutoff -= 1;
            d1 = Number(numString.substring(cutoff,cutoff+1));
          } else {
            cutoff -= 1;
          }
        }
      }
      d1 += 1;
    } 
    if (d1 == 10) {
      numString = numString.substring(0, numString.lastIndexOf("."));
      var roundedNum = Number(numString) + 1;
      newString = roundedNum.toString() + '.';
    } else {
      newString = numString.substring(0,cutoff) + d1.toString();
    }
  }
  if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
    newString += ".";
  }
  var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
  for(var i=0;i<decimals-decs;i++) newString += "0";
  //var newNumber = Number(newString);// make it a number if you like
  return newString; // Output the result to the form field (change for your purposes)
}

function update_total() {
  var total = 0;
  $('.price').each(function(i){
    price = $(this).html().replace("Rs.","");
    if (!isNaN(price)) total += Number(price);
  });

  total = roundNumber(total,2);

  $('#subtotal').html("Rs."+total);
  $('#total').html("Rs."+total);
  
  update_balance();
}

function update_balance() {
  var due = $("#total").html().replace("Rs.","") - $("#paid").val().replace("$","");
  due = roundNumber(due,2);
  
  $('.due').html("Rs."+due);
}

function update_price() {
  var row = $(this).parents('.item-row');
  var price = row.find('.cost').val().replace("Rs.","") * row.find('.qty').val();
  price = roundNumber(price,2);
  isNaN(price) ? row.find('.price').html("N/A") : row.find('.price').html("Rs."+price);
  
  update_total();
}

function bind() {
  $(".cost").blur(update_price);
  $(".qty").blur(update_price);
}

$(document).ready(function() {

  $('input').click(function(){
    $(this).select();
  });

  $("#paid").blur(update_balance);
   





  $("#addrow").click(function(){
    $(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><textarea name="product[]"></textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="description"><textarea name="inf[]"></textarea></td><td><textarea class="cost" name="costt[][]">0.0</textarea></td><td><textarea class="qty" name="qtyy[][]">0</textarea></td><td><span class="price">Rs.0</span></td></tr>');
    if ($(".delete").length > 0) $(".delete").show();
    bind();
  });
  
  bind();
  
  $(".delete").live('click',function(){
    $(this).parents('.item-row').remove();
    update_total();
    if ($(".delete").length < 2) $(".delete").hide();
  });
  
  $("#cancel-logo").click(function(){
    $("#logo").removeClass('edit');
  });
  $("#delete-logo").click(function(){
    $("#logo").remove();
  });
  $("#change-logo").click(function(){
    $("#logo").addClass('edit');
    $("#imageloc").val($("#image").attr('src'));
    $("#image").select();
  });
  $("#save-logo").click(function(){
    $("#image").attr('src',$("#imageloc").val());
    $("#logo").removeClass('edit');
  });
  
  $("#date").val(print_today());
  
});
</script>
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
<br> <br> <br>
<body>
<?php
   include "connect.php";
$ino=$_REQUEST['id'];
     $result=mysql_query("select * from information where no LIKE '%$ino%'");
 

while($row=mysql_fetch_array($result))
{
   $a=$row['no'];
 $b= $row['name'];
  $c=$row['date'];
$numbers = $row['product'];
 $numbers1= $row['inf'];
 $f=$row['total'];
   $g=$row['Discounted'];
   $numbers2=$row['cost'];
$numbers3=$row['qty'];
}
?>

	<div id="page-wrap">

		<center><h3><label>INVOICE</label></h3></center>
<form oninput="a.value=parseInt(b.value)-parseInt(c.value)" action="update.php" method="POST">		
		<div id="identity">
		
           <label id="address"><h4><b>Hardi Stationary & Xerox</b></h4>
ff-17,Vishvas City 1,<br>Ghatlodiya,<br>Ahmedabad<br>
                (+91)9979414060</p></label>
            <div id="logo">

              
              <img id="image" src="images.png" alt="logo" width="150" height="100" />
            </div>
		
		</div>
		
		<div style="clear:both"></div>
		
		<div id="customer">

            <textarea id="customer-title" name="name"><?php echo $b; ?></textarea>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><textarea name="ii"><?php echo $a; ?></textarea></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><textarea id="date" name="date"><?php echo $c; ?></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Pay Amount : Rs.</td>
                    <td><textarea id="a" name="discounted"><?php echo $g; ?></textarea></td>
                </tr>
                
            </table>
		
		</div>
		
		<table id="items" id="tableId">
		
		  <tr>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Quantity</th>
		      <th>Price</th>
		  </tr>
		  
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
		      <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    $k=explode(",",$numbers2);
                    $l=explode(",",$numbers3);
                    echo $i[0]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea name="inf[]"><?php echo$j; ?></textarea></td>
		      <td><textarea class="cost" name="costt[]"><?php echo$k; ?></textarea></td>
		      <td><textarea class="qty" name="qtyy[]"><?php echo$l; ?></textarea></td>
		      <td><span class="price"></span></td>
		  </tr>
		  
		  
		 <!-- <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
		      <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[1]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea name="inf[]"><?php echo$j[1]; ?></textarea></td>
		      <td><textarea class="cost" name="costt[]"><?php echo$k[1]; ?></textarea></td>
		      <td><textarea class="qty" name="qtyy[]"><?php echo$l[1]; ?></textarea></td>
		      <td><span class="price"></span></td>
		  </tr>
		 
 

<tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
		      <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[2]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea name="inf[]"><?php echo$j[2]; ?></textarea></td>
		      <td><textarea class="cost" name="costt[]"><?php echo$k[2]; ?></textarea></td>
		      <td><textarea class="qty" name="qtyy[]"><?php echo$l[2]; ?></textarea></td>
		      <td><span class="price"></span></td>
		  </tr>
		 

 <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
		      <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[3]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea name="inf[]"><?php echo$j[3]; ?></textarea></td>
		      <td><textarea class="cost" name="costt[]"><?php echo$k[3]; ?></textarea></td>
		      <td><textarea class="qty" name="qtyy[]"><?php echo$l[3]; ?></textarea></td>
		      <td><span class="price"></span></td>
		  </tr>


 <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
		      <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[4]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea name="inf[]"><?php echo$j[4]; ?></textarea></td>
		      <td><textarea class="cost" name="costt[]"><?php echo$k[4]; ?></textarea></td>
		      <td><textarea class="qty" name="qtyy[]"><?php echo$l[4]; ?></textarea></td>
		      <td><span class="price"></span></td>
		  </tr>
		 
 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[5]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[5]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[5]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[5]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>

       <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[6]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[6]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[6]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[6]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>
 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[7]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[7]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[7]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[7]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>
       <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[8]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo $j[8]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[8]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[8]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>
 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[9]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[9]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[9]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[9]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>

 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[10]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[10]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[10]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[10]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>
 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[11]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[11]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[11]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[11]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>
 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[12]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[12]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[12]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[12]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>
 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[13]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[13]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[13]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[13]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>
 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[14]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[14]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[14]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[14]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>
 <tr class="item-row">
          <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
          <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[15]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
          <td class="description"><textarea name="inf[]"><?php echo$j[15]; ?></textarea></td>
          <td><textarea class="cost" name="costt[]"><?php echo$k[15]; ?></textarea></td>
          <td><textarea class="qty" name="qtyy[]"><?php echo$l[15]; ?></textarea></td>
          <td><span class="price"></span></td>
      </tr>





















		 
 <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
		      <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[5]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea name="inf[]"><?php echo$j[5]; ?></textarea></td>
		      <td><textarea class="cost" name="costt[]"><?php echo$k[5]; ?></textarea></td>
		      <td><textarea class="qty" name="qtyy[]"><?php echo$l[5]; ?></textarea></td>
		      <td><span class="price"></span></td>
		  </tr>
		 

 <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea name="product[]">
		      <?php $i=explode(",",$numbers);
                    $j=explode(",",$numbers1);
                    echo $i[6]; ?>
</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea name="inf[]"><?php echo $j[6]; ?></textarea></td>
		      <td><textarea class="cost" name="costt[]"><?php echo$k[6]; ?></textarea></td>
		      <td><textarea class="qty" name="qtyy[]"><?php echo$l[6]; ?></textarea></td>
		      <td><span class="price"></span></td>
		  </tr>
		 
!-->






		  <tr id="hiderow">
		    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
		  </tr>
		  
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal"></div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Total</td>
		      <td class="total-line balance"><input type="text" name="m" id="b" value="0.00"></td>
		  </tr>
		  <tr>
                    <td colspan="2" class="blank"> </td>
                   <td colspan="2" class="total-line balance">Discount</td>
                    <td class="total-line balance"><textarea name="dis" id="c">0.00</textarea></td>
                </tr>
            
		</table>
		<input type="submit" name="submit" id="hiderow" value="update">
		<div id="terms">
		  <h5>Terms</h5>
		  <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
		</div>
	
	</div>

	</form>
</body>



</html>
