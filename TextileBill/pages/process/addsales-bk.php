<?php
if (isset($_REQUEST['lid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "3,3,44";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
if (isset($_REQUEST['createaccount'])) {
	global $db;
    @extract($_REQUEST);
	
	
	$status=1;
$resa = $db->prepare("INSERT INTO `customer` (`cusid`,`name`,`mobileno`,`object`,`idproof`,`address`,`status`) VALUES(?,?,?,?,?,?,?)");
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

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['lid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
	
    $object1 = implode(',', $objectval);
    $quantity1 = implode(',', $quantity);
    $rate1 = implode(',', $rate);
    $total1 = implode(',', $total);
	$oid1 = implode(',', $oid);
//    print_r($object1);
//    exit;

    $customerid1 = FETCH_all("SELECT  * FROM `customer` WHERE `id`=?", $cusid);

    $customerid = $customerid1['cusid'];
// $object11 = ltrim($object1, ',');
// $quantity11 = ltrim($quantity1, ',');
    $msg = addsales1($order_method,$oid1,$payment_mode,$customer_name, $order_type, $date, $bill_no,$object1, $quantity1, $rate1, $total1, $given_amt, $balance_amt,$sub_total,$discount,$packing_charge,$delivery_charge,$tot_amt,$getid);
}

if (isset($_REQUEST['lid']) && ($_REQUEST['lid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `online_order_deatils` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['lid'];
   if($_REQUEST['lid']!='') { 
    echo '<script>window.location.href="' . $sitename . 'process/' + $_REQUEST['lid'] + '/editstoreorder.htm"</script>';
	}else{
	   echo '<script>window.location.href="' . $sitename . 'process/addstoreorder.htm"</script>';	
	}
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
            <li><a href="<?php echo $sitename; ?>pages/process/onlineorder.php"><i class="fa fa-circle-o"></i> Online Order</a></li>
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
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['lid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Online Order </h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-2" >
						<table width="100%">
						<tr>
						<td colspan="2"><label>Customer name</label></td>
						</tr>
						<tr>
						<td  style="margin-top: 5px;">
						<input type="hidden" id="lid" value="<?php echo $_REQUEST['lid']; ?>">
						
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
							 <select name="customer_name" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> id="supplierid" class="form-control select2"  style="font-weight: bold; font-size:13px;width:fit-content;">
							 <option value="">Store</option>
                             <?php
$customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['id']; ?>" <?php if(getsales("supplierid", $_REQUEST['lid'])==$customerfetch['id'] || $customerfetch['id']==$_REQUEST['pid']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['name']; ?></option>
<?php } ?>							
							 </select>
							 
                   
						</td>
						<td style="vertical-align:bottom;">
						<?php if($_REQUEST['type']!='view') { ?>
						<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Add Customer</button>
						<?php } ?>
						</td>
						</tr>
						</table>
				
                        </div>
						<div class="col-md-2" style="margin-left:35px;">

                            <label>Order Method <span style="color:#FF0000;">*</span></label>   
<select name="order_method" class="form-control" required="required" onchange="getordertype(this.value);" style="margin-top: 16px;width:fit-content;" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>>
						<option value="">Select</option>
						<option value="1" <?php
                                if (getsales('order_method', $_REQUEST['lid']) == '1') {
                                    echo 'selected';
                                }
                                ?>>Online Order</option>
						<option value="2" <?php
                                if (getsales('order_method', $_REQUEST['lid']) == '2') {
                                    echo 'selected';
                                }
                                ?>>Store Order</option>
						</select>							
							</div>
                        <div class="col-md-2">

                            <label>Order Type <span style="color:#FF0000;">*</span></label>                                  
                            <select name="order_type" id="order_type" required="required" class="form-control" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> style="margin-top: 14px;width:fit-content;">
							<?php if (getsales('order_method', $_REQUEST['lid']) == '1') { ?>
                                <option value="1" <?php
                                if (stripslashes(getsales('order_type', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Vendor Order</option>
                                <option value="0" <?php
                                if (stripslashes(getsales('order_type', $_REQUEST['lid']) == '0')) {
                                    echo 'selected';
                                }
                                ?>>Phone Order</option>
							<?php } else if (getsales('order_method', $_REQUEST['lid']) == '2') {  ?>
							<option value="1" <?php
                                if (stripslashes(getsales('order_type', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Dinnig Order</option>
                                <option value="0" <?php
                                if (stripslashes(getsales('order_type', $_REQUEST['lid']) == '0')) {
                                    echo 'selected';
                                }
                                ?>>Take Away</option>
							<?php } else { ?>
							<option value="">Select</option>
							<?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Date<span style="color:#FF0000;">*</span></label>
                            <div class="input-group date" style="margin-top: 14px;">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                                if (isset($_REQUEST['lid']) && (date('d-m-Y', strtotime(getsales('date', $_REQUEST['lid']))) != '01-01-1970')) {
                                    echo date('d-m-Y', strtotime(getsales('date', $_REQUEST['lid'])));
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?>" >
                            </div>  
                        </div>
						
						
						<div class="col-md-2">
						<table width="100%">
						<tr>
						<td colspan="2"><label>Bill Number<span style="color:#FF0000;">*</span></label>
						<?php if($_REQUEST['type']!='view') { ?>
						&nbsp;&nbsp;&nbsp;<label>Manual Bill</label>&nbsp;<input type="checkbox" name="" id="chkRead"> 
							    <div style="display:block;" id="bilresult11"></div>
					
					<?php } ?>
								</td>
						</tr>
						<tr>
						<td colspan="2"><input type="text" class="form-control"  readonly=""  name="bill_no" id="bill_no" style="width:fit-content;" required="required"  value="<?php if($_REQUEST['lid']!=''){ echo getsales('bill_number',$_REQUEST['lid']); } else { $customerid1 = FETCH_all("SELECT  * FROM `online_order` WHERE `id`!=? ORDER BY `id` DESC", 0);
                                echo $customerid1['bill_number'] + 1;
								}
                                 ?>"></td>
						
						
						</tr>
						</table>
                            
                            <!--  Manual Bill:<input type="checkbox" name="" id="chkRead"> -->
                           
                               
                              
                            </div> 

						</div>
						<br>
						
						
                   <!-- <div class="clearfix"><br /></div> -->
                   
				   <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table width="80%" class="table table-bordered" id="task_table" cellpadding="0"  cellspacing="0">
                                            <thead>
                                                <tr style="font-size:13px;font-weight:bold;">
                                                    <th width="5%">S.no</th>
                                                    <th width="20%">Product</th>
                                                    <th width="10%">Quantity</th>
                                                    <th width="10%">Rate</th>
                                                    <th width="10%">Total</th>
                                                    <!--<th width="55%">Image</th>-->
                                                    <th width="5%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody><?php
                                                $b = 1;
                                                $object1 = $db->prepare("SELECT * FROM `online_order_deatils` WHERE `object_id`= ?");
                                                $object1->execute(array($_REQUEST['lid']));
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
</td>
                                                           
        <td style="border: 1px solid #f4f4f4;">
		<input type="hidden" name="oid[]" value="<?php echo $object1list['id']; ?>">
		<input type="text" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>  style="text-align: right;" name="quantity[]" id="quantity[]" pattern="[0-9]+" class="form-control quantity" value="<?php echo $object1list['qty']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>
        <td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="rate[]" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>  id="rate[]" class="form-control rate" value="<?php echo $object1list['rate']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="ratehidden" id="ratehidden" value="" /></td>
        <td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="total[]" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>  id="total[]" class="form-control total" value="<?php echo $object1list['total']; ?>" onkeyup="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>

                                                            <td <?php if($_REQUEST['type']!='view') { ?>  onclick="delrec1($(this), '<?php echo $object1list['id']; ?>')"  <?php } ?> style="border: 1px solid #f4f4f4;"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
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
													<input type="hidden" name="oid[]" value="">
													<input type="text" name="objectval[]" id="objectval" class="form-control objectchange">
                                                       
                                                           <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                    </td>
<td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control quantity" value="" /><input type="hidden" name="qtyhidden" id="qtyhidden" pattern="[0-9]+" onkeyup="quantitycalculation(this.value)"/></td>

                                                    
<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="rate[]" id="rate[]" class="form-control rate" value="" /><input type="hidden" name="ratehidden" id="ratehidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="total[]" id="total" class="form-control total"/><input type="hidden" name="totalhidden" id="totalhidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

                                                    <!--<td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>-->
                                                </tr>
                                        
										        <tr id="firsttasktr" style="display:none">
                                                    <td>1</td>
                                                    <td>
													<input type="hidden" name="oid[]" value="">
													<input type="text" name="objectval[]" id="objectval" class="form-control objectchange">
                                                       
                                                           <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                    </td>
<td style="border: 1px solid #f4f4f4;"><input type="text" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control quantity" value="" /><input type="hidden" name="qtyhidden" id="qtyhidden" pattern="[0-9]+" onkeyup="quantitycalculation(this.value)"/></td>

                                                    
<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="rate[]" id="rate[]" class="form-control rate" value="" /><input type="hidden" name="ratehidden" id="ratehidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="total[]" id="total" class="form-control total"/><input type="hidden" name="totalhidden" id="totalhidden" value="" onkeyup="quantitycalculation(this.value)"/></td>

                                                    <!--<td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>-->
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr><td colspan="6"></td></tr>
                                                <tr>
                                                    <td colspan="1" style="border:0;">
													<?php if($_REQUEST['type']!='view') { ?>  
													<button type="button" class="btn btn-info" style="background-color: #00a65a;border-color: #008d4c;" id="add_task">Add Item</button>
													<?php } ?>
													</td>
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
<div class="col-md-6">
<table width="100%" style="width:500px;font-size:13px; font-weight:bold;" align="left">
<tr>
  <td>Due Amount:</td>
    <td><input type="text" name="given_amt" id="given_amt" value="<?php echo stripslashes(getsales("given_amnt", $_REQUEST['lid'])); ?>" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?>></td>
   </tr>
  <tr>
    <td>Balance Amount:</td>
    <td><input type="text" name="balance_amt" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> id="balance_amt" value="<?php echo getsales("balance_amnt", $_REQUEST['lid']); ?>"></td>
    
  </tr>
  <tr>
  <td colspan="2">&nbsp; </td>
  </tr>
   <tr>
    <td>Payment Mode:</td>
    <td>
	<select name="payment_mode" class="form-control" required="required" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?>>
	<option value="">Select</option>
	<option value="Cash Payment" <?php if(trim(getsales('payment_mode',$_REQUEST['lid']))=='Cash Payment') { ?> selected="selected" <?php } ?>>Cash Payment</option>
	<option value="Card Payment" <?php if(trim(getsales('payment_mode',$_REQUEST['lid']))=='Card Payment') { ?> selected="selected" <?php } ?>>Card Payment</option>
	<option value="UPI Payment" <?php if(trim(getsales('payment_mode',$_REQUEST['lid']))=='UPI Payment') { ?> selected="selected" <?php } ?>>Google Pay</option>
	</select>
	
	</td>
  </tr>
</table>
</div>
<div class="col-md-6">

<table border="1" cellpadding="10" style="width:372px;font-size:13px; font-weight:bold;" align="right">
</div>
</div>
 


  
  <tr>
    <td>Sub Total:</td>
    <td><input type="text" name="sub_total" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> id="sub_total" readonly value="<?php echo stripslashes(getsales("sub_tot", $_REQUEST['lid'])); ?>"></td>
  </tr>
  <tr>
   <td>Discount:</td>
    <td><input type="text" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="discount" id="discount" value="<?php echo stripslashes(getsales("discount", $_REQUEST['lid'])); ?>"></td>
    
  </tr>
  <tr>
     <td>Packing Charges:</td>
    <td><input type="text" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="packing_charge" id="packing_charge" value="<?php echo stripslashes(getsales("packing_charges", $_REQUEST['lid'])); ?>"></td>
    
  </tr>
   <tr>
   
   
    <td>Delivery Charges:</td>
    <td><input type="text" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> name="delivery_charge" id="delivery_charge" value="<?php echo stripslashes(getsales("delivery_charges", $_REQUEST['lid'])); ?>"></td>
    
  </tr>
   <tr>
 
 
    <td style="color:blue; font-size:22px;">Grand Total:</td>
    <td><input type="text" name="tot_amt" <?php if($_REQUEST['type']=='view') { ?>  readonly="readonly" <?php } ?> id="tot_amt" value="<?php echo stripslashes(getsales("total_amnt", $_REQUEST['lid'])); ?>"></td>
    
  </tr>
 </table>
                        
                     
                 <!--   <div class="row">
                        <div class="col-md-4">
                            <label>Discount(%/Rs)<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="discount_type" id="discount_type" placeholder="Enter Discount" class="form-control" value="<?php echo stripslashes(getsales("netweight", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4">
                            <label>Sub Total <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Sub Total" class="form-control" value="<?php echo stripslashes(getsales("amount", $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <!--  <div class="col-md-4">

                            <label>Status <span style="color:#FF0000;">*</span></label>                                  
                            <select name="status" class="form-control">
                                <option value="1" <?php
                                if (stripslashes(getsales('status', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if (stripslashes(getsales('status', $_REQUEST['lid']) == '0')) {
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
                            <a href="<?php echo $sitename; ?>pages/process/onlineorder.php" target="_blank" style="font-size:19px;">Back to Listings page</a>
                        </div>
						<div class="col-md-4">
						<?php if($_REQUEST['lid']!='') { ?>
						 <a href="<?php echo $sitename; ?>MPDF/bill.php?id=<?php echo $_REQUEST['lid']; ?>" style="font-size:19px;"><button type="button" name="print" id="submit" class="btn btn-success" style="float:right;">PRINT</button></a>
						<?php } ?>
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
            </div><!-- /.box -->
        </form>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
				var rateval=result;
				  $this.parent().parent().find('.rate').val(rateval);
			})

    return false;
   }
  });
  
	
			
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
		packing_charge=$(this).parent().siblings('td').find('.packing_charge').val();
		delivery_charge=$(this).parent().siblings('td').find('.delivery_charge').val();
		final_total=sum;
		if(discount!=='') {
		final_total = (parseFloat(sum) - parseFloat(discount)) + Number(packing_charge) + Number(delivery_charge);
		}
		given_amnt=$(this).parent().siblings('td').find('#given_amnt').val();
		balance_amnt=$(this).parent().siblings('td').find('#balance_amnt').val();
			if(given_amnt!=='') {
				gfinal_total = (parseFloat(final_total) - parseFloat(given_amnt))
			$('#balance_amnt').val(gfinal_total);
			}

			
	 $('#tot_amt').val(Math.abs(final_total));
		} else { 
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


 $(document).on('keyup', '.discount', function (e){
	 
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
		if($('#lid').val()!=='') {
		discount=$('#discount').val();
		packing_charge=$('#packing_charge').val();
		delivery_charge=$('#delivery_charge').val();
		final_total=sum;
		if(discount!=='') {
			
		final_total = (parseFloat(sum) - parseFloat(discount)) + Number(packing_charge) + Number(delivery_charge);
		}
		given_amnt=$('#given_amt').val();
		balance_amnt=$('#balance_amt').val();
			if(given_amnt!=='') {
				
				
			gfinal_total = (parseFloat(final_total) - parseFloat(given_amnt));
			$('#balance_amt').val(gfinal_total);
			}

			
	 $('#tot_amt').val(Math.abs(final_total));
		} else { 
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

    function delrec1(elem, id) {
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();
 <?php if($_REQUEST['lid']!='') { ?>
            window.location.href = "<?php echo $sitename; ?>process/<?php echo $_REQUEST['lid']; ?>/editsales.htm?delid1=" + id;
			<?php } else { ?>
			  window.location.href = "<?php echo $sitename; ?>process/addsales.htm?delid1=" + id;
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
function getordertype(a) {
	    $.post("<?php echo $sitename; ?>config/functions_ajax.php", {ordermethod: a},
                function (data) {
					//alert(data);
                    $('#order_type').html(data);
                });
    }
	
</script>


   