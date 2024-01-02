<?php
$menu = "19,20,23";
if ($_REQUEST['id'] != '') {
    $thispageeditid = 13;
} else {
    $thispageid = 13;
}

include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');

if(isset($_REQUEST['submit'])){
    $d = $db->prepare("UPDATE `payslip` SET `draft`='0',`status`=? WHERE `id`=?");
    $d->execute([$_REQUEST['status'],$_REQUEST['id']]);
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
}

$viewpay = FETCH_all("SELECT * FROM `payslip` WHERE `id`=?", $_REQUEST['id']);

if(isset($_REQUEST['sendmails'])){
    
PayslipMail($_REQUEST['id']);
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i> Successfully Sent</h4></div>';
}


?>
<style>
    td {
        border: none;
    }
    .btn-newone:hover{
        background-color: #0C2294 !important;
    }
</style>
<?php ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pay Slip
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo $sitename; ?>invoice/payslip.htm"><i class="fa fa-bar-chart"></i> Pay Slip</a></li>
            <li><a href="#">View Pay Slip</a></li>

        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">

                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Employee Details 
                        </div>
                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <table   class="table table-bordered table-striped">
                                        <tbody>

                                            <tr>
                                                <td>
                                                    Date : 
                                                </td>
                                                <td>
                                                    <?php echo date("d-M-Y", strtotime($viewpay['date'])) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Employee Name: 
                                                </td>
                                                <td>
                                                    <input type="hidden" name="employee" id="employee" value="<?php echo $viewpay['employee']; ?>">
                                                    <?php echo getdriver('firstname', $viewpay['employee']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Mobile Number: 
                                                </td>
                                                <td>
                                                    <?php echo getdriver('mobile', $viewpay['employee']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Emailid: 
                                                </td>
                                                <td>
                                                    <?php echo getdriver('email', $viewpay['employee']); ?>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Pay Slip Details 
                        </div>
                        <div class="panel-body">
                            <br>
                            <div class="row">

                                <div class="col-md-12 table-resposive">
                                    <table id="normalexamples" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <!--<th style="width: 3%;">#</th>-->
                                                <th style="width: 10%;">Date</th>
                                                <th style="width: 10%;">Job's</th>
                                                <th style="width: 10%;">Invoiceid</th>
                                                <th style="width: 15%;">Description</th>
                                                <th style="width: 15%;">Basic Rate</th>
                                                <th style="width: 10%;">Qty</th>
                                                <th style="width: 15%;">Extra Charge</th>
                                                <th style="width: 15%;">Total Amt</th>
                                                <!--<th style="width: 8%;">Paid Amt</th>
                                                <th style="width: 8%;">Payable Amt</th>-->
                                                <!--<th style="width: 8%;">Status</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM `payslip_details` WHERE `payslip_id`=?";

                                            $paylist = $db->prepare($sql);
                                            $paylist->execute(array($viewpay['id']));
                                            $ccount = $paylist->rowcount();
                                            $i = 1;
                                            $total = 0;
                                            if ($ccount != '0') {
                                                while ($paylistfetch = $paylist->fetch(PDO::FETCH_ASSOC)) {
                                                    $total += $paylistfetch['task_amount_aud'];
                                                    ?>
                                                    <tr>
<!--                                                        <td>
                  
                                                            <input type="checkbox" name="chkPassport[]"/>
                                                        </td>-->
                                                        <td>
                                                                                                      <input type="hidden" name="payid[]" id="payid[]" disabled="disabled" value="<?php echo $paylistfetch['id'] ?>">
                                                            <input type="hidden" disabled="disabled" name="invoicedate[]" id="invoicedate[]" value="<?php echo $paylistfetch['date'] ?>">
                                                            <input type="hidden" disabled="disabled" name="job_id[]" id="job_id[]" value="<?php echo $paylistfetch['job_id'] ?>">
                                                            <?php echo date("d-M-Y", strtotime($paylistfetch['date'])) ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo $sitename; ?>jobs/<?php echo $paylistfetch['job_id']; ?>/editnewjob.htm" target="_blank"><?php echo getjob('jobid',$paylistfetch['job_id']); ?></a><br />
                                                          
                                                        </td>
                                                        <td>
                                                            <input type="hidden" disabled="disabled" name="invoiceid[]" id="invoiceid[]" value="<?php echo $paylistfetch['invoice_id']; ?>" />
                                                            <a href="<?php echo $sitename; ?>invoice/<?php echo $paylistfetch['invoice_id']; ?>/editnewinvoice.htm" target="_blank"><?php echo getinvoice('invoiceid', $paylistfetch['invoice_id']); ?></a>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" disabled="disabled" name="empdesc[]" id="empdesc[]" value="<?php echo $paylistfetch['task_description']; ?>" />
                                                             <?php echo $paylistfetch['task_description']; ?>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" disabled="disabled" name="empunitprice[]" id="empunitprice[]" value="<?php echo $paylistfetch['task_unit_price']; ?>" class="form-control" onkeyup="calfunction($(this));" />
                                                            $ <?php echo $paylistfetch['task_unit_price']; ?></td>
                                                        <td>
                                                            <input type="hidden" disabled="disabled" name="emptask_quty[]" id="emptask_quty[]" value="<?php echo $paylistfetch['task_quty']; ?>" class="form-control" onkeyup="calfunction($(this));" />
                                                            <?php echo $paylistfetch['task_quty']; ?>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" disabled="disabled" name="emptask_extra_amt[]" id="emptask_extra_amt[]" value="<?php echo $paylistfetch['task_extra_amt']; ?>" class="form-control" onkeyup="calfunction($(this));" />
                                                            $ <?php echo $paylistfetch['task_extra_amt']; ?>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <input type="hidden"disabled="disabled" name="total_amt[]" id="total_amt" class="form-control" value="<?php echo $paylistfetch['task_amount_aud']; ?>" />
                                                            <span>$ <?php echo number_format($paylistfetch['task_amount_aud'],3); ?></span>
                                                        </td>
                                                        <!--<td>-->
                                                            <input type="hidden" name="paid_amt[]" class="form-control" disabled="disabled" id="paid_amt" onkeyup="calfunction($(this));"  value="<?php echo $paylistfetch['paid_amt']; ?>" />
                                                        <!--</td>
                                                        <td>-->
                                                            <input type="hidden" name="payable_amt[]" class="form-control" disabled="disabled"id="payable_amt"  value="<?php echo $paylistfetch['payable_amt']; ?>" />
                                                        <!--</td>-->
<!--                                                        <td>
                                                            <select name="status[]" required="required" id="status[]" class="form-control" disabled="disabled" style="width:100%;">
                                                                <option value="">Select</option>
                                                                <option value="1" <?php if ($paylistfetch['status'] == '1') { ?> selected <?php } ?>>Paid</option>
                                                                <option value="2" <?php if ($paylistfetch['status'] == '2') { ?> selected <?php } ?>>Not Paid</option>
                                                            </select>
                                                        </td>							-->
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }?>
                                                    <tr><td colspan="8" style="text-align: right;font-weight:bold;">Total Amount : $ <?php echo number_format($total,3); ?></td></tr>  
                                            <?php } else {
                                                ?>
                                                <tr>
                                                    <td colspan="8" align="center"><strong>No Records Found</strong></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-4">
                            <label>Status  <span style="color:#FF0000;">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php echo(isset($_REQUEST['id'])) ? ($viewpay['status'] == '1') ? 'selected' : '' : 'selected'; ?>>Not Paid</option>
                                <option value="2" <?php echo(isset($_REQUEST['id'])) ? ($viewpay['status'] == '2') ? 'selected' : '' : ''; ?>>Paid</option>
                            </select>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-4">
                        <a href="<?php echo $sitename; ?>invoice/payslip.htm">Back to Listings page</a>
                    </div>
                     <div class="col-md-4">
                            <?php
                            if ($_REQUEST['id'] != '') {
                                ?>
                                <a target="_blank" href="<?php echo $fsitename; ?>MPDF/invoice/payslip.php?id=<?php echo $_REQUEST['id']; ?>" class="btn btn-info"><i class="fa fa-print"></i>&nbsp;&nbsp;View Pay Slip</a>
                        <?php } ?>
                                 <?php
                            if ($_REQUEST['id'] != '') {
                                ?>
                                <button type="submit" name="sendmails" class="btn btn-info"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Send Mail</button>
                        <?php } ?>
                        </div>
                    <div class="col-md-4">                
                            <?php 
                            if($viewpay['id']!=''){
                                if($viewpay['draft']=='1'){ ?>
                                    <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;margin-right:5px;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                                <?php }
                            }
                            ?>
                        </div>
                </div>
            </div>
            </div>
            </div>
        </form>
        <!-- /.box -->
    </section><!-- /.content 
</div><!-- /.content-wrapper -->
    <?php include ('../../require/footer.php'); ?>
    <script type="text/javascript">

        $('#cid').on('change', function () {
            var ts = $('#cid').val();
            //  alert(ts);
            $.ajax({
                url: "<?php echo $sitename; ?>pages/master/getsubcate.php",
                async: false,
                data: {pid: ts},
                success: function (data) {
                    $('#getsub').html(data);
                }
            });
        });
        function delrec(a, b) {
            if (confirm("Are you sure you want to remove this timing?")) {
                a.parent().parent().remove();
                var rtn = '';
                $.ajax({
                    url: "<?php echo $sitename; ?>pages/master/delthistime.php",
                    async: false,
                    data: {id: b},
                    success: function (data) {
                        rtn = '1';
                    }
                });
                if (rtn == '1') {

                }
            }
        }

        function imgchktore(a) {

            if (a != '')
            {
                $("#imagenameid").prop('required', true);
                $("#imagealtid").prop('required', true);
                $("#addstar").html('*');
                $("#addstar1").html('*');
            }

        }

    </script>
    <script>
        function showUser(str) {

            $("#one").hide();
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo $sitename; ?>pages/master/add_branch_statebg.php?q=" + str, true);
            xmlhttp.send();
        }
        function showUser1(str) {

            // $("#two").hide();
            if (str == "") {
                document.getElementById("txtHint1").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint1").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo $sitename; ?>pages/master/add_branch_citybg.php?z=" + str, true);
            xmlhttp.send();
        }
        function showUser2(str) {

            //$("#two").hide();
            if (str == "") {
                document.getElementById("city").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("city").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "<?php echo $sitename; ?>pages/master/add_branch_citybg.php?z=" + str, true);
            xmlhttp.send();
        }
    </script>

    <script type="text/javascript">


        $(document).on('click', 'input[name="asondate"]', function () {

            var checked = $(this).prop('checked');// true or false
            if (checked) {
                $(this).parents('tr').find('td input[name="asondate"]').val('1');
                $(this).parents('tr').find('td input[name="from_date"]').attr('disabled', 'disabled');
                $(this).parents('tr').find('td input[name="to_date"]').attr('disabled', 'disabled');
                $(this).parents('tr').find('td input[name="asondates"]').removeAttr('disabled');
                $(this).parents('tr').find('td input[name="from_date"]').val('');
                $(this).parents('tr').find('td input[name="to_date"]').val('');

            } else {
                $(this).parents('tr').find('td input[name="asondate"]').val('0');
                $(this).parents('tr').find('td input[name="asondates"]').val('');
                $(this).parents('tr').find('td input[name="from_date"]').removeAttr('disabled');
                $(this).parents('tr').find('td input[name="to_date"]').removeAttr('disabled');
                $(this).parents('tr').find('td input[name="asondates"]').attr('disabled', 'disabled');


            }
        });


        $(document).on('click', 'input[name="chkPassport[]"]', function () {

            var status = $(this).parents('tr').find('td select[name="status[]"]').find(':selected').val();

            /* if(status!='1')
             {*/
            var checked = $(this).prop('checked');// true or false
            if (checked) {
                $(this).parents('tr').find('td input[type="text"]').removeAttr('disabled');
                $(this).parents('tr').find('td input[type="hidden"]').removeAttr('disabled');
                $(this).parents('tr').find('td select').removeAttr('disabled');
            } else {
                $(this).parents('tr').find('td input[type="text"]').attr('disabled', 'disabled');
                $(this).parents('tr').find('td input[type="hidden"]').attr('disabled', 'disabled');
                $(this).parents('tr').find('td select').attr('disabled', 'disabled');
            }
            /* } */
        });
        function calfunction(elem)
        {            
            var new_elem = $(elem).parents('tr').find('td');
            var basic_rate = new_elem.find('input[name="empunitprice[]"]').val() || 0;
            var qty = new_elem.find('input[name="emptask_quty[]"]').val() || 0;
            var extra = new_elem.find('input[name="emptask_extra_amt[]"]').val() || 0;
            var total = (parseFloat(basic_rate) * parseFloat(qty)) + parseFloat(extra);
            new_elem.find('input[name="total_amt[]"]').val(total.toFixed(2));
            new_elem.find('span').html('$ ' + total.toFixed(2));
//            var totalamt = new_elem.find('input[name="total_amt[]"]').val(total.toFixed(2));            
            //var paidamt = new_elem.find('input[name="paid_amt[]"]').val();
            //var payableamt = parseFloat(totalamt) - parseFloat(paidamt);
//            new_elem.find('input[name="payable_amt[]"]').val(payableamt.toFixed(2));
//            new_elem.find('input[name="payable_amt[]"]').val(total.toFixed(2));

        }
        function check_pays(){
            if($('input[name="chkPassport[]"]:checked').length > 0){
                return true;
            }else{
                alert("Please select atleast one pay");
                return false;
            }
        }
    </script>