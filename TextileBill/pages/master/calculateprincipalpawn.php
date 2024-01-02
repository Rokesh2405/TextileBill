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
echo "test";
    // echo $_REQUEST['month'];
    $dateformate = $db->prepare("SELECT * FROM `loan` WHERE `status`='1' ");
    $dateformate->execute();

    while ($orderdate = $dateformate->fetch(PDO::FETCH_ASSOC)) {
        // echo $orderdate['date'];
        $orderdate1 = explode('-', $orderdate['date']);
        $month = $orderdate1[0];
        $day = $orderdate1[1];
        $year = $orderdate1[2];
        // echo $day.'<br>';
        if ($day == $_REQUEST['month']) {

            //$dateformate1 = $db->prepare("SELECT * FROM `loan` WHERE `date` LIKE '%" . $_REQUEST['month'] . "-" . $_REQUEST['year'] . "' AND `status` = '1'");
            $dateformate1 = $db->prepare("SELECT * FROM `loan` WHERE `date` LIKE '".$_REQUEST['year']."-".$_REQUEST['month']."%' AND `status` = '1'");

            $dateformate1->execute();
        }
    }
    // echo $month.'<br>';
    // echo $_REQUEST['month'];

    while ($orderdate2 = $dateformate1->fetch(PDO::FETCH_ASSOC)) {

        $qty += $orderdate2['amount'];
        // echo $qty;
    }
} else {
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


