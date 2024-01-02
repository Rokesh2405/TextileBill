<?php
$menu = "3,5,,45";
$thispageid = 40;
$ze = 40;
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = 1;
include ('../../require/header.php');

if ($_REQUEST['id'] != '') {
    $get1 = $db->prepare("SELECT * FROM `expense` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $fetched = $get1->fetch(PDO::FETCH_ASSOC);
    if ($fetched['id'] == '') {
        header("location:" . $sitename . 'accounts/expense_entry.htm');
        exit;
    }
}

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];    
    if ($_REQUEST['id'] == '') {
        
		list($ledger, $amount, $paytype, $bank) = null_zero(array($ledger, $amount, $paytype, $bank));
		
                $insert = $db->prepare("INSERT INTO `expense` SET `bill_no`=?,`date`=?, `ledger_id`=?, `amount`=?, `pay_type`=?, `bank`=?, `bank_pay_type`=?, `bank_date`=?, `description`=?, `ip`=?");

                if ($paytype == '2') {

                    $ledg = getbank('ledger_id', $bank);
                } else {
                    $ledg = '176';
                    $bank = '0';
                    $cheque = Null;
                    $cdate = Null;
                }
                $insert->execute(array($bill_no,date("Y-m-d", strtotime($date)), $ledger, $amount, $paytype, $bank, $cheque, $cdate, $desc, $ip));
                $lsid = $db->lastInsertId();

                add_transaction($bill_no, date("Y-m-d", strtotime($date)), $ledger, $amount, $lsid, 'Expense', 'C');
                add_transaction($bill_no, date("Y-m-d", strtotime($date)), $ledg, $amount, $lsid, 'Expense', 'D');

               

        $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Saved</h4></div>';
    } else {

		list($ledger, $amount, $paytype, $bank) = null_zero(array($ledger, $amount, $paytype, $bank));
        $insert = $db->prepare("UPDATE `expense` SET `bill_no`=?,`date`=?, `ledger_id`=?,`amount`=?,`pay_type`=?, `bank`=?, `bank_pay_type`=?, `bank_date`=?, `description`=?, `ip`=? WHERE `id`=?");


        if ($paytype == '2') {

            $ledg = getbank('ledger_id', $bank);
        } else {
            $ledg = '176';
            $bank = '0';
            $cheque = Null;
            $cdate = Null;
        }
        $insert->execute(array($bill_no,date("Y-m-d", strtotime($date)), $ledger, $amount, $paytype, $bank, $cheque, date("Y-m-d", strtotime($cdate)), $desc, $ip, $fetched['id']));

            transaction_del($fetched['id'], 'Expense');

            add_transaction($bill_no, date("Y-m-d", strtotime($date)), $ledger, $amount, $fetched['id'], 'Expense', 'C');
            add_transaction($bill_no, date("Y-m-d", strtotime($date)), $ledg, $amount, $fetched['id'], 'Expense', 'D');
      
        $get1 = $db->prepare("SELECT * FROM `expense` WHERE `id`=?");
        $get1->execute(array($_REQUEST['id']));
        $fetched = $get1->fetch(PDO::FETCH_ASSOC);
        
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }

}

?>
<style type="text/css">
    .select2-container--default .select2-selection--single{
        height: 34px;
        border-radius: 0;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Expense Entry
           <!--  <small>
            <?php
            if ($_REQUEST['lid'] != '') {
                echo 'Edit';
            } else {
                echo 'Add New';
            }
            ?>
                 Item Type</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa fa-money"></i> Accounts</li>
            <li><a href="<?php echo $sitename; ?>accounts/expense_entry.htm"><i class="fa fa-circle-o"></i> Expense Entry </a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Expense Entry</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title"><?php
                    if ($_REQUEST['lid'] != '') {
                        echo 'Edit';
                    } else {
                        echo 'Add New';
                    }
                    ?> &nbsp;Item Type</h3>-->
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg;
                    ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Expense Entry</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">                                                               
                                <div class="col-md-3">
                                    <label>Date<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control usedatepicker" placeholder="Date" name="date"   value="<?php echo ($fetched['date'] != '') ? date("d-m-Y", strtotime($fetched['date'])) : ''; ?>" required="required"  />
                                </div>
                                <div class="col-md-3">
                                    <label>Bill No<span style="color:#FF0000;">*</span></label>
                                    <input type="text" name="bill_no" id="bill_no" required class="form-control" value="<?php echo $fetched['bill_no']; ?>" />
                                </div>
                                <div class="col-md-3">
                                    <label>Ledger<span style="color:#FF0000;">*</span></label>
                                    <select name="ledger" required id="ledger" class="form-control select2">
                                        <option value="">Select Ledger</option>
                                        <?php 
                                            $ls = $db->prepare("SELECT * FROM `ledger` WHERE `under`=?");
                                            $ls->execute(array('43'));
                                            while($fs = $ls->fetch()){                                                
                                        ?>
                                        <option value="<?php echo $fs['lid']; ?>" <?php if($fetched['ledger_id']==$fs['lid']){
                                                    echo "selected";
                                                } ?>><?php echo $fs['Name']; ?></option>;
                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Amount<span style="color:#FF0000;">*</span></label>
                                    <input type="text" name="amount" id="amount" required class="form-control" value="<?php echo $fetched['amount']; ?>" />
                                </div>
                            </div>

                            <br />
                            <div class="container-fluit">
                                <div class="row bankdetails">
                                    <div class="col-md-3">
                                        <label>Pay Type <span style="color:#FF0000;">*</span></label>

                                        <select name="paytype" id="paytype" onchange="getcash(this.value)" class="form-control" required="required">
                                            <option value="">Select Type</option>
                                            <option value="1" <?php echo ($fetched['pay_type'] == '1') ? 'selected' : ''; ?>>Cash</option>
                                            <option value="2" <?php echo ($fetched['pay_type'] == '2') ? 'selected' : ''; ?>>Bank</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 bankdata" <?php echo ($fetched['pay_type'] == '2') ? '' : 'style="display:none"'; ?> id="bank" >
                                        <label>Bank<span style="color:#FF0000;">*</span></label>
                                        <select class="form-control requireds" <?php echo ($fetched['pay_type'] == '2') ? 'required' : ''; ?>  name="bank">
                                            <option value="">Select Bank</option>
                                            <?php
                                            $sup = $db->prepare("SELECT * FROM `bank` WHERE `Status`=? ");
                                            $sup->execute(array(1));
                                            while ($s = $sup->fetch()) {
                                                $selc = '';
                                                if ($fetched['bank'] == $s['BankID']) {
                                                    $selc = 'selected';
                                                }
                                                echo '<option value="' . $s['BankID'] . '" ' . $selc . '>' . $s['Bank_Name'] . '</option> ';
                                            }
                                            ?>         
                                        </select>      
                                    </div>
                                    <div class="col-md-3 bankdata" <?php echo ($fetched['pay_type'] == '2') ? '' : 'style="display:none"'; ?> id="cheque" >
                                        <label>Cheque/DD/Transaction No<span style="color:#FF0000;">*</span></label>
                                        <input type="text" class="form-control requireds" placeholder="Cheque/DD/Transaction No" name="cheque"   value="<?php echo $fetched['bank_pay_type']; ?>" pattern="[a-z A-Z 0-9.,-]{0,100}" title="Allowed Attribute [a-z A-Z 0-9.,-]{0,100}" <?php echo ($fetched['pay_type'] == '2') ? 'required' : ''; ?> />          
                                    </div>
                                    <div class="col-md-3 bankdata" <?php echo ($fetched['pay_type'] == '2') ? '' : 'style="display:none"'; ?> id="date">
                                        <label>Date<span style="color:#FF0000;">*</span></label>
                                        <input type="text" class="form-control usedatepicker requireds" placeholder="Date" name="cdate"  <?php echo ($fetched['pay_type'] == '2') ? 'required' : ''; ?>  value="<?php echo ($fetched['bank_date']) ? date("d-m-Y", strtotime($fetched['bank_date'])) : date('d-m-Y'); ?>" />
                                    </div> 

                                </div> <br/> 
                                <div class="row">
                                    <div class="col-md-12 " id="textarea">
                                        <label>Description</label>
                                        <textarea  rows="6" class="form-control " col="80" name="desc"  ><?php echo $fetched['description']; ?></textarea>    <input type="hidden" value="<?php echo $fi_hi ?>" id="curr_hid" name="curr_hid">
                                    </div></div>
                                <?php /*if ($_REQUEST['id'] != '') { ?>
                                    <div class="row">        
                                        <div class="col-md-12">
                                            <br>
                                            <a target="_blank" href="<?php echo $sitename; ?>MPDF53/credit.php?enqid=<?php echo $_REQUEST['id']; ?>" class="btn btn-info fa fa-print"></a> 
                                        </div>
                                    </div>    
                                <?php }*/ ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?php echo $sitename; ?>accounts/expense_entry.htm">Back to Listings page</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                        if ($_REQUEST['lid'] != '') {
                                            echo 'UPDATE';
                                        } else {
                                            echo 'SAVE';
                                        }
                                        ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                
                
<!--                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        <button type="submit" name="submit" class="btn btn-success">Save</button>
                    </div>
                </div>-->
            </div>
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php include ('../../require/footer.php'); ?>
<script>
    function getsuptrans(a) {
        $.ajax({
            type: "POST",
            url: "<?php echo $sitename . 'pages/master/userajax.php' ?>",
            dataType: 'JSON',
            data: {id: a, payment: 'get'},
            success: function (data) {
                $('#data_pay').html(data['r']);
                if (data['nodata'] != 1) {
                   $('#tot_amt').html('Total Amount ('+ data['curr'] +') : ' + data['tot']);
                    $('#rec_amt_hid').val(data['rec']);
                    $('#rec_amt').html('Received Amount ('+ data['curr'] +') : ' + data['rec']);
                    $('#bal_amt_hid').val(data['bal']);
                    $('#bal_amt').html('Balance Amount ('+ data['curr'] +') : ' + data['bal']);
                    $('#count_i').val(data['count']);
                    $('.curr').html('(' + data['curr'] + ')')
                    $('#curr_hid').val(data['curr']);
                }
            },
        });
    }
    function getcash(a) {
        if (a == '2') {
            $('.bankdata').show();
            $('.bankdata input,.bankdata select').attr('required', 'required');
        } else {
            $('.bankdata').hide();
            $('.bankdata input,.bankdata select').removeAttr('required');
        }
    }
    function paynow1212() {
        var count = $('#count_i').val();
        var i = 1;
        var curr = $('#curr_hid').val();
        var tot_may = 0;
        var rec_amt = $('#rec_amt_hid').val();
        var bal_amt = $('#bal_amt_hid').val();
        for (i = 1; i <= count; i++) {
            tot_may += parseFloat($('#paynow' + i).val()) || parseFloat(0);
        }
        var tot_rec = parseFloat(rec_amt) + parseFloat(tot_may);
        var tot_bal = parseFloat(bal_amt) - parseFloat(tot_may);
        $('#rec_amt').html('Received Amount ('+ curr +') : ' + tot_rec);
        $('#bal_amt').html('Balance Amount ('+ curr +') : ' + tot_bal);
        $('#show_total').html('Total Amount ('+ curr +') : ' + tot_may);
    }
</script>