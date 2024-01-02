<?php
include ('../../config/config.inc.php');

    
    // echo $_REQUEST['incharge'];
//    $totalamount = $db->prepare("SELECT SUM(`amount`) AS `total_amount` FROM `loan` WHERE `status`=? ");
//    $totalamount->execute('1');
//    $row = $db->fetchAll(PDO::FETCH_OBJ);
//$sum = $row->total_amount;
$query = $db->prepare("SELECT * FROM `bankstatus`");
$query->execute();

$qty= 0;
while ($num = $query->fetch(PDO::FETCH_ASSOC)) {
    $qty += $num['amount'];
}
//echo $qty;
    
    ?>
    
    
            <div class="col-md-12">
                <label>Total Amount:  <span style="color:#FF0000;"></span> </label>
                <label><?php echo $qty; ?></label>
            </div>

            <!-- <p>  Name : <?php echo $customerlist['title'] . '.' . $customerlist['officername']; ?></p>
            <p>  Phone Number: <?php echo $customerlist['phonenumber']; ?></p>
            <p> Station / Unit : <?php echo $customerlist['station']; ?></p> -->


