<?php
$menu = "3,3,28";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
if(isset($_REQUEST['export']))
{
@extract($_REQUEST);
$url=$sitename.'pages/process/export.php?type=sales&fromdate='.$_REQUEST['fromdate'].'&todate='.$_REQUEST['todate'].'&order_method='.$_REQUEST['order_method'].'&order_type='.$_REQUEST['order_type'].'&customer_name='.$_REQUEST['customer_name'].'&area='.$_REQUEST['area'].'&city='.$_REQUEST['city'];
echo "<script>window.open('".$url."', '_blank');</script>";
}
?>
<style type="text/css">
    .row { margin:0;}
  
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sales Report
            <small>List of Report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Report(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Sales Report Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Sales Report</h3>
            </div><!-- /.box-header -->
            <div class="box-header">
                <div class="panel panel-info">

                        <div class="panel-heading">

                            <div class="panel-title">
Search
                            </div>

                        </div>

                        <div class="panel-body">
						<form name="sform" method="post" autocomplete="off">
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
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="todate" id="todate" required="required" value="<?php echo $_REQUEST['todate']; ?>">
                            </div>
						
						</div>
						<div class="col-md-3">
						<label>Order Method </label>
						<select name="order_method" class="form-control">
						<option value="">Select</option>
						                         <?php
$ordermethod = pFETCH("SELECT * FROM `ordertype` WHERE `status`=?", '1');
while ($ordermethodfetch = $ordermethod->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $ordermethodfetch['id']; ?>" <?php if($link22['order_method']==$ordermethodfetch['id']) { ?> selected="selected" <?php } ?>><?php echo $ordermethodfetch['ordertype']; ?></option>
<?php } ?>                          

						</select>
						</div>
						
						<style>
						.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px;
    font-size: 13px;
    /* font-weight: bold; */
}
						</style>
						<div class="col-md-3">
						
						<label>Product Name</label>
						 <select name="product" class="form-control select2"  style="font-size:13px !important;">
							 <option value="">Select</option>
                             <?php
$customer = pFETCH("SELECT * FROM `object` WHERE `status`=?", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['objectname']; ?>" <?php if($customerfetch['objectname']==$_REQUEST['product']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['objectname']; ?></option>
<?php } ?>							
							 </select>
						</div>
					 
						</div>
						<br>
						<div class="row">
						
					 
						<div class="col-md-3">
						
						<label>Customer Name</label>
						 <select name="customer_name" class="form-control select2"  style="font-size:13px !important;">
							 <option value="">Select</option>
                             <?php
$customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['id']; ?>" <?php if($_REQUEST['customer_name']==$customerfetch['id']) { ?> selected <?php } ?>><?php echo $customerfetch['name']; ?></option>
<?php } ?>							
							 </select>
						</div>
					 
					 
						
						<div class="col-md-3">
						<label>Area</label>
						<input type="text" class="form-control" name="area" value="<?php echo $_REQUEST['area']; ?>">
						</div>
						
						<div class="col-md-3">
						<label>City</label>
						<input type="text" class="form-control" name="city" value="<?php echo $_REQUEST['city']; ?>">
						</div>
						<?php if($_SESSION['usertype']!='salesman') { ?>
						 <div class="col-md-3">
						<label>Salesman</label>
						<select name="salesman" class="form-control">
						  <option value="">Select</option>
                             <?php
$salesman = pFETCH("SELECT * FROM `salesman` WHERE `status`=?", '1');
while ($salesmanfetch = $salesman->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $salesmanfetch['id']; ?>" <?php if($_REQUEST['salesman']==$salesmanfetch['id']) { ?> selected="selected" <?php } ?>><?php echo $salesmanfetch['name']; ?></option>
<?php } ?>                          
                             </select>
						</div>
					<?php } ?>
						</div>
						<br>
						<div class="row">
                       
						<div class="col-md-3">
							<label>Discount</label>
							<br>
							<input type="checkbox" name="discount" value="1" <?php if($_REQUEST['discount']=='1') { ?> checked="checked" <?php } ?>>
						</div>
						</div>
						<div class="row">
						
						<div class="col-md-3"><br>
						<button type="submit" class="btn btn-info btn-sm" name="search" style="font-size:16px;">Search</button>&nbsp;&nbsp;&nbsp;
						<button type="submit" class="btn btn-info btn-sm" name="export" style="font-size:16px;">Export Excel</button>
						</div>
						</div>
						</form>
						</div></div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <?php echo $msg; ?>
				<?php
				 global $db;
$s='';
if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(date(`cudate`)>='".date('Y-m-d',strtotime($_REQUEST['fromdate']))."'  AND date(`cudate`)<='".date('Y-m-d',strtotime($_REQUEST['todate']))."')";
}
if($_REQUEST['order_method']!='' && $_REQUEST['order_method']!='All')
{
$s1[]="`order_method`='".$_REQUEST['order_method']."'";
}
if($_REQUEST['order_type']!='')
{
$s1[]="`order_type`='".$_REQUEST['order_type']."'";
}
if($_REQUEST['salesman']!='')
{
$s1[]="`salesman`='".$_REQUEST['salesman']."'";
}

if($_SESSION['usertype']=='salesman') {
$s1[]="`salesman`='".$_SESSION['merchant']."'";
}

if($_REQUEST['discount']=='1')
{
$s1[]="`discount`!=''";
}
if($_REQUEST['customer_name']!='') {
$cusarray[]=	$_REQUEST['customer_name'];
}
if($_REQUEST['area']!='') {
$sel=pFETCH("SELECT * FROM `customer` WHERE `status`=? AND `object` LIKE '%".$_REQUEST['area']."%' ", 1);
while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
$cusarray[]=	$fdepart['id'];
}

}
if($_REQUEST['city']!='') {
$sel=pFETCH("SELECT * FROM `customer` WHERE `status`=? AND `idproof` LIKE '%".$_REQUEST['city']."%' ", 1);
while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
$cusarray[]=	$fdepart['id'];
}

}
if(is_countable($cusarray) && count($cusarray)>0) {
	$cusexp=implode(',',$cusarray);
$s1[]='`customer_id` IN ('.$cusexp.')';	
}
$m=1;
if(is_countable($s1) && count($s1)>0) {
$s=implode('  AND  ',$s1);
}
if($s!='') { 
$tomes = $db->prepare("SELECT SUM(`total_amnt`) AS `totamt` FROM `online_order` WHERE `id`!='0' AND $s ORDER BY `cudate` DESC");
}
else{
$tomes = $db->prepare("SELECT SUM(`total_amnt`) AS `totamt` FROM `online_order` WHERE `id`!='0' ORDER BY `cudate` DESC");	
}

 $tomes->execute();
 $tomesfetch = $tomes->fetch(PDO::FETCH_ASSOC);

				?>
				<br>
				<br>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:3%;">Sno</th>
                                    <th style="width:8%">Date</th>
                                    <th style="width:8%">Salesman</th>
                                    <th style="width:10%">Order Type</th>
									 <th style="width:10%">Products</th>
                                    <th style="width:8%">Cus Name</th>
                                    <th style="width:8%">Area</th>
                                    <th style="width:8%">Discount</th>
                                   <th style="width:8%">Amount</th>
								   <th style="width:14%">Payment Method</th>
								   <th style="width:5%">View</th>
                                </tr>
                            </thead>
<?php  
if($s!='') { 
//echo "SELECT * FROM `online_order` WHERE `id`!='0' AND $s ORDER BY `cudate` DESC";

 $message1 = $db->prepare("SELECT * FROM `sales_order` WHERE `id`!='0' AND $s ORDER BY `cudate` DESC");
}
else{
$message1 = $db->prepare("SELECT * FROM `sales_order` WHERE `id`!='0' ORDER BY `cudate` DESC");	
}

 $message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
	
	
if(!empty($_REQUEST['product'])) { 	

  $get1 = FETCH_all("SELECT * FROM `object` WHERE `objectname`=?", $_REQUEST['product']);
  $labl=$_REQUEST['product'].' - '.$get1['productcode'];
 
 
  
$items = $db->prepare("SELECT * FROM `sales_order_deatils` WHERE `object_id`='".$message['id']."' AND `product_name`='".$labl."' ");	
}
else
{
$items = $db->prepare("SELECT * FROM `online_order_deatils` WHERE `object_id`='".$message['id']."'");		
}

$items->execute();
$checknum1 = $items->rowCount();	
if($checknum1>0) {		
$totsalemat+=$message['total_amnt'];										
  ?>
                                    
                                         <tr>

                                                    <td><?php echo $m; ?></td>
                                                   
													   <td><?php echo date('d-m-Y h:i:s',strtotime($message['cudate'])); ?></td>
													    <td><?php echo getsalesman('name',$message['salesman']); ?></td>
                                                    <td><?php 
                                                    echo getordertype('ordertype',$message['order_method']);
													?></td>
													<td>
													<?php 
													$itemarray=array();
													
													while($itemslist = $items->fetch(PDO::FETCH_ASSOC)) {
														$itemarray[]=$itemslist['product_name'];
													 } 
													 $itemdetails=implode(' , ',$itemarray);
													 echo $itemdetails;
													 ?>
													</td>
                                                     <td><?php echo getcustomer('name',$message['customer_id']); ?></td>
                                                     
													 
                                                       <td><?php echo getcustomer('object',$message['customer_id']); ?></td>
                                                       <td>Rs. <?php echo number_format($message['discount'],2); ?></td>
													   <td>Rs. <?php echo number_format($message['total_amnt'],2); ?></td>
													   													   <td><?php echo $message['payment_mode']; ?></td>
                                                     <td><a href="<?php echo $sitename; ?>process/<?php echo $message['id']; ?>/editsales.htm?type=view" target="_blank">View</a></td>


                                                </tr>
                                                <?php
												$m++;
} }
                                            ?>

                                               
                           
                            

                            
                            <tfoot>
                            </tfoot>
                        </table>
                      
                    </div>
                </form>
          
<div class="row" style="position: absolute;left:1px;top: 55%;">
				<div class="col-md-12"><h2>Total Sales Amount: <span style="color:blue;">Rs .<?php echo number_format($totsalemat,2); ?></span></h2></div>
				</div>
				<br>
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