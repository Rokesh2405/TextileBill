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
		
		$product = explode(',',$_REQUEST['productid']);
		$qtys = explode(',',$_REQUEST['qtys']);
		$chks = explode(',',$_REQUEST['chks']);
       $i=0;
       foreach($qtys as $qtys11){
       	if($qtys11!='') {
       		$product1=$product[$i];
       		if(in_array($product1,$chks)){
       	for($j=1;$j<=$qtys11;$j++){
       		echo "<p class='inline'><span ><b>Item: ".getobject('objectname',$product1)."</b></span>".bar128(stripcslashes(getobject('productcode',$product1)))."<span ><b>Price: ".getobject('price',$product1)." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
       			//echo "<p class='inline'><span ><b>Item: ".getobject('objectname',$product1)."</b></span>".bar128(stripcslashes(getobject('productcode',$product1)))."<span ><b>Price: ".getobject('price',$product1)." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
		}
	}
		
	}
        $i++;
       }
		

		?>
	</div>
</body>
</html>