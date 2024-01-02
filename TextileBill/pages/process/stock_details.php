<?php
$menu = "5,5,219";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
if(isset($_REQUEST['export']))
{
@extract($_REQUEST);
$url=$sitename.'pages/process/export.php?type=expense&fromdate='.$_REQUEST['fromdate'].'&todate='.$_REQUEST['todate'].'&expense_type='.$_REQUEST['expense_type'];
echo "<script>window.open('".$url."', '_blank');</script>";
}
if(isset($_REQUEST['submit']))
{
@extract($_REQUEST);
global $db;
$resa = $db->prepare("INSERT INTO `stock_usage` (`product`,`date`,`quantity`) VALUES(?,?,?)");
$resa->execute(array($product,date('Y-m-d',strtotime($adddate)),$qty));
  $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
}

?>
<style>
						.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px;
    font-size: 13px;
    /* font-weight: bold; */
}
						</style>
						
<style type="text/css">
    .row { margin:0;}


</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Stock Details
            <small>List of Stocks</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Inventory(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>List of Stock Details</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Stocks</h3>
            </div><!-- /.box-header -->
            <div class="box-header">
			<?php echo $msg; ?>
             </div><!-- /.box-header -->

            <div class="box-body">
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:3%;">Sno</th>
                                    <th style="width:8%">Product</th>
                                      <th style="width:10%">Purchase Stock</th>
                                        <th style="width:10%">Sales Stock</th>
                                         <th style="width:10%">Current Stock</th>
                                    <th style="width:10%">Return Stock</th>
                                    <th style="width:8%">Total Available Stock</th>
                                </tr>
                            </thead>
<?php  
    global $db;

$message1 = $db->prepare("SELECT * FROM `object` WHERE `id`!='0'");	
$m=1;
$message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
    
$Tostkqry = FETCH_all("SELECT sum(`pquantity`) AS `totqty` FROM `purchase_object_detail` WHERE `hsn`=?", $message['hsn']);
$usedqtyqry = FETCH_all("SELECT sum(`qty`) AS `totqty` FROM `online_order_deatils` WHERE `hsn`=?", $message['hsn']);
$remqty=$Tostkqry['totqty'] - $usedqtyqry['totqty'];
$returnqtyqry = FETCH_all("SELECT sum(`qty`) AS `totqty` FROM `sales_return_details` WHERE `hsn`=?", $message['hsn']);
$totstk=$remqty+$returnqtyqry['totqty'];
?> 
<tr>
<td><?php echo $m; ?></td>
<td><?php echo getobject('objectname',$message['id']); ?></td>
<td><?php echo $Tostkqry['totqty']; ?></td>
<td><?php echo $usedqtyqry['totqty']; ?></td>
<td><?php echo $remqty; ?></td>
<td><?php echo $returnqtyqry['totqty']; ?></td>
<td><?php echo $totstk; ?></td>
</tr>
<?php
$m++;
}
?>

                                               
                           
                            

                            
                            <tfoot>
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
<script>
function getordertype(a) {
	     $.post("<?php echo $sitename; ?>config/functions_ajax.php", {ordermethod: a},
                function (data) {
					//alert(data);
                    $('#order_type').html(data);
                });
    }
	
</script>
<script type="text/javascript">
     $('#normalexamples').dataTable({
        "bProcessing": false,
        "bServerSide": false,
        //"scrollX": true,
        "searching": true,
	"ordering":false,
         });
		 
</script>