<?php
if (isset($_REQUEST['stockid'])) {
    $thispageeditid = 32;
} else {
    $thispageaddid = 32;
}
$collapse = '1';
$menu = "4,4,4,32";
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';
include ('../../require/header.php');
$getmanuf = $db->prepare("SELECT * FROM `purchase_order` ORDER BY `PoID` DESC");
$getmanuf->execute();
$lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
    $val = 1;
    $purid = 'POI' . str_pad(1, 8, '0', STR_PAD_LEFT);
} else {
    $val = $lst['PoID'] + 1;
    $purid = 'POI' . str_pad($val, 8, '0', STR_PAD_LEFT);
}

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    //print_r($_REQUEST);
    //exit;
    $_SESSION['stockid'] = $_REQUEST['stockid'];
    $id = $_REQUEST['stockid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $product_id   = implode("#,#",$_REQUEST['Item_name']);
    $product_name = implode("#,#",$_REQUEST['Item_name1']);
    $batchnumber  = implode("#,#",$_REQUEST['batchnumber']);
    $qty          = implode("#,#",$_REQUEST['Qty']);
    $packuom      = implode("#,#",$_REQUEST['Pack_UOM']);
    $packqty      = implode("#,#",$_REQUEST['Pack_qty']);
    $itemuom      = implode("#,#",$_REQUEST['Item_UOM']);
    $totqty       = implode("#,#",$_REQUEST['Total_Qty']);
    $packrate     = implode("#,#",$_REQUEST['Pack_Rate']);
    $itemrate     = implode("#,#",$_REQUEST['Item_Rate']);
    $spackrate    = implode("#,#",$_REQUEST['sPack_Rate']);
    $sitemrate    = implode("#,#",$_REQUEST['sItem_Rate']);
    $tax          = implode("#,#",$_REQUEST['tax']);
    $taxableamt   = implode("#,#",$_REQUEST['Taxable_Amt']);
    $taxamt       = implode("#,#",$_REQUEST['Tax_Amt']);
    $netamt       = implode("#,#",$_REQUEST['Net_Amt']);    
    
    $msg = addopeningstock($stockdate, $taxtype, $product_id, $product_name, $batchnumber, $qty, $packuom, $packqty, $itemuom, $totqty, $packrate, $itemrate, $spackrate, $sitemrate, $tax, $taxableamt, $taxamt, $netamt, $ip, $id);
}
?>
<script type="text/javascript">
    function checkall(objForm) {
        len = objForm.elements.length;
        var i = 0;
        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }
</script>
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
    #normalexamples1 tbody tr td:nth-child(1),tbody tr td:nth-child(6){
        text-align:center;
    }
    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(5){
        text-align:center;
    }
    
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    #customFields td { padding: 0 !important; }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Opening Stock 
            <small><?php
                if ($_REQUEST['stockid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Opening Stock</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-product-hunt"></i> Process</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Stock</a></li>
            <li><a href="<?php echo $sitename; ?>process/purchase_order.htm"><i class="fa fa-circle-o"></i>Opening Stock</a></li>
            <li class="active"><?php
                if ($_REQUEST['stockid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Opening Stock</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        if ($_REQUEST['stockid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Opening Stock</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Order Information
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Date <span style="color:#FF0000;">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right usedatepicker" name="stockdate" required="required"  value="<?php
                                        if (isset($_REQUEST['stockid']) && ( date('d-m-Y', strtotime(getopeningstock('Date', $_REQUEST['stockid']))) != '01-01-1970')) {
                                            echo date('d-m-Y', strtotime(getopeningstock('Date', $_REQUEST['stockid'])));
                                        }
                                        ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Tax Type <span style="color:#FF0000;">*</span></label>
                                    <select name="taxtype" id="taxtype" class="form-control" onchange="univaerselcha()">
                                        <option value="0" <?php
                                        if (getopeningstock('TaxType', $_REQUEST['stockid']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>No Tax</option>
                                        <option value="1" <?php
                                        if (getopeningstock('TaxType', $_REQUEST['stockid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Inclusive Tax</option>
                                        <option value="2" <?php
                                        if (getopeningstock('TaxType', $_REQUEST['stockid']) == '2') {
                                            echo 'selected';
                                        }
                                        ?>>Excluded Tax</option>
                                    </select>
                                </div>
                            </div>
                            <br />
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Item Details
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="customFieldss">
                                    <thead>
                                        <tr valign="top">
                                            <th style="width:14%;">Item</th>
                                            <th style="width:5%;">Batch&nbsp;No</th>
                                            <th style="width:5%;">Qty</th>
                                            <th style="width:5%;">P.UOM</th>
                                            <th style="width:5%;">per</th>
                                            <th style="width:5%;">I.UOM</th>
                                            <th style="width:5%;">Tot&nbsp;Qty</th>
                                            <th style="width:7%;">Pur.P.Rate(<i class="fa fa-inr"></i>)</th>
                                            <th style="width:7%;">Pur.I.Rate(<i class="fa fa-inr"></i>)</th>
                                            <th style="width:7%;">Sal.P.Rate(<i class="fa fa-inr"></i>)</th>
                                            <th style="width:7%;">Sal.I.Rate(<i class="fa fa-inr"></i>)</th>
                                            <th style="width:5%;">Tax</th>
                                            <th style="width:7%;">Taxable&nbsp;Amt</th>
                                            <th style="width:7%;">Tax&nbsp;Amt</th>
                                            <th style="width:7%;">Nett..(<i class="fa fa-inr"></i>)</th>
                                            <th style="width:2%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="customFields">
                                        <?php
                                        if ($_REQUEST['stockid'] != '') {
                                            $getitemvalue = $db->prepare("SELECT * FROM `stock` WHERE `Sid` = ?");
                                            $getitemvalue->execute(array($_REQUEST['stockid']));
                                            $i = '1';
                                            while ($fdepart = $getitemvalue->fetch()) {
                                                ?>
                                                <tr valign="top">
                                                    <td>
                                                        <input type="hidden" name="purchase_detailid[]" id="purchase_detailid<?php echo $fdepart['Product_Id']; ?>"  value="<?php echo $fdepart['Product_Id']; ?>"/>
                                                        <input type="text" class="form-control" style="border: 1px solid #f9f9f9;"  name="Item_name1[]" id="Item_name1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" data-id="<?php echo $fdepart['Product_Name']; ?>" value="<?php echo $fdepart['Product_Name']; ?>" readonly="readonly" />
                                                        <input type="hidden" class="form-control" style="border: 1px solid #f9f9f9;"  name="Item_name[]" id="Item_name1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" data-id="1" value="<?php echo $fdepart['Product_Id']; ?>" readonly="readonly" />
                                                    </td>
                                                    <td> 
                                                        <input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="batchnumber[]" id="batchnumber1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" placeholder="Batch Number" value="<?php echo $fdepart['Batch_Number']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9;" class="form-control"  onkeyup="caltolqty(this.value, '1')"  placeholder="Qty" name="Qty[]" id="Qty1"  pattern="[0-9  .,:'()]{1,60}" data-id="1"  title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $fdepart['Qty']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Pack_UOM1[]" id="Pack_UOM1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo getuom('Name', $fdepart['PUom']); ?>" readonly="readonly" />
                                                        <input type="hidden" class="form-control"  name="Pack_UOM[]" id="Pack_UOM" required="required" value="<?php echo $fdepart['PUom']; ?>"  />
                                                    </td>
                                                    <td>
                                                        <input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Pack_qty[]" id="Pack_qty1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $fdepart['per']; ?>" readonly="readonly" />
                                                    <td>
                                                        <input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Item_UOM1[]" id="Item_UOM1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo getuom('Name', $fdepart['IUom']); ?>" readonly="readonly" />
                                                        <input type="hidden" class="form-control"  name="Item_UOM[]" id="Item_UOM" required="required" value="<?php echo $fdepart['IUom']; ?>"  />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control"  step="0.0001" onkeyup="calpackqty(this.value, '1')" placeholder="Total Qty" name="Total_Qty[]" id="Total_Qty1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $fdepart['Tot_Qty']; ?>" />   
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control"  step="0.0001"  placeholder="Pack Rate" name="Pack_Rate[]" onkeyup="calitemrate(this.value, '1')" id="Pack_Rate1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo number_format((float) $fdepart['Purchase_pack_rate'], 2, '.', ''); ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control" step="0.0001" placeholder="Item Rate" name="Item_Rate[]" onkeyup="calpackrate(this.value, '1')" id="Item_Rate1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo number_format((float) $fdepart['Purchase_Rate'], 2, '.', ''); ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control"  step="0.0001"  placeholder="Pack Rate" name="sPack_Rate[]" onkeyup="calitemrate(this.value, '1')" id="Pack_Rate1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo number_format((float) $fdepart['Sales_pack_rate'], 2, '.', ''); ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control" step="0.0001" placeholder="Item Rate" name="sItem_Rate[]" onkeyup="calpackrate(this.value, '1')" id="Item_Rate1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo number_format((float) $fdepart['Sales_Rate'], 2, '.', ''); ?>" />
                                                    </td>
                                                    <td>
                                                        <select style="border: 1px solid #f9f9f9;" name = "tax[]" required id = "tax1"  onchange="taxpertage('1')" class = "form-control">
                                                            <option value = "">
                                                                Select Item
                                                            </option>
                                                            <?php
                                                            $getitemvalue121 = $db->prepare("SELECT * FROM `tax` WHERE `status`='1' ");
                                                            $getitemvalue121->execute();
                                                            while ($getval45 = $getitemvalue121->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?php echo $getval45['tid']; ?>#@#<?php echo $getval45['taxpercentage']; ?>"  <?php
                                                                if ($getval45['tid'] == $fdepart['Tax_Id']) {
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?> >  <?php echo $getval45['taxname']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"  class="form-control"  name="Taxable_Amt[]" id="Taxable_Amt1"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $fdepart['Taxable_Amount']; ?>" readonly="readonly" /></td>
                                                    <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"   class="form-control"  name="Tax_Amt[]" id="Tax_Amt1"  pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?php echo $fdepart['Tax_Amount']; ?>" readonly="readonly" /></td>
                                                    <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"   class="form-control"  name="Net_Amt[]" id="Net_Amt1"  pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})"  data-id="1" value="<?php echo number_format((float) $fdepart['Total_Amount'], 2, '.', ''); ?>" readonly="readonly" /></td>
                                                    <td valign="middle"></td>
                                                </tr> 
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <a id="addbutton" onclick="loaditemgrid()" class="btn btn-sm btn-info"  aria-hidden="true" data-toggle="modal" data-target="#ItemModal" >Add Item</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="row" style="font-size: 20px;">
                                        <div class="col-md-8 text-right">
                                            <b>Sub&nbsp;Total(<i class="fa fa-inr"></i>)</b> :
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <span id='subtotaldisplay'><?php
                                                if ($_REQUEST['stockid'] != '') {
                                                    echo number_format((float) (getopeningstock('Total_Amount', $_REQUEST['stockid'])-getopeningstock('Tax_Amount', $_REQUEST['stockid'])), 2, '.', '');
                                                } else {
                                                    echo '0.00';
                                                }
                                                ?></span>
                                            
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="row" style="font-size: 20px;">
                                        <div class="col-md-8 text-right">
                                            <b>Tax(<i class="fa fa-inr"></i>)</b>:
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <span id='taxdisplay'><?php
                                                if ($_REQUEST['stockid'] != '') {
                                                    echo number_format((float) getopeningstock('Tax_Amount', $_REQUEST['stockid']), 2, '.', '');
                                                } else {
                                                    echo '0.00';
                                                }
                                                ?></span>
                                            
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="row" style="font-size: 20px;">
                                        <div class="col-md-8 text-right">
                                            <b>Total Amount(<i class="fa fa-inr"></i>)</b>:
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <span id='NetAmtdisplay'><?php
                                                if ($_REQUEST['stockid'] != '') {
                                                    echo number_format((float) getopeningstock('Total_Amount', $_REQUEST['stockid']), 2, '.', '');
                                                } else {
                                                    echo '0.00';
                                                }
                                                ?></span>
                                            
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"><br /></div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>process/openingstock.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['stockid'] != '') {
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

    <div id="ItemModal" class="modal fade" role="itemmodal">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose from Item register</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="normalexamples1" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:15%">Item Name</th>
                                    <th style="width:25%">Item Code</th>
                                    <th style="width:10%">Order</th>
                                    <th style="width:10%">Status</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">
                                        <input name="check_all" id="check_all" value="1"  type="checkbox" onclick="return checkall('chk[]');" />
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">&nbsp;</th>
                                    <th style="margin:0px auto;"><button type="submit" class="btn btn-success" name="delete" data-dismiss="modal" onclick="return checkselect('chk[]');"> Select </button></th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>

<script>

    //decluration  here
    var supplaerprid = 0;
    var findid = 0;

    //supplier details Start here
<?php if (($_REQUEST['stockid'] == '') && (!isset($_REQUEST['stockid']))) { ?>

        //$("#addbutton").attr("disabled", "disabled");

<?php } ?>

    var gridvalue = Array();
    function loaditemgrid() {
        $('#check_all').prop('checked', false);
        var supplierid = 0;
        if ($('#purmode').val() == '1') {
            supplierid = $('#supplierprimary').val()
        } else {
            supplierid = 'ALL';
        }
        $('#normalexamples1').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            //"scrollX": true,
            "searching": true,
            "destroy": true,
            "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/purchase_table.htm?types=itemtable&supplierid=" + supplierid
        });
    }

    function checkselect(a)
    {
        var param_count = document.getElementsByName(a);
        var values = [];
        for (var i = 0; i < param_count.length; i++) {
            if (param_count[i].checked) {
                values.push(param_count[i].value);
            }
        }
        addrow(values);
    }
    
    $('#check_all').change(function () {
        $('#normalexamples1 input[name="chk[]"]').prop('checked', $(this).prop('checked'));
    });

    function addrow(itemid) {

        var supplierid = 0;
        if ($('#purmode').val() == '1') {
            supplierid = $('#supplierprimary').val()
        } else {
            supplierid = 'ALL';
        }
        findid = findid + 1;

        $('#typeerr').html('');
        var c = parseInt($('#remm').val()) + parseInt(1);
        $('#remm').val(c);

        $("#addbutton").attr("disabled", "disabled");
        $("#submit").attr("disabled", "disabled");
        $("#customFields").append('<tr><td colspan="16"><i class="fa fa-spinner"></i></td></tr>');
        $.post("<?php echo $sitename; ?>pages/process/userajax.php", {supplier: supplierid, findkeyid: findid, selectitem: itemid},
        function (data)
        {
            $("#customFields tr:last").remove();
            $("#customFields").append(data);
            var param_count = document.getElementsByName('Qty[]');
            for (var i = 0; i < param_count.length; i++) {
                caltolqty(param_count[i].value, param_count[i].getAttribute('data-id'))
            }
            $("#addbutton").removeAttr("disabled", "disabled");
            $("#submit").removeAttr("disabled", "disabled");
        });
    }

    function removegriddata(a) { //remove row
        var indexvalue = gridvalue.indexOf(a);
        gridvalue.splice(indexvalue, 1);
        var str = '#removeitems' + a;
        var str1 = '#additems' + a;
        $(str).css('display', "none");
        $(str1).css('display', "inline-block");
        //$('#displayred').html(gridvalue.length);
        $('#displayred').html(gridvalue.toString());
    }
    //Add Row Table  Start here


    var findid = 0;
    function selectitem(value, id) {
        setTimeout(function () {
            if (value !== '') {
                $.post('<?php echo $sitename; ?>pages/master/userajax.php', {itemkeyid: value}, function (data) {
                    if (parseInt() === parseInt(0)) {
                        return false;
                    } else {
                        $('#Pack_UOM' + id).val(data['pack_uom']);
                        $('#Pack_qty' + id).val(data['pack_qty']);
                        $('#Item_UOM' + id).val(data['item_uom']);
                        var justd = parseFloat(data['pack_rate']);
                        var justd1 = parseFloat(data['item_rate']);

                        $('#Pack_Rate' + id).val(justd.toFixed(2));
                        $('#Item_Rate' + id).val(justd1.toFixed(2));
                        var sentval = parseInt($('#Qty' + id).val());

                        if ($('#Qty' + id).val() != '') {
                            caltolqty(sentval, id);
                        }

                        return true;
                    }

                }, 'json');
            }
        }, 100);
    }
    function caltolqty(a, b) {
        var getqty = parseFloat($('#Qty' + b).val());
        //var getqty = parseFloat(a);
        var getqty45 = parseFloat($('#Pack_qty' + b).val());
        if (a === '') {
            $('#Total_Qty' + b).val('');
        } else {
            $('#Total_Qty' + b).val(getqty45 * getqty);
        }
        netamt(b);
        taxpertage(b);
    }

    function calpackqty(a, b) {
        var getqty = parseFloat(a);
        var getqty45 = parseFloat($('#Pack_qty' + b).val());
        if (a === '') {
            $('#Qty' + b).val('');
        } else {
            $('#Qty' + b).val(getqty / getqty45);
        }
        netamt(b);
    }

    function calsitemrate(a, b) {

        var getpackrate = parseFloat($('#sPack_Rate' + b).val());
        var getpackqty = parseFloat($('#Pack_qty' + b).val());
        var itemrateresult = getpackrate / getpackqty;

        if ($('#Qty' + b).val() == '') {
            $('#sItem_Rate' + b).val('');
        } else {
            $('#sItem_Rate' + b).val(itemrateresult.toFixed(2));
        }
        
    }
    
    function calspackrate(a, b) {

        var getpackrate = parseFloat($('#sItem_Rate' + b).val());
        var getpackqty = parseFloat($('#Pack_qty' + b).val());
        var itemrateresult = getpackrate * getpackqty;

        if ($('#Qty' + b).val() == '') {
            $('#sPack_Rate' + b).val('');
        } else {
            $('#sPack_Rate' + b).val(itemrateresult.toFixed(2));
        }
        
    }

    function calitemrate(a, b) {

        var getpackrate = parseFloat($('#Pack_Rate' + b).val());
        var getpackqty = parseFloat($('#Pack_qty' + b).val());
        var itemrateresult = getpackrate / getpackqty;

        if ($('#Qty' + b).val() == '') {
            $('#Item_Rate' + b).val('');
        } else {
            $('#Item_Rate' + b).val(itemrateresult.toFixed(2));
        }
        netamt(b);
        taxpertage(b);
        displaynettotal();
    }
    
    function calpackrate(a, b) {

        var getpackrate = parseFloat($('#Item_Rate' + b).val());
        var getpackqty = parseFloat($('#Pack_qty' + b).val());
        var itemrateresult = getpackrate * getpackqty;

        if ($('#Qty' + b).val() == '') {
            $('#Pack_Rate' + b).val('');
        } else {
            $('#Pack_Rate' + b).val(itemrateresult.toFixed(2));
        }
        netamt(b);
        taxpertage(b);
        displaynettotal();
    }

    function netamt(b) {

        var getqty = parseFloat($('#Qty' + b).val());
        var getrate = parseFloat($('#Pack_Rate' + b).val());
        var netresult = getqty * getrate;

        if ($('#Qty' + b).val() == '') {
            $('#Net_Amt' + b).val('');
        } else {
            $('#Net_Amt' + b).val(netresult.toFixed(2));
        }
        displaynettotal();
    }

    function displaynettotal()
    {
        var total = 0;
        var taable = 0;
        var ttax = 0;
        var Net_Amt = document.getElementsByName('Net_Amt[]');
        var Taxable_Amt = document.getElementsByName('Taxable_Amt[]');
        var Tax_Amt = document.getElementsByName('Tax_Amt[]');

        for (var i = 0; i < Net_Amt.length; i++) {
            total += parseFloat(Net_Amt[i].value) || parseFloat(0);
            taable += parseFloat(Taxable_Amt[i].value) || parseFloat(0);
            ttax += parseFloat(Tax_Amt[i].value) || parseFloat(0);
        }

        $('#NetAmtdisplay').html(total.toFixed(2));
        $('#subtotaldisplay').html(taable.toFixed(2));
        $('#taxdisplay').html(ttax.toFixed(2));
        $('#subtotal').val(taable.toFixed(2));
        $('#taxtotal').val(ttax.toFixed(2));
        $('#netpayamt').val(total.toFixed(2));
    }

    function taxpertage(id)
    {
        var ttax = 0;
        var getqty = parseFloat($('#Qty' + id).val());
        var getrate = parseFloat($('#Pack_Rate' + id).val());
        var gettotal = parseFloat(getqty * getrate);
        
        if ($('#tax' + id).val()!= '')
        {
            var itemrate = $('#tax' + id).val();
            var res = itemrate.split("#@#");
            var taxpercentage = parseFloat(res[1]);
            
            
            if ($('#Net_Amt' + id).val()=='') {
                $('#Taxable_Amt' + id).val('');
                $('#Tax_Amt' + id).val('');
            } else {
                if ($('#taxtype').val()=='0') {
                    $('#Taxable_Amt' + id).val('0.00');
                    $('#Tax_Amt' + id).val('0.00');
                } else if ($('#taxtype').val()=='1') {
                    var taxbamt = (gettotal / (100 + parseFloat(taxpercentage))) * 100;
                    var taxamt = gettotal - taxbamt;
                    $('#Taxable_Amt' + id).val(taxbamt);
                    $('#Tax_Amt' + id).val(taxamt);
                } else {
                    var taxbamt = gettotal;
                    var taxamt = (gettotal * parseFloat(taxpercentage)) / 100;
                    $('#Taxable_Amt' + id).val(taxbamt);
                    $('#Tax_Amt' + id).val(taxamt);
                    $('#Net_Amt' + id).val(taxamt + taxbamt);
                }
            }
        } else {
            $('#Taxable_Amt' + id).val('0.00');
            $('#Tax_Amt' + id).val('0.00');
            $('#Net_Amt' + id).val(gettotal);
        }
        displaynettotal();
    }


    function remove(b) {
        var getv1 = $('#purchase_detailid' + b).val();
        var senttablename = 'purchase_order_details';
        var sentfield = 'PdID';

        if (confirm("Please confirm you want to Delete this Item(s)"))
        {
            if (getv1 != 'NEW') {
                var sentdeldata = $('#purchase_detailid' + b).val();
                $("#addbutton").attr("disabled", "disabled");
                $("#submit").attr("disabled", "disabled");
                $.post("<?php echo $sitename; ?>pages/master/userajax.php", {deledtered: sentdeldata, tablename: senttablename, primarykey: sentfield},
                        function (data)
                        {
                            $("#addbutton").removeAttr("disabled", "disabled");
                            $("#submit").removeAttr("disabled", "disabled");
                        });
            }
            $('#datarow' + b).remove();

            displaynettotal();
            return true;
        } else
        {
            return false;
        }

    }

    function gridmode() {
        if ($('#purmode').val() == '2') {
            $('#suppliermode').css('visibility', 'hidden');
            $('#suppliermode121').css('visibility', 'hidden');
            $("#addbutton").removeAttr("disabled", "disabled");

        } else {
            $('#suppliermode').css('visibility', 'visible');
            $('#suppliermode121').css('visibility', 'visible');
            $("#addbutton").attr("disabled", "disabled");
        }
    }

//tax cal
    function univaerselcha() {

        var lenth = document.getElementsByName('Net_Amt[]');
        var justtemp = '';
        for (var i = 0; i < lenth.length; i++) {
            justtemp = lenth[i].getAttribute('data-id')
            netamt(justtemp);
            taxpertage(justtemp);
            displaynettotal();
        }
    }

    function showtrans(a) {

        $('#st').html('<tr><td colspan="6"><i class="fa fa-spinner fa-spin"></i></td></tr>');
        $.post('<?php echo $sitename; ?>pages/master/userajax.php', {seetrans: '1', supp_id: a}, function (data) {
            $('#st').html(data);
        });
    }

</script>