<?php
if (isset($_REQUEST['rid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,21";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

//if(isset($_REQUEST['yearwise'])){
//    @extract($_REQUEST);
//    $getid = $_REQUEST['rid'];
//    $ip = $_SERVER['REMOTE_ADDR'];
//    
//    
//}
//if (isset($_REQUEST['submit'])) {
//    @extract($_REQUEST);
//    $getid = $_REQUEST['rid'];
//    $ip = $_SERVER['REMOTE_ADDR'];
//
//    $msg = addcustomer($username, $password, $servicetype, $rank, $customerid, $membership, $title, $cname, $area, $mobile, $emailid, $joineddate, $valid_fromdate, $valid_todate, $address, $description, $payment, $status, $ip, $getid);
//}
//if (isset($_REQUEST['find'])) {
//    @extract($_REQUEST);
//    $getreceiptno = $_REQUEST['receiptno'];
//    $getcustomer = $_REQUEST['customerid'];
//
//    $findqry = $db->prepare("SELECT * FROM `return` WHERE `customerid`=? OR `receiptno`=?");
//    $findqry->execute(array($getcustomer, $getreceiptno));
//}
//
//if (isset($_REQUEST['rid']) && ($_REQUEST['rid'] != '')) {
//    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
//    $get1->execute(array($_REQUEST['id']));
//    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
//}
//
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
            Return View
            <small><?php
                if ($_REQUEST['rid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Return View</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/addreturnview.htm"><i class="fa fa-circle-o"></i> Return View</a></li>
            <li class="active"><?php
//                if ($_REQUEST['rid'] != '') {
//                    echo 'Edit';
//                } else {
//                    echo 'Add New';
//                }
                ?> Return View</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php
//                        if ($_REQUEST['rid'] != '') {
//                            echo 'Edit';
//                        } else {
//                            echo 'Add New';
//                        }
                    ?> Return View</h3>
                <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
            </div>
           
            <div class="box-body">
                <div class="panel panel-info">
                    <div class="panel-heading" style="background-color: #d9f7df;font-size:19px;">Find Amount</div>
                    <div class="panel-body">
                        <form>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Month:</label>
                                    <input type="text" class="form-control" name="monthcalc" id="monthcalc" placeholder="Enter the month" />
                                </div>
                                <div class="col-md-3">
                                    <label>Year:</label>
                                    <input type="text" class="form-control" name="yearcalc" id="yearcalc" placeholder="Enter the Year" required="required"/>
                                </div>
                                <div class="col-md-6" id="calculation">

                                </div>

                            </div>

                            <br>

                            <!--<form name="department" id="department"  method="post" enctype="multipart/form-data">-->
                            <div class="col-md-3">
                                <button type="button" name="totalprincipal" id="totalprincipal" class="btn btn-success" style="float:left;"><?php
                                    echo 'Click here to get Total Principal';
                                    ?></button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" name="totalamount" id="totalamount" class="btn btn-success" style="float:left;"><?php
                                    echo 'Click here to get Total Amount';
                                    ?></button>
                            </div>
                            <!--                        </form>
                                                    <form name="department" id="department"  method="post" enctype="multipart/form-data">-->

                        </form>
                        <form name="department" id="department"  method="post" enctype="multipart/form-data">
                            <div class="col-md-3">
                                <button type="button" name="totalinterest" id="totalinterest" class="btn btn-success" style="float:left;"><?php
                                    echo 'Click here to get Total Interest';
                                    ?></button>
                            </div>
                        </form>
                        <!--</form>-->
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <form name="department" id="department"  method="post" enctype="multipart/form-data">
                    <?php echo $msg; ?>
                    <div class="row">

                        <div class="col-md-3">
                            <label>No of Pawn<span style="color:#FF0000;">*</span></label>
                            <?php
                            //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            $pawn = $db->prepare("SELECT * FROM `loan` WHERE `status`=? AND `returnstatus`=? OR `returnstatus`=?");
                            $pawn->execute(array('1', '1', '2'));
                            $pcount = $pawn->rowcount();
                            ?>
                            <input type="text" name="noofpawn" id="noofpawn" class="form-control" placeholder="No of Pawn" value="<?php echo $pcount; ?>" />

                        </div> 
                        <div class="col-md-3">
                            <label>No of Return <span style="color:#FF0000;">*</span></label>
                            <?php
                            //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            $return = $db->prepare("SELECT * FROM `return` WHERE `status`=? ");
                            $return->execute(array('0'));
                            $rcount = $return->rowcount();
                            ?>
                            <input type="text" name="noofreturn" id="noofreturn" placeholder="No of Return"  class="form-control" value="<?php echo $rcount; ?>" />

                        </div> 
                        <div class="col-md-3">
                            <label>No of Cancel <span style="color:#FF0000;">*</span></label>
                            <?php
//$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            $cancel = $db->prepare("SELECT * FROM `loan` WHERE `status`=?");
                            $cancel->execute(array('0'));
                            $ccount = $cancel->rowcount();
                            ?>
                            <input type="text" name="noofcancel" id="noofcancel" placeholder="No of Cancel"  class="form-control" value="<?php echo $ccount; ?>" />
                        </div> 
                        <div class="col-md-3">
                            <label>Total Bill Performed <span style="color:#FF0000;">*</span></label>
                            <?php
                            //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                            $totalbill = $db->prepare("SELECT * FROM `loan`");
                            $totalbill->execute();
                            $tcount = $totalbill->rowcount();
                            ?>
                            <input type="text" name="totalbill" id="totalbill" placeholder="Total Bill Performed"  class="form-control" value="<?php echo $tcount; ?>" />
                        </div> 
                    </div>

                    <div class="clearfix"><br /></div>
                    <div class="panel panel-info">
                        <div class="panel-heading" style="background-color: #d9f7df;font-size:19px;">Customer Search</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Receipt Number <span style="color:#FF0000;">*</span></label>
                                    <input type="text"  required="required" name="receiptno" id="receiptno" placeholder="Enter Receipt Number" class="form-control" value="" onchange="findreceipt(this.value)" />
                                </div>
                                <div class="col-md-3">
                                    <label>Customer ID<span style="color:#FF0000;">*</span></label>
                                    <input type="text"  required="required" name="customerid" id="customerid" placeholder="Enter Customer ID" class="form-control" value="<?php echo getreturnview('customerid', $_REQUEST['rid']); ?>" onchange="finddata(this.value)"/>
                                </div>
                                <!--onclick="finddata(document.getElementById('receiptno').value,document.getElementBtId('customerid').value)"-->

                            </div> 
                            <br>
                            <div class="row" id="customerdetail">

                            </div>
                        </div>
                    </div>
                </form>

                <br>
                <div class="panel panel-info">
                    <div class="panel-heading" style="background-color: #d9f7df;font-size:19px;">Days Search</div>
                    <div class="panel-body">
                        <div class="row">
                            <form name="department" id="department"  method="post" enctype="multipart/form-data">
                                <div class="col-md-3">
                                    <label>Year <span style="color:#FF0000;">*</span></label>
                                    <input type="text" required="required" name="year" id="year" placeholder="Enter Year" class="form-control" value="<?php echo (isset($_REQUEST['rid'])) ? stripslashes($showrecords['mobile']) : '' ?>" maxlength="10"/>
                                </div>

                                <div class="col-md-3"><br>
                                    <button type="button" name="yearwise" id="yearwise" class="btn btn-success" style="float:left;">Year Wise View</button>
                                </div>

                            </form>
                            <form name="department" id="department" method="post" enctype="multipart/form-data">

                                <div class="col-md-3"> 
                                    <label>Month Wise View <span style="color:#FF0000;">*</span></label>
                           <select id="month" name="month" class="form-control" style="width: 235px;height: 40px;">
                             <option value=''>--Select Month--</option>
                            <option value='1'>Janaury</option>
                            <option value='2'>February</option>
                            <option value='3'>March</option>
                            <option value='4'>April</option>
                            <option value='5'>May</option>
                            <option value='6'>June</option>
                            <option value='7'>July</option>
                            <option value='8'>August</option>
                            <option value='9'>September</option>
                            <option value='10'>October</option>
                            <option value='11'>November</option>
                            <option value='12'>December</option>
                           </select>
                                </div> 
                                <div class="col-md-3">
                                    <label>Enter Year<span style="color:#FF0000;">*</span></label>
                                    <input type="text" required="required" name="myear" id="myear" placeholder="Enter Year" class="form-control" value="<?php echo (isset($_REQUEST['rid'])) ? stripslashes($showrecords['mobile']) : '' ?>" maxlength="10"/>

                                </div>
                            </form>
                        </div>
                        <br>
                        <form name="department" id="department"  method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Date<span style="color:#FF0000;">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control pull-right usedatepicker" name="date" id="date" required="required"  value="<?php
                                        if (isset($_REQUEST['rid']) && (date('d-m-Y', strtotime($showrecords['joineddate'])) != '01-01-1970')) {
                                            echo date('d-m-Y', strtotime($showrecords['joineddate']));
                                        } else {
                                            echo date('d-m-Y');
                                        }
                                        ?>" >
                                    </div>  
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <button type="button" name="datewise" id="datewise" class="btn btn-success" style="float:left;">Date Wise View</button>
                                </div>

                                <div class="col-md-3">
                                    <label>Page Size <span style="color:#FF0000;">*</span></label>
                                    <input type="text" required="required" name="pagesize" id="pagesize" placeholder="Enter Page Size" class="form-control" value="<?php echo (isset($_REQUEST['rid'])) ? stripslashes($showrecords['mobile']) : '' ?>" maxlength="10"/>

                                </div>

                            </div> 
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Status <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" name="status" id="status" value="Returned" readonly="readonly" />   
                                </div>
                                <!--                                <div class="col-md-6" id="calculation">
                                
                                                                </div>-->
                            </div>
                        </form>
                        <br>
                        <div class="row" id="datewisedetail">
                        </div>
                    </div>
                </div>
                <br>
                <!--  <div class="row">
                                      <div class="col-md-3">
                                            &nbsp;
                                        </div>
                </div> -->
                <br>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="row">
                    <!--                    <div class="col-md-3">
                                            <a href="<?php echo $sitename; ?>master/returnview.htm">Back to Listings page</a>
                                        </div>-->
                    <!--                    <form name="department" id="department"  method="post" enctype="multipart/form-data">
                                            <div class="col-md-3">
                                                <button type="button" name="totalamount" id="totalamount" class="btn btn-success" style="float:left;"><?php
                    //echo 'Click here to get Total Amount';
                    ?></button>
                                            </div>
                                        </form>
                    <form name="department" id="department"  method="post" enctype="multipart/form-data">
                        <div class="col-md-3">
                            <button type="button" name="totalprincipal" id="totalprincipal" class="btn btn-success" style="float:left;"><?php
                    //echo 'Click here to get Total Principal';
                    ?></button>
                        </div>
                    </form>
                    <form name="department" id="department"  method="post" enctype="multipart/form-data">
                        <div class="col-md-3">
                            <button type="button" name="totalinterest" id="totalinterest" class="btn btn-success" style="float:left;"><?php
                    //echo 'Click here to get Total Intrest';
                    ?></button>
                        </div>
                    </form>-->
                </div>
            </div>
        </div>
</div><!-- /.box -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
        $("#yearwise").click(function () {
            var a = $("#year").val();
            var page = $('#pagesize').val();
//            alert(a);
            $.ajax({
                type: "POST",
                catch : "false",
                url: "<?php echo $sitename; ?>pages/master/searchajax.php",
                data: {year: a, page: page},
                success: function (data) {
                    $("#datewisedetail").html(data);
//                $("#customerid").val(a);

                }
            });
        });
        $("#month").change(function(){
            var a = $("#month").val();
            var page = $('#myear').val();
//            alert(a);
            $.ajax({
                url: "<?php echo $sitename; ?>pages/master/searchajax.php",
                data: {month: a, page: page},
                success: function (data) {
                    $("#datewisedetail").html(data);
//                $("#customerid").val(a);

                }
            });
        });
        $("#datewise").click(function () 
        {
            
            var a = $("#date").val();
            // alert(a);
            var page = $('#pagesize').val();
//            alert(a);
            $.ajax({
                url: "<?php echo $sitename; ?>pages/master/searchajax.php",
                data: {date: a, page: page},
                success: function (data) {
                    $("#datewisedetail").html(data);
//                $("#customerid").val(a);

                }
            });
        });
        $("#totalamount").click(function () {
//            alert('hiii');
            var month = $('#monthcalc').val();
            var year = $('#yearcalc').val();
            $.ajax({
                url: "<?php echo $sitename; ?>pages/master/calculateamount.php",
                data: {month: month, year: year},
                success: function (data) {
                    $("#calculation").html(data);
//                $("#customerid").val(a);

                }
            });
        });
        $("#totalprincipal").click(function () {
            var month = $('#monthcalc').val();
            var year = $('#yearcalc').val();
            $.ajax({
                url: "<?php echo $sitename; ?>pages/master/calculateprincipal.php",
                data: {month: month, year: year},
                success: function (data) {
                    $("#calculation").html(data);
//                $("#customerid").val(a);

                }
            });
        });
        $("#totalinterest").click(function () {
            var month = $('#monthcalc').val();
            var year = $('#yearcalc').val();
            $.ajax({
                url: "<?php echo $sitename; ?>pages/master/calculateinterest.php",
                data: {month: month, year: year},
                success: function (data) {
                    $("#calculation").html(data);
//                $("#customerid").val(a);

                }
            });
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
        $("#worker_table tbody tr").not('#firstworkertr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
    }


    function finddata(a) {
//        alert(a);
        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/searchajax.php",
            data: {customerid: a},
            success: function (data) {
                $("#customerdetail").html(data);
//                $("#customerid").val(a);

            }
        });

    }
    function findreceipt(a) {
//        alert(a);
        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/searchajax.php",
            data: {receiptno: a},
            success: function (data) {
                $("#customerdetail").html(data);
//                $("#customerid").val(a);

            }
        });

    }


</script>