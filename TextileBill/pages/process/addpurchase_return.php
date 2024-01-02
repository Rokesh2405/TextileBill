<?php
if (isset($_REQUEST['lid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "46,46,2";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
if (isset($_REQUEST['createaccount'])) {
    global $db;
    @extract($_REQUEST);
        
    $status=1;
$resa = $db->prepare("INSERT INTO `supplier` (`shopname`,`suppliername`, `area`,`mobileno`,`status`,`date`,`ip`) VALUES(?,?,?,?,?,?,?)");
            $resa->execute(array($shopname, $suppliername , $area, $mobileno,$status,date('Y-m-d'),$ip));
            
 $insid = $db->lastInsertId();    
$url="addpurchase_return.htm?pid=".$insid; 
  echo "<script>window.location.assign('".$url."')</script>";  

}
 if ($_REQUEST['lid'] != '') {
$lid=$_REQUEST['lid'];
 $link22 = FETCH_all("SELECT * FROM `purchasereturn` WHERE `id`=?", $lid);   
 }

 if(isset($_REQUEST['purchaseorder_billno'])) {
 global $db;
@extract($_REQUEST);

$als = FETCH_all("SELECT * FROM `purchasereturn` WHERE `bill_number`=?", $purchaseorder_billno);
if($als['id']!='') {
$link22 = FETCH_all("SELECT * FROM `purchasereturn` WHERE `id`=?", $als['id']); 
$lid=$link22['id'];  
}
else
{
$link22 = FETCH_all("SELECT * FROM `purchaseorder` WHERE `bill_number`=?", $purchaseorder_billno);    
}

}


if(isset($_REQUEST['search'])) {
 global $db;
@extract($_REQUEST);
$als = FETCH_all("SELECT * FROM `purchasereturn` WHERE `bill_number`=?", $purchaseorder_billno);
if($als['id']!='') {
$link22 = FETCH_all("SELECT * FROM `purchasereturn` WHERE `id`=?", $als['id']);   
$lid=$link22['id'];  
}
else
{
   
$link22 = FETCH_all("SELECT * FROM `purchaseorder` WHERE `bill_number`=?", $purchaseorder_billno);    
}
}

if (isset($_REQUEST['delidss1']) && $_REQUEST['delidss1'] != '') {
    $up = $db->prepare("DELETE FROM `temp_purchase_detail` WHERE `id`=?");
    $up->execute(array($_REQUEST['delidss1']));
    

$object1 = $db->prepare("SELECT * FROM `temp_purchase_detail` WHERE `object_id`= ?");
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
    $tobjects = $db->prepare("SELECT SUM(`amount`) AS `totsub` FROM `temp_purchase_detail` WHERE `object_id`= ?");
$tobjects->execute(array($link22['id']));
$tobject1 = $tobjects->fetch(PDO::FETCH_ASSOC);
$subtotal=$tobject1['totsub'];
$discount=$link22['discount'];
$gtotal=($subtotal-$discount);
$advanceamt=$link22['advance_amnt'];
$balcamt=$gtotal-$link22['balance_amount'];    
}


       echo '<script>window.location.href="' . $sitename . 'pages/process/addpurchase_return.php?delsttaus=temp&purchaseorder_billno=' . $_REQUEST['purchaseorder_billno'] . '"</script>';   
 
}


if($_REQUEST['delsttaus']=='temp') {
       $tobjects = $db->prepare("SELECT SUM(`amount`) AS `totsub` FROM `temp_purchase_detail` WHERE `object_id`= ?");
$tobjects->execute(array($link22['id']));
$tobject1 = $tobjects->fetch(PDO::FETCH_ASSOC);
$subtotal=$tobject1['totsub'];
$discount=$link22['discount'];
$gtotal=($subtotal-$discount);
$advanceamt=$link22['advance_amnt'];
$balcamt=$gtotal-$link22['balance_amount'];    
}



$exerecord = FETCH_all("SELECT * FROM `purchasereturn` WHERE `bill_number`=?", $link22['bill_number']);   


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['purid'];
    $ip = $_SERVER['REMOTE_ADDR'];

 $oid1 = implode(',', $oid);
    $object1 = implode(',', $objectval);
    $quantity1 = implode(',', $quantity);
    $rate1 = implode(',', $rate);
    $style1 = implode(',', $style);
      $meter1 = implode(',', $meter);
       $orgrate1 = implode(',', $orgrate);
      $mrp_price1 = implode(',', $mrp_price);
    $tamount1 = implode(',', $total);
   
 $hsn1 = implode(',', $hsn);
    $customerid1 = FETCH_all("SELECT  * FROM `customer` WHERE `id`=?", $cusid);

    $customerid = $customerid1['cusid'];
// $object11 = ltrim($object1, ',');
// $quantity11 = ltrim($quantity1, ',');
$msg = addpurchasereturn($style1,$meter1,$orgrate1,$mrp_price1,$hsn1,$oid1,$bill_no,$supplierid, $date, $netweight, $amount, $status,$object1, $quantity1,$rate1,$tamount1, $sub_total,$discount,$tot_amt,$payment_type,$advance_amount,$balance_amount,$getid);
}

if (isset($_REQUEST['lid']) && ($_REQUEST['lid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `purchasereturn_object_detail` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['lid'];
    if($_REQUEST['lid']!='') { 
    echo '<script>window.location.href="' . $sitename . 'process/' + $_REQUEST['lid'] + '/editpurchase_return.htm"</script>';
    }else{
       echo '<script>window.location.href="' . $sitename . 'process/addpurchase_return.htm"</script>'; 
    }
    
//    echo '<script>window.location.href="' . $sitename . 'process/' + $_REQUEST['lid'] + 'editpurchase.htm"</script>';
}
?>

<style>
    #task_table input {
    border: none;
    box-shadow: none;
}
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
        font-size:13px;
        font-weight:bold;
    }
    label{
        font-size:13px;
    }
    input{
        font-style:bold;
    }
</style>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Purchase
            <small><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Purchase</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Purchase(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>pages/process/purchase_return.php"><i class="fa fa-circle-o"></i> Purchase Return</a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Purchase Return</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['lid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Purchase Return</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                      <?php  if ($_REQUEST['lid'] == '') { ?>
                    <form name="searchform" method="post">
                     <div class="row">
                        <div class="col-md-4">
                        <label>Purchase Order Bill No</label>
                        <input type="text" name="purchaseorder_billno" id="purchaseorder_billno" class="form-control" value="<?php echo $_REQUEST['purchaseorder_billno']; ?>">
                        </div>
                         <div class="col-md-4">
                            <br>
                            <button type="submit" name="search" id="search" class="btn btn-success">SEARCH</button>
                         </div>
                     </div> 
                 </form>
             <?php } ?>
              <div class="row">
   <div class="col-md-12" <?php if((isset($_REQUEST['search']) || $_REQUEST['lid']!='') && $link22['id']!='') { ?> style="display: block;" <?php } else { ?> style="display: none;" <?php } ?> >
               <form name="department" id="department"  method="post" enctype="multipart/form-data">
                 <div class="row">
    <div class="col-md-12">
          
                    <div class="row">
                        <div class="col-md-4">
                           <input type="hidden" id="lid" value="<?php echo $_REQUEST['lid']; ?>">
                            <input type="hidden" name="purid" id="purid" value="<?php echo $exerecord['id']; ?>">
                           <table width="100%">
                        <tr>
                        <td valign="top">
                        <label>Supplier Name<span style="color:#FF0000;">*</span></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                             <select name="supplierid" id="supplierid" class="form-control select2" required="required" style="font-size: 19px;font-weight: bold;">
                             <option value="">Select</option>
                             <?php
$customer = pFETCH("SELECT * FROM `supplier` WHERE `status`=?", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['id']; ?>" <?php if($link22['supplierid']==$customerfetch['id']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['suppliername']; ?></option>
<?php } ?>                          
                             </select>
                             
                   
                        </td>
                        <td style="vertical-align:bottom;"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Add Supplier</button></td>
                        </tr>
                        </table>
                
                
                        </div>

                        <div class="col-md-4" style="margin-top: 10px;">
                            <label>Date<span style="color:#FF0000;">*</span></label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                                if (isset($_REQUEST['lid']) && (date('d-m-Y', strtotime($link22['date'])) != '01-01-1970')) {
                                    echo date('d-m-Y', strtotime($link22['date']));
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?>" >
                            </div>  
                        </div>
                         
                            <div class="col-md-4" style="margin-top: 10px;">
                            <label>Reference Bill Number<span style="color:#FF0000;">*</span></label>
                            <!--  Manual Bill:<input type="checkbox" name="" id="chkRead"> -->
                            
                                <input type="text" class="form-control"name="bill_no" id="bill_no" required="required" value="<?php if($_REQUEST['purchaseorder_billno']!='') { echo $_REQUEST['purchaseorder_billno']; } else { echo $link22['bill_number']; } ?>" readonly="readonly">                                
                          
                        </div>
                  
                  
</div>             
                    <!-- <div class="clearfix"><br /></div> -->
                   
                  
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table width="80%" class="table table-bordered" id="task_table" cellpadding="0"  cellspacing="0">
                                            <thead>
                                                <tr style="font-size:13px;">
                                                    <th width="5%">S.no</th>
                                                    <th width="20%">Product</th>
                                                     <th width="8%">HSN</th>
                                                     <th width="15%">Style & Pattern</th>
                                                     <th width="8%">Meter</th> 
                                                     <th width="10%">Quantity</th>
                                                    <th width="10%">Rate</th>
                                                    <th width="15%">Total</th>
                                                    <!--<th width="55%">Image</th>-->
                                                    <th width="5%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $b = 1;
                                             if($_REQUEST['delsttaus']=='temp') {
                                                   
$object1 = $db->prepare("SELECT * FROM `temp_purchase_detail` WHERE `object_id`= ?");
                                                }
                                                else if($exerecord['id']!='') {
                                                $object1 = $db->prepare("SELECT * FROM `purchasereturn_object_detail` WHERE `object_id`= ?");
                                                }
                                                else {
   $objectsss1 = $db->prepare("SELECT * FROM `purchaseorder_object_detail` WHERE `object_id`= ?"); 
                                                  $objectsss1->execute(array($link22['id']));  
                                                  while ($objectsss1list = $objectsss1->fetch(PDO::FETCH_ASSOC)) 
                                                    {
                                                  
$getrecr = FETCH_all("SELECT * FROM `temp_purchase_detail` WHERE `productid`=?", $objectsss1list['productid']);   
if($getrecr['id']==''){
                                                    $hsn=$objectsss1list['hsn'];
                                                    $object_id=$objectsss1list['object_id'];
                                                    $productid=$objectsss1list['productid'];
                                                    $bill_no=$objectsss1list['id'];
                                                    $product_name=$objectsss1list['object'];
                                                     $rate=$objectsss1list['rate'];
                                                     $style=$objectsss1list['style'];
                                                     $meter=$objectsss1list['meter'];
                                                     $orgrate=$objectsss1list['orgrate'];
                                                     
                                                      $mrp_price=$objectsss1list['mrp_price'];
                                                      $total=$objectsss1list['amount'];
                                                    $qty=$objectsss1list['pquantity'];

                                                     $resa = $db->prepare("INSERT INTO `temp_purchase_detail` (`style`,`meter`,`orgrate`,`mrp_price`,`productid`,`hsn`,`object_id`,`object`,`pquantity`,`rate`,`amount`) VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
            $resa->execute(array($style,$meter,$orgrate,$mrp_price,$productid,$hsn,$object_id,$product_name,$qty,$rate,$total));
}

                                                    }
  $object1 = $db->prepare("SELECT * FROM `temp_purchase_detail` WHERE `object_id`= ?");
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
                                                              <input type="text" name="objectval[]" id="objectval" class="form-control objectchange" value="<?php echo $object1list['object']; ?>">
                                                              
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

        <td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="quantity[]" id="quantity[]" pattern="[0-9]+" class="form-control quantity" value="<?php echo $object1list['pquantity']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>
        

        <td style="border: 1px solid #f4f4f4;">
<input type="hidden" style="text-align: right;" name="mrp_price[]" readonly="readonly" id="mrp_price" class="form-control mrp_price" value="<?php echo $object1list['mrp_price']; ?>" /><input type="hidden" style="text-align: right;" name="orgrate[]" readonly="readonly"  id="orgrate[]" class="form-control orgrate" value="<?php echo $object1list['orgrate']; ?>"/>

            <input type="text" style="text-align: right;" name="rate[]" id="rate[]" readonly="readonly" class="form-control rate" value="<?php echo $object1list['rate']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="ratehidden" id="ratehidden" value="" /></td>

       
        <td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="total[]" id="total[]" class="form-control total" value="<?php echo $object1list['amount']; ?>" onkeyup="quantitycalculation(this.value)"/>
        <input type="hidden" name="oid[]" value="<?php echo $object1list['id']; ?>">
        <input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>

                                                           <?php if($exerecord['id']!='') { ?>
                                                            <td <?php if($_REQUEST['type']!='view') { ?>  onclick="delrec1($(this), '<?php echo $object1list['id']; ?>','<?php echo $lid; ?>')"  <?php } ?>><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                        <?php } else {
                                                            ?>
                                                                    <td <?php if($_REQUEST['type']!='view') { ?>  onclick="delrecss1($(this), '<?php echo $object1list['id']; ?>','<?php echo $_REQUEST['purchaseorder_billno']; ?>')"  <?php } ?>><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                        <?php                                                     } ?>
                                                        </tr>
                                                        <?php
                                                        $b++;
                                                    }
                                                }
                                                ?>
                                                
                                                <tr id="firsttasktr" style="display:none;">
                                                    <td>1</td>
                                                    <td>
                                                    <input type="hidden" name="oid[]">
                                                      <input type="text" name="objectval[]" id="objectval" class="form-control objectchange">
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

<td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control quantity" value="" /><input type="hidden" name="qtyhidden" id="qtyhidden" pattern="[0-9]+" onkeyup="quantitycalculation(this.value)"/></td>

                                            
<td style="border: 1px solid #f4f4f4;">
<input type="hidden" style="text-align: right;" name="mrp_price[]" readonly="readonly" id="mrp_price" class="form-control mrp_price" value="" />
<input type="hidden" style="text-align: right;" name="orgrate[]" readonly="readonly"  id="orgrate[]" class="form-control orgrate"/>

    <input type="number" style="text-align: right;" name="rate[]" id="rate[]" class="form-control rate" readonly="readonly" /><input type="hidden" name="ratehidden" id="ratehidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="total[]" id="total" class="form-control total"/><input type="hidden" name="totalhidden" id="totalhidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

                                                    <!--<td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>-->
                                                </tr>
                                                
                                                <tr id="firsttasktr1">
                                                    <td><?php echo $b; ?></td>
                                                    <td>
                                                    <input type="hidden" name="oid[]">
                                                    <input type="text" name="objectval[]" id="objectval" class="form-control objectchange">
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
<td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control quantity" value="" /><input type="hidden" name="qtyhidden" id="qtyhidden" pattern="[0-9]+" onkeyup="quantitycalculation(this.value)"/></td>
                     
<td style="border: 1px solid #f4f4f4;">

<input type="hidden" style="text-align: right;" name="mrp_price[]"  readonly="readonly" id="mrp_price" class="form-control mrp_price" />
 <input type="hidden" style="text-align: right;" name="orgrate[]" readonly="readonly"  id="orgrate[]" class="form-control orgrate" />


    <input readonly="readonly" type="number" style="text-align: right;" name="rate[]" id="rate[]" class="form-control rate" value="" /><input type="hidden" name="ratehidden" id="ratehidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="total[]" id="total" class="form-control total"/><input type="hidden" name="totalhidden" id="totalhidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

                                                    <!--<td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>-->
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr><td colspan="9"></td></tr>
                                                <tr>
                                                    <td colspan="9" style="border:0;"><button type="button" class="btn btn-info" style="background-color: #00a65a;border-color: #008d4c;" id="add_task">Add Item</button></td>
                                                    <!--<td style="text-align:right;"> <label>Total Quantity </label> </td>-->
                                                    <!--<td><input type="number" style="text-align: right;font-size: 19px;" name="totalquantity" id="totalquantity" value="<?php echo getpurchase('totalquantity', $_REQUEST['lid']); ?>" /></td>-->
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
<div class="col-md-12">
<table border="1" cellpadding="10" style="width:500px;font-size:13px; font-weight:bold;" align="right">

  
  <tr>
    <td>Sub Total:</td>
    <td><input type="text" class="form-control" name="sub_total" id="sub_total" readonly placeholder="subtotal" value="<?php if($subtotal!='') { echo $subtotal; } else { echo stripslashes($link22['sub_total']); } ?>"></td>
  </tr>
  <tr>
   <td>Discount:</td>
    <td><input type="text" class="form-control" name="discount" id="discount" value="<?php if($discount!='') { echo $discount; } else { echo stripslashes($link22['discount']); } ?>"></td>
    
  </tr>
  
   <tr>
 
 
    <td>Grand Total:</td>
    <td><input type="text" class="form-control" name="tot_amt" id="tot_amt" placeholder="Total Amount" value="<?php if($gtotal!='') { echo $gtotal; } else { echo stripslashes($link22['tot_amt']); } ?>"></td>
    
  </tr>
  
  
</table>
  </div>    </div>                     
                      
                      
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
                        <div class="col-md-4">
                            <label>Payment Type <span style="color:#FF0000;">*</span></label>
                            <select name="payment_type" id="payment_type" class="form-control" required="required">
                            <option value="">select</option>
                                <option value="1" <?php
                                if ($link22['payment_type'] == '1') {
                                    echo 'selected';
                                }
                                ?>>Cash Bill</option>
                                <option value="0" <?php
                                if ($link22['payment_type'] == '0') {
                                    echo 'selected';
                                }
                                ?>>Credit Bill</option>

                            </select>
                           <!--  <input type="text" name="" value="<?php echo getpurchase("payment_type", $_REQUEST['lid']) ?>"> -->
                        </div>
                        <div class="col-md-4" <?php if($link22['payment_type']=='0') { ?> style="display:block" <?php } else { ?> style="display:none" <?php } ?> id="advance">
                            <label>Advance Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" name="advance_amount" id="advance_amount" placeholder="Enter Amount" class="form-control" value="<?php if($advanceamt!='') { echo $advanceamt; } else { echo stripslashes($link22['advance_amount']); } ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4" <?php if($link22['payment_type']=='0') { ?> style="display:block" <?php } else { ?> style="display:none" <?php } ?> id="balance">
                            <label>Balance Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" name="balance_amount" id="balance_amount" placeholder="Enter Amount" class="form-control" value="<?php if($balcamt!='') { echo $balcamt; } else { echo stripslashes($link22['balance_amount']); } ?>"  maxlength="10"/>
                        </div>
                        <!--  <div class="col-md-4">
                             <label>Interest Percent<span style="color:#FF0000;"></span></label>
                             <input type="text" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" onchange="interest_calculation()" value="<?php echo stripslashes(getpurchase("interestpercent", $_REQUEST['lid'])); ?>" />
                         </div> -->

                    </div> <br>
                    <!-- <div class="panel panel-info">
                   <div class="panel-heading">ID Proof Details</div>
                   <div class="panel-body">
                       <div class="row">   
                           <div class="col-md-12">
                               <div class="table-responsive">
                                   <table width="80%" class="table table-bordered" id="proof_table" cellpadding="0"  cellspacing="0">
                                       <thead>
                                           <tr>
                                               <th width="5%">S.no</th>
                                               <th width="10%">Proof Name</th>
                                               <th width="10%">Proof</th>
                                               <th width="5%">Delete</th>
                                           </tr>
                                       </thead>
                                       <tbody>

                               <tr id="firstprooftr" style="display:none;">
                                               <td>1</td>

                                              <td>
                                                  <input type="text" name="proofname[]" id="proofname[]" class="form-control">
                                                 
                                             </td>
                                              
                                             <td><input type="file" name="proof[]" id="proof[]"  class="form-control"></td>
                                             
                                           </tr>


                                       </tbody>
                                       <tfoot>
                                           
                                           <tr><td colspan="2"></td></tr>
                                           <tr>
                                               <td colspan="2" style="border:0;"><button type="button" class="btn btn-info" id="add_proof">Add Proof</button></td>
                                               
                                           </tr>
                                       </tfoot>
                                   </table>

                               </div>                                   
                           </div>
                       </div>
                   </div>

               </div> -->
                    <!-- <div class="clearfix"><br /></div> -->
                    <!-- <div class="row">
                          <div class="col-md-4">
                            <label>Net Weight (in gms) <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="netweight" id="netweight" placeholder="Enter Net Weight" class="form-control" value="<?php echo stripslashes(getpurchase('netweight', $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4">
                            <label>Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getpurchase('amount', $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                         <div class="col-md-4">
                            <label>Interest Percent<span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" value="<?php echo stripslashes(getpurchase('interestpercent', $_REQUEST['lid'])); ?>" />
                        </div>
                       
                    </div> 
                     
                     <br> -->
                    <div class="row">
                        <!-- <div class="col-md-4">
                            <label>Interest <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="interest"  name="interest" placeholder="Enter Interest Amount" class="form-control" value="<?php echo stripslashes(getpurchase('interest', $_REQUEST['lid'])); ?>" />
                        </div> -->
                        <div class="col-md-4">

                            <label>Status <span style="color:#FF0000;">*</span></label>                                  
                            <select name="status" class="form-control">
                                <option value="1" <?php
                                if ($link22['status'] == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if ($link22['status'] == '0') {
                                    echo 'selected';
                                }
                                ?>>Canceled</option>

                            </select>
                        </div>

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
<!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>pages/process/purchase_return.php" style="font-size:19px;">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['lid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
                 </div></div></form>
             </div></div>
            </div><!-- /.box -->
      
    </section><!-- /.content -->
      
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Add New Supplier</strong></h4>
        </div>
        <form name="mform" method="post">
       <div class="row" style="padding:10px;">
                        
                        
                        <div class="col-md-6">
                            <label>Supplier Name <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="suppliername" id="suppliername" placeholder="Enter Supplier Name" class="form-control"/>
                        </div>
                         <div class="col-md-6">
                            <label>Contact Person Name <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="shopname" id="mobileno" placeholder="Enter Contact Person Name" class="form-control"/>
                        </div>
                        </div>
                        <br>
                        <div class="row"  style="padding:10px;">
                        <div class="col-md-6">
                            <label>Mobile No <span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="mobileno" id="area" placeholder="Enter Mobile No" class="form-control" />
                        </div>
                        
                        <div class="col-md-6">
                            <label>Area <span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="city" id="area" placeholder="Enter Area" class="form-control"/>
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

$(document).on('change', '#payment_type', function (e){
var paytype = $(this).val();
if(paytype == 0){
$("#advance").css("display", "block");  
$("#advance_amount").prop('required',true);
$("#balance").css("display", "block");
$("#balance_amount").prop('required',true);
}
else{
$("#advance").css("display", "none");   
$("#advance_amount").prop('required',false);
$("#balance").css("display", "none");   
$("#balance_amount").prop('required',false);
}

});


var count = 0;





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
                     
              //  $('#gstvalue').val(myArray[1]);
            
                 $this.parent().parent().find('#gstresult').val(myArray[2]);
            }
            else
            {
                  $("#gstdisp").css("display", "none");
                    $('#gstvalue').val(0);
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



        $(document).on('keyup', '.quantity', function (e){
            var quantity =  $(this).val();
    var rate = $(this).parent().siblings('td').find('.rate').val();
 
    // alert(quantity);
    // alert(rate);
    // exit;

    var total = rate * quantity;

var gstress=$('#gstvalue').val();
 
  $('#gstresult').each(function(){
    var total=$(this).parent().siblings('td').find('.rate').val()
    var gstres =  $(this).val();
    
        var orggst =   parseFloat(total)*parseFloat(gstres/100);
        if(gstress!='') {
 gstress= parseFloat(gstress)+parseFloat(orggst * quantity);
}
else
{

   gstress= parseFloat(orggst * quantity);  
}
        });


$('#gstvalue').val(gstress);

$(this).parent().siblings('td').find('.total').val(total);


var sum=0;
 
        $('.total').each(function(){
        sum+=Number($(this).val());
        });

        $('#sub_total').val(sum);
       $('#tot_amt').val(sum);
        });

  $(document).ready(function (e) {

$(document).on('keyup', '#given_amt', function (e){
 final_total = parseFloat($('#tot_amt').val()) - parseFloat($(this).val());
     $('#balance_amt').val(Math.abs(final_total));  
});
$(document).on('keyup', '#discount', function (e){
    if($(this).val()!=='') {
      final_total = parseFloat($('#sub_total').val()) - parseFloat($(this).val());
     $('#tot_amt').val(Math.abs(final_total));
    }
    else
    {
     $('#tot_amt').val($('#sub_total').val());  
    }
     
 });
 
 
 $(document).on('keyup', '#advance_amount', function (e){
      final_total = parseFloat($('#tot_amt').val()) - parseFloat($(this).val());
     $('#balance_amount').val(Math.abs(final_total));
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
                data:{purchasebillno:billno}
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
    
        $(document).on('keyup', '.total', function (e){
            var rate =  $(this).parent().siblings('td').find('.rate').val();
    var quantity = $(this).val();

    var total = rate * quantity;

$(this).parent().siblings('td').find('.total').val(total);

var sum=0;
 
        $('.total').each(function(){
        sum+=Number($(this).val());
         
        });

        $('#sub_total').val(sum);
        final_total=sum;
        if($('#lid').val()!=='') {
            discount=$('#discount').val();
            if( parseFloat(discount)!='') {
            final_total = (parseFloat(sum) - parseFloat(discount));
            }
            else{
            final_total = parseFloat(sum);  
            }
            
        $('#tot_amt').val(final_total);
        advance_amount=$('#advance_amount').val();
        balance_amount=$('#balance_amount').val();
            if(advance_amount!=='') {
            gfinal_total = (parseFloat(final_total) - parseFloat(advance_amount));
            $('#balance_amount').val(gfinal_total);
            }
            
        }
        else{
            $('#tot_amt').val(sum);
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

$(this).parent().siblings('td').find('.total').val(total);


var sum=0;
 
        $('.total').each(function(){
        sum+=Number($(this).val());
        });

        $('#sub_total').val(sum);
      final_total=sum;
        if($('#lid').val()!=='') {
            discount=$('#discount').val();
            if( parseFloat(discount)!='') {
            final_total = (parseFloat(sum) - parseFloat(discount));
            }
            else{
            final_total = parseFloat(sum);  
            }
            
        $('#tot_amt').val(final_total);
        advance_amount=$('#advance_amount').val();
        balance_amount=$('#balance_amount').val();
            if(advance_amount!=='') {
            gfinal_total = (parseFloat(final_total) - parseFloat(advance_amount));
            $('#balance_amount').val(gfinal_total);
            }
            
        }
        else{
            $('#tot_amt').val(sum);
        }

        });







        $("input").click(function () {
            $(this).next().show();
            $(this).next().hide();
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

    function delrec1(elem, id,lid) {
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();

             <?php if($_REQUEST['lid']!='') { ?>
            window.location.href = "<?php echo $sitename; ?>process/<?php echo $_REQUEST['lid']; ?>/editpurchase_return.htm?delid1=" + id;
            <?php }  elseif($lid!='') { ?>
            window.location.href = "<?php echo $sitename; ?>process/<?php echo $lid; ?>/editpurchase_return.htm?delid1=" + id;
            <?php }  else { ?>
              window.location.href = "<?php echo $sitename; ?>process/addpurchase_return.htm?delid1=" + id;
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
 var d_charge=parseInt($("#delivery_charge").val());
 var p_charge=parseInt($("#packing_charge").val());
 
 var s_tot = parseInt($('#sub_total').val());
 var lastChar = name.slice(-1);
 var value = name.substr(0, 2);
 var tot = d_charge + p_charge + s_tot;
 //var discountPrice = $("#discount").val();

 
 var percentage = $('#discount').val();
 var price = tot;
 var calcPrice = price - ( (price/100) * percentage );
 var discountPrice = calcPrice.toFixed(2);
 $("#tot_amt").val(discountPrice);
});

    function delrecss1(elem, id,billno) {
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();
              window.location.href = "<?php echo $sitename; ?>pages/process/addpurchase_return.php?delsttaus=temp&delidss1=" + id + "&purchaseorder_billno="+ billno;
         
        }
    }

</script>

