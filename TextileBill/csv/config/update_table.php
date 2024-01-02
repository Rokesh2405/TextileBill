<?php
/*include "config.inc.php";
$dbname = 'impaerp';
$sql = "SHOW TABLES FROM $dbname";
$result = $db->prepare($sql);
$result->execute();
while ($row = $result->fetch()) {
    echo "Table: {$row[0]}\n";
    
   // mysql_query("update $row[0] set `company_id`='2772',`company_admin`='2772'");
     $data = $db->prepare("ALTER TABLE `$row[0]` ADD `inserted_user_id` INT(11) NOT NULL DEFAULT '0' ;");
     $data->execute();
    
}*/
include "config.inc.php";

function update_pono($pon,$podate,$postatus,$poref,$table,$id){
    global $db;
    $po = $table == 'sales_order' ? 'po_ref_no' : 'ref_no';
    $up = $db->prepare("UPDATE `$table` SET `PONumber`='$pon',`PODate`='".date("Y-m-d",strtotime($podate))."',`status_approve`='$postatus',`$po`='$poref' WHERE `PoID`='$id'");
    $up->execute();
    $up = $db->prepare("UPDATE `".$table."_details` SET `PONum`='$pon' WHERE `PoID`='$id'");
    $up->execute();
}

$sql = "SELECT * FROM `sales_quote` WHERE `Converted`='1'";
$result = $db->prepare($sql);
$result->execute();
while ($quote = $result->fetch()) {
    if($quote['converted_sales_order_id'] > 0){
        $so_id = $quote['converted_sales_order_id'];
        $so_qry = $db->prepare("SELECT * FROM `sales_order` WHERE `PoID`='$so_id'");
        $so_qry->execute();
        if($so_qry->rowCount() > 0) {
            $so = $so_qry->fetch();
            delsalesorder($so_id);
            $sonewid = ConverttoSalesorder($quote['PoID'],'1');
            update_pono($so['PONumber'],$so['PODate'],$so['status_approve'],$so['po_ref_no'],'sales_order',$sonewid);  
            echo 'delso='.$so_id.'===create='.$sonewid.'<br>';
            if($so['Converted'] == '1'){
                $dn_id = $so['converted_delivery_note_id'];
                $dn_qry = $db->prepare("SELECT * FROM `delivery_note` WHERE `PoID`='$dn_id'");
                $dn_qry->execute();
                if($dn_qry->rowCount() > 0) {
                    $dn = $dn_qry->fetch();
                    deldeliverynote($dn_id);
                    $dnnewid = ConvertoDeliveryNote($sonewid,'1');
                    update_pono($dn['PONumber'],$dn['PODate'],$dn['status_approve'],$dn['ref_no'],'delivery_note',$dnnewid);
                    echo 'deldn='.$dn_id.'===create='.$dnnewid.'<br>';
                    if($dn['Converted'] == '1'){
                        $iv_id = $dn['converted_invoice_id'];
                        $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
                        $iv_qry->execute();
                        if($iv_qry->rowCount() > 0) {
                            $iv = $iv_qry->fetch();
                            delinvoice($iv_id);
                            $ivnewid = ConvertoInvoice($dnnewid,'1');
                            update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);  
                            echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
                        }
                    }
                }
            }
            if($so['Converted_invoice'] == '1'){                
                $iv_id = $so['converted_invoice_id'];
                $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
                $iv_qry->execute();
                if($iv_qry->rowCount() > 0) {
                    $iv = $iv_qry->fetch();
                    delinvoice($iv_id);
                    $ivnewid = ConvertoInvoiceFromSO($sonewid,'1');
                    update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);
                    echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
                }
            }
        }
    }
}

$sql = "SELECT * FROM `sales_order` WHERE (`Converted`='1' OR `Converted_invoice`='1')";
$result = $db->prepare($sql);
$result->execute();
while ($order = $result->fetch()) {
    if($order['Converted'] == '1'){
        $dn_id = $order['converted_delivery_note_id'];
        $dn_qry = $db->prepare("SELECT * FROM `delivery_note` WHERE `PoID`='$dn_id'");
        $dn_qry->execute();
        if($dn_qry->rowCount() > 0) {
            $dn = $dn_qry->fetch();
            deldeliverynote($dn_id);
            $dnnewid = ConvertoDeliveryNote($order['PoID'],'1');
            update_pono($dn['PONumber'],$dn['PODate'],$dn['status_approve'],$dn['ref_no'],'delivery_note',$dnnewid);
            echo 'deldn='.$dn_id.'===create='.$dnnewid.'<br>';
            if($dn['Converted'] == '1'){
                $iv_id = $dn['converted_invoice_id'];
                $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
                $iv_qry->execute();
                if($iv_qry->rowCount() > 0) {
                    $iv = $iv_qry->fetch();
                    delinvoice($iv_id);
                    $ivnewid = ConvertoInvoice($dnnewid,'1');
                    update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);  
                    echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
                }
            }
        }
    }
    if($order['Converted_invoice'] == '1'){                
        $iv_id = $order['converted_invoice_id'];
        $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
        $iv_qry->execute();
        if($iv_qry->rowCount() > 0) {
            $iv = $iv_qry->fetch();
            delinvoice($iv_id);
            $ivnewid = ConvertoInvoiceFromSO($order['PoID'],'1');
            update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);
            echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
        }
    }        
}

$sql = "SELECT * FROM `delivery_note` WHERE `Converted`='1'";
$result = $db->prepare($sql);
$result->execute();
while ($delivery = $result->fetch()) {
    if($delivery['Converted'] == '1'){
        $iv_id = $delivery['converted_invoice_id'];
        $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
        $iv_qry->execute();
        if($iv_qry->rowCount() > 0) {
            $iv = $iv_qry->fetch();
            delinvoice($iv_id);
            $ivnewid = ConvertoInvoice($delivery['PoID'],'1');
            update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);  
            echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
        }
    }
}

//Converted but converted=0

$sql = "SELECT so.* FROM `sales_order` as so INNER JOIN `sales_quote` as sq ON(so.Sales_quote = sq.PoID) WHERE `sq`.Converted!='1'";
$result = $db->prepare($sql);
$result->execute();
while ($quote = $result->fetch()) {        
    $so_id = $quote['PoID'];
    $so_qry = $db->prepare("SELECT * FROM `sales_order` WHERE `PoID`='$so_id'");
    $so_qry->execute();
    if($so_qry->rowCount() > 0) {
        $so = $so_qry->fetch();
        delsalesorder($so_id);
        $sonewid = ConverttoSalesorder($quote['Sales_quote'],'1');
        update_pono($so['PONumber'],$so['PODate'],$so['status_approve'],$so['po_ref_no'],'sales_order',$sonewid);  
        echo 'delso='.$so_id.'===create='.$sonewid.'<br>';
        if($so['Converted'] == '1'){
            $dn_id = $so['converted_delivery_note_id'];
            $dn_qry = $db->prepare("SELECT * FROM `delivery_note` WHERE `PoID`='$dn_id'");
            $dn_qry->execute();
            if($dn_qry->rowCount() > 0) {
                $dn = $dn_qry->fetch();
                deldeliverynote($dn_id);
                $dnnewid = ConvertoDeliveryNote($sonewid,'1');
                update_pono($dn['PONumber'],$dn['PODate'],$dn['status_approve'],$dn['ref_no'],'delivery_note',$dnnewid);
                echo 'deldn='.$dn_id.'===create='.$dnnewid.'<br>';
                if($dn['Converted'] == '1'){
                    $iv_id = $dn['converted_invoice_id'];
                    $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
                    $iv_qry->execute();
                    if($iv_qry->rowCount() > 0) {
                        $iv = $iv_qry->fetch();
                        delinvoice($iv_id);
                        $ivnewid = ConvertoInvoice($dnnewid,'1');
                        update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);  
                        echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
                    }
                }
            }
        }
        if($so['Converted_invoice'] == '1'){                
            $iv_id = $so['converted_invoice_id'];
            $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
            $iv_qry->execute();
            if($iv_qry->rowCount() > 0) {
                $iv = $iv_qry->fetch();
                delinvoice($iv_id);
                $ivnewid = ConvertoInvoiceFromSO($sonewid,'1');
                update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);
                echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
            }
        }
    } 
}

$sql = "SELECT dn.* FROM `delivery_note` as dn INNER JOIN `sales_order` as so ON(dn.Sales_order = so.PoID) WHERE `so`.Converted!='1'";
$result = $db->prepare($sql);
$result->execute();
while ($order = $result->fetch()) {    
    $dn_id = $order['PoID'];
    $dn_qry = $db->prepare("SELECT * FROM `delivery_note` WHERE `PoID`='$dn_id'");
    $dn_qry->execute();
    if($dn_qry->rowCount() > 0) {
        $dn = $dn_qry->fetch();
        deldeliverynote($dn_id);
        $dnnewid = ConvertoDeliveryNote($order['Sales_order'],'1');
        update_pono($dn['PONumber'],$dn['PODate'],$dn['status_approve'],$dn['ref_no'],'delivery_note',$dnnewid);
        echo 'deldn='.$dn_id.'===create='.$dnnewid.'<br>';
        if($dn['Converted'] == '1'){
            $iv_id = $dn['converted_invoice_id'];
            $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
            $iv_qry->execute();
            if($iv_qry->rowCount() > 0) {
                $iv = $iv_qry->fetch();
                delinvoice($iv_id);
                $ivnewid = ConvertoInvoice($dnnewid,'1');
                update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);  
                echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
            }
        }
    }               
}

$sql = "SELECT iv.* FROM `invoice` as iv INNER JOIN `sales_order` as so ON(iv.Sales_order = so.PoID) WHERE `so`.Converted_invoice!='1'";
$result = $db->prepare($sql);
$result->execute();
while ($order = $result->fetch()) {                  
    $iv_id = $order['PoID'];
    $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
    $iv_qry->execute();
    if($iv_qry->rowCount() > 0) {
        $iv = $iv_qry->fetch();
        delinvoice($iv_id);
        $ivnewid = ConvertoInvoiceFromSO($order['Sales_order'],'1');
        update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);
        echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
    }    
}

$sql = "SELECT iv.* FROM `invoice` as iv INNER JOIN `delivery_note` as dn ON(iv.Delivery_note = dn.PoID) WHERE `dn`.Converted!='1'";
$result = $db->prepare($sql);
$result->execute();
while ($order = $result->fetch()) {                  
    $iv_id = $order['PoID'];
    $iv_qry = $db->prepare("SELECT * FROM `invoice` WHERE `PoID`='$iv_id'");
    $iv_qry->execute();
    if($iv_qry->rowCount() > 0) {
        $iv = $iv_qry->fetch();
        delinvoice($iv_id);
        $ivnewid = ConvertoInvoice($order['Delivery_note'],'1');
        update_pono($iv['PONumber'],$iv['PODate'],$iv['status_approve'],$iv['ref_no'],'invoice',$ivnewid);
        echo 'deliv='.$iv_id.'===create='.$ivnewid.'<br>';
    }    
}
?>
