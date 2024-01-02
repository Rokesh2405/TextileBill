<?php
$menu = "3,2,2,45";
$thispageid = 40;
$ze = 40;
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = 1;
include ('../../require/header.php');
/*
if ($_REQUEST['id'] != '') {
    $get1 = $db->prepare("SELECT * FROM `accounts_payment` WHERE `id`=? AND `type`=?");
    $get1->execute(array($_REQUEST['id'],'C'));
    $fetched = $get1->fetch(PDO::FETCH_ASSOC);
    if ($fetched['id'] == '') {
        header("location:" . $sitename . 'accounts/expense_entry.htm');
        exit;
    }
}


if (isset($_POST['print'])) {
    $img = "<img src='" . $fsitename . "pages/profile/image/" . getprofile('image', $_SESSION['UID']) . "' />";
    $company_name = getprofile('Company_name', $_SESSION['UID']);
    $phonenumber = getprofile('phonenumber', $_SESSION['UID']);
    $email = getprofile('recoveryemail', $_SESSION['UID']);
    $address = "UNIT 2,-18-02, TOWER 2, VSQ @ PJCC, 
JALAN UTARA, 46200 PETALING JAYA, 
SELANGOR DARUL EHSAN ";


    $PRODUCTS = '<style type="text/css">
                        .tg  {border-collapse:collapse;border-spacing:0;}
                        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 11px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 11px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                        .tg .tg-9hbo{font-weight:bold;vertical-align:top}
                        .tg .tg-yw4l{vertical-align:top}
                        </style>
                        <table class="tg" border="1" width="100%">
                          <tr>
                            <th class="tg-9hbo">Bill No</th>
                            <th class="tg-9hbo">Bill Name</th>
                            <th class="tg-9hbo">Total Amount(RM)</th>
                            <th class="tg-9hbo">Received Amount(RM)</th>
                            <th class="tg-9hbo">Balance(RM)</th>
                          </tr>';
    $pds = $db->prepare("SELECT * FROM ``accounts_payment` WHERE `id`=? AND `type`=?");
    $pds->execute(array($_REQUEST['enquiryid'], 'C'));
    while ($fpds = $pds->fetch()) {
        $PRODUCTS .= '<tr>
                            <td class="tg-yw4l">' . gettransaction('bill_no', $fpds['bill_no']) . '</td>
                            <td class="tg-yw4l">' . gettransaction('bill_date', $fpds['bill_date']) . '</td>
                            <td class="tg-yw4l">' . gettransaction('amount', $fpds['amount']) . '</td>
                            <td class="tg-yw4l">' . $fpds['received_amount'] . '</td>
                            <td class="tg-yw4l">' . $fpds['balance_amount'] . '</td>
                          </tr>';
    }
    $PRODUCTS .= '</table>';
    $placeHolders = [
        '$@LOGO$@$',
        '$@COMPANY_NAME@$',
        '$@ADDRESS@$',
        '$@PHONE@$',
        '$@EMAIL@$',
        '$@FAX@$',
        '$@PRODUCTS@$',
        '$@SUPPLIERNAME@$'
    ];

    $values = [
        $img,
        $company_name,
        $address,
        $phonenumber,
        $email,
        '7777777',
        $PRODUCTS,
        getsupplier('Supplier_name', $fpds['supplier'])
    ];

    if (isset($_POST['send_email'])) {
        $TO = getsupplier('E-mail', getrfq('supplier', $_REQUEST['enquiryid']));
        $MESSAGE = getTableValue('email_template', 'message', '2');
        $SUBJECT = getTableValue('email_template', 'subject', '2');
        $MESSAGE = str_replace($placeHolders, $values, $MESSAGE);

        $HEADERS = 'MIME-Version: 1.0' . "\r\n";
        $HEADERS .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $HEADERS .= 'From: IMPA ERP <' . getprofile('recoveryemail', $_SESSION['UID']) . ">\r\n";
        //echo $TO, $SUBJECT, $MESSAGE, $HEADERS;
        // exit;
        //continue;
        mail($TO, $SUBJECT, $MESSAGE, $HEADERS);
        $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Sent</h4></div>';
    } else {
        require_once '../../MPDF53/vendor/autoload.php';
        $MESSAGE = getTableValue('print_template', 'message', '2');
        $MESSAGE = str_replace($placeHolders, $values, $MESSAGE);
        $mpdf = new mPDF();
        //  new \Mpdf\Mpdf();
        //$mpdf = new mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);

        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
        $filename = "test.txt";

        $file = fopen($filename, "w");
        fwrite($file, $MESSAGE);
        $mpdf->SetTitle('Credit Note Report');
        $mpdf->keep_table_proportions = false;
        $mpdf->WriteHTML(file_get_contents($filename));
        $mpdf->Output('yourFileName.pdf', 'I');
    }
}
$msg1 = $_SESSION['sucmsg'];
/*
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];    
    if ($_REQUEST['id'] == '') {
        
        foreach($paynow as $keys => $pays){
            
            $get1 = $db->prepare("SELECT * FROM `transactions` WHERE `id`=?");
            $get1->execute(array($_POST['bill_id'][$keys]));
            $get = $get1->fetch(PDO::FETCH_ASSOC);

            
            if($pays != ''){
                $insert = $db->prepare("INSERT INTO `accounts_payment` SET `type`=?,`supplier`=?, `date`=?, `bill_id`=?,`bill_no`=?,`bill_date`=?, `amount`=?,`received_amount`=?,`balance_amount`=?,`pay_now_amount`=?, `pay_type`=?, `bank`=?, `bank_pay_type`=?, `bank_date`=?, `description`=?, `ip`=?,`transaction`=? ");

                if ($paytype == '2') {

                    $ledg = getbank('ledger_id', $bank);
                } else {
                    $ledg = '176';
                    $bank = '0';
                    $cheque = Null;
                    $cdate = Null;
                }
                $insert->execute(array('C',$supplier, date("Y-m-d", strtotime($date)), $get['ref_id'], $get['bill_no'], $get['bill_date'], $get['amount'], $pays, ($get['amount'] - $pays), $pays, $paytype, $bank, $cheque, $cdate, $desc, $ip, $_POST['bill_id'][$keys]));
                $lsid = $db->lastInsertId();

                $uts = $db->prepare("UPDATE `transactions` SET `return_amount` = (`return_amount` + ?) WHERE `id`= ?");
                $uts->execute(array($pays, $_POST['bill_id'][$keys]));

                add_transaction($get['bill_no'], date("Y-m-d"), $get['ledger_id'], $pays, $lsid, 'Payment', 'C');
                add_transaction($get['bill_no'], date("Y-m-d"), $ledg, $pays, $lsid, 'Payment', 'D');

            }
        }        

        $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Saved</h4></div>';
    } else {

         $get1 = $db->prepare("SELECT * FROM `transactions` WHERE `id`=?");
            $get1->execute(array($_POST['bill_id']));
            $get = $get1->fetch(PDO::FETCH_ASSOC);
        $insert = $db->prepare("UPDATE `accounts_payment` SET `type`=?,`date`=?,`amount`=?,`received_amount`=?,`balance_amount`=?,`pay_now_amount`=?, `pay_type`=?, `bank`=?, `bank_pay_type`=?, `bank_date`=?, `description`=?, `ip`=? WHERE `id`=? ");


        if ($paytype == '2') {

            $ledg = getbank('ledger_id', $bank);
        } else {
            $ledg = '176';
            $bank = '0';
            $cheque = Null;
            $cdate = Null;
        }
        $insert->execute(array('C',date("Y-m-d", strtotime($date)), $fetched['amount'], $paynow, ($fetched['amount'] - $paynow), $paynow, $paytype, $bank, $cheque, date("Y-m-d", strtotime($cdate)), $desc, $ip, $fetched['id']));

        if ($paynow != '') {

            transaction_del($fetched['id'], 'Payment');

            $uts = $db->prepare("UPDATE `transactions` SET `return_amount` = ((`return_amount` - ?) + ?) WHERE `id`=?");
            $uts->execute(array($fetched['pay_now_amount'], $paynow, $_POST['bill_id']));

            add_transaction($get['bill_no'], date("Y-m-d"), $get['ledger_id'], $paynow, $fetched['id'], 'Payment', 'C');
            add_transaction($get['bill_no'], date("Y-m-d"), $ledg, $paynow, $fetched['id'], 'Payment', 'D');
        }
        $get1 = $db->prepare("SELECT * FROM `accounts_payment` WHERE `id`=? AND `type`=?");
        $get1->execute(array($_REQUEST['id'],'C'));
        $fetched = $get1->fetch(PDO::FETCH_ASSOC);
    }

    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
}
*/
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Journal Entry
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
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-file-o"></i>Accounts</a></li>
            <li><a href="<?php echo $sitename; ?>accounts/journal_entry.htm">Journal Entry </a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Journal Entry</li>
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
                            <div class="panel-title">Journal Entry</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">                                                               
                                <div class="col-md-4">
                                    <label>Date<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control usedatepicker" placeholder="Date" name="date"   value="<?php echo ($fetched['date'] != '') ? date("d-m-Y", strtotime($fetched['date'])) : ''; ?>" required="required"  />
                                </div>

                            </div>

                            <br />
                            <div class="container-fluit">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="panel-title"><br/></div>
                                    </div>
                                    <div class="panel-body">  
                                        <div class="table-responsive">
                                           <?php $fi = '';
                                           ?>
                                            <table id="normalexamples" class="table table-bordered table-striped" style="width: 100%">
                                                <thead>
                                                <th style="width:10%">Ledger Name</th>
                                                <th style="width:10%">Bill No</th>
                                                <th style="width:10%">Bill Date</th>
                                                <th style="width:17%;text-align:center">Total Amount <?php echo $fi; ?> <label class="curr"></label></th>
                                                <th style="width:17%;text-align:center">Received Amount <?php echo $fi; ?> <label class="curr"></label></th>
                                                <th style="width:17%;text-align:center">Balance <?php echo $fi; ?> <label class="curr"></label></th>
                                                <th style="width:19%;text-align:center">Amount</th>
                                                </thead>
                                                 <?php /*
                                                <tbody id="data_pay">
                                                   
                                                   $sup = $db->prepare("SELECT `lid`,`Name` FROM `ledger` WHERE `Status`=? AND `under`=? ");
                                                   $sup->execute(array(1,16)); 
                                                  if($sup->rowCount() > 0){
                                                   while($led = $sup->fetch()){
                                                     $tras = $db->prepare("SELECT * FROM `transactions` WHERE `ledger_id`=? ");
                                                     $tras->execute(array($led['lid']));
                                                    
                                                     while($tr = $tras->fetch()){                                                         
                                                   ?>                                                 
                                                    <tr>
                                                        <td style="width:10%"><?php echo $led['Name']; ?></td>
                                                        <td style="width:10%"><?php echo $tr['bill_no']; ?></td>
                                                        <td style="width:10%"><?php echo $tr['bill_date']; ?></td>
                                                        <td style="width:17%;text-align:center"><?php echo number_format($tr['amount'],2); ?></td>
                                                        <td style="width:17%;text-align:center"><?php echo number_format($tr['received_amount'],2); ?></td>
                                                        <td style="width:17%;text-align:center"><?php echo number_format($tr['balance_amount'],2); ?></td>
                                                        <td style="width:19%;text-align:center"><input type="text" class="form-contorl" onkeyup="paynow1212()" id="paynow<?php echo $i; ?>" name="paynow" value="" /></td>
                                                    </tr>
                                                    <?php
                                                      } 
                                                    }
                                                  }else{                                                    
                                                ?>
                                                <tr>
                                                    <td colspan="6" style="text-align:center">No Data Found</td>
                                                </tr></tbody>
                                                  <?php } */ ?>
                                                
                                            </table>
                                        </div>
                                         <div class="row">
                                            <div class="col-md-3">
                                                <h4 id="tot_amt">Total Amount <?php echo $fi; ?> : <?php echo number_format(($fetched['amount']) ? $fetched['amount'] : '0.00',2); ?></h4>                                                
                                            </div>
                                            <div class="col-md-3">
                                                <h4 id="rec_amt">Received Amount <?php echo $fi; ?> : <?php echo number_format(($fetched['received_amount']) ? $fetched['received_amount'] : '0.00',2); ?></h4>
                                                <input type="hidden" id="rec_amt_hid" value="<?php echo ($fetched['received_amount']) ? $fetched['received_amount'] : '0.00'; ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <h4 id="bal_amt">Balance Amount <?php echo $fi; ?> : <?php echo number_format(($fetched['balance_amount']) ? $fetched['balance_amount'] : '0.00',2); ?></h4>
                                                <input type="hidden" id="bal_amt_hid" value="<?php echo ($fetched['balance_amount']) ? $fetched['balance_amount'] : '0.00'; ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" id="total_hid" name="total" value="0.00" />
                                                <input type="hidden" id="count_i" name="count_" value="1" />
                                                <h4 id="show_total" style="float: right;">Total Amt <label class="curr"><?php echo $fi; ?></label> : 0.00</h4>
<!--                                                <h4 id="bal_amt">Total Amount <?php echo $fi; ?> : <?php echo number_format(($fetched['pay_now_amount']) ? $fetched['pay_now_amount'] : '0.00',2); ?></h4>
                                                <input type="hidden" id="total_hid" value="<?php echo ($fetched['pay_now_amount']) ? $fetched['pay_now_amount'] : '0.00'; ?>">-->
                                            </div>
                                        </div>

                                    </div>
                                </div> 

                            </div>
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
                                <?php if ($_REQUEST['id'] != '') { ?>
                                    <div class="row">        
                                        <div class="col-md-12">
                                            <br>
                                            <a target="_blank" href="<?php echo $sitename; ?>MPDF53/credit.php?enqid=<?php echo $_REQUEST['id']; ?>" class="btn btn-info fa fa-print"></a> 
                                        </div>
                                    </div>    
                                <?php } ?>
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
<script type="text/javascript">
    $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.htm?types=journal_entry"
    });
</script>
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