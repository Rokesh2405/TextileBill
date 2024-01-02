<?php
$menu = "19,20,23";
$thispageid = 21;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
if(isset($_REQUEST['sendmails'])){
    
PayslipMail($_REQUEST['id']);
   
header("location:" . $sitename . "invoice/payslip.htm?change_status_suc1");
    exit;
}
if ($_REQUEST['change_status'] != '' && $_REQUEST['id'] != '') {
    $up = $db->prepare("UPDATE `payslip` SET `status`='" . $_REQUEST['change_status'] . "' WHERE `id`='" . $_REQUEST['id'] . "'");
    $up->execute();
    header("location:" . $sitename . "invoice/payslip.htm?change_status_suc");
    exit;
}
if ($_REQUEST['change_status_invoice'] != '' && $_REQUEST['id'] != '') {  
    $ups = $db->prepare("UPDATE `payslip` SET `draft`=? WHERE `id`=?");
    $ups->execute(array('0', $_REQUEST['id']));
    header("location:" . $sitename . "invoice/invoice.htm?change_status_suc");
    exit;
}

if (isset($_REQUEST['change_status_suc'])) {
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
}
if (isset($_REQUEST['change_status_suc1'])) {
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Sent</h4></div>';
}
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    foreach ($chk as $chkk){
        $dl = $db->prepare("DELETE FROM `payslip_details` WHERE `payslip_id`=?");
        $dl->execute(array($chkk));
        $dl = $db->prepare("DELETE FROM `payslip` WHERE `id`=?");
        $dl->execute(array($chkk));
    }
    $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Deleted</h4></div>';
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
            if (confirm("Please confirm you want to Delete this Payslip(s)"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to delete.");
            return false;
        }
    }

</script>
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
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(2),tbody tr td:nth-child(5),tbody tr td:nth-child(6),tbody tr td:nth-child(7) {
        text-align:center;
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
            Pay Slip
            <small>List of Pay Slip(s)</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-bar-chart"></i>Invoice</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Pay Slip</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div id="mmssg"><?php echo $msg; ?></div>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <div class="btn-group row" style="display: block;padding: 0 15px;">
                            <button type="button" data-value="draft" class="btn btn-default btn-selected col-sm-4" style="padding: 17px 122px;font-size: 18px;">Draft<br /><span style="font-size: 28px;">$ 0.00</span></button>                            
                            <button type="button" data-value="1" class="btn btn-default col-sm-4" style="padding: 17px 122px;font-size: 18px;">Not Paid<br /><span style="font-size: 28px;">$ 0.00</span></button>
                            <button type="button" data-value="2" class="btn btn-default col-sm-4" style="padding: 17px 122px;font-size: 18px;">Paid<br /><span style="font-size: 28px;">$ 0.00</span></button>
                        </div>
                        <br /><br />
                        <table id="normalexamples" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.No</th>
                                    <th style="width:10%">Date</th>
                                    <th style="width:50%">Employee</th>
                                    <th style="width:10%">Status</th>
                                    <th style="width:10%">Draft</th>
                                    <th style="width:10%; text-align:center;">Action</th>
                                    <th style="width:5%; text-align:center;">View</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 5%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead> 
                            <tfoot>
                                <tr>                                    
                                    <th colspan="8" style="text-align: right;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>invoice/' + a + '/viewpayslip.htm';
    }
    function sendMails(id){
        window.location.href = '<?php echo $sitename; ?>invoice/payslip.htm?sendmails=1&id='+id;
    }
    function changestatus(a, b)
    {
        var e = $('input[name="sendmail"]:checked').val();
        var status = a;
        var oid = b;
        if (confirm("Please confirm you want to change the Order Status)"))
        {
            changestatusmessage(status, oid, e);
            location.reload();
            return true;
        } else
        {
            location.reload();
            return false;
        }
    }

    function changestatusmessage(a, b, c)
    {
        var a = a;
        var b = b;
        var c = c;
        if (window.XMLHttpRequest)
        {
            oRequestsubcat = new XMLHttpRequest();
        } else if (window.ActiveXObject)
        {
            oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if ((a != '') && (b != ''))
        {
            document.getElementById("mmssg").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
            oRequestsubcat.open("POST", "<?php echo $fsitename; ?>get/results.htm", true);
            oRequestsubcat.onreadystatechange = getcstatus;
            oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oRequestsubcat.send("orderstatus=" + a + "&orderid=" + b +"&sendmail="+c);
            console.log(a, b);
        }
        return false;
    }

    function getcstatus()
    {
        if (oRequestsubcat.readyState == 4)
        {
            if (oRequestsubcat.status == 200)
            {
                document.getElementById("mmssg").innerHTML = oRequestsubcat.responseText;
            } else
            {
                document.getElementById("mmssg").innerHTML = oRequestsubcat.responseText;
            }
        }
    }
</script>
<?php
include ('../../require/footer.php');
?>  
<script type="text/javascript">
    function change_status(status, id) {
        window.location.href = '<?php echo $sitename; ?>invoice/payslip.htm?change_status=' + status + '&id=' + id;
    }
    function change_status_invoice1(status, id) {
        window.location.href = '<?php echo $sitename; ?>invoice/payslip.htm?change_status_invoice=' + status + '&id=' + id;
    }
      $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
	"ordering":false,
        "initComplete": function (settings) {
            var osrc = settings.sAjaxSource;
            var fn = this;
                      
            $('.btn-group button').click(function(){
                $('.btn-group button').removeClass('btn-selected');
                $(this).addClass('btn-selected');
                $(this).blur();
                callFN();
            });
           
            function callFN() {               
                var statusn = $('.btn-selected').data('value') || '';
                settings.sAjaxSource = osrc + '&status_filter=' + statusn;
                fn.fnDraw();
            }
        },
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=paysliptable&status_filter="+$('.btn-selected').data('value')
    });
    
    $.post('<?=$sitename?>getpassup.php',{ get_summary_payslip : '1' },function(res){
        $('.btn-group button:eq(0) span').html('$ '+res['draft']);
        $('.btn-group button:eq(1) span').html('$ '+res['notpaid']);
        $('.btn-group button:eq(2) span').html('$ '+res['paid']);
    },'json');
</script>