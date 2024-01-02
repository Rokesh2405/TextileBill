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
                        
                       <center>PAWN DETAILES</center>
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:17px;">
                                    <th style="width:5%;">S.no</th>
                                    <th style="width:1%;">Rec:NO</th>
                                    <th style="width:10%">Amount</th>
                                    <th style="width:10%">Weight (in gms)</th>
                                    <th style="width:10%">Loan Number</th>
                                    <th style="width:10%">Name</th>
                                    <th style="width:10%">Date of Pawn</th>
                                    <th style="width:10%">Days</th>
                                    <th style="width:10%">Bank Name</th>
                                    <th style="width:10%">Interest Percent</th>
                                    <th style="width:10%">Interest (Per Day)</th>
                                    <th style="width:10%">Interest amount</th>
                                   
                                    
                                     
                                     
                                   
                                </tr>
                            </thead>

                            <?php
                            $sid = 1;
                    //total amount
                             
                                //echo $tot1;
                    //total amount
                        $sql4 = $db->prepare("SELECT * FROM bankstatus WHERE DATEDIFF(`currentdate`,`dateofpawn`) > 85 and `status`=1");
                            $sql4->execute();
                            
                            $result4 = $sql4->rowcount();
                            if ($result4 > 0) {
                                  $tot=0;
                                  $intsta =0;
                                  $now = time();
                                while ($purchase = $sql4->fetch(PDO::FETCH_ASSOC)) 
                                {
                                  
                                    $rno = $purchase['receiptno'];
                                    $amount = $purchase['amount'];
                                    $weight = $purchase['weight'];  
                                    $lno = $purchase['loanno'];
                                    $name = $purchase['name'];
                                    $dop = $purchase['dateofpawn']; 
                                    $cdate = $purchase['currentdate'];  
                                    $bank = $purchase['bankname'];
                                    $intrstp = $purchase['interestpercent'];
                                    $intrstpd = $purchase['interest'];  
                                    $datetime1 = new DateTime($cdate);
                                    $datetime2 = new DateTime($dop);
                                    //echo $datetime1;
                                    $interval = $datetime2->diff($datetime1);
                                    //echo $interval;
                                    $newDate = date("d-m-Y", strtotime($dop));
                                    $intsta = $interval * $intrstpd;
                                    $tot += $purchase['amount'];
                                  
                                   
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
                                                        <input type="text" readonly="" style="width: 120px;" value="<?php echo $rno ?>" name="">
                                                    </b></td>
                                                    <td><b><?php echo $amount ?></b></td>
                                                    <td><b><?php  echo $weight ?></b></td>
                                                    <td><b><?php echo $lno ?></b></td>
                                                    <td><b><?php echo $name ?></b></td>
                                                    <td><b></b>
                                                        <input type="text" readonly="" style="width: 98px;border-color: white;background-color: #a3b3cc;color: #000000;font-weight: bold;" value="<?php  echo $newDate ?>" name="">
                                                    </td>
                                                    <td><b><?php echo $interval->format('%a'); ?>

                                                    </td>
                                                    <td><b><?php echo $bank ?></b></td>
                                                    <td><b><?php echo $intrstp ?></b></td>
                                                    <td><b><?php  echo $intrstpd ?></b></td>
                                                    <td><b><?php $t = $interval->format('%a');  

                                                    $t1 = $t * $intrstpd;
                                                    echo $t1;
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
                           
                            

                            
                            <tfoot>
                                  <h2><b>TOTAL AMOUNT:<?php  //echo $tot; 

                                 echo number_format($tot)."<br>";
                                 ?></b></h2>


                            </tfoot>
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
