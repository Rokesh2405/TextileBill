<?php
include ('../../config/config.inc.php');

if ($_REQUEST['year'] != '') {
//    echo $_REQUEST['year'].'<br>';
//    echo $_REQUEST['month'].'<br>';
//    echo $_REQUEST['status'];
    $dateformate = $db->prepare("SELECT * FROM `bankstatus` WHERE `status`='1'");
    $dateformate->execute();
    while ($orderdate = $dateformate->fetch(PDO::FETCH_ASSOC)) {


        // echo $orderdate['date'];
        $orderdate1 = explode('-', $orderdate['dateofpawn']);
        $month = $orderdate1[0];
        $day = $orderdate1[1];
        $year = $orderdate1[2];
//         echo $day.'<br>';
//         echo $_REQUEST['month'];     
        if ($day == $_REQUEST['month']) {
            $qty += $orderdate['totalamount'];
        }
    }
    // echo $dcount;
}
?>


<div class="col-md-12">
    <label>Total Amount:  <span style="color:#FF0000;"></span> </label>
    <label><?php echo $qty; ?></label>
</div>

                <!-- <p>  Name : <?php echo $customerlist['title'] . '.' . $customerlist['officername']; ?></p>
                <p>  Phone Number: <?php echo $customerlist['phonenumber']; ?></p>
                <p> Station / Unit : <?php echo $customerlist['station']; ?></p> -->


