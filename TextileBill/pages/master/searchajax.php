<?php
include ('../../config/config.inc.php');

// echo "SELECT * FROM `loan` WHERE `status`='1' AND `id` ='". $_REQUEST['receiptno']."' ";
if ($_REQUEST['receiptno'] != '') {
//    $customer = FETCH_all("SELECT * FROM `customer` WHERE `cusid`=?", $_REQUEST['id']);
//    $loanqry = $db->prepare("SELECT * FROM `loan` WHERE `cusid`=? ");
//$loanqry->execute(array($customer['id']));


    
    $qry = FETCH_all("SELECT * FROM `loan` WHERE `receipt_no`=? ", $_REQUEST['receiptno']);
    ?>
    <div style="text-align:center">
        <div class="row">
            <div class="col-md-2">
                <label>Receipt No</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $qry['receipt_no']; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Customer ID</label>
            </div>
            <div class="col-md-2">
                <label><?php echo  $qry['customerid']; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Customer Name</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $qry['name']; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Mobile No</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $qry['mobileno']; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Entry Date</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $qry['date']; ?></label>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-2">
                <label>Entry Item</label>
            </div>
            <div class="col-md-2">
                <?php
//while ($loan = $loanqry->fetch(PDO::FETCH_ASSOC)) {

    $object_detail = $db->prepare("SELECT * FROM `object_detail` WHERE `object_id`=? ");
    $object_detail->execute(array($qry['id']));
    while ($object_detaillist = $object_detail->fetch(PDO::FETCH_ASSOC)) {
    ?>
                <label><?php echo getobject('objectname', $object_detaillist['object']) . - $object_detaillist['quantity']; ?></label>
<?php } 

   // } ?>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Amount</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $qry['amount']; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Interest</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $qry['interest']; ?></label>
            </div>
        </div>
        <?php 
            if($qry['status'] == '1' && $qry['returnstatus'] == '0'){
                $qry1 = FETCH_all("SELECT * FROM `return` WHERE `receipt_no`=? ", $_REQUEST['receiptno']);
        ?>
        <div class="row">
            <div class="col-md-2">
                <label>Return Date</label>
            </div>
            <div class="col-md-2">
                <label><?php echo $qry1['currentdate']; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label>Status</label>
            </div>
            <div class="col-md-2">
                <label><?php if($qry['status'] == '1' && $qry['returnstatus'] == '0'){  ?> Returned <?php }else { ?> Pawned <?php } ?></label>
            </div>
        </div>
            <?php }else{ ?>
        <div class="row">
            <div class="col-md-2">
                <label>Status</label>
            </div>
            <div class="col-md-2">
                <label><?php if($qry['status'] == '1' && $qry['returnstatus'] == '0'){  ?> Returned <?php }else { ?> Pawned <?php } ?></label>
            </div>
        </div>
            <?php } ?>
    </div>
<?php
} else if ($_REQUEST['customerid'] != '') {


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
                        <th style="width:10%">Receipt No</th>
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
                                    if ($find['returnstatus'] == '0') {
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

            <a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename . 'MPDF/customerwise.php?id=' . $_REQUEST['customerid']; ?>"></a>

        </div>
    </div>
    <?php
} elseif ($_REQUEST['year'] != '') {
//    echo $_REQUEST['year'];
    if ($_REQUEST['page'] != '') {
        $page = $_REQUEST['page'];
        $dateformate = $db->prepare("SELECT * FROM `return` LIMIT $page ");
        $dateformate->execute();
        echo "SELECT * FROM `return` LIMIT $page";
    } else {
        $dateformate = $db->prepare("SELECT * FROM `return` ");
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
                    <th style="width:10%">Customer ID</th>
                    <th style="width:10%">Customer Name</th>
                    <th style="width:10%">Receipt No</th>
                    <th style="width:10%">Net Weight</th>
                    <th style="width:10%">Pawn date</th>
                    <th style="width:10%">Return date</th>
                    <th style="width:10%">Principal</th>
                    <th style="width:10%">Interest</th>
                    <th style="width:10%">Amount</th>
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
                    $orderdate1 = explode('-', $orderdate['date']);
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
                                <td><?php echo getcustomer('cusid', $orderdate['customerid']); ?></td>
                                <td><?php echo $orderdate['name']; ?></td>
                                <td><?php echo getloan('receipt_no', $orderdate['loanid']); ?></td>
                                <td><?php echo $orderdate['netweight']; ?></td>
                                <td><?php echo $orderdate['date']; ?></td>
                                <td><?php echo $orderdate['currentdate']; ?></td>
                                <td><?php echo $orderdate['amount']; ?></td>
                                <td><?php echo number_format($orderdate['totalinterest'], 2, '.', ''); ?></td>
                                <td><?php echo number_format($orderdate['finalpay'], 2, '.', ''); ?></td>
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
        <a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename . 'MPDF/yearwise.php?id=' . $_REQUEST['year']; ?>"></a>
    </div>
    <?php
} elseif ($_REQUEST['month'] != '') {
//    echo $_REQUEST['year'];
    if ($_REQUEST['page'] != '') {
        $page = $_REQUEST['page'];
        $dateformate = $db->prepare("SELECT * FROM `return` LIMIT $page ");
        $dateformate->execute();
    } else {
        $dateformate = $db->prepare("SELECT * FROM `return` ");
        $dateformate->execute();
    }
//    $yearqry = $db->prepare("SELECT * FROM `return` WHERE IN `currentdate`=? ");
//    $yearqry->execute(array($_REQUEST['year']));
    ?>
    <label>Month Wise Search </label>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr align="center" style="font-size:19px;">
                    <th style="width:5%;">S.id</th>
                    <th style="width:10%">Customer ID</th>
                    <th style="width:10%">Customer Name</th>
                    <th style="width:10%">Receipt No</th>
                    <th style="width:10%">Net Weight</th>
                    <th style="width:10%">Pawn date</th>
                    <th style="width:10%">Return date</th>
                    <th style="width:10%">Days</th>
                    <th style="width:10%">Principal</th>
                    <th style="width:10%">Interest</th>
                    <th style="width:10%">Amount</th>
                   
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
                    $orderdate1 = explode('-', $orderdate['currentdate']);
                    $day = $orderdate1[0];
                    $month = $orderdate1[1];
                    $year = $orderdate1[2];
                       // echo $year;
                    if ($month == $_REQUEST['month']&& $year == $_REQUEST['page']) {

//                            echo $year;
//                            echo $orderdate['0'];
$qty = $qty + $orderdate['amount'];
                        ?>
                        <tbody>
                            <tr style="font-size:19px">
                                <td><?php echo $i; ?></td>
                                <td><?php echo getcustomer('cusid', $orderdate['customerid']); ?></td>
                                <td><?php echo $orderdate['name']; ?></td>
                                <td><?php echo getloan('receipt_no', $orderdate['loanid']); ?></td>
                                <td><?php echo $orderdate['netweight']; ?></td>
                                <td>
                                    
                                    <input type="text" style="width: 95px;" value="<?php echo $orderdate['date']; ?>" name="">
                                </td>
                                <td>
                                    
                                    <input type="text" style="width: 95px;" value="<?php echo $orderdate['currentdate']; ?>" name="">
                                </td>
                                <td><?php echo $orderdate['pawndays']; ?></td>
                                <td><?php echo $orderdate['amount']; ?></td>
                                <td><?php echo number_format($orderdate['totalinterest'], 2, '.', ''); ?></td>
                                <td><?php echo number_format($orderdate['finalpay'], 2, '.', ''); ?></td>
                               
                                <!--<td><a href=""><i class="fa fa-print"></i></a></td>-->
                            </tr>
                        </tbody>

                        <?php
                        $i++;
                    }
                }
            } else {
                echo '<label>No row displayed yet';
            }
            ?>
                        <tr><td></td><td><td></td><td><td><td></td><td><td></td></td></td></td></td><td><input type="text" readonly="" name="" value="<?php echo $qty; ?>"></td></tr>

            <tfoot>
                <tr>
                    <th colspan="5">&nbsp;</th>
    <!--                                    <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>-->
                </tr>
            </tfoot>
        </table>
        <a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename . 'MPDF/monthwise.php?id=' . $_REQUEST['month']; ?>"></a>
    </div>
    <?php
} elseif ($_REQUEST['date'] != '') {
    //echo "asd";
    $t1 = $_REQUEST['date'];
    
    $t=date("d-m-Y",strtotime($t1));
    //echo $t;
    $yearqry = $db->prepare("SELECT * FROM `return` WHERE `currentdate`=? ");
    $yearqry->execute(array($t));
    $dcount = $yearqry->rowcount();
    if ($dcount != '') {
        ?>
        <label>Date Wise Search </label>
        <div class="table-responsive">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr align="center" style="font-size:19px;">
                        <th style="width:5%;">S.id</th>
                        <th style="width:10%">Customer ID</th>
                        <th style="width:10%">Customer Name</th>
                        <th style="width:10%">Receipt No</th>
                        <th style="width:10%">Net Weight</th>
                        <th style="width:10%">Pawn date</th>
                        <th style="width:10%">Return date</th>
                        <th style="width:10%">Principal</th>
                        <th style="width:10%">Interest</th>
                        <th style="width:10%">Amount</th>
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
                            <td><?php echo getcustomer('cusid', $year['customerid']); ?></td>
                            <td><?php echo $year['name']; ?></td>
                            <td><?php echo getloan('receipt_no', $year['loanid']); ?></td>
                            <td><?php echo $year['netweight']; ?></td>
                            <td><?php echo $year['date']; ?></td>
                            <td><?php echo $year['currentdate']; ?></td>
                            <td><?php echo $year['amount']; ?></td>
                            <td><?php echo number_format($year['totalinterest'], 2, '.', ''); ?></td>
                            <td><?php echo number_format($year['finalpay'], 2, '.', ''); ?></td>
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
                }
                ?> 
                <tfoot>
                    <tr>
                        <th colspan="10">&nbsp;</th>
        <!--                                    <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>-->
                    </tr>
                </tfoot>
            </table>
            <a id="printbutton" target="_blank" class="btn btn-info fa fa-print" href="<?php echo $fsitename . 'MPDF/datewise.php?id=' . $_REQUEST['date']; ?>"></a>
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

