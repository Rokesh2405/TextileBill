<?php
if (isset($_REQUEST['bid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,13";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['bid'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $object1 = implode(',', $objectval);
    $quantity1 = implode(',', $quantity);
    $msg = addbankstatus($receiptno,$loanno,$name,$cus_amount, $bankname, $dateofpawn, $object1, $quantity1, $totalquantity, $weight, $amount, $interestpercent, $interest, $month, $status, $totalamount, $returndate,$no_of_days, $ip, $getid);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $delqty = FETCH_ALL("SELECT * FROM `bank_object_detail` WHERE `id`=?", $_REQUEST['delid1']);

    $bankqry = FETCH_ALL("SELECT * FROM `bankstatus` WHERE `id`=?", $delqry['object_id']);


    $up = $db->prepare("DELETE FROM `bank_object_detail` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['bid'];

    echo '<script>window.location.href="' . $sitename . 'master/' + $_REQUEST['bid'] + 'editbankstatus.htm"</script>';
}
// if (isset($_REQUEST['cid']) && ($_REQUEST['cid'] != '')) {
//     $get1 = $db->prepare("SELECT * FROM `bankstatus` WHERE `id`=?");
//     $get1->execute(array($_REQUEST['id']));
//     $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
// }
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
            Bank Status
            <small><?php
                if ($_REQUEST['bid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Bank Status</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/bankstatus.htm"><i class="fa fa-circle-o"></i> Bank Status</a></li>
            <li class="active"><?php
                if ($_REQUEST['bid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Bank Status</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['bid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Bank Status</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                         <div class="col-md-4">

                            <label>Receipt Number<span style="color:#FF0000;">*</span></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                            <input type="text" name="receiptno" id="receiptno" required="required" class="form-control" placeholder="Enter the Receipt Number" value="<?php echo (getbankstatus('receiptno', $_REQUEST['bid'])); ?>" />
                        </div> 
                        <div class="col-md-4">
                            <label>Amount <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getbankstatus('amount', $_REQUEST['bid'])); ?>" maxlength="10"/>
                        </div>
                         <div class="col-md-4">
                            <label>Weight (in gms) <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="weight" id="weight" placeholder="Enter Weight" class="form-control" value="<?php echo stripslashes(getbankstatus('weight', $_REQUEST['bid'])); ?>" maxlength="10"/>
                        </div>
                        </div>
                        </br>
                        <div class="row">
                       
                        
                        <div class="col-md-4">

                            <label>Loan Number<span style="color:#FF0000;">*</span></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                            <input type="text" name="loanno" id="loanno" required="required" class="form-control" placeholder="Enter the Loan Number" value="<?php echo (getbankstatus('loanno', $_REQUEST['bid'])); ?>" />
                        </div>
                        
                        <div class="col-md-4">

                            <label>Name<span style="color:#FF0000;">*</span></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                            <input type="text" name="name" id="name" required="required" class="form-control" placeholder="Enter the Receipt Name" value="<?php echo (getbankstatus('name', $_REQUEST['bid'])); ?>" />
                        </div>
                        <div class="col-md-4">

                            <label>Customer Amount<span style="color:#FF0000;">*</span></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                            <input type="text" name="cus_amount" id="cus_amount" required="required" class="form-control" placeholder="Enter the Customer Amount" value="<?php echo (getbankstatus('cus_amount', $_REQUEST['bid'])); ?>" />
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Date of Pawn<span style="color:#FF0000;">*</span></label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker" name="dateofpawn" id="dateofpawn" required="required"  value="<?php
                                if (isset($_REQUEST['bid']) && (date('Y-m-d', strtotime(getbankstatus('dateofpawn', $_REQUEST['bid']))) != '1970-01-01')) {
                                    echo date('d-m-Y', strtotime(getbankstatus('dateofpawn', $_REQUEST['bid'])));
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?>" >
                            </div>  
                        </div>
                        <div class="col-md-4">
                            <label>Bank Name <span style="color:#FF0000;">*</span></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                            <input type="text" name="bankname" required="required" id="bankname" placeholder="Enter the Bank Name"  class="form-control" value="<?php echo (getbankstatus('bankname', $_REQUEST['bid'])); ?>" />
                        </div> 
                        <div class="col-md-4">
                            <label>Number Days From Pawn Date <span style="color:#FF0000;">*</span></label>
                            
                            <input type="text" readonly="" name="no_of_days"  id="no_of_days" placeholder=""  class="form-control" value="<?php

                            $t = getbankstatus('id', $_REQUEST['bid']);
                             $stmt=FETCH_ALL("SELECT DATEDIFF(`currentdate`,`dateofpawn`) AS dif FROM bankstatus WHERE `status` = 1 and `id`=?",$t);
                            // $stmt->execute($t); 
                             $t1 =  $stmt['dif'];
                             echo $t1;


                            ?>"
                            <?php 
                        if ($t1 > 85) {
                            echo "style=color:red;border-color:red;font-size:18px;";   
                        }
                        ?>
                             />
                        </div>
                        
                        <input type="hidden" name="" id="cdate" value="<?php echo date("d/m/Y"); ?>">
                        
                    </div>

                    <div class="clearfix"><br /></div>


                    <!--                        <div class="col-md-4">
                                                <button type="submit" name="objectsubmit" id="objectsubmit" class="btn btn-success" style="float:left;">Object</button></div>-->
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
                                                    <th width="40%">Object</th>
                                                    <th width="10%">Quantity</th>
                                                    <!--<th width="55%">Image</th>-->
                                                    <th width="5%">Delete</th>
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
                                                                <option value="<?php echo $objectfetch['id']; ?>" ><?php echo $objectfetch['objectname']; ?></option>
                                                            <?php } ?>               
                                                        </select>
                                                           <!-- <input type="text" name="object[]" id="object[]" class="form-control"> --> 
                                                    </td>
                                                    <td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control" value="" onchange="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>

                                                </tr>
                                                <?php
                                                $b = 1;
                                                $object1 = $db->prepare("SELECT * FROM `bank_object_detail` WHERE `object_id`= ?");
                                                $object1->execute(array($_REQUEST['bid']));
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
                                                            <!--<td><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control" value="<?php echo $object1list['quantity']; ?>"/></td>-->
                                                            <td style="border: 1px solid #f4f4f4;"><input type="number" style="text-align: right;" name="quantity[]" id="quantity[]" class="form-control" value="<?php echo $object1list['quantity']; ?>" onchange="quantitycalculation(this.value)"/><input type="hidden" name="qtyhidden" id="qtyhidden" value="" /></td>

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
                                                    <td style="text-align:right;"> <label>Total Quantity </label> </td>
                                                    <td><input type="number" style="text-align: right;font-size: 19px;" name="totalquantity" id="totalquantity" value="<?php echo getbankstatus('totalquantity', $_REQUEST['bid']); ?>" /></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>                        
                    <!--<div class="col-md-8">
                                                 <label>Object <span style="color:#FF0000;">*</span></label>
                                                <textarea name="object" id="object" class="form-control"><?php echo getbankstatus('object', $_REQUEST['bid']); ?></textarea>
                                            </div>-->


                    <div class="clearfix"><br /></div>
                    <div class="row">

                        <!--                         <div class="col-md-4">
                                                    <label>Return Date<span style="color:#FF0000;">*</span></label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                        if (isset($_REQUEST['bid']) && (date('d-m-Y', strtotime(getbankstatus('date', $_REQUEST['bid']))) != '01-01-1970')) {
                            echo date('d-m-Y', strtotime(getbankstatus('date', $_REQUEST['bid'])));
                        } else {
                            echo date('d-m-Y');
                        }
                        ?>" >
                                                    </div>
                                                </div>-->
                        

                       
                    </div> 

                    <br>
                    <div class="row">
 <div class="col-md-4">
                            <label>Interest Percent<span style="color:#FF0000;">*</span></label>
                            <input type="text" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" value="<?php echo stripslashes(getbankstatus('interestpercent', $_REQUEST['bid'])); ?>" onchange="interest_calculation()"/>
                        </div>
                        <div class="col-md-4">
                            <label>Interest (Per Day) <span style="color:#FF0000;">*</span></label>
                            <input type="text" required="required" id="interest"  name="interest" placeholder="Enter Interest Amount" class="form-control" value="<?php echo stripslashes(getbankstatus('interest', $_REQUEST['bid'])); ?>" />
                        </div>
                        
                        <div class="col-md-4">
                            <label>Return Date<span style="color:#FF0000;"></span></label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" autocomplete="off" class="form-control pull-right usedatepicker" name="returndate" id="returndate" value="<?php echo getbankstatus('returndate', $_REQUEST['bid']);
                        ?>" onchange="final_pay(this.value)" >
                            </div>  
                        </div>
                        

                    </div>    
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Days <span style="color:#FF0000;"></span></label>
                            <input type="text" id="month"  name="month" placeholder="Enter the Days" class="form-control" value="<?php echo stripslashes(getbankstatus('month', $_REQUEST['bid'])); ?>" onchange="month_calculation()"/>
                        </div>
                        <div class="col-md-4">
                            <label>Total Amount <span style="color:#FF0000;"></span></label>
                            <input type="text" id="totalamount"  name="totalamount" placeholder="Enter Total Amount" class="form-control" value="<?php $t = stripslashes(getbankstatus('totalamount', $_REQUEST['bid'])); 
                            echo round($t, 2);
                            //echo $t;
                            ?>" />
                            <!-- pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" -->
                        </div>
                        <div class="col-md-4">
                            <label>Status <span style="color:#FF0000;">*</span></label>
                            <select name="status" class="form-control">
                                <option value="1" <?php
                                if (stripslashes(getbankstatus('status', $_REQUEST['bid'])) == '1') {
                                    echo 'selected';
                                }
                                ?>>Pawned</option>
                                <option value="0" <?php
                                if (stripslashes(getbankstatus('status', $_REQUEST['bid']) == '0')) {
                                    echo 'selected';
                                }
                                ?>>Returned</option>

                            </select>
                                <!--<input type="text" required="required" id="status"  name="status" placeholder="Enter the Status" class="form-control" value="<?php echo stripslashes(getbankstatus('status', $_REQUEST['bid'])); ?>" />-->
                        </div>
                    </div><br>
                </div<!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/bankstatus.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['bid'] != '') {
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


    function delrec1(elem, id) {
        if (confirm("Are you sure want to delete this Object?")) {
            $(elem).parent().remove();
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getbankstatus('id', $_REQUEST['bid']); ?>/editbankstatus.htm?delid1=" + id;
        }
    }


    $(document).ready(function (e) {

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
        $("#worker_table tbody tr").not('#firstworkertr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
    }
    function interest_calculation() {
        var interest_amount = $('#amount').val();

        var interest_percent = $('#interestpercent').val();

        var a = (interest_percent / 100);
        // alert(a);
        var interest_total = (((interest_amount * a) / 12)/30);

        document.getElementById('interest').value = interest_total.toFixed(2);
        // $('#interest').html(interest_total);
    }
//    function month_calculation() {
//        var interest_permonth = $('#interest').val();
//        var month = $('#month').val();
//
//        var total_interest = interest_permonth * month;
//
//        document.getElementById('totalamount').value = total_interest;
//    }
    function quantitycalculation(a) {
//            document.getElementById('qtyhidden').value = a;
//            var total = 0;
        var hidden1 = $('#qtyhidden').val();
        var c = +a + +hidden1;
        document.getElementById('qtyhidden').value = c;
        document.getElementById('totalquantity').value = c;
    }
    function final_pay(a) {
        var d = document.getElementById('dateofpawn').value;
        var current_date = a;
        from = moment(d, 'DD-MM-YYYY'); // format in which you have the date
        to = moment(current_date, 'DD-MM-YYYY');
        var resultdate = to.diff(from, 'days');
                
//        var resultdate = Math.abs(different / 86400);
        $('#month').val(resultdate);
        

//        alert(current_date);
//        var days = $('#days').val();
               var interest_permonth = $('#interest').val();
        var month = $('#month').val();

        var total_interest = interest_permonth * month;

        document.getElementById('totalamount').value = total_interest;


//         document getElementById('currdate').value = current_date;
    }
//     $(document).ready(function()
//     {
//   $("#dateofpawn").change(function()
//   {
//     var start= $("#dateofpawn").datepicker("getDate");
//         var end= $("#cdate").datepicker("getDate");
//         days = (end- start) / (1000 * 60 * 60 * 24);
//         $("#no_of_days").val(days);
//   });
//});
</script>