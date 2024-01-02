<?php
$menu = "3,5,,45";
$thispageid = 40;
$ze = 40;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');

$_SESSION['additemid'] = $_REQUEST['Iid'];
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    foreach($_REQUEST['chk'] as $ck){
        transaction_del($ck,'Expense');
    }    
     $msgs = del_acc_payment($chk);
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
            if (confirm("Please confirm you want to Delete this?"))
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
</style>
<style type="text/css">
    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(5),tbody tr td:nth-child(6),tbody tr td:nth-child(7) {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Expense Entry
           <!-- <small>Manage all Item </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa fa-money"></i> Accounts</li>
            <li class="active">Expense Entry </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>accounts/addexpense_entry.htm">Add Expense Entry</a></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
<?php echo $msgs; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped"  style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="5%">S.id</th>  
                                    <th width="10%">Date</th>  
                                    <th width="10%">Bill No</th>  
                                    <th width="20%">Ledger</th> 
                                    <th width="10%">Amount</th>
                                    <th data-sortable="false" align="center" width="5%" style="text-align: center; padding-right:0; padding-left: 0;">Edit</th>
                                    <th data-sortable="false" align="center" width="5%" style="text-align: center; padding-right:0; padding-left: 0;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    
                                    <th colspan="7" style="margin:0px auto;text-align: right"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
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
        window.location.href = '<?php echo $sitename; ?>accounts/' + a + '/editexpense_entry.htm';
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
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.htm?types=expense_entry"
    });
</script>
