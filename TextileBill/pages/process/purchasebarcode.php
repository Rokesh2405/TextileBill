<?php include ('../../config/config.inc.php'); ?>
<html>
<head>
<style>
p.inline {display: inline-block;}
span { font-size: 13px;}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }
</style>
</head>
<!-- <body onload="window.print();"> -->
	<body onload="window.print();">
	<div style="margin-left: 5%">
		<?php
		include 'barcode128.php';
		$getid=$_REQUEST['purchaseid'];
	
       	$produs = pFETCH("SELECT * FROM `purchase_object_detail` WHERE `object_id`=?", $getid);
while ($produsfetch = $produs->fetch(PDO::FETCH_ASSOC)) 
{
for($j=1;$j<=$produsfetch['pquantity'];$j++){
       		echo "<p class='inline'><span ><b>".$produsfetch['object']."</b></span>".bar128(stripcslashes(getobject('productcode',$produsfetch['productid'])))."<span ><b>".date('d-m-Y',strtotime(getpurchase('date',$getid)))." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
       			//echo "<p class='inline'><span ><b>Item: ".getobject('objectname',$product1)."</b></span>".bar128(stripcslashes(getobject('productcode',$product1)))."<span ><b>Price: ".getobject('price',$product1)." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
		
	}
		
	
	}	

		?>
	</div>
</body>
</html>