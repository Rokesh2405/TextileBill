<?php
if (isset($_REQUEST['lid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "3,3,45";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

 if ($_REQUEST['lid'] != '') {
$lid=$_REQUEST['lid'];
 $link22 = FETCH_all("SELECT * FROM `sales_order` WHERE `id`=?", $lid);   
 }

if(isset($_REQUEST['salesorder_billno'])) {
 global $db;
@extract($_REQUEST);

$als = FETCH_all("SELECT * FROM `sales_order` WHERE `bill_number`=?", $salesorder_billno);
if($als['id']!='') {
$link22 = FETCH_all("SELECT * FROM `sales_order` WHERE `id`=?", $als['id']); 
$lid=$link22['id'];  
}
else
{
$link22 = FETCH_all("SELECT * FROM `online_order` WHERE `bill_number`=?", $salesorder_billno);    
}

}

 if ($_REQUEST['lid'] != '') {
$lid=$_REQUEST['lid'];
 $link22 = FETCH_all("SELECT * FROM `sales_order` WHERE `id`=?", $lid);   
 }

if (isset($_REQUEST['createaccount'])) {
    global $db;
    @extract($_REQUEST);
    
$status=1;
$resa = $db->prepare("INSERT INTO `customer` (`cusid`,`name`,`mobileno`,`area`,`city`,`address`,`status`) VALUES(?,?,?,?,?,?,?)");
$resa->execute(array($cusid,$name,$mobileno,$area,$city, $address,$status));
 $insid = $db->lastInsertId();    
$url="addsales.php?pid=".$insid; 
  echo "<script>window.location.assign('".$url."')</script>";  

}

if (isset($_REQUEST['newcustomer'])) {
    global $db;
    @extract($_REQUEST);
$resa = $db->prepare("INSERT INTO `customer` (`name`,`mobileno`,`city`,`area`,`address`) VALUES(?,?,?,?,?)");
        $resa->execute(array($cusid,$name,$mobileno,$area,$city, $address,$status));
        // $l_insert = $db->lastinsertid(); 
}

$exerecord = FETCH_all("SELECT * FROM `sales_order` WHERE `bill_number`=?", $link22['bill_number']);   


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['purid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $object1 = implode(',', $objectval);
    $quantity1 = implode(',', $quantity);
    $rate1 = implode(',', $rate);
    $total1 = implode(',', $total);
       $style1 = implode(',', $style);
      $meter1 = implode(',', $meter);
       $orgrate1 = implode(',', $orgrate);
      $mrp_price1 = implode(',', $mrp_price);
    $hsn1 = implode(',', $hsn);
    $gstresult1=implode(',',$gstresult);
    $oid1 = implode(',', $oid);
//    print_r($object1);
//    exit;

    $customerid1 = FETCH_all("SELECT  * FROM `customer` WHERE `id`=?", $cusid);
    $customerid = $customerid1['cusid'];

// $object11 = ltrim($object1, ',');
// $quantity11 = ltrim($quantity1, ',');
    $msg = addsalesorder($style1,$meter1,$orgrate1,$taxtype,$cgstvalue,$sgstvalue,$mrp_price1,$salesman,$hsn1,$billtypemast,$bill_advanceamt,$bill_balanceamt,$gstresult1,$gsttype,$gstvalue,$billtype,$order_method,$oid1,$payment_mode,$customer_name, $order_type, $date, $bill_no,$object1, $quantity1, $rate1, $total1, $given_amt, $balance_amt,$sub_total,$discount,$packing_charge,$delivery_charge,$tot_amt,$getid);
}

if (isset($_REQUEST['lid']) && ($_REQUEST['lid'] != '')) {
        global $db;
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
        global $db;
    $up = $db->prepare("DELETE FROM `sales_order_details` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['lid'];

   if($_REQUEST['lid']!='') { 
   $lids=$_REQUEST['lid'];
      $tobjects = $db->prepare("SELECT SUM(`total`) AS `totsub` FROM `sales_order_details` WHERE `object_id`= ?");
$tobjects->execute(array($lids));
$tobject1 = $tobjects->fetch(PDO::FETCH_ASSOC);
$subtotal=$tobject1['totsub'];
$discount=$link22['discount'];
$gstvalue=$link22['gstvalue'];
$gtotal=($subtotal-$discount)+$gstvalue;
$dueamt=$link22['given_amnt'];
$balanceamt=$gtotal-$dueamt;
$advanceamt=$link22['bill_advanceamt'];
$balcamt=$gtotal-$link22['bill_advanceamt'];    


    echo '<script>window.location.href="' . $sitename . 'process/' + $_REQUEST['lid'] + '/editsales_order.htm"</script>';
    }else{
       echo '<script>window.location.href="' . $sitename . 'process/addsales_order.htm"</script>';   
    }
}
if (isset($_REQUEST['delidss1']) && $_REQUEST['delidss1'] != '') {
    global $db;


    $up = $db->prepare("DELETE FROM `temp_sales_details` WHERE `id`=?");
    $up->execute(array($_REQUEST['delidss1']));

$object1 = $db->prepare("SELECT * FROM `temp_sales_details` WHERE `object_id`= ?");
$object1->execute(array($link22['id']));
$scount = $object1->rowcount();
if($scount==0) {
$subtotal='';
$discount='';
$gstvalue='';
$gtotal='';
$dueamt='';
$balanceamt='';
$advanceamt='';
$balcamt='';
}
else
{
    $tobjects = $db->prepare("SELECT SUM(`total`) AS `totsub` FROM `temp_sales_details` WHERE `object_id`= ?");
$tobjects->execute(array($link22['id']));
$tobject1 = $tobjects->fetch(PDO::FETCH_ASSOC);
$subtotal=$tobject1['totsub'];
$discount=$link22['discount'];
$gstvalue=$link22['gstvalue'];
$gtotal=($subtotal-$discount)+$gstvalue;
$dueamt=$link22['given_amnt'];
$balanceamt=$gtotal-$dueamt;
$advanceamt=$link22['bill_advanceamt'];
$balcamt=$gtotal-$link22['bill_advanceamt'];    
}

    
       echo '<script>window.location.href="' . $sitename . 'pages/process/addsales_order.php?delsttaus=temp&salesorder_billno=' . $_REQUEST['salesorder_billno'] . '"</script>';   
 
}

if($_REQUEST['delsttaus']=='temp') {
       $tobjects = $db->prepare("SELECT SUM(`total`) AS `totsub` FROM `temp_sales_details` WHERE `object_id`= ?");
$tobjects->execute(array($link22['id']));
$tobject1 = $tobjects->fetch(PDO::FETCH_ASSOC);
$subtotal=$tobject1['totsub'];
$discount=$link22['discount'];
$gstvalue=$link22['gstvalue'];
$gtotal=($subtotal-$discount)+$gstvalue;
$dueamt=$link22['given_amnt'];
$balanceamt=$gtotal-$dueamt;
$advanceamt=$link22['bill_advanceamt'];
$balcamt=$gtotal-$link22['bill_advanceamt'];
}

?>

<style>

.content-wrapper, .right-side {
    min-height: 100%;
    background-color: #fff;
    z-index: 800;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px;
    font-size: 13px;
    font-weight: bold;
}
    .form-control{
        font-size:13px !important;
        font-weight:bold;
    }
    label{
        font-size:13px;
    }
    input{
        font-style:bold;
    }
    #task_table input{
        border: none;
        box-shadow:  none;
    }
</style>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- <h1>
            Sales
            <small><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Sales</small>
        </h1> -->
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Sales</a></li>            
            <li><a href="<?php echo $sitename; ?>pages/process/sales_order.php"><i class="fa fa-circle-o"></i> Sales</a></li>
            <!-- <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Sales</li> -->
        </ol>
    </section>

    <!-- Main content -->
    <br>
    <section class="content">
          <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['lid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Sales </h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <?php  if ($_REQUEST['lid'] == '') { ?>
                    <form name="searchform" method="post">
                     <div class="row">
                        <div class="col-md-4">
                        <label>Sales Order Bill No</label>
                        <input type="text" name="salesorder_billno" id="salesorder_billno" class="form-control" value="<?php echo $_REQUEST['salesorder_billno']; ?>">
                        </div>
                         <div class="col-md-4">
                            <br>
                            <button type="submit" name="search" id="search" class="btn btn-success">SEARCH</button>
                         </div>
                     </div> 
                 </form>
             <?php } ?>
                   
<br>
 <form name="department" id="department"  method="post" enctype="multipart/form-data">

 <div class="row">
    <div class="col-md-12" >
                    <div class="row">
                        <div class="col-md-2" >
                        <table width="100%">
                        <tr>
                        <td colspan="2"><label>Customer name</label></td>
                        </tr>
                        <tr>
                        <td  style="margin-top: 5px;">
                        <input type="hidden" id="lid" value="<?php echo $_REQUEST['lid']; ?>">
                        <input type="hidden" name="purid" id="purid" value="<?php echo $exerecord['id']; ?>">
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                             <select name="customer_name" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> id="supplierid" class="form-control select2"  style="font-weight: bold; font-size:13px;width:fit-content;">
                             <option value="">Store</option>
                             <?php
$customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['id']; ?>" <?php if($link22['customer_id']==$customerfetch['id'] || $customerfetch['id']==$_REQUEST['pid']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['name']; ?></option>
<?php } ?>                          
                             </select>
                             
                   
                        </td>
                        <td style="vertical-align:bottom;">
                        <?php if($_REQUEST['type']!='view') { ?>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" style="height:36px;">Add Customer</button>
                        <?php } ?>
                        </td>
                        </tr>
                        </table>
                
                        </div>
                        <div class="col-md-2" style="margin-left:78px;">

                            <label>Order Method</label>   
<select name="order_method" class="form-control" style="margin-top: 16px;width:fit-content;" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>>
                        <option value="">Select</option>
                         <?php
$ordermethod = pFETCH("SELECT * FROM `ordertype` WHERE `status`=?", '1');
while ($ordermethodfetch = $ordermethod->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $ordermethodfetch['id']; ?>" <?php if($link22['order_method']==$ordermethodfetch['id']) { ?> selected="selected" <?php } ?>><?php echo $ordermethodfetch['ordertype']; ?></option>
<?php } ?>                          

                        </select>                           
                            </div>
                       <!-- <div class="col-md-2">
 <label>Order Type <span style="color:#FF0000;">*</span></label>                                  
                            <select name="order_type" id="order_type" required="required" class="form-control" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> style="margin-top: 14px;width:fit-content;">
                            <?php if (getsalesorder('order_method', $_REQUEST['lid']) == '1') { ?>
                                <option value="1" <?php
                                if (stripslashes(getsalesorder('order_type', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Vendor Order</option>
                                <option value="0" <?php
                                if (stripslashes(getsalesorder('order_type', $_REQUEST['lid']) == '0')) {
                                    echo 'selected';
                                }
                                ?>>Phone Order</option>
                            <?php } else if (getsalesorder('order_method', $_REQUEST['lid']) == '2') {  ?>
                            <option value="1" <?php
                                if (stripslashes(getsalesorder('order_type', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Dinnig Order</option>
                                <option value="0" <?php
                                if (stripslashes(getsalesorder('order_type', $_REQUEST['lid']) == '0')) {
                                    echo 'selected';
                                }
                                ?>>Take Away</option>
                            <?php } else { ?>
                            <option value="">Select</option>
                            <?php } ?>
                            </select>
                        </div>-->
                        <div class="col-md-2">
                            <label>Date<span style="color:#FF0000;">*</span></label>
                            <div class="input-group date" style="margin-top: 14px;">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                                if (isset($_REQUEST['lid']) && (date('d-m-Y', strtotime($link22['date'])) != '01-01-1970')) {
                                    echo date('d-m-Y', strtotime($link22['date']));
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?>" >
                            </div>  
                        </div>
                        
                        
                        <div class="col-md-2">
                             <label>Bill Type </label>   
                        <select name="billtypemast" id="billtype" class="form-control"  style="margin-top: 16px;" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>>
                       <option value="1" <?php
                                if ($link22['billtypemast'] == '1') {
                                    echo 'selected';
                                }
                                ?>>Cash Bill</option>
                                <option value="2"  <?php
                                if ($link22['billtypemast'] == '2') {
                                    echo 'selected';
                                }
                                ?>>Credit Bill</option>
                        </select>

                            
                            <!--  Manual Bill:<input type="checkbox" name="" id="chkRead"> -->
                           
                               
                              
                            </div> 
<div class="col-md-2">

                            <label>GST Type</label>   
<select name="gsttype" id="gsttype" class="form-control" style="margin-top: 16px;width:fit-content;" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>>
                        <option value="1" <?php
                                if ($link22['gsttype'] == '1') {
                                    echo 'selected';
                                }
                                ?>>With GST</option>
                        <option value="2" <?php
                                if ($link22['gsttype'] == '2') {
                                    echo 'selected';
                                }
                                ?>>Without GST</option>
                        </select>                           
                            </div>
                        </div>
                        <br>
                        
                        <div class="row">
<div class="col-md-3">
    <table width="100%">
                        <tr>
                        <td colspan="2"><label>Bill Number<span style="color:#FF0000;">*</span></label>
                        <?php if($_REQUEST['type']!='view') { ?>
                        &nbsp;&nbsp;&nbsp;<label>Manual Bill</label>&nbsp;<input type="checkbox" name="billtype" id="chkRead" value="1" <?php if($link22['billtype']=='1') { ?> checked="checked" <?php } ?>> 
                                <div style="display:block;" id="bilresult11"></div>
                    
                    <?php } ?>
                                </td>
                        </tr>
                        <tr>
                        <td colspan="2"><input type="text" class="form-control"  <?php if($link22['billtype']!='1') { ?> readonly="" <?php } ?> name="bill_no" id="bill_no" style="width:fit-content;" required="required"  value="<?php if($link22['bill_number']!=''){ echo $link22['bill_number']; } else { $customerid1 = FETCH_all("SELECT  * FROM `sales_order` WHERE `id`!=? ORDER BY `id` DESC", 0);
                                echo $customerid1['bill_number'] + 1;
                                }
                                 ?>"></td>
                        
                        
                        </tr>
                        </table>
                            

</div>

  <div class="col-md-3">
                            <br><br>
                            <table width="30%" border="1">
                                <tr>
                                    <td> <input type="radio" name="taxtype" value="1" <?php if($link22['taxtype']==1) { ?> checked="checked" <?php } ?>>&nbsp;&nbsp;Include Tax  </td>
                                     <td> <input type="radio" name="taxtype" value="2" <?php if($link22['taxtype']==2) { ?> checked="checked" <?php } ?>>&nbsp;&nbsp;Exclude Tax  </td>
                                 </tr>   
                             </table>
                        </div>
                       

 <!-- <div class="col-md-3">
                        <label>Salesman</label>
                    <select name="salesman" class="form-control" required>
                     <option value="">Select</option>
                             <?php
$salesman = pFETCH("SELECT * FROM `salesman` WHERE `status`=?", '1');
while ($salesmanfetch = $salesman->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $salesmanfetch['id']; ?>" <?php if($link22['salesman']==$salesmanfetch['id']) { ?> selected="selected" <?php } ?>><?php echo $salesmanfetch['name']; ?></option>
<?php } ?>                          
                             </select>
                    </div> -->
                        </div>
                        <br>
                   <!-- <div class="clearfix"><br /></div> -->
                   
                   <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                          <table width="80%" class="table table-bordered" id="task_table" cellpadding="0"  cellspacing="0">
                                     <!--    <table width="80%" class="table" id="task_table" cellpadding="10"  cellspacing="0" border="0"> -->
                                            <thead>
                                                <tr style="font-size:13px;font-weight:bold;">
                                                    <th width="1%">S.no</th>
                                                    <th width="20%">Product Name / Code / Bar Code</th>
                                                    <th width="8%">HSN</th>
                                                     <th width="15%">Style & Pattern</th>
                                                     <th width="8%">Meter</th>
                                                    <th width="10%">Quantity</th>
                                                    <!--  <th width="10%">MRP</th> -->
                                                    <th width="10%">Rate</th>
                                                    <th width="15%">Total</th>
                                                    <!--<th width="55%">Image</th>-->
                                                    <th width="2%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody><?php
                                                $b = 1;
                                                if($_REQUEST['delsttaus']=='temp') {
                                                $object1 = $db->prepare("SELECT * FROM `temp_sales_details` WHERE `object_id`= ?");
                                                }
                                                else if($exerecord['id']!='') {
                                                $object1 = $db->prepare("SELECT * FROM `sales_order_details` WHERE `object_id`= ?");
                                                }
                                                else {

        // $get = $db->prepare("TRUNCATE `temp_sales_details` ");
        // $get->execute(array());


                                                 $objectsss1 = $db->prepare("SELECT * FROM `online_order_deatils` WHERE `object_id`= ?"); 
                                                  $objectsss1->execute(array($link22['id']));  
                                                  while ($objectsss1list = $objectsss1->fetch(PDO::FETCH_ASSOC)) 
                                                    {
                                                  
$getrecr = FETCH_all("SELECT * FROM `temp_sales_details` WHERE `bill_no`=?", $objectsss1list['id']);   
if($getrecr['id']==''){
                                                    $hsn=$objectsss1list['hsn'];
                                                    $gstresult=$objectsss1list['gstresult'];
                                                    $object_id=$objectsss1list['object_id'];
                                                    $bill_no=$objectsss1list['id'];
                                                    $product_name=$objectsss1list['product_name'];
                                                     $rate=$objectsss1list['rate'];
                                                     $mprprice=$objectsss1list['mrp_price'];
                                                     $style=$objectsss1list['style'];
                                                     $meter=$objectsss1list['meter'];
                                                     $orgrate=$objectsss1list['orgrate'];
                                                      $total=$objectsss1list['total'];
                                                    $qty=$objectsss1list['qty'];

                                                     $resa = $db->prepare("INSERT INTO `temp_sales_details` (`style`,`meter`,`orgrate`,`mrp_price`,`hsn`,`gstresult`,`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
            $resa->execute(array($style,$orgrate,$meter,$mprprice,$hsn,$gstresult,$object_id,$bill_no,$product_name,$qty,$rate,$total));
}

                                                    }
  $object1 = $db->prepare("SELECT * FROM `temp_sales_details` WHERE `object_id`= ?");
                                                }
                                                $object1->execute(array($link22['id']));
                                                $scount = $object1->rowcount();
                                                //echo $_REQUEST['lid'];
                                                if ($scount != '0') {
                                            while ($object1list = $object1->fetch(PDO::FETCH_ASSOC)) 
                                            {

                                                        ?>
                                                        <tr>
                                                            <td><?php echo $b; ?></td>
                                                            <td>
                                                            <input <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> type="text" name="objectval[]" id="objectval" class="form-control objectchange" value="<?php echo $object1list['product_name']; ?>">
                                                              <input type="hidden" name="gstresult[]" id="gstresult" class="gstresult" value="<?php echo $object1list['gstresult']; ?>">
</td>
                                                            <td><input type="text" style="text-align: right;" name="hsn[]" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>  id="hsn" class="form-control" value="<?php echo $object1list['hsn']; ?>"/></td>
                                                             <td>

    <select name="style[]" id="style" class="form-control stylechange">
        <option value="">Select</option>
 <?php
 if($object1list['style']!='') {
 $stypleproid=getstylepattern('object_id',$object1list['style']);
$style = pFETCH("SELECT * FROM `objectprice` WHERE `object_id`=?", $stypleproid);
while ($stylefetch = $style->fetch(PDO::FETCH_ASSOC)) 
{
?>
<option value="<?php echo $stylefetch['id']; ?>" <?php if($stylefetch['id']==$object1list['style']) { ?> selected="selected" <?php } ?>><?php echo getstyle('style',$stylefetch['style']).' - '.getpattern('pattern',$stylefetch['pattern']); ?></option>
<?php } } ?>
</select>
 </td>
 <td>
        <input type="text" name="meter[]" id="meter" class="form-control meter" value="<?php echo $object1list['meter']; ?>">
    </td>


        <td>
        <input type="hidden" name="oid[]" value="<?php echo $object1list['id']; ?>">
      
        <input type="text" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>  style="text-align: right;" name="quantity[]" id="quantity[]" pattern="[0-9]+" class="form-control quantity" value="<?php echo $object1list['qty']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>
        
        <td>
<input type="hidden" style="text-align: right;" name="mrp_price[]" readonly="readonly" id="mrp_price" class="form-control mrp_price" value="<?php echo $object1list['mrp_price']; ?>">
<input type="hidden" style="text-align: right;" name="orgrate[]" readonly="readonly"  id="orgrate[]" class="form-control orgrate" value="<?php echo $object1list['orgrate']; ?>"/>
       
            <input type="text" style="text-align: right;" name="rate[]" readonly="readonly" id="rate[]" class="form-control rate" value="<?php echo $object1list['rate']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="ratehidden" id="ratehidden" value="" /></td>
         
        <td><input type="text" style="text-align: right;" name="total[]" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>  id="total[]" class="form-control total" value="<?php echo $object1list['total']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>
    <?php if($exerecord['id']!='') { ?>
                                                            <td <?php if($_REQUEST['type']!='view') { ?>  onclick="delrec1($(this), '<?php echo $object1list['id']; ?>','<?php echo $lid; ?>')"  <?php } ?>><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                        <?php } else {
                                                            ?>
                                                                    <td <?php if($_REQUEST['type']!='view') { ?>  onclick="delrecss1($(this), '<?php echo $object1list['id']; ?>','<?php echo $_REQUEST['salesorder_billno']; ?>')"  <?php } ?>><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                        <?php                                                     } ?>
                                                        </tr>
                                                        <?php
                                                        $b++;
                                                    }
                                                }
                                                ?>
                                                
                                                <?php if($_REQUEST['type']!='view') { ?>  
                                                    <tr id="firsttasktr1">
                                                    <td><?php echo $b; ?></td>
                                                    <td>
                                                          <input type="hidden" name="gstresult[]" id="gstresult" class="gstresult">
                                                    <input type="hidden" name="oid[]" value="">
                                                    <input type="text" name="objectval[]" id="objectval" class="form-control objectchange">
                                                       
                                                           <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 

                                                    </td>

                                                    <td><input type="text" style="text-align: right;" name="hsn[]" id="hsn" class="form-control" value="" /></td>
                                                     <td>
    <select name="style[]"  id="style" class="form-control stylechange">
        <option value="">SELECT</option>

</select>
 </td>
 <td>
        <input type="text" name="meter[]" id="meter" class="form-control meter">
    </td>

<td><input type="text" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control quantity" value="" /><input type="hidden" name="qtyhidden" id="qtyhidden" pattern="[0-9]+" onkeyup="quantitycalculation(this.value)"/></td>


                                                 
<td>
 <input type="hidden" style="text-align: right;" name="mrp_price[]" readonly="readonly" id="mrp_price" class="form-control mrp_price" />
   <input type="hidden" style="text-align: right;" name="orgrate[]" readonly="readonly"  id="orgrate[]" class="form-control orgrate"/>
    <input type="text" style="text-align: right;" name="rate[]" readonly="readonly" id="rate[]" class="form-control rate" value="" /><input type="hidden" name="ratehidden" id="ratehidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

<td><input type="text" style="text-align: right;" name="total[]" id="total" class="form-control total"/><input type="hidden" name="totalhidden" id="totalhidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

                                                    <!--<td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>-->
                                                </tr>
                                        
                                                <tr id="firsttasktr" style="display:none">
                                                    <td>1</td>
                                                    <td>
                                                    <input type="hidden" name="oid[]" value="">
                                                          <input type="hidden" name="gstresult[]" id="gstresult" class="gstresult">
                                                    <input type="text" name="objectval[]" id="objectval" class="form-control objectchange">
                                                    <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                    </td>
                                                    <td><input type="text" style="text-align: right;" name="hsn[]" id="hsn" class="form-control" value="" /></td>
                                                     <td>
    <select name="style[]"  id="style" class="form-control stylechange">
        <option value="">SELECT</option>

</select>
 </td>
 <td>
        <input type="text" name="meter[]" id="meter" class="form-control meter">
    </td>

<td><input type="text" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control quantity" value="" /><input type="hidden" name="qtyhidden" id="qtyhidden" pattern="[0-9]+" onkeyup="quantitycalculation(this.value)"/></td>


<td>
<input type="hidden" style="text-align: right;" readonly="readonly" name="mrp_price[]" id="mrp_price" class="form-control mrp_price"  />
 <input type="hidden" style="text-align: right;" name="orgrate[]" readonly="readonly"  id="orgrate[]" class="form-control orgrate" />

    <input type="text" style="text-align: right;" readonly="readonly" name="rate[]" id="rate[]" class="form-control rate" value="" /><input type="hidden" name="ratehidden" id="ratehidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

<td><input type="text" style="text-align: right;" name="total[]" id="total" class="form-control total"/><input type="hidden" name="totalhidden" id="totalhidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

                                                    <!--<td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>-->
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr><td colspan="9"></td></tr>
                                                <tr>
                                                    <td colspan="9" style="border:0;">
                                                    <?php if($_REQUEST['type']!='view') { ?>  
                                                    <button type="button" class="btn btn-info" style="background-color: #00a65a;border-color: #008d4c;" id="add_task">Add Item</button>
                                                    <?php } ?>
                                                    </td>
                                                    <!--<td style="text-align:right;"> <label>Total Quantity </label> </td>-->
                                                    <!--<td><input type="text" style="text-align: right;font-size: 19px;" name="totalquantity" id="totalquantity" value="<?php echo getpurchase('totalquantity', $_REQUEST['lid']); ?>" /></td>-->
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>                                   
                                </div>
                            </div>
                            <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 6px solid #ffff;
  text-align: left;
  padding: 10px;
}

tr:nth-child(even) {
  /*background-color: #dddddd;*/
}
</style>

<div class="row">
<div class="col-md-6">
<table width="100%" style="width:500px;font-size:13px; font-weight:bold;" align="left">

   <tr>
    <td>Payment Mode:</td>
    <td>
    <select name="payment_mode" class="form-control" required="required" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?>>
    <option value="">Select</option>
     <?php
$paymentmode = pFETCH("SELECT * FROM `paymentmode` WHERE `status`=?", '1');
while ($paymentmodefetch = $paymentmode->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $paymentmodefetch['id']; ?>" <?php if($link22['payment_mode']==$paymentmodefetch['id']) { ?> selected="selected" <?php } ?>><?php echo $paymentmodefetch['paymentmode']; ?></option>
<?php } ?>
   
    </select>
    
    </td>
  </tr>
  <tr>
    <td  <?php if($link22['billtypemast']=='2') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="bil1">Advance Amount:</td>
    <td <?php if($link22['billtypemast']=='2') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="bil2"><input type="text" name="bill_advanceamt" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> class="form-control"  id="bill_advanceamt" value="<?php if($advanceamt!='') {echo $advanceamt; } else { echo $link22['bill_advanceamt']; } ?>">
</td>
</tr>
 <tr>
    <td <?php if($link22['billtypemast']=='2') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="bil3">Balance Amount:</td>
    <td <?php if($link22['billtypemast']=='2') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="bil4"><input type="text" class="form-control" name="bill_balanceamt" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> id="bill_balanceamt" value="<?php if($balcamt!='') { echo $balcamt; } else { echo $link22['bill_balanceamt']; } ?>">
</td>
</tr>
</table>

</div>
<div class="col-md-6">

<table border="1" cellpadding="10" style="width:372px;font-size:13px; font-weight:bold;" align="right">
 
  
  <tr>
    <td>Sub Total:</td>
    <td><input type="text" class="form-control"  name="sub_total" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> id="sub_total" readonly value="<?php if($subtotal!='') { echo $subtotal; } else { echo stripslashes($link22['sub_tot']); } ?>"></td>
  </tr>
  <tr>
   <td>Discount:</td>
    <td><input type="text" class="form-control"  <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="discount" id="discount" value="<?php if($discount!='') { echo $discount; } else { echo stripslashes($link22['discount']);} ?>"></td>
    
  </tr>
  <tr>

    <td colspan="2">
        <div class="row" <?php if($link22['gsttype']=='2') { ?> style="display:none;" <?php } else { ?> style="display:block;" <?php } ?> id="gstdisp">
    <div class="col-md-6" style="padding-right: 0px;">CGST Value:</div>
       <div class="col-md-6"  style="padding-left: 20px;"><input class="form-control"  type="hidden" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="gstvalue" id="gstvalue" value="<?php if($gstvalue!='') { echo $gstvalue; } else { echo stripslashes($link22['gstvalue']); } ?>">
        <input class="form-control"  type="text" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="cgstvalue" id="cgstvalue" value="<?php echo $link22['cgstvalue']; ?>">

       </div>
</div>
   </td>
 
  </tr>

   <tr>

    <td colspan="2">
        <div class="row" <?php if($link22['gsttype']=='2') { ?> style="display:none;" <?php } else { ?> style="display:block;" <?php } ?> id="gstdisp1">
    <div class="col-md-6" style="padding-right: 0px;">SGST Value:</div>
       <div class="col-md-6"  style="padding-left: 20px;"> <input class="form-control"  type="text" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="sgstvalue" id="sgstvalue" value="<?php echo $link22['sgstvalue']; ?>"></div>
</div>
   </td>
 
  </tr>

  <!--<tr>
     <td>Packing Charges:</td>
    <td><input type="text" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="packing_charge" id="packing_charge" value="<?php echo stripslashes(getsalesorder("packing_charges", $_REQUEST['lid'])); ?>"></td>
    
  </tr>
   <tr>
   <td>Delivery Charges:</td>
    <td><input type="text" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="delivery_charge" id="delivery_charge" value="<?php echo stripslashes(getsalesorder("delivery_charges", $_REQUEST['lid'])); ?>"></td>
    
  </tr>-->
   <tr>
 
  
    <td style="color:blue; font-size:22px;">Grand Total:</td>
    <td><input type="text" name="tot_amt" class="form-control"  <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> id="tot_amt" value="<?php if($gtotal!='') { echo $gtotal; } else { echo stripslashes($link22['total_amnt']); } ?>"></td>
    
  </tr>
  <tr>
  <td>Due Amount:</td>
    <td width="45%"><input type="text" class="form-control"  name="given_amt" id="given_amt" value="<?php if($dueamt!='') { echo $dueamt; } else { echo stripslashes($link22['given_amnt']); } ?>" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?>></td>
   </tr>
  <tr>
    <td>Balance Amount:</td>
    <td><input type="text" class="form-control"  name="balance_amt" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> id="balance_amt" value="<?php if($balanceamt!='') { echo $balanceamt;  } else { echo $link22['balance_amnt']; } ?>"></td>
    
  </tr>
  <tr>
  <td colspan="2">&nbsp; </td>
  </tr>
 </table>
                        
                     
                 <!--   <div class="row">
                        <div class="col-md-4">
                            <label>Discount(%/Rs)<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="discount_type" id="discount_type" placeholder="Enter Discount" class="form-control" value="<?php echo stripslashes(getsalesorder("netweight", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4">
                            <label>Sub Total <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Sub Total" class="form-control" value="<?php echo stripslashes(getsalesorder("amount", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4">

                            <label>Status <span style="color:#FF0000;">*</span></label>                                  
                            <select name="status" class="form-control">
                                <option value="1" <?php
                                if (stripslashes(getsalesorder('status', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if (stripslashes(getsalesorder('status', $_REQUEST['lid']) == '0')) {
                                    echo 'selected';
                                }
                                ?>>Canceled</option>

                            </select>
                        </div> -->

                    </div> 
                 <br>

                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if ($_REQUEST['lid'] != '') {
                                ?>
                                <!--<a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename . 'MPDF/receiptprint.php?id=' . $_REQUEST['lid']; ?>"></a>-->
                            <?php } ?>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo $sitename; ?>pages/process/sales_order.php" target="_blank" style="font-size:19px;">Back to Listings page</a>
                        </div>
                        <div class="col-md-4">
                        <?php if($_REQUEST['lid']!='') {
                         if(getsettings('setting_value',1)=='1') {
                         ?>
                         <a href="<?php echo $sitename; ?>MPDF/bill.php?id=<?php echo $_REQUEST['lid']; ?>" style="font-size:19px;"><button type="button" name="print" id="submit" class="btn btn-success" style="float:right;">PRINT</button></a>
                        <?php } else { ?>
 <a href="<?php echo $sitename; ?>MPDF/billinvoice.php?id=<?php echo $_REQUEST['lid']; ?>" style="font-size:19px;"><button type="button" name="print" id="submit" class="btn btn-success" style="float:right;">PRINT</button></a>
                        <?php }  } ?>
                         </div>
                        <div class="col-md-4">
                        <?php if($_REQUEST['type']!='view') { ?> 
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['lid'] != '') {
                                    echo 'UPDATE & PRINT';
                                } else {
                                    echo 'SAVE & PRINT';
                                }
                                ?></button>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div></div></form>
            </div><!-- /.box -->
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <div class="container">
  <!-- <h2>Add Customer</h2> -->
  <!-- Trigger the modal with a button -->
  
  <!-- Modal -->
  
  
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Add New Customer</strong></h4>
        </div>
        <form name="mform" method="post">
       <div class="row" style="padding:10px;">
                        
                        
                        <div class="col-md-4">
                            <label>Name <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php echo stripslashes(getcustomer('name',$_REQUEST['cid'])); ?>" />
                        </div>
                         <div class="col-md-4">
                            <label>Mobile Number <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="mobileno" id="mobileno" placeholder="Enter Mobile No" class="form-control" value="<?php echo stripslashes(getcustomer('mobileno',$_REQUEST['cid'])); ?>" />
                        </div>
                        <div class="col-md-4">
                            <label>Area <span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="area" id="area" placeholder="Enter Area" class="form-control" value="<?php echo stripslashes(getcustomer('area',$_REQUEST['cid'])); ?>" />
                        </div>
                        </div>
                        <br>
                        <div class="row" style="padding:10px;">
                        
                        <div class="col-md-4">
                            <label>City <span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="city" id="area" placeholder="Enter City" class="form-control" value="<?php echo stripslashes(getcustomer('city',$_REQUEST['cid'])); ?>" />
                        </div>
                         <div class="col-md-8">
                            <label>Address <span style="color:#FF0000;">*</span></label>
                            <textarea  required="required" name="address" id="address" placeholder="Enter address" class="form-control" ><?php echo getcustomer('address',$_REQUEST['cid']); ?></textarea>
                        </div>
                         <!-- <div class="col-md-4">
                             <label>Receipt Number <span style="color:#FF0000;">*</span></label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                                    <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter the Receipt Number"  class="form-control" value="<?php echo (getcustomer('receipt_no',$_REQUEST['cid'])); ?>" />
                        </div>  -->
                    </div>
        
        <div class="modal-footer">
          <button type="submit" name="createaccount" class="btn btn-default" name="newcustomer">Save</button> &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
       </form>
      </div>
      
    </div>
  </div>
 
</div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript">

    function show_contacts(id) {
        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            data: {get_contacts_of_customer: id}
        }).done(function (data) {
            $('#choose_contacts_grid_table tbody').html(data);
        });
    }


    function delrec(elem, id) {
        if (confirm("Are you sure want to delete this Object?")) {
            $(elem).parent().remove();
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getpurchase('id', $_REQUEST['lid']); ?>/editprovider.htm?delid=" + id;
        }
    }

var count = 0;


        $(document).on('keyup', '.quantity', function (e){
    var quantity =  $(this).val();
    var rate = $(this).parent().siblings('td').find('.rate').val();
 var hsn = $(this).parent().siblings('td').find('#hsn').val();
    // alert(quantity);
    // alert(rate);
    // exit;
 var gstress=0;

   $('.gstresult').each(function(){
    var total=$(this).parent().siblings('td').find('.rate').val();
    var qtys=$(this).parent().siblings('td').find('.quantity').val();

    var gstres =  $(this).val();
if(gstres!='') {

    var finval=parseFloat(total)*parseFloat(qtys);

    var orggst =   parseFloat(finval)*parseFloat(gstres/100);
      gstress+= parseFloat(orggst);  

}
 });
var res=parseFloat(gstress)/2;

$('#gstvalue').val(gstress);
$('#cgstvalue').val(res);
$('#sgstvalue').val(res);


         var self = this;
   $.ajax({
            url: "<?php echo $sitename; ?>pages/process/proprice.php",
            data: {qty: quantity,hsn: hsn},
            success: function (data) {
                const myArray = data.split("|");
            if(myArray[0]=='notallow') {
               
               alert("You can allow only "+myArray[1]+" quantity");
                 $(self).val("");
                $(self).parent().siblings('td').find('.total').val("");
                $('#sub_total').val();
                $('#tot_amt').val();
              }
             
            }
        });


 var total = rate * quantity;


$(self).parent().siblings('td').find('.total').val(total);

        var sum=0;
 
        $('.total').each(function(){
        
        sum+=Number($(this).val());
        
        });

    //     $('#sub_total').val(sum);
    //     if($('#lid').val()!=='') {
    //     discount=$('#discount').val();
    //     final_total=sum;
    //     if(discount!=='') {
            
    //     final_total = (parseFloat(sum) - parseFloat(discount));
    //     }
    //     given_amnt=$('#given_amt').val();
    //     balance_amnt=$('#balance_amt').val();
    //     if(given_amnt!=='') {
    //         gfinal_total = (parseFloat(final_total) - parseFloat(given_amnt));
    //         $('#balance_amt').val(gfinal_total);
    //     }
    // gtotal=parseFloat(final_total)+parseFloat($('#gstvalue').val());
            
    //  $('#tot_amt').val(Math.abs(gtotal));
    //     } else { 
    //         gstvalue=$('#gstvalue').val(); 
    //         gtotal=parseFloat(sum)+parseFloat($('#gstvalue').val());
    //         $('#tot_amt').val(gtotal);
    //     }
   
        });


// $(document).on('keyup', '.quantity', function (e){
//             var quantity =  $(this).val();
//     var rate = $(this).parent().siblings('td').find('.rate').val();
 
//     // alert(quantity);
//     // alert(rate);
//     // exit;

//     var total = rate * quantity;

// var gstress=$('#gstvalue').val();
 
//   $('#gstresult').each(function(){
    
//     var total=$(this).parent().siblings('td').find('.rate').val()
//     var gstres =  $(this).val();
    
//         var orggst =   parseFloat(total)*parseFloat(gstres/100);
       
//    gstress= parseFloat(orggst * quantity);  


//         });


// $('#gstvalue').val(gstress);

// $(this).parent().siblings('td').find('.total').val(total);


// var sum=0;
 
//         $('.total').each(function(){
//         sum+=Number($(this).val());
//         });

//         $('#sub_total').val(sum);
//         if($('#lid').val()!=='') {
//         discount=$('#discount').val();
//         final_total=sum;
//         if(discount!=='') {
            
//         final_total = (parseFloat(sum) - parseFloat(discount));
//         }
//         given_amnt=$('#given_amt').val();
//         balance_amnt=$('#balance_amt').val();
//             if(given_amnt!=='') {
                
                
//             gfinal_total = (parseFloat(final_total) - parseFloat(given_amnt));
//             $('#balance_amt').val(gfinal_total);
//             }
//               bill_advanceamt=$('#bill_advanceamt').val();
//             if(bill_advanceamt!=='') {
                 
//             bill_balanceamt = (parseFloat(final_total) - parseFloat(bill_advanceamt));
//             $('#bill_balanceamt').val(bill_balanceamt);
//             }

//   gtotal=parseFloat(final_total)+parseFloat($('#gstvalue').val());
            
//      $('#tot_amt').val(Math.abs(gtotal));
//         } else { 
//             gstvalue=$('#gstvalue').val(); 
//             gtotal=parseFloat(sum)+parseFloat($('#gstvalue').val());
            
// $('#tot_amt').val(gtotal);
//         }
//         });

$(document).on('keyup', '.objectchange', function (e){
    var product = $(this).val();
     $this = $(this);
     
     // Initialize jQuery UI autocomplete
  $('.objectchange').autocomplete({
   source: function( request, response ) {
    $.ajax({
   url:"<?php echo $sitename.'pages/process/'; ?>proprice.php",
     type: 'post',
     dataType: "json",
     data: {
      search: request.term,request:1
     },
     success: function( data ) {
      response( data );
     }
    });
   },
   select: function (event, ui) {
    $(this).val(ui.item.label); // display the selected text
    var userid = ui.item.value; // selected value
$.ajax({
                url:"<?php echo $sitename.'pages/process/'; ?>proprice.php",
                data:{data:userid}
            }).done(function(result)
            {
                    const myArray = result.split("|");
                var rateval=myArray[0];
                if($('#gsttype').val()=='1') {
                      $("#gstdisp").css("display", "block");
                     $("#gstdisp1").css("display", "block");
              //  $('#gstvalue').val(myArray[1]);
             var resul=myArray[2]/2;
              $this.parent().parent().find('#cgstresult').val(resul);
                 $this.parent().parent().find('#sgstresult').val(resul);
                  $this.parent().parent().find('#gstresult').val(myArray[2]);
            
            }
            else
            {
                  $("#gstdisp").css("display", "none");
                  $("#gstdisp1").css("display", "none");
                    $('#cgstvalue').val(0);
                    $('#sgstvalue').val(0);
            }

  $this.parent().parent().find('#hsn').val(myArray[3]);
  $this.parent().parent().find('#mrp_price').val(myArray[4]);
                  $this.parent().parent().find('.rate').val(rateval);
                   $this.parent().parent().find('.orgrate').val(rateval);
                     $this.parent().parent().find('#style').html(myArray[5]);
            })

    return false;
   }
  });
  
    
            
});
   

$(document).on('change', '.stylechange', function (e){
      var styleid = this.value;
      
      
    $.ajax({
                url:"<?php echo $sitename.'pages/process/'; ?>proprice.php",
                data:{styleid:styleid}
            }).done(function(result)
            {
                $this.parent().parent().find('.rate').val(result);
                
            })
     });

  $(document).on('keyup', '.meter', function (e){
    var meter =  $(this).val();
    var rate = $(this).parent().siblings('td').find('.orgrate').val();

if(meter!='') {
    var finval=parseFloat(rate)*parseFloat(meter);
$(this).parent().siblings('td').find('.rate').val(finval);
}

   
        });


   

   $(document).ready(function (e) {
$(document).on('keyup', '#bill_advanceamt', function (e){
 final_total = parseFloat($('#tot_amt').val()) - parseFloat($(this).val());
     $('#bill_balanceamt').val(Math.abs(final_total));  
});

$(document).on('keyup', '#given_amt', function (e){
 final_total = parseFloat($('#tot_amt').val()) - parseFloat($(this).val());
     $('#balance_amt').val(Math.abs(final_total));  
});
$(document).on('keyup', '#discount', function (e){
    if($(this).val()!=='') {
      final_total = parseFloat($('#sub_total').val()) - parseFloat($(this).val());
         gtotal=parseFloat(final_total)+parseFloat($('#gstvalue').val());
    
     $('#tot_amt').val(Math.abs(gtotal));
    }
    else
    {
           gtotal=parseFloat($('#sub_total').val())+parseFloat($('#gstvalue').val());
    
     $('#tot_amt').val(gtotal); 
    }
     
 });
 $(document).on('keyup', '#packing_charge', function (e){
     if($(this).val()!=='') {
     final_total = (parseFloat($('#sub_total').val()) - parseFloat($('#discount').val())) + Number($(this).val());
     $('#tot_amt').val(final_total);
     }
     else
    {
     final_total = parseFloat($('#sub_total').val()) - parseFloat($('#discount').val());
     $('#tot_amt').val(Math.abs(final_total));
    }
     
 });

 $(document).on('keyup', '#delivery_charge', function (e){
      if($(this).val()!=='') {
           final_total = (parseFloat($('#sub_total').val()) - parseFloat($('#discount').val())) + Number($(this).val()) + Number($('#packing_charge').val());
     $('#tot_amt').val(final_total);
    
      }
      else{
        
     final_total = (parseFloat($('#sub_total').val()) - parseFloat($('#discount').val())) + parseFloat($('#packing_charge').val());
     $('#tot_amt').val(final_total);

      }
      
     
 });

         

$(document).on('keyup', '#bill_no', function (e){
      var billno = this.value;
      
      
    $.ajax({
                url:"<?php echo $sitename.'pages/process/'; ?>proprice.php",
                data:{billno:billno}
            }).done(function(result)
            {
                if(result!='') {
                    $("#bilresult11").css("display", "block");
                $('#bilresult11').html(result);
                $('#bill_no').val('');
                }
                else
                {
                $('#bilresult11').html(''); 
        
                }
                
            })
     });
    
        $(document).on('keydown', '#total', function (e){
            
            var rate =  $(this).parent().siblings('td').find('.rate').val();
    var quantity = $(this).parent().siblings('td').find('.quantity').val();

    var total = rate * quantity;

$(this).parent().siblings('td').find('.total').val(total);

var sum=0;
 
        $('.total').each(function(){
        sum+=Number($(this).val());
         
        });

        $('#sub_total').val(sum);
        
        if($('#lid').val()!=='') {
        discount=$(this).parent().siblings('td').find('.discount').val();
        final_total=sum;
        if(discount!=='') {
        final_total = (parseFloat(sum) - parseFloat(discount)) ;
        }
        given_amnt=$(this).parent().siblings('td').find('#given_amnt').val();
        balance_amnt=$(this).parent().siblings('td').find('#balance_amnt').val();
            if(given_amnt!=='') {
                gfinal_total = (parseFloat(final_total) - parseFloat(given_amnt))
            $('#balance_amnt').val(gfinal_total);
            }
      gtotal=parseFloat(final_total)+parseFloat($('#gstvalue').val());
    
     $('#tot_amt').val(Math.abs(gtotal));
        } else { 
            gtotal=parseFloat(sum)+parseFloat($('#gstvalue').val());
    
        $('#tot_amt').val(gtotal); 
        } 
var data = $('#firsttasktr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Details?")) {
                    $(this).parent().remove();
                    re_assing_serial();

                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#task_table tbody').append(data);
            $('.usedatepicker').datepicker({
                autoclose: true
            });


            re_assing_serial();

        });

     
        $(document).on('keyup', '.rate', function (e){
            var quantity =  $(this).parent().siblings('td').find('.quantity').val();
    var rate = $(this).val();
 
    // alert(quantity);
    // alert(rate);
    // exit;

    var total = rate * quantity;

var gstress=0;

  $('.gstresult').each(function(){
    var total=$(this).parent().siblings('td').find('.rate').val();
    var qtys=$(this).parent().siblings('td').find('.quantity').val();

    var gstres =  $(this).val();
if(gstres!='') {

    var finval=parseFloat(total)*parseFloat(qtys);

    var orggst =   parseFloat(finval)*parseFloat(gstres/100);
      gstress+= parseFloat(orggst);  

}
 });
var res=parseFloat(gstress)/2;

$('#gstvalue').val(gstress);
$('#cgstvalue').val(res);
$('#sgstvalue').val(res);


$(this).parent().siblings('td').find('.total').val(total);


var sum=0;
 
        $('.total').each(function(){
        sum+=Number($(this).val());
        });

        $('#sub_total').val(sum);
        if($('#lid').val()!=='') {
        discount=$('#discount').val();
        final_total=sum;
        if(discount!=='') {
            
        final_total = (parseFloat(sum) - parseFloat(discount));
        }
        given_amnt=$('#given_amt').val();
        balance_amnt=$('#balance_amt').val();
            if(given_amnt!=='') {
                
                
            gfinal_total = (parseFloat(final_total) - parseFloat(given_amnt));
            $('#balance_amt').val(gfinal_total);
            }
  gtotal=parseFloat(final_total)+parseFloat($('#gstvalue').val());
            
     $('#tot_amt').val(Math.abs(gtotal));
        } else { 
            gstvalue=$('#gstvalue').val(); 
            gtotal=parseFloat(sum)+parseFloat($('#gstvalue').val());
            
$('#tot_amt').val(gtotal);
        }
        });







        $("input").click(function () {
            $(this).next().show();
            $(this).next().hide();
        });

$('#remove_task').click(function () {


    alert('wer');
   $(this).parent().remove();
                    re_assing_serial();
        });

        $('#add_task').click(function () {


            var data = $('#firsttasktr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Details?")) {
                    $(this).parent().remove();
                    re_assing_serial();

                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#task_table tbody').append(data);
            $('.usedatepicker').datepicker({
                autoclose: true
            });


            re_assing_serial();

        });

        $('#add_proof').click(function () {


            var data = $('#firstprooftr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Proof?")) {
                    $(this).parent().remove();
                    re_assing_serial();

                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#proof_table tbody').append(data);
            $('.usedatepicker').datepicker({
                autoclose: true
            });


            re_assing_serial();

        });



    });

    function del_addi(elem) {
        if (confirm("Are you sure want to remove this?")) {
            elem.parent().parent().remove();
            additionalprice();
        }
    }





    function re_assing_serial() {
        $("#task_table tbody tr").not('#firsttasktr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
        $("#proof_table tbody tr").not('#firstprooftr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
    }

 function delrecss1(elem, id,billno) {
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();
              window.location.href = "<?php echo $sitename; ?>pages/process/addsales_order.php?delsttaus=temp&delidss1=" + id + "&salesorder_billno="+ billno;
         
        }
    }

    function delrec1(elem, id,lid) {
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();
 <?php if($_REQUEST['lid']!='') { ?>
            window.location.href = "<?php echo $sitename; ?>process/<?php echo $_REQUEST['lid']; ?>/editsales_order.htm?delid1=" + id;
            <?php }  elseif($lid!='') { ?>
            window.location.href = "<?php echo $sitename; ?>process/<?php echo $lid; ?>/editsales_order.htm?delid1=" + id;
            <?php }  else { ?>
              window.location.href = "<?php echo $sitename; ?>process/addsales_order.htm?delid1=" + id;
            <?php } ?>
        }
    }

    function interest_calculation() {
        var interest_amount = $('#amount').val();
        var interest_percent = $('#interestpercent').val();
        var a = (interest_percent / 100);
        // alert(a);
        var interest_total = interest_amount - (interest_amount * a);
        // alert(interest_total);
        document.getElementById('interest').value = interest_total;
        // $('#interest').html(interest_total);
    }

    function customer(a) {

        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/ajax_page.php",
            data: {customerid: a},
            success: function (data) {
                $("#customerdetail").html(data);
                $("#customerid").val(a);

            }
        });
    }

    function quantitycalculation(a) {
//            document.getElementById('qtyhidden').value = a;
//            var total = 0;
        var hidden1 = $('#qtyhidden').val();
        var c = +a + +hidden1;
        document.getElementById('qtyhidden').value = c;
        document.getElementById('totalquantity').value = c;
    }



</script>

<script type="text/javascript">
    $(document).ready(function () 
{
      $("#billtype").change(function () {
    var billno = this.value;
      if(billno==='1') {
        $("#bil1").css("display", "none");
         $("#bil2").css("display", "none");
          $("#bil3").css("display", "none");
           $("#bil4").css("display", "none");
      }
      else {
 $("#bil1").css("display", "block");
         $("#bil2").css("display", "block");
          $("#bil3").css("display", "block");
           $("#bil4").css("display", "block");
  }
});


   $("#gsttype").change(function () {
    var billno = this.value;
      if(billno==='1') {
        $("#gstdisp").css("display", "block");
        $("#gstdisp1").css("display", "block");
      }
      else {
 $("#gstdisp").css("display", "none");
 $("#gstdisp1").css("display", "none");
  }
});



            $("#chkRead").change(function () {

                if ($(this).is(":checked")) 
                {
                    $('#bill_no').removeAttr("readonly")
                }
                else 
                {
                    $('#bill_no').attr('readonly', true);
                }
            });
        });
    $(document).ready(function()
    {
  $("#manual").click(function()
  {
    var a = $("#bill_no").val();
    var b = $("#manual").text();
    
   if(a!="")
   {
    if(b=="Manual Bill")
    {
    //$("#bill_no").val();
    $("#bill_no").removeAttr("readonly");
    $("#manual").text("Auto BIll");
    }

   }
   if(b!="Manual Bill")
    {
    //$("#bill_no").val();
    $("#bill_no").addAttr("readonly");
    $("#manual").text("Manual BIll");
    }
  });
});

    $("#discount_type").focusout(function()
    {
 var name = $('#discount_type').val();
        //var lastChar = name.slice(-1);
        var value = name.substr(0, 2);;
        
        $("#discount").val(value);
});
    ///////////
    $("#delivery_charge").focusout(function()
    {
 var name = $('#discount_type').val();
 
 var s_tot = parseInt($('#sub_total').val());
 var lastChar = name.slice(-1);
 var value = name.substr(0, 2);
 var tot = s_tot;
 //var discountPrice = $("#discount").val();

 
 var percentage = $('#discount').val();
 var price = tot;
 var calcPrice = price - ( (price/100) * percentage );
 var discountPrice = calcPrice.toFixed(2);
 $("#tot_amt").val(discountPrice);
});
function getordertype(a) {
        $.post("<?php echo $sitename; ?>config/functions_ajax.php", {ordermethod: a},
                function (data) {
                    //alert(data);
                    $('#order_type').html(data);
                });
    }
    
</script>


   