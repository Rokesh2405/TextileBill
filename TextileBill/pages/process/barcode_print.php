<?php
$menu = "3,3,44";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
include 'barcode128.php';
if(isset($_REQUEST['export']))
{
@extract($_REQUEST);
$url=$sitename.'pages/process/export.php?type=stock&fromdate='.$_REQUEST['fromdate'].'&todate='.$_REQUEST['todate'].'&product='.$_REQUEST['product'];
echo "<script>window.open('".$url."', '_blank');</script>";
}
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {

   $proids=implode(',',$_REQUEST['productid']);
   $qtys=implode(',',$_REQUEST['qty']);
    $chks=implode(',',$_REQUEST['chk']);
  $url=$sitename.'/pages/process/printbarcode.php?productid='.$proids.'&qtys='.$qtys.'&chks='.$chks;
  echo "<script>
        window.open('".$url."', '_blank');
    </script>";
}
?>
<script type="text/javascript" >
    function validcheck(name)
    {
        var chObj = document.getElementsByName(name);
        var result = false;
        // for (var i = 0; i < chObj.length; i++) {
        //     if (chObj[i].checked) {
        //         result = true;
        //         break;
        //     }
        // }
        // if (!result) {
        //     return false;
        // } else {
            return true;
        //}
    }

    function checkdelete(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Do you want to Print the Barcode(s)"))
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
            Barcode Print
            <small>List of Barcodes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Report(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Barcode Print Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Barcode</h3>
            </div><!-- /.box-header -->
            <div class="box-header">
               
            </div><!-- /.box-header -->

            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:3%;">Sno</th>
								   <th style="width:10%">Product Name</th>
								   <th style="width:10%">Barcode</th>
								   <th style="width:10%">Selling Price</th>
								   <th style="width:10%">Purchase Price</th>
								   <th style="width:10%">Print Qty</th>
                                   <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead>
<?php  
    global $db;

$message1 = $db->prepare("SELECT * FROM `object` WHERE `id`!='0' ORDER BY `id` DESC");

$m=1;
 $message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {

	
  ?>
                                    
                                         <tr>
  <td><?php echo $m; ?></td>
													  
                                                   
                                                    <td><?php 
                                                   
												   echo $message['objectname']; 
													?>
                 <input type="hidden" name="productid[]" value="<?php echo $message['id']; ?>">

                                                    </td>
													 <td>
                                                        <?php
    echo "<p class='inline'><span ><b>Item: ".$message['objectname']."</b></span>".bar128(stripcslashes($message['productcode']))."<span ><b>Price: ".$message['price']." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
                                                        ?>
                                                      </td>
                                                     <td>Rs. <?php echo $message['price']; ?></td>
													 <td>Rs. <?php echo $message['mrp_price']; ?></td>
                                                     <td><input type="text" name="qty[]" id="qty[]" class="form-control"></td>
													 <td style="text-align:center;"><input type="checkbox" name="chk[]" id="chk[]" value="<?php echo $message['id']; ?>"></td>
                                                </tr>
                                                <?php
												$m++;
                                            }
                                            ?>
                            
                            <tfoot>
                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                    <td style="text-align:center;"><button type="submit" class="btn btn-success" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> Print </button></td>
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