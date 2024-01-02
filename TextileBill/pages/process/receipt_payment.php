<?php
$menu = "11,11,2";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
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
            Receipt Payment Details
            <small>List of Receipt Payments</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Inventory(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>List of Credit Payments</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Receipt Payments</h3>
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
                                    <th style="width:5%">Date</th>
                                    <th style="width:12%">Ref. Bill Number</th>
                                    <th style="width:10%">Purchase Amt</th>
									 <th style="width:10%">Advance Amt</th>
									<th style="width:8%">Balance Amt</th> 
									<th style="width:18%">Current Amt</th> 
                                </tr>
                            </thead>
<?php  
    global $db;

$message1 = $db->prepare("SELECT * FROM `credit_payment` WHERE `id`!='0' AND `type`='sales' ");	
$m=1;
$message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {


?> 
<tr>
<td><?php echo $m; ?></td>
<td><?php echo date('d-m-Y',strtotime($message['date'])); ?></td>
<td><?php echo $message['billno']; ?></td>
<td><?php echo $message['purchase_amt']; ?></td>
<td><?php echo $message['advance_amt']; ?></td>
<td><?php if($message['balance_amt']!='') {  echo $message['balance_amt']; } else { echo $message['purchase_amt']; } ?></td>
<td>
<?php if($message['purchase_amt']==$message['advance_amt'] || $message['purchase_amt']<$message['advance_amt']) { ?>
<span style="color:green; font-weight:bold;">Closed</span>
<?php } else { ?>
<form name="aform" method="post">
<input type="hidden" name="purchase_id" value="<?php echo $message['id']; ?>">

<input type="text" class="form-control" name="current_amt" required="required">&nbsp;&nbsp;
<input type="submit" name="save" value="Save" class="btn btn-info btn-sm">
</form>
<?php } ?>
</td>
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