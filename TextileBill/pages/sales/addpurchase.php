<?php
if (isset($_REQUEST['lid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,25";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['lid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($imagename != '') {
        $imagec = $imagename;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    $pimage = getpurchase('image', $getid);

    if ($imag) {
        if ($pimage != '') {
            unlink("../../img/loan/" . $pimage);
            unlink("../../img/loan/thump/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 2000;
        $height = 500;
        $width1 = 1000;
        $height1 = 300;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = strtolower($imagec);
            $imagev = strtolower($m) . "." . $extension;
            $thumppath = "../../img/loan/";
            $filepath = "../../img/loan/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $filepath, $filepath, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['lid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    $o_image = implode(',', $object_image);
    for ($i = 0; $i < count($_FILES['object_image']['name']); $i++) {

        if ($_FILES['object_image']['name'][$i]) {

            $main = $_FILES['object_image']['name'][$i];
            $tmp = $_FILES['object_image']['tmp_name'][$i];
            $extension = getExtension($main);
            $extension = strtolower($extension);
            $m = time() . rand();
            $object_image = $m . "." . $extension;
            move_uploaded_file($tmp, '../../img/object/' . $object_image);


            if ($object_image == '') {
                $object_image1 = $object_image;
            } else {
                $object_image1 .= "," . $object_image;
            }
        }
    }
    // echo 'hiii';
    // print_r($object_image1);
    // exit;
    // $object_image11 = ltrim($object_image1, ',');
    // print_r($object_image1);
    // exit;

    // $proofname1 = implode(',', $proofname);
    // $proof1 = implode(',', $proof);

    $object1 = implode(',', $objectval);
    $quantity1 = implode(',', $quantity);
    $rate1 = implode(',', $rate);
    $tamount1 = implode(',', $tamount);
   

    $customerid1 = FETCH_all("SELECT  * FROM `customer` WHERE `id`=?", $cusid);

    $customerid = $customerid1['cusid'];
// $object11 = ltrim($object1, ',');
// $quantity11 = ltrim($quantity1, ',');
$msg = add_sales_purchase($supplierid, $date, $netweight, $amount, $status,$object1, $quantity1,$rate1,$tamount1, $getid);
}

if (isset($_REQUEST['lid']) && ($_REQUEST['lid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `purchase_object_detail` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['lid'];
//    echo '<script>window.location.href="' . $sitename . 'process/' + $_REQUEST['lid'] + 'editpurchase.htm"</script>';
}
?>

<style>
    .form-control{
        font-size:19px;
        font-weight:bold;
    }
    label{
        font-size:19px;
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
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>pages/process/purchase.htm"><i class="fa fa-circle-o"></i> Purchase</a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Purchase</li>
        </ol>
    </section>

    <!-- Main content -->
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
                        ?> Purchase</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Supplier ID <span style="color:#FF0000;">*</span><a href="<?php $fsitename; ?>addsupplier.php"> Add Supplier </a></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                            <select name="supplierid" id="supplierid" class="form-control select2" required="required" style="font-size: 19px;font-weight: bold;">
                                <option value="">Select</option>
                                <?php
                                $customer = pFETCH("SELECT * FROM `supplier` WHERE `status`=?", '1');
                                while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $customerfetch['id']; ?>" <?php if (getpurchase('supplierid', $_REQUEST['lid']) == $customerfetch['id']) { ?> selected <?php } ?>><?php
                                        echo $customerfetch['supplierid'];
                                        echo '-';
                                        echo $customerfetch['suppliername'];
                                        ?></option>
                                    <!-- <input type="hidden" name="customerid" id="customerid" value="<?php
                                    if (getpurchase('supplierid', $_REQUEST['lid']) == $customerfetch['id']) {
                                        echo $customerfetch['supplierid'];
                                    }
                                    ?>" /> -->
                                    <!-- <input type="text" name="customerid" id="customerid" value="<?php
                                    if ($_REQUEST['lid'] == $customerfetch['id']) {
                                        echo $customerfetch['supplierid'];
                                    }
                                    ?>" /> -->
                                <?php } ?>               
                            </select>

<!-- <input type="text" name="customerid" id="customerid" class="form-control" placeholder="Enter the Customer ID" value="<?php echo getreturn("customerid", $_REQUEST['cid']); ?>" /> -->
                        </div>

                        <!--                        <div class="col-md-4">
                                                    <label>Customer ID <span style="color:#FF0000;">*</span><a href="<?php $fsitename; ?>addcustomer.htm"> Add Customer </a></label>
                        <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                        ?>
                                                    <select name="cusid" id="cusid" class="form-control" required="required" onchange="customer(this.value)">
                                                        <option value="">Select</option>
                        <?php
                        $customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
                        while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                                                        <option value="<?php echo $customerfetch['id']; ?>" <?php if (getpurchase('cusid', $_REQUEST['lid']) == $customerfetch['id']) { ?> selected <?php } ?>><?php
                            echo $customerfetch['cusid'];
                            echo '-';
                            echo $customerfetch['name'];
                            ?></option>
                                                                         <input type="hidden" name="customerid" id="customerid" value="<?php
                            if (getpurchase('cusid', $_REQUEST['lid']) == $customerfetch['id']) {
                                echo $customerfetch['cusid'];
                            }
                            ?>" /> 
                                                                         <input type="text" name="customerid" id="customerid" value="<?php
                            if ($_REQUEST['lid'] == $customerfetch['id']) {
                                echo $customerfetch['cusid'];
                            }
                            ?>" /> 
                        <?php } ?>               
                                                    </select>
                        
                         <input type="text" name="customerid" id="customerid" class="form-control" placeholder="Enter the Customer ID" value="<?php echo getreturn("customerid", $_REQUEST['cid']); ?>" /> 
                                                </div> -->
                        <div class="col-md-4">
                            <label>Date<span style="color:#FF0000;">*</span></label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                                if (isset($_REQUEST['lid']) && (date('d-m-Y', strtotime(getpurchase('date', $_REQUEST['lid']))) != '01-01-1970')) {
                                    echo date('d-m-Y', strtotime(getpurchase('date', $_REQUEST['lid'])));
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?>" >
                            </div>  
                        </div>
                        
                    </div>
                    <br>

                    <div class="clearfix"><br /></div>
                    <!-- <div class="clearfix"><br /></div> -->
                    <div class="panel panel-info">
                        <div class="panel-heading" style="background-color: #d9f7df;font-size:19px;">Product Details</div>
                        <div class="panel-body">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table width="80%" class="table table-bordered" id="task_table" cellpadding="0"  cellspacing="0">
                                            <thead>
                                                <tr style="font-size:19px;">
                                                    <th width="5%">S.no</th>
                                                    <th width="30%">Product</th>
                                                    <th width="10%">Quantity</th>
                                                    <th width="20%">Rate</th>
                                                    <th width="20%">Amount</th>
                                                    <th width="5%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="firsttasktr" style="display:none;">
                                                    <td>1</td>
                                                    <td>
                                                        <select name="objectval[]" id="objectval[]" class="form-control" id='selUser'>
                                                            <option value="">Select</option>
                                                            <?php
                                                            $object = pFETCH("SELECT * FROM `stock_product` WHERE `status`=?", '1');
                                                            while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?php echo $objectfetch['id']; ?>" ><?php echo $objectfetch['objectname']; ?></option>
                                                            <?php } ?>               
                                                        </select>
                                                           <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                    </td>

                                                    <td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control" value="" onchange="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>


<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="rate[]" id="rate[]" class="form-control" value="" onchange="quantitycalculation(this.value)"/><input type="hidden" name="ratehidden" id="ratehidden" value="" /></td>


<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="tamount[]" id="tamount[]" class="form-control" value="" onchange="quantitycalculation(this.value)"/><input type="hidden" name="amounthidden" id="amounthidden" value="" /></td>


                                                </tr>
                                                <?php
                                                $b = 1;
                                                $object1 = $db->prepare("SELECT * FROM `purchase_object_detail` WHERE `object_id`= ?");
                                                $object1->execute(array($_REQUEST['lid']));
                                                $scount = $object1->rowcount();
                                                if ($scount != '0') {
                                                    while ($object1list = $object1->fetch(PDO::FETCH_ASSOC)) 
                                                    {
                                                        
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $b; ?></td>
                                                <td>
                                                                <select name="objectval[]" id="objectval[]" class="form-control" >
                                                                    <option value="">Select</option>
                                                                    <?php
                        $object = pFETCH("SELECT * FROM `stock_product` WHERE `status`=?", '1');
                                                                    while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                                                        ?>
            <option value="<?php echo $objectfetch['id']; ?>" <?php if ($object1list['object'] == $objectfetch['id']) { ?> selected <?php } ?>><?php echo $objectfetch['objectname']; ?></option>
                                                                    <?php } ?>               
                                                                </select>
                                                            </td>


 <td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control" value="<?php echo $object1list['pquantity']; ?>" onchange="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>

<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="rate[]" id="rate[]" class="form-control" value="<?php echo $object1list['rate']; ?>" onchange="quantitycalculation(this.value)"/><input type="hidden" name="ratehidden" id="ratehidden" value="" /></td>

<td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="tamount[]" id="tamount[]" class="form-control" value="<?php echo $object1list['amount']; ?>" onchange="quantitycalculation(this.value)"/><input type="hidden" name="amounthidden" id="amounthidden" value="" /></td>


                                                            <td onclick="delrec1($(this), '<?php echo $object1list['id']; ?>')" style="border: 1px solid #f4f4f4;"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>

                                                        </tr>
                                                        <?php
                                                        $b++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr><td colspan="2" ></td></tr>
                                                <tr>
                                                    <td colspan="1" style="border:0;"><button type="button" class="btn btn-info" style="background-color: #00a65a;border-color: #008d4c;" id="add_task">Add Item</button></td>
<!--                                                    <td style="text-align:right;"> <label>Total Quantity </label> </td>
                                                    <td><input type="number" style="text-align: right;font-size: 19px;" name="totalquantity" id="totalquantity" value="<?php echo getloan('totalquantity', $_REQUEST['lid']); ?>" /></td>-->
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>                                   
                                </div>
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
</head>
<body>



<table style="float: right;">
  
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Sub Tot:</td>
    <td><input type="text" name="sub_total" value="<?php

$id = $_REQUEST['lid'];
$tamnt = 0;
$stmt=$db->prepare("SELECT * FROM `purchase_object_detail` WHERE `object_id`=?");
$stmt->execute(array($id));
while($row=$stmt->fetch(PDO::FETCH_ASSOC))
{
$amnt=$row['amount'];
$tamnt = $tamnt + $amnt;

}
echo $tamnt;
//echo $bankid;
     ?>

    "></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="hidden" name=""></td>
    <td>Discount:</td>
    <td><input type="text" name="" value="
<?php 
$id = $_REQUEST['lid'];
$stmt=$db->prepare("SELECT * FROM `purchase` WHERE `id`=?");
$stmt->execute(array($id));
while($row=$stmt->fetch(PDO::FETCH_ASSOC))
{
$amnt=$row['discount'];

}
echo $amnt;

?>


        "></td>
    
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Grant Tot:</td>
    <td><input type="text" name="" value="
<?php
$grant_total = $tamnt - $amnt;
echo $grant_total;
?>

        "></td>
    
  </tr>
   
   
  
</table>
<?php
echo $getid;
?>


                    <div class="row">
                        <div class="col-md-4">
                            <label>Payment Type <span style="color:#FF0000;">*</span></label>
                            <select name="status" class="form-control">
                                <option value="1" <?php
                                if (stripslashes(getpurchase('payment_type', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Cash Bill</option>
                                <option value="0" <?php
                                if (stripslashes(getpurchase('payment_type', $_REQUEST['lid']) == '2')) {
                                    echo 'selected';
                                }
                                ?>>Credit Bill</option>

                            </select>
                           <!--  <input type="text" name="" value="<?php echo getpurchase("payment_type", $_REQUEST['lid']) ?>"> -->
                        </div>
                        <div class="col-md-4">
                            <label>Advance Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getpurchase("advance_amnt", $_REQUEST['lid'])); ?>" maxlength="10"/>
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
                                if (stripslashes(getpurchase('status', $_REQUEST['lid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if (stripslashes(getpurchase('status', $_REQUEST['lid']) == '0')) {
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

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>pages/process/purchase.htm" style="font-size:19px;">Back to Listings page</a>
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
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
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


    $(document).ready(function (e) {

        $("input").click(function () {
            $(this).next().show();
            $(this).next().hide();
        });



        $('#add_task').click(function () {


            var data = $('#firsttasktr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Offer?")) {
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

            window.location.href = "<?php echo $sitename; ?>process/<?php echo getpurchase('id', $_REQUEST['lid']); ?>/editpurchase.htm?delid1=" + id;
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
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script>
$(document).ready(function(){
 
  // Initialize select2
  $("#selUser").select2();

  // Read selected option
  $('#but_read').click(function(){
    var username = $('#selUser option:selected').text();
    var userid = $('#selUser').val();

    $('#result').html("id : " + userid + ", name : " + username);

  });
});
</script>
