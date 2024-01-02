<?php

function getopeningstock($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `stocks` WHERE `company_id`=? AND `id`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delopeningstock($a) {
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $get = $db->prepare("DELETE FROM `stocks` WHERE `company_id`=? AND `id`=?");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function addopeningstocks($stockdate, $taxtype, $product_id, $product_name, $batchnumber, $qty, $packuom, $packqty, $itemuom, $totqty, $packrate, $itemrate, $spackrate, $sitemrate, $tax, $taxableamt, $taxamt, $netamt,$ip, $id) {
   
    global $db;
    if ($id == '')
    {
        $i=0;
        $product_id   = explode("#,#",$product_id);
        $product_name = explode("#,#",$product_name);
        $batchnumber  = explode("#,#",$batchnumber);
        $qty          = explode("#,#",$qty);
        $packuom      = explode("#,#",$packuom);
        $packqty      = explode("#,#",$packqty);
        $itemuom      = explode("#,#",$itemuom);
        $totqty       = explode("#,#",$totqty);
        $packrate     = explode("#,#",$packrate);
        $itemrate     = explode("#,#",$itemrate);
        $spackrate    = explode("#,#",$spackrate);
        $sitemrate    = explode("#,#",$sitemrate);
        $tax          = explode("#,#",$tax);
        $taxableamt   = explode("#,#",$taxableamt);
        $taxamt       = explode("#,#",$taxamt);
        $netamt       = explode("#,#",$netamt);
        foreach ($product_id as $product_id)
        {
            $taxx = explode("#@#", $tax[$i]);
            
            //$ress.="INSERT INTO `stock` (`Opening_Stock`,`Date`,`Product_Id`,`Product_Name`,`Batch_Number`,`PUom`,`per`,`IUom`,`Qty`,`Tot_Qty`,`Taxable_Amount`,`Tax_Amount`,`Purchase_Rate`,`Sales_Rate`,`Purchase_pack_rate`,`Sales_pack_rate`,`Tax_Id`,`Stock_Type`,`Screen`,`Total_Amount`,`Single_Piece_Rate`,`Is_Free`) VALUES ('1', date('Y-m-d', strtotime($stockdate)), trim($product_id), trim($product_name[$i]), trim($batchnumber[$i]), trim($packuom[$i]),'1', trim($itemuom[$i]), trim($qty[$i]), trim($totqty[$i]), trim($taxableamt[$i]), trim($taxamt[$i]), trim($itemrate[$i]), trim($sitemrate[$i]), trim($packrate[$i]), trim($spackrate[$i]), trim($tax[0]), 'A','OPENING STOCK', trim($netamt[$i]), trim($itemrate[$i]/$totqty[$i]),'0')";
            
            $resa = $db->prepare("INSERT INTO `stock` (`Opening_Stock`,`Date`,`TaxType`,`Product_Id`,`Product_Name`,`Batch_Number`,`PUom`,`per`,`IUom`,`Qty`,`Tot_Qty`,`Taxable_Amount`,`Tax_Amount`,`Purchase_Rate`,`Sales_Rate`,`Purchase_pack_rate`,`Sales_pack_rate`,`Tax_Id`,`Stock_Type`,`Screen`,`Total_Amount`,`Single_Piece_Rate`,`Is_Free`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            
            $resa->execute(array('1', date('Y-m-d', strtotime($stockdate)), trim($taxtype), trim($product_id), trim($product_name[$i]), trim($batchnumber[$i]), trim($packuom[$i]),'1', trim($itemuom[$i]), trim($qty[$i]), trim($totqty[$i]), trim($taxableamt[$i]), trim($taxamt[$i]), trim($itemrate[$i]), trim($sitemrate[$i]), trim($packrate[$i]), trim($spackrate[$i]), trim($taxx[0]), 'A','OPENING STOCK', trim($netamt[$i]), trim($itemrate[$i]/$totqty[$i]),'0',$_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('OpeningStock', 41, 'Insert', $_SESSION['UID'], $ip, $insert_id,$_SESSION['COMPANY_ID']));
            $i++;
        }

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted!</h4></div>';
    } else {
        $i='0';
        $product_id   = explode("#,#",$product_id);
        $product_name = explode("#,#",$product_name);
        $batchnumber  = explode("#,#",$batchnumber);
        $qty          = explode("#,#",$qty);
        $packuom      = explode("#,#",$packuom);
        $packqty      = explode("#,#",$packqty);
        $itemuom      = explode("#,#",$itemuom);
        $totqty       = explode("#,#",$totqty);
        $packrate     = explode("#,#",$packrate);
        $itemrate     = explode("#,#",$itemrate);
        $spackrate    = explode("#,#",$spackrate);
        $sitemrate    = explode("#,#",$sitemrate);
        $tax          = explode("#,#",$tax);
        $taxableamt   = explode("#,#",$taxableamt);
        $taxamt       = explode("#,#",$taxamt);
        $netamt       = explode("#,#",$netamt);
        foreach ($product_id as $product_id)
        {
            $taxx = explode("#@#", $tax[$i]);
            
            //$ress.="UPDATE `stock` SET `Opening_Stock`='1',`Date`='".date('Y-m-d', strtotime($stockdate))."',`TaxType`='".$taxtype."',`Product_Id`='".$product_id[$i]."',`Product_Name`='".$product_name[$i]."',`Batch_Number`='".$batchnumber[$i]."',`PUom`='".$packuom[$i]."',`per`='1',`IUom`='".$itemuom[$i]."',`Qty`='".$qty[$i]."',`Tot_Qty`='".$totqty[$i]."',`Taxable_Amount`='".$taxableamt[$i]."',`Tax_Amount`='".$taxamt[$i]."',`Purchase_Rate`='".$itemrate[$i]."',`Sales_Rate`='".$sitemrate[$i]."',`Purchase_pack_rate`='".$packrate[$i]."',`Sales_pack_rate`='".$spackrate[$i]."',`Tax_Id`='".$taxx[0]."',`Stock_Type`='A',`Screen`='OPENING STOCK',`Total_Amount`='".$netamt[$i]."',`Single_Piece_Rate`='".trim($itemrate[$i]/$totqty[$i])."',`Is_Free`='0' WHERE `Sid`='".$id."'";
            
            $resa = $db->prepare("UPDATE `stock` SET `Opening_Stock`=?,`Date`=?,`TaxType`=?,`Product_Id`=?,`Product_Name`=?,`Batch_Number`=?,`PUom`=?,`per`=?,`IUom`=?,`Qty`=?,`Tot_Qty`=?,`Taxable_Amount`=?,`Tax_Amount`=?,`Purchase_Rate`=?,`Sales_Rate`=?,`Purchase_pack_rate`=?,`Sales_pack_rate`=?,`Tax_Id`=?,`Stock_Type`=?,`Screen`=?,`Total_Amount`=?,`Single_Piece_Rate`=?,`Is_Free`=? WHERE `company_id`=? AND `Sid`=?");
            
            $resa->execute(array('1', date('Y-m-d', strtotime($stockdate)), trim($taxtype), trim($product_id[$i]), trim($product_name[$i]), trim($batchnumber[$i]), trim($packuom[$i]),'1', trim($itemuom[$i]), trim($qty[$i]), trim($totqty[$i]), trim($taxableamt[$i]), trim($taxamt[$i]), trim($itemrate[$i]), trim($sitemrate[$i]), trim($packrate[$i]), trim($spackrate[$i]), trim($taxx[0]), 'A','OPENING STOCK', trim($netamt[$i]), trim($itemrate[$i]/$totqty[$i]),'0',$_SESSION['COMPANY_ID'], $id));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('OpeningStock', 41, 'Update', $_SESSION['UID'], $ip, $insert_id,$_SESSION['COMPANY_ID']));
            $i++;
        }
        
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}

function addopeningstock($stockdate, $taxtype, $product_id, $product_name, $batchnumber, $qty, $packuom, $packqty, $itemuom, $totqty, $packrate, $itemrate, $spackrate, $sitemrate, $tax, $taxableamt, $taxamt, $netamt,$ip, $id) {
   
    global $db;
    if ($id == '')
    {
        $i=0;
        $product_id   = explode("#,#",$product_id);
        $product_name = explode("#,#",$product_name);
        $batchnumber  = explode("#,#",$batchnumber);
        $qty          = explode("#,#",$qty);
        $packuom      = explode("#,#",$packuom);
        $packqty      = explode("#,#",$packqty);
        $itemuom      = explode("#,#",$itemuom);
        $totqty       = explode("#,#",$totqty);
        $packrate     = explode("#,#",$packrate);
        $itemrate     = explode("#,#",$itemrate);
        $spackrate    = explode("#,#",$spackrate);
        $sitemrate    = explode("#,#",$sitemrate);
        $tax          = explode("#,#",$tax);
        $taxableamt   = explode("#,#",$taxableamt);
        $taxamt       = explode("#,#",$taxamt);
        $netamt       = explode("#,#",$netamt);
        foreach ($product_id as $product_id)
        {
            $taxx = explode("#@#", $tax[$i]);
             list($taxtype, $product_id, $packuom[$i], $itemuom[$i], $qty[$i], $totqty[$i], $taxableamt[$i], $taxamt[$i], $itemrate[$i], $packrate[$i], $netamt[$i], $packqty[$i]) = null_zero(array($taxtype, $product_id, $packuom[$i], $itemuom[$i], $qty[$i], $totqty[$i], $taxableamt[$i], $taxamt[$i], $itemrate[$i], $packrate[$i], $netamt[$i], $packqty[$i]));	
    
             $svl = $itemrate[$i]/$totqty[$i];
             list($svl) = null_zero(array($svl));
            //$ress.="INSERT INTO `stock` (`Opening_Stock`,`Date`,`Product_Id`,`Product_Name`,`Batch_Number`,`PUom`,`per`,`IUom`,`Qty`,`Tot_Qty`,`Taxable_Amount`,`Tax_Amount`,`Purchase_Rate`,`Sales_Rate`,`Purchase_pack_rate`,`Sales_pack_rate`,`Tax_Id`,`Stock_Type`,`Screen`,`Total_Amount`,`Single_Piece_Rate`,`Is_Free`) VALUES ('1', date('Y-m-d', strtotime($stockdate)), trim($product_id), trim($product_name[$i]), trim($batchnumber[$i]), trim($packuom[$i]),'1', trim($itemuom[$i]), trim($qty[$i]), trim($totqty[$i]), trim($taxableamt[$i]), trim($taxamt[$i]), trim($itemrate[$i]), trim($sitemrate[$i]), trim($packrate[$i]), trim($spackrate[$i]), trim($tax[0]), 'A','OPENING STOCK', trim($netamt[$i]), trim($itemrate[$i]/$totqty[$i]),'0')";
            
            $resa = $db->prepare("INSERT INTO `stocks` SET `opening_stock`=?,`date`=?,`tax`=?,`proid`=?,`batch`=?,`package_uom`=?,`unitperpack`=?,`unit_uom`=?,`qty`=?,`total_qty`=?,`taxableamt`=?,`taxamt`=?,`pur_rate`=?,`packrate`=?,`taxid`=?,`stocktype`=?,`type`=?,`screen`=?,`amount`=?,`salitemrate`=?,`perqty`=?,`company_id`=? ");
         // print_r(array('1', date('Y-m-d', strtotime($stockdate)), trim($taxtype), trim($product_id), trim($batchnumber[$i]), trim($packuom[$i]),'1', trim($itemuom[$i]), trim($qty[$i]), trim($totqty[$i]), trim($taxableamt[$i]), trim($taxamt[$i]), trim($itemrate[$i]), trim($packrate[$i]), trim($taxx[0]), 'A','opening_stock', trim($netamt[$i]), trim($itemrate[$i]/$totqty[$i]),$packqty[$i]));
            $resa->execute(array('1', date('Y-m-d', strtotime($stockdate)), trim($taxtype), trim($product_id), trim($batchnumber[$i]), trim($packuom[$i]),'1', trim($itemuom[$i]), trim($qty[$i]), trim($totqty[$i]), trim($taxableamt[$i]), trim($taxamt[$i]), trim($itemrate[$i]), trim($packrate[$i]), trim($taxx[0]), 'A','OS','opening_stock', trim($netamt[$i]), trim($svl),$packqty[$i],$_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $i++;
        }

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted!</h4></div>';
    } else {
        $i='0';
        $product_id   = explode("#,#",$product_id);
        $product_name = explode("#,#",$product_name);
        $batchnumber  = explode("#,#",$batchnumber);
        $qty          = explode("#,#",$qty);
        $packuom      = explode("#,#",$packuom);
        $packqty      = explode("#,#",$packqty);
        $itemuom      = explode("#,#",$itemuom);
        $totqty       = explode("#,#",$totqty);
        $packrate     = explode("#,#",$packrate);
        $itemrate     = explode("#,#",$itemrate);
        $spackrate    = explode("#,#",$spackrate);
        $sitemrate    = explode("#,#",$sitemrate);
        $tax          = explode("#,#",$tax);
        $taxableamt   = explode("#,#",$taxableamt);
        $taxamt       = explode("#,#",$taxamt);
        $netamt       = explode("#,#",$netamt);
        foreach ($product_id as $product_id)
        {
            $taxx = explode("#@#", $tax[$i]);
			 list($taxtype, $product_id, $packuom[$i], $itemuom[$i], $qty[$i], $totqty[$i], $taxableamt[$i], $taxamt[$i], $itemrate[$i], $packrate[$i], $netamt[$i], $packqty[$i]) = null_zero(array($taxtype, $product_id, $packuom[$i], $itemuom[$i], $qty[$i], $totqty[$i], $taxableamt[$i], $taxamt[$i], $itemrate[$i], $packrate[$i], $netamt[$i], $packqty[$i]));	
    
            //$ress.="UPDATE `stock` SET `Opening_Stock`='1',`Date`='".date('Y-m-d', strtotime($stockdate))."',`TaxType`='".$taxtype."',`Product_Id`='".$product_id[$i]."',`Product_Name`='".$product_name[$i]."',`Batch_Number`='".$batchnumber[$i]."',`PUom`='".$packuom[$i]."',`per`='1',`IUom`='".$itemuom[$i]."',`Qty`='".$qty[$i]."',`Tot_Qty`='".$totqty[$i]."',`Taxable_Amount`='".$taxableamt[$i]."',`Tax_Amount`='".$taxamt[$i]."',`Purchase_Rate`='".$itemrate[$i]."',`Sales_Rate`='".$sitemrate[$i]."',`Purchase_pack_rate`='".$packrate[$i]."',`Sales_pack_rate`='".$spackrate[$i]."',`Tax_Id`='".$taxx[0]."',`Stock_Type`='A',`Screen`='OPENING STOCK',`Total_Amount`='".$netamt[$i]."',`Single_Piece_Rate`='".trim($itemrate[$i]/$totqty[$i])."',`Is_Free`='0' WHERE `Sid`='".$id."'";   
             $svl = $itemrate[$i]/$totqty[$i];
             list($svl) = null_zero(array($svl));
            
           $resa = $db->prepare("UPDATE `stocks` SET `opening_stock`=?,`date`=?,`tax`=?,`proid`=?,`batch`=?,`package_uom`=?,`unitperpack`=?,`unit_uom`=?,`qty`=?,`total_qty`=?,`taxableamt`=?,`taxamt`=?,`pur_rate`=?,`packrate`=?,`taxid`=?,`stocktype`=?,`type`=?,`screen`=?,`amount`=?,`salitemrate`=?,`perqty`=? WHERE `company_id`=? AND `id`=?");
            
            $resa->execute(array('1', date('Y-m-d', strtotime($stockdate)), trim($taxtype), trim($product_id), trim($batchnumber[$i]), trim($packuom[$i]),'1', trim($itemuom[$i]), trim($qty[$i]), trim($totqty[$i]), trim($taxableamt[$i]), trim($taxamt[$i]), trim($itemrate[$i]), trim($packrate[$i]), trim($taxx[0]), 'A','OS','opening_stock', trim($netamt[$i]), $svl,$packqty[$i], $_SESSION['COMPANY_ID'], $id));
            $i++;
        }
        
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}

?>