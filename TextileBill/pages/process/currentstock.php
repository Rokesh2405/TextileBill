<?php
$menu = "4,7,7,46";
$thispageid = 46;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
$_SESSION['ostock_id'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delopeningstock($chk);
}
?>
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(4) {
       text-align:right;
    }
     #normalexamples tbody tr td:nth-child(1) {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Current Stock
            <small>List of Current Stock</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-product-hunt"></i>Process</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Stock</a></li>
            <li class="active">Current Stock</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
<!--                <h3 class="box-title"><a href="<?php echo $sitename; ?>process/addopening_stock.htm">Add New Opening Stock</a></h3>-->
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:50%;">Item</th>
                                    <th style="width:15%">Batch Number</th>
                                    <th style="width:30%">Qty/Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">&nbsp;</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include ('../../require/footer.php');
?>

<script type="text/javascript">
    $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.htm?types=current_stock",

    });
</script>
