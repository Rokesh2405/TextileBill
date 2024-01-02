<?php
if (isset($_REQUEST['id'])) {
    $thispageeditid = 12;
} else {
    $thispageaddid = 12;
}
$menu = "19,20,20";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];

//echo "<pre>";
//print_r($_REQUEST);
//exit;
    
	$task_description = implode(',', $task_description);
    $task_qty = implode(',', $task_qty);
    $task_unitprice = implode(',', $task_amount);
    $task_totamount = implode(',', $task_amount);

    $task_unitprice1 = implode(',', $task_passup1);

    $additioncharg = implode(',', $additcharge);

    $task_employee2 = implode(',', $employees_grouppercent);
    $task_description2 = implode(',', $empdesc);
    $task_qty2 = $empqty1;
    $task_unitprice2 = implode(',', $empbasicpay);
    //exit;

    $passupvalue = implode(',', $task_passup);
    $task_passup12 = implode(',', $task_passup1);
    $passup_amount2 = implode(',', $passup_amount);
    $empqty1 = implode(',', $empqty);


$price_category1=implode(',',$price_category);
//$msg = addjob_new($task_description,$task_qty,$task_unitprice,$task_description1,$task_qty1,$task_unitprice1,$additioncharg,$task_employee2,$task_description2,$task_qty2,$task_unitprice2,$empqty1,$subtotal,$taxamt,$addcharge,$nettotal,$jobid, $customer, $price_category, $pickup_date, $pickup_time, $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $assign_to, $status, $nettotal, $ip, $task_passup_request, $task_description, $task_price, $task_qty, $task_tax, $task_tax_amount, $task_amount, $task_old_id, $getid);
    $msg = addinvoice($task_tax, $amt, $passupvalue, $task_passup12, $passup_amount2, $task_totamount, $task_description, $task_qty, $task_unitprice, $task_unitprice1, $additioncharg, $task_employee2, $task_description2, $task_qty2, $task_unitprice2, $invoiceid, $customer, $price_category1, $pickup_date, $pickup_time, $pickup_location, $pickup_lat, $pickup_lng, $drop_location, $drop_lat, $drop_lng, $km, $description, $status, $subtotal, $nettotal, $tax, $additionalcharge, $empqty1, $Emptotal, $ip, $getid);
}
if (isset($_REQUEST['id']) && ($_REQUEST['id'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `jobinvoice` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid']) && $_REQUEST['delid'] != '') {
    $up = $db->prepare("DELETE FROM `job_newtask` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid']));

    $up1 = $db->prepare("UPDATE `jobinvoice` SET `nettotal`=? WHERE `id`=?");
    $up1->execute(array($_REQUEST['tot'], $_REQUEST['id']));
    echo '<script>window.location.href="' . $sitename . 'jobs/' . $showrecords['id'] . '/editnewjob.htm"</script>';
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `job_newinvoice` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));

    $up1 = $db->prepare("UPDATE `job_newinvoice` SET `nettotal`=? WHERE `id`=?");
    $up1->execute(array($_REQUEST['tot'], $_REQUEST['id']));
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
<script>
    function getprcid(a)
    {
        document.getElementById("prcid").value = a;
    }
    function getslotvalue(a)
    {
        $.ajax({
            url: "<?php echo $sitename; ?>getslot.php",
            dataType: 'JSON',
            data: {slotid: b}
        }).done(function (data) {
            $('#task_slotamt').val(data[0]);
        });
    }

    function getpassupprice(elem)
    {
        var new_elem = $(elem).parents('tr').find('td');
        var tax = new_elem.find('select[name="task_passup[]"]');
        var rate = new_elem.find('input[name="task_amount[]"]').val();
        var tax_type = parseFloat(rate) * (parseFloat(tax.find('option:selected').data('type')) / 100);
        var total = tax_type + parseFloat(rate);
        
        new_elem.find('input[name="task_passup1[]"]').val(tax_type);
        new_elem.find('input[name="passup_amount[]"]').val(total);
    }

    function additionalcharge()
    {
        $('input[name="task_amount[]"]').each(function (e) {
            nettotal = parseFloat(nettotal) + (parseFloat($(this).val()) || parseFloat(0));
        });
    }

</script>
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
                                    <input type="text" readonly name="invoiceid" id="invoiceid" class="form-control" value="<?php echo ($fetched['invoiceid'] != '') ? $fetched['invoiceid'] : 'INV' . date("YmdHis"); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Customer</label>
                                    <div class="input-group">
                                        <input type="hidden" name="customer_group" id="customer_group">
                                        <input type="hidden" name="customer_grouppercent" id="customer_grouppercent">
                                        <input type="text" id="customer" class="form-control" readonly value="<?php echo getcustomer('firstname', $showrecords['customer']); ?>"/>
                                        <input type="hidden" name="customer" id="customer_id" class="form-control" readonly value="<?php echo getcustomer('cid', $showrecords['customer']); ?>" />
                                        <span class="input-group-addon" id="customer_grid_search" style="cursor: pointer;" data-toggle="modal" data-target="#customer_grid_modal"><i class="fa fa-search"></i></span>
                                    </div>
                                </div>                       
                            </div>
                            <br />
                            <div class="row">
                               
                                <div class="col-md-4">
                                    <label>Pickup Date<span style="color:#F00;">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right usedatepicker" name="pickup_date" id="pickup_date" required="required"  value="<?php
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
                                            <input type="text" name="pickup_time" id="pickup_time" required="required" class="form-control timepicker" value="<?php echo date("h:i A",strtotime($showrecords['pickup_time'])); ?>" />
                                        </div>
                                    </div>                            
                                </div>		
                                <!--<div class="col-md-4">
                                    <label>Choose Jobs</label>
                                    <button type="button" name="choose_job" id="choose_job_id" class="btn btn-info" style="display: block;">Choose</button>
                                </div>-->
                            </div>
                            <br>                                        
                            <div class="row">                         
                                <div class="col-md-4">
                                    <label>Pickup location<span style="color:#F00;">*</span></label>                       
                                    <input type="text" class="form-control" name="pickup_location" id="pickup_from" placeholder="Pick location" required="required" value="<?php echo $showrecords['pickup_location']; ?>"/>
                                    <input type="hidden" name="pickup_lat" id="pickup_lat" value="<?php echo $showrecords['pickup_lat']; ?>" />
                                    <input type="hidden" name="pickup_lng" id="pickup_lng" value="<?php echo $showrecords['pickup_lng']; ?>" />         
                                </div>
                                <div class="col-md-4">
                                    <label>Drop location<span style="color:#F00;">*</span></label>
                                    <input type="text" class="form-control" name="drop_location" id="drop_to" placeholder="Drop location" value="<?php echo $showrecords['drop_location']; ?>" required="required" />
                                    <input type="hidden" name="drop_lat" id="drop_lat" value="<?php echo $showrecords['drop_lat']; ?>" />
                                    <input type="hidden" name="drop_lng" id="drop_lng" value="<?php echo $showrecords['drop_lng']; ?>" />
                                </div>   
                                <div class="col-md-4">
                                    <label>KM</label>
                                    <input type="text" readonly name="km" id="km" class="form-control" value="<?php echo $showrecords['km']; ?>" />
                                </div>
                            </div>
                            <br>
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
                                                    <th width="25%">Price Category</th>
                                                    <th width="25%">Description</th>
                                                    <th width="10%">Qty</th>
                                                    <th width="10%">Per Rate</th>
                                                    <th width="10%">Total Rate</th>
                                                    <th width="20%">Passup Request</th>
                                                    <th width="10%">Passup Rate</th>
                                                    <th width="10%">Amount</th>
                                                    <td width="5%"></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $deta = $db->prepare("SELECT * FROM `job_newtask` WHERE `job_id`='" . $showrecords['id'] . "'");
                                                $deta->execute();
                                                $sno = 0;
                                                while ($fetc = $deta->fetch()) {
                                                    $sno++;
                                                    $tot=$fetc['per_rate']*$fetc['qty'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $sno ?></td>
                                                        <td>
<select name="price_category[]" id="price_category[]" class="form-control" onchange="calculate_price($(this));">
                                        <option value="">Select</option>
                                        <?php
                                        $pricelist = pFETCH("SELECT * FROM `pricing` WHERE `status`=? AND `status`!=?", '1', '2');
                                        while ($pricefetch = $pricelist->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $pricefetch['id']; ?>" <?php
                                            if ($pricefetch['id'] == $fetc['pricecategory']) {
                                                echo 'selected';
                                            }
                                            ?> data-type="<?php echo $pricefetch['id']; ?>"><?php echo $pricefetch['title']; ?></option>
                                                <?php } ?>
                                    </select></td>
                                                        <td><input type="hidden" name="prcres[]" id="prcres[]"><input type="text" name="task_description[]" class="form-control" value="<?php echo $fetc['description']; ?>" /></td>
                                                        <td><input type="text" name="task_qty[]" min="1" class="form-control" onkeyup="calculate_price($(this));" value="<?php echo $fetc['qty']; ?>" /></td>
                                                        <td><input type="text" style="text-align: right;" name="task_amount[]" class="form-control" onkeyup="calculate_price($(this));" value="<?php echo $fetc['per_rate']; ?>" readonly /></td>
                                                        <td><input type="text" name="task_totamount[]" class="form-control" onkeyup="calculate_price($(this));" value="<?php echo $tot; ?>"  readonly /></td>

                                                        <td><input type="hidden" name="passupres[]" id="passupres[]">
                                                            <select name="task_passup[]" id="task_passup[]" class="form-control" onchange="calculate_price($(this));">
                                                                <option value="">Select Passup</option>
                                                                <?php
                                                                $i = '0';
                                                                $gsts = $db->prepare("SELECT * FROM `passup`");
                                                                $gsts->execute();
                                                                while ($fgsts = $gsts->fetch()) {
                                                                    ?>
                                                                    <option value="<?php echo $fgsts['id']; ?>" data-type="<?php echo $fgsts['value']; ?>" <?php echo ($fetc['passup'] == $fgsts['id']) ? 'selected' : ''; ?>><?php echo $fgsts['name']; ?></option>
                                                                <?php } ?>
                                                            </select></td>
                                                        <td><input type="text" style="text-align: right;" name="task_passup1[]" class="form-control" readonly value="<?php echo $fetc['passup_rate']; ?>"  readonly /></td>
                                                        <td><input type="text" style="text-align: right;" name="passup_amount[]" class="form-control" readonly value="<?php echo $fetc['amount']; ?>"  readonly /></td>
                                                        <td onclick="delrec($(this), '<?php echo $fetc['id']; ?>')"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr id="firsttasktr" style="display:none;">
                                                    <td>1</td>
<td>
<select name="price_category[]" id="price_category[]" class="form-control" onchange="calculate_price($(this));">
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
                                    </select></td>
                                                    <td>
                                                        <input type="hidden" name="prcres[]" id="prcres[]">
                                                        <input type="text" name="task_description[]" class="form-control" value="<?php echo $fetc['description']; ?>" /></td>
                                                    <td><input type="text" name="task_qty[]" id="task_qty" class="form-control" onkeyup="calculate_price($(this));" /></td>

                                                    <td><input type="text" style="text-align: right;" name="task_amount[]" class="form-control" onkeyup="calculate_price($(this));" readonly /></td>
                                                    <td><input type="text" name="task_totamount[]" class="form-control" onkeyup="calculate_price($(this));" readonly /></td>

                                                    <td><input type="hidden" name="passupres[]" id="passupres[]">
                                                        <select name="task_passup[]" id="task_passup[]" class="form-control" onchange="calculate_price($(this));">
                                                            <option value="">Select Passup</option>
                                                            <?php
                                                            $i = '0';
                                                            $gsts = $db->prepare("SELECT * FROM `passup`");
                                                            $gsts->execute();
                                                            while ($fgsts = $gsts->fetch()) {
                                                                ?>
                                                                <option value="<?php echo $fgsts['id']; ?>" data-type="<?php echo $fgsts['value']; ?>" <?php echo ($fetc['passup'] == $fgsts['id']) ? 'selected' : ''; ?>><?php echo $fgsts['name']; ?></option>
                                                            <?php } ?>
                                                        </select></td>
                                                    <td><input type="text" style="text-align: right;" name="task_passup1[]" class="form-control" readonly /></td>
                                                    <td><input type="text" style="text-align: right;" name="passup_amount[]" class="form-control" readonly /></td>
                                                </tr>

                                            </tbody>
                                            <tfoot>
                                                <tr><td colspan="9"></td></tr>
                                                <tr>
                                                    <td colspan="2" style="border:0;"><button type="button" class="btn btn-info" id="add_task">Add Task</button></td>
                                                    <td colspan="7" style="border:0;padding-top: 15px;"><strong>Total Qty : <span class="empqty1">0</span><br></strong></td>
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
                                        $showrecords['additionalcharge'] = $showrecords['additionalcharge']!='' ? $showrecords['additionalcharge'] : '0';
                                        $coun = $db->prepare("SELECT * FROM `additional_charges` WHERE `id` IN (".$showrecords['additionalcharge'].")");
                                        $coun->execute();
                                        $addcharge = explode(",", $showrecords['additionalcharge']);
                                        $sel = '';
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
                                                <td><?php echo $fcoun['charge']; ?> %</td>
                                                <td><i onclick="del_addi($(this));" class="fa fa-trash fa-2x" style="cursor: pointer;color:#F00;"></i></td>
                                            </tr>                                            
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">
                                                    Sub Total: <input type="hidden" name="subtotal" value="<?php echo $showrecords['subtotal']; ?>" /><span class="subtotal"><?php echo $showrecords['subtotal']; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
<?php $taxdetails = FETCH_all("SELECT * FROM `tax` WHERE `id` = ?", '1');?>
                                                <td colspan="3" style="text-align: right;">
                                                    Tax:  
                                                    <input type="hidden" name="gstid" id="gstid">
                                                   <input data-type="<?php echo $taxdetails['type']; ?>" data-perc="<?php echo $taxdetails['percentage']; ?>" type="hidden" name="task_tax" id="task_tax" value="<?php echo $taxdetails['type']; ?>" />

                                                   <!-- <select name="task_tax"  onchange="calculate_total(this.value);">
                                                        <option value="">Select GST</option>
                                                        <?php
                                                       // $gsts = $db->prepare("SELECT * FROM `tax` WHERE `status`='1'");
                                                       // $gsts->execute();
                                                       // while ($fgsts = $gsts->fetch()) {
                                                            ?>
                                                            <option value="<?php //echo $fgsts['id']; ?>" data-perc="<?php //echo $fgsts['percentage']; ?>" data-type="<?php //echo $fgsts['type']; ?>" <?php //echo ($showrecords['tax_id'] == $fgsts['id']) ? 'selected' : ''; ?>><?php //echo $fgsts['title']; ?></option>
                                                        <?php //} ?>
                                                    </select>--><input type="hidden" name="tax" value="<?php
                                                    if ($showrecords['tax']) {
                                                        echo $showrecords['tax'];
                                                    } else {
                                                        echo "0.0";
                                                    }
                                                    ?>" /><span class="taxxamt"><?php echo $showrecords['tax']; ?></span>
                                                    <span id="taxamt"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">
                                                    <input type="hidden" name="amt" id="amt" value="<?=$showrecords['additionalchargeprice']?>">
                                                    Additional Charges : <input type="hidden" name="addcharge" value="<?php
                                                    if ($showrecords['additionalchargeprice']) {
                                                        echo $showrecords['additionalchargeprice'];
                                                    } else {
                                                        echo "0.0";
                                                    }
                                                    ?>"/><span class="addcharge"><?php echo $showrecords['additionalchargeprice']; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">
                                                    Total Amount : <input type="hidden" name="nettotal" value="<?php
                                                    if ($showrecords['nettotal']) {
                                                        echo $showrecords['nettotal'];
                                                    } else {
                                                        echo "0.0";
                                                    }
                                                    ?>" /><span class="nettotal"><?php echo $showrecords['nettotal']; ?></span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" name="addcharges_btn" class="btn btn-info" id="addcharges_btn" data-toggle="modal" data-target="#additional_grid_modal">Add Additional Charges</button>
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
                                                <td><strong>Amount</strong></td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $deta = $db->prepare("SELECT * FROM `job_invoice` WHERE `subject`='Worker Charge' AND `job_id`='" . $showrecords['id'] . "' ");
                                            $deta->execute();
                                            $sno = 0;
                                            while ($fetc = $deta->fetch()) {
                                                $sno++;
                                                $amt = $fetc['task_quty'] * $fetc['task_unit_price'];
                                                ?>
                                                <tr>
                                                    <td><?=$sno?></td>
                                               <!-- <td>
                                                                                              <input type="hidden" name="emptotal" id="empqtotal"> </td>-->
                                                    <td>                                               <input type="hidden" name="employees_grouppercent[]" value="<?php echo $fetc['employee']; ?>">
                                                  <input type="text" class="form-control employees_view" readonly value="<?php echo getdriver('firstname', $fetc['employee']); ?>" style="width: 70%;float:left;"/>
                                                  <span class="input-group-addon" id="employees_grid_search" style="cursor: pointer;width: 30%;float:left;height: 34px;" data-toggle="modal" data-target="#employee_grid_modal" onclick="setmodal_tr($(this).parent().parent())"><i class="fa fa-search"></i></span>
                                                  </td>
                                                    <td id="desc"><input type="text" name="empdesc[]" id="empdesc[]" class="form-control" value="<?php echo $fetc['task_description']; ?>" /></td>
                                                    <td id="basicpay"><input type="text" name="empbasicpay[]" id="empbasicpay[]" class="form-control readonly" value="<?php echo $fetc['task_unit_price']; ?>" readonly /></td>                                                    
                                                    <td id="empqty"><input type="text" name="empqty[]" id="empqty[]" class="form-control readonly" value="<?php echo $fetc['task_quty']; ?>" readonly /></td>
                                                    <td><input type="text" name="empamt[]" id="empamt[]" class="form-control readonly" value="<?php echo $amt; ?>"  readonly /></td>
                                                    <td onclick="delrec_wor($(this), '<?php echo $fetc['id']; ?>')"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>
                                                </tr>
                                            <?php } ?>

                                            <tr style="display:none;" id="firstworkertr">
                                                <td>1</td>

                                                <td>
                                                    <input type="hidden" name="emptotal" id="empqtotal">
                                                    <input type="hidden" name="employees_grouppercent[]">
                                                    <input type="text" class="form-control employees_view" readonly value="<?php echo getcustomer('firstname', $showrecords['customer']); ?>" style="width: 70%;float:left;"/>
                                                    <span class="input-group-addon" id="employees_grid_search" style="cursor: pointer;width: 30%;float:left;height: 34px;" data-toggle="modal" data-target="#employee_grid_modal" onclick="setmodal_tr($(this).parent().parent())"><i class="fa fa-search"></i></span>

                                                </td>
                                                <td id="desc"><input type="text" name="empdesc[]" id="empdesc[]" class="form-control"></td>
                                                <td id="basicpay"><input type="text" name="empbasicpay[]" id="empbasicpay[]" class="form-control readonly" readonly></td>                                                    
                                                <td id="empqty"><input type="text" name="empqty[]" id="empqty[]" class="form-control" readonly></td>
                                                <td><input type="text" name="empamt[]" id="empamt[]" class="form-control readonly" readonly>
                                            </tr> 
                                        </tbody>

                                    </table>

<br />
                                <button type="button" class="btn btn-info" id="add_worker" style="padding-left:20px;">Add Worker</button></div>

                            </div>
                            <div class="col-12" align="right">
                                <input type="hidden" name="Emptotal" id="Emptotal">
                                <strong style="text-align:right;">Worker Charges&nbsp;</strong><span class="Emptotal"></span>
                            </div>
                        </div>

                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Description<span style="color:#F00;">*</span></label>
                            <textarea name="description" class="form-control" id="description" required="required"><?php echo $showrecords['description']; ?></textarea>

                        </div>



                    </div>                    
                    <br>
                    <div class="row">
                        <div class="col-md-6">

                            <label>Status  <span style="color:#FF0000;">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php echo(isset($_REQUEST['id'])) ? ($showrecords['status'] == '1') ? 'selected' : '' : 'selected'; ?>>Active</option>
                                <option value="0" <?php echo(isset($_REQUEST['id'])) ? ($showrecords['status'] == '0') ? 'selected' : '' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>					   
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo $sitename; ?>jobs/job.htm">Back to Listings page</a>
                        </div>
                       <!-- <div class="col-md-4">
                            <?php //if ($showrecords['id'] != '') { ?>
                                <a href="<?php //echo $sitename; ?>MPDF/invoice/invoice.php?id=<?php //echo $showrecords['id']; ?>" target="_blank" class="btn btn-info">Generate Invoice</a>
                            <?php //} ?>
                        </div>-->
                        <div class="col-md-4">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['id'] != '') {
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
                                    <td><button type="button" class="btn btn-success" onclick="select_worker('<?php echo $fetched['did']; ?>', '<?php echo $fetched['firstname']; ?>')">Select</button></td>
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
                                <th width="35%">Customer Name</th>
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
                                    <td><?= getcustomer('firstname', $fetched['cid']) ?></td>
                                    <td><button type="button" class="btn btn-success" onclick="select_customer('<?php echo $fetched['cid']; ?>', '<?php echo getcustomer('firstname', $fetched['cid']); ?>', '<?php echo getcustomer('cus_group', $fetched['cid']); ?>')">Select</button></td>
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
                                    if (in_array($fcoun['id'], $addcharge)) {
                                        $sel = 'checked="checked"';
                                    } else {
                                        $sel = '';
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $fcoun['name']; ?></td>
                                        <td><?php echo $fcoun['charge']; ?></td>
                                        <td><input data-name="<?php echo $fcoun['name']; ?>" data-value="<?php echo $fcoun['charge']; ?>"  <?php echo $sel; ?> type="checkbox" name="additional_charges_check[]" value="<?php echo $fcoun['id']; ?>" /></td>
                                    </tr>
                                <?php }  ?>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJDyvS5KNpnvnegYaDI63SpMlSezrM9iE&libraries=places&callback=initMap" async defer></script>
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

                                            var input = document.getElementById('google_autofile_text');
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
                                            });



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
            });

            data = $(data);
            $('#worker_table tbody').append(data);
            re_assing_serial();
        });


        $('#add_task').click(function () {
           // if ($('#price_category').val() == '')
           // {
            //    alert("Please Select Price Category");
            //} else
            //{
                var data = $('#firsttasktr').clone();
                var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                    if (confirm("Are you sure want to delete task?")) {
                        $(this).parent().remove();
                        re_assing_serial();
                        calculate_total($('select[name="task_tax"]').val());
                    }
                });
                $(data).attr('id', '').show().append(rem_td);
                $(data).find('td').each(function (e) {
                    $(this).find('input,select').val('').attr('required', 'required');
                });

                data = $(data);
                $('#task_table tbody').append(data);
                if ($('#prcid').val() == '2')
                {
                    $('input[name="task_qty[]"]').each(function (e) {
                        if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                            $(this).val($('#km').val());
                        }
                    });
                }
                re_assing_serial();
            //}
        });
        
        $('#addcharges_btn').click(function (e) {
            $('#additional_grid_table').dataTable({
                paging:false
            });
            $('input[name="additional_charges_check[]"]').prop('checked',false);
            $('input[name="additcharge[]"]').each(function(){
                $('input[name="additional_charges_check[]"][value="'+$(this).val()+'"]').prop('checked',true);
            });
        });
        $('#add_additional_charges_button').click(function(){
            var len = $('input[name="additional_charges_check[]"]:checked');
            if(len.length > 0){
                var elems = '';
                len.each(function(){
                    var new_elem = '<tr><td><input data-type="'+$(this).data('value')+'" type="hidden" name="additcharge[]" id="additcharge" value="'+$(this).val()+'" />'+$(this).data('name')+'</td><td>'+$(this).data('value')+' %</td><td><i onclick="del_addi($(this));" class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td></tr>';
                    elems += new_elem;
                });
                $('#additional_charges_display tbody').html(elems);             
                additionalprice();
                $('#additional_grid_modal').modal('hide');
            }else{
                alert("Please select atleast one additional charges..");
            }
        });
        $('#choose_job_id').click(function(){
            if($('#customer_id').val()!=''){
                $('#choose_jobs_grid_modal').modal('show');
                 $.ajax({
                    url: "<?php echo $sitename; ?>getpassup.php",
                    data: {get_jobs: $('#customer_id').val()}
                }).done(function (data) {
                    $('#choose_jobs_grid_table tbody').html(data);
                });                                
            }else{
                alert("Please choose customer.");
            }
        });
        
        $('#add_jobs_c_button').click(function(){
            var len = $('input[name="jobs_checkboxs[]"]:checked');
            if(len.length > 0){
                var elems = [];
                len.each(function(){
                    elems.push($(this).val());
                });
                $.ajax({
                    url: "<?php echo $sitename; ?>getpassup.php",
                    data: {jobs_id: elems},
                    dataType: 'JSON',
                }).done(function (data) {
                    
                });   
                $('#choose_jobs_grid_modal').modal('hide');
            }else{
                alert("Please select atleast one job..");
            }    
        });

    });

    function del_addi(elem){
        if(confirm("Are you sure want to remove this?")){
            elem.parent().parent().remove();
            additionalprice();
        }
    }

    function setmodal_tr(elem) {
        $('#employee_grid_modal').data('elem', elem);
    }

    function select_worker(id, name) {

        $('#employee_grid_modal').modal('hide');
        var selected_elem = $('#employee_grid_modal').data('elem');
        $(selected_elem).find('td input[name="employees_grouppercent[]"]').val(id);
        var empqty1 = parseFloat(0);
         $('input[name="task_qty[]"]').each(function (e) {
            if ($(this).parent().parent().attr('id') != 'firsttasktr') {
                empqty1 = parseFloat(empqty1) + (parseFloat($(this).val()) || parseFloat(0));
            }
        });
        $(selected_elem).find('td input[name="empqty[]"]').val(empqty1);
        var qty = $(selected_elem).find('td input[name="empqty[]"]').val();
        $(selected_elem).find('td .employees_view').val(name);
        $.ajax({
            url: "<?php echo $sitename; ?>getslot.php",
            dataType: 'JSON',
            async: false,
            data: {getBasic: id, pric_cate: $('#prcid').val()}
        }).done(function (data) {
            $(selected_elem).find('td input[name="empbasicpay[]"]').val(data[0]);
            var total = qty * data[0];
            $(selected_elem).find('td input[name="empamt[]"]').val(total);
            calcuempamt();
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

        $('#Emptotal').val(empamt.toFixed(2));
        $('.Emptotal').html(empamt.toFixed(2));
    }
    function select_customer(id, name, cusgroup) {

        $('#customer_grid_modal').modal('hide');
        $('#customer').val(name);
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


    function calculate_price(elem) {
        var cuspercent = $('#customer_grouppercent').val();
        var new_elem = $(elem).parents('tr').find('td');
        var passup_req = new_elem.find('select[name="task_passup[]"]').val();

        var rate = new_elem.find('input[name="rate[]"]').val

        var qty = new_elem.find('input[name="task_qty[]"]').val();
        //var prcid = $('#prcid').val();

 var prcid = new_elem.find('select[name="price_category[]"]').val();
if(qty!='0')
{
        var prccatid_value = $('#customer_grouppercent').val();


        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            dataType: 'JSON',
            async:false,
            data: {getrange: prcid, qty: qty}
        })
		.done(function (data) {
			new_elem.find('input[name="prcres[]"]').val(data['0']);
		});


        var prcres = new_elem.find('input[name="prcres[]"]').val();

        if (parseFloat(cuspercent) > 0) {
            var rate = prcres * (cuspercent / 100);
        } else {
            var rate = 0;
        }
    
    
        var rate1 = parseFloat(prcres) - parseFloat(rate);
        
        passup_req1 = parseFloat(new_elem.find('select[name="task_passup[]"] option[value="'+passup_req+'"]').data('type')) || parseFloat(0);
        
        var passrate = rate1 * (passup_req1 / 100);

        var task_totamount = qty * rate1;

        new_elem.find('input[name="task_totamount[]"]').val(task_totamount);

        new_elem.find('input[name="task_passup1[]"]').val(rate1);

        var passup_req1 = new_elem.find('input[name="task_passup1[]"]').val();

        var frate = parseFloat(task_totamount) + parseFloat(passrate);

		
        new_elem.find('input[name="task_passup1[]"]').val(passrate);
        new_elem.find('input[name="task_amount[]"]').val(rate1);
        new_elem.find('input[name="passup_amount[]"]').val(frate);
        $(amt).val(frate);
        calculate_total($('select[name="task_tax"]').val());
   } }

    function additionalprice(a) {
        var total = parseFloat(0);
        var subtotal = parseFloat(0);
        var nettotal = parseFloat(0);
        var n = parseFloat(0);
        subtotal = $('input[name="subtotal"]').val();
        for (var i = 0; i < document.department.additcharge.length; i++) {
          
  //          if (document.department.additcharge[i].checked == true)
//            {
                var gval = document.department.additcharge[i].getAttribute("data-type");
                n = subtotal * (gval / 100);
                total = parseFloat(total) + parseFloat(n);
  //          }


        }
        $('.addcharge').html(total.toFixed(2));
        $('input[name="addcharge"]').val(total.toFixed(2));
        $('input[name="amt"]').val(total.toFixed(2));

        subtotal = $('input[name="subtotal"]').val();

        nettotal = parseFloat(subtotal) + total;

        $('.nettotal').html(nettotal.toFixed(2));
        $('input[name="nettotal"]').val(nettotal.toFixed(2));

    }
    function calculate_total(a) {

        var additionalcharge = $('input[name="addcharge"]').val();
        var subtotal = parseFloat(0);
        var nettotal = parseFloat(0);
        var taxamt = parseFloat(0);
        var subtotal1 = $('input[name="amt"]').val();
        var empqty1 = 0;


var gsttype = $('input[name="task_tax"]').data('type');
//alert(gsttype);
 var gstperc = $('input[name="task_tax"]').data('perc');
//alert(gstperc);
if (gsttype == '1') {


                    tax_amt = parseFloat(subtotal1) - parseFloat((subtotal / (100 + parseFloat(gstperc))) * 100);
                } else {
                    tax_amt = parseFloat((subtotal1 * parseFloat(gstperc)) / 100);
                }


            $('.taxxamt').html(tax_amt);
            $('input[name="tax"]').val(tax_amt.toFixed(2));

       


        $('input[name="passup_amount[]"]').each(function (e) {
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

        $('input[name="empqty1"]').val(empqty1);

        $('input[name="empqty[]"]').val(empqty1);

        var es = 0;
        $('input[name="empamt[]"]').each(function (e) {            
            if ($(this).parent().parent().attr('id') != 'firstworkertr') {
                $(this).val($('input[name="empbasicpay[]"]').eq(es).val() * empqty1);
            }
            es++;
        });
        calcuempamt();

        $('.empqty1').html(empqty1);

        var gstid = $('input[name="gstid"]').val();
//alert(gstid);

        $('.subtotal').html(subtotal.toFixed(2));
        $('input[name="subtotal"]').val(subtotal.toFixed(2));


        if (gstid == '1')
        {
            nettotal = parseFloat(subtotal) + parseFloat(additionalcharge);

            $('.nettotal').html(nettotal.toFixed(2));
            $('input[name="nettotal"]').val(nettotal.toFixed(2));
        } else {

            taxamt = $('input[name="tax"]').val();


            nettotal = parseFloat(subtotal) + parseFloat(additionalcharge) + parseFloat(taxamt);



//$('.subtotal').html(subtotal.toFixed(2));
// $('input[name="subtotal"]').val(subtotal.toFixed(2));

            $('.nettotal').html(nettotal.toFixed(2));
            $('input[name="nettotal"]').val(nettotal.toFixed(2));
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

    function delrec(elem, id) {
        if (confirm("Are you sure want to delete this job?")) {
            $(elem).parent().remove();
            calculate_total($('select[name="task_tax"]').val());
            window.location.href = "<?php echo $sitename; ?>jobs/<?php echo $showrecords['id'] ?>/editnewjob.htm?delid=" + id + "&tot=" + $('input[name="nettotal"]').val();
        }
    }
    function delrec_wor(elem, id) {
        if (confirm("Are you sure want to delete this worker?")) {
            $(elem).parent().remove();
            calculate_total($('select[name="task_tax"]').val());
            window.location.href = "<?php echo $sitename; ?>jobs/<?php echo $showrecords['id'] ?>/editnewjob.htm?delid1=" + id + "&tot=" + $('input[name="nettotal"]').val();
        }
    }
    <?php if($showrecords['id']!=''){ ?>
    setTimeout(function(){ 
        calculate_total($('select[name="task_tax"]').val());
        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            dataType: 'JSON',
            data: { cusgroup : '<?php echo getcustomer('cus_group',$showrecords['customer']) ?>' , cusid: '<?php echo $showrecords['customer']; ?>' }
        }).done(function (data) {
            $('#customer_grouppercent').val(data['0']);
            $('#customer_detail').html(data['1']);
        });
    },500);
    <?php } ?>
</script>