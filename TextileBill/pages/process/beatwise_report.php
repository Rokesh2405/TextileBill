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
if(($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') || $_REQUEST['customer_name']!='' || $_REQUEST['salesman']!='' || $_REQUEST['area']!='') {
$url=$sitename.'pages/process/export.php?type=beatwise&fromdate='.$_REQUEST['fromdate'].'&todate='.$_REQUEST['todate'].'&customer_name='.$_REQUEST['customer_name'].'&salesman='.$_REQUEST['salesman'].'&area='.$_REQUEST['area'];
}
else
{
$url=$sitename.'pages/process/export.php?type=beatwise';
}
echo "<script>window.open('".$url."', '_blank');</script>";
}
if(isset($_REQUEST['save']))
{
@extract($_REQUEST);
global $db;

$chkcredit = FETCH_all("SELECT * FROM `credit_payment` WHERE `id`=?", $purchase_id);
if($chkcredit['balance_amt']>=$current_amt) {  
  $advamt=$chkcredit['advance_amt'] + $current_amt;
  $balance_amt=$chkcredit['purchase_amt'] - $advamt;
$resa = $db->prepare("UPDATE `credit_payment` SET `inputamt`=?,`advance_amt`=?,`balance_amt`=? WHERE `id`=? ");
$resa->execute(array($current_amt,$advamt,$balance_amt,$purchase_id));


//Credit History
$cresa = $db->prepare("INSERT INTO `credit_history` (`billno`,`supplier_id`,`purchase_id`,`purchase_amt`,`advance_amt`,`balance_amt`,`inputamt`) VALUES(?,?,?,?,?,?,?)");
$cresa->execute(array($chkcredit['billno'],$chkcredit['supplier_id'],$chkcredit['purchase_id'],$chkcredit['purchase_amt'],$chkcredit['advance_amt'],$chkcredit['balance_amt'],$current_amt));
//Credit History

$msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Updated Successfully.</h4></div>';
}
else
{
$msg = '<div class="alert alert-error alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Enter the Valid  Value</h4></div>';	
}

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
            Beatwise Report
            <small>List of Report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Report(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Beatwise Report Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Beatwise Report</h3>
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
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="fromdate" id="fromdate" value="<?php echo $_REQUEST['fromdate']; ?>">
                            </div>
					 	</div>
						<div class="col-md-3">
						<label>To Date <span style="color:red;">*</span></label>
						<div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="todate" id="todate" value="<?php echo $_REQUEST['todate']; ?>">
                            </div>
						
						</div>
						
						
	<style>
	.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px;
    font-size: 13px;
    /* font-weight: bold; */
   }
   </style>
						
					 <?php
                      if($_SESSION['usertype']!='salesman') { ?>
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
					<?php } else { ?>
                        <input type="hidden" name="salesman" value="<?php echo $_SESSION['merchant']; ?>">
                    <?php } ?>
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
						</div>

						<br>
						<div class="row">
						<div class="col-md-3">
						<label>Area</label>
						 <select name="area" class="form-control select2"  style="font-size:13px !important;">
							 <option value="">Select</option>
                             <?php
$customer = pFETCH("SELECT * FROM `customer` WHERE `status`=? AND `city`!='' GROUP BY `city`", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['city']; ?>" <?php if($_REQUEST['area']==$customerfetch['city']) { ?> selected <?php } ?>><?php echo $customerfetch['city']; ?></option>
<?php } ?>							
							 </select>
						</div>
						
						
						

						<div class="col-md-3"><br>
						<button type="submit" class="btn btn-info btn-sm" name="search" style="font-size:16px;">Search</button>&nbsp;&nbsp;&nbsp;
						
						</div>
						</div>
						
						
						</form>
						</div></div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <a href="<?php echo $fsitename; ?>MPDF/beatwise_report.php" target="_blank"><button type="button" class="btn btn-info btn-sm" name="export" style="font-size:16px;">Download Today Salesman Wise Report</button></a>
                <br>
                <?php echo $msg; ?>
				<?php
				 global $db;
$s='';
if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(date(A.`date`)>='".date('Y-m-d',strtotime($_REQUEST['fromdate']))."'  AND date(A.`date`)<='".date('Y-m-d',strtotime($_REQUEST['todate']))."')";
}

if($_REQUEST['salesman']!='')
{
$s1[]="`salesman`='".$_REQUEST['salesman']."'";
}

if($_SESSION['usertype']=='salesman') {
$s1[]="B.`salesman`='".$_SESSION['merchant']."'";
}

if($_REQUEST['customer_name']!='') {
$cusarray[]=	$_REQUEST['customer_name'];
}
if($_REQUEST['area']!='') {
$sel=pFETCH("SELECT * FROM `customer` WHERE `status`=? AND `city` LIKE '%".$_REQUEST['area']."%' ", 1);
while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
$cusarray[]=	$fdepart['id'];
}

}

if(count($cusarray)>0) {
	$cusexp=implode(',',$cusarray);
$s1[]='A.`supplier_id` IN ('.$cusexp.')';	
}
$m=1;
if(count($s1)>0) {
$s=implode('  AND  ',$s1);
}

				?>
				<br>
				<br>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:3%;">Sno</th>
                                    <th style="width:8%">Invoice Date</th>
                                    <th style="width:8%">Invoice</th>
                                    <th style="width:8%">Salesman</th>
                                    <th style="width:8%">Area</th>
                                    <th style="width:8%">Customer</th>
                                    <th style="width:8%">Bill Amount</th>
                                    <th style="width:8%">Collection</th>
                                   <th style="width:8%">Bal Amount</th>
								   <th style="width:20%">Coll Amount</th>
								  </tr>
                            </thead>
<?php  
if($s!='') { 
//echo "SELECT * FROM `online_order` WHERE `id`!='0' AND $s ORDER BY `cudate` DESC";

 $message1 = $db->prepare("SELECT B.`salesman`,A.`balance_amt`,A.`advance_amt`,A.`purchase_amt`,A.`purchase_id`,A.`supplier_id`,A.`purchase_amt`,A.`advance_amt`,A.`balance_amt`,A.`id` FROM `credit_payment` A, `sales_order` B WHERE A.`type`='sales' AND A.`purchase_id`= B.`id` AND $s ORDER BY A.`date` DESC");
}
else{
 
$message1 = $db->prepare("SELECT B.`salesman`,A.`balance_amt`,A.`advance_amt`,A.`purchase_amt`,A.`purchase_id`,A.`supplier_id`,A.`purchase_amt`,A.`advance_amt`,A.`balance_amt`,A.`id` FROM `credit_payment` A, `sales_order` B WHERE A.`type`='sales' AND A.`purchase_id`= B.`id` ORDER BY A.`date` DESC");	
}

$message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
$cusarea=getcustomer('area',$message['supplier_id']);

$cuday=date('N')-1;

$checkday = FETCH_all("SELECT A.`id`,A.`day`,A.`area` FROM `daywise_beat` AS A,`beatsalesman` B WHERE A.`beatsalesman_id`=B.`id` AND A.`day`=?", $cuday);
$areaname=explode('-',$checkday['area']);

if($areaname['1']==$cusarea)
{
  ?>

<tr>

<td><?php echo $m; ?></td>

   <td><?php echo date('d-m-Y h:i:a',strtotime(getsalesorder('date',$message['purchase_id']))); ?></td>
    <td><?php echo getsalesorder('bill_number',$message['purchase_id']); ?></td>

<td><?php echo getsalesman('name',$message['salesman']); ?></td>
 <td><?php echo getcustomer('city',$message['supplier_id']); ?></td>
 <td><?php echo getcustomer('name',$message['supplier_id']); ?></td>
  <td>Rs. <?php echo number_format($message['purchase_amt'],2); ?></td>
   <td>Rs. <?php echo number_format($message['advance_amt'],2); ?></td>
     <td>Rs. <?php echo number_format($message['balance_amt'],2); ?></td>
 <td><?php if($message['purchase_amt']==$message['advance_amt'] || $message['purchase_amt']<$message['advance_amt']) { ?>
<span style="color:green; font-weight:bold;">Closed</span>
<?php } else { ?>
<form name="aform" method="post">
<input type="hidden" name="purchase_id" value="<?php echo $message['id']; ?>">

<input type="text" class="form-control" name="current_amt" required="required">
<br><br>
<input type="submit" name="save" value="Save" class="btn btn-info btn-sm">
</form>
<?php } ?></td>


</tr>
<?php
$m++;
}
} 
?> <tfoot>
                            </tfoot>
                        </table>
                      
                    </div>
                </form>
          
<!-- <div class="row" style="position: absolute;left:1px;top: 55%;">
				<div class="col-md-12"><h2>Total Sales Amount: <span style="color:blue;">Rs .<?php echo number_format($totsalemat,2); ?></span></h2></div>
				</div> -->
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