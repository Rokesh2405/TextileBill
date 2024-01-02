 <?php
include ('../../config/config.inc.php');


if ($_REQUEST['sonc'] == 'supid') {
$fvalue="";
$value=0;
$date="";
$objectid="";
$supid1=""
//    echo $_REQUEST['customerid'];
//    exit;
    
    // echo $_REQUEST['incharge'];
    // $customerlist = FETCH_all("SELECT * FROM `loan` WHERE `status`=? AND `id` =? ", '1', $_REQUEST['customerid']);
    ?>
    
            <option value="0">Select</option>
            <?php
    $customerlist = pFETCH("SELECT * FROM `supplier` WHERE `suppliername`=?",$_REQUEST['customerid']);
            while ($objectfetch = $customerlist->fetch(PDO::FETCH_ASSOC)) {

//                echo $objectfetch['receipt_no'];
                
        $purchaseid = pFETCH("SELECT * FROM `purchase` WHERE `supplierid`=?",$objectfetch['id']);
        while ($objectfetch1 = $purchaseid->fetch(PDO::FETCH_ASSOC)) {
            $supid1=$objectfetch1['id'];
        $purchase_objid = pFETCH("SELECT * FROM `purchase_object_detail` WHERE `object_id`=?",$objectfetch1['id']);
            while ($objectfetch2 = $purchase_objid->fetch(PDO::FETCH_ASSOC)) {
                $value=$objectfetch2['pquantity'];
                $date=$objectfetch2['pdate'];
                $objectid=$objectfetch2['object'];
                $date1=explode(" ",$date);
                $date=$date1[0];
                $fvalue=$value.",".$date.",".$objectid.",".$supid1;
    $silver_objid = pFETCH("SELECT * FROM `silverobject` WHERE `id`=?",$objectfetch2['object']);
            while ($objectfetch3 = $silver_objid->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fvalue.','.$objectfetch3['objectname']; ?>" >
                    <?php echo $objectfetch3['objectname'] ?>
                        
                    </option>
            <?php 
        }
        }
        } 
        }
            ?>               
       

    
    <?php
}
else if ($_REQUEST['sonc1']=="purid")
{

    $silver_objid = pFETCH("SELECT * FROM `silverobject` WHERE `objectname`=?",$_REQUEST['customerid1']);
        while ($objectfetch3 = $silver_objid->fetch(PDO::FETCH_ASSOC)) {
            $pd1 = pFETCH("SELECT * FROM `purchase_object_detail` WHERE `object`=?",$objectfetch3['id']);
             while ($pd2 = $pd1->fetch(PDO::FETCH_ASSOC)) {
                $pd11 = pFETCH("SELECT * FROM `purchase` WHERE `id`=?",$pd2['object_id']);
                while ($pd22 = $pd11->fetch(PDO::FETCH_ASSOC)) {
                echo $pd22['date']."      ";
                }    
            }
        }
}
?>
<?php
$fvalue="";
$value=0;
$date="";
$objectid="";
if ($_REQUEST['sale1']=="cusid"){
    $date="";
    ?>
            <option value="0">
           Select
            </option>
            <?php
            $salelist = pFETCH("SELECT * FROM `sales_object_detail` WHERE `object_id`=?",$_REQUEST['cusid']);
            while ($objectfetch = $salelist->fetch(PDO::FETCH_ASSOC)) {
                $value=$objectfetch['squantity'];
                $date=$objectfetch['sdate'];
                $objectid=$objectfetch['object'];
                $date1=explode(" ",$date);
                $date=$date1[0];
                $fvalue=$value.",".$date.",".$objectid;
            $silver_objid = pFETCH("SELECT * FROM `silverobject` WHERE `id`=?",$objectfetch['object']);
            while ($objectfetch3 = $silver_objid->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $fvalue.','.$objectfetch3['objectname']; ?>" >
                    <?php echo $objectfetch3['objectname'] ?>
                        
                    </option>
            <?php 
        }
        } 
        }
            ?>      
 <?php 
if ($_REQUEST['sale2']=="supid")
{

    $silver_objid = pFETCH("SELECT * FROM `silverobject` WHERE `objectname`=?",$_REQUEST['silvername']);
        while ($objectfetch3 = $silver_objid->fetch(PDO::FETCH_ASSOC)) {
            $pd1 = pFETCH("SELECT * FROM `sales_object_detail` WHERE `object`=?",$objectfetch3['id']);
             while ($pd2 = $pd1->fetch(PDO::FETCH_ASSOC)) {
                $pd11 = pFETCH("SELECT * FROM `sales` WHERE `id`=?",$pd2['object_id']);
                while ($pd22 = $pd11->fetch(PDO::FETCH_ASSOC)) {
                echo $pd22['date']." ,  ";
                }    
            }
        }
}
if ($_REQUEST['sale3']=="supid1")
{ 
    $qty=0;
    $silver_objid1= pFETCH("SELECT * FROM `silverobject` WHERE `objectname`=?",$_REQUEST['quantity']);
        while ($objectfetch33 = $silver_objid1->fetch(PDO::FETCH_ASSOC)) { 
            $pd11 = pFETCH("SELECT * FROM `sales_object_detail` WHERE `object`=?",$objectfetch33['id']);
             while ($pd22 = $pd11->fetch(PDO::FETCH_ASSOC)) {
                $qty+=$pd22['squantity'];
                }    
                echo $qty;
            }
}
?>
