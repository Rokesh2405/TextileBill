<?php
$menu = "3,3,44";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable='1';
include ('../../require/header.php');

$_SESSION['driver'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delonlineorder($chk);
}
if (isset($_REQUEST['submit']) || isset($_REQUEST['submit_x'])) {
global $db;
$getid= $_REQUEST['getid'];
$getsalesorder = FETCH_all("SELECT * FROM `online_order` WHERE `id`=?", $getid);
@extract($getsalesorder);
$resa = $db->prepare("INSERT INTO `sales_order` (`billtypemast`,`bill_advanceamt`,`bill_balanceamt`,`gsttype`,`gstvalue`,`createdby`,`created_id`,`billtype`,`order_method`,`payment_mode`,`customer_id`,`order_type`,`date`,`bill_number`,`given_amnt`,`balance_amnt`,`sub_tot`,`discount`,`packing_charges`,`delivery_charges`,`total_amnt`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$resa->execute(array($billtypemast,$bill_advanceamt,$bill_balanceamt,$gsttype,$gstvalue,$createdby,$created_id,$billtype,$order_method,$payment_mode,$customer_id,$order_type,$date,$bill_number,$given_amnt,$balance_amnt,$sub_tot, $discount, $packing_charges, $delivery_charges, $total_amnt));

 $l_insert = $db->lastinsertid();

$orderdetails = pFETCH("SELECT * FROM `online_order_deatils` WHERE `object_id`=?", $getid);
while ($orderdetailsfetch = $orderdetails->fetch(PDO::FETCH_ASSOC)) 
{
    @extract($orderdetailsfetch);

    $resa11 = $db->prepare("INSERT INTO `sales_order_details` (`hsn`,`gstresult`,`object_id`,`bill_no`,`product_name`,`qty`,`rate`,`total`) VALUES (?,?,?,?,?,?,?,?) ");
    $resa11->execute(array($hsn,$gstresult,$l_insert,$bill_no,$product_name, $qty, $rate, $total)); 
}
 $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Converted to Sales</h4></div>';

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
            if (confirm("Do you want to delete the Order(s)"))
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
    #normalexamples tbody tr td:nth-child(3), tr td:nth-child(4),  tbody tr td:nth-child(6),tbody tr td:nth-child(8),tbody tr td:nth-child(9) {
        text-align:left;
        font-size: 19px;
    }
    #normalexamples tbody tr td:nth-child(5),  tbody tr td:nth-child(6),tbody tr td:nth-child(7) {
        text-align:center;
        font-size: 19px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Convert Sales Order to Sales
            <small>List of Sales(s)</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Sales</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Convert Sales Order to Sales</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <!-- <h3 class="box-title"><a href="<?php echo $sitename; ?>pages/process/addsales.php">Add New POS</a></h3> -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:5%;">S.id</th>
									<th style="width:10%">Date</th>
                                    <th style="width:10%">Customer Name</th>
                                    <th style="width:10%">Order Type</th>
                                    <th style="width:10%">Bill No</th>
									<th style="width:10%">Quantity</th>
									 <th style="width:10%">Rate</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Convert to Sales</th>
 </tr>
                            </thead>
                            <tbody>
<?php  
global $db;
$sn=1;
$sorder = $db->prepare("SELECT * FROM `online_order` WHERE `id`!='0'"); 
$sorder->execute();
while($sorderfetch = $sorder->fetch(PDO::FETCH_ASSOC)) { ?>
<form name="sform" method="post">
<tr>
<td><?php echo $sn; ?></td>
<td><?php echo date('d-m-Y',strtotime($sorderfetch['cudate'])); ?></td>
<td><?php if($sorderfetch['customer_id']=='') { echo "Store"; } else { echo getcustomer('name',$sorderfetch['customer_id']); } ?></td>
<td><?php if($sorderfetch['billtypemast']=='1') { echo "Cash Bill"; } else { echo "Credit Bill"; } ?></td>
<td><?php echo $sorderfetch['bill_number']; ?></td>
<td><?php echo getonlinetotqty($sorderfetch['id']); ?></td>
<td><?php echo $sorderfetch['total_amnt']; ?></td>
<td>
<input type="hidden" name="getid" value="<?php echo $sorderfetch['id']; ?>">
    <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;">Convert to Sales</button></td>
</tr>
</form>
<?php $sn++; } ?>

<tr>

</tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="8">&nbsp;</th>
									
                                </tr>
                            </tfoot>
                        </table>
                    </div>
              
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>process/' + a + '/editsales.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>  
