<?php
include ('../../config/config.inc.php');

// echo "SELECT * FROM `loan` WHERE `status`='1' AND `id` ='". $_REQUEST['receiptno']."' ";
if($_REQUEST['receipt'] != ''){
    ?>
    <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg"> 
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Returned</h4>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="modalvalue" id="modalvalue" value="" class="form-control" />
                                <?php
                                $qry = FETCH_all("SELECT * FROM `loan` WHERE `receipt_no`=? ", $_REQUEST['receipt']);
                                echo 'hi' . $_REQUEST['receipt'];
                                ?>
                                <div style="text-align:center">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Receipt No</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo $qry['receipt_no']; ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Customer ID</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo getcustomer('cusid', $qry['customerid']); ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Name</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo $qry['name']; ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Mobile No</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo $qry['mobileno']; ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Entry Date</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo $qry['date']; ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Entry Item</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Amount</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo $qry['amount']; ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Interest</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo $qry['interestercent']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
<?php }
else if ($_REQUEST['customerid'] != '') {


    $findqry = $db->prepare("SELECT * FROM `loan` WHERE `customerid`=? ");
    $findqry->execute(array($_REQUEST['customerid']));
//    echo 'hi' . $findqry['receiptno'];
//    $findqry->execute(array( $_REQUEST['customerid'], $_REQUEST['receiptno']));
//    $receiptlist = FETCH_ALL("SELECT * FROM `loan` WHERE `status`=? AND `id` =? ", '1', $_REQUEST['receiptno']);
    $extra = FETCH_all("SELECT * FROM `loan` WHERE `customerid`=?", $_REQUEST['customerid']);
    ?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <label>Customer ID : </label> 
            </div>
            <div class="col-md-2">
                <label> <?php echo $extra['customerid']; ?> </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Customer Name : </label> 
            </div>
            <div class="col-md-2">
                <label> <?php echo $extra['name']; ?> </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Mobile number : </label> 
            </div>
            <div class="col-md-2">
                <label> <?php echo $extra['mobileno']; ?> </label>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr align="center" style="font-size:19px;">
                        <th style="width:5%;">S.id</th>
                        <!--<th style="width:10%">Customer Name</th>-->
                        <th style="width:10%">Receipt No1</th>
                        <th style="width:10%">Net weight</th>
                        <th style="width:10%">Amount</th>
                        <th style="width:10%">Interest</th>
                        <th style="width:10%">Status</th>
                        <!--<th style="width:15%">Mobile No</th>-->
                        <!--<th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">View</th>-->
        <!--                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                        <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>-->
                    </tr>
                </thead>
                <?php
                $i = '1';
                if ($i != '') {
                    while ($find = $findqry->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $find['receipt_no']; ?></td>
                                <td><?php echo $find['netweight']; ?></td>
                                <td><?php echo $find['amount']; ?></td>
                                <td><?php echo $find['interestpercent']; ?></td>
                                <td><?php
                                    if ( $find['returnstatus'] == '0') {
                                        echo 'Returned';
                                    } else {
                                        echo 'Pawned';
                                    }
                                    ?></td>
                            </tr>
                        </tbody>
                        <?php
                        $i++;
                    }
                }
                ?>
    <!--            <tfoot>
    <tr>
    <th colspan="6">&nbsp;</th>
    <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
    </tr>
    </tfoot>-->
            </table>

            <!--<a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename .'MPDF/customerwise.php?id='.$_REQUEST['customerid']; ?>"></a>-->

        </div>
    </div>
    <?php
} elseif ($_REQUEST['year'] != '') {
//    echo $_REQUEST['year'];
    if ($_REQUEST['page'] != '') {
        $page = $_REQUEST['page'];
        $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status`='1' LIMIT $page ");
        $dateformate->execute();
//        echo "SELECT * FROM `return` LIMIT $page";
    } else {
        $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status`='1' ");
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
                    <!--<th style="width:10%">Return date</th>-->
                    <th style="width:10%">Principal</th>
                    <th style="width:10%">Interest</th>
                    <th style="width:10%">Loan Number</th>
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
                    $orderdate1 = explode('-', $orderdate['dateofpawn']);
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
                                <td><?php
                                $t=$orderdate['dateofpawn'];
                               //echo $t;
                                $newDate = date("d-m-Y", strtotime($t));
                                 ?>
                                     <input type="text" readonly="" data-date-format='dd-mm-yyyy' value="<?php echo $newDate; ?>" name="">
                                 </td>
                                
                                <td><?php echo $orderdate['amount']; ?></td>
                                <td><?php echo $orderdate['interest']; ?></td>
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
//echo $_REQUEST['year'];
    if ($_REQUEST['page'] != '') {
        $page = $_REQUEST['page'];
        //echo $page;
        $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status` = '1' LIMIT $page ");
        $dateformate->execute();
    } else {
        $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status` = '1'");
        $dateformate->execute();
    }
//    $yearqry = $db->prepare("SELECT * FROM `return` WHERE IN `date`=? ");
//    $yearqry->execute(array($_REQUEST['year']));
    ?>
    <label>Month Wise Search </label>
    <!-- <input type="text" name=""> -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr align="center" style="font-size:19px;">
                    <th style="width:5%;">S.id</th>     
                    <th style="width:10%">Receipt No</th>
                     <th style="width:10%">Bank Name</th>
                    <th style="width:10%">Net Weight</th>
                    <th style="width:10%">Pawn date</th>
                   <!--<th style="width:10%">Return date</th>-->
                    <th style="width:10%">Principal</th>
                    <th style="width:10%">Interest</th>
                    <th style="width:10%">Loan No</th>
                    <th style="width:10%">Status</th>
                    <!--<th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">View</th>-->
    <!--                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>-->
                </tr>

            </thead>

            <?php
            $i = '1';
            $qty ='0';
            $mcount = $dateformate->rowcount();
                    if ($mcount != '') {
            while ($orderdate = $dateformate->fetch(PDO::FETCH_ASSOC)) {
//              echo $orderdate['customerid'];
                $orderdate1 = explode('-', $orderdate['dateofpawn']);
                $day = $orderdate1[0];
                $month = $orderdate1[1];
                $year = $orderdate1[2];
                        //echo $day;

                if ($month == $_REQUEST['month'] && $day == $_REQUEST['page']) {
                    $qty = $qty + $orderdate['amount'];
                    
//                            echo $year;
//                            echo $orderdate['0'];
                    // $newDate = date("d-m-Y", strtotime($orderdate));
                               // echo $newDate;
                        ?>
                        <tbody>
                            <tr style="font-size:19px">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $orderdate['receiptno']; ?></td>
                                <td><?php echo $orderdate['bankname']; ?></td>
                                <td><?php echo $orderdate['weight']; ?></td>
                                <td><?php 
                                $t=$orderdate['dateofpawn'];
                            //   echo $t;
                                $newDate = date("d-m-Y", strtotime($t));
                                 ?>
                                     <input type="text" style="width: 100px;" readonly="" data-date-format='dd-mm-yyyy' value="<?php echo $newDate; ?>" name="">
                                 </td>
                                
                                <td><?php echo $orderdate['amount']; ?></td>
                                <td><?php echo $orderdate['interest']; ?></td>
                                <td><?php echo $orderdate['loanno']; ?></td>
                                <td><?php
                                    if ($orderdate['status'] == '1') {
                                        echo 'Pawned';
                                    } else {
                                        echo 'Returned';
                                    }
                                    ?></td>
                                <!--<td><a href=""><i class="fa fa-print"></i></a></td>-->

                        </tbody>

                        <?php
                        $i++;
                    }
                }

            }else{
                echo '<label>No row displayed yet';
            }
            ?>
             <tr><td><td><td><td><td></td></td></td></td></td><td><h2><input type="text" style="width: 100px;" readonly="" name="" value="<?php echo $qty; ?>"></h2></td></tr>
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
} elseif ($_REQUEST['date'] != '') 
{
    $yearqry = $db->prepare("SELECT * FROM `bankstatus` WHERE `dateofpawn`=? AND `status`= '1'");
    $t = $_REQUEST['date'];
    $newDate = date("Y-m-d", strtotime($t));
    //echo $newDate;
    
    $yearqry->execute(array($newDate));
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
                    <th style="width:10%">Loan Number</th>
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
                            <td><?php

                            $t= $year['dateofpawn'];
                            //   echo $t;
                            //   echo "adsfds";
                                $newDate = date("d-m-Y", strtotime($t));
                                // echo $newDate;
                                 ?>
                                     <input type="text" readonly="" data-date-format='dd-mm-yyyy' value="<?php echo $newDate; ?>" name="">
                             </td>
                            <td><?php echo $year['amount']; ?></td>
                            <td><?php echo $year['interest']; ?></td>
                            <td><?php echo $year['loanno']; ?></td>
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

