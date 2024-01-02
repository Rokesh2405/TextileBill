<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function adddeliverynote($invno, $billdate, $taxtype, $netpayamt,$status_app, $subtotal, $subtaxtotal, $Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $CusID, $ship_address,$ship_country,$ship_state,$ship_city,$ship_pincode, $others_name, $others_amount, $others_description, $others_ids, $id) {
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
    if ($id == '') {
        try {
            $db->beginTransaction();
            $invno = get_bill_settings('prefix','9').str_pad(get_bill_settings('current_value','9'),get_bill_settings('format','9'),'0', STR_PAD_LEFT);
            $resa = $db->prepare("INSERT INTO  `delivery_note` (`PONumber`,`PODate`,`TaxType`,`status_approve`,`CusID`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Converted`,`IP`,`Updated_by`,`ship_address`,`ship_country`,`ship_state`,`ship_city`,`ship_pincode`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType',$CusID),$status_app, $CusID, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency',$CusID), getcustomer('paymentmode',$CusID), getcustomer('paymentterm',$CusID), $enquirytype, $vessel, $salesrep, '2', $ip, $_SESSION['UID'],$ship_address,$ship_country,$ship_state,$ship_city,$ship_pincode));

            $insert_id = $db->lastInsertId();
            
           // add_transaction($invno,$billdate,getledger_by_field('lid',$CusID,'customer_id'),$netpayamt,$insert_id,'Delivery_note','D');
            
            $i = 0;
            foreach ($Qty as $netpay) {
                list($taxname) = explode("#@#", $tax[$i]);
                $resa = $db->prepare("INSERT INTO `delivery_note_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip));
                
                stock_add($insert_id,'DC','L','Delivery_note',$Item_name[$i],$suppliergird[$i],$Qty[$i],$Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],date('Y-m-d', strtotime($billdate)));
                
            /*    if($taxtype == '0'){
                    $taxl = '78';        
                    add_transaction($invno,$billdate,$taxl,$Net_Amt[$i],$insert_id,'Delivery_note','C');
                }else{
                    $taxlp = getledger('lid',gettax1('pledger',$taxname));
                    $taxli= getledger('lid',gettax1('iledger',$taxname));
                    add_transaction($invno,$billdate,$taxlp,$Taxable_Amt[$i],$insert_id,'Delivery_note','C');
                    add_transaction($invno,$billdate,$taxli,$Tax_Amt[$i],$insert_id,'Delivery_note','C');
                }    */    
                
                $i++;
            }
            
             foreach ($others_name as $v => $oname) {
                if($oname!=''){
                    $oc = $db->prepare("INSERT INTO `delivery_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Description`=?,`Status`=?"); 
                    $oc->execute(array($insert_id,$oname,$others_amount[$v],$others_description[$v],'1'));
                    // $taxli = getledger('lid',getotherterms('Ledger_id',$oname));
                   // add_transaction($invno,$billdate,$taxli,$others_amount[$v],$insert_id,'Delivery_note','C');
                }
            }
            
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('delivery_note', 2, 'Insert', $_SESSION['UID'], $ip, $id));

            $db->commit();
              update_bill_value('9');
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();
            $res = $e->getMessage();
        }
    } else {
        try {
            $db->beginTransaction();
            $resa = $db->prepare("UPDATE `delivery_note` SET `CusID`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`status_approve`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`Converted`=?,`IP`=?,`Updated_by`=?,`ship_address`=?,`ship_country`=?,`ship_state`=?,`ship_city`=?,`ship_pincode`=? Where PoID=?");
            $resa->execute(array($CusID, $invno, date('Y-m-d', strtotime($billdate)), getcustomer('TaxType',$CusID),$status_app, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, getcustomer('Currency',$CusID), getcustomer('paymentmode',$CusID), getcustomer('paymentterm',$CusID),$enquirytype, $vessel, $salesrep, '2', $ip, $_SESSION['UID'],$ship_address,$ship_country,$ship_state,$ship_city,$ship_pincode, $id));
            $i = 0;
                stock_del($id,'DC');
           // transaction_del($id,'Delivery_note');
                
                
           // add_transaction($invno,$billdate,getledger_by_field('lid',$CusID,'customer_id'),$netpayamt,$id,'Delivery_note','D');
            foreach ($Qty as $netpay) {
                if ($purchase_detailid[$i] == 'NEW') {
                    list($taxname) = explode("#@#", $tax[$i]);
                    $resa = $db->prepare("INSERT INTO `delivery_note_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`, `IP`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip));
                } else {
                    list($taxname) = explode("#@#", $tax[$i]);
                    $resa = $db->prepare("UPDATE `delivery_note_details` SET `PoNum`=?, `PoID`=?, `Item`=?,`supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=?, `IP`=?  WHERE `PdID`=?");
                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i], $ip, $purchase_detailid[$i]));
                }
                stock_add($id,'DC','L','Delivery_note',$Item_name[$i],$suppliergird[$i],$Qty[$i],$Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],date('Y-m-d', strtotime($billdate)));
                
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
            
            foreach ($others_name as $v => $oname) {
                if($others_ids[$v]!=''){
                     $oc = $db->prepare("UPDATE `delivery_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Description`=?,`Status`=? WHERE `OSID`=?"); 
                    $oc->execute(array($id,$oname,$others_amount[$v],$others_description[$v],'1',$others_ids[$v]));
                }else{
                if($oname!=''){
                    $oc = $db->prepare("INSERT INTO `delivery_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Description`=?,`Status`=?"); 
                    $oc->execute(array($id,$oname,$others_amount[$v],$others_description[$v],'1'));
                    //$taxli = getledger('lid',getotherterms('Ledger_id',$oname));
                    //add_transaction($invno,$billdate,$taxli,$others_amount[$v],$insert_id,'Delivery_note','C');
                }
                }
            }

            $db->commit();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } catch (PDOException $e) {
            $db->rollBack();
            die($e->getMessage());
        }
    }
    return $res;
}

