<?php
$menu = "3,3,26";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
if(isset($_REQUEST['export']))
{
@extract($_REQUEST);
$url=$sitename.'pages/process/export.php?type=purchase&fromdate='.$_REQUEST['fromdate'].'&todate='.$_REQUEST['todate'].'&supplier='.$_REQUEST['supplier'].'&billno='.$_REQUEST['billno'];
echo "<script>window.open('".$url."', '_blank');</script>";
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
            Purchase Report
            <small>List of Purchase</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Report(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Purchase Report Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Purchase</h3>
            </div><!-- /.box-header -->
            <div class="box-header">
                <div class="panel panel-info">

                        <div class="panel-heading">

                            <div class="panel-title">
Search
                            </div>

                        </div>

                        <div class="panel-body">
						<form name="sform" method="post"autocomplete="off">
						<div class="row">
						<div class="col-md-3">
						<label>Form Date <span style="color:red;">*</span></label>
						 <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="fromdate" id="fromdate" required="required" value="<?php echo $_REQUEST['fromdate']; ?>">
                            </div>
						</div>
						<div class="col-md-3">
						<label>To Date <span style="color:red;">*</span></label>
						 <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="todate" id="fromdate" required="required" value="<?php echo $_REQUEST['todate']; ?>">
                            </div>
						</div>
						<div class="col-md-3">
						<style>
						.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px;
    font-size: 13px;
    /* font-weight: bold; */
}
						</style>
						<label>Supplier Name </label>
						 <select name="supplier" class="form-control select2"  style="font-size:13px !important;">
							 <option value="">Select</option>
                             <?php
$supplier = pFETCH("SELECT * FROM `supplier` WHERE `status`=?", '1');
while ($supplierfetch = $supplier->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $supplierfetch['id']; ?>" <?php if($_REQUEST['supplier']==$supplierfetch['id']){  ?> selected="selected" <?php } ?>><?php echo $supplierfetch['suppliername']; ?></option>
<?php } ?>							
							 </select>
						</div>
		 <div class="col-md-3">
						<label>Billno</label>
						
						
                                <input type="text" class="form-control" name="billno" id="billno" value="<?php echo $_REQUEST['billno']; ?>">
                          
						  
						</div>
						</div>
						<br>
						<div class="row">
						<div class="col-md-9">&nbsp;</div>
<div class="col-md-3">
						<button type="submit" class="btn btn-info btn-sm" name="search" style="font-size:16px;">Search</button>&nbsp;&nbsp;&nbsp;
						<button type="submit" class="btn btn-info btn-sm" name="export" style="font-size:16px;">Export Excel</button>
						</div>
		 </div>
						<br>
					 	</form>
						</div></div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                           <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:3%;">Sno</th>
                                    <th style="width:8%">Date</th>
                                    <th style="width:10%">Bill Number</th>
                                    <th style="width:8%">Supplier</th>
                                    <th style="width:12%">Amount</th>
								   <th style="width:5%">View</th>
                                </tr>
                            </thead>
<?php  
    global $db;
$s='';
if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(`date`>='".date('Y-m-d',strtotime($_REQUEST['fromdate']))."'  AND `date`<='".date('Y-m-d',strtotime($_REQUEST['todate']))."')";
}
if($_REQUEST['supplier']!='')
{
$s1[]="`supplierid`='".$_REQUEST['supplier']."'";
}
if($_REQUEST['billno']!='')
{
$s1[]="`bill_number`='".$_REQUEST['billno']."'";
}

$m=1;
if(is_countable($s1) && count($s1)>0) {
$s=implode('  AND  ',$s1);
}
if($s!='') { 
$message1 = $db->prepare("SELECT * FROM `purchase` WHERE `id`!='0' AND $s ORDER BY `id` DESC");
}
else{
$message1 = $db->prepare("SELECT * FROM `purchase` WHERE `id`!='0' ORDER BY `id` DESC");	
}


 $message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
  ?>
                                    
                                         <tr>

                                                    <td><?php echo $m; ?></td>
													   <td><?php echo $message['date']; ?></td>
                                                    <td><?php echo $message['bill_number']; ?>
													</td>
                                                     <td><?php echo getsupplier('suppliername',$message['supplierid']); ?></td>
                                                      <td>Rs. <?php echo 
													  number_format($message['tot_amt'],2); ?></td>
                                                       
                                                     <td><a href="<?php echo $sitename; ?>process/<?php echo $message['id']; ?>/editpurchase.htm?type=view" target="_blank">View</a></td>


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
   /*   $('#normalexamples').dataTable({
        "bProcessing": false,
        "bServerSide": false,
        //"scrollX": true,
        "searching": true,
	"ordering":false,
         });*/
</script>