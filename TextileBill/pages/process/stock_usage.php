<?php
$menu = "5,5,218";
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
            Stock Usage
            <small>List of Usage</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Inventory(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>List of Usage Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Usage</h3>
            </div><!-- /.box-header -->
            <div class="box-header">
			<?php echo $msg; ?>
                <div class="panel panel-info">

                        <div class="panel-heading">

                            <div class="panel-title">
Add Usage Details
                            </div>

                        </div>

                        <div class="panel-body">
						
						<form name="sform" method="post"autocomplete="off">
						<div class="row">
						<div class="col-md-3">
					 <label>Date <span style="color:red;">*</span></label>
						 <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="adddate" id="fromdate" required="required">
                            </div>
					 	</div>
						<div class="col-md-3">
						<label>Product <span style="color:red;">*</span></label>
						<select name="product" required="required" class="form-control">
							<option value="">Select</option>
							<?php
						 $sel = pFETCH("SELECT * FROM `stock_product` WHERE `status`=?", 1);

					while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
					
                       ?>
					   <option value="<?php echo $fdepart['id']; ?>"><?php echo $fdepart['objectname']; ?></option>
					<?php } ?>
							</select>
						</div>
		 <div class="col-md-3">
						<label>Quantity <span style="color:red;">*</span></label>
						<input type="text" name="qty" class="form-control" required="required">
						</div>
<div class="col-md-3"><br>
						<button type="submit" class="btn btn-info btn-sm" name="submit" style="font-size:16px;">Submit</button>&nbsp;&nbsp;&nbsp;
						
						</div>
		 </div>
						<br>
					 	</form>
						</div></div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:3%;">Sno</th>
                                    <th style="width:8%">Date</th>
                                    <th style="width:10%">Product</th>
                                    <th style="width:8%">Quantity</th>
                                </tr>
                            </thead>
<?php  
    global $db;

$message1 = $db->prepare("SELECT * FROM `stock_usage` WHERE `id`!='0'");	

$m=1;
 $message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
  ?>
                                    
                                         <tr>

                                                    <td><?php echo $m; ?></td>
													   <td><?php echo date('d-m-Y',strtotime($message['date'])); ?></td>
                                                    <td><?php 
                                                   
												   echo getobject1('objectname',$message['product']); 
													?></td>
                                                     <td><?php echo $message['quantity']; ?></td>
                                                    
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