<?php
$menu = "19,20,20";
$thispageid = 12;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');

if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delinvoice($chk);
}
if (isset($_REQUEST['invoice']) || isset($_REQUEST['invoice_x'])) {

    $chk = $_REQUEST['chk'];
    $chk = implode(',', $chk);
    $sitname = $fsitename . "MPDF/invoice/invoice.php?id=" . $chk;


    // header("location:MPDF/invoice/invoice.php");
    header("location:" . $fsitename . 'management/loyaltypoints/');
    exit;
}
if (isset($_REQUEST['sendmails'])) {
    InvoiceMail($_REQUEST['selected_contacts'], $_REQUEST['invoiced_id']);
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i> Successfully Sent</h4></div>';
}
if ($_REQUEST['change_status'] != '' && $_REQUEST['id'] != '') {
    $up = $db->prepare("UPDATE `jobinvoice` SET `status`='" . $_REQUEST['change_status'] . "' WHERE `id`='" . $_REQUEST['id'] . "'");
    $up->execute();
    header("location:" . $sitename . "invoice/invoice.htm?change_status_suc");
    exit;
}
if ($_REQUEST['change_status_invoice'] != '' && $_REQUEST['id'] != '') {    
    $invno = get_bill_settings('prefix', '1') . str_pad(get_bill_settings('current_value', '1'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
    update_bill_value('1');
    $ups = $db->prepare("UPDATE `jobinvoice` SET `invoiceid`=?,`draft`=? WHERE `id`=?");
    $ups->execute(array($invno, '0', $_REQUEST['id']));
    header("location:" . $sitename . "invoice/invoice.htm?change_status_suc");
    exit;
}
if (isset($_REQUEST['change_status_suc'])) {
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
}
?>
<script type="text/javascript" >
    function validcheck(name)
    {
        var chObj = document.getElementsByName(name);
        var result = false;
        for (var i = 0; i < chObj.length; i++) {
            if (chObj[i].checked) {
                result = true;
                break;
            }
        }
        if (!result) {
            return false;
        } else {
            return true;
        }
    }

    function checkdelete(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Please confirm you want to Delete this Invoice(s)"))
            {
                return true;
            } else
            {
                return false;
            }
        } else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to delete.");
            return false;
        }
    }

</script>
<script type="text/javascript">

    function checkinvoice(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Please confirm you want to take invoice"))
            {
                //	alert("test");

                var checkboxValues = [];
                $('input[name="chk[]"]:checked').each(function () {
                    checkboxValues.push($(this).val());
                });
//alert(checkboxValues);
                //return true;
                //window.location.href="<?php echo $fsitename; ?>"+"MPDF/invoice/invoice.php";

                window.open("<?php echo $fsitename; ?>" + "MPDF/invoice/invoice.php?id=" + checkboxValues, '_blank');

            } else
            {
                return false;
            }
        } else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to take invoice.");
            return false;
        }
    }


    function checkall(objForm) {
        len = objForm.elements.length;
        var i = 0;
        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }

    function show_contacts(id, iid) {
        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            data: {get_contacts_of_customer: id}
        }).done(function (data) {
            $('#choose_contacts_grid_table tbody').html(data);
            $('#choose_contacts_grid_table tbody').append('<input type="hidden" name="invoiced_id" value="' + iid + '" />');

        });
    }
    function check_Cont() {
        var $len = $('input[name="selected_contacts[]"]:checked').length;
        if ($len > 0) {
            return true;
        } else {
            alert("Please select atleast one contact..");
            return false;
        }
    }
</script>
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(1), tbody tr td:nth-child(6), tbody tr td:nth-child(7),tbody tr td:nth-child(8),tbody tr td:nth-child(9),tbody tr td:nth-child(10) {
        text-align:center;
    }
    #normalexamples tbody tr td:nth-child(5) {
        text-align:right;
    }
    .btn-selected{
        /*box-shadow: inset 0 3px #00C0EF;*/
        box-shadow: inset 0 3px #27157B;
    }
    .btn-selected span{
        /*box-shadow: inset 0 3px #00C0EF;*/
        color: #27157B;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Invoice
            <small>List of Invoice(s)</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Master(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Invoice</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>invoice/addnewinvoice.htm">Add New Invoice</a></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <div class="btn-group row" style="display: block;padding: 0 15px;">
                            <button type="button" data-value="draft" class="btn btn-default btn-selected col-sm-4" style="padding: 17px 122px;font-size: 18px;">Draft<br /><span style="font-size: 28px;">$ 0.00</span></button>                            
                            <button type="button" data-value="1" class="btn btn-default col-sm-4" style="padding: 17px 122px;font-size: 18px;">Not Paid<br /><span style="font-size: 28px;">$ 0.00</span></button>
                            <button type="button" data-value="2" class="btn btn-default col-sm-4" style="padding: 17px 122px;font-size: 18px;">Paid<br /><span style="font-size: 28px;">$ 0.00</span></button>
                        </div>
                        <br /><br />
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:15%">Date</th>
                                    <th style="width:15%">Invoice ID</th>
                                    <th style="width:15%">Customer</th>
                                    <th style="width:10%; text-align:center;">Amount</th>
                                    <th style="width:10%;text-align:center;">Status</th>
                                    <th style="width:10%;text-align:center;">Invoice Status</th>
                                    <th data-sortable="false" align="center" style="text-align: left; padding-right:0; padding-left: 10px; width:5%;text-align:center;">Edit</th>
                                    <th style="width:10%;text-align:center;">Action</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 5%;"><input name="check_all[]" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>                                    
                                    <th colspan="10" style="margin:0px auto;text-align:right;">
                                        <!--<button type="button" class="btn btn-danger" name="invoice" id="invoice" value="Invoice" onclick="return checkinvoice('chk[]');"> INVOICE </button>&nbsp;&nbsp;&nbsp;--><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
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
<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>invoice/' + a + '/editnewinvoice.htm';
    }
    function change_status(status, id) {
        window.location.href = '<?php echo $sitename; ?>invoice/invoice.htm?change_status=' + status + '&id=' + id;
    }
    function change_status_invoice1(status, id) {
        window.location.href = '<?php echo $sitename; ?>invoice/invoice.htm?change_status_invoice=' + status + '&id=' + id;
    }
</script>
<?php
include ('../../require/footer.php');
?>  
<script type="text/javascript">
    $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "initComplete": function (settings) {
            var osrc = settings.sAjaxSource;
            var fn = this;

            var select = $('<select/>').addClass('form-control input-sm status_new').html('<option value="all">Show All</option><option value="1">Not Paid</option><option value="2">Paid</option>').change(function () {
                callFN();
            });
            $('.btn-group button').click(function(){
                $('.btn-group button').removeClass('btn-selected');
                $(this).addClass('btn-selected');
                $(this).blur();
                callFN();
            });
           // $('#normalexamples_filter').append(select);
            var input = $('<input/>').addClass('form-control input-sm daterangepicker_new').attr('placeholder', 'Date').css('margin', '0').prop('readonly', true);
            $('#normalexamples_filter').append(input);
            $('.daterangepicker_new').daterangepicker({format: 'DD-MM-YYYY', separator: ' to '});
            $('.daterangepicker_new').on('apply.daterangepicker', function (ev, picker) {
                callFN();
            });
            $('.daterangepicker_new').on('cancel.daterangepicker', function (ev, picker) {
                if ($(this).val() != '') {
                    $(this).val('');
                    callFN();
                }
            });
            function callFN() {
                var dateRange = $('.daterangepicker_new').val() || '';
//                var statusn = $('.status_new').val() || '';
                var statusn = $('.btn-selected').data('value') || '';
                settings.sAjaxSource = osrc + '&status_filter=' + statusn + '&dateRange=' + dateRange;
                fn.fnDraw();
            }
        },
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.htm?types=invoicetable<?= $st ?>&status_filter="+$('.btn-selected').data('value'),
    });    
    $.post('<?=$sitename?>getpassup.php',{ get_summary_invoice : '1' },function(res){
        $('.btn-group button:eq(0) span').html('$ '+res['draft']);
        $('.btn-group button:eq(1) span').html('$ '+res['notpaid']);
        $('.btn-group button:eq(2) span').html('$ '+res['paid']);
    },'json');
</script>