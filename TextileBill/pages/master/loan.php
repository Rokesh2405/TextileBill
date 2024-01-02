<?php
$menu = "8,8,18";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable='1';
include ('../../require/header.php');

$_SESSION['driver'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delloan($chk);
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
            if (confirm("Do you want to delete the loan(s)"))
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
    #normalexamples tbody tr td:nth-child(1), tbody tr td:nth-child(2),tbody tr td:nth-child(3),tbody tr td:nth-child(4),tbody tr td:nth-child(5),tbody tr td:nth-child(6),tbody tr td:nth-child(7) {
        text-align:center;
        font-size: 19px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Loan
            <small>List of Loan(s)</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Master(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Loan Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>master/addloan.htm">Add New Loan</a></h3>
                 <form method="post" name="export-form" action="<?=$sitename?>csv/export.php" style="display: inline;"><button name="export_csv" class="btn btn-info btn-social" style="float:right;"><i style="font-size:12px;" class="fa fa-upload"></i> Export</button></form>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:20%">Date of Pawn</th>
                                    <th style="width:10%">Customer ID</th>
                                    <th style="width:10%">Receipt No</th>
                                    <th style="width:10%">Amount</th>
                                    <th style="width:15%">Mobile No</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">View</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                                    <!--<th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>-->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="6">&nbsp;</th>
                                    <!--<th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>-->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                   <?php 
                    $res1 = $db->prepare("SELECT * FROM `loan`");
                            $res1->execute();
                            $sum_amount = 0;
                            while($row1 = $res1->fetch(PDO::FETCH_ASSOC)) {
                            $sum_amount += $row1['amount'];
                            }
                    //echo 'Total Loan Amount:<input type="text" value='.$sum_amount.'>';
                    ?>
                    <h3><b>TOTAL LOAN AMOUNT:<input type="text" style="width: 120px;" value="<?php echo $sum_amount;?>" name=""></b></h3>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>master/' + a + '/editloan.htm';
    }
    function viewthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>master/' + a + '/viewloan.htm';
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
	"ordering":false,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=loantable"
    });
</script>