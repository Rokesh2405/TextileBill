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
//    $qty += $num['amount'];
//}
//echo $qty;

if ($_REQUEST['year'] != '') {
   // $dateformate = $db->prepare("SELECT * FROM `return` WHERE `status`='0' ");
     $dateformate = $db->prepare("SELECT * FROM `return` ");
   
    $dateformate->execute();
    $ycount = $dateformate->rowcount();
    if ($ycount != '') {
        while ($orderdate = $dateformate->fetch(PDO::FETCH_ASSOC)) {
//                        echo $orderdate['customerid'];
            $orderdate1 = explode('-', $orderdate['currentdate']);
            $month = $orderdate1[0];
            $day = $orderdate1[1];
            $year = $orderdate1[2];
            //echo $month;
//                        echo $year;
            if ($day == $_REQUEST['month'] && $year == $_REQUEST['year']) {
                $qty += $orderdate['amount'];
                
            }else{
//                echo "nothing";
            }
        }
    }
}else{
    echo "Select year";
}
    
    ?>
    
    
            <div class="col-md-12">
                <label>Total Principal:  <span style="color:#FF0000;"></span> </label>
                <label><?php echo $qty; ?></label>
            </div>

            <!-- <p>  Name : <?php echo $customerlist['title'] . '.' . $customerlist['officername']; ?></p>
            <p>  Phone Number: <?php echo $customerlist['phonenumber']; ?></p>
            <p> Station / Unit : <?php echo $customerlist['station']; ?></p> -->


