<?php
include ('../../config/config.inc.php');

    
    // echo $_REQUEST['incharge'];
//    $totalamount = $db->prepare("SELECT SUM(`amount`) AS `total_amount` FROM `loan` WHERE `status`=? ");
//    $totalamount->execute('1');
//    $row = $db->fetchAll(PDO::FETCH_OBJ);
//$sum = $row->total_amount;
//$query = $db->prepare("SELECT * FROM `return` WHERE `status`=0");
//$query->execute();
//
//$qty= 0;
//while ($num = $query->fetch(PDO::FETCH_ASSOC)) {
//    $qty += $num['totalinterest'];
//}
//echo $qty;
if ($_REQUEST['year'] != '') {
    $dateformate = $db->prepare("SELECT * FROM `loan` WHERE `status`='1'  ");
    $dateformate->execute();
    $ycount = $dateformate->rowcount();
    if ($ycount != '') {
        while ($orderdate = $dateformate->fetch(PDO::FETCH_ASSOC)) {
//                        echo $orderdate['customerid'];
            $orderdate1 = explode('-', $orderdate['date']);
            $month = $orderdate1[0];
            $day = $orderdate1[1];
            $year = $orderdate1[2];
//                        echo $year;
            if ($day == $_REQUEST['month']) {
//                echo $orderdate['amount'].'<br>';
//                echo $orderdate['interestpercent'];
                
                $interestcalc = ($orderdate['amount'] - $orderdate['interest']);
//                echo $interestcalc.'<br>';
               
                $qty += $interestcalc;
                
            }else{
//                echo "nothing";
            }
        }
    }
}else{
    echo "Select year";
}
//echo $qty;
//        exit;
    
    ?>
    
    
            <div class="col-md-12">
                <label>Total Interest:  <span style="color:#FF0000;"></span> </label>
                <label><?php echo $qty; ?></label>
            </div>

            <!-- <p>  Name : <?php echo $customerlist['title'] . '.' . $customerlist['officername']; ?></p>
            <p>  Phone Number: <?php echo $customerlist['phonenumber']; ?></p>
            <p> Station / Unit : <?php echo $customerlist['station']; ?></p> -->


