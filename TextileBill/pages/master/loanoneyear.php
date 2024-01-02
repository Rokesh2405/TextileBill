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
           
            <small></small>
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
                <h3 class="box-title"></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        
                       <center><h4><b>LOAN DETAILES(AFTER 1 YEAR SHOWING CUSTOMER DETAILS FROM PAWN DATE)</b></h4></center>
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:17px;">
                                    <th style="width:5%;">S.no</th>
                                    <th style="width:5%">Cus.Id</th>
                                    <th style="width:1%;">Rec:NO</th>
                                    
                                   <th style="width:10%">Name</th>
                                     <th style="width:10%">Date of Pawn</th>
                                     
                                     <th style="width:10%">No.of.Days</th>
                                      <th style="width:10%">No.of.Months</th>
                                      <th style="width:10%">Amount</th>
                                      <th style="width:10%">intrst-%</th>
                                       <th style="width:10%">intrst-amount per month</th>
                                        <th style="width:10%">total intrst amount</th>
                                   
                                   
                                    
                                   
                                    
                                     
                                     
                                   
                                </tr>
                            </thead>

                            <?php
                            $sid = 1;
                    //total amount
                             
                                //echo $tot1;
                    //total amount
                        $sql4 = $db->prepare("SELECT * FROM loan WHERE DATEDIFF(`currentdate`,`date`) > 364 and `status`=1 and `returnstatus`=2");
                            $sql4->execute();
                            
                            $result4 = $sql4->rowcount();
                            if ($result4 > 0) {
                                  $tot=0;
                                  $intsta =0;
                                  $now = time();
                                while ($purchase = $sql4->fetch(PDO::FETCH_ASSOC)) 
                                {
                                  
                                    $rno = $purchase['cusid'];
                                    $customerid = $purchase['customerid'];
                                    $recno=$purchase['receipt_no'];
                                    $name=$purchase['name'];
                                    $pdate=$purchase['date'];
                                    $cdate=$purchase['currentdate'];
                                    $amount=$purchase['amount'];
                                    $intrstpr=$purchase['interestpercent'];
                                    $intrstamnt=$purchase['interest'];
                                    $datetime1 = new DateTime($cdate);
                                    $datetime2 = new DateTime($pdate);
                                    $interval = $datetime2->diff($datetime1);
                                    $newDate = date("d-m-Y", strtotime($pdate));
                                    //echo $datetime1;
                                    //echo $cdate;interest
                                    $tot_p += $purchase['amount'];
                                    $tot_a += $purchase['interest'];
                                    $inter1=$interval->format('%a');
                                    $months=$inter1/30;
                                    $month1=round($months);
                                    
                                   
                                      if ($sid % 2 == 0){
echo "<tr class='style1'>";
}
else{
echo "<tr class='style2'>";
}
                                    
                                        ?>
                                    
                                         <tr style="font-size:19px;" >
                                                <td><?php echo $sid ?></td>

                            <td><b>
                             <input type="text" readonly="" style="width: 50px;" value="<?php echo $customerid;?>" name="">
                                                    </b></td>
                                                    <td><b><?php echo $recno;?></b></td>
                                                    <td><b><?php echo $name;?></b></td>
                                                    <td><b><?php echo $newDate;?></b></td>
                                                    
                                                    <td><b><?php echo $interval->format('%a'); ?></b></td>
                                                    <td><b><?php echo $month1; ?></b></td>
                                                     <td><b><?php echo $amount; ?></b></td>
                                                    
                                                   <td><b><?php echo $intrstpr; ?>%</b></td>
                                                   <td><b><?php $intrstamntt=$amount-$intrstamnt; 
                                                   echo $intrstamntt;
                                                   
                                                   ?></b></td>
                                                   <td><b><?php 
                                                   $totalint=$month1*$intrstamntt;
                                                   echo $totalint;
                                                   
                                                   ?></b></td>
                                                   
                                                    
                                                    <?php $sid++; ?>

                                                 
                                                </tr>

                                                <tr>
                                            
                                                </tr>

                                                <?php 
                                  
                                }
                            }
                                
                            
                            // echo "TOTAL PAWN AMOUNT:".$tot;

                            ?>
                           
                            

                            
                          
                                  
                                 <div class="row">
                                     <div class="col-md-4">
                                        <h4><b>TOTAL PAWN AMOUNT:<?php  //echo $tot; 

                                 echo number_format($tot_p);
                                 ?>Rs</b>
                                 </h4> 
                                     </div>
                                     <div class="col-md-4">
                                         <h4><b>TOTAL AMOUNT:<?php  //echo $tot; 

                                 echo number_format($tot_a);
                                 ?>Rs</b>
                                 </h4>
                                     </div>
                                     <div class="col-md-4">
                                         <h4><b>TOTAL INTRST AMOUNT:<?php  //echo $tot; 

                                 $tot_b = $tot_p - $tot_a;
                                 echo $tot_b;
                                 ?>Rs</b>
                                 </h4>
                                     </div>
                                 </div>
                                 


                           
                        </table>
                         <!-- <img src="https://img.icons8.com/office/80/000000/send-to-printer.png" height="70" id="printt"> -->

                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include ('../../require/footer.php');
?>  
<script type="text/javascript">
    $("#printt").click(function()
    {
           window.print();
           return false;
});
</script>
