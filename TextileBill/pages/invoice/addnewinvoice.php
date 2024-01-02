<?php
if (isset($_REQUEST['id'])) {
    $thispageeditid = 20;
} else {
    $thispageaddid = 20;
}
$menu = "19,20,20";

// if(isset($_REQUEST['show'])) { phpinfo(); exit;    }
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
//print_r($_POST);
$ji_style = '';
$ji_required = 'required';
$get1 = $db->prepare("SELECT * FROM `jobinvoice` WHERE `id`=?");
$get1->execute(array($_REQUEST['id']));
$showrecordss = $get1->fetch(PDO::FETCH_ASSOC);
if($_POST['jobs_to_invoice_draft']!=''){
    $job_ids = explode(',',$_POST['jobs_to_invoice_draft']);
    $showrecords['customer'] = getjob('customer',$job_ids[0]);
    $ji_style = 'style="display:none;"';
    $ji_required = '';
}else if($showrecordss['invoice_from']=='job'){
    $ji_style = 'style="display:none;"';
    $ji_required = '';
}
   
$mangprofile = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
if (isset($_REQUEST['submit']) || isset($_REQUEST['submit_draft'])) {


    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $draft = '0';
    if(isset($_REQUEST['submit_draft'])){
        $draft = '1';
    }

//    $jid_t = implode(',',$jid_t);
    $task_description = implode('*&&*&*', $task_description);
    $task_qty = implode(',', $task_qty);
    $task_unitprice = implode(',', $task_amount);
    $task_totamount = implode(',', $task_totamount);

    $task_unitprice1 = implode(',', $task_passup1);

//    $jid_a = implode(',',$jid_a);
//    $additioncharg = implode(',', array_unique($additcharge));
    $additioncharg = implode(',', $additcharge);
    $additionchargprc = implode(',', $additional_charges);

    
//    $jid_w = implode(',',$jid_w);
    $task_employee2 = implode(',', $employees_grouppercent);
    $task_description2 = implode('*&&*&*', $empdesc);
    $task_qty2 = implode(',', $empqty);
    $task_extraamt = implode(',', $empextraamt);
    $task_empamt2 = implode(',', $empamt);
    $task_unitprice2 = implode(',', $empbasicpay);
    //exit;

    $passupvalue = implode(',', $task_passup);
    $task_passup12 = implode(',', $task_passup1);
    $passup_amount2 = implode(',', $passup_amount);
    
    $invoicefrom = "Invoice";   
    if($invoice_from!=''){
        $invoicefrom = $invoice_from;   
    }    
    $msg = addinvoice($status, $finalnettotal, $task_extraamt, $invoicefrom, $invoice_jobid, $additionchargprc, $task_empamt2, $task_tax, $amt, $passupvalue, $task_passup12, $passup_amount2, $task_totamount, $task_description, $task_qty, $task_unitprice, $task_unitprice1, $additioncharg, $pay_id,$task_employee2, $task_description2, $task_qty2, $task_unitprice2, $jobid, $customer, $price_category, $pickup_date, $pickup_time,$due_date, $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $subtotal, $nettotal, $tax, $additionalcharge, $empqty1, $Emptotal, $draft,$jid_t,$jid_a,$jid_w,$ip, $getid);
}

if(isset($_REQUEST['sendmails'])){
    InvoiceMail($_REQUEST['selected_contacts'],$_REQUEST['id']);    
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i> Successfully Sent</h4></div>';
    
}

if (isset($_REQUEST['id']) && ($_REQUEST['id'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `jobinvoice` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid']) && $_REQUEST['delid'] != '') {
    
    /*$deta = $db->prepare("SELECT a.*,b.jid FROM `jobinvoice` AS a,`job_newtask` AS b WHERE b.`id`='" . $_REQUEST['delid']. "' AND a.id=b.job_id");
    $deta->execute();
    $fdeta = $deta->fetch();
        
    $old_ids = explode(',',$fdeta['jobids']);
    if(!empty($old_ids) && $fdeta['jid']!='' && $fdeta['jid']!='0'){
        $old_ids = array_diff($old_ids, array($fdeta['jid']));
    }*/
    
    $up = $db->prepare("DELETE FROM `job_newtask` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid']));

    /*$up1 = $db->prepare("UPDATE `jobinvoice` SET `nettotal`=?,`jobids`=? WHERE `id`=?");
    $up1->execute(array($_REQUEST['tot'],implode(',',$old_ids), $_REQUEST['id']));*/
    
    $up1 = $db->prepare("UPDATE `jobinvoice` SET `nettotal`=? WHERE `id`=?");
    $up1->execute(array($_REQUEST['tot'], $_REQUEST['id']));
    echo '<script>window.location.href="' . $sitename . 'invoice/' . $showrecords['id'] . '/editnewinvoice.htm"</script>';
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `job_newinvoice` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));

    $up1 = $db->prepare("UPDATE `jobinvoice` SET `nettotal`=?,`emptotal`=? WHERE `id`=?");
        $up1->execute(array($_REQUEST['tot'],$_REQUEST['emptot'], $_REQUEST['id']));
    echo '<script>window.location.href="' . $sitename . 'invoice/' . $showrecords['id'] . '/editnewinvoice.htm"</script>';
}
?>
<style type="text/css">
    #task_table input[type=number]::-webkit-inner-spin-button, 
    #task_table input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0; 
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Invoice
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Invoice</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Invoice(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>invoice/invoice.htm"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Invoice</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['id'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Invoice</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>                    
                    <div class="row">
                        <div class="col-md-8">    
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Invoice ID</label>
                                    <?php $purid = get_bill_settings('prefix', '1') . str_pad(get_bill_settings('current_value', '1'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    if($_POST['jobs_to_invoice_draft']!=''){
                                    ?>
                                    <input type="hidden" name="invoice_from" class="form-control" value="job" />                                
                                    <?php } ?>                                    
                                    <input type="hidden" name="invoice_jobid" id="invoice_jobid" class="form-control" value="<?=$showrecords['jobids']?>" />                                
                                    <input type="text" readonly name="jobid" id="jobid" class="form-control" value="<?php echo ($showrecords['invoiceid'] != '') ? $showrecords['invoiceid'] : $purid; ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Customer</label>
                                    <div class="input-group">
                                        <input type="hidden" name="customer_group" id="customer_group">
                                        <input type="hidden" name="customer_grouppercent" id="customer_grouppercent">
                                        <input type="text" id="customer" class="form-control" readonly value="<?php echo getcustomer('companyname', $showrecords['customer']); ?>"/>
                                        <input type="hidden" name="customer" id="customer_id" class="form-control" readonly value="<?php echo getcustomer('cid', $showrecords['customer']); ?>" />
                                        <span class="input-group-addon" id="customer_grid_search" style="cursor: pointer;" data-toggle="modal" data-target="#customer_grid_modal"><i class="fa fa-search"></i></span>
                                    </div>
                                </div>                       
                            </div>
                            <br />
                            <div class="row" <?=$ji_style?>>
                                <div class="col-md-4">
                                    <label>Price Category<span style="color:#F00;">*</span></label>
                                    <input type="hidden" name="prcid" id="prcid" value="<?= ($showrecords['price_category']!='') ? $showrecords['price_category'] : 0; ?>">
                                    <select name="price_category" id="price_category" class="form-control" <?=$ji_required?> onchange="getprcid(this.value);">
                                        <option value="">Select</option>
                                        <?php
                                        $pricelist = pFETCH("SELECT * FROM `pricing` WHERE `status`=? AND `status`!=?", '1', '2');
                                        while ($pricefetch = $pricelist->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $pricefetch['id']; ?>" <?php
                                            if ($pricefetch['id'] == $showrecords['price_category']) {
                                                echo 'selected';
                                            }
                                            ?> data-type="<?php echo $pricefetch['id']; ?>"><?php echo $pricefetch['title']; ?></option>
                                                <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Pickup Date<span style="color:#F00;">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right usedatepicker" name="pickup_date" id="pickup_date" <?=$ji_required?> value="<?php
                                        if (isset($_REQUEST['id']) && (date('d-m-Y', strtotime($showrecords['pickup_date'])) != '01-01-1970')) {
                                            echo date('d-m-Y', strtotime($showrecords['pickup_date']));
                                        } else {
                                            // echo date('d-m-Y');
                                        }
                                        ?>" >
                                    </div>						
                                </div>
                                <div class="col-md-4">
                                    <label>Pickup Time<span style="color:#F00;">*</span></label>           
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <input type="text" name="pickup_time" id="pickup_time" class="form-control timepicker" <?=$ji_required?> value="<?php echo date("h:i A", strtotime($showrecords['pickup_time'])); ?>" />
                                        </div>
                                    </div>                            
                                </div>	
                                <?php /*<div class="col-md-4">
                                    <label>Choose Jobs</label>
                                    <button type="button" name="choose_job" id="choose_job_id" class="btn btn-info" style="display: block;">Choose</button>
                                </div>	*/ ?>							
                            </div>
                            <br>                                        
                            <div class="row" <?=$ji_style?>>                         
                                <div class="col-md-4">
                                    <label>Pickup location<span style="color:#F00;">*</span></label>                       
                                    <input type="text" class="form-control" name="pickup_location" id="pickup_from" placeholder="Pick location" <?=$ji_required?> value="<?php echo $showrecords['pickup_location']; ?>"/>
                                    <input type="hidden" name="pickup_lat" id="pickup_lat" value="<?php echo $showrecords['pickup_lat']; ?>" />
                                    <input type="hidden" name="pickup_lng" id="pickup_lng" value="<?php echo $showrecords['pickup_lng']; ?>" />         
                                </div>
                                <div class="col-md-4">
                                    <label>Drop location<span style="color:#F00;">*</span></label>
                                    <input type="text" class="form-control" name="drop_location" id="drop_to" placeholder="Drop location" <?=$ji_required?> value="<?php echo $showrecords['drop_location']; ?>" />
                                    <input type="hidden" name="drop_lat" id="drop_lat" value="<?php echo $showrecords['drop_lat']; ?>" />
                                    <input type="hidden" name="drop_lng" id="drop_lng" value="<?php echo $showrecords['drop_lng']; ?>" />
                                </div>   
                                <div class="col-md-4">
                                    <label>KM</label>
                                    <input type="text" readonly name="km" id="km" class="form-control" value="<?php echo $showrecords['km']; ?>" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Due Date</label>
                                    <input type="text" name="due_date" class="form-control usedatepicker" required value="<?php 
                                    if (isset($_REQUEST['id']) && (date('d-m-Y', strtotime($showrecords['due_date'])) != '01-01-1970')) {
                                            echo date('d-m-Y', strtotime($showrecords['due_date']));
                                        } else {
                                            // echo date('d-m-Y');
                                        }
                                    ?>" />
                                </div>
                            </div>
                            <br />
                        </div>
                        <div id="customer_detail" class="col-md-4"></div>    
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">Tasks</div>
                        <div class="panel-body">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table width="100%" class="table table-bordered" id="task_table" cellpadding="0"  cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width="5%">S.no</th>
                                                    <th width="25%">Description</th>
                                                    <th width="10%">Qty</th>
                                                    <th width="10%">Per Rate</th>
                                                    <th width="10%">Total Rate</th>

                                                    <td width="5%"></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $deta = $db->prepare("SELECT * FROM `job_newtask` WHERE `job_id`='" . $showrecords['id'] . "' ORDER BY `id` ASC");
                                                $deta->execute();
                                                $sno = 0;
                                                $tot_qty = 0;
                                                while ($fetc = $deta->fetch()) {
                                                    $sno++;
                                                    $tot = $fetc['per_rate'] * $fetc['qty'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $sno ?></td>
                                                        <td><input type="hidden" name="prcres[]" id="prcres[]"><textarea name="task_description[]" rows="3" class="form-control"><?php echo $fetc['description']; ?></textarea></td>
                                                        <td><input type="text" name="task_qty[]" min="1" class="form-control" onkeyup="calculate_price($(this));" value="<?php $tot_qty+=$fetc['qty']!='' ? $fetc['qty'] : 0 ; echo $fetc['qty']; ?>" /></td>
                                                        <td><input type="text" style="text-align: right;" name="task_amount[]" class="form-control" onkeyup="calculate_price($(this));" value="<?php echo $fetc['per_rate']; ?>" /></td>
                                                        <td><input type="text" style="text-align: right;" name="task_totamount[]" class="form-control" onkeyup="calculate_subprice($(this));" value="<?php echo $fetc['total_rate']; ?>"  /></td>

                                                        <td onclick="delrec($(this), '<?php echo $fetc['id']; ?>')"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr id="firsttasktr" style="display:none;">
                                                    <td>1</td>

                                                    <td>
                                                        <input type="hidden" name="prcres[]" id="prcres[]">
                                                        <textarea name="task_description[]" class="form-control" rows="3"><?php echo $fetc['description']; ?></textarea>
                                                    <td><input type="number" step="0.0001" name="task_qty[]" id="task_qty" class="form-control" onkeyup="calculate_price($(this));" /></td>

                                                    <td><input type="number" step="0.0001" style="text-align: right;" name="task_amount[]" class="form-control" onkeyup="calculate_price($(this));" /></td>
                                                    <td><input type="number" step="0.0001" style="text-align: right;" name="task_totamount[]" class="form-control" onkeyup="calculate_subprice($(this));" /></td>

                                                </tr>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="9" style="text-align: right;">
                                                        Task Charges&nbsp;:&nbsp; <input type="hidden" name="subtotal" value="<?php echo $showrecords['subtotal']; ?>" /><span class="subtotal"><?php echo "$" . $showrecords['subtotal']; ?></span>
                                                    </td>
                                                </tr>
                                                <tr><td colspan="9"></td></tr>
                                                <tr>
                                                    <td colspan="2" style="border:0;"><button type="button" class="btn btn-info" id="add_task">Add Task</button></td>
                                                    <td colspan="7" style="border:0;padding-top: 15px;"><strong>Total Qty : <span class="empqty1"><?php echo number_format($tot_qty,2); ?></span><br></strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>                                   
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel panel-info" id="additionchargemng">
                        <div class="panel-heading">Additional Charges Details</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table width="100%" class="table table-bordered" cellpadding="0"  cellspacing="0" id="additional_charges_display">
                                        <thead>
                                            <tr>
                                                <th style="width: 50%;"><strong>Name</strong></th>
                                                <th style="width: 45%;"><strong>Charge</strong></th>
                                                <th style="width: 5%;"></th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <?php
                                            $showrecords['additionalcharge'] = $showrecords['additionalcharge'] != '' ? $showrecords['additionalcharge'] : '0';
                                            $coun = $db->prepare("SELECT * FROM `additional_charges` WHERE `id` IN (" . $showrecords['additionalcharge'] . ")");
                                            $coun->execute();
                                            $addcharge = explode(",", $showrecords['additionalcharge']);
                                            $additionchargprc = explode(",", $showrecords['additionalchargerate']);

                                            $sel = '';
                                            $i = 0;
                                            while ($fcoun = $coun->fetch(PDO::FETCH_ASSOC)) {
                                                if (in_array($fcoun['id'], $addcharge)) {
                                                    $sel = 'checked="checked"';
                                                } else {
                                                    $sel = '';
                                                }
                                                ?>
                                                <tr>                                                
                                                    <td>
                                                        <input data-type="<?php echo $fcoun['charge']; ?>" type="hidden" name="additcharge[]" id="additcharge" value="<?php echo $fcoun['id']; ?>" />
                                                        <?php echo $fcoun['name']; ?>
                                                    </td>
                                                    <td>
                                                        <!--<input type="hidden" name="additcharge[]" id="additcharge" value="<?php echo $fcoun['id']; ?>" >-->
                                                        <input type="number" step="0.0001" name="additional_charges[]" id="additional_charges" value="<?php echo $additionchargprc[$i]; ?>" data-type="<?php echo $additionchargprc[$i]; ?>" onkeyup="additionalprice();"> </td>
                                                    <td><i onclick="del_addi($(this));" class="fa fa-trash fa-2x" style="cursor: pointer;color:#F00;"></i></td>
                                                </tr>                                            
                                                <?php $i++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>



                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" name="addcharges_btn" class="btn btn-info" id="addcharges_btn" data-toggle="modal" data-target="#additional_grid_modal">Add Additional Charges</button>
                                    <br>
                                    <table width="100%">
                                        <tr>
                                            <td colspan="3" style="text-align: right;">
                                                <input type="hidden" name="amt" id="amt" value="<?= $showrecords['additionalchargeprice'] ?>">
                                                Additional Charges : <input type="hidden" name="addcharge" value="<?php
                                                if ($showrecords['additionalchargeprice']) {
                                                    echo $showrecords['additionalchargeprice'];
                                                } else {
                                                    echo "0.0";
                                                }
                                                ?>"/><span class="addcharge"><?php echo "$" . number_format($showrecords['additionalchargeprice'],2); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align: right;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align: right;">
                                                Sub Total&nbsp;:&nbsp; <input type="hidden" name="nettotal" value="<?php
                                                if ($showrecords['nettotal']) {
                                                    echo $showrecords['nettotal'];
                                                } else {
                                                    echo "0.0";
                                                }
                                                ?>" /><span class="nettotal"><?php echo "$" . number_format($showrecords['nettotal'],2); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align: right;">&nbsp;</td>
                                        </tr>
                                        <tr>
<?php $taxdetails = FETCH_all("SELECT * FROM `tax` WHERE `id` = ?", '1'); ?>
                                            <td colspan="3" style="text-align: right;">
                                                GST&nbsp;:&nbsp; <input type="hidden" name="gstid" id="gstid">
                                                <input type="hidden" name="task_tax" id="task_tax" value="<?php echo $mangprofile['tax']; ?>" />

                                                <input type="hidden" name="tax" value="<?php
                                                if ($showrecords['tax']) {
                                                    echo $showrecords['tax'];
                                                } else {
                                                    echo "0.0";
                                                }
                                                ?>" /><span class="taxxamt"><?php echo "$" . number_format($showrecords['tax'],2); ?></span>
                                                <span id="taxamt"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align: right;">&nbsp;</td>
                                        </tr>	
                                        <tr>
                                            <td colspan="3" style="text-align: right;">
                                                Net Amount&nbsp;:&nbsp; <input type="hidden" name="finalnettotal" value="<?php
                                                if ($showrecords['finalnettotal']) {
                                                    echo $showrecords['finalnettotal'];
                                                } else {
                                                    echo "0.0";
                                                }
                                                ?>" /><span class="finalnettotal"><?php echo "$" . number_format($showrecords['finalnettotal'],2); ?></span>
                                            </td>
                                        </tr>												
                                    </table>	
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="panel panel-info">
                        <div class="panel-heading">Worker Details</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table width="100%" class="table table-bordered" cellpadding="0"  id="worker_table" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>S.no</th>
                                            <!--<td></td>-->
                                                <td><input type="hidden" name="empqty1" id="empqty1"><strong>Employee Name</strong></td>
                                                <td><strong>Description</strong></td>
                                                <td><strong>Basic Rate</strong></td>
                                                <td><strong>Qty</strong></td>
                                                <td><strong>Extra Charge</strong></td>
                                                <td><strong>Amount</strong></td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $deta = $db->prepare("SELECT * FROM `job_newinvoice` WHERE `subject`='Worker Charge' AND `job_id`='" . $showrecords['id'] . "'  ORDER BY `id` ASC ");
                                            $deta->execute();
                                            $sno = 0;
                                            while ($fetc = $deta->fetch()) {
                                                $sno++;
                                                $amt = $fetc['task_quty'] * $fetc['task_unit_price'];
                                                ?>
                                                <tr>
                                                    <td><?= $sno ?></td>
                                               <!-- <td>
                                                                                              <input type="hidden" name="emptotal" id="empqtotal"> </td>-->
                                                    <td>
                                                        <input type="hidden" name="pay_id[]" value="<?=$fetc['pay_id']?>" />
                                                        <input type="hidden" name="employees_grouppercent[]" value="<?php echo $fetc['employee']; ?>">
                                                        <input type="text" class="form-control employees_view" readonly value="<?php echo getdriver('firstname', $fetc['employee']); ?>" />
                                 <?php /*                       <span class="input-group-addon" id="employees_grid_search" style="cursor: pointer;width: 30%;float:left;height: 34px;" data-toggle="modal" data-target="#employee_grid_modal" onclick="setmodal_tr($(this).parent().parent())"><i class="fa fa-search"></i></span> */ ?>
                                                    </td>
                                                    <td id="desc"><input type="text" name="empdesc[]" id="empdesc[]" class="form-control" value="<?php echo $fetc['task_description']; ?>" /></td>
                                                    <td id="basicpay"><input type="number" step="0.001" name="empbasicpay[]" id="empbasicpay[]" class="form-control" onkeyup="calculate_workerprice($(this));" style="text-align: right;" value="<?php echo number_format($fetc['task_unit_price'],2,'.',''); ?>" /></td>                                                    
                                                    <td id="empqty"><input type="number" step="0.001" name="empqty[]" id="empqty[]" class="form-control" onkeyup="calculate_workerprice($(this));" value="<?php echo number_format($fetc['task_quty'],2,'.',''); ?>" /></td>
                                                    <td><input type="number" step="0.001" name="empextraamt[]" id="empextraamt[]" class="form-control" onkeyup="calculate_workerprice($(this));" style="text-align: right;" value="<?php echo number_format($fetc['task_extra_amt'],2,'.',''); ?>" /></td>
                                                    <td><input type="number" step="0.001" name="empamt[]" id="empamt[]" class="form-control" onkeyup="calcuempamt();" style="text-align: right;" value="<?php echo number_format($fetc['task_amount_aud'],2,'.',''); ?>" /></td>
                                                    <td onclick="delrec_wor($(this), '<?php echo $fetc['id']; ?>')"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                </tr>
<?php } ?>

                                            <tr style="display:none;" id="firstworkertr">
                                                <td>1</td>

                                                <td>
                                                    <input type="hidden" name="emptotal" id="empqtotal">
                                                    <input type="hidden" name="employees_grouppercent[]">
                                                    <input type="text" class="form-control employees_view" readonly value="<?php echo getcustomer('firstname', $showrecords['customer']); ?>" />
                                      <?php /*              <span class="input-group-addon" id="employees_grid_search" style="cursor: pointer;width: 30%;float:left;height: 34px;" data-toggle="modal" data-target="#employee_grid_modal" onclick="setmodal_tr($(this).parent().parent())"><i class="fa fa-search"></i></span> */ ?>

                                                </td>
                                                <td id="desc"><input type="text" name="empdesc[]" id="empdesc[]" class="form-control"></td>
                                                <td id="basicpay"><input type="number" step="0.001" name="empbasicpay[]" id="empbasicpay[]" onkeyup="calculate_workerprice($(this));" class="form-control" style="text-align: right;"></td>                                                    
                                                <td id="empqty"><input type="number" step="0.001" name="empqty[]" id="empqty[]" class="form-control" onkeyup="calculate_workerprice($(this));"></td>
                                                <td><input type="number" step="0.001" name="empextraamt[]" id="empextraamt[]" class="form-control" onkeyup="calculate_workerprice($(this));" value="<?php echo $fetc['task_extra_amount']; ?>" style="text-align: right;" /></td>
                                                <td><input type="number" step="0.001" name="empamt[]" id="empamt[]" class="form-control" onkeyup="calcuempamt();" style="text-align: right;"></td>
                                            </tr> 
                                        </tbody>

                                    </table>

                                    <br />
                                    <button type="button" class="btn btn-info" id="add_worker" style="padding-left:20px;">Add Worker</button></div>

                            </div>

                            <div class="col-12" align="right">
                                <table width="100%" cellpadding="10" cellspacing="10">

                                    <tr>
                                        <td colspan="3" style="text-align: right;">
                                            Worker Charges&nbsp;:&nbsp; <input type="hidden" name="Emptotal" id="Emptotal" value="<?php echo $showrecords['emptotal']; ?>">
                                            <span class="Emptotal"><?php echo "$" . number_format($showrecords['emptotal'],3); ?></span> </td>
                                    </tr>
                                </table>				


                            </div>
                        </div>

                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Customer Reference<span style="color:#F00;">*</span></label>
                            <textarea name="description" class="form-control" id="description" required="required"><?php 
                            if($showrecords['description']!=''){
                               echo $showrecords['description'];
                            }else if($job_ids!=''){
                                $shoids = [];
                                foreach($job_ids as $ind_job_ids){
                                    $shoids[] = getjob('jobid',$ind_job_ids);
                                }
                                echo implode(',', $shoids);
                            }
                            ?></textarea>

                        </div>
                        <div class="col-md-6">

                            <label>Status  <span style="color:#FF0000;">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php echo(isset($_REQUEST['id'])) ? ($showrecords['status'] == '1') ? 'selected' : '' : 'selected'; ?>>Not Paid</option>
                                <option value="2" <?php echo(isset($_REQUEST['id'])) ? ($showrecords['status'] == '2') ? 'selected' : '' : ''; ?>>Paid</option>
                            </select>
                        </div>


                    </div>                    

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo $sitename; ?>invoice/invoice.htm">Back to Listings page</a>
                        </div>
                        <!-- <div class="col-md-4">
                        <?php //if ($showrecords['id'] != '') {   ?>
                                 <a href="<?php //echo $sitename;  ?>MPDF/invoice/invoice.php?id=<?php //echo $showrecords['id'];  ?>" target="_blank" class="btn btn-info">Generate Invoice</a>
<?php //}  ?>
                         </div>-->
                        <div class="col-md-4">
                            <?php
                            if ($_REQUEST['id'] != '') {
                                ?>
                                <a target="_blank" href="<?php echo $fsitename; ?>MPDF/invoice/invoice.php?id=<?php echo $_REQUEST['id']; ?>" class="btn btn-info"><i class="fa fa-print"></i>&nbsp;&nbsp;View Invoice</a>
                        <?php } ?>
                            <?php
                            if ($_REQUEST['id'] != '') {
                                ?>
                                <button type="button" data-toggle="modal" data-target="#Conatct_Persons_Modal" class="btn btn-info"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Send Mail</button>
                        <?php } ?>
                        </div>
                        <div class="col-md-4">                
                            <?php 
                            if($_POST['jobs_to_invoice_draft']==''){
                            ?>
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;margin-right: 5px;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?> AS INVOICE</button>
                            <?php }
                            if($showrecords['id']!=''){
                                if($showrecords['draft']=='1'){ ?>
                                    <button type="submit" name="submit_draft" id="submit_draft" class="btn btn-warning" style="float:right;margin-right:5px;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SAVE';
                                }
                                ?> AS DRAFT</button>
                                <?php }
                            }else{ ?>
                                <button type="submit" name="submit_draft" id="submit_draft" class="btn btn-warning" style="float:right;margin-right:5px;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SAVE';
                                }
                                ?> AS DRAFT</button>
                            <?php }
                            ?>
                        </div>


                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<div id="employee_grid_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Worker</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="worker_grid_table" width="100%" class="table table-bordered table-striped">
                        <thead>
                            <tr><input type="hidden" name="employee" id="employee"><input type="hidden" name="employee_id" id="employee_id">
                        <th width="5%">S.no</th>
                        <th width="35%">Worker ID</th>
                        <th width="35%">Worker Name</th>
                        <th width="25%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $cust_query = $db->prepare("SELECT * FROM `driver` WHERE `status`='1'");
                            $cust_query->execute();
                            while ($fetched = $cust_query->fetch()) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $fetched['driverid'] ?></td>
                                    <td><?= $fetched['firstname'] ?></td>
                                    <td>
                                        <input type="checkbox" name="wrkr_chk[]" data-name="<?=$fetched['firstname']?>" value="<?=$fetched['did']?>" />
                                        <!--<button type="button" class="btn btn-success" onclick="select_worker('<?php // echo $fetched['did']; ?>', '<?php // echo $fetched['firstname']; ?>')">Select</button>-->
                                    </td>
                                </tr>
    <?php
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="select_worker();">Select</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="customer_grid_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Customer</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="customer_grid_table" width="100%" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">S.no</th>
                                <th width="35%">Customer ID</th>
                                <th width="35%">Company Name</th>
                                <th width="35%">Contact Person</th>
                                <th width="25%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $cust_query = $db->prepare("SELECT * FROM `customer` WHERE `status`='1'");
                            $cust_query->execute();
                            while ($fetched = $cust_query->fetch()) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getcustomer('customerid', $fetched['cid']) ?></td>
                                    <td><?= getcustomer('companyname', $fetched['cid']) ?></td>
                                    <td><?= getcustomer('firstname', $fetched['cid']) ?></td>
                                    <td><button type="button" class="btn btn-success" onclick="select_customer('<?php echo $fetched['cid']; ?>', '<?php echo getcustomer('firstname', $fetched['cid']); ?>', '<?php echo getcustomer('cus_group', $fetched['cid']); ?>', '<?php echo getcustomer('companyname', $fetched['cid']); ?>')">Select</button></td>
                                </tr>
                                <?php
                            }
                            ?>
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

<div id="additional_grid_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Additional Charges</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="additional_grid_table" width="100%" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">S.no</th>
                                <th width="35%">Name</th>
                                <th width="35%">Charges</th>
                                <th width="25%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $coun = pFETCH("SELECT * FROM `additional_charges` WHERE `id`!=?", '');
                            $addcharge = explode(",", $showrecords['additionalcharge']);
                            $sel = '';
                            while ($fcoun = $coun->fetch(PDO::FETCH_ASSOC)) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $fcoun['name']; ?></td>
                                    <td><?php echo $fcoun['charge']; ?></td>
                                    <td>
                                        <input data-name="<?php echo $fcoun['name']; ?>" data-value="<?php echo $fcoun['charge']; ?>"  <?php echo $sel; ?> type="checkbox" name="additional_charges_check[]" value="<?php echo $fcoun['id']; ?>" /></td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_additional_charges_button">Add</button> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="choose_jobs_grid_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Jobs</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="choose_jobs_grid_table" width="100%" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">S.no</th>
                                <th width="10%">Date</th>
                                <th width="35%">Job ID</th>                                
                                <th width="25%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_jobs_c_button">Add</button> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="Conatct_Persons_Modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Contact to Send Mail</h4>
            </div>
            <form name="contacts_form" method="post" onsubmit="return check_Cont();">
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="choose_contacts_grid_table" width="100%" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">S.no</th>
                                <th width="10%">Contact Person</th>
                                <th width="35%">Email Address</th>                                
                                <th width="25%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $cont = $db->prepare("SELECT * FROM `contact_informations` WHERE `customer_id`=?");
                                $cont->execute(array($showrecords['customer']));
                                $sno = 0;
                                while($fcont = $cont->fetch()){
                                     $sno++;
                                    ?>
                            <tr>
                                <td style="text-align:center;"><?=$sno?></td>
                                <td><?=$fcont['contact_name']?></td>
                                <td><?=$fcont['contact_email']?></td>
                                <td style="text-align:center;"><input type="checkbox" name="selected_contacts[]" value="<?php echo $fcont['id']; ?>" /></td>
                            </tr>
                                <?php 
                                
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"  name="sendmails" id="add_contacts_c_button">Send</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJDyvS5KNpnvnegYaDI63SpMlSezrM9iE&libraries=places"></script>
<script type="text/javascript">
                                        function findKM() {
                                            var pickup = $('#pickup_from').val();
                                            var pickup_lat = $('#pickup_lat').val();
                                            var pickup_lng = $('#pickup_lng').val();
                                            var drop = $('#drop_to').val();
                                            var drop_lat = $('#drop_lat').val();
                                            var drop_lng = $('#drop_lng').val();
                                            if (pickup_lat != '' && pickup_lng != '' && drop_lat != '' && drop_lng != '') {
                                                $.ajax({
                                                    url: "<?php echo $sitename; ?>getlocation.php",
                                                    dataType: 'JSON',
                                                    data: {pickup: pickup, pickup_lat: pickup_lat, pickup_lng: pickup_lng, drop: drop, drop_lat: drop_lat, drop_lng: drop_lng}
                                                }).done(function (data) {
                                                    $('#kilometer').val(data[0]);
                                                    $('#km').val(data[0]);
                                                    $('#kilometerorg').val(data[0]);
                                                    $('#viewmap').html(data[1]);
                                                    if ($('#prcid').val() == '2')
                                                    {
                                                        $('input[name="task_qty[]"]').each(function (e) {
                                                            if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                                                                $(this).val(data[0]);
                                                                calculate_price($(this));
                                                            }
                                                        });

                                                    }
                                                });
                                            }
                                        }
                                        function initMap() {

                                            var options = {
                                                componentRestrictions: {country: ["my", "sg", "in", "au"]}
                                            };

                                       /*     var input = document.getElementById('google_autofile_text');
                                            var autocomplete = new google.maps.places.Autocomplete(input, options);

                                            autocomplete.addListener('place_changed', function () {
                                                var place = autocomplete.getPlace();
                                                document.getElementById("from_lat").value = place.geometry.location.lat();
                                                document.getElementById("from_lng").value = place.geometry.location.lng();
                                                var comp = place.address_components;
                                                $.each(comp, function (i, val) {
                                                    if (val.types[0] == 'administrative_area_level_2') {
                                                        document.getElementById("from_city").value = val.long_name;
                                                    }
                                                    if (val.types[0] == 'administrative_area_level_1') {
                                                        document.getElementById("from_state").value = val.long_name;
                                                    }
                                                    if (val.types[0] == 'country') {
                                                        document.getElementById("from_country").value = val.long_name;
                                                    }
                                                });
                                            });*/



                                            var input1 = document.getElementById('pickup_from');
                                            var autocomplete1 = new google.maps.places.Autocomplete(input1, options);

                                            autocomplete1.addListener('place_changed', function () {
                                                var place = autocomplete1.getPlace();
                                                document.getElementById("pickup_lat").value = place.geometry.location.lat();
                                                document.getElementById("pickup_lng").value = place.geometry.location.lng();
                                                findKM();
                                            });

                                            var input2 = document.getElementById('drop_to');
                                            var autocomplete2 = new google.maps.places.Autocomplete(input2, options);
                                            autocomplete2.addListener('place_changed', function () {
                                                var place = autocomplete2.getPlace();
                                                document.getElementById("drop_lat").value = place.geometry.location.lat();
                                                document.getElementById("drop_lng").value = place.geometry.location.lng();
                                                findKM();
                                            });
                                        }
</script>
<script>
    function check_Cont(){
        var $len = $('input[name="selected_contacts[]"]:checked').length;
        if($len > 0){
            return true;
        }else{
            alert("Please select atleast one contact..");
            return false;
        }
    }
    function showpassword()
    {
        var change = $("#change").val();
        if (change == '1')
        {
            $("#password").prop("type", "password");
            $("#change").val('0');
        } else {
            $("#password").prop("type", "text");
            $("#change").val('1');
        }
    }

    $(document).ready(function (e) {
        $('.timepicker').timepicker();
        $('#customer_grid_search').click(function (e) {
            $('#customer_grid_table').dataTable();
        });

        $('#add_worker').click(function () {
            $('#employee_grid_modal').modal('show');
            $('#worker_grid_table').dataTable();
            return '';
            var data = $('#firstworkertr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Are you sure want to delete Worker?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                    calculate_total($('input[name="task_tax"]').val());
                }
            });
            $(data).attr('id', '').show().append(rem_td);
            $(data).find('td').each(function (e) {
                $(this).find('input,select').val('').attr('required', 'required');
                $(this).find('input[name="empdesc[]"]').prop('required',false);
            });

            data = $(data);
            $('#worker_table tbody').append(data);
            re_assing_serial();
        });


        $('#add_task').click(function () {
               var pricevalid = $('#price_category').find(':selected').val();
               <?php 
               if($ji_required!=''){ ?>
            if(pricevalid==''){ alert("Please select price category.."); return ''; }
               <?php } ?>
            var data = $('#firsttasktr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Are you sure want to delete task?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                    calculate_total($('input[name="task_tax"]').val());
                }
            });
            $(data).attr('id', '').show().append(rem_td);
            $(data).find('td').each(function (e) {
                $(this).find('input,select').val('').attr('required', 'required');
            });

            data = $(data);
            $('#task_table tbody').append(data);
            
            var priceval = $('#price_category').find(':selected').data('type');
            if (pricevalid == '2')
            {
                km = $('input[name="km"]').val();
                $('#task_table tbody tr:last td input[name="task_qty[]"]').each(function (e) {
                    $(this).val(km);
                });
            } else {
                $('#task_table tbody tr:last td input[name="task_amount[]"]').each(function (e) {
                    $(this).val(priceval);
                });
            }
            re_assing_serial();

        });

        $('#addcharges_btn').click(function (e) {
            $('#additional_grid_table').dataTable({
                paging: false, destroy: true
            });
            $('input[name="additional_charges_check[]"]').prop('checked', false);
            $('input[name="additcharge[]"]').each(function () {
                $('input[name="additional_charges_check[]"][value="' + $(this).val() + '"]').prop('checked', true);
            });
        });
        $('#choose_job_id').click(function () {
            if ($('#customer_id').val() != '') {
                $('#choose_jobs_grid_modal').modal('show');
                $.ajax({
                    url: "<?php echo $sitename; ?>getpassup.php",
                    data: {get_jobs: $('#customer_id').val()}
                }).done(function (data) {
                    $('#choose_jobs_grid_table tbody').html(data);

                });
            } else {
                alert("Please choose customer.");
            }
        });

        $('#add_jobs_c_button').click(function () {
            var len = $('input[name="jobs_checkboxs[]"]:checked');
            if (len.length > 0) {
                var elems = [];
                len.each(function () {
                    elems.push($(this).val());
                });
                $('#invoice_jobid').val(elems);
                $.ajax({
                    url: "<?php echo $sitename; ?>getpassup.php",
                    data: {jobs_id: elems},
                    dataType: 'JSON',
                }).done(function (data) {
                    $('#task_table tbody').append(data['0']);
                    $('#additional_charges_display tbody').append(data['1']);
                    $('#worker_table tbody').append(data['2']);
                    $('.empqty1').html(parseFloat(data['3']).toFixed(2));

//additionalprice();
                    calculate_subprice();
                    var total = parseFloat(0);
                    var subtotal = parseFloat(0);
                    var nettotal = parseFloat(0);
                    var n = parseFloat(0);
                    var emptot = parseFloat(0);
                    subtotal = $('input[name="subtotal"]').val();

                    for (var i = 0; i < $('input[name="additional_charges[]"]').length; i++) {

                        //          if (document.department.additcharge[i].checked == true)
//            {
                        //var gval = document.department.additional_charges[i].value;
                        var gval = $('input[name="additional_charges[]"]').eq(i).val();
                        //alert(gval);
                        total = parseFloat(total) + parseFloat(gval);
                        //          }


                    }
                    $('.addcharge').html('$' + total.toFixed(2));
                    $('input[name="addcharge"]').val(total.toFixed(2));
                    $('input[name="amt"]').val(total.toFixed(2));
                    $('input[name="empamt[]"]').each(function (e) {
                        if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                            emptot = parseFloat(emptot) + (parseFloat($(this).val()) || parseFloat(0));
                        }
                    });

                    $('.Emptotal').html('$' + emptot.toFixed(2));
                    $('input[name="Emptotal"]').val(emptot.toFixed(2));
                    calcuempamt();
                });
                $('#choose_jobs_grid_modal').modal('hide');
            } else {
                alert("Please select atleast one job..");
            }
        });
        <?php
        if($_POST['jobs_to_invoice_draft']!=''){
        ?>
                function getJobsDraft(){
                var elems = JSON.parse("[<?php echo $_POST['jobs_to_invoice_draft']; ?>]");
                $('#invoice_jobid').val(elems);
                $.ajax({
                    url: "<?php echo $sitename; ?>getpassup.php",
                    data: {jobs_id: elems},
                    dataType: 'JSON',
                }).done(function (data) {
                    $('#task_table tbody').append(data['0']);
                    $('#additional_charges_display tbody').append(data['1']);
                    $('#worker_table tbody').append(data['2']);
                    $('.empqty1').html(parseFloat(data['3']).toFixed(2));

//additionalprice();
                    calculate_subprice();
                    var total = parseFloat(0);
                    var subtotal = parseFloat(0);
                    var nettotal = parseFloat(0);
                    var n = parseFloat(0);
                    var emptot = parseFloat(0);
                    subtotal = $('input[name="subtotal"]').val();

                    for (var i = 0; i < $('input[name="additional_charges[]"]').length; i++) {

                        //          if (document.department.additcharge[i].checked == true)
//            {
                        //var gval = document.department.additional_charges[i].value;
                        var gval = $('input[name="additional_charges[]"]').eq(i).val();
                        //alert(gval);
                        total = parseFloat(total) + parseFloat(gval);
                        //          }


                    }
                    $('.addcharge').html('$' + total.toFixed(2));
                    $('input[name="addcharge"]').val(total.toFixed(2));
                    $('input[name="amt"]').val(total.toFixed(2));
                    $('input[name="empamt[]"]').each(function (e) {
                        if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                            emptot = parseFloat(emptot) + (parseFloat($(this).val()) || parseFloat(0));
                        }
                    });

                    $('.Emptotal').html('$' + emptot.toFixed(2));
                    $('input[name="Emptotal"]').val(emptot.toFixed(2));
                    calcuempamt();
                });
                $('#choose_jobs_grid_modal').modal('hide');
                }
                getJobsDraft();
        <?php } ?>
        $('#add_additional_charges_button').click(function () {
            var len = $('input[name="additional_charges_check[]"]:checked');
            if (len.length > 0) {
                var elems = '';
                len.each(function () {
                    var new_elem = '<tr><td><input data-type="' + $(this).data('value') + '" type="hidden" name="additcharge[]" id="additcharge" value="' + $(this).val() + '" />' + $(this).data('name') + '</td><td>' + '<input onkeyup="additionalprice();" data-type="' + $(this).data('value') + '" type="text" name="additional_charges[]" id="additional_charges" value="' + $(this).data('value') + '" />' + '</td><td><i onclick="del_addi($(this));" class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td></tr>';
                    elems += new_elem;
                });
                $('#additional_charges_display tbody').html(elems);
                additionalprice();
                $('#additional_grid_modal').modal('hide');
            } else {
                alert("Please select atleast one additional charges..");
            }
        });


    });

    function del_addi(elem) {
        if (confirm("Are you sure want to remove this?")) {
            elem.parent().parent().remove();
            additionalprice();
        }
    }

    function setmodal_tr(elem) {
        $('#employee_grid_modal').data('elem', elem);
    }

    function select_worker(id, name) {
        var chked = $('input[name="wrkr_chk[]"]:checked');
        if(chked.length == '0'){
            alert("Please select atleast one worker.");
            return '';
        }
        $('#employee_grid_modal').modal('hide');
        var empqty1 = parseFloat(0);
        $('input[name="task_qty[]"]').each(function (e) {
            if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                empqty1 = parseFloat(empqty1) + (parseFloat($(this).val()) || parseFloat(0));
            }
        });
        chked.each(function(){
            var data = $('#firstworkertr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Are you sure want to delete Worker?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                    calculate_total($('select[name="task_tax"]').val());
                }
            });
            $(data).attr('id', '').show().append(rem_td);
            $(data).find('td').each(function (e) {
                $(this).find('input,select').val('').attr('required', 'required');
                $(this).find('input[name="empdesc[]"]').prop('required', false);
            });

            data = $(data);
            $('#worker_table tbody').append(data);
            re_assing_serial();
            
            $(data).find('td input[name="employees_grouppercent[]"]').val($(this).val());
            $(data).find('td input[name="empqty[]"]').val(empqty1.toFixed(2));
            $(data).find('td input[name="empextraamt[]"]').val('0');
            var qty = $(data).find('td input[name="empqty[]"]').val();
            $(data).find('td .employees_view').val($(this).data('name'));
            $.ajax({
                url: "<?php echo $sitename; ?>getslot.php",
                dataType: 'JSON',
                async: false,
                data: { getBasic: $(this).val(), pric_cate: $('#prcid').val() }
            }).done(function (data1) {
                $(data).find('td input[name="empbasicpay[]"]').val(parseFloat(data1[0]).toFixed(2));
                var total = qty * data1[0];
                $(data).find('td input[name="empamt[]"]').val(parseFloat(total).toFixed(2));
                calcuempamt();
            });
        });        

    }

    function calcuempamt()
    {
        var empamt = parseFloat(0);
        $('input[name="empamt[]"]').each(function (e) {
            if ($(this).parent().parent().attr('id') != 'firstworkertr') {
                empamt = parseFloat(empamt) + (parseFloat($(this).val()) || parseFloat(0));
            }

        });
//alert(empamt);

        $('#Emptotal').val(empamt.toFixed(3));
        $('.Emptotal').html('$' + empamt.toFixed(3));

        var additionalcharge = $('input[name="addcharge"]').val();

        var subtotal = $('input[name="subtotal"]').val();
        nettotal = parseFloat(subtotal) + parseFloat(additionalcharge);

        var taxvalue = $('input[name="task_tax"]').val();

        tax_amt = parseFloat(nettotal) * (parseFloat(taxvalue) / 100);

        $('.taxxamt').html('$' + tax_amt.toFixed(2));
        $('input[name="tax"]').val(tax_amt.toFixed(2));

        taxamt = $('input[name="tax"]').val();

        finalnettotal = parseFloat(subtotal) + parseFloat(additionalcharge) + parseFloat(taxamt);

//$('.subtotal').html(subtotal.toFixed(2));
// $('input[name="subtotal"]').val(subtotal.toFixed(2));

        $('.finalnettotal').html('$' + finalnettotal.toFixed(2));
        $('input[name="finalnettotal"]').val(finalnettotal.toFixed(2));

        $('.nettotal').html('$' + nettotal.toFixed(2));
        $('input[name="nettotal"]').val(nettotal.toFixed(2));

    }
    function select_customer(id, name, cusgroup, companyname) {

        $('#customer_grid_modal').modal('hide');
//$('#customer').val(name);
        $('#customer').val(companyname);
        $('#customer_id').val(id);
        $('#customer_group').val(cusgroup);
        $('#customer_detail').html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            dataType: 'JSON',
            async: false,
            data: {cusgroup: cusgroup, cusid: id}
        })
                .done(function (data) {
                    $('#customer_grouppercent').val(data['0']);
                    $('#customer_detail').html(data['1']);
                });
    }


    function calculate_subprice(elem) {
        var new_elem = $(elem).parents('tr').find('td');
        var total = parseFloat(0);
        var subtotal = parseFloat(0);
        var nettotal = parseFloat(0);


        $('input[name="task_totamount[]"]').each(function (e) {
            if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                subtotal = parseFloat(subtotal) + (parseFloat($(this).val()) || parseFloat(0));
            }
        });
        var additionalcharge = $('input[name="addcharge"]').val();
        var gstid = $('input[name="gstid"]').val();

        $('.subtotal').html('$' + subtotal.toFixed(2));
        $('input[name="subtotal"]').val(subtotal.toFixed(2));
        emptotal = $('input[name="Emptotal"]').val();
        //nettotal = parseFloat(subtotal) + parseFloat(additionalcharge) + parseFloat(emptotal);
        nettotal = parseFloat(subtotal) + parseFloat(additionalcharge);


        var taxvalue = $('input[name="task_tax"]').val();
        tax_amt = parseFloat(nettotal) * (parseFloat(taxvalue) / 100);

        $('.taxxamt').html('$' + tax_amt.toFixed(2));
        $('input[name="tax"]').val(tax_amt.toFixed(2));

        taxamt = $('input[name="tax"]').val();

        finalnettotal = parseFloat(subtotal) + parseFloat(additionalcharge) + parseFloat(taxamt);

//$('.subtotal').html(subtotal.toFixed(2));
// $('input[name="subtotal"]').val(subtotal.toFixed(2));

        $('.finalnettotal').html('$' + finalnettotal.toFixed(2));
        $('input[name="finalnettotal"]').val(finalnettotal.toFixed(2));

        $('.nettotal').html('$' + nettotal.toFixed(2));
        $('input[name="nettotal"]').val(nettotal.toFixed(2));

    }
    function calculate_workerprice(elem) {
        var new_elem = $(elem).parents('tr').find('td');

        var empbasicpay = new_elem.find('input[name="empbasicpay[]"]').val();
        var empqty = new_elem.find('input[name="empqty[]"]').val();
        var extraempamt = new_elem.find('input[name="empextraamt[]"]').val();
        if (extraempamt != '')
        {
            var emptot = parseFloat(empbasicpay) * parseFloat(empqty) + parseFloat(extraempamt);
        } else
        {
            var emptot = parseFloat(empbasicpay) * parseFloat(empqty);
        }
        new_elem.find('input[name="empamt[]"]').val(parseFloat(emptot).toFixed(3));
        $('input[name="empamt[]"]').each(function (e) {
            if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                emptot = parseFloat(emptot) + (parseFloat($(this).val()) || parseFloat(0));
            }
        });

        $('.Emptotal').html('$' + emptot.toFixed(3));
        $('input[name="Emptotal"]').val(emptot.toFixed(3));
        calcuempamt();
    }
    function calculate_price(elem) {
        var new_elem = $(elem).parents('tr').find('td');

        var task_amount = new_elem.find('input[name="task_amount[]"]').val();

        var qty = new_elem.find('input[name="task_qty[]"]').val();

        if (task_amount != '' && qty != '')
        {
            var total_rate = parseFloat(task_amount) * parseFloat(qty);
        } else if (task_amount != '' && qty == '')
        {
            var total_rate = parseFloat(task_amount);
        } else if (qty != '' && task_amount == '')
        {
            var total_rate = parseFloat(qty);
        } else
        {
            var total_rate = '';
        }
        new_elem.find('input[name="task_totamount[]"]').val(parseFloat(total_rate).toFixed(2));

        calculate_total($('input[name="task_tax"]').val());
    }
    function getprcid(a)
    {
        document.getElementById("prcid").value = a;
        var pricevalid = $('#price_category').find(':selected').val();
        var priceval = $('#price_category').find(':selected').data('type');
        if (pricevalid == '2')
        {
            km = $('input[name="km"]').val();
            $('input[name="task_qty[]"]').each(function (e) {
                $(this).val(km);
            });
        } else {
            $('input[name="task_amount[]"]').each(function (e) {
                $(this).val(priceval);
            });
        }

    }

    function additionalprice(a) {
        var total = parseFloat(0);
        var subtotal = parseFloat(0);
        var nettotal = parseFloat(0);
        var n = parseFloat(0);
        subtotal = $('input[name="subtotal"]').val();
        for (var i = 0; i < $('input[name="additional_charges[]"]').length; i++) {

            //          if (document.department.additcharge[i].checked == true)
//            {
            //var gval = document.department.additional_charges[i].value;
            var gval = $('input[name="additional_charges[]"]').eq(i).val();
            //alert(gval);
            total = parseFloat(total) + parseFloat(gval);
            //          }


        }
        $('.addcharge').html('$' + total.toFixed(2));
        $('input[name="addcharge"]').val(total.toFixed(2));
        $('input[name="amt"]').val(total.toFixed(2));
        emptotal = $('input[name="Emptotal"]').val();

        //nettotal = parseFloat(subtotal) + parseFloat(total) + parseFloat(emptotal);

        nettotal = parseFloat(subtotal) + parseFloat(total);
        var taxvalue = $('input[name="task_tax"]').val();
        tax_amt = parseFloat(nettotal) * (parseFloat(taxvalue) / 100);

        $('.taxxamt').html('$' + tax_amt.toFixed(2));
        $('input[name="tax"]').val(tax_amt.toFixed(2));

        taxamt = $('input[name="tax"]').val();

        finalnettotal = parseFloat(nettotal) + parseFloat(taxamt);

//$('.subtotal').html(subtotal.toFixed(2));
// $('input[name="subtotal"]').val(subtotal.toFixed(2));

        $('.finalnettotal').html('$' + finalnettotal.toFixed(2));
        $('input[name="finalnettotal"]').val(finalnettotal.toFixed(2));

        $('.nettotal').html('$' + nettotal.toFixed(2));
        $('input[name="nettotal"]').val(nettotal.toFixed(2));

    }




    function calculate_total(a) {

        var additionalcharge = $('input[name="addcharge"]').val();
        var subtotal = parseFloat(0);
        var nettotal = parseFloat(0);
        var taxamt = parseFloat(0);
        var subtotal1 = $('input[name="subtotal"]').val();
        var nettotal = $('input[name="nettotal"]').val();
        var empqty1 = 0;



        $('input[name="task_totamount[]"]').each(function (e) {
            if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                subtotal = parseFloat(subtotal) + (parseFloat($(this).val()) || parseFloat(0));
            }
        });


        $('.nettotal').html(subtotal);
        $('input[name="nettotal"]').val(subtotal);

        $('input[name="task_qty[]"]').each(function (e) {
            if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                empqty1 = parseFloat(empqty1) + (parseFloat($(this).val()) || parseFloat(0));
            }
        });

        $('input[name="empqty1"]').val(empqty1.toFixed(2));

        //$('input[name="empqty[]"]').val(empqty1.toFixed(2));

        var es = 0;
        $('input[name="empamt[]"]').each(function (e) {
            if ($(this).parent().parent().attr('id') != 'firstworkertr') {
                 var br = parseFloat($('input[name="empbasicpay[]"]').eq(es).val());
                   var qy = parseFloat($('input[name="empqty[]"]').eq(es).val());
                   var ex = parseFloat($('input[name="empextraamt[]"]').eq(es).val());
                   $(this).val(parseFloat((br * qy) + ex).toFixed(3));
              //  $(this).val(parseFloat(parseFloat($('input[name="empbasicpay[]"]').eq(es).val()) * parseFloat($('input[name="empqty[]"]').eq(es).val())).toFixed(3));
            }
            es++;
        });
        calcuempamt();

        $('.empqty1').html(empqty1.toFixed(2));

        var gstid = $('input[name="gstid"]').val();
//alert(gstid);

        $('.subtotal').html('$' + subtotal.toFixed(2));
        $('input[name="subtotal"]').val(subtotal.toFixed(2));
        emptotal = $('input[name="Emptotal"]').val();



        //nettotal = parseFloat(subtotal) + parseFloat(additionalcharge) + parseFloat(emptotal);
        nettotal = parseFloat(subtotal) + parseFloat(additionalcharge);

        var taxvalue = $('input[name="task_tax"]').val();
        tax_amt = parseFloat(nettotal) * (parseFloat(taxvalue) / 100);

        $('.taxxamt').html(tax_amt.toFixed(2));
        $('input[name="tax"]').val(tax_amt.toFixed(2));

        taxamt = $('input[name="tax"]').val();

        finalnettotal = parseFloat(nettotal) + parseFloat(taxamt);

//$('.subtotal').html(subtotal.toFixed(2));
// $('input[name="subtotal"]').val(subtotal.toFixed(2));

        $('.finalnettotal').html('$' + finalnettotal.toFixed(2));
        $('input[name="finalnettotal"]').val(finalnettotal.toFixed(2));

        $('.nettotal').html('$' + nettotal.toFixed(2));
        $('input[name="nettotal"]').val(nettotal.toFixed(2));

    }



    function re_assing_serial() {
        $("#task_table tbody tr").not('#firsttasktr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
        $("#worker_table tbody tr").not('#firstworkertr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
    }

    function delrec(elem, id) {
        if (confirm("Are you sure want to delete this job?")) {
            $(elem).parent().remove();
            calculate_total($('select[name="task_tax"]').val());
            window.location.href = "<?php echo $sitename; ?>invoice/<?php echo $showrecords['id'] ?>/editnewinvoice.htm?delid=" + id + "&tot=" + $('input[name="nettotal"]').val();
        }
    }
    function delrec_wor(elem, id) {
        if (confirm("Are you sure want to delete this worker?")) {
            $(elem).parent().remove();
            calculate_total($('select[name="task_tax"]').val());
            window.location.href = "<?php echo $sitename; ?>invoice/<?php echo $showrecords['id'] ?>/editnewinvoice.htm?delid1=" + id + "&tot=" + $('input[name="nettotal"]').val()+"&emptot="+$('#Emptotal').val();
        }
    }
    initMap();
<?php if ($showrecords['customer'] != '') { ?>
        setTimeout(function () {
            // calculate_total($('select[name="task_tax"]').val());
            $.ajax({
                url: "<?php echo $sitename; ?>getpassup.php",
                dataType: 'JSON',
                data: {cusgroup: '<?php echo getcustomer('cus_group', $showrecords['customer']) ?>', cusid: '<?php echo $showrecords['customer']; ?>'}
            }).done(function (data) {
                $('#customer_grouppercent').val(data['0']);
                $('#customer_detail').html(data['1']);
            });
        }, 500);
<?php } ?>
</script>