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
        font-size: 19px;
    }
    #normalexamples tbody tr td:nth-child(3),  tbody tr td:nth-child(4) {
        text-align:center;
        font-size: 19px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Purchase Stocks
            <small>List Purchase of Stocks</small>
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
                <h3 class="box-title">List of Stocks</h3>
            </div><!-- /.box-header -->
            <div class="box-header">
                <h3 class="box-title">TOTAL STOCK AMOUNT:
                <?php 
                $sql41 = $db->prepare("SELECT SUM(`amount`) AS `samount` FROM `sales`");
                $sql41->execute();

                 $sql411 = $db->prepare("SELECT SUM(`amount`) AS `pamount` FROM `purchase`");
                $sql411->execute();
                $st = 0;
                $pt = 0;
                 while ($stock = $sql41->fetch(PDO::FETCH_ASSOC)) 
                 {
                    $st = $stock['samount'];
                    // echo $st;
                    // echo "<br>";
                    while ($ptock = $sql411->fetch(PDO::FETCH_ASSOC)) 
                    {
                         $pt = $ptock['pamount'];
                        // echo $pt;
                    }
                 }
                
                 $bt = $pt - $st;
                 echo $bt;
                 //echo $bt;
                ?></h3><br><br>
                <h3 class="box-title">TOTAL STOCK COUNT:
                <?php 
                $sql412 = $db->prepare("SELECT SUM(`squantity`) AS `squant` FROM `sales_object_detail`");
                $sql412->execute();

                 $sql4112 = $db->prepare("SELECT SUM(`pquantity`) AS `pquant` FROM `purchase_object_detail`");
                $sql4112->execute();
                
                 while ($stock = $sql412->fetch(PDO::FETCH_ASSOC)) 
                 {
                    $sq = $stock['squant'];
                    // echo $st;
                    // echo "<br>";
                    while ($ptock = $sql4112->fetch(PDO::FETCH_ASSOC)) 
                    {
                         $pq = $ptock['pquant'];
                        // echo $pt;
                    }
                 }
                
                 $bq = $pq - $sq;
                 echo $bq;
                 //echo $bt;
                ?></h3>
            </div>
            </div>
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        
                       <center> AVAILABLE STOCKS</center>
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:5%;">Name</th>
                                    <th style="width:10%">Total</th>
                                     
                                      <th style="width:10%">Purchase Date</th>
                                     
                                   
                                </tr>
                            </thead>

                            <?php
                        $sql4 = $db->prepare("SELECT `object`,`pdate`,SUM(`pquantity`) AS `tot_quantity` FROM `purchase_object_detail` GROUP BY `object`");
                            $sql4->execute();
                            
                            $result4 = $sql4->rowcount();
                            if ($result4 > 0) {      
                                while ($purchase = $sql4->fetch(PDO::FETCH_ASSOC)) {
                                    $pobj = $purchase['object'];
                                    $pqty = $purchase['tot_quantity'];  
                                   
                                     $pdate = $purchase['pdate'];
                                       
                                    
                                        ?>
                                    
                                         <tr>
                                                    <td><?php echo getobjectsilver('objectname', $pobj); ?></td>

                                                    <td><?php echo $pqty; ?></td>
                                                     
                                                      <td><?php //echo $pdate; 
                                                       $newDate = date("d-m-Y", strtotime($pdate));
                                                       echo $newDate;
                                                       ?></td>
                                                        


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
