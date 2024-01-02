<?php
include ('../../config/config.inc.php');

// echo "SELECT * FROM `loan` WHERE `status`='1' AND `id` ='". $_REQUEST['receiptno']."' ";
if ($_REQUEST['year'] != '') {
//    echo $_REQUEST['year'];
    if ($_REQUEST['page'] != '') {
        $page = $_REQUEST['page'];
        $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status`='0' LIMIT $page ");
        $dateformate->execute();
//        echo "SELECT * FROM `return` LIMIT $page";
    } else {
        $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status`='0' ");
        $dateformate->execute();
    }
//    $yearqry = $db->prepare("SELECT * FROM `return` WHERE IN `date`=? ");
//    $yearqry->execute(array($_REQUEST['year']));
    ?>
    <label>Year Wise Search </label>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr align="center" style="font-size:19px;">
                    <th style="width:5%;">S.id</th>
                   
                    
                    <th style="width:10%">Receipt No</th>
                    <th style="width:10%">Bank Name</th>
                    <th style="width:10%">Net Weight</th>
                    <th style="width:10%">Pawn date</th>
                    <th style="width:10%">Return date</th>
                    <th style="width:10%">Principal</th>
                    <th style="width:10%">Interest</th>
                    <th style="width:10%">Amount</th>
                    <th style="width:10%">Loan No</th>
                    <th style="width:10%">Status</th>
                    <!--<th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">View</th>-->
    <!--                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>-->
                </tr>
            </thead>

            <?php
            $i = '1';
            $ycount = $dateformate->rowcount();
            if ($ycount != '') {
                while ($orderdate = $dateformate->fetch(PDO::FETCH_ASSOC)) { 
//                        echo $orderdate['customerid'];
                    $orderdate1 = explode('-', $orderdate['returndate']);
                    $month = $orderdate1[0];
                    $day = $orderdate1[1];
                    $year = $orderdate1[2];
//                        echo $year;
                    if ($year == $_REQUEST['year']) {

//                            echo $year;
//                            echo $orderdate['0'];
                        ?>
                        <tbody>
                            <tr style="font-size:19px">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $orderdate['receiptno']; ?></td>
                                <td><?php echo $orderdate['bankname']; ?></td>
                                <td><?php echo $orderdate['weight']; ?></td> 
                                <td><?php echo $orderdate['dateofpawn']; ?></td>
                                <td><?php echo $orderdate['returndate']; ?></td>
                                <td><?php echo $orderdate['amount']; ?></td>
                                <td><?php echo $orderdate['interest']; ?></td>
                                <td><?php echo number_format( $orderdate['totalamount'], 2, '.', ''); ?></td>
                                <td><?php echo $orderdate['loanno']; ?></td>
                                <td><?php
                                    if ($orderdate['status'] == '1') {
                                        echo 'Pawned';
                                    } else {
                                        echo 'Returned';
                                    }
                                    ?></td>
                <!--                                <td><a href=""><i class="fa fa-print"></i></a></td>-->
                            </tr>
                        </tbody>

                        <?php
                        $i++;
                    }
                }
            }
            ?>
        <!--            <tfoot>
                        <tr>
                            <th colspan="5">&nbsp;</th>
                                                <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                        </tr>
                    </tfoot>-->
        </table>
        <!--<a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename . 'MPDF/yearwise.php?id=' . $_REQUEST['year']; ?>"></a>-->
    </div>
    <?php
}elseif ($_REQUEST['month'] != '') {

  $t = $_REQUEST['page'];
  //echo $t;
    if ($_REQUEST['page'] != '') {
        $page = $_REQUEST['page'];
        $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status` = '0' LIMIT $page ");
        $dateformate->execute();
    } else {
        $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status` = '0'");
        $dateformate->execute();
    }
//    $yearqry = $db->prepare("SELECT * FROM `return` WHERE IN `date`=? ");
//    $yearqry->execute(array($_REQUEST['year']));
    ?>
    <label>Month Wise Search </label>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr align="center" style="font-size:19px;">
                    <th style="width:5%;">S.id</th>
              
                   
                    <th style="width:10%">Receipt No</th>
                     <th style="width:10%">Bank Name</th>
                    <th style="width:10%">Net Weight</th>
                    <th style="width:10%">Pawn date</th>
                   <th style="width:10%">Return date</th>
                    <th style="width:5%">Principal</th>
                    <th style="width:5%">Days</th>
                    <th style="width:10%">Interest</th>
                    <th style="width:10%">Amount</th>
                     <th style="width:10%">Loan No</th>
                    <th style="width:10%">Status</th>
                    <!--<th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">View</th>-->
    <!--                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>-->
                </tr>
            </thead>

            <?php
            $i = '1';
            $mcount = $dateformate->rowcount();
                    if ($mcount != '') {
            while ($orderdate = $dateformate->fetch(PDO::FETCH_ASSOC)) {
//                        echo $orderdate['customerid'];
                $orderdate1 = explode('-', $orderdate['returndate']);
                $day = $orderdate1[0];
                $month = $orderdate1[1];
                $year = $orderdate1[2];
                        //echo $year;
                if ($month == $_REQUEST['month'] && $year == $_REQUEST['page']) {
                    $qty = $qty + $orderdate['amount'];
//                            echo $year;
//                            echo $orderdate['0'];
                        ?>
                        <tbody>
                            <tr style="font-size:19px">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $orderdate['receiptno']; ?></td>
                                <td><?php echo $orderdate['bankname']; ?></td>
                                <td><?php echo $orderdate['weight']; ?></td>
                                <td><?php 
                                $pawndate=date('d-m-Y', strtotime($orderdate['dateofpawn']));
                                echo $pawndate;
                                ?></td>
                                <td><?php
                                $pawndate1=date('d-m-Y', strtotime($orderdate['returndate'])); 
                                 echo $pawndate1;
                                ?></td>
                                <td  style="max-width:100px"><?php echo $orderdate['amount']; ?></td>
                                <td><?php  
$date1=date_create($pawndate);
$date2=date_create($pawndate1);
$diff=date_diff($date1,$date2);
$diff1=$diff->format("%a"); 
echo $diff1;
                                ?></td>
                                <td><?php echo $orderdate['interest']; ?></td>
                                <td><?php echo number_format( $orderdate['totalamount'], 2, '.', ''); ?></td>
                                <td><?php echo $orderdate['loanno']; ?></td>
                                <td><?php
                                    if ($orderdate['status'] == '1') {
                                        echo 'Pawned';
                                    } else {
                                        echo 'Returned';
                                    }
                                    ?></td>
                                <!--<td><a href=""><i class="fa fa-print"></i></a></td>-->
                            </tr>
                        </tbody>

                        <?php
                        $i++;
                    }
                }
            }else{
                echo '<label>No row displayed yet';
            }
            ?>
            <tr><td></td><td><td><td><td><td></td></td></td></td></td><td><input type="text" readonly="" name="" value="<?php echo $qty; ?>"></td></tr>
            <tfoot>
                <tr>
                    <th colspan="5">&nbsp;</th>
    <!--                                    <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>-->
                </tr>
            </tfoot>
        </table>
        <!--<a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename .'MPDF/monthwise.php?id='.$_REQUEST['month']; ?>"></a>-->
    </div>
    <?php
} elseif ($_REQUEST['date'] != '') {
    $yearqry = $db->prepare("SELECT * FROM `bankstatus` WHERE `returndate`=? AND `status`= '0'");
    $yearqry->execute(array($_REQUEST['date']));
  $dcount = $yearqry->rowcount();
            if ($dcount != '') {?>
    <label>Date Wise Search </label>
    <div class="table-responsive">
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr align="center" style="font-size:19px;">
                    <th style="width:5%;">S.id</th>


                    <th style="width:10%">Receipt No</th>
                    <th style="width:10%">Bank Name</th>                    
                    <th style="width:10%">Net Weight</th>
                    <th style="width:10%">Pawn date</th>
                    <th style="width:10%">Principal</th>
                    <th style="width:10%">Interest</th>
                    <th style="width:10%">Amount</th>
                     <th style="width:10%">Loan No</th>
                    <th style="width:10%">Status</th>
                    <!--<th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">View</th>-->
    <!--                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>-->
                </tr>
            </thead>
             
            <?php
            $i = '1';
           
                while ($year = $yearqry->fetch(PDO::FETCH_ASSOC)) {
                    ?><tbody>
                   
                        <tr style="font-size:19px">
                            <td><?php echo $i; ?></td>
                            
                            <td><?php echo $year['receiptno']; ?></td>
                            <td><?php echo $year['bankname']; ?></td>
                            <td><?php echo $year['weight']; ?></td>
                            <td><?php echo $year['dateofpawn']; ?></td>
                            <td><?php echo $year['amount']; ?></td>
                            <td><?php echo $year['interest']; ?></td>
                            <td><?php echo number_format( $orderdate['totalamount'], 2, '.', ''); ?></td>
                            <td><?php echo $orderdate['loanno']; ?></td>
                            <td><?php
                                    if ($year['status'] == '1') {
                                        echo 'Pawned';
                                    } else {
                                        echo 'Returned';
                                    }
                                    ?></td>
                            <!--<td><a href=""><i class="fa fa-print"></i></a></td>-->
                        </tr>
                    </tbody> 
                    <?php
                   $i++;
                }  ?> 
            <tfoot>
                <tr>
                    <th colspan="10">&nbsp;</th>
    <!--                                    <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>-->
                </tr>
            </tfoot>
        </table>
        <!--<a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename .'MPDF/datewise.php?id='.$_REQUEST['date']; ?>"></a>-->
        <?php
            } else {
    echo '<label>No row displayed yet</label>';
}
            ?>
    </div>
    <?php
} else {
    echo "No row selected";
}
?>
<script>
    $('.usedatepicker').datepicker({
        autoclose: true
    });

</script>

