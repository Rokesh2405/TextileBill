<?php
include ('../../config/config.inc.php');


if ($_REQUEST['customerid'] != '') {
//    echo $_REQUEST['customerid'];
//    exit;
    
    // echo $_REQUEST['incharge'];
    // $customerlist = FETCH_all("SELECT * FROM `loan` WHERE `status`=? AND `id` =? ", '1', $_REQUEST['customerid']);
    ?>
  
            <option value="">Select</option>
            <?php
            // $object = pFETCH("SELECT * FROM `loan` WHERE `status`=?", '1');
        //    echo "SELECT * FROM `loan` WHERE `status`='1' AND `cusid` ='".$_REQUEST['customerid']."' " ;
            $customerlist = pFETCH("SELECT * FROM `loan` WHERE `status`=? AND `cusid` =? AND `returnstatus`=? ", '1', $_REQUEST['customerid'], '2');
            while ($objectfetch = $customerlist->fetch(PDO::FETCH_ASSOC)) {
//                echo $objectfetch['receipt_no'];
                ?>
                <option value="<?php echo $objectfetch['id']; ?>" <?php if (getloan('receipt_no', $_REQUEST['cid']) == $objectfetch['id'] ) { ?> selected <?php } ?>><?php echo $objectfetch['receipt_no']; ?></option>
            <?php } ?>               
       

    
    <?php
}
?>

