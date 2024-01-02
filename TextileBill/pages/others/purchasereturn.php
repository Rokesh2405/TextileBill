<?php
$menu = "8,8,29";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');

$_SESSION['driver'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delobject($chk);
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
            if (confirm("Do you want to delete the Object(s)"))
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
    #normalexamples tbody tr td:nth-child(2),  tbody tr td:nth-child(6),tbody tr td:nth-child(7),tbody tr td:nth-child(8),tbody tr td:nth-child(9) {
        text-align:left;
        font-size: 15px;
    }
    #normalexamples tbody tr td:nth-child(3),  tbody tr td:nth-child(4) {
        text-align:center;
        font-size: 15px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sales Return
            <small>List Sales Return</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Master(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Silver Object Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of sales return</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        
                       <center> SALES RETURN</center>
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:5%;">Supplier Name</th>
                                    <th style="width:10%">Silver Object</th>
                                    <th style="width:10%">Purchase Date</th>
                                      <th style="width:10%">Return Date</th>
                                      <th style="width:10%">Purchase Quantity</th>
                                      <th style="width:10%">Return Quantity</th>
                                      <th style="width:10%">Remaining Quantity</th>
                                      <th style="width:10%">Reason of Return</th>
                                      

                                     
                                   
                                </tr>
                            </thead>

                            <?php
                        $sql4 = $db->prepare("SELECT * FROM `purchasereturn`");
                            $sql4->execute();
                            $result4 = $sql4->rowcount();
                            if ($result4 > 0) {      
                                while ($purchase = $sql4->fetch(PDO::FETCH_ASSOC)) {

                                    $sid=$purchase['supplier_name'];                             
                                    $ssobj=$purchase['silver_object'];
                                    $ssdate=$purchase['purchase_date'];            
                                    $sqty=$purchase['total_quantity'];
                                    $sreqty=$purchase['return_quantity'];
                                    $sremqty=$purchase['remaining_quantity'];
                                    $srdate=$purchase['return_date'];            
                                    $sreson=$purchase['reson_return'];            
                                        ?>

                                         <tr>
                                                    <td>
                                                       <?php echo $sid; ?>
                                                    </td>
                                                    <td><?php echo $ssobj; ?></td>
                                                      
                                                      <td><?php echo $sdate; ?></td>
                                                       <td><?php echo $srdate; ?></td>
                                                       <td><?php echo $sqty; ?></td>
                                                        <td><?php echo $sreqty; ?></td>
                                                         <td><?php echo $sremqty; ?></td>
                                                       <td><?php echo $sreson; ?></td>
                                                        
                                                </tr>
                                                <tr>
                                            
                                                </tr>

                                                <?php
                                  
                                }

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
