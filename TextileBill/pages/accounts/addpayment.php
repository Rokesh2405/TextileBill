<?php
$menu = "3,5,,43";
$thispageid = 43;
$ze = 43;
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = 1;
include ('../../require/header.php');

if ($_REQUEST['id'] != '') {
    $get1 = $db->prepare("SELECT * FROM `accounts_payment` WHERE `id`=? AND `type`=?");
    $get1->execute(array($_REQUEST['id'],'P'));
    $fetched = $get1->fetch(PDO::FETCH_ASSOC);
    if ($fetched['id'] == '') {
        header("location:" . $sitename . 'accounts/payment.htm');
        exit;
    }
}

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];    
    if ($_REQUEST['id'] == '') {
        $i = '';
        foreach($paynow as $keys => $pays){
            
            $get1 = $db->prepare("SELECT * FROM `transactions` WHERE `id`=?");
            $get1->execute(array($_POST['bill_id'][$keys]));
            $get = $get1->fetch(PDO::FETCH_ASSOC);
			
            list($get['ref_id'], $get['amount'], $pays, $paytype, $bank, $_POST['bill_id']) = null_zero(array($get['ref_id'], $get['amount'], $pays, $paytype, $bank, $_POST['bill_id']));
			
            if($pays != ''){
                $i = 1;
                $insert = $db->prepare("INSERT INTO `accounts_payment` SET `type`=?,`supplier`=?, `date`=?, `bill_id`=?,`bill_no`=?,`bill_date`=?, `amount`=?,`received_amount`=?,`balance_amount`=?,`pay_now_amount`=?, `pay_type`=?, `bank`=?, `bank_pay_type`=?, `bank_date`=?, `description`=?, `ip`=?,`transaction`=? ");

                if ($paytype == '2') {

                    $ledg = getbank('ledger_id', $bank);
                } else {
                    $ledg = '176';
                    $bank = '0';
                    $cheque = Null;
                    $cdate = Null;
                }
                $insert->execute(array('P',$supplier, date("Y-m-d", strtotime($date)), $get['ref_id'], $get['bill_no'], $get['bill_date'], $get['amount'], $pays, ($get['amount'] - $pays), $pays, $paytype, $bank, $cheque, date("Y-m-d", strtotime($cdate)), $desc, $ip, $_POST['bill_id'][$keys]));
                $lsid = $db->lastInsertId();

                $uts = $db->prepare("UPDATE `transactions` SET `received_amount` = (`received_amount` + ?) WHERE `id`= ?");
                $uts->execute(array($pays, $_POST['bill_id'][$keys]));

                add_transaction($get['bill_no'], date("Y-m-d"), $get['ledger_id'], $pays, $lsid, 'Payment', 'C');
                add_transaction($get['bill_no'], date("Y-m-d"), $ledg, $pays, $lsid, 'Payment', 'D');

            }
        }        
        if($i != ''){
         $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Saved</h4></div>';   
        }else{
          $msg = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-exclamation-triangle"></i>Payment Amount Empty</h4></div>';    
        }        
    } else {

         $get1 = $db->prepare("SELECT * FROM `transactions` WHERE `id`=?");
            $get1->execute(array($_POST['bill_id']));
            $get = $get1->fetch(PDO::FETCH_ASSOC);
        $insert = $db->prepare("UPDATE `accounts_payment` SET `type`=?,`date`=?,`amount`=?,`received_amount`=?,`balance_amount`=?,`pay_now_amount`=?, `pay_type`=?, `bank`=?, `bank_pay_type`=?, `bank_date`=?, `description`=?, `ip`=? WHERE `id`=? ");

		list($get['ref_id'], $get['amount'], $pays, $paytype, $bank, $_POST['bill_id']) = null_zero(array($get['ref_id'], $get['amount'], $pays, $paytype, $bank, $_POST['bill_id']));
        
		if ($paytype == '2') {

            $ledg = getbank('ledger_id', $bank);
        } else {
            $ledg = '176';
            $bank = '0';
            $cheque = Null;
            $cdate = Null;
        }
        $insert->execute(array('P',date("Y-m-d", strtotime($date)), $fetched['amount'], $paynow, ($fetched['amount'] - $paynow), $paynow, $paytype, $bank, $cheque, date("Y-m-d", strtotime($cdate)), $desc, $ip, $fetched['id']));

        if ($paynow != '') {

            transaction_del($fetched['id'], 'Payment');

            $uts = $db->prepare("UPDATE `transactions` SET `received_amount` = ((`received_amount` - ?) + ?) WHERE `id`=?");
            $uts->execute(array($fetched['pay_now_amount'], $paynow, $_POST['bill_id']));

            add_transaction($get['bill_no'], date("Y-m-d"), $get['ledger_id'], $paynow, $fetched['id'], 'Payment', 'C');
            add_transaction($get['bill_no'], date("Y-m-d"), $ledg, $paynow, $fetched['id'], 'Payment', 'D');
        }
        $get1 = $db->prepare("SELECT * FROM `accounts_payment` WHERE `id`=? AND `type`=?");
        $get1->execute(array($_REQUEST['id'],'P'));
        $fetched = $get1->fetch(PDO::FETCH_ASSOC);
         $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }

   
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Payment
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
            <li><a href="<?php echo $sitename; ?>accounts/payment.htm"><i class="fa fa-circle-o"></i> Payment </a></li>
            <li class="active"><?php
                if ($_REQUEST['lid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Payment</li>
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
                            <div class="panel-title">Payment</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Supplier <span style="color:#FF0000;">*</span></label>
                                    <?php
                                    if ($_REQUEST['id'] != '') {
                                        $disabled = 'disabled';
                                        //echo "<input type='hidden' name='supplier' id='supplier' />";
                                    }
                                    ?>
                                    <div class="input-group">
                                        <input type="text" name="supplier_view" id="supplier_view" value="<?php echo getsupplier('Company', $fetched['supplier']); ?>" readonly class="form-control" <?php echo $disabled; ?> />
                                        <input type='hidden' name='supplier' id='supplier' value="<?php echo $fetched['supplier']; ?>" />
                                         <?php
                                            if ($_REQUEST['id'] == '') { ?>
                                        <div class="input-group-addon">
                                            <i class="fa fa-search" id="load_sup" data-toggle="modal" data-target="#myModal"></i>
                                        </div>
                                        <?php } ?>
                                    </div>  
                                </div>
                                <div class="col-md-4">
                                    <div  <?php if($fetched['supplier']==''){ echo 'style="display:none;"'; } ?>  id="suppanel">
                                        <div class="row">
                                            <br />
                                            <div class="col-md-12">
                                                <img style="padding-bottom:10px;"  id="supp_logeo" <?php if(getsupplier('Image', $fetched['supplier'])!=''){ ?> src="<?php echo $fsitename; ?>images/supplier/<?php echo getsupplier('Image', $fetched['supplier']); ?>" <?php } ?>  height="100" />
                                            </div>
                                            <div class="col-md-12" >
                                                <label style="display: block !important; font-size:20px;" id="compa_name"><?php echo getsupplier('Company', $fetched['supplier']); ?></label>
                                                <label style="display: block !important;" id="supp_code"><?php echo getsupplier('Supplier_name', $fetched['supplier']); ?></label>
                                                <label style="display: block !important; font-weight:400 !important;" id="supp_address"><?php echo getsupplier('Adderss_1', $fetched['supplier']); ?></label>
                                                <label style="display: block !important; font-weight:400 !important;" id="supp_state"><?php echo st(getsupplier('State', $fetched['supplier'])); ?></label>
                                                <label style="display: block !important; font-weight:400 !important;" id="supp_city"><?php echo ci('name',getsupplier('City', $fetched['supplier'])); ?></label>
                                                <label style="display: block !important; font-weight:400 !important;" id="supp_county"><?php echo co('name',getsupplier('Country', $fetched['supplier'])); ?></label>
                                                <label style="display: block !important; font-weight:400 !important;" id="supp_postcode"><?php echo getsupplier('Postcode', $fetched['supplier']); ?></label>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Date<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control usedatepicker" placeholder="Date" name="date"   value="<?php echo ($fetched['date'] != '') ? date("d-m-Y", strtotime($fetched['date'])) : date("d-m-Y"); ?>" required="required"  />
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
                                           if ($_REQUEST['id'] != '') {     
                                                       $curr = $db->prepare("SELECT `Currency` FROM `suppliers` WHERE `SupID`=? ");
                                                        $curr->execute(array($fetched['supplier']));
                                                        $cu = $curr->fetch();

                                                        $sym = $db->prepare("SELECT `code` FROM `currency_new` WHERE `id`=? ");
                                                        $sym->execute(array($cu['Currency']));
                                                        $sy = $sym->fetch();
                                         $fi = '('.Currency($sy['code']).')'; $fi_hi = Currency($sy['code']);  } ?>
                                            <table class="table" width="100%">
                                                <thead>
                                                <th>Bill No</th>
                                                <th>Bill Date</th>
                                                 <th style="text-align:right">Total Amount <?php echo $fi; ?> <label class="curr"></label></th>
                                                <th style="text-align:right">Received Amount <?php echo $fi; ?> <label class="curr"></label></th>
                                                <th style="text-align:right">Balance <?php echo $fi; ?> <label class="curr"></label></th>
                                                <th>Amount</th>
                                                </thead>
                                                <tbody id="data_pay">
                                                    <?php
                                                    if ($_REQUEST['id'] != '') {
                                                        $i = 1;
                                                        ?>
                                                    <input type="hidden" name="bill_id" value="<?php echo $fetched['transaction']; ?>"> 
                                                    <tr>
                                                        <td><?php echo $fetched['bill_no']; ?></td>
                                                        <td><?php echo date("d-m-Y", strtotime($fetched['bill_date'])); ?></td>
                                                       <td align="right"><?php echo number_format($fetched['amount'],2); ?></td>
                                                        <td align="right"><?php echo number_format($fetched['received_amount'],2); ?></td>
                                                        <td align="right"><?php echo number_format($fetched['balance_amount'],2); ?></td>
                                                        <td><input type="text" class="form-contorl" onkeyup="paynow1212()" id="paynow<?php echo $i; ?>" name="paynow" value="<?php echo $fetched['received_amount']; ?>" /></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                </tbody>
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
                                                <h4 id="show_total" style="float: right;">Total Amt <label class="curr"><?php echo $fi; ?></label> : <?php echo ($fetched['pay_now_amount']) ? number_format($fetched['pay_now_amount'],2) : '0.00'; ?></h4>
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
                                        <input type="text" class="form-control usedatepicker requireds" placeholder="Date" name="cdate"  <?php echo ($fetched['pay_type'] == '2') ? 'required' : ''; ?>  value="<?php echo ($fetched['bank_date']) ? date("d-m-Y", strtotime($fetched['bank_date'])) : date('d-m-Y'); ?>"  />
                                    </div> 

                                </div> <br/> 
                                <div class="row">
                                    <div class="col-md-12 " id="textarea">
                                        <label>Description</label>
                                        <textarea  rows="6" class="form-control " col="80" name="desc"  ><?php echo $fetched['description']; ?></textarea>   <input type="hidden" value="<?php echo $fi_hi ?>" id="curr_hid" name="curr_hid">
                                    </div></div>
                            </div>








                        </div>
                    </div>
                </div>
                <div class="box-footer">
                       <div class="col-md-6">
                                    <a href="<?php echo $sitename; ?>accounts/payment.htm">Back to Listings page</a>
                                </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" name="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose from register</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:15%">Supplier Group</th>
                                    <th style="width:15%">Company Name</th>
                                    <th style="width:25%">Supplier Name</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 20%;"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>                            
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
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
                }else{
                     $('#tot_amt').html('Total Amount ('+ data['curr'] +') : 0.00');
                    $('#rec_amt_hid').val('0.00');
                    $('#rec_amt').html('Received Amount ('+ data['curr'] +') : 0.00');
                    $('#bal_amt_hid').val('0.00');
                    $('#bal_amt').html('Balance Amount ('+ data['curr'] +') : 0.00');
                    $('#count_i').val('0.00');
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
    
    $('#load_sup').click(function(e){
        $('#normalexamples').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            //"scrollX": true,
            "searching": true,
            "destroy": true,
            "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/purchase_table.htm?types=suppliertable&sqlitemid=ALL",
        });
    });
    function addgriddata(a) {
        getsuptrans(a)
        $('#supplier').val(a);
        if (a != '') {
            $.post('<?php echo $sitename; ?>pages/master/userajax.php', {getfulldetails: a}, function (data) {
                $('#suppanel').show();
                if (data['image'] === '') {
                    $('#supp_logeo').css('display', 'none');
                }
                $('#supp_logeo').attr('src', '<?php echo $fsitename; ?>images/supplier/' + data['image']);
                $('#supplier_view').val(data['companyname']);
                $('#compa_name').html(data['companyname']);
                $('#supp_code').html(data['name']);
                $('#supp_address').html(data['address']);
                $('#supp_state').html(data['state']);
                $('#supp_city').html(data['city']);
                $('#supp_county').html(data['country']);
                $('#supp_postcode').html(data['postcode']);
            }, 'json');
        }
    }
</script>