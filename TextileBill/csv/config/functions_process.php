<?php

/* Purchase Enquiry start here */

function addpurchaseEnquiry($invno, $billdate, $taxtype, $status_app,$ref_text, $customer, $netpayamt, $subtotal, $subtaxtotal, $product_suppliers,$Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty,$Margin,$product_rate_hidden, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $CusID,$icurrency,$Comments, $id) {
    global $db;
    $icurrency = getcustomer('Currency', $CusID);
    if ($deliveryterms == '') {
        $deliveryterms = 0;
    }
    if ($modeofshipment == '') {
        $modeofshipment = 0;
    }
    if ($enquirycurrency == '') {
        $enquirycurrency = 0;
    }
    if ($modeofpayment == '') {
        $modeofpayment = 0;
    }
    if ($paymentterms == '') {
        $paymentterms = 0;
    }
    if ($enquirytype == '') {
        $enquirytype = 0;
    }
    if ($vessel == '') {
        $vessel = 0;
    }
    if ($salesrep == '') {
        $salesrep = 0;
    }

    if ($id == '') {
        try {
            $db->beginTransaction();
            $invno = get_bill_settings('prefix', '1') . str_pad(get_bill_settings('current_value', '1'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
            $resa = $db->prepare("INSERT INTO  `purchase_enquiry` (`PONumber`,`PODate`,`TaxType`,`status_approve`,`ref_text`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID), $status_app, $ref_text,$CusID, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep,$ip, $_SESSION['UID'],$_SESSION['COMPANY_ID']));

            $insert_id = $db->lastInsertId();
            $i = 0; $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($taxname) = null_zero(explode("#@#", $tax[$i]));
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency));
                $resa = $db->prepare("INSERT INTO `purchase_enquiry_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`, `Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                $neinsid = $db->lastInsertId();
                
                if($product_suppliers[$i]!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=?,`company_id`=?");
                    $sim->execute(array('enquiry', $insert_id,$neinsid, $Item_name[$i], $product_suppliers[$i], $_SERVER['REMOTE_ADDR'],$_SESSION['COMPANY_ID']));                
                }
                $i++;
            }
                        
            
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Purchase Enquiry', 2, 'Insert', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            update_bill_value('1');
            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $_SESSION['sucmsg'] = $res;
        } catch (PDOException $e) {
            $db->rollBack();
            $res = $e->getMessage();
        }
    } else {
        try {
            $db->beginTransaction();
            //$invno = get_bill_settings('prefix', '1') . str_pad(get_bill_settings('current_value', '1'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
            $resa = $db->prepare("UPDATE `purchase_enquiry` SET `CusID`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`status_approve`=?,`ref_text`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`IP`=?,`Updated_by`=? Where `company_id`=? AND `PoID`=?");
            $resa->execute(array($CusID, $invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID), $status_app,$ref_text, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $ip, $_SESSION['UID'],$_SESSION['COMPANY_ID'], $id));
            $i = 0;
            $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency));
                if ($purchase_detailid[$i] == 'NEW') {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("INSERT INTO `purchase_enquiry_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                 
                    $neinsid = $db->lastInsertId();
                    if($product_suppliers[$i]!=''){
                        $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=?,`company_id`=? ");
                        $sim->execute(array('enquiry', $id,$neinsid, $Item_name[$i], $product_suppliers[$i], $_SERVER['REMOTE_ADDR'], $_SESSION['COMPANY_ID']));                
                    }
                } else {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("UPDATE `purchase_enquiry_details` SET `PoNum`=?, `PoID`=?, `Item`=?,`supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?,`Margin`=?,`product_rate_hidden`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=?, `IP`=?,`Currency`=?, `Comments`=?, `display_order`=?  WHERE `company_id`=? AND `PdID`=?");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID'], $purchase_detailid[$i]));
                }
                $i++;
            }
            
            /*foreach($product_suppliers as $s => $product_supplierss){
                if($product_supplierss!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`product`=?,`supplier`=?,`ip`=?");
                    $sim->execute(array('enquiry', $id, $Item_name[$s], $product_supplierss, $_SERVER['REMOTE_ADDR']));                
                }
            }*/

            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();
            die($e->getMessage());
        }
    }
    return array($res, $insert_id);
}

function delpurchaseEnquiry($a) {
    $ip = $_SERVER['REMOTE_ADDR'];
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $get1 = $db->prepare("DELETE FROM `purchase_enquiry_details`  WHERE `PoNum` =? AND `company_id`=? AND `PoID` =? ");
        $get1->execute(array(getpurchaseorderdetails('PoNum', $c), $_SESSION['COMPANY_ID'], $c));

        $get1 = $db->prepare("DELETE FROM `item_mapping`  WHERE `type` =? AND `company_id`=? AND `type_id` =? ");
        $get1->execute(array('enquiry', $_SESSION['COMPANY_ID'], $c));

        $get = $db->prepare("DELETE FROM `purchase_enquiry` WHERE `PoID` =? AND `company_id`=? ");
        $get->execute(array($c, $_SESSION['COMPANY_ID']));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Purchase Order', 3, 'Delete', $_SESSION['UID'], $ip, $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

function getpurchaseEnquiry($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `purchase_enquiry` WHERE `company_id`=? AND `PoID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'],  $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addItemMapEnq($suppliers, $products,$pdid, $type, $enquiry_id, $old_enq_Im_ids) {
    global $db;
    foreach ($suppliers as $kk => $sup_val) {
        if (get_enq_item_map('id', $products[$kk],$pdid[$kk], $type, $enquiry_id) != '') {
            $sim = $db->prepare("UPDATE `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=? WHERE `company_id`=? AND `id`=?");
            $sim->execute(array($type, $enquiry_id, $pdid[$kk],$products[$kk], $suppliers[$kk], $_SERVER['REMOTE_ADDR'], get_enq_item_map('id', $products[$kk],$pdid[$kk], $type,$_SESSION['COMPANY_ID'], $enquiry_id)));
        } else {
            $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=? ,`company_id`=? ");
            $sim->execute(array($type, $enquiry_id, $pdid[$kk],$products[$kk], $suppliers[$kk], $_SERVER['REMOTE_ADDR'],$_SESSION['COMPANY_ID']));
        }
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Saved</h4></div>';
    }
    return $res;
}

function Update_Product_Price_From_IM($mtable,$table,$otable,$id,$type){
    global $db;    
    $get = $db->prepare("SELECT * FROM `$mtable` WHERE `PoID`=? AND `company_id`=?");
    $get->execute(array($id, $_SESSION['COMPANY_ID']));
    $fget = $get->fetch();
    $taxtype = $fget['TaxType'];
    //----------------------------
    $settot = 0;
    //---------------------------
    $su = $db->prepare("SELECT * FROM `$table` WHERE `PoID`=? AND `company_id`=?");
    $su->execute(array($id, $_SESSION['COMPANY_ID']));
    while($fsu = $su->fetch()){        
        $im = get_enq_item_map('supplier', $fsu['Item'],$fsu['PdID'], $type, $id);
        if($im!=''){
            $exp = explode(',',$im);
            $rts = [];
            foreach($exp as $sups){
                $sup = $db->prepare("SELECT `id`,`price` FROM `item_price` WHERE `supplier`=? AND `item`=? AND `company_id`=?");
                $sup->execute(array($sups,$fsu['Item'], $_SESSION['COMPANY_ID']));
                $fsup = $sup->fetch();
                if($sup->rowCount() > 0){
                    $nr = (getcurrency_new('code',getsupplier('Currency',$sups)) != getcurrency_new('code',$fsu['Currency'])) ? currencycv(getcurrency_new('code',getsupplier('Currency',$sups)),getcurrency_new('code',$fsu['Currency']),1) : 1;                    
                    $rts[$sups] = $fsup['price'] * $nr;                            
                }else{
                    $rts[$sups] = '0';
                }
            }   
            if(!empty($rts)){
                $rts = array_diff($rts,array('0'));
                if(!empty($rts)){
                    $settot = 1;
                    $lprc = min($rts);
                    $lprc1 = min($rts);
                    $item_margin = getitem('Margin',$fsu['Item']);
                    $margin_value = getmargin('Name',$item_margin);                
                    $def_margin_value = getmargin('Name', getprofile('margin'));
                    if($item_margin!=''){
                        $lprc = ($lprc * ($margin_value/100)) + $lprc;
                    }else{
                        $lprc = ($lprc * ($def_margin_value/100)) + $lprc;
                    }
                    $qty = $fsu['Qty'];
                    $tot_prc = $qty * $lprc;                    
                    $tot_prc = $tot_prc - (float)$fsu['Discount'];
                    $taa = 0;
                    $ta = 0;
                    $taxper = gettax1('taxpercentage',$fsu['TaxName']);
                    if($taxtype=='0'){
                        $taa = $tot_prc;                       
                    }else if($taxtype=='1'){
                        $taa = ($tot_prc / (100 + $taxper)) * 100;
                        $ta = $tot_prc - $taa;
                    }else{
                        $taa = $tot_prc;
                        $ta = ($tot_prc * $taxper) / 100;
                        $tot_prc = $taa + $ta;
                    }                    
                    $up = $db->prepare("UPDATE `$table` SET `product_rate_hidden`=?,`PackRate`=?,`TaxableAmt`=?,`TaxAmt`=?,`Amount`=? WHERE `PdID`=? AND `company_id`=?");
                    $up->execute(array($lprc1,$lprc,$taa,$ta,$tot_prc,$fsu['PdID'], $_SESSION['COMPANY_ID']));
                }
            }
        }
    }
    if($settot==1){
       setAmtNewCalc($mtable,$table,$otable,$id);
    }
}

function saveAutoItemMap($table,$details_table,$others_table,$id,$type){
    global $db;
    $get = $db->prepare("SELECT * FROM `$table` WHERE `PoID`=? AND `company_id`=?");
    $get->execute(array($id, $_SESSION['COMPANY_ID']));
    $fget = $get->fetch();
    $taxtype = $fget['TaxType'];
    //----------------------------
    $settot = 0;
    //---------------------------
    $su = $db->prepare("SELECT * FROM `$details_table` WHERE `PoID`=? AND `company_id`=?");
    $su->execute(array($id, $_SESSION['COMPANY_ID']));
    while($fsu = $su->fetch()){
        $whr = $db->prepare("SELECT GROUP_CONCAT(`SupID`) as `gp` FROM `suppliers` WHERE FIND_IN_SET((SELECT `Sub_Group` FROM `item_master` WHERE `Item_Id`='".$fsu['Item']."'),`subgroup`) AND `status`='1' AND `company_id`= '".$_SESSION['COMPANY_ID']."'");
        $whr->execute();
        $whr1 = $whr->fetch();
        $im = $whr1['gp'];
        ///$im = get_enq_item_map('supplier', $fsu['Item'], $type, $id);
        if(trim($im)!=''){
            $exp = explode(',',$im);
            $rts = [];
            foreach($exp as $sups){
                $sup = $db->prepare("SELECT `id`,`price` FROM `item_price` WHERE `supplier`=? AND `item`=? AND `company_id`=?");
                $sup->execute(array($sups,$fsu['Item'], $_SESSION['COMPANY_ID']));
                $fsup = $sup->fetch();
                if($sup->rowCount() > 0){
                    if($fsup['price']!=='' && $fsup['price']!==NULL){
                        $nr = (getcurrency_new('code',getsupplier('Currency',$sups)) != getcurrency_new('code',$fsu['Currency'])) ? currencycv(getcurrency_new('code',getsupplier('Currency',$sups)),getcurrency_new('code',$fsu['Currency']),1) : 1;                    
                       $rts[$sups] = $fsup['price'] * $nr;                            
                        // $rts[$sups] = $fsup['price'];                            
                    }
                }else{
                    //$rts[$sups] = '0';
                }
            }
            //print_r($rts); exit;
            if(!empty($rts)){
                //$rts = array_diff($rts,array('0'));
                if(!empty($rts)){
                    $settot = 1;
                    $lprc = min($rts);
                    $ke6 = array_search ($lprc, $rts);
                    if (get_enq_item_map('id', $fsu['Item'],$fsu['PdID'], $type, $id) != '') {
                        $sim = $db->prepare("UPDATE `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=? WHERE `company_id`=? AND `id`=?");
                        $sim->execute(array($type, $id,$fsu['PdID'], $fsu['Item'], $ke6, $_SERVER['REMOTE_ADDR'],get_enq_item_map('id', $fsu['Item'],$fsu['PdID'], $type,$_SESSION['COMPANY_ID'],  $id)));
                    }else{
                        $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=?, `company_id`=? ");
                        $sim->execute(array($type, $id,$fsu['PdID'], $fsu['Item'], $ke6, $_SERVER['REMOTE_ADDR'],$_SESSION['COMPANY_ID']));
                    }                    
                }
            }
        }
    }
    if($settot==1){
       Update_Product_Price_From_IM($table,$details_table,$others_table,$id,$type);
       $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Items Mapped</h4></div>';
    }else{
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-times"></i>Sorry Unable to map</h4></div>';
    }
    return $res;
}

function setAmtNewCalc($table,$table1,$table2,$id){
    global $db;
    if($table2!=''){
        $ot = $db->prepare("SELECT SUM(`Taxable_Amt`) as `taa`,SUM(`Tax_Amt`) as `ta` FROM `$table2` WHERE `salesid`=? AND `company_id`=?");
        $ot->execute(array($id, $_SESSION['COMPANY_ID']));
        $fot = $ot->fetch();
    }
    //-------------------------------------
    $pt = $db->prepare("SELECT SUM(`TaxableAmt`) as `taa`,SUM(`TaxAmt`) as `ta` FROM `$table1` WHERE `PoID`=? AND `company_id`=?");
    $pt->execute(array($id, $_SESSION['COMPANY_ID']));
    $fpt = $pt->fetch();
    $fpt['taa'] = $fpt['taa']!='' ? $fpt['taa'] : '0';
    $fpt['ta'] = $fpt['taa']!='' ? $fpt['ta'] : '0';
    //-------------------------------------
    $st = $fot['taa'] + $fpt['taa'];
    $tt = $fot['ta'] + $fpt['ta'];
    $mt = $st + $tt;
    $get = $db->prepare("UPDATE `$table` SET `SubTotal`=?,`SubTaxTotal`=?,`Total`=? WHERE `PoID`=? AND `company_id`=?");
    $get->execute(array($st,$tt,$mt,$id, $_SESSION['COMPANY_ID']));    
}

function get_enq_item_map($a, $item,$det_id, $enq_type, $enq) {
    global $db;
    $gim = $db->prepare("SELECT * FROM `item_mapping` WHERE `company_id`=? AND `type`=? AND `type_id`=? AND `type_details_id`=? AND `product`=?");
    $gim->execute(array($_SESSION['COMPANY_ID'], $enq_type, $enq,$det_id, $item));
    $f = $gim->fetch();
    return $f[$a];
}

function CreateRFQ($enq_type, $enq_id, $suppliers) {
    global $db;
    if (count($suppliers) > 0) {
        foreach ($suppliers as $sk => $vals) {
            $ls = $db->prepare("SELECT `product` FROM `item_mapping` WHERE `type`=? AND `type_id`=? AND FIND_IN_SET(?,`supplier`) AND `company_id`=?");
            $ls->execute(array($enq_type, $enq_id, $vals, $_SESSION['COMPANY_ID']));
            $pds = '';
            while ($fs = $ls->fetch()) {
                $pds .= ($pds) ? ',' . $fs['product'] : $fs['product'];
            }
            //echo $pds; continue;

            $getmanuf = $db->prepare("SELECT * FROM `rfq` WHERE `company_id`= '".$_SESSION['COMPANY_ID']."'  ORDER BY `PoID` DESC");
            $getmanuf->execute();
            $lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

            if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
                $val = 1;
                $purid = 'RFQ' . str_pad(1, 8, '0', STR_PAD_LEFT);
            } else {
                $val = $lst['PoID'] + 1;
                $purid = 'RFQ' . str_pad($val, 8, '0', STR_PAD_LEFT);
            }
            $purid = get_bill_settings('prefix', '4') . str_pad(get_bill_settings('current_value', '4'), get_bill_settings('format', '4'), '0', STR_PAD_LEFT);
            if ($enq_type == 'enquiry') {
                $table = 'purchase_enquiry';
                $table_d = 'purchase_enquiry_details';
                $getponumber = getpurchaseEnquiry('PONumber', $enq_id);
            } elseif ($enq_type == 'sales_quote') {
                $table = 'sales_quote';
                $table_d = 'sales_quote_details';
                $getponumber = getsalesquote('PONumber', $enq_id);
            } elseif ($enq_type == 'sales_order') {
                $table = 'sales_order';
                $table_d = 'sales_order_details';
                $getponumber = getsalesorder('PONumber', $enq_id);
            }

            $resa = $db->prepare("INSERT INTO  `rfq` (`PONumber`,`PODate`,`TaxType`,`CusID`,`supplier`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,'" . $vals . "',`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','".$_SESSION['COMPANY_ID']."' FROM `$table` WHERE `PoID` = ?  AND `company_id`=?");
            $resa->execute(array($enq_id, $_SESSION['COMPANY_ID']));
            $linsert_id = $db->lastInsertId();
            update_bill_value('4');
            $resa = $db->prepare("INSERT INTO `rfq_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Comments`,`company_id`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, '" . $vals . "', `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Comments`, '". $_SESSION['COMPANY_ID'] ."' FROM `$table_d` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? AND `Item` IN (" . $pds . ")");
            $resa->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enq_id));
           echo convertd_page($linsert_id, 'editrfq.htm', 'process');
        }
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Saved</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-times"></i>Select Suppliers</h4></div>';
    }
    return $res;
}

function SendRFQMail($enq_type, $enq_id, $suppliers) {
    global $db, $sitename, $fsitename;
    if (count($suppliers) > 0) {
        $img = "<img src='" . $fsitename . "pages/profile/image/" . getprofile('image') . "' height='80' />";
        $certi = "<img src='" . $fsitename . "images/b1.png' height='80' style='border:1px solid;padding:2px;' />";
        $company_name = getprofile('Company_name');
        $phonenumber = getprofile('phonenumber');
        $email = getprofile('recoveryemail');
        $address = '<b>' . getprofile('Company_name') . '<br />' . getprofile('Adderss1');
        $address .= (trim(getprofile('Adderss2')) != '') ? ' ' . getprofile('Adderss2') : '';
        $address .= ' ' . ci('name', getprofile('City')) . ', ' . st('name', getprofile('State'));
        $address .= ' ' . co('name', getprofile('Country')) . '</b>';
        $address .= '<br />TEL : ' . $phonenumber . ' Email : ' . $email;
        foreach ($suppliers as $sk => $vals) {
            $ls = $db->prepare("SELECT `product` FROM `item_mapping` WHERE `company_id`=? AND `type`=? AND `type_id`=? AND FIND_IN_SET(?,`supplier`)");
            $ls->execute(array($_SESSION['COMPANY_ID'], $enq_type, $enq_id, $vals));
            $pds = '';
            while ($fs = $ls->fetch()) {
                $pds .= ($pds) ? ',' . $fs['product'] : $fs['product'];
            }
            //echo $pds; continue;
            //$sql = FETCH_all("SELECT * FROM `seller_adminusers` WHERE `id`='1'");
            //
            $TO = getsupplier('E-mail', $vals);
            $MESSAGE = getTableValue('email_template', 'message', '2');
            $SUBJECT = getTableValue('email_template', 'subject', '2');
            $PRODUCTS = '<table border="0" class="sd" cellpadding="8" cellspacing="0"  width="70%">
                    <thead>
                        <tr>
                            <th style="border:1px solid;" width="5%"><small>Sl.no</th>
                            <th style="border:1px solid;" width="40%" align="left"><small>Description</th>                           
                            <th style="border:1px solid;" width="10%" style="text-align:center;"><small>UOM</small></th>
                            <th style="border:1px solid;" width="10%" style="text-align:center;"><small>Qty</small></th>
                        </tr>
                    </thead>                                    
                    <tbody>';
            if ($enq_type == 'enquiry') {
                $table = 'purchase_enquiry';
                $table_d = 'purchase_enquiry_details';
                $getponumber = getpurchaseEnquiry('PONumber', $enq_id);
            } elseif ($enq_type == 'sales_quote') {
                $table = 'sales_quote';
                $table_d = 'sales_quote_details';
                $getponumber = getsalesquote('PONumber', $enq_id);
            } elseif ($enq_type == 'sales_order') {
                $table = 'sales_order';
                $table_d = 'sales_order_details';
                $getponumber = getsalesorder('PONumber', $enq_id);
            }
            $pds = $db->prepare("SELECT * FROM `$table_d` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? AND `Item` IN (" . $pds . ")");
            $pds->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enq_id));
            $k = 0;
            while ($fpds = $pds->fetch()) {
                $k = 1;
                $PRODUCTS .= '<tr>
                                <td class="tg-yw4l" align="center" style="border:1px solid;">' . $k . '</td>
                                <td class="tg-yw4l" align="left" style="border:1px solid;">' . getitem('Item_Name', $fpds['Item']) . '</td>
                                <td class="tg-yw4l" align="left" style="border:1px solid;">' . getuom('Name', $fpds['PackUoM']) . '</td>
                                <td class="tg-yw4l" align="center" style="border:1px solid;">' . $fpds['Qty'] . '</td>
                              </tr>
                            </tr>';
            }
            $PRODUCTS .= '</tbody></table>';

            $placeHolders = [
                '$@LOGO$@$',
                '$@COMPANY_NAME@$',
                '$@ADDRESS@$',
                '$@PHONE@$',
                '$@EMAIL@$',
                '$@FAX@$',
                '$@PRODUCTS@$',
                '$@SUPPLIERNAME@$',
                '$@CERTIFICATION$@$'
            ];

            $values = [
                $img,
                $company_name,
                $address,
                $phonenumber,
                $email,
                '7777777',
                $PRODUCTS,
                getsupplier('Supplier_name', $vals),
                $certi
            ];
            $MESSAGE = str_replace($placeHolders, $values, $MESSAGE) . '<div style="border-top: 0.1mm solid #000000;text-align:center;padding:5px 0 5px 0;width:70%;"><small>' . $address . '</samll></div>';

            $HEADERS = 'MIME-Version: 1.0' . "\r\n";
            $HEADERS .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $HEADERS .= 'From: IMPA ERP <' . getprofile('recoveryemail') . ">\r\n";
            if (isset($_REQUEST['show'])) {
                echo $TO, $SUBJECT, $MESSAGE, $HEADERS;
                exit;
            }
            //continue;
            //mail($TO, $SUBJECT, $MESSAGE, $HEADERS);
            Send_Mail($TO, $SUBJECT, $MESSAGE);
        }
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Sent</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-times"></i>Select Suppliers</h4></div>';
    }
    return $res;
}

function ConverttoSalesQuote($enqid, $fromquote = '') {
    global $db, $sitename;
    $purid = get_bill_settings('prefix', '5') . str_pad(get_bill_settings('current_value', '5'), get_bill_settings('format', '5'), '0', STR_PAD_LEFT);


    $resa = $db->prepare("INSERT INTO  `sales_quote` (`PONumber`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`purchase_enquiry_id`,`status_approve`,`ref_no`,`Othercharges`,`Discount`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','" . $enqid . "',`status_approve`,`ref_text`,'0','0','". $_SESSION['COMPANY_ID'] ."' FROM `purchase_enquiry` WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('5');
    $getponumber = getpurchaseEnquiry('PONumber', $enqid);
    
    //$resa = $db->prepare("INSERT INTO `sales_quote_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments` FROM `purchase_enquiry_details` WHERE `PoNum` = ? AND `PoID` =? ORDER BY `PdID` ASC");
    //$resa->execute(array($getponumber, $enqid));
    
    $equ_sq_ids = array();
    $enq_details = $db->prepare("SELECT * FROM `purchase_enquiry_details` WHERE `PoNum` = ? AND `PoID` =? AND `company_id`=? ORDER BY `PdID` ASC");
    $enq_details->execute(array($getponumber, $enqid, $_SESSION['COMPANY_ID']));
    while($fetch_data = $enq_details->fetch()){
        $fetch_data['supplier_id'] = $fetch_data['supplier_id'] != '' ? $fetch_data['supplier_id'] : 0;
        $fetch_data['ItemRate'] = $fetch_data['ItemRate'] != '' ? $fetch_data['ItemRate'] : 0;
        $resa = $db->prepare("INSERT INTO `sales_quote_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount_per`,`Discount`,`display_order`,`company_id`) VALUES ('" . $purid . "', '" . $linsert_id . "', '".$fetch_data['Item']."', '".$fetch_data['supplier_id']."', '".$fetch_data['Qty']."', '".$fetch_data['QtyPerPack']."', '".$fetch_data['PackUoM']."', '".$fetch_data['ItemUoM']."', '".$fetch_data['TotalQty']."','".$fetch_data['Margin']."','".$fetch_data['product_rate_hidden']."','".$fetch_data['PackRate']."', '".$fetch_data['ItemRate']."', '".$fetch_data['TaxName']."', '".$fetch_data['TaxableAmt']."', '".$fetch_data['TaxAmt']."', '".$fetch_data['Amount']."', '" . $_SERVER['REMOTE_ADDR'] . "','".$fetch_data['Currency']."',?,'0','0','".$fetch_data['display_order']."','".$_SESSION['COMPANY_ID']."')");
        $resa->execute(array($fetch_data['Comments']));
        $equ_sq_ids[$fetch_data['PdID']] = $db->lastInsertId();
    }    
    
    /*
    $up_prc = $db->prepare("SELECT `PdID`,`Item`,`TaxName`,`Qty` FROM `sales_quote_details` WHERE `PoID`=?");
    $up_prc->execute(array($linsert_id));
    while ($f = $up_prc->fetch()) {
        $ap_item = $f['Item'];
        $ap_pprice = getitem('Sales_Pack_Price', $ap_item);
        $ap_iprice = getitem('Sales_Unit_price', $ap_item);        
        $ap_tax = getitem('Tax', $ap_item);
        $ap_taxable_amt = getitem('Sales_Pack_Price', $ap_item);
        $ap_tax_amt = ($ap_tax!='' && $ap_tax!='0') ? getitem('Sales_Pack_Price', $ap_item) * (gettax('taxpercentage', $ap_tax) / 100) : '0';
     
        $ap_amt = $ap_taxable_amt + $ap_amt;      
        $nr = currencycv(getcurrency_new('code',getprofile('currency')),getcurrency_new('code',getcustomer('Currency',getpurchaseEnquiry('CusID', $enqid))),1);
        $ap_pprice = $ap_pprice * $nr;           
        $qty = $f['Qty'];
        $tot_prc = $qty * $ap_pprice;
        $taa = 0;
        $ta = 0;
        $taxper = gettax1('taxpercentage',$ap_tax);
        $taxtype = getsalesquote('TaxType',$linsert_id);
        if($taxper!='' && $taxper!='0'){
        if($taxtype=='0'){
            $ap_tax= 0;
        }else if($taxtype=='1'){
            $taa = ($tot_prc / (100 + $taxper)) * 100;
            $ta = $tot_prc - $taa;
        }else{
            $taa = $tot_prc;
            $ta = ($tot_prc * $taxper) / 100;
            $tot_prc = $taa + $ta;
        }              
        }else{
            
        }   // `PackRate`=?,    
        $up_qry = $db->prepare("UPDATE `sales_quote_details` SET  `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=? WHERE `PdID`=?");
        $up_qry->execute(array(number_format($ap_pprice,2,'.',''), $ap_tax, number_format($taa,2,'.',''), number_format($ta,2,'.',''), number_format($tot_prc,2,'.',''), $f['PdID']));
    }
    */

//    $resa = $db->prepare("INSERT INTO `item_mapping` (`type`,`type_id`,`supplier`,`product`,`ip`) SELECT 'sales_quote','" . $linsert_id . "',`supplier`,`product`,'" . $_SERVER['REMOTE_ADDR'] . "' FROM `item_mapping` WHERE `type`=? AND `type_id`=?");
//    $resa->execute(array('enquiry', $enqid));
    
    $old_im = $db->prepare("SELECT * FROM `item_mapping` WHERE `company_id`=? AND `type`=? AND `type_id`=?");
    $old_im->execute(array($_SESSION['COMPANY_ID'], 'enquiry',$enqid));
    while($fetch_old_im = $old_im->fetch()){     
        $nid = $equ_sq_ids[$fetch_old_im['type_details_id']]!='' ? $equ_sq_ids[$fetch_old_im['type_details_id']] : 0;
        $resa = $db->prepare("INSERT INTO `item_mapping` (`type`,`type_id`,`type_details_id`,`supplier`,`product`,`ip`,`company_id`) VALUES ('sales_quote','" . $linsert_id . "','".$nid."','".$fetch_old_im['supplier']."','".$fetch_old_im['product']."','" . $_SERVER['REMOTE_ADDR'] . "', '".$_SESSION['COMPANY_ID']."')");
        $resa->execute();
    }    

    $resa = $db->prepare("UPDATE `purchase_enquiry` SET `convert_to_sales_quote`='1',`converted_sales_quote_id`=? WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($linsert_id,$_SESSION['COMPANY_ID'], $enqid));

    echo ($fromquote == '') ? convertd_page($linsert_id, 'editquote.htm', 'process') : '';

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Converted</h4></div>';

    return ($fromquote == '') ? $res : $linsert_id;
}

function ConvertoInvoice($enqid, $fromdelivery = '') {
    global $db;
    $getmanuf = $db->prepare("SELECT * FROM `invoice` WHERE `company_id`= '".$_SESSION['COMPANY_ID']."' ORDER BY `PoID` DESC");
    $getmanuf->execute();
    $lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

    if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
        $val = 1;
        $purid = 'INV' . str_pad(1, 8, '0', STR_PAD_LEFT);
        $purid = get_bill_settings('prefix', '11') . str_pad(get_bill_settings('current_value', '11'), get_bill_settings('format', '11'), '0', STR_PAD_LEFT);
    } else {
        $val = $lst['PoID'] + 1;
        $purid = 'INV' . str_pad($val, 8, '0', STR_PAD_LEFT);
        $purid = get_bill_settings('prefix', '11') . str_pad(get_bill_settings('current_value', '11'), get_bill_settings('format', '11'), '0', STR_PAD_LEFT);
    }

    $resa = $db->prepare("INSERT INTO  `invoice` (`PONumber`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`Delivery_note`,`status_approve`,`ref_no`,`Discount`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','" . $enqid . "',`status_approve`,`ref_no`,`Discount`,'" . $_SESSION['COMPANY_ID'] ."' FROM `delivery_note` WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('11');
    $getponumber = getdeliverynote('PONumber', $enqid);
    $resa = $db->prepare("INSERT INTO `invoice_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,`company_id`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`, '". $_SESSION['COMPANY_ID'] ."' FROM `delivery_note_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? ORDER BY `PdID` ASC");
    $resa->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enqid));

    $resa = $db->prepare("INSERT INTO `invoice_othercharges` (`invoiceid`,`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,`company_id`) SELECT '" . $linsert_id . "',`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,'" .$_SESSION['COMPANY_ID']. "' FROM `delivery_othercharges` WHERE `company_id`=? AND `salesid`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));

    $resa = $db->prepare("UPDATE `delivery_note` SET `Converted`='1',`converted_invoice_id`=? WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($linsert_id, $_SESSION['COMPANY_ID'], $enqid));

    echo ($fromdelivery == '') ? convertd_page($linsert_id, 'editinvoice.htm', 'process') : '';

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Converted</h4></div>';

    return ($fromdelivery == '') ? $res : $linsert_id;
}
function ConvertoInvoiceFromSO($enqid, $fromso = '') {
    global $db;
    $getmanuf = $db->prepare("SELECT * FROM `invoice` WHERE `company_id`='".$_SESSION['COMPANY_ID']."' ORDER BY `PoID` DESC");
    $getmanuf->execute();
    $lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

    if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
        $val = 1;
        $purid = 'INV' . str_pad(1, 8, '0', STR_PAD_LEFT);
        $purid = get_bill_settings('prefix', '11') . str_pad(get_bill_settings('current_value', '11'), get_bill_settings('format', '11'), '0', STR_PAD_LEFT);
    } else {
        $val = $lst['PoID'] + 1;
        $purid = 'INV' . str_pad($val, 8, '0', STR_PAD_LEFT);
        $purid = get_bill_settings('prefix', '11') . str_pad(get_bill_settings('current_value', '11'), get_bill_settings('format', '11'), '0', STR_PAD_LEFT);
    }

    $resa = $db->prepare("INSERT INTO  `invoice` (`PONumber`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`Sales_order`,`status_approve`,`ref_no`,`Othercharges`,`Discount`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','" . $enqid . "',`status_approve`,`po_ref_no`,`Othercharges`,`Discount`,'" . $_SESSION['COMPANY_ID'] . "' FROM `sales_order` WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('11');
    $getponumber = getsalesorder('PONumber', $enqid);
    $resa = $db->prepare("INSERT INTO `invoice_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,`company_id`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,'" .$_SESSION['COMPANY_ID']. "' FROM `sales_order_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? ORDER BY `PdID` ASC");
    $resa->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enqid));

    $resa = $db->prepare("INSERT INTO `invoice_othercharges` (`invoiceid`,`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,`company_id`) SELECT '" . $linsert_id . "',`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`, '". $_SESSION['COMPANY_ID']."' FROM `sales_order_othercharges` WHERE `company_id`=? AND `salesid`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));

    $resa = $db->prepare("UPDATE `sales_order` SET `Converted_invoice`='1',`converted_invoice_id`=? WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($linsert_id,$_SESSION['COMPANY_ID'], $enqid));

    echo ($fromso == '') ? convertd_page($linsert_id, 'editinvoice.htm', 'process') : '';

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Converted</h4></div>';

    return ($fromso == '') ? $res : $linsert_id;
}

function ConvertoInvoice_PAI($enqid, $fromdelivery = '') {
    global $db;
    $purid = get_bill_settings('prefix', '13') . str_pad(get_bill_settings('current_value', '13'), get_bill_settings('format', '13'), '0', STR_PAD_LEFT);
    
    $resa = $db->prepare("INSERT INTO  `perform_a_invoice` (`PONumber`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`Delivery_note`,`status_approve`,`ref_no`,`Discount`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','" . $enqid . "',`status_approve`,`ref_no`,`Discount`,'". $_SESSION['COMPANY_ID'] ."' FROM `delivery_note` WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('13');
    $getponumber = getdeliverynote('PONumber', $enqid);
    $resa = $db->prepare("INSERT INTO `perform_a_invoice_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,`company_id`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,'".$_SESSION['COMPANY_ID']."' FROM `delivery_note_details` WHERE `company_id`=? AND  `PoNum` = ? AND `PoID` =? ORDER BY `PdID` ASC");
    $resa->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enqid));

    $resa = $db->prepare("INSERT INTO `perform_a_invoice_othercharges` (`invoiceid`,`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,`company_id`) SELECT '" . $linsert_id . "',`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,' " .$_SESSION['COMPANY_ID']. "' FROM `delivery_othercharges` WHERE `company_id`=? AND `salesid`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));

    echo ($fromdelivery == '') ? convertd_page($linsert_id, 'edit_perform_a_invoice.htm', 'process') : '';

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Converted</h4></div>';

    return ($fromdelivery == '') ? $res : $linsert_id;
}
function ConvertoInvoiceFromSO_PAI($enqid, $fromso = '') {
    global $db;
    $purid = get_bill_settings('prefix', '13') . str_pad(get_bill_settings('current_value', '13'), get_bill_settings('format', '13'), '0', STR_PAD_LEFT);
    
    $resa = $db->prepare("INSERT INTO  `perform_a_invoice` (`PONumber`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`Sales_order`,`status_approve`,`ref_no`,`Discount`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','" . $enqid . "',`status_approve`,`po_ref_no`,`Discount`,'" .$_SESSION['COMPANY_ID']. "' FROM `sales_order` WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('13');
    $getponumber = getsalesorder('PONumber', $enqid);
    $resa = $db->prepare("INSERT INTO `perform_a_invoice_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,`company_id`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,'" .$_SESSION['COMPANY_ID']. "' FROM `sales_order_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? ORDER BY `PdID` ASC");
    $resa->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enqid));

    $resa = $db->prepare("INSERT INTO `perform_a_invoice_othercharges` (`invoiceid`,`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,`company_id`) SELECT '" . $linsert_id . "',`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,'".$_SESSION['COMPANY_ID']."' FROM `sales_order_othercharges` WHERE `company_id`=? AND `salesid`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));


    echo ($fromso == '') ? convertd_page($linsert_id, 'edit_perform_a_invoice.htm', 'process') : '';

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Converted</h4></div>';

    return ($fromso == '') ? $res : $linsert_id;
}

function ConverttoSalesorder($enqid, $fromsales = '') {

    global $db;
    $getmanuf = $db->prepare("SELECT * FROM `sales_order` WHERE `company_id`='".$_SESSION['COMPANY_ID']."' ORDER BY `PoID` DESC");
    $getmanuf->execute();
    $lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

    if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
        $val = 1;
        $purid = 'SAO' . str_pad(1, 8, '0', STR_PAD_LEFT);
    } else {
        $val = $lst['PoID'] + 1;
        $purid = 'SAO' . str_pad($val, 8, '0', STR_PAD_LEFT);
    }
    $purid = get_bill_settings('prefix', '6') . str_pad(get_bill_settings('current_value', '6'), get_bill_settings('format', '6'), '0', STR_PAD_LEFT);

    $resa = $db->prepare("INSERT INTO `sales_order` (`PONumber`,`Sales_quote`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Discount`,`IP`,`Updated_by`,`status_approve`,`po_ref_no`,`company_id`) SELECT '" . $purid . "','" . $enqid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Discount`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "',`status_approve`,`ref_no`,'" .$_SESSION['COMPANY_ID']. "' FROM `sales_quote` WHERE `company_id`=? AND `PoID`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('6');
    $getponumber = getsalesquote('PONumber', $enqid);
  
//    $resa = $db->prepare("INSERT INTO `sales_order_details` (`PoNum`, `PoID`, `Item`, `supplier_id`,`Q_Qty`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount`,`Discount_per`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments`,`Discount`,`Discount_per` FROM `sales_quote_details` WHERE `PoNum` = ? AND `PoID`=? ORDER BY `PdID` ASC");
//    $resa->execute(array($getponumber, $enqid));
    
    $equ_so_ids = array();
    $sq_details = $db->prepare("SELECT * FROM `sales_quote_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID`=? ORDER BY `PdID` ASC");
    $sq_details->execute(array($_SESSION['COMPANY_ID'],  $getponumber, $enqid));
    while($fetch_data = $sq_details->fetch()){
        $fetch_data['supplier_id'] = $fetch_data['supplier_id'] != '' ? $fetch_data['supplier_id'] : 0;
        $fetch_data['ItemRate'] = $fetch_data['ItemRate'] != '' ? $fetch_data['ItemRate'] : 0;
        $resa = $db->prepare("INSERT INTO `sales_order_details` (`PoNum`, `PoID`, `Item`, `supplier_id`,`Q_Qty`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,`company_id`)  VALUES ('" . $purid . "', '" . $linsert_id . "', '".$fetch_data['Item']."', '".$fetch_data['supplier_id']."', '".$fetch_data['Qty']."', '".$fetch_data['Qty']."', '".$fetch_data['QtyPerPack']."', '".$fetch_data['PackUoM']."', '".$fetch_data['ItemUoM']."', '".$fetch_data['TotalQty']."','".$fetch_data['Margin']."','".$fetch_data['product_rate_hidden']."', '".$fetch_data['PackRate']."', '".$fetch_data['ItemRate']."', '".$fetch_data['TaxName']."', '".$fetch_data['TaxableAmt']."', '".$fetch_data['TaxAmt']."', '".$fetch_data['Amount']."', '" . $_SERVER['REMOTE_ADDR'] . "','".$fetch_data['Currency']."',?,'".$fetch_data['Discount']."','".$fetch_data['Discount_per']."','".$fetch_data['display_order']."','" .$_SESSION['COMPANY_ID']. "')");
        $resa->execute(array($fetch_data['Comments']));
        $equ_so_ids[$fetch_data['PdID']] = $db->lastInsertId();
    }

    $sof = $db->prepare("SELECT * FROM `sales_order_details` WHERE `company_id`=? AND `PoID`=?");
    $sof->execute(array($_SESSION['COMPANY_ID'],$linsert_id));
    while ($fsof = $sof->fetch()) {
        $resa = $db->prepare("UPDATE `sales_order_details` SET `A_Qty`=? WHERE `company_id`=? AND `PdID`=?");
        $resa->execute(array(getcurrentqtyproduct($fsof['Item']), $_SESSION['COMPANY_ID'], $fsof['PdID']));
    }
//   getcurrentqtyproduct($setid)

    //$resa = $db->prepare("INSERT INTO `item_mapping` (`type`,`type_id`,`supplier`,`product`,`ip`) SELECT 'sales_order','" . $linsert_id . "',`supplier`,`product`,'" . $_SERVER['REMOTE_ADDR'] . "' FROM `item_mapping` WHERE `type`=? AND `type_id`=?");
    //$resa->execute(array('sales_quote', $enqid));

    $old_im = $db->prepare("SELECT * FROM `item_mapping` WHERE `company_id`=? AND `type`=? AND `type_id`=?");
    $old_im->execute(array($_SESSION['COMPANY_ID'], 'sales_quote',$enqid));
    while($fetch_old_im = $old_im->fetch()){ 
        $nid = $equ_so_ids[$fetch_old_im['type_details_id']]!='' ? $equ_so_ids[$fetch_old_im['type_details_id']] : 0;
        $resa = $db->prepare("INSERT INTO `item_mapping` (`type`,`type_id`,`type_details_id`,`supplier`,`product`,`ip`,`company_id`) VALUES ('sales_order','" . $linsert_id . "','".$nid."','".$fetch_old_im['supplier']."','".$fetch_old_im['product']."','" . $_SERVER['REMOTE_ADDR'] . "','".$_SESSION['COMPANY_ID']."')");
        $resa->execute();
    }    
    
    $resa = $db->prepare("INSERT INTO `sales_order_othercharges` (`salesid`,`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,`company_id`) SELECT '" . $linsert_id . "',`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,'".$_SESSION['COMPANY_ID']."' FROM `sales_othercharges` WHERE `company_id`=? AND `salesid`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));

    $resa = $db->prepare("UPDATE `sales_quote` SET `Converted`='1',`converted_sales_order_id`=? WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($linsert_id,$_SESSION['COMPANY_ID'],  $enqid));

    echo ($fromsales == '') ? convertd_page($linsert_id, 'editorder.htm', 'process') : '';

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Converted</h4></div>';

    return ($fromsales == '') ? $res : $linsert_id;
}
function ConverttoPurchase($enqid, $frompurchase = '') {

    global $db;    
    $purid = get_bill_settings('prefix', '8') . str_pad(get_bill_settings('current_value', '8'), get_bill_settings('format', '8'), '0', STR_PAD_LEFT);

    $resa = $db->prepare("INSERT INTO `purchase` (`PONumber`,`purchase_order`,`PODate`,`TaxType`,`supplier`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`status_approve`,`dn_ref_no`,`Discount`,`company_id`) SELECT '" . $purid . "','" . $enqid . "','" . date("Y-m-d") . "',`TaxType`,`supplier`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "',`status_approve`,`po_ref_no`,`Discount`,'".$_SESSION['COMPANY_ID']."' FROM `purchase_order` WHERE `company_id`=?  AND `PoID`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('8');
    $getponumber = getpurchaseorder('PONumber', $enqid);
    $resa = $db->prepare("INSERT INTO `purchase_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,`company_id`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,'".$_SESSION['COMPANY_ID']."' FROM `purchase_order_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID`=? ORDER BY `PdID` ASC");
    $resa->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enqid));

    $resa = $db->prepare("UPDATE `purchase_order` SET `Converted`='1',`converted_purchase_id`=? WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($linsert_id,$_SESSION['COMPANY_ID'], $enqid));

    echo ($frompurchase == '') ? convertd_page($linsert_id, 'editpurchase.htm', 'process') : '';

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Converted</h4></div>';

    return ($frompurchase == '') ? $res : $linsert_id;
}

function ConvertoDeliveryNote($enqid, $fromorder = '') {
    global $db;
    $getmanuf = $db->prepare("SELECT * FROM `delivery_note` WHERE `company_id`='".$_SESSION['COMPANY_ID']."' ORDER BY `PoID` DESC");
    $getmanuf->execute();
    $lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

    if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
        $val = 1;
        $purid = 'DC' . str_pad(1, 8, '0', STR_PAD_LEFT);
    } else {
        $val = $lst['PoID'] + 1;
        $purid = 'DC' . str_pad($val, 8, '0', STR_PAD_LEFT);
    }
    $purid = get_bill_settings('prefix', '9') . str_pad(get_bill_settings('current_value', '9'), get_bill_settings('format', '9'), '0', STR_PAD_LEFT);
    $resa = $db->prepare("UPDATE `sales_order` SET `Converted`='1' WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));


    $resa = $db->prepare("INSERT INTO  `delivery_note` (`PONumber`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`Sales_order`,`status_approve`,`ref_no`,`Discount`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','" . $enqid . "',`status_approve`,`po_ref_no`,`Discount`,'".$_SESSION['COMPANY_ID']."' FROM `sales_order` WHERE `company_id`=? AND `PoID` = ?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('9');
    $getponumber = getsalesorder('PONumber', $enqid);
    $resa = $db->prepare("INSERT INTO `delivery_note_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,`company_id`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments`,`Discount`,`Discount_per`,`display_order`,'".$_SESSION['COMPANY_ID']."' FROM `sales_order_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? ORDER BY `PdID` ASC");
    $resa->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enqid));

    $getdc = $db->prepare("SELECT * FROM `delivery_note` WHERE `company_id`=? AND `PoID`=?");
    $getdc->execute(array($_SESSION['COMPANY_ID'], $linsert_id));
    $fgetdc = $getdc->fetch();
 $ld =  getledger_by_field('lid', $fgetdc['CusID'], 'customer_id')!='' ?  getledger_by_field('lid', $fgetdc['CusID'], 'customer_id') : 0;
    add_transaction($purid, date("Y-m-d"), $ld, ($fgetdc['Total'] != '') ? $fgetdc['Total'] : '0', $linsert_id, 'Delivery_note', 'D');


    $getdc_d = $db->prepare("SELECT * FROM `delivery_note_details` WHERE `company_id`=? AND `PoID`=?");
    $getdc_d->execute(array($_SESSION['COMPANY_ID'], $linsert_id));
    while ($fgetdc_d = $getdc_d->fetch()) {
        if ($fgetdc['TaxType'] == '0') {
            $taxl = '78';
            add_transaction($purid, date("Y-m-d"), $taxl, ($fgetdc['Amount'] != '') ? $fgetdc['Amount'] : '0', $linsert_id, 'Delivery_note', 'C');
        } else {
            $taxlp = getledger('lid', gettax1('pledger', $fgetdc_d['TaxName']));
            $taxli = getledger('lid', gettax1('iledger', $fgetdc_d['TaxName']));
            if ($taxlp != '' && $taxli != '') {
                add_transaction($purid, date("Y-m-d"), $taxlp, ($fgetdc_d['TaxableAmt'] != '') ? $fgetdc_d['TaxableAmt'] : '0', $linsert_id, 'Delivery_note', 'C');
                add_transaction($purid, date("Y-m-d"), $taxli, ($fgetdc_d['TaxAmt'] != '') ? $fgetdc_d['TaxAmt'] : '0', $linsert_id, 'Delivery_note', 'C');
            }
        }
    }

    $resa = $db->prepare("INSERT INTO `delivery_othercharges` (`salesid`,`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,`company_id`) SELECT '" . $linsert_id . "',`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,'".$_SESSION['COMPANY_ID']."' FROM `sales_order_othercharges` WHERE `company_id`=? AND `salesid`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));

    $resa = pFetch("UPDATE `sales_order` SET `Converted`=?,`converted_delivery_note_id`=? WHERE `company_id`=? AND `PoID`=?", '1', $linsert_id,$_SESSION['COMPANY_ID'], $enqid);

    echo ($fromorder == '') ? convertd_page($linsert_id, 'editdeliverynote.htm', 'process') : '';
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Converted</h4></div>';

    return ($fromorder == '') ? $res : $linsert_id;
}

function savePOR($so_id, $suppliers, $products,$details_id, $qtys) {
    global $db;
    
    $new_array = array();
    foreach($suppliers as $kj => $sup){
        if($qtys[$kj] > 0){
            $new_array[$sup]['details_id'][] = $details_id[$kj];
            $new_array[$sup]['products'][] = $products[$kj];
            $new_array[$sup]['qty'][] = $qtys[$kj];
        }
    }         
    foreach($new_array as $new_supplier => $new_products){        
        $getmanuf = $db->prepare("SELECT * FROM `purchase_order`  WHERE `company_id`='".$_SESSION['COMPANY_ID']."' ORDER BY `PoID` DESC");
        $getmanuf->execute();
        $lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

        if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
            $val1 = 1;
            $purid = 'POI' . str_pad(1, 8, '0', STR_PAD_LEFT);
        } else {
            $val1 = $lst['PoID'] + 1;
            $purid = 'POI' . str_pad($val1, 8, '0', STR_PAD_LEFT);
        }
        
        $tt = getsupplier('TaxType',$new_supplier);
        
        $tt = $tt != '' ? $tt : '0';
        
        $ns = $new_supplier !='' ? $new_supplier : '0';
        
        $purid = get_bill_settings('prefix', '7') . str_pad(get_bill_settings('current_value', '7'), get_bill_settings('format', '7'), '0', STR_PAD_LEFT);
        $resa = $db->prepare("INSERT INTO `purchase_order` (`PONumber`,`PODate`,`TaxType`,`supplier`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`Sales_order`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "','".$tt."','".$ns."',`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','" . $so_id . "','".$_SESSION['COMPANY_ID']."' FROM `sales_order` WHERE `company_id`=? AND `PoID` = ?");
        $resa->execute(array($_SESSION['COMPANY_ID'], $so_id));
        $linsert_id = $db->lastInsertId();
        $s++;
        update_bill_value('7');
        $getponumber = getsalesorder('PONumber', $so_id);
        foreach($new_products['products'] as $keys => $values){
            $resa = $db->prepare("INSERT INTO `purchase_order_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Comments`,`company_id`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, '" . $ns . "', '".$new_products['qty'][$keys]."', `QtyPerPack`, `PackUoM`, `ItemUoM`, '".$new_products['qty'][$keys]."',`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Comments`,'".$_SESSION['COMPANY_ID']."' FROM `sales_order_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? AND `Item`=? AND `PdID`=?");
            $resa->execute(array($_SESSION['COMPANY_ID'], $getponumber, $so_id, $new_products['products'][$keys],$new_products['details_id'][$keys]));
        }
        $up_prc = $db->prepare("SELECT `PdID`,`Item`,`TaxName`,`Qty` FROM `purchase_order_details` WHERE `company_id`=? AND `PoID`=?");
    $up_prc->execute(array($_SESSION['COMPANY_ID'], $linsert_id));
    $supps = getpurchaseorder('supplier', $linsert_id);
    while ($f = $up_prc->fetch()) {
        $ap_item = $f['Item'];
        $ap_tax = ($f['TaxName'] > 0) ? $f['TaxName'] : (getitem('Tax', $ap_item)!='') ? getitem('Tax', $ap_item) : getprofile('default_tax');
         $sup = $db->prepare("SELECT `id`,`price` FROM `item_price` WHERE `company_id`=? AND `supplier`=? AND `item`=?");
        $sup->execute(array($_SESSION['COMPANY_ID'], $supps,$f['Item']));
        $fsup = $sup->fetch();
        if($fsup['price'] > 0){  
            $newrate1 = $fsup['price'];
        }else{
            $newrate1 = getitem('Sales_Pack_Price', $ap_item);        
            $nr = currencycv(getcurrency_new('code',getprofile('currency')),getcurrency_new('code',getsupplier('Currency',getpurchaseorder('supplier', $linsert_id))),1);
            $newrate1 = $newrate1 * $nr;           
        }
         $margins = array(
            "item_margin" => getmargin('Name', getitem('Margin',$ap_item)),
            "default_margin" => getmargin('Name', getprofile('margin')),
            "margin_type" => getprofile('margin_type')
        );
        //$margin = ($margins['item_margin'] != '') ? $margins['item_margin'] : $margins['default_margin'];
         $margin = 0;
        $newrate = ($newrate1 * ($margin / 100)) + $newrate1;        
        
        $qty = $f['Qty'];
        $tot_prc = $qty * $newrate;
        $taa = 0;
        $ta = 0;
        $taxper = gettax1('taxpercentage',$ap_tax);
        $taxtype = getpurchaseorder('TaxType',$linsert_id);
        if($taxper!='' && $taxper!='0'){
        if($taxtype=='0'){
                $ap_tax= 0; 
        }else if($taxtype=='1'){
            $taa = ($tot_prc / (100 + $taxper)) * 100;
            $ta = $tot_prc - $taa;
        }else{
            $taa = $tot_prc;
            $ta = ($tot_prc * $taxper) / 100;
            $tot_prc = $taa + $ta;
        }              
        }else{
            
        }       
        $up_qry = $db->prepare("UPDATE `purchase_order_details` SET `Margin`=?,`product_rate_hidden`=?,`PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=? WHERE `company_id`=? AND `PdID`=?");
        $up_qry->execute(array($margin,number_format($newrate1,getDigit($supps,'S'),'.',''),number_format($newrate,getDigit($supps,'S'),'.',''), number_format($newrate,getDigit($supps,'S'),'.',''), $ap_tax, number_format($taa,getDigit($supps,'S'),'.',''), number_format($ta,getDigit($supps,'S'),'.',''), number_format($tot_prc,getDigit($supps,'S'),'.',''), $_SESSION['COMPANY_ID'], $f['PdID']));
    }
        $ct = $db->prepare("SELECT sum(`TaxableAmt`) as t1,sum(`TaxAmt`) as t2,SUM(`Amount`) as t3 FROM `purchase_order_details` WHERE `company_id`='".$_SESSION['COMPANY_ID']."' AND `PoID`='" . $linsert_id . "' GROUP BY PoID");
        $ct->execute();
        $ct_f = $ct->fetch();

        $ct_u = $db->prepare("UPDATE `purchase_order` SET `SubTotal`=?, `SubTaxTotal`=?, `Total`=? WHERE `company_id`=? AND `PoID`=?");
        $ct_u->execute(array($ct_f['t1'], $ct_f['t2'], $ct_f['t3'],$_SESSION['COMPANY_ID'], $linsert_id));

        echo convertd_page($linsert_id, 'editpurchase_order.htm', 'process');
    }
    /*$s = 0;
    foreach ($qtys as $ko => $val) {

        if ($val > 0) {
            if ($s == 0) {
                $getmanuf = $db->prepare("SELECT * FROM `purchase_order` ORDER BY `PoID` DESC");
                $getmanuf->execute();
                $lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

                if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
                    $val1 = 1;
                    $purid = 'POI' . str_pad(1, 8, '0', STR_PAD_LEFT);
                } else {
                    $val1 = $lst['PoID'] + 1;
                    $purid = 'POI' . str_pad($val1, 8, '0', STR_PAD_LEFT);
                }
                $purid = get_bill_settings('prefix', '7') . str_pad(get_bill_settings('current_value', '7'), get_bill_settings('format', '7'), '0', STR_PAD_LEFT);
                $resa = $db->prepare("INSERT INTO `purchase_order` (`PONumber`,`PODate`,`TaxType`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`Sales_order`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "','" . $so_id . "' FROM `sales_order` WHERE `PoID` = ?");
                $resa->execute(array($so_id));
                $linsert_id = $db->lastInsertId();
                $s++;
                update_bill_value('7');
            }
            $getponumber = getsalesorder('PONumber', $so_id);
            $resa = $db->prepare("INSERT INTO `purchase_order_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, '" . $suppliers[$ko] . "', `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, '$val', `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "' FROM `sales_order_details` WHERE `PoNum` = ? AND `PoID` =? AND `Item`=?");
            $resa->execute(array($getponumber, $so_id, $products[$ko]));
        }
    }*/    
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Raised</h4></div>';

    return $res;
}


function Clone_Enquiry($enqid) {

    global $db;    
    $purid = get_bill_settings('prefix', '1') . str_pad(get_bill_settings('current_value', '1'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);

    $resa = $db->prepare("INSERT INTO `purchase_enquiry` (`PONumber`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`status_approve`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "',`status_approve`,'".$_SESSION['COMPANY_ID']."' FROM `purchase_enquiry` WHERE `company_id`=? AND `PoID`=?");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('1');
    $getponumber = getpurchaseEnquiry('PONumber', $enqid);
    
    $equ_enq_ids = array();
    $enq_details = $db->prepare("SELECT * FROM `purchase_enquiry_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? ORDER BY `PdID` ASC");
    $enq_details->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enqid));
    while($fetch_data = $enq_details->fetch()){
        $resa = $db->prepare("INSERT INTO `purchase_enquiry_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`) VALUES ('" . $purid . "', '" . $linsert_id . "', '".$fetch_data['Item']."', '".$fetch_data['supplier_id']."', '".$fetch_data['Qty']."', '".$fetch_data['QtyPerPack']."', '".$fetch_data['PackUoM']."', '".$fetch_data['ItemUoM']."', '".$fetch_data['TotalQty']."','".$fetch_data['PackRate']."', '".$fetch_data['ItemRate']."', '".$fetch_data['TaxName']."', '".$fetch_data['TaxableAmt']."', '".$fetch_data['TaxAmt']."', '".$fetch_data['Amount']."', '" . $_SERVER['REMOTE_ADDR'] . "','".$fetch_data['Currency']."',?,'".$fetch_data['display_order']."', '".$_SESSION['COMPANY_ID']."')");
        $resa->execute(array($fetch_data['Comments']));
        $equ_enq_ids[$fetch_data['PdID']] = $db->lastInsertId();
    }    
    
   /*$resa = $db->prepare("INSERT INTO `purchase_enquiry_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments` FROM `purchase_enquiry_details` WHERE `PoNum` = ? AND `PoID`=? ORDER BY `PdID` ASC");
    $resa->execute(array($getponumber, $enqid));*/

    
    $old_im = $db->prepare("SELECT * FROM `item_mapping` WHERE `company_id`=? AND `type`=? AND `type_id`=?");
    $old_im->execute(array($_SESSION['COMPANY_ID'], 'enquiry',$enqid));
    while($fetch_old_im = $old_im->fetch()){     
        $nid = $equ_enq_ids[$fetch_old_im['type_details_id']]!='' ? $equ_enq_ids[$fetch_old_im['type_details_id']] : 0;
        $resa = $db->prepare("INSERT INTO `item_mapping` (`type`,`type_id`,`type_details_id`,`supplier`,`product`,`ip`,`company_id`) VALUES ('enquiry','" . $linsert_id . "','".$nid."','".$fetch_old_im['supplier']."','".$fetch_old_im['product']."','" . $_SERVER['REMOTE_ADDR'] . "', '".$_SESSION['COMPANY_ID']."')");
        $resa->execute();
    }    

    
 /*   $resa = $db->prepare("INSERT INTO `item_mapping` (`type`,`type_id`,`supplier`,`product`,`ip`) SELECT `type`,'" . $linsert_id . "',`supplier`,`product`,'" . $_SERVER['REMOTE_ADDR'] . "' FROM `item_mapping` WHERE `type`=? AND `type_id`=? ORDER BY `id` ASC");
    $resa->execute(array('enquiry', $enqid));*/

    echo convertd_page($linsert_id, 'editenquiry.htm', 'process');

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Cloned</h4></div>';

    return $res;
}

function Clone_Sales_Quote($enqid) {

    global $db;    
    $purid = get_bill_settings('prefix', '5') . str_pad(get_bill_settings('current_value', '5'), get_bill_settings('format', '5'), '0', STR_PAD_LEFT);

    $resa = $db->prepare("INSERT INTO `sales_quote` (`PONumber`,`PODate`,`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`Discount`,`Validity`,`Deliverydays`,`IP`,`Updated_by`,`status_approve`,`company_id`) SELECT '" . $purid . "','" . date("Y-m-d") . "',`TaxType`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`Discount`,`Validity`,`Deliverydays`,'" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['UID'] . "',`status_approve`,'".$_SESSION['COMPANY_ID']."' FROM `sales_quote` WHERE `company_id`=? AND `PoID`=?");   
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));
    $linsert_id = $db->lastInsertId();
    update_bill_value('5');
    $getponumber = getsalesquote('PONumber', $enqid);
    
    
    $equ_sq_ids = array();
    $enq_details = $db->prepare("SELECT * FROM `sales_quote_details` WHERE `company_id`=? AND `PoNum` = ? AND `PoID` =? ORDER BY `PdID` ASC");
    $enq_details->execute(array($_SESSION['COMPANY_ID'], $getponumber, $enqid));
    while($fetch_data = $enq_details->fetch()){
        $resa = $db->prepare("INSERT INTO `sales_quote_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`Discount_per`,`Discount`,`display_order`,`company_id`) VALUES ('" . $purid . "', '" . $linsert_id . "', '".$fetch_data['Item']."', '".$fetch_data['supplier_id']."', '".$fetch_data['Qty']."', '".$fetch_data['QtyPerPack']."', '".$fetch_data['PackUoM']."', '".$fetch_data['ItemUoM']."', '".$fetch_data['TotalQty']."','".$fetch_data['Margin']."','".$fetch_data['product_rate_hidden']."','".$fetch_data['PackRate']."', '".$fetch_data['ItemRate']."', '".$fetch_data['TaxName']."', '".$fetch_data['TaxableAmt']."', '".$fetch_data['TaxAmt']."', '".$fetch_data['Amount']."', '" . $_SERVER['REMOTE_ADDR'] . "','".$fetch_data['Currency']."',?,'".$fetch_data['Discount_per']."','".$fetch_data['Discount']."','".$fetch_data['display_order']."', '".$_SESSION['COMPANY_ID']."')");
        $resa->execute(array($fetch_data['Comments']));
        $equ_sq_ids[$fetch_data['PdID']] = $db->lastInsertId();
    }    
    
    /*$resa = $db->prepare("INSERT INTO `sales_quote_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`,`Discount_per`,`Discount`, `Amount`, `IP`,`Currency`,`Comments`,`Margin`,`product_rate_hidden`)  SELECT '" . $purid . "', '" . $linsert_id . "', `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`,`Discount_per`,`Discount`, `Amount`, '" . $_SERVER['REMOTE_ADDR'] . "',`Currency`,`Comments`,`Margin`,`product_rate_hidden` FROM `sales_quote_details` WHERE `PoNum` = ? AND `PoID`=? ORDER BY `PdID` ASC");
    $resa->execute(array($getponumber, $enqid));*/

    /*$resa = $db->prepare("INSERT INTO `item_mapping` (`type`,`type_id`,`supplier`,`product`,`ip`) SELECT `type`,'" . $linsert_id . "',`supplier`,`product`,'" . $_SERVER['REMOTE_ADDR'] . "' FROM `item_mapping` WHERE `type`=? AND `type_id`=? ORDER BY `id` ASC");
    $resa->execute(array('sales_quote', $enqid));
*/
    
    $old_im = $db->prepare("SELECT * FROM `item_mapping` WHERE `company_id`=? AND `type`=? AND `type_id`=?");
    $old_im->execute(array($_SESSION['COMPANY_ID'], 'sales_quote',$enqid));
    while($fetch_old_im = $old_im->fetch()){     
        $nid = $equ_sq_ids[$fetch_old_im['type_details_id']]!='' ? $equ_sq_ids[$fetch_old_im['type_details_id']] : 0;
        $resa = $db->prepare("INSERT INTO `item_mapping` (`type`,`type_id`,`type_details_id`,`supplier`,`product`,`ip`,`company_id`) VALUES ('sales_quote','" . $linsert_id . "','".$nid."','".$fetch_old_im['supplier']."','".$fetch_old_im['product']."','" . $_SERVER['REMOTE_ADDR'] . "','".$_SESSION['COMPANY_ID']."')");
        $resa->execute();
    }    

    $resa = $db->prepare("INSERT INTO `sales_othercharges` (`salesid`,`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,`company_id`) SELECT '" . $linsert_id . "',`Name`,`Amount`,`Tax`,`Taxable_Amt`,`Tax_Amt`,`Total_Amt`,`Description`,`Status`,'".$_SESSION['COMPANY_ID']."' FROM `sales_othercharges` WHERE `company_id`=? AND `salesid`=? ORDER BY `OSID` ASC");
    $resa->execute(array($_SESSION['COMPANY_ID'], $enqid));

    echo convertd_page($linsert_id, 'editquote.htm', 'process');

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Cloned</h4></div>';

    return $res;
}

function addrfq($invno, $billdate, $taxtype, $supplierprimary, $netpayamt, $status_app, $subtotal, $subtaxtotal, $Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $CusID,$Comments, $id) {
    global $db;

    if ($deliveryterms == '') {
        $deliveryterms = 0;
    }if ($modeofshipment == '') {
        $modeofshipment = 0;
    }if ($enquirycurrency == '') {
        $enquirycurrency = 0;
    }if ($modeofpayment == '') {
        $modeofpayment = 0;
    }if ($paymentterms == '') {
        $paymentterms = 0;
    }if ($enquirytype == '') {
        $enquirytype = 0;
    }if ($vessel == '') {
        $vessel = 0;
    }if ($salesrep == '') {
        $salesrep = 0;
    }
    $Modeofpayment  = getsupplier('paymentmode', $supplierprimary);
    if($Modeofpayment == ''){
        $Modeofpayment = 0;
    }
    $payment_terms  = getsupplier('paymentterm', $supplierprimary);
    if($payment_terms == ''){
        $payment_terms = 0;
    }
    if ($id == '') {
        try {
            $db->beginTransaction();
            $invno = get_bill_settings('prefix', '4') . str_pad(get_bill_settings('current_value', '4'), get_bill_settings('format', '4'), '0', STR_PAD_LEFT);
            $resa = $db->prepare("INSERT INTO  `rfq` (`PONumber`,`PODate`,`TaxType`,`status_approve`,`supplier`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($invno, date('Y-m-d', strtotime($billdate)), getsupplier('TaxType', $supplierprimary), $status_app, $supplierprimary, $CusID, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, $enquirycurrency, $Modeofpayment,$payment_terms , $enquirytype, $vessel, $salesrep, $ip, $_SESSION['UID'],$_SESSION['COMPANY_ID']));

            $insert_id = $db->lastInsertId();
            $i = 0;
            $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($taxname) = null_zero(explode("#@#", $tax[$i]));
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i]) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i]));
                $resa = $db->prepare("INSERT INTO `rfq_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `Comments`, `IP`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Comments[$i], $ip,$do,$_SESSION['COMPANY_ID']));
                $i++;
            }
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('RFQ', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));

            $db->commit();
            update_bill_value('4');
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $_SESSION['sucmsg'] = $res;
        } catch (PDOException $e) {
            $db->rollBack();
            $res = $e->getMessage();
        }
    } else {
        try {
            $db->beginTransaction();

            $resa = $db->prepare("UPDATE `rfq` SET `CusID`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`status_approve`=?,`supplier`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`IP`=?,`Updated_by`=? Where `company_id`=? AND PoID=?");
            $resa->execute(array($CusID, $invno, date('Y-m-d', strtotime($billdate)), getsupplier('TaxType', $supplierprimary), $status_app, $supplierprimary, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, $enquirycurrency, $Modeofpayment, $payment_terms, $enquirytype, $vessel, $salesrep, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'],$id));
            $i = 0;
            $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i]) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i]));
                if ($purchase_detailid[$i] == 'NEW') {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("INSERT INTO `rfq_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `Comments`,`IP`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $Comments[$i],$ip,$do,$_SESSION['COMPANY_ID']));
                } else {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("UPDATE `rfq_details` SET `PoNum`=?, `PoID`=?, `Item`=?,`supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=?,`Comments`=?, `IP`=?, `display_order`=?  WHERE `company_id`=? AND `PdID`=?");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Comments[$i], $ip,$do, $_SESSION['COMPANY_ID'],$purchase_detailid[$i]));
                }
                $i++;
            }

            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();
            die($e->getMessage());
        }
    }
    return array($res, $insert_id);
}

function delrfq($a) {
    $ip = $_SERVER['REMOTE_ADDR'];
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $get1 = $db->prepare("DELETE FROM `rfq_details`  WHERE `company_id`=? AND `PoNum` =? AND `PoID` =? ");
        $get1->execute(array($_SESSION['COMPANY_ID'], getpurchaseorderdetails('PoNum', $c), $c));

        $get = $db->prepare("DELETE FROM `rfq` WHERE `company_id`=? AND `PoID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('rfq', 3, 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

function getrfq($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `rfq` WHERE `company_id`=? AND `PoID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addsalesquote($invno, $billdate, $taxtype,$ref_no, $netpayamt, $status_app, $subtotal, $subtaxtotal, $product_suppliers,$Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty,$Margin,$product_rate_hidden, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $Discount_per, $Discount, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $validity, $deliverydays, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $othercharges, $CusID,$discount_total, $others_name, $others_amount, $others_tax, $others_taxable_amt, $others_tax_amt, $others_amount_total, $others_description, $others_ids,$icurrency,$Comments, $id) {
    global $db;
 $icurrency = getcustomer('Currency', $CusID);
    if ($deliveryterms == '') {
        $deliveryterms = 0;
    }if ($modeofshipment == '') {
        $modeofshipment = 0;
    }if ($validity == '') {
        $validity = 0;
    }if ($deliverydays == '') {
        $deliverydays = 0;
    }if ($enquirycurrency == '') {
        $enquirycurrency = 0;
    }if ($modeofpayment == '') {
        $modeofpayment = 0;
    }if ($paymentterms == '') {
        $paymentterms = 0;
    }if ($enquirytype == '') {
        $enquirytype = 0;
    }if ($vessel == '') {
        $vessel = 0;
    }if ($salesrep == '') {
        $salesrep = 0;
    }
    list($taxtype) = null_zero(array($taxtype));
    if ($id == '') {
        try {
            $db->beginTransaction();
            $invno = get_bill_settings('prefix', '5') . str_pad(get_bill_settings('current_value', '5'), get_bill_settings('format', '5'), '0', STR_PAD_LEFT);
            $resa = $db->prepare("INSERT INTO  `sales_quote` (`PONumber`,`PODate`,`TaxType`,`status_approve`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Validity`,`Deliverydays`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`Discount`,`IP`,`Updated_by`,`ref_no`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID), $status_app, $CusID, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, $validity, $deliverydays,getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $othercharges,$discount_total, $ip, $_SESSION['UID'],$ref_no,$_SESSION['COMPANY_ID']));

            $insert_id = $db->lastInsertId();
            $i = 0; $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($taxname) = null_zero(explode("#@#", $tax[$i]));          
                list($suppliergird[$i],$Pack_qty[$i],$Pack_UOM[$i],$Item_UOM[$i],$Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i],$Pack_qty[$i],$Pack_UOM[$i],$Item_UOM[$i],$Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency));
                $resa = $db->prepare("INSERT INTO `sales_quote_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`,`Discount_per`,`Discount`, `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                $nsid = $db->lastInsertId();
                if($product_suppliers[$i]!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=?,`company_id`=?");
                    $sim->execute(array('sales_quote', $insert_id,$nsid, $Item_name[$i], $product_suppliers[$i], $_SERVER['REMOTE_ADDR'], $_SESSION['COMPANY_ID']));           
                }
                $i++;
            }

            foreach ($others_name as $v => $oname) {
                list($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]) = null_zero(array($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]));
                if ($oname != '') {
                    $oc = $db->prepare("INSERT INTO `sales_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?, `company_id`=? ");
                    $oc->execute(array($insert_id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1',$_SESSION['COMPANY_ID']));
                }
            }
            
            /*foreach($product_suppliers as $s => $product_supplierss){
                if($product_supplierss!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`product`=?,`supplier`=?,`ip`=?");
                    $sim->execute(array('sales_quote', $insert_id, $Item_name[$s], $product_supplierss, $_SERVER['REMOTE_ADDR']));                
                }
            }*/
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('sales_quote', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));

            $db->commit();
            update_bill_value('5');
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $_SESSION['sucmsg'] = $res;
        } catch (PDOException $e) {
            $db->rollBack();
            $res = $e->getMessage();
        }
    } else {
        try {
            $db->beginTransaction();

            $resa = $db->prepare("UPDATE `sales_quote` SET `CusID`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`status_approve`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Validity`=?,`Deliverydays`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?, `Othercharges`=?,`Discount`=?,`IP`=?,`Updated_by`=?,`ref_no`=? WHERE `company_id`=? AND PoID=?");
            $resa->execute(array($CusID, $invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID), $status_app, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, $validity, $deliverydays, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $othercharges,$discount_total, $ip, $_SESSION['UID'],$ref_no, $_SESSION['COMPANY_ID'], $id));
            $i = 0; $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($suppliergird[$i],$Pack_qty[$i],$Pack_UOM[$i],$Item_UOM[$i],$Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i],$Pack_qty[$i],$Pack_UOM[$i],$Item_UOM[$i],$Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency));
                if ($purchase_detailid[$i] == 'NEW') {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("INSERT INTO `sales_quote_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`,`Discount_per`,`Discount`, `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                    $nsid = $db->lastInsertId();
                if($product_suppliers[$i]!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=?,`company_id`=? ");
                    $sim->execute(array('sales_quote', $id,$nsid, $Item_name[$i], $product_suppliers[$i], $_SERVER['REMOTE_ADDR'],$_SESSION['COMPANY_ID']));                                
                }
                } else {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("UPDATE `sales_quote_details` SET `PoNum`=?, `PoID`=?, `Item`=?,`supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?,`Margin`=?,`product_rate_hidden`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?,`Discount_per`=?,`Discount`=?, `Amount`=?, `IP`=?,`Currency`=?,`Comments`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do, $_SESSION['COMPANY_ID'], $purchase_detailid[$i]));
                }
                $i++;
            }

            foreach ($others_name as $v => $oname) {
                list($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]) = null_zero(array($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]));
                if ($others_ids[$v] != '') {
                    $oc = $db->prepare("UPDATE `sales_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `company_id`=? AND `OSID`=?");
                    $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1', $_SESSION['COMPANY_ID'], $others_ids[$v]));
                } else {
                    if ($oname != '') {
                        $oc = $db->prepare("INSERT INTO `sales_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? ");
                        $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1',$_SESSION['COMPANY_ID']));
                    }
                }
            }
            
           /* foreach($product_suppliers as $s => $product_supplierss){
                if($product_supplierss!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`product`=?,`supplier`=?,`ip`=?");
                    $sim->execute(array('sales_quote', $id, $Item_name[$s], $product_supplierss, $_SERVER['REMOTE_ADDR']));                
                }
            }*/

            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();
            die($e->getMessage());
        }
    }
    return array($res,$insert_id);
}

function delsalesquote($a) {
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);

    foreach ($b as $c) {
        $get1 = $db->prepare("DELETE FROM `sales_quote_details` WHERE `company_id`=? AND `PoNum`=? AND `PoID`=? ");
        $get1->execute(array($_SESSION['COMPANY_ID'], getsalesquote('PoNum', $c), $c));

        if (getsalesquote('purchase_enquiry_id', $c) > 0) {
            $resa = $db->prepare("UPDATE `purchase_enquiry` SET `convert_to_sales_quote`='0',`converted_sales_quote_id`='0' WHERE `company_id`=? AND `PoID` = ?");
            $resa->execute(array($_SESSION['COMPANY_ID'], getsalesquote('purchase_enquiry_id', $c)));
        }

        $get1 = $db->prepare("DELETE FROM `item_mapping`  WHERE `company_id`=? AND `type` =? AND `type_id` =? ");
        $get1->execute(array($_SESSION['COMPANY_ID'], 'sales_quote', $c));
        $get1 = $db->prepare("DELETE FROM `sales_othercharges`  WHERE `company_id`=? AND `salesid` =?");
        $get1->execute(array($_SESSION['COMPANY_ID'], $c));

        $get = $db->prepare("DELETE FROM `sales_quote` WHERE `company_id`=? AND `PoID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Sales Quote', 3, 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));
    }

    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Successfully Deleted</h4></div>';
    return $res;
}

function getsalesquote($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `sales_quote` WHERE `company_id`=? AND `PoID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addsalesorder($invno, $billdate, $taxtype,$po_ref_no, $netpayamt, $status_app, $subtotal, $subtaxtotal,$product_suppliers, $Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty,$Margin,$product_rate_hidden, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt,$Discount_per, $Discount, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $CusID,$oc,$discount_total, $A_Qty, $others_name, $others_amount, $others_tax, $others_taxable_amt, $others_tax_amt, $others_amount_total, $others_description, $others_ids,$icurrency,$Comments, $id) {
    global $db;
$icurrency = getcustomer('Currency', $CusID);
    if ($deliveryterms == '') {
        $deliveryterms = 0;
    }if ($modeofshipment == '') {
        $modeofshipment = 0;
    }if ($enquirycurrency == '') {
        $enquirycurrency = 0;
    }if ($modeofpayment == '') {
        $modeofpayment = 0;
    }if ($paymentterms == '') {
        $paymentterms = 0;
    }if ($enquirytype == '') {
        $enquirytype = 0;
    }if ($vessel == '') {
        $vessel = 0;
    }if ($salesrep == '') {
        $salesrep = 0;
    }
    if ($id == '') {
        try {
            $db->beginTransaction();
            $invno = get_bill_settings('prefix', '6') . str_pad(get_bill_settings('current_value', '6'), get_bill_settings('format', '6'), '0', STR_PAD_LEFT);
            $resa = $db->prepare("INSERT INTO  `sales_order` (`PONumber`,`PODate`,`TaxType`,`po_ref_no`,`status_approve`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`Discount`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID),$po_ref_no, $status_app, $CusID, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep,$oc,$discount_total, $ip, $_SESSION['UID'],$_SESSION['COMPANY_ID']));

            $insert_id = $db->lastInsertId();
            $i = 0; $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($taxname) = null_zero(explode("#@#", $tax[$i]));
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $A_Qty[$i], $icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $A_Qty[$i], $icurrency));
                $resa = $db->prepare("INSERT INTO `sales_order_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`A_Qty`, `Currency`,`Discount`,`Discount_per`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $A_Qty[$i], $icurrency,$Discount[$i],$Discount_per[$i],$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                $nsid = $db->lastInsertId();
                if($product_suppliers[$i]!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=?,`company_id`=? ");
                    $sim->execute(array('sales_order', $insert_id,$nsid, $Item_name[$i], $product_suppliers[$i], $_SERVER['REMOTE_ADDR'], $_SESSION['COMPANY_ID']));                
                }
                $i++;
            }
            foreach ($others_name as $v => $oname) {
                list($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]) = null_zero(array($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]));
                if ($oname != '') {
                    $oc = $db->prepare("INSERT INTO `sales_order_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?, `company_id`=? ");
                    $oc->execute(array($insert_id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1',$_SESSION['COMPANY_ID']));
                }
            }
            
            /*foreach($product_suppliers as $s => $product_supplierss){
                if($product_supplierss!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`product`=?,`supplier`=?,`ip`=?");
                    $sim->execute(array('sales_order', $insert_id, $Item_name[$s], $product_supplierss, $_SERVER['REMOTE_ADDR']));                
                }
            }*/
            
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('sales_order', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));

            $db->commit();
            update_bill_value('6');
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $_SESSION['sucmsg'] = $res;
        } catch (PDOException $e) {
            $db->rollBack();
            print_r($e);
            die($res = $e->getMessage());
            
        }
    } else {
        try {
            $db->beginTransaction();

            $resa = $db->prepare("UPDATE `sales_order` SET `CusID`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`po_ref_no`=?,`status_approve`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`Othercharges`=?,`Discount`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND PoID=?");
            $resa->execute(array($CusID, $invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID),$po_ref_no, $status_app, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep,$oc,$discount_total, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $i = 0; $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $A_Qty[$i], $icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $A_Qty[$i], $icurrency));
                if ($purchase_detailid[$i] == 'NEW') {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("INSERT INTO `sales_order_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`A_Qty`, `Currency`,`Discount`,`Discount_per`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $A_Qty[$i], $icurrency,$Discount[$i],$Discount_per[$i],$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                    $nsid = $db->lastInsertId();
                if($product_suppliers[$i]!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`type_details_id`=?,`product`=?,`supplier`=?,`ip`=?,`company_id`=? ");
                    $sim->execute(array('sales_order', $id,$nsid, $Item_name[$i], $product_suppliers[$i], $_SERVER['REMOTE_ADDR'], $_SESSION['COMPANY_ID']));                
                }
                } else {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("UPDATE `sales_order_details` SET `PoNum`=?, `PoID`=?, `Item`=?,`supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?,`Margin`=?,`product_rate_hidden`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=?, `IP`=?,`A_Qty`=?, `Currency`=?,`Discount`=?,`Discount_per`=?,`Comments`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $A_Qty[$i], $icurrency,$Discount[$i],$Discount_per[$i],$Comments[$i],$do, $_SESSION['COMPANY_ID'], $purchase_detailid[$i]));
                }
                $i++;
            }
            foreach ($others_name as $v => $oname) {
                list($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]) = null_zero(array($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]));
                if ($others_ids[$v] != '') {
                    $oc = $db->prepare("UPDATE `sales_order_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `company_id`=? AND `OSID`=?");
                    $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1', $_SESSION['COMPANY_ID'], $others_ids[$v]));
                } else {
                    if ($oname != '') {
                        $oc = $db->prepare("INSERT INTO `sales_order_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? ");
                        $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1',$_SESSION['COMPANY_ID']));
                    }
                }
            }
            
            /*foreach($product_suppliers as $s => $product_supplierss){
                if($product_supplierss!=''){
                    $sim = $db->prepare("INSERT INTO `item_mapping` SET `type`=?,`type_id`=?,`product`=?,`supplier`=?,`ip`=?");
                    $sim->execute(array('sales_order', $id, $Item_name[$s], $product_supplierss, $_SERVER['REMOTE_ADDR']));                
                }
            }*/
            
            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();
            die($e->getMessage());
        }
    }
    return array($res,$insert_id);
}

function delsalesorder($a) {
    $ip = $_SERVER['REMOTE_ADDR'];
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $get1 = $db->prepare("DELETE FROM `sales_order_details`  WHERE `company_id`=? AND `PoID` =? ");
        $get1->execute(array($_SESSION['COMPANY_ID'], $c));

        if (getsalesorder('Sales_quote', $c) > 0) {
            $resa = $db->prepare("UPDATE `sales_quote` SET `Converted`='0',`converted_sales_order_id`='0' WHERE `company_id`=? AND `PoID` = ?");
            $resa->execute(array($_SESSION['COMPANY_ID'],getsalesorder('Sales_quote', $c)));
        }
        $get1 = $db->prepare("DELETE FROM `item_mapping`  WHERE `company_id`=? AND `type` =? AND `type_id` =? ");
        $get1->execute(array($_SESSION['COMPANY_ID'], 'sales_order', $c));

        $get = $db->prepare("DELETE FROM `sales_order` WHERE `company_id`=? AND `PoID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));

        $get1 = $db->prepare("DELETE FROM `sales_order_othercharges`  WHERE `company_id`=? AND `salesid` =?");
        $get1->execute(array($_SESSION['COMPANY_ID'], $c));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('sales_order', 3, 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

function getsalesorder($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `sales_order` WHERE `company_id`=? AND `PoID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function adddeliverynote($invno, $billdate, $taxtype,$ref_no, $netpayamt, $status_app, $subtotal, $subtaxtotal, $Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty,$Margin,$product_rate_hidden, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $othercharges, $CusID, $ship_address,$ship_address2, $ship_country, $ship_state, $ship_city, $ship_pincode, $others_name, $others_amount, $others_tax, $others_taxable_amt, $others_tax_amt, $others_amount_total, $others_description, $others_ids,$icurrency, $Comments,$id) {
    global $db;
$icurrency = getcustomer('Currency', $CusID);
    if ($deliveryterms == '') {
        $deliveryterms = 0;
    }if ($modeofshipment == '') {
        $modeofshipment = 0;
    }if ($enquirycurrency == '') {
        $enquirycurrency = 0;
    }if ($modeofpayment == '') {
        $modeofpayment = 0;
    }if ($paymentterms == '') {
        $paymentterms = 0;
    }if ($enquirytype == '') {
        $enquirytype = 0;
    }if ($vessel == '') {
        $vessel = 0;
    }if ($salesrep == '') {
        $salesrep = 0;
    }
   
    if ($id == '') {
        try {
            $db->beginTransaction();
            $invno = get_bill_settings('prefix', '9') . str_pad(get_bill_settings('current_value', '9'), get_bill_settings('format', '9'), '0', STR_PAD_LEFT);
            $resa = $db->prepare("INSERT INTO  `delivery_note` (`PONumber`,`PODate`,`TaxType`,`status_approve`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`IP`,`Updated_by`,`ship_address`,`ship_address2`,`ship_country`,`ship_state`,`ship_city`,`ship_pincode`,`ref_no`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID), $status_app, $CusID, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $othercharges, $ip, $_SESSION['UID'], $ship_address,$ship_address2, $ship_country, $ship_state, $ship_city, $ship_pincode,$ref_no,$_SESSION['COMPANY_ID']));

            $insert_id = $db->lastInsertId();

            // add_transaction($invno,$billdate,getledger_by_field('lid',$CusID,'customer_id'),$netpayamt,$insert_id,'Delivery_note','D');

            $i = 0;
           $do = 0;
            foreach ($Item_name as $netpay) {
                $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency));        
                list($taxname) = null_zero(explode("#@#", $tax[$i]));
                $resa = $db->prepare("INSERT INTO `delivery_note_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`, `Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));

                stock_add($insert_id, 'DC', 'L', 'Delivery_note', $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], date('Y-m-d', strtotime($billdate)));

                /*    if($taxtype == '0'){
                  $taxl = '78';
                  add_transaction($invno,$billdate,$taxl,$Net_Amt[$i],$insert_id,'Delivery_note','C');
                  }else{
                  $taxlp = getledger('lid',gettax1('pledger',$taxname));
                  $taxli= getledger('lid',gettax1('iledger',$taxname));
                  add_transaction($invno,$billdate,$taxlp,$Taxable_Amt[$i],$insert_id,'Delivery_note','C');
                  add_transaction($invno,$billdate,$taxli,$Tax_Amt[$i],$insert_id,'Delivery_note','C');
                  } */

                $i++;
            }

            /*foreach ($others_name as $v => $oname) {
                if ($oname != '') {
                    $oc = $db->prepare("INSERT INTO `delivery_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?");
                    $oc->execute(array($insert_id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1'));
                    // $taxli = getledger('lid',getotherterms('Ledger_id',$oname));
                    // add_transaction($invno,$billdate,$taxli,$others_amount[$v],$insert_id,'Delivery_note','C');
                }
            }*/

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('delivery_note', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));

            $db->commit();
            update_bill_value('9');
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $_SESSION['sucmsg'] = $res;
        } catch (PDOException $e) {
            $db->rollBack();
            $res = $e->getMessage();
            $_SESSION['sucmsg'] = $res;
        }
    } else {
        try {
            $db->beginTransaction();
            $resa = $db->prepare("UPDATE `delivery_note` SET `CusID`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`status_approve`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`Othercharges`=?,`IP`=?,`Updated_by`=?,`ship_address`=?,`ship_address2`=?,`ship_country`=?,`ship_state`=?,`ship_city`=?,`ship_pincode`=?,`ref_no`=? WHERE `company_id`=? AND `PoID` =?");
            $resa->execute(array($CusID, $invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID), $status_app, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $othercharges, $ip, $_SESSION['UID'], $ship_address,$ship_address2, $ship_country, $ship_state, $ship_city, $ship_pincode,$ref_no,$_SESSION['COMPANY_ID'], $id));
            $i = 0; $do = 0;
            stock_del($id, 'DC');
            // transaction_del($id,'Delivery_note');
            // add_transaction($invno,$billdate,getledger_by_field('lid',$CusID,'customer_id'),$netpayamt,$id,'Delivery_note','D');
            foreach ($Item_name as $netpay) { $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency)); 
                if ($purchase_detailid[$i] == 'NEW') {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("INSERT INTO `delivery_note_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                } else {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("UPDATE `delivery_note_details` SET `PoNum`=?, `PoID`=?, `Item`=?,`supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?,`Margin`=?,`product_rate_hidden`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=?, `IP`=?,`Currency`=?, `Comments`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip,$icurrency, $Comments[$i],$do, $_SESSION['COMPANY_ID'], $purchase_detailid[$i],));
                }
                stock_add($id, 'DC', 'L', 'Delivery_note', $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], date('Y-m-d', strtotime($billdate)));

                /*    if($taxtype == '0'){
                  $taxl = '78';
                  add_transaction($invno,$billdate,$taxl,$Net_Amt[$i],$id,'Delivery_note','C');
                  }else{
                  $taxlp = getledger('lid',gettax1('pledger',$taxname));
                  $taxli= getledger('lid',gettax1('iledger',$taxname));
                  add_transaction($invno,$billdate,$taxlp,$Taxable_Amt[$i],$id,'Delivery_note','C');
                  add_transaction($invno,$billdate,$taxli,$Tax_Amt[$i],$id,'Delivery_note','C');
                  } */

                $i++;
            }

            /*foreach ($others_name as $v => $oname) {
                if ($others_ids[$v] != '') {
                    $oc = $db->prepare("UPDATE `delivery_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `OSID`=?");
                    $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1', $others_ids[$v]));
                } else {
                    if ($oname != '') {
                        $oc = $db->prepare("INSERT INTO `delivery_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?");
                        $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1'));
                        //$taxli = getledger('lid',getotherterms('Ledger_id',$oname));
                        //add_transaction($invno,$billdate,$taxli,$others_amount[$v],$insert_id,'Delivery_note','C');
                    }
                }
            }*/

            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();
            die($e->getMessage());
        }
    }
    return array($res,$insert_id);
}

function deldeliverynote($a) {
    $ip = $_SERVER['REMOTE_ADDR'];
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        transaction_del($c, 'Delivery_note');
        $get1 = $db->prepare("DELETE FROM `delivery_note_details` WHERE `company_id`=? AND `PoID` =? ");
        $get1->execute(array($_SESSION['COMPANY_ID'], $c));

        if (getdeliverynote('Sales_order', $c) > 0) {
            $resa = $db->prepare("UPDATE `sales_order` SET `Converted`='0',`converted_delivery_note_id`='0' WHERE `company_id`=? AND `PoID` = ?");
            $resa->execute(array(getdeliverynote('Sales_order',$_SESSION['COMPANY_ID'],  $c)));
        }

        $get = $db->prepare("DELETE FROM `delivery_note` WHERE `company_id`=? AND `PoID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));

        $get1 = $db->prepare("DELETE FROM `delivery_othercharges`  WHERE `company_id`=? AND `salesid` =?");
        $get1->execute(array($_SESSION['COMPANY_ID'], $c));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('sales_order', 3, 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

function getdeliverynote($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `delivery_note` WHERE `company_id`=? AND `PoID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addinvoice($invno, $manual, $billdate, $taxtype, $status_app,$ref_no, $netpayamt, $subtotal, $subtaxtotal,$bank, $Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty,$Margin,$product_rate_hidden, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $Discount_per, $Discount, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $CusID,$discount_total, $oc, $others_name, $others_amount, $others_tax, $others_taxable_amt, $others_tax_amt, $others_amount_total, $others_description, $others_ids, $icurrency,$Comments,$id) {
    global $db;
	$icurrency = getcustomer('Currency', $CusID);
    if ($deliveryterms == '') {
        $deliveryterms = 0;
    }
	if ($modeofshipment == '') {
        $modeofshipment = 0;
    }
	if ($enquirycurrency == '') {
        $enquirycurrency = 0;
    }
	if ($modeofpayment == '') {
        $modeofpayment = 0;
    }
	if ($paymentterms == '') {
        $paymentterms = 0;
    }
	if ($enquirytype == '') {
        $enquirytype = 0;
    }
	if ($vessel == '') {
        $vessel = 0;
    }
	if ($salesrep == '') {
        $salesrep = 0;
    }
	if ($bank == '') {
        $bank = 0;
    }
    
    if ($id=='')
	{
        try {
            $db->beginTransaction();
            if ($manual == '1') {
                
            } else {
                $invno = get_bill_settings('prefix', '4') . str_pad(get_bill_settings('current_value', '4'), get_bill_settings('format', '4'), '0', STR_PAD_LEFT);
            }

            $resa = $db->prepare("INSERT INTO  `invoice` (`PONumber`,`PODate`,`TaxType`,`status_approve`,`ref_no`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`Discount`,`IP`,`Updated_by`,`bank`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID), $status_app,$ref_no, $CusID, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $oc, $discount_total, $ip, $_SESSION['UID'],$bank,$_SESSION['COMPANY_ID']));

            $insert_id = $db->lastInsertId();

            add_transaction($invno, $billdate, getledger_by_field('lid', $CusID, 'customer_id'), $netpayamt, $insert_id, 'SALES', 'D');

            $i = 0; $do = 0;
            foreach ($Item_name as $netpay) { $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency));
                list($taxname) = null_zero(explode("#@#", $tax[$i]));
                $resa = $db->prepare("INSERT INTO `invoice_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Discount_per`,`Discount`,`Amount`, `IP`,`Currency`,`Comments`,`display_order` ,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                
                $gettype=FETCH_all("SELECT `conversion`,`conversion_type`,`Item_Id` FROM `item_master` WHERE `Item_Id`=?",$Item_name[$i]);
                $conv = FETCH_all("SELECT `id` FROM `conversion` WHERE `item`=?", $gettype['Item_Id']);
                if ($conv['id'] != '') {
                    $conid = pFETCH("SELECT * FROM `conversion_details` WHERE `conversion_id`=?", $conv['id']);
                    while ($fcon = $conid->fetch()) {
                        stock_add($insert_id, 'SR', 'L', 'SALES', $fcon['item'], $suppliergird[$i], $fcon['qty'], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $fcon['sale_rate'], $fcon['sale_rate'], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $fcon['sale_rate'], date('Y-m-d', strtotime($billdate)));
                    }
                } else {
                    stock_add($insert_id, 'SR', 'L', 'SALES', $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], date('Y-m-d', strtotime($billdate)));
                }
                
                if ($taxtype == '0') {
                    //$taxl = '419';
                    //add_transaction($invno, $billdate, $taxl, $Net_Amt[$i], $insert_id, 'SALES', 'C');
                } else {
                    $taxlp = getledger('lid', gettax1('sledger', $taxname));
                    $taxli = getledger('lid', gettax1('oledger', $taxname));
                    add_transaction($invno, $billdate, $taxlp, $Taxable_Amt[$i], $insert_id, 'SALES', 'C');
                    add_transaction($invno, $billdate, $taxli, $Tax_Amt[$i], $insert_id, 'SALES', 'C');
                }

                $i++;
            }

            foreach ($others_name as $v => $oname) {
                list($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]) = null_zero(array($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]));
                if ($oname != '') {
                    $oc = $db->prepare("INSERT INTO `invoice_othercharges` SET `invoiceid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? ");
                    $oc->execute(array($insert_id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1',$_SESSION['COMPANY_ID']));
                    if ($taxtype == '0') {
                        $taxl = getledger('lid', getotherterms('Ledger_id', $oname));
                        add_transaction($invno, $billdate, $taxl, $others_amount_total[$v], $insert_id, 'SALES', 'C');
                    } else {
                        $taxp = getledger('lid', getotherterms('Ledger_id', $oname));
                        $taxli = getledger('lid', gettax1('oledger', $others_tax[$v]));
                        add_transaction($invno, $billdate, $taxlp, $others_taxable_amt[$v], $insert_id, 'SALES', 'C');
                        add_transaction($invno, $billdate, $taxli, $others_tax_amt[$v], $insert_id, 'SALES', 'C');
                    }
                }
            }

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('SALES', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));

            $db->commit();
            if ($manual != '1') {
                update_bill_value('11');
            }
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $_SESSION['sucmsg'] = $res;
        } catch (PDOException $e) {
            $db->rollBack();
            $res = $e->getMessage();
        }
    } else {
        try {
            $db->beginTransaction();

            $resa = $db->prepare("UPDATE `invoice` SET `CusID`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`ref_no`=?,`status_approve`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`Othercharges`=?,`Discount`=?,`IP`=?,`Updated_by`=?,`bank`=? WHERE `company_id`=? AND  `PoID`=?");
            $resa->execute(array($CusID, $invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID),$ref_no, $status_app, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $oc,$discount_total, $ip, $_SESSION['UID'],$bank,$_SESSION['COMPANY_ID'], $id));
            $i = 0;
            stock_del($id, 'SR');
            transaction_del($id, 'SALES');
            add_transaction($invno, $billdate, getledger_by_field('lid', $CusID, 'customer_id'), $netpayamt, $id, 'SALES', 'D');
            $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency));
                if ($purchase_detailid[$i] == 'NEW') {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("INSERT INTO `invoice_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Discount_per`,`Discount`, `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Margin[$i],$product_rate_hidden[$i],$Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                } else {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    //echo $tax[$i].'---------------'; exit;
                    $resa = $db->prepare("UPDATE `invoice_details` SET `PoNum`=?, `PoID`=?, `Item`=?,`supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?,`Margin`=?,`product_rate_hidden`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Discount_per`=?,`Discount`=?, `Amount`=?, `IP`=?,`Currency`=?,`Comments`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do, $_SESSION['COMPANY_ID'], $purchase_detailid[$i]));
                }
                stock_add($id, 'SR', 'L', 'SALES', $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], date('Y-m-d', strtotime($billdate)));
                if ($taxtype == '0') {
                    //$taxl = '419';
                    //add_transaction($invno, $billdate, $taxl, $Net_Amt[$i], $id, 'SALES', 'C');
                } else {
                    $taxlp = getledger('lid', gettax1('sledger', $taxname));                    
                    $taxli = getledger('lid', gettax1('oledger', $taxname));                    
                    add_transaction($invno, $billdate, $taxlp, $Taxable_Amt[$i], $id, 'SALES', 'C');
                    add_transaction($invno, $billdate, $taxli, $Tax_Amt[$i], $id, 'SALES', 'C');
                }
                $i++;
            }

            foreach ($others_name as $v => $oname) {
                list($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]) = null_zero(array($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]));
                $y = 0;
                if ($others_ids[$v] != '') {
                    $oc = $db->prepare("UPDATE `invoice_othercharges` SET `invoiceid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `company_id`=? AND `OIID`=?");
                    $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1', $_SESSION['COMPANY_ID'], $others_ids[$v]));
                    $y = 1;
                } else {
                    if ($oname != '') {
                        $oc = $db->prepare("INSERT INTO `invoice_othercharges` SET `invoiceid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? ");
                        $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1', $_SESSION['COMPANY_ID']));
                        $y = 1;
                    }
                }
                if ($y == 1) {
                    if ($taxtype == '0'){
                        $taxl = getledger('lid', getotherterms('Ledger_id', $oname));
                        add_transaction($invno, $billdate, $taxl, $others_amount_total[$v], $id, 'SALES', 'C');
                    } else {
                        $taxlp = getledger('lid', getotherterms('Ledger_id', $oname));
                        $taxli = getledger('lid', gettax1('oledger', $others_tax[$v]));
                        add_transaction($invno, $billdate, $taxlp, $others_taxable_amt[$v], $id, 'SALES', 'C');
                        add_transaction($invno, $billdate, $taxli, $others_tax_amt[$v], $id, 'SALES', 'C');
                    }
                }
            }

            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated.!'.$taxlp.'</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();            
            die($e->getMessage());
        }
    }
    return array($res,$insert_id);
}

function delinvoice($a) {
    $ip = $_SERVER['REMOTE_ADDR'];
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
		transaction_del($c,'SALES');

        if (getinvoice('Delivery_note', $c) > 0) {
            $resa = $db->prepare("UPDATE `delivery_note` SET `Converted`='0',`converted_invoice_id`='0' WHERE `company_id`=? AND `PoID` = ?");
            $resa->execute(array($_SESSION['COMPANY_ID'],getinvoice('Delivery_note', $c)));
        }
        if (getinvoice('Sales_order', $c) > 0) {
            $resa = $db->prepare("UPDATE `sales_order` SET `Converted_invoice`='0',`converted_invoice_id`='0' WHERE `company_id`=? AND `PoID` = ?");
            $resa->execute(array($_SESSION['COMPANY_ID'],getinvoice('Sales_order', $c)));
        }
        $get1 = $db->prepare("DELETE FROM `invoice_details`  WHERE `company_id`=? AND `PoID` =? ");
        $get1->execute(array($_SESSION['COMPANY_ID'], $c));
        $get = $db->prepare("DELETE FROM `invoice_othercharges` WHERE `company_id`=? AND `invoiceid` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
        $get = $db->prepare("DELETE FROM `invoice` WHERE `company_id`=? AND `PoID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));


        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('SALES', '3', 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

function getinvoice($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `invoice` WHERE `company_id`=? AND `PoID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function add_perform_a_invoice($invno, $manual, $billdate, $taxtype, $status_app,$ref_no, $netpayamt, $subtotal, $subtaxtotal,$bank, $Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty,$Margin,$product_rate_hidden, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $Discount_per, $Discount, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $CusID,$discount_total, $oc, $others_name, $others_amount, $others_tax, $others_taxable_amt, $others_tax_amt, $others_amount_total, $others_description, $others_ids, $icurrency,$Comments,$id) {
    global $db;
$icurrency = getcustomer('Currency', $CusID);
    if ($deliveryterms == '') {
        $deliveryterms = 0;
    }if ($modeofshipment == '') {
        $modeofshipment = 0;
    }if ($enquirycurrency == '') {
        $enquirycurrency = 0;
    }if ($modeofpayment == '') {
        $modeofpayment = 0;
    }if ($paymentterms == '') {
        $paymentterms = 0;
    }if ($enquirytype == '') {
        $enquirytype = 0;
    }if ($vessel == '') {
        $vessel = 0;
    }if ($salesrep == '') {
        $salesrep = 0;
    }if ($bank == '') {
        $bank = 0;
    }
    
    if ($id == '') {
        try {
            $db->beginTransaction();
            if ($manual == '1') {
                
            } else {
                $invno = get_bill_settings('prefix', '13') . str_pad(get_bill_settings('current_value', '13'), get_bill_settings('format', '13'), '0', STR_PAD_LEFT);
            }

            $resa = $db->prepare("INSERT INTO  `perform_a_invoice` (`PONumber`,`PODate`,`TaxType`,`status_approve`,`ref_no`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`Discount`,`IP`,`Updated_by`,`bank`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID), $status_app,$ref_no, $CusID, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $oc,$discount_total, $ip, $_SESSION['UID'],$bank,$_SESSION['COMPANY_ID']));

            $insert_id = $db->lastInsertId();

            $i = 0; $do = 0;
            foreach ($Item_name as $netpay) { $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency));
                list($taxname) = null_zero(explode("#@#", $tax[$i]));
                $resa = $db->prepare("INSERT INTO `perform_a_invoice_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Discount_per`,`Discount`,`Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                $i++;
            }

            foreach ($others_name as $v => $oname) {
                list($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]) = null_zero(array($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]));
                if ($oname != '') {
                    $oc = $db->prepare("INSERT INTO `perform_a_invoice_othercharges` SET `invoiceid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=?");
                    $oc->execute(array($insert_id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1',$_SESSION['COMPANY_ID']));
                }
            }

            $db->commit();
            if ($manual != '1') {
                update_bill_value('13');
            }
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $_SESSION['sucmsg'] = $res;
        } catch (PDOException $e) {
            $db->rollBack();
            $res = $e->getMessage();
        }
    } else {
        try {
            $db->beginTransaction();

            $resa = $db->prepare("UPDATE `perform_a_invoice` SET `CusID`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`ref_no`=?,`status_approve`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`Othercharges`=?,`Discount`=?,`IP`=?,`Updated_by`=?,`bank`=? WHERE `company_id`=? AND `PoID`=?");
            $resa->execute(array($CusID, $invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType', $CusID),$ref_no, $status_app, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency', $CusID), getcustomer('paymentmode', $CusID), getcustomer('paymentterm', $CusID), $enquirytype, $vessel, $salesrep, $oc,$discount_total, $ip, $_SESSION['UID'],$bank, $_SESSION['COMPANY_ID'],$id));
            $i = 0;
            $do = 0;
            foreach ($Qty as $netpay) { $do++;
                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency));
                if ($purchase_detailid[$i] == 'NEW') {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("INSERT INTO `perform_a_invoice_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Discount_per`,`Discount`, `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));
                } else {
                    list($taxname) = null_zero(explode("#@#", $tax[$i]));
                    $resa = $db->prepare("UPDATE `perform_a_invoice_details` SET `PoNum`=?, `PoID`=?, `Item`=?,`supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?,`Margin`=?,`product_rate_hidden`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Discount_per`=?,`Discount`=?, `Amount`=?, `IP`=?,`Currency`=?,`Comments`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Discount_per[$i], $Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do, $_SESSION['COMPANY_ID'],$purchase_detailid[$i]));
                }

                $i++;
            }

            foreach ($others_name as $v => $oname) {
                list($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]) = null_zero(array($others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v]));
                $y = 0;
                if ($others_ids[$v] != '') {
                    $oc = $db->prepare("UPDATE `perform_a_invoice_othercharges` SET `invoiceid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `company_id`=? AND `OIID`=?");
                    $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1', $_SESSION['COMPANY_ID'], $others_ids[$v]));
                    $y = 1;
                } else {
                    if ($oname != '') {
                        $oc = $db->prepare("INSERT INTO `perform_a_invoice_othercharges` SET `invoiceid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=?");
                        $oc->execute(array($id, $oname, $others_amount[$v], $others_tax[$v], $others_taxable_amt[$v], $others_tax_amt[$v], $others_amount_total[$v], $others_description[$v], '1',$_SESSION['COMPANY_ID']));
                        $y = 1;
                    }
                }
            }

            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();
            die($e->getMessage());
        }
    }
    return array($res,$insert_id);
}

function del_perform_a_invoice($a) {
    $ip = $_SERVER['REMOTE_ADDR'];
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $get1 = $db->prepare("DELETE FROM `perform_a_invoice_details`  WHERE `company_id`=? AND `PoID` =? ");
        $get1->execute(array($_SESSION['COMPANY_ID'], $c));
        $get = $db->prepare("DELETE FROM `perform_a_invoice_othercharges` WHERE `company_id`=? AND `invoiceid` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
        $get = $db->prepare("DELETE FROM `perform_a_invoice` WHERE `company_id`=? AND `PoID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

function get_perform_a_invoice($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `perform_a_invoice` WHERE `company_id`=? AND `PoID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function getcurrentqtyproduct($prodid) {
    global $db;
    //$get_C_S = $db->prepare("SELECT SUM(t1 - t2) as cqty FROM (SELECT SUM(Tot_Qty) as t1 FROM `stock` WHERE `company_id`=? AND `Product_Id`=? AND `Stock_Type`='A') as a,(SELECT SUM(Tot_Qty) as t2 FROM `stock` WHERE `company_id`=? AND `Product_Id`=? AND `Stock_Type`='L') as b");
//    $get_C_S->execute(array($_SESSION['COMPANY_ID'], $prodid,$_SESSION['COMPANY_ID'], $prodid));
    $get_C_S = $db->prepare("SELECT SUM(ifnull(t1,'0') - ifnull(t2,'0')) as cqty FROM (SELECT SUM(qty) as t1 FROM `stocks` WHERE `company_id`=? AND `proid`=? AND `stocktype`='A') as a,(SELECT SUM(qty) as t2 FROM `stocks` WHERE `company_id`=? AND `proid`=? AND `stocktype`='L') as b");
    $get_C_S->execute(array($_SESSION['COMPANY_ID'], $prodid,$_SESSION['COMPANY_ID'], $prodid));
    $fetc = $get_C_S->fetch();
    $cqty = $fetc['cqty'];
    return ($cqty != '') ? $cqty : '0';
}

function convertd_page($id, $page, $type) {
    global $sitename;
    $tt = time().rand('586','5644');
    $rs = '
    <script id="thissc'.$tt.'">
        //window.onload = function(){
            window.open("' . $sitename . $type . '/' . $id . '/' . $page . '","_blank");
                document.getElementById("thissc'.$tt.'").remove();
        //}
        
    </script>';
    return $rs;
}

function getcurrencyn($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `currency_new` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
?>