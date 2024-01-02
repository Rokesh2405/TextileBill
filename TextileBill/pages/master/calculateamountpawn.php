<?php
include ('../../config/config.inc.php');

//    
//     echo $_REQUEST['incharge'];
//    $totalamount = $db->prepare("SELECT SUM(`amount`) AS `total_amount` FROM `loan` WHERE `status`=? ");
//    $totalamount->execute('1');
//    $row = $db->fetchAll(PDO::FETCH_OBJ);
//$sum = $row->total_amount;
//if ($_REQUEST['year'] != '') {
//    $dateformate = $db->prepare("SELECT * FROM `return` WHERE `status`=0");
//    $dateformate->execute();
//    $qry = 0;
//
//    while ($orderdate = $dateformate->fetch(PDO::FETCH_ASSOC)) {
//        if (preg_match('#^(\d{2})-(\d{2})-(\d{4})$#', $orderdate['currentdate'], $matches)) {
//            $month = $matches[1];
//            $day = $matches[2];
//            $year = $matches[3];
////    echo $day;
//            if ($day == $_REQUEST['month'] || $year == $_REQUEST['year']) {
//                echo $day;
//                echo $year;
//                exit;
//                
////                echo $_REQUEST['month'];
////                echo $_REQUEST['year'];
//
//                $qry1 = $db->prepare("SELECT * FROM `return` WHERE MONTH(`currentdate`)=".$_REQUEST['month']." OR YEAR(`currentdate`)=".$_REQUEST['year']." ");
//                $qry1->execute();
//
//                while ($qry2 = $qry1->fetch(PDO::FETCH_ASSOC)) {
//                    $qty += $qry2['finalpay'];
//                }
////        echo $day.'<br>';
////        echo $_REQUEST['month'];
////           
//            }
//        }
//    }
//} else {
//    echo 'Select Year';
//}
//$orderdate1 = explode('-', $orderdate['currentdate']);
//                    $month = $orderdate1[0];
//                    $day = $orderdate1[1];
//                    $year = $orderdate1[2];
//                    echo $day .'<br>';
//                    echo $_REQUEST['month'];
//$query = $db->prepare("SELECT * FROM `return` WHERE `status`=0");
//$query->execute();
//$qty= 0;
//while ($num = $dateformate->fetch(PDO::FETCH_ASSOC)) {
//   
//
//}
//echo $qty;
//$monthwise = $db->prepare("SELECT * FROM `return` WHERE MONTH(`currentdate`)=?");
//$monthwise->execute(array($_REQUEST['month']));
//
//while($month = $monthwise->fetch(PDO::FETCH_ASSOC)){
//    echo $month['currentdate'];
//    
//}

if ($_REQUEST['year'] != '') {
    $dateformate = $db->prepare("SELECT * FROM `loan` WHERE `status`='1' AND `returnstatus`='2' ");
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
                <label>Total Amount:  <span style="color:#FF0000;"></span> </label>
                <label><?php echo $qty; ?></label>
            </div>

                        <!-- <p>  Name : <?php echo $customerlist['title'] . '.' . $customerlist['officername']; ?></p>
                        <p>  Phone Number: <?php echo $customerlist['phonenumber']; ?></p>
                        <p> Station / Unit : <?php echo $customerlist['station']; ?></p> -->


