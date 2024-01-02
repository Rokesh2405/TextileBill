<?php
if (isset($_REQUEST['cid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,12,12";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['cid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $customerid1 = FETCH_all("SELECT  * FROM `customer` WHERE `id`=?",$customerid);

$customeridname = $customerid1['cusid'];

    $msg = addreturn($customerid,$customeridname, $object, $loanid, $date, $name, $mobileno, $netweight, $amount, $interestpercent, $interest, $status,$pawndays,$currentdate,$totalinterest,$pamount,$finalpay, $ip, $getid);
}

if (isset($_REQUEST['cid']) && ($_REQUEST['cid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['cid']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
// $now = time(); // or your date as well
// $your_date = strtotime("2010-01-01");
// $datediff = $now - $your_date;
// echo round($datediff / (60 * 60 * 24));
?>
<style>
    .form-control{
        font-size:19px;
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
            Return
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Return</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/return.htm"><i class="fa fa-circle-o"></i> Return</a></li>
            <li class="active"><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Return</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data"  autocomplete="off" >
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['cid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Return</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row" >
                        <div class="col-md-4">
                            <label>Customer ID <span style="color:#FF0000;">*</span></label>
                            <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            ?>
                            <select name="customerid" id="customerid" class="form-control select2" required="required" onchange="loan(this.value)">
                                <option value="">Select</option>
                                <?php
                                $customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
                                while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $customerfetch['id']; ?>" <?php if (getreturn('customerid', $_REQUEST['cid']) == $customerfetch['id']) { ?> selected <?php } ?>><?php
                                        echo $customerfetch['cusid'];
                                        echo '-';
                                        echo $customerfetch['name'];
                                        ?></option>
                                <?php } ?>               
                            </select>
                                    <!-- <input type="text" name="customerid" id="customerid" class="form-control" placeholder="Enter the Customer ID" value="<?php echo getreturn("customerid", $_REQUEST['cid']); ?>" /> -->
                        </div> 
                        <div class="col-md-4" >
                            <label>Receipt Number <span style="color:#FF0000;">*</span></label>
                            <select name="loanid" id="loanid" class="form-control" required="required" onchange="return_1(this.value)">
                                <option value="">Select</option>
                                <?php
                                if (isset($_REQUEST['cid'])) {

                                    $customerlist = pFETCH("SELECT * FROM `loan` WHERE `status`=? AND `cusid` =? ", '1', getreturn('customerid', $_REQUEST['cid']));
                                    while ($objectfetch = $customerlist->fetch(PDO::FETCH_ASSOC)) {
                                        echo $objectfetch['receipt_no'];
                                        ?>
                                        <option value="<?php echo $objectfetch['id']; ?>" <?php if (getreturn('loanid', $_REQUEST['cid']) == $objectfetch['id']) { ?> selected <?php } ?>><?php echo $objectfetch['receipt_no']; ?></option>
                                        <?php
                                    }
                                }
                                ?>           
                            </select>
                                    <!-- <input type="text" name="receiptno" id="receiptno" placeholder="Enter the Receipt Number"  class="form-control" value="<?php echo getreturn("receiptno", $_REQUEST['cid']); ?>" /> -->
                        </div> 
                    <div class="row">
                        <div class="col-md-4">
                            <label>Return Date<span style="color:#FF0000;">*</span></label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker" name="currentdate" id="currentdate" required="required"  value="<?php echo getreturn('currentdate',$_REQUEST['cid']);
                    ?>" onchange="final_pay(this.value)" >
                            </div>  
                        </div>
                    </div>
                    </div>

                    <div class="clearfix"><br /></div>
                    <div id="receiptdetails">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Date of Pawn<span style="color:#FF0000;">*</span></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                                    if (isset($_REQUEST['cid'])) {
                                        echo date('d-m-Y', strtotime(getreturn("date", $_REQUEST['cid'])));
                                    } else {
                                        echo date('d-m-Y');
                                    }
                                    ?>" >
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <label>Name <span style="color:#FF0000;">*</span></label>
                                <input type="text"  required="required" name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php echo stripslashes(getreturn("name", $_REQUEST['cid'])); ?>" />
                            </div>
                            <div class="col-md-4">
                                <label>Mobile Number <span style="color:#FF0000;">*</span></label>
                                <input type="text" required="required" name="mobileno" id="mobileno" placeholder="Enter Mobile Number" class="form-control" value="<?php echo stripslashes(getreturn("mobileno", $_REQUEST['cid'])); ?>" />
                            </div>

                        </div>  <br>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Net Weight (in gms) <span style="color:#FF0000;"></span></label>
                                <input type="text"  required="required" name="netweight" id="netweight" placeholder="Enter Net Weight" class="form-control" value="<?php echo stripslashes(getreturn("netweight", $_REQUEST['cid'])); ?>" />
                            </div>
                            <div class="col-md-4">
                                <label>Amount <span style="color:#FF0000;"></span></label>
                                <input type="text" required="required" name="amount" id="amount" placeholder="Enter Amount" class="form-control" value="<?php echo stripslashes(getreturn("amount", $_REQUEST['cid'])); ?>"  />
                            </div>
                            <div class="col-md-4">
                                <label>Interest Percent<span style="color:#FF0000;"></span></label>
                                <input type="text" id="interestpercent"  name="interestpercent" placeholder="Enter Interest Percent" class="form-control" value="<?php echo stripslashes(getreturn("interestpercent", $_REQUEST['cid'])); ?>" />
                            </div>

                        </div> 


                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Interest <span style="color:#FF0000;"></span></label>
                                <input type="text" id="interest"  name="interest" placeholder="Enter Interest Amount" class="form-control" value="<?php echo stripslashes(getreturn("interest", $_REQUEST['cid'])); ?>" onchange="interestvalue()"/>
                                <!-- pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" -->
                            </div>
                            <div class="col-md-4">

                                <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                <select name="status" class="form-control">
                                    <option value="1" <?php
                                    if (stripslashes(getreturn("status", $_REQUEST['cid']) == '1')) {
                                        echo 'selected';
                                    }
                                    ?>>Pawned</option>
                                    <option value="0" <?php
                                    if (stripslashes(getreturn("status", $_REQUEST['cid']) == '0')) {
                                        echo 'selected';
                                    }
                                    ?>>Returned</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Pawn Days <span style="color:#FF0000;">*</span></label>
                                <input type="text" id="pawndays"  name="pawndays" class="form-control" value="<?php echo stripslashes(getreturn('pawndays', $_REQUEST['cid'])); ?>" />
                            </div>
                        </div> 
                        <div class="col-md-4">

                        </div> 
                        <br>
                        <div class="panel panel-info">
                            <div class="panel-heading" style="background-color: #d9f7df;">Calculation</div>
                            <div class="panel-body">
                                <div class="col-md-4">
                                    <label>Interest <span style="color:#FF0000;">*</span></label>
                                    <input type="text" required="required" id="interestvalue"  name="interestvalue" class="form-control" value="<?php echo stripslashes(getreturn('interest', $_REQUEST['cid'])); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label>Days <span style="color:#FF0000;">*</span></label>
                                    <input type="text" required="required" id="days"  name="days" class="form-control" value="<?php echo stripslashes(getreturn('pawndays', $_REQUEST['cid'])); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label>Total Interest<span style="color:#FF0000;">*</span></label>
                                    <input type="text" required="required" id="totalinterest"  name="totalinterest" class="form-control" value="<?php echo stripslashes(getreturn('totalinterest', $_REQUEST['cid'])); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label>PAmount <span style="color:#FF0000;">*</span></label>
                                    <input type="text" required="required" id="amountvalue"  name="amountvalue" class="form-control" value="<?php echo stripslashes(getreturn('amount', $_REQUEST['cid'])); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label>Final Pay <span style="color:#FF0000;">*</span></label>
                                    <input type="text" required="required" id="finalpay"  name="finalpay" class="form-control" value="<?php echo stripslashes(getreturn('finalpay', $_REQUEST['cid'])); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo $sitename; ?>master/return.htm">Back to Listings page</a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                            if ($_REQUEST['cid'] != '') {
                                echo 'UPDATE';
                            } else {
                                echo 'SUBMIT';
                            }
                            ?></button>
                    </div>
                </div>
            </div>
            <!-- /.box -->
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
            window.location.href = "<?php echo $sitename; ?>master/<?php echo $showrecords['id'] ?>/editprovider.htm?delid=" + id;
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
            $(this).find('td').eq(0).html(i + 1 + 1);
        });
        $("#proof_table tbody tr").not('#firstprooftr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1 + 1);
        });
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

    function loan(a) {

        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/loan_ajax.php",
            data: {customerid: a},
            success: function (data) {
                $("#loanid").html(data);
            }
        });
    }

    function return_1(a) {

        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/return_ajax.php",
            data: {loanid: a},
           
            success: function (data) {
                $("#receiptdetails").html(data);
                //   $("#mobileno").html(data);
                //   $("#netweight").html(data);
                //   $("#amount").html(data);
                //   $("#interestpercent").html(data);
                //   $("#interest").html(data);
                //   $("#status").html(data);
            }
        });
    }


</script>
<script>
  

//     function final_pay(a) {
//         var d = document.getElementById('date').value;
//         var current_date = a;
//         from = moment(d, 'DD-MM-YYYY'); // format in which you have the date
//         to = moment(current_date, 'DD-MM-YYYY');
//         var resultdate = to.diff(from, 'days');
// //        var resultdate = Math.abs(different / 86400);
//         $('#days').val(resultdate);
//         $('#pawndays').val(resultdate);

// //        alert(current_date);
// //        var days = $('#days').val();
//         var amount = $('#amount').val();
//         var interest = $('#interest').val();
//         var interestminus = (amount - interest);
//         var interesrperday = (interestminus / 30);
//         var totalinterest = interesrperday * resultdate;
//         document.getElementById('totalinterest').value = totalinterest;
//         var finalamount = +totalinterest + +amount;
// //                alert(finalamount);
//         document.getElementById('finalpay').value = finalamount;


// //         document getElementById('currdate').value = current_date;
//     }
//    function dateDiffInDays(date1, date2) {
//        // Calulating the difference in timestamps 
//        var dateobj = new Date(date1); 
//        alert(date1);
//        var dateobj1 = new Date(date2); 
//        var diff = dateobj.toTimeString() - dateobj1.toTimeString();
//        var resultdate = Math.abs(diff / 86400);
//        // 1 day = 24 hours 
//        // 24 * 60 * 60 = 86400 seconds 
//        return resultdate;
//    }
</script>

