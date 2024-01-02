<?php
if (isset($_REQUEST['lid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,18";
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
    $pimage = getloan('image', $getid);

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

    $proofname1 = implode(',', $proofname);
    $proof1 = implode(',', $proof);

    $object1 = implode(',', $objectval);
    $quantity1 = implode(',', $quantity);

    $customerid1 = FETCH_all("SELECT  * FROM `customer` WHERE `id`=?", $cusid);

    $customerid = $customerid1['cusid'];
// $object11 = ltrim($object1, ',');
// $quantity11 = ltrim($quantity1, ',');
    $msg = addloan($cusid, $customerid, $date, $receipt_no, $name, $mobileno, $image, $address, $object1, $object_image1, $idproof, $proofname1, $proof1, $quantity1, $netweight, $amount, $interestpercent, $interest, $status, $ip, $getid);
}

if (isset($_REQUEST['lid']) && ($_REQUEST['lid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `object_detail` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['lid'];
    echo '<script>window.location.href="' . $sitename . 'master/' + $_REQUEST['lid'] + 'editloan.htm"</script>';
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
            Loan
            <small><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Loan</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/loan.htm"><i class="fa fa-circle-o"></i> Loan</a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Loan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['lid'] != '') {
                            echo 'View';
                        }
                        ?> Loan</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Receipt Number :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-2">
                            <label> <?php echo getloan('receipt_no', $_REQUEST['lid']); ?> </label>
                                        <!-- <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter the Receipt Number"  class="form-control" value="<?php echo (getloan('receipt_no', $_REQUEST['lid'])); ?>" /> -->
                        </div>
                        <div class="col-md-2">
                            <label>Customer ID :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-2">

                            <label>   <?php
                                echo getloan('cusid', $_REQUEST['lid']);
                                echo '-';
                                echo getloan('name', $_REQUEST['lid']);
                                ?></label>
                                    <!-- <input type="hidden" name="customerid" id="customerid" value="<?php
                            if (getloan('cusid', $_REQUEST['lid']) == $customerfetch['id']) {
                                echo $customerfetch['cusid'];
                            }
                            ?>" /> -->
                                    <!-- <input type="text" name="customerid" id="customerid" value="<?php
                            if ($_REQUEST['lid'] == $customerfetch['id']) {
                                echo $customerfetch['cusid'];
                            }
                            ?>" /> -->


<!-- <input type="text" name="customerid" id="customerid" class="form-control" placeholder="Enter the Customer ID" value="<?php echo getreturn("customerid", $_REQUEST['cid']); ?>" /> -->
                        </div> 
                        <div class="col-md-2">
                            <label>Date :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-2">

                            <label>  <?php
                                if (isset($_REQUEST['lid']) && (date('d-m-Y', strtotime(getloan('date', $_REQUEST['lid']))) != '01-01-1970')) {
                                    echo date('d-m-Y', strtotime(getloan('date', $_REQUEST['lid'])));
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?></label>

                        </div>

                    </div>

                    <div class="clearfix"><br /></div>
                    <div class="row" >
                        <div class="col-md-2">
                            <label>Name :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-2">
                            <label>  <?php
                                echo getloan('name', $_REQUEST['lid']);
                                ?></label>
                        </div>
                        <!-- <div class="col-md-4">
                            <label>Address <span style="color:#FF0000;">*</span></label>
                            <textarea  required="required" name="address" id="address" placeholder="Enter address" class="form-control" ><?php echo getloan('address', $_REQUEST['lid']); ?></textarea>
                        </div> -->
                        <div class="col-md-2">
                            <label>Mobile Number :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-2">
                            <label> <?php
                                echo getloan('mobileno', $_REQUEST['lid']);
                                ?> 
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label>Address :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-2">
                            <label><?php
                                echo getloan('address', $_REQUEST['lid']);
                                ?></label>
                        </div>
                    </div><br>

                    <div class="panel panel-info">
                        <div class="panel-heading" style="background-color: #d9f7df;font-size:19px;">Object Details</div>
                        <div class="panel-body">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table width="80%" class="table table-bordered" id="task_table" cellpadding="0"  cellspacing="0">
                                            <thead>
                                                <tr style="font-size:19px;">
                                                    <th width="5%">S.no</th>
                                                    <th width="50%">Object</th>
                                                    <th width="10%">Quantity</th>
                                                    <!--<th width="55%">Image</th>-->
                                                    <!--<th width="5%">Delete</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="firsttasktr" style="display:none;">
                                                    <td>1</td>
                                                    <td>
                                                        <select name="objectval[]" id="objectval[]" class="form-control" >
                                                            <option value="">Select</option>
                                                            <?php
                                                            $object = pFETCH("SELECT * FROM `object` WHERE `status`=?", '1');
                                                            while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?php echo $objectfetch['id']; ?>" <?php if (getobjectdetail('object', $_REQUEST['lid']) == $objectfetch['id']) { ?> selected <?php } ?>><?php echo $objectfetch['objectname']; ?></option>
                                                            <?php } ?>               
                                                        </select>
                                                           <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                    </td>
                                                    <td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control" value="<?php echo getobjectdetail('quantity', $_REQUEST['lid']); ?>" /></td>
<!--                                                    <td style="border: 1px solid #f4f4f4;"><div class="row"><div class="col-md-6"><input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file"></div></div> </td>-->
                                                </tr>
                                                <?php
                                                $b = 1;
                                                $object1 = $db->prepare("SELECT * FROM `object_detail` WHERE `object_id`= ?");
                                                $object1->execute(array($_REQUEST['lid']));
                                                $scount = $object1->rowcount();
                                                if ($scount != '0') {
                                                    while ($object1list = $object1->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $b; ?></td>
                                                            <td>
                                                                <select name="objectval[]" id="objectval[]" class="form-control" >
                                                                    <option value="">Select</option>
                                                                    <?php
                                                                    $object = pFETCH("SELECT * FROM `object` WHERE `status`=?", '1');
                                                                    while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                                                        ?>
                                                                        <option value="<?php echo $objectfetch['id']; ?>" <?php if ($object1list['object'] == $objectfetch['id']) { ?> selected <?php } ?>><?php echo $objectfetch['objectname']; ?></option>
                                                                    <?php } ?>               
                                                                </select>
                                                                   <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                            </td>
                                                            <td><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control" value="<?php echo $object1list['quantity']; ?>" /></td>
                                                            <td>
                                                                <!--                                                                <div class="row">
                                                                                                                                    <div class="col-md-4">
                                                                                                                                        <input class="form-control spinner" <?php if (getobjectdetail('object_image', $_REQUEST['lid']) == '') { ?>  <?php } ?> name="object_image[]" type="file">
                                                                                                                                    </div>                 
                                                                <?php if ($object1list['object_image'] != '') { ?>   
                                                                                                                                                <div class="col-md-8" id="delimage">
                                                                                                                                                    <input class="form-control spinner"value="<?php echo $object1list['object_image']; ?>" name="object_image[]" type="text">
                                                                                                                                                    <img src="<?php echo $fsitename; ?>img/object/<?php echo $object1list['object_image']; ?>" style="padding-bottom:10px;" height="100" />
                                                                                                                                                     <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo $object1list['object_image']; ?>', '<?php echo $object1list['id']; ?>', 'object_detail', '../../img/object/', 'object_image', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>                                                             
                                                                                                                                                </div>
                                                                <?php } ?>
                                                                                                                                </div>-->
                                                            </td>
                                                            <!--<td onclick="delrec1($(this), '<?php echo $object1list['id']; ?>')" style="border: 1px solid #f4f4f4;"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>-->
                                                        </tr>
                                                        <?php
                                                        $b++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                             <tfoot>
                                                <tr><td colspan="1" ></td>
                                                    <!--<td colspan="1" style="border:0;"><button type="button" class="btn btn-info" style="background-color: #00a65a;border-color: #008d4c;" id="add_task">Add Item</button></td>-->
                                                    <td style="text-align:right;"> <label>Total Quantity </label> </td>
                                                    <td><input type="number" style="text-align: right;font-size: 19px;" name="totalquantity" id="totalquantity" value="<?php echo getloan('totalquantity', $_REQUEST['lid']); ?>" /></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Net Weight (in gms) :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-1">
                            <label><?php echo stripslashes(getloan("netweight", $_REQUEST['lid'])); ?></label>
                        </div>
                        <div class="col-md-3">
                            <label>Amount :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-1">
                            <label><?php echo stripslashes(getloan("amount", $_REQUEST['lid'])); ?></label>
                        </div>
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
                            <input type="text"  required="required" name="netweight" id="netweight" placeholder="Enter Net Weight" class="form-control" value="<?php echo stripslashes(getloan('netweight', $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                        <div class="col-md-4">
                            <label>Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getloan('amount', $_REQUEST['lid'])); ?>" maxlength="10"/>
                        </div>
                         <div class="col-md-4">
                            <label>Interest Percent<span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" value="<?php echo stripslashes(getloan('interestpercent', $_REQUEST['lid'])); ?>" />
                        </div>
                       
                    </div> 
                     
                     <br> -->
                    <div class="row">
                         <div class="col-md-3">
                            <label>Interest Percent :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-1">
                            <label><?php echo stripslashes(getloan("interestpercent", $_REQUEST['lid'])); ?></label>
                        </div>
                        <div class="col-md-3">
                            <label>Interest :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-3">
                            <label><?php echo stripslashes(getloan('interest', $_REQUEST['lid'])); ?></label>
                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-md-3">

                            <label>Status :<span style="color:#FF0000;"></span></label>
                        </div>
                        <div class="col-md-3">
                            <label><?php
                                if (stripslashes(getloan('status', $_REQUEST['lid'])) == '1') {
                                    echo 'Active';
                                }
                                ?>
                                <?php
                                if (stripslashes(getloan('status', $_REQUEST['lid']) == '0')) {
                                    echo 'Canceled';
                                }
                                ?></label>
                        </div>
                    </div>    
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/loan.htm" style="font-size:19px;">Back to Listings page</a>
                        </div>
                        
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
