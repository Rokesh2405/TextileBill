<?php



function getpermission($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `permission` WHERE `company_id`=? AND `pid`=? AND `status`!=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



function delpermission($a) {

    global $db;

    $b = str_replace(".", ",", $a);

    $b = explode(",", $b);

    foreach ($b as $c) {

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

        $htry->execute(array('Permission group', 26, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c,$_SESSION['COMPANY_ID']));

        $get = $db->prepare("UPDATE `permission` SET `status`=? WHERE `company_id`=? AND `pid` =? ");

        $get->execute(array(2, $_SESSION['COMPANY_ID'], $c));

    }

    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    return $res;

}



function getsendgrid($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `sendgrid` WHERE `sgid`=?");

    $get1->execute(array($b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

//$res = "SELECT * FROM `sendgrid` WHERE `sgid`='$b'";

    return $res;

}



function addsendgrid($a, $b, $c, $d, $e) {

    global $db;

    if ($e == '') {



        $resa = $db->prepare("INSERT INTO `sendgrid` (`api_key`,`username`,`password`,`ip`) VALUES (?,?,?,?,?,?)");

        $resa->execute(array(trim($a), trim($b), trim($c), trim($d)));

        $insert_id = $db->lastInsertId();



        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");

        $htry->execute(array('sendgrid', 41, 'Insert', $_SESSION['UID'], $d, $insert_id));





        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Send Grid Detail Successfully Inserted!</h4></div>';

    } else {



        $resa = $db->prepare("UPDATE `sendgrid` SET `api_key`=?,`username`=?,`password`=?,`ip`=? WHERE `sgid`=?");

        $resa->execute(array(trim($a), trim($b), trim($c), trim($d), $e));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");

        $htry->execute(array('sendgrid', 41, 'Update', $_SESSION['UID'], $d, $e));

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';

    }

    return $res;

}





function delsendgrid($a) {

    global $db;

    $b = str_replace(".", ",", $a);

    $b = explode(",", $b);

    foreach ($b as $c) {

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");

        $htry->execute(array('sendgrid', 41, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));

        $get = $db->prepare("DELETE FROM `sendgrid`  WHERE `sgid` =?");

        $get->execute(array($c));

    }

    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';

    //echo "UPDATE `faq` SET `status`='2' WHERE `fid` ='" . $c . "'";

    return $res;

}



/* Purchase Order start here */



function addtpurchaseorder($purmode, $invno, $billdate, $taxtype,$po_ref_no,$status_app, $supplier,$netpayamt, $subtotal, $subtaxtotal, $Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty,$Margin,$product_rate_hidden, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt,  $Discount_per, $Discount,  $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep,$othercharges, $discount_total,$others_name,$others_amount,$others_tax,$others_taxable_amt,$others_tax_amt,$others_amount_total,$others_description,$others_ids,$icurrency,$Comments, $id) {

    global $db;

   $icurrency = getsupplier('Currency',$supplier);

    if($deliveryterms==''){

        $deliveryterms=0;

    }if($modeofshipment==''){

        $modeofshipment=0;

    }if($enquirycurrency==''){

        $enquirycurrency=0;

    }if($modeofpayment==''){

        $modeofpayment=0;

    }if($paymentterms==''){

        $paymentterms=0;

    }if($enquirytype==''){

        $enquirytype=0;

    }if($vessel==''){

        $vessel=0;   

    }if($salesrep==''){

        $salesrep=0;

    }

    $pay_term = (getsupplier('paymentterm',$supplier)!='') ? getsupplier('paymentterm',$supplier) : 0;

    $pay_mode = (getsupplier('paymentmode',$supplier)!='') ? getsupplier('paymentmode',$supplier) : 0;

    $pay_curr = (getsupplier('Currency',$supplier)!='') ? getsupplier('Currency',$supplier) : 0;

    if ($id == '') {

        try {

            $db->beginTransaction();

            $invno = get_bill_settings('prefix','7').str_pad(get_bill_settings('current_value','7'),get_bill_settings('format','7'),'0', STR_PAD_LEFT);

            $resa = $db->prepare("INSERT INTO  `purchase_order` (`PoType`,`PONumber`,`PODate`,`TaxType`,`po_ref_no`,`status_approve`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`Discount`,`Converted`,`IP`,`Updated_by`,`supplier`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $resa->execute(array($purmode, $invno, date('Y-m-d', strtotime($billdate)), getsupplier('TaxType',$supplier),$po_ref_no,$status_app, $subtotal, $subtaxtotal,$netpayamt, $deliveryterms, $modeofshipment, $pay_curr, $pay_mode, $pay_term, $enquirytype, $vessel, $salesrep, $othercharges,$discount_total, '2', $ip, $_SESSION['UID'],$supplier,$_SESSION['COMPANY_ID']));



            $insert_id = $db->lastInsertId();

            $i = 0; $do = 0;

            foreach ($Net_Amt as $netpay) { $do++;

                list($taxname) = null_zero(explode("#@#", $tax[$i]));

                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency));

                $resa = $db->prepare("INSERT INTO `purchase_order_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`,`Discount_per`,`Discount`,  `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));

                $i++;

            }

            

            

            foreach ($others_name as $v => $oname) {

                list($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]) = null_zero(array($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]));

                if($oname!=''){

                    $oc = $db->prepare("INSERT INTO `purchaseorder_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? "); 

                    $oc->execute(array($insert_id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID']));

                }

            }

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

            $htry->execute(array('Purchase Order', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));



            $db->commit();

            update_bill_value('7');

           $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';

          $_SESSION['sucmsg'] = $res;

        } catch (PDOException $e) {

            $db->rollBack();

            $res= $e->getMessage();

            //print_r($e); exit;

        }

    } else {

        try {

            $db->beginTransaction();

           

            $resa = $db->prepare("UPDATE `purchase_order` SET `PoType`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`po_ref_no`=?,`status_approve`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`Othercharges`=?,`Discount`=?,`Converted`=?,`IP`=?,`Updated_by`=?,`supplier`=? WHERE `company_id`=? AND `PoID`=?");

            $resa->execute(array($purmode, $invno, date('Y-m-d', strtotime($billdate)), getsupplier('TaxType',$supplier),$po_ref_no,$status_app,$subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, $pay_curr, $pay_mode, $pay_term, $enquirytype, $vessel, $salesrep,$othercharges,$discount_total, '2', $ip, $_SESSION['UID'],$supplier,$_SESSION['COMPANY_ID'],$id));

            $i = 0;

            $do = 0;

            foreach ($Net_Amt as $netpay) { $do++;

                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency));

                if ($purchase_detailid[$i] == 'NEW') {

                    list($taxname) = null_zero(explode("#@#", $tax[$i]));

                    $resa = $db->prepare("INSERT INTO `purchase_order_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`,`Discount_per`,`Discount`, `Amount`, `IP`,`Currency`,`Comments`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do,$_SESSION['COMPANY_ID']));

                } else {

                    list($taxname) = null_zero(explode("#@#", $tax[$i]));

                    $resa = $db->prepare("UPDATE `purchase_order_details` SET `PoNum`=?, `PoID`=?, `Item`=?, `supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?,`Margin`=?,`product_rate_hidden`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?,`Discount_per`=?,`Discount`=?, `Amount`=?, `IP`=?,`Currency`=?,`Comments`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");

                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Discount_per[$i],$Discount[$i], $Net_Amt[$i], $ip,$icurrency,$Comments[$i],$do, $_SESSION['COMPANY_ID'], $purchase_detailid[$i]));

                }

                $i++;

            }

            

            foreach ($others_name as $v => $oname) {

                list($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]) = null_zero(array($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]));

                if($others_ids[$v]!=''){

                     $oc = $db->prepare("UPDATE `purchaseorder_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `company_id`=? AND `OSID`=?"); 

                    $oc->execute(array($id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID'], $others_ids[$v]));

                }else{

                if($oname!=''){

                     $oc = $db->prepare("INSERT INTO `purchaseorder_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? "); 

                    $oc->execute(array($id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID']));

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

    return array($res, $insert_id);

}



function delpurchaseorder($a) {

    $ip = $_SERVER['REMOTE_ADDR'];

    global $db;

    $b = str_replace(".", ",", $a);

    $b = explode(",", $b);

    foreach ($b as $c) {

        $get1 = $db->prepare("DELETE FROM `purchase_order_details`  WHERE `company_id`=? AND `PoNum` =? AND `PoID` =? ");

        $get1->execute(array($_SESSION['COMPANY_ID'], getpurchaseorderdetails('PoNum', $c), $c));



        $get = $db->prepare("DELETE FROM `purchase_order` WHERE `company_id`=? AND `PoID` =? ");

        $get->execute(array($_SESSION['COMPANY_ID'], $c));

        

        $get1 = $db->prepare("DELETE FROM `purchaseorder_othercharges`  WHERE `company_id`=? AND `salesid` =?");

        $get1->execute(array($_SESSION['COMPANY_ID'], $c));



        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

        $htry->execute(array('Purchase Order', 3, 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));

    }

    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    return $res;

}



function getpurchaseorder($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `purchase_order` WHERE `company_id`=? AND `PoID`=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



function getpurchaseorderdetails($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `purchase_order_details` WHERE `company_id`=? AND `PdID`=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



/* Purchase Order end here */





function addtpurchasereturn($purmode, $invno, $billdate, $supplierprimary,$taxtype, $purchased,$total,$Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt,$Return_Qty,$Return_Rate, $purchase_detailid,$R_Taxable_Amt,$R_Tax_Amt,$R_Net_Amt,$othercharges, $ip, $others_name,$others_amount,$others_tax,$others_taxable_amt,$others_tax_amt,$others_amount_total,$others_description,$others_ids,$Comments, $id) {

    global $db;

    $taxtype = getsupplier('TaxType',$supplierprimary)!='' ? getsupplier('TaxType',$supplierprimary) : '0';

    $total = $total!='' ? $total : '0';

    $othercharges = $othercharges!='' ? $othercharges : '0';

    if ($id == '') {

        try {

            $db->beginTransaction();

            $invno = get_bill_settings('prefix','10').str_pad(get_bill_settings('current_value','10'),get_bill_settings('format','10'),'0', STR_PAD_LEFT);

            $resa = $db->prepare("INSERT INTO  `purchase_return` (`PoType`,`PONumber`,`PODate`,`TaxType`,`supplier`,`purchase_id`,`Total`,`Othercharges`, `IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

            $resa->execute(array($purmode, $invno, date('Y-m-d', strtotime($billdate)), $taxtype,$supplierprimary,$purchased, $total, $othercharges, $ip, $_SESSION['UID'],$_SESSION['COMPANY_ID']));



            $insert_id = $db->lastInsertId();

            

            add_transaction($invno,$billdate,getledger_by_field('lid',$supplierprimary,'supplier_id'),$total,$insert_id,'Purchase_return','D');

            

            $i = 0;

            $do = 0;

            foreach ($Net_Amt as $netpay) { 

				$do++;

                list($taxname) = null_zero(explode("#@#", $tax[$i]));

                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i]) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i]));

                $resa = $db->prepare("INSERT INTO `purchase_return_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`,`Return_Qty`,`Return_Rate`,`Return_taxbamt`,`Return_taxamt`,`Return_netamt`, `Comments`,`IP`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i],$Comments[$i], $ip,$do, $_SESSION['COMPANY_ID']));

                stock_add($insert_id,'PRT','L','Purchase_return',$Item_name[$i],$suppliergird[$i],$Return_Qty[$i],$Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Return_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $R_Taxable_Amt[$i], $R_Tax_Amt[$i], $R_Net_Amt[$i],date('Y-m-d', strtotime($billdate)));

                

                if($taxtype == '0'){

                    $taxl = '78';        

                    add_transaction($invno,$billdate,$taxl,$Net_Amt[$i],$insert_id,'Purchase_return','C');

                } else {

                    $taxlp = getledger('lid',gettax1('pledger',$taxname));

                    $taxli = getledger('lid',gettax1('iledger',$taxname));

                    $taxlp = ($taxlp!='') ? $taxlp : 0;

                    $taxli = ($taxli!='') ? $taxli : 0;

                    add_transaction($invno,$billdate,$taxlp,$Taxable_Amt[$i],$insert_id,'Purchase_return','C');

                    add_transaction($invno,$billdate,$taxli,$Tax_Amt[$i],$insert_id,'Purchase_return','C');

                }

                $i++;

            }

            

             foreach ($others_name as $v => $oname) {

                 list($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]) = null_zero(array($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]));

                if($oname!=''){

                    $oc = $db->prepare("INSERT INTO `purchasereturn_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? "); 

                    $oc->execute(array($insert_id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID']));

                    if($taxtype == '0'){

                        $taxl = getledger('lid',getotherterms('Ledger_id',$oname));

                        $taxl = ($taxl!='') ? $taxl : 0;

                        add_transaction($invno,$billdate,$taxl,$others_amount_total[$v],$insert_id,'Purchase_return','C');

                    }else{

                        $taxlp = getledger('lid',getotherterms('Ledger_id',$oname));

                        $taxli = getledger('lid',gettax1('iledger',$others_tax[$v]));

                        $taxlp = ($taxlp!='') ? $taxlp : 0;

                        $taxli = ($taxli!='') ? $taxli : 0;

                        add_transaction($invno,$billdate,$taxlp,$others_taxable_amt[$v],$insert_id,'Purchase_return','C');

                        add_transaction($invno,$billdate,$taxli,$others_tax_amt[$v],$insert_id,'Purchase_return','C');

                    }   

                }

            }           

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

            $htry->execute(array('Purchase Order', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));

            $db->commit();

             update_bill_value('10');

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';

            $_SESSION['sucmsg'] = $res;

        } catch (PDOException $e) {

            $db->rollBack();

            print_r($e);

            die($e->getMessage());

        }

    } else {

        try {

            $db->beginTransaction();

            $resa = $db->prepare("UPDATE `purchase_return` SET `PoType`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`supplier`=?,`purchase_id`=?,`Total`=?,`Othercharges`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `PoID`=?");

            $resa->execute(array($purmode, $invno, date('Y-m-d', strtotime($billdate)), $taxtype,$supplierprimary,$purchased, $total, $othercharges, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));

            $i = 0; $do = 0;

            stock_del($id,'PRT');

            transaction_del($id,'Purchase_return');

             

            add_transaction($invno,$billdate,getledger_by_field('lid',$supplierprimary,'supplier_id'),$total,$id,'Purchase_return','D');

            foreach ($Net_Amt as $netpay) { $do++;

                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i]) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i]));

                if ($purchase_detailid[$i] == 'NEW') {

                    list($taxname) = null_zero(explode("#@#", $tax[$i]));

                    $resa = $db->prepare("INSERT INTO `purchase_return_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`,`Return_Qty`,`Return_Rate`,`Return_taxbamt`,`Return_taxamt`,`Return_netamt`,`Comments`, `IP`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i],$Comments[$i], $ip,$do,$_SESSION['COMPANY_ID']));

                } else {

                    list($taxname) = null_zero(explode("#@#", $tax[$i]));

                    $resa = $db->prepare("UPDATE `purchase_return_details` SET `PoNum`=?, `PoID`=?, `Item`=?, `supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=?,`Return_Qty`=?,`Return_Rate`=?,`Return_taxbamt`=?,`Return_taxamt`=?,`Return_netamt`=?, `Comments`=?,`IP`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");

                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i],$Comments[$i], $ip,$do, $_SESSION['COMPANY_ID'], $purchase_detailid[$i]));

                }

                stock_add($id,'PRT','L','Purchase_return',$Item_name[$i],$suppliergird[$i],$Return_Qty[$i],$Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Return_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $R_Taxable_Amt[$i], $R_Tax_Amt[$i], $R_Net_Amt[$i],date('Y-m-d', strtotime($billdate)));

                

                if($taxtype == '0'){

                    $taxl = '78';        

                    add_transaction($invno,$billdate,$taxl,$Net_Amt[$i],$id,'Purchase_return','C');

                }else{

                    $taxlp = getledger('lid',gettax1('pledger',$taxname));

                    $taxli= getledger('lid',gettax1('iledger',$taxname));

                    $taxlp = ($taxlp!='') ? $taxlp : 0;

                    $taxli = ($taxli!='') ? $taxli : 0;

                    add_transaction($invno,$billdate,$taxlp,$Taxable_Amt[$i],$id,'Purchase_return','C');

                    add_transaction($invno,$billdate,$taxli,$Tax_Amt[$i],$id,'Purchase_return','C');

                }        

                $i++;

            }

            

             foreach ($others_name as $v => $oname) {

                 $y=0;

                 list($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]) = null_zero(array($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]));

                if($others_ids[$v]!=''){

                     $oc = $db->prepare("UPDATE `purchasereturn_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `company_id`=? AND `OSID`=?"); 

                    $oc->execute(array($id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID'], $others_ids[$v]));

                    $y=1;

                } else{

                    if($oname!=''){

                        $oc = $db->prepare("INSERT INTO `purchasereturn_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? "); 

                        $oc->execute(array($id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID']));

                        $y=1;

                    }

                }

                if($y==1){

                    if($taxtype == '0'){

                        $taxl = getledger('lid',getotherterms('Ledger_id',$oname));

                    $taxl = ($taxl!='') ? $taxl : 0;

                        add_transaction($invno,$billdate,$taxl,$others_amount_total[$v],$id,'Purchase_return','C');

                    }else{

                        $taxlp = getledger('lid',getotherterms('Ledger_id',$oname));

                        $taxli = getledger('lid',gettax1('iledger',$others_tax[$v]));

                        $taxlp = ($taxlp!='') ? $taxlp : 0;

                    $taxli = ($taxli!='') ? $taxli : 0;

                        add_transaction($invno,$billdate,$taxlp,$others_taxable_amt[$v],$id,'Purchase_return','C');

                        add_transaction($invno,$billdate,$taxli,$others_tax_amt[$v],$id,'Purchase_return','C');

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

    return array($res, $insert_id);

}



function delpurchasereturn($a) {

    $ip = $_SERVER['REMOTE_ADDR'];

    global $db;

    $b = str_replace(".", ",", $a);

    $b = explode(",", $b);

    foreach ($b as $c) {

        transaction_del($c,'Purchase_return');

        $get1 = $db->prepare("DELETE FROM `purchase_return_details`  WHERE `company_id`=? AND `PoID` =? ");

        $get1->execute(array($_SESSION['COMPANY_ID'], $c));

        $get = $db->prepare("DELETE FROM `purchase_return` WHERE `company_id`=? AND `PoID` =? ");

        $get->execute(array($_SESSION['COMPANY_ID'], $c));

        $get1 = $db->prepare("DELETE FROM `purchasereturn_othercharges`  WHERE `company_id`=? AND `salesid` =?");

        $get1->execute(array($_SESSION['COMPANY_ID'], $c));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

        $htry->execute(array('Purchase Order', 3, 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));

    }

    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    return $res;

}



function getpurchasereturn($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `purchase_return` WHERE `company_id`=? AND `PoID`=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



function getpurchasereturndetails($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `purchase_return_details` WHERE `company_id`=? AND `PdID`=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



function addtdeliverynotereturn($purmode, $invno, $billdate, $customer,$ref_no,$taxtype, $purchased,$total,$Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt,$Return_Qty,$Return_Rate, $purchase_detailid,$R_Taxable_Amt,$R_Tax_Amt,$R_Net_Amt, $othercharges, $ip,$others_name,$others_amount,$others_tax,$others_taxable_amt,$others_tax_amt,$others_amount_total,$others_description,$others_ids,$Comments, $id) {

    global $db;

    $taxtype = $taxtype!='' ? $taxtype : '0';

    $total = $total!='' ? $total : '0';

    $othercharges = $othercharges!='' ? $othercharges : '0';

    if ($id == '') {

        try {

            $db->beginTransaction();

            $invno = get_bill_settings('prefix','12').str_pad(get_bill_settings('current_value','12'),get_bill_settings('format','12'),'0', STR_PAD_LEFT);

            $resa = $db->prepare("INSERT INTO  `delivery_note_return` (`PoType`,`PONumber`,`PODate`,`ref_no`,`TaxType`,`customer`,`delivery_note_id`,`Total`,`Othercharges`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

            $resa->execute(array($purmode, $invno, date('Y-m-d', strtotime($billdate)),$ref_no, getsupplier('TaxType',$customer),$customer,$purchased, $total, $othercharges, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));



            $insert_id = $db->lastInsertId();

            

            add_transaction($invno,$billdate,getledger_by_field('lid',$customer,'customer_id'),$total,$insert_id,'Delivery_note_return','C');

            

            $i = 0; $do = 0;

            foreach ($Net_Amt as $netpay) { $do++;

                list($taxname) = null_zero(explode("#@#", $tax[$i]));

                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i]) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i]));

                $resa = $db->prepare("INSERT INTO `delivery_note_return_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`,`Return_Qty`,`Return_Rate`,`Return_taxbamt`,`Return_taxamt`,`Return_netamt`, `Comments`,`IP`,`display_order`, `company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                $resa->execute(array($invno, $insert_id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i], $Comments[$i],$ip,$do,$_SESSION['COMPANY_ID']));

                stock_add($insert_id,'DCRT','A','Delivery_note_return',$Item_name[$i],$suppliergird[$i],$Return_Qty[$i],$Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Return_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $R_Taxable_Amt[$i], $R_Tax_Amt[$i], $R_Net_Amt[$i],date('Y-m-d', strtotime($billdate)));

                

                 if($taxtype == '0'){

                    $taxl = '78';        

                    add_transaction($invno,$billdate,$taxl,$R_Net_Amt[$i],$insert_id,'Delivery_note_return','D');

                }else{

                    $taxlp = getledger('lid',gettax1('pledger',$taxname));

                    $taxli= getledger('lid',gettax1('iledger',$taxname));

                    add_transaction($invno,$billdate,$taxlp,$R_Taxable_Amt[$i],$insert_id,'Delivery_note_return','D');

                    add_transaction($invno,$billdate,$taxli,$R_Tax_Amt[$i],$insert_id,'Delivery_note_return','D');

                }        

                

                $i++;

            }

            

            foreach ($others_name as $v => $oname) {

                list($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]) = null_zero(array($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]));

                if($oname!=''){

                    $oc = $db->prepare("INSERT INTO `deliverynotereturn_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? "); 

                    $oc->execute(array($insert_id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID']));                     

                    if($taxtype == '0'){

                        $taxl = getledger('lid',getotherterms('Ledger_id',$oname));

                        add_transaction($invno,$billdate,$taxl,$others_amount_total[$v],$insert_id,'Delivery_note_return','D');

                    }else{

                        $taxp = getledger('lid',getotherterms('Ledger_id',$oname));

                        $taxli = getledger('lid',gettax1('iledger',$others_tax[$v]));

                        add_transaction($invno,$billdate,$taxlp,$others_taxable_amt[$v],$insert_id,'Delivery_note_return','D');

                        add_transaction($invno,$billdate,$taxli,$others_tax_amt[$v],$insert_id,'Delivery_note_return','D');

                    }   

                }

            }

            

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

            $htry->execute(array('Purchase Order', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));

            $db->commit();

             update_bill_value('12');

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';

            $_SESSION['sucmsg'] = $res;

        } catch (PDOException $e) {

            $db->rollBack();

            die($e->getMessage());

        }

    } else {

        try {

            $db->beginTransaction();

            $resa = $db->prepare("UPDATE `delivery_note_return` SET `PoType`=?,`PONumber`=?,`PODate`=?,`ref_no`=?,`TaxType`=?,`customer`=?,`delivery_note_id`=?,`Total`=?,`Othercharges`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `PoID`=?");

            $resa->execute(array($purmode, $invno, date('Y-m-d', strtotime($billdate)),$ref_no, getsupplier('TaxType',$customer),$customer,$purchased, $total, $othercharges, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));

            $i = 0;

            stock_del($id,'DCRT');

             transaction_del($id,'Delivery_note_return');

             $do = 0;

             add_transaction($invno,$billdate,getledger_by_field('lid',$customer,'customer_id'),$total,$id,'Delivery_note_return','D');

            foreach ($Net_Amt as $netpay) { $do++;

                list($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i]) = null_zero(array($suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i]));

                if ($purchase_detailid[$i] == 'NEW') {

                    list($taxname) = null_zero(explode("#@#", $tax[$i]));

                    $resa = $db->prepare("INSERT INTO `delivery_note_return_details` (`PoNum`, `PoID`, `Item`, `supplier_id`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`, `Amount`,`Return_Qty`,`Return_Rate`,`Return_taxbamt`,`Return_taxamt`,`Return_netamt`, `Comments`,`IP`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i],$R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i], $Comments[$i],$ip,$do,$_SESSION['COMPANY_ID']));

                } else {

                    list($taxname) = null_zero(explode("#@#", $tax[$i]));

                    $resa = $db->prepare("UPDATE `delivery_note_return_details` SET `PoNum`=?, `PoID`=?, `Item`=?, `supplier_id`=?, `Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?, `Amount`=?,`Return_Qty`=?,`Return_Rate`=?,`Return_taxbamt`=?,`Return_taxamt`=?,`Return_netamt`=?, `Comments`=?,`IP`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");          

                    $resa->execute(array($invno, $id, $Item_name[$i], $suppliergird[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i], $Net_Amt[$i],$Return_Qty[$i],$Return_Rate[$i], $R_Taxable_Amt[$i],$R_Tax_Amt[$i],$R_Net_Amt[$i],$Comments[$i],$ip,$do,$_SESSION['COMPANY_ID'], $purchase_detailid[$i]));

                }

                stock_add($id,'DCRT','A','Delivery_note_return',$Item_name[$i],$suppliergird[$i],$Return_Qty[$i],$Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Return_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $R_Taxable_Amt[$i], $R_Tax_Amt[$i], $R_Net_Amt[$i],date('Y-m-d', strtotime($billdate)));

                

                  if($taxtype == '0'){

                    $taxl = '78';        

                    add_transaction($invno,$billdate,$taxl,$R_Net_Amt[$i],$id,'Delivery_note_return','D');

                } else{

                    $taxlp = getledger('lid',gettax1('pledger',$taxname));

                    $taxli= getledger('lid',gettax1('iledger',$taxname));

                    add_transaction($invno,$billdate,$taxlp,$R_Taxable_Amt[$i],$id,'Delivery_note_return','D');

                    add_transaction($invno,$billdate,$taxli,$R_Tax_Amt[$i],$id,'Delivery_note_return','D');

                }   

                $i++;

            }

            

            foreach ($others_name as $v => $oname) {

                $y=0;

                list($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]) = null_zero(array($others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v]));

                if($others_ids[$v]!=''){

                     $oc = $db->prepare("UPDATE `deliverynotereturn_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `company_id`=? AND `OSID`=?"); 

                    $oc->execute(array($id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID'], $others_ids[$v]));

                    $y=1;

                }else{

                    if($oname!=''){

                        $oc = $db->prepare("INSERT INTO `deliverynotereturn_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=? "); 

                        $oc->execute(array($id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID']));

                        $y=1;

                    }

                }

                if($y==1){

                    if($taxtype == '0'){

                        $taxl = getledger('lid',getotherterms('Ledger_id',$oname));

                        add_transaction($invno,$billdate,$taxl,$others_amount_total[$v],$id,'Delivery_note_return','D');

                    }else{

                        $taxlp = getledger('lid',getotherterms('Ledger_id',$oname));

                        $taxli = getledger('lid',gettax1('iledger',$others_tax[$v]));

                        add_transaction($invno,$billdate,$taxlp,$others_taxable_amt[$v],$id,'Delivery_note_return','D');

                        add_transaction($invno,$billdate,$taxli,$others_tax_amt[$v],$id,'Delivery_note_return','D');

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

    return array($res, $insert_id);

}



function deldeliverynotereturn($a) {

    $ip = $_SERVER['REMOTE_ADDR'];

    global $db;

    $b = str_replace(".", ",", $a);

    $b = explode(",", $b);

    foreach ($b as $c) {

        transaction_del($c,'Delivery_note_return');

        $get1 = $db->prepare("DELETE FROM `delivery_note_return_details`  WHERE `company_id`=? AND `PoNum` =? AND `PoID` =? ");

        $get1->execute(array($_SESSION['COMPANY_ID'], getpurchaseorderdetails('PoNum', $c), $c));

        $get = $db->prepare("DELETE FROM `delivery_note_return` WHERE `company_id`=? AND `PoID` =? ");

        $get->execute(array($_SESSION['COMPANY_ID'], $c));

        

        $get1 = $db->prepare("DELETE FROM `deliverynotereturn_othercharges`  WHERE `company_id`=? AND `salesid` =?");

        $get1->execute(array($_SESSION['COMPANY_ID'], $c));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

        $htry->execute(array('delivery note return', 3, 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));

    }

    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    return $res;

}



function getdeliverynotereturn($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `delivery_note_return` WHERE `company_id`=? AND `PoID`=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



function getdeliverynotereturndetails($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `delivery_note_return_details` WHERE `company_id`=? AND `PdID`=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



/* Purchase Order end here */





/* Purchase start here */



function addtpurchase($roundoff,$purmode, $invno, $billdate, $taxtype,$dn_ref_no, $netpayamt,$status_app, $subtotal, $subtaxtotal, $Item_name, $supplierprimary, $batch_number,$O_Qty,  $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty,$Margin,$product_rate_hidden, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt,$Discount_per, $Discount,$purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $othercharges,$discount_total, $others_name,$others_tax,$others_taxable_amt,$others_tax_amt,$others_amount_total, $others_amount, $others_description, $others_ids,$icurrency,$Comments, $id)

{

    global $db;

      $icurrency = getsupplier('Currency',$supplierprimary);

    if($deliveryterms==''){

        $deliveryterms=0;

    }

	if($modeofshipment==''){

        $modeofshipment=0;

    }

	if($enquirycurrency==''){

        $enquirycurrency=0;

    }

	if($modeofpayment==''){

        $modeofpayment=0;

    }

	if($paymentterms==''){

        $paymentterms=0;

    }

	if($enquirytype==''){

        $enquirytype=0;

    }

	if($vessel==''){

        $vessel=0;   

    }

	if($salesrep==''){

        $salesrep=0;

    }

	

    $pay_term = (getsupplier('paymentterm',$supplierprimary)!='') ? getsupplier('paymentterm',$supplierprimary) : 0;

    $pay_mode = (getsupplier('paymentmode',$supplierprimary)!='') ? getsupplier('paymentmode',$supplierprimary) : 0;

    $pay_curr = (getsupplier('Currency',$supplierprimary)!='') ? getsupplier('Currency',$supplierprimary) : 0;

    if ($id == '') {

        try {

            $db->beginTransaction();

            $invno = get_bill_settings('prefix','7').str_pad(get_bill_settings('current_value','7'),get_bill_settings('format','7'),'0', STR_PAD_LEFT);

            $resa = $db->prepare("INSERT INTO `purchase` (`PoType`,`supplier`,`PONumber`,`PODate`,`TaxType`,`dn_ref_no`,`status_approve`,`SubTotal`,`SubTaxTotal`,`Total`,`Deliveryterms`,`Modeofshipment`,`Enquirycurrency`,`Modeofpayment`,`Paymentterms`,`Enquirytype`,`Vessel`,`Salesrep`,`Othercharges`,`Discount`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $resa->execute(array($purmode, $supplierprimary, $invno, date('Y-m-d', strtotime($billdate)), getsupplier('TaxType',$supplierprimary),$dn_ref_no,$status_app, $subtotal, $subtaxtotal, $netpayamt, $deliveryterms, $modeofshipment, $pay_curr, $pay_mode, $pay_term, $enquirytype, $vessel, $salesrep, $othercharges,$discount_total, $ip, $_SESSION['UID'],$_SESSION['COMPANY_ID']));

            $insert_id = $db->lastInsertId();

			

            add_transaction($invno,$billdate,getledger_by_field('lid',$supplierprimary,'supplier_id'),$netpayamt,$insert_id,'PURCHASE','C');
            
            if($rondoff < 0.00) {
            add_transaction($invno,$billdate,660,($roundoff),$insert_id,'RoundOff','C');
            
            } else {
            add_transaction($invno,$billdate,660,($roundoff),$insert_id,'RoundOff','D');
            
            }


            $i = 0; 

			$do = 0;

            foreach ($Item_name as $netpay) { 

				$do++;

                list($taxname) = null_zero(explode("#@#", $tax[$i]));

                list($supplierprimary, $batch_number[$i], $O_Qty[$i],$Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i], $ip,$icurrency) = null_zero(array($supplierprimary, $batch_number[$i], $O_Qty[$i],$Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i], $ip,$icurrency));

				

               $resa = $db->prepare("INSERT INTO `purchase_details` (`PoNum`, `PoID`, `Item`, `supplier_id`,`batch_number`, `O_Qty`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`,`Amount`, `IP`,`Currency`,`Comments`,`Discount_per`,`Discount`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

				

               $resa->execute(array($invno, $insert_id, $Item_name[$i], $supplierprimary, $batch_number[$i], $O_Qty[$i],$Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i], $ip,$icurrency,$Comments[$i],$Discount_per[$i],$Discount[$i],$do,$_SESSION['COMPANY_ID']));

				

                stock_add($insert_id,'PR','A','PURCHASE',$Item_name[$i],$supplierprimary,$Qty[$i],$Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i], date('Y-m-d', strtotime($billdate)));

                if($taxtype == '0'){

                    //$taxl = '77';        

                    //add_transaction($invno,$billdate,$taxl, $insert_id,'PURCHASE','D');

                }else{

                    $taxlp = getledger('lid',gettax1('pledger',$taxname));

                    $taxli = getledger('lid',gettax1('iledger',$taxname));

                    add_transaction($invno,$billdate,$taxlp,$Taxable_Amt[$i],$insert_id,'PURCHASE','D');

                    add_transaction($invno,$billdate,$taxli,$Tax_Amt[$i],$insert_id,'PURCHASE','D');

                }

                $i++;

            }

			

            foreach ($others_name as $v => $oname) {

                if($oname!=''){

                    $oc = $db->prepare("INSERT INTO `purchase_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=?"); 

                    $oc->execute(array($insert_id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID']));

                    

                    if($taxtype == '0'){

                        $taxl = getledger('lid',getotherterms('Ledger_id',$oname));

                        add_transaction($invno,$billdate,$taxl,$others_amount_total[$v],$insert_id,'PURCHASE','D');

                    } else {

                        $taxlp = getledger('lid',getotherterms('Ledger_id',$oname));

                        $taxli = getledger('lid',gettax1('iledger',$others_tax[$v]));

                        add_transaction($invno,$billdate,$taxlp,$others_taxable_amt[$v],$insert_id,'PURCHASE','D');

                        add_transaction($invno,$billdate,$taxli,$others_tax_amt[$v],$insert_id,'PURCHASE','D');

                    }         

                }

            }                       



            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

            $htry->execute(array('Purchase', 2, 'Insert', $_SESSION['UID'], $ip, $id,$_SESSION['COMPANY_ID']));



            $db->commit();

            update_bill_value('8');

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';

            $_SESSION['sucmsg'] = $res;

        } catch (PDOException $e) {

            $db->rollBack();

            print_r ($e);

            die($e->getMessage());

        }

    } else {

        try {

            $db->beginTransaction();

            $resa = $db->prepare("UPDATE `purchase` SET `PoType`=?,`supplier`=?,`PONumber`=?,`PODate`=?,`TaxType`=?,`dn_ref_no`=?,`status_approve`=?,`SubTotal`=?,`SubTaxTotal`=?,`Total`=?,`Deliveryterms`=?,`Modeofshipment`=?,`Enquirycurrency`=?,`Modeofpayment`=?,`Paymentterms`=?,`Enquirytype`=?,`Vessel`=?,`Salesrep`=?,`Othercharges`=?,`Discount`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `PoID` = ?");

            $resa->execute(array($purmode, $supplierprimary, $invno, date('Y-m-d', strtotime($billdate)), getsupplier('TaxType',$supplierprimary),$dn_ref_no,$status_app,  $subtotal, $subtaxtotal,$netpayamt, $deliveryterms, $modeofshipment, $pay_curr, $pay_mode, $pay_term, $enquirytype, $vessel, $salesrep, $othercharges,$discount_total, $ip, $_SESSION['UID'],$_SESSION['COMPANY_ID'], $id));

            $i = 0;

            stock_del($id,'PR');

            transaction_del($id,'PURCHASE');

            add_transaction($invno,$billdate,getledger_by_field('lid',$supplierprimary,'supplier_id'),$netpayamt,$id,'PURCHASE','C');  

        

            $do = 0;

            foreach ($Item_name as $netpay) { $do++;

                list($supplierprimary, $batch_number[$i], $O_Qty[$i],$Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i], $ip,$icurrency) = null_zero(array($supplierprimary, $batch_number[$i], $O_Qty[$i],$Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i], $ip,$icurrency));

                if ($purchase_detailid[$i] == 'NEW') {

                    list($taxname) = null_zero(explode("#@#", $tax[$i]));

                    $resa = $db->prepare("INSERT INTO `purchase_details` (`PoNum`, `PoID`, `Item`, `supplier_id`,`O_Qty`, `Qty`, `QtyPerPack`, `PackUoM`, `ItemUoM`, `TotalQty`,`Margin`,`product_rate_hidden`, `PackRate`, `ItemRate`, `TaxName`, `TaxableAmt`, `TaxAmt`,`Amount`, `IP`,`Currency`,`Comments`,`Discount_per`,`Discount`,`display_order`,`company_id`)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    $resa->execute(array($invno, $id, $Item_name[$i], $supplierprimary,$O_Qty[$i], $Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i], $ip,$icurrency,$Comments[$i],$Discount_per[$i],$Discount[$i],$do,$_SESSION['COMPANY_ID']));

                } else {

                    list($taxname) = null_zero(explode("#@#", $tax[$i]));

                    $resa = $db->prepare("UPDATE `purchase_details` SET `PoNum`=?, `PoID`=?, `Item`=?, `supplier_id`=?, `batch_number`=?, `O_Qty`=?,`Qty`=?, `QtyPerPack`=?, `PackUoM`=?, `ItemUoM`=?, `TotalQty`=?,`Margin`=?,`product_rate_hidden`=?, `PackRate`=?, `ItemRate`=?, `TaxName`=?, `TaxableAmt`=?, `TaxAmt`=?,`Amount`=?, `IP`=?,`Currency`=?,`Comments`=?,`Discount_per`=?,`Discount`=?,`display_order`=?  WHERE `company_id`=? AND `PdID`=?");

                    $resa->execute(array($invno, $id, $Item_name[$i], $supplierprimary, $batch_number[$i], $O_Qty[$i],$Qty[$i], $Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i],$Margin[$i],$product_rate_hidden[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i], $ip,$icurrency,$Comments[$i],$Discount_per[$i],$Discount[$i],$do,$_SESSION['COMPANY_ID'], $purchase_detailid[$i]));

                }

                stock_add($id,'PR','A','PURCHASE',$Item_name[$i],$supplierprimary,$Qty[$i],$Pack_qty[$i], $Pack_UOM[$i], $Item_UOM[$i], $Total_Qty[$i], $Pack_Rate[$i], $Item_Rate[$i], $taxname, $Taxable_Amt[$i], $Tax_Amt[$i],$Net_Amt[$i],  date('Y-m-d', strtotime($billdate)));

                

                if($taxtype == '0'){

                    //$taxl = '77';        

                    //add_transaction($invno,$billdate,$taxl,$id,'PURCHASE','D');

                }else{

                    $taxlp = getledger('lid',gettax1('pledger',$taxname));

                    $taxli= getledger('lid',gettax1('iledger',$taxname));

                    add_transaction($invno,$billdate,$taxlp,$Taxable_Amt[$i],$id,'PURCHASE','D');

                    add_transaction($invno,$billdate,$taxli,$Tax_Amt[$i],$id,'PURCHASE','D');

                }               

                $i++;

            }

                    

            foreach ($others_name as $v => $oname) {

                $y = 0;

                if($others_ids[$v]!=''){

                    $oc = $db->prepare("UPDATE `purchase_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=? WHERE `company_id`=? AND `OSID`=?"); 

                    $oc->execute(array($id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID'],$others_ids[$v]));

                    $y=1;

                } else {

					if($oname!=''){

						$oc = $db->prepare("INSERT INTO `purchase_othercharges` SET `salesid`=?,`Name`=?,`Amount`=?,`Tax`=?,`Taxable_Amt`=?,`Tax_Amt`=?,`Total_Amt`=?,`Description`=?,`Status`=?,`company_id`=?"); 

						$oc->execute(array($id,$oname,$others_amount[$v],$others_tax[$v],$others_taxable_amt[$v],$others_tax_amt[$v],$others_amount_total[$v],$others_description[$v],'1',$_SESSION['COMPANY_ID']));

						$y=1;

					}

                }

                if($y==1)

				{

                    if($taxtype == '0'){

                        $taxl = getledger('lid',getotherterms('Ledger_id',$oname));                        

                        add_transaction($invno,$billdate,$oname,$others_amount_total[$v],$id,'PURCHASE','D');

                    } else {

                        $taxlp = getledger('lid',getotherterms('Ledger_id',$oname));

                        $taxli = getledger('lid',gettax1('iledger',$others_tax[$v]));                           

                        add_transaction($invno,$billdate,$taxlp,$others_taxable_amt[$v],$id,'PURCHASE','D');

                        add_transaction($invno,$billdate,$taxli,$others_tax_amt[$v],$id,'PURCHASE','D');

                    }       

                }

            } 

            

          $db->commit();

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';

        } catch (PDOException $e) {

            $db->rollBack();

            print_r($e);

            die($e->getMessage());

        }

    }

    return array($res, $insert_id);

}



function delpurchase($a) {

    $ip = $_SERVER['REMOTE_ADDR'];

    global $db;

    $b = str_replace(".", ",", $a);

    $b = explode(",", $b);

    foreach ($b as $c) {

        transaction_del($c,'PURCHASE');
        
        transaction_del($c,'RoundOff');

        $get1 = $db->prepare("DELETE FROM `purchase_details` WHERE `company_id`=? AND `PoNum` =? AND `PoID` =? ");

        $get1->execute(array($_SESSION['COMPANY_ID'], getpurchaseorderdetails('PoNum', $c), $c));

        

        if (getpurchase('purchase_order', $c) > 0) {

            $resa = $db->prepare("UPDATE `purchase_order` SET `Converted`='0',`converted_purchase_id`='0' WHERE `company_id`=? AND `PoID`=?");

            $resa->execute(array($_SESSION['COMPANY_ID'], getpurchase('purchase_order', $c)));

        }



        $get = $db->prepare("DELETE FROM `purchase` WHERE `company_id`=? AND `PoID` =? ");

        $get->execute(array($_SESSION['COMPANY_ID'], $c));

        

        $get1 = $db->prepare("DELETE FROM `purchase_othercharges` WHERE `company_id`=? AND `salesid`=?");

        $get1->execute(array($_SESSION['COMPANY_ID'], $c));



        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");

        $htry->execute(array('Purchase Order', 3, 'Delete', $_SESSION['UID'], $ip, $c,$_SESSION['COMPANY_ID']));

    }

    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    return $res;

}



function getpurchase($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `purchase` WHERE `company_id`=? AND `PoID`=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



function getpurchasedetails($a, $b) {

    global $db;

    $get1 = $db->prepare("SELECT * FROM `purchase_details` WHERE `company_id`=? AND `PdID`=?");

    $get1->execute(array($_SESSION['COMPANY_ID'], $b));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$a];

    return $res;

}



/* Purchase end here */





/* Update Email Template  

 * 

 */



function updateEmailTemplate($name,$subject,$message,$id){

    global  $db;

     $res = $db->prepare("UPDATE `email_template` SET   `name`=?,`subject`=?,`message`=?  WHERE `company_id`=? AND `id`=?");

     $res->execute(array($name,$subject,$message,$_SESSION['COMPANY_ID'], $id));     

     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Updated!</h4></div>';

     return $res;

}





function updatePrintTemplate($name,$subject,$footer_message,$message,$id){

    global  $db;

	

     $res1 = $db->prepare("UPDATE `print_template` SET  `name`=?,`subject`=?,`footer_message`=?,`message`=?  WHERE `company_id`=? AND `id`=?");

     $res1->execute(array($name,$subject,$footer_message,$message,$_SESSION['COMPANY_ID'],$id));     

     $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';

     return $res;

}



function updateSignTemplate($name,$subject,$sign1,$sign2,$sign3,$sign4,$title1,$title2,$title3,$title4,$name1,$name2,$name3,$name4,$id){

    global  $db;

	list($sign1,$sign2,$sign3,$sign4) = null_zero(array($sign1,$sign2,$sign3,$sign4));

     $res1 = $db->prepare("UPDATE `print_template` SET `name`=?,`subject`=?,`sign1`=?,`sign2`=?, `sign3`=?, `sign4`=?, `title1`=?,`title2`=?,`title3`=?,`title4`=?,`name1`=?,`name2`=?,`name3`=?,`name4`=?  WHERE `company_id`=? AND `id`=?");

     $res1->execute(array($name,$subject,$sign1,$sign2,$sign3,$sign4,$title1,$title2,$title3,$title4,$name1,$name2,$name3,$name4,$_SESSION['COMPANY_ID'],$id));     

     $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';

     return $res;

}



function addbillsettings($prefix,$format, $current_value,$id){

    global  $db;

	list($format, $current_value) = null_zero(array($format, $current_value));

     $res = $db->prepare("UPDATE `bill_settings` SET `prefix`=?,`format`=? , `current_value`=?  WHERE `company_id`=? AND `id`=?");

     $res->execute(array($prefix,$format,$current_value,$_SESSION['COMPANY_ID'],$id));     

     $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';

     return $res;

}



function  get_bill_settings($field,$id){

    global $db;

    $get0 = $db->prepare("SELECT `page_type` FROM `bill_settings` WHERE `id`=?");

    $get0->execute(array($id));

    $gets = $get0->fetch(PDO::FETCH_ASSOC);

    

    $get1 = $db->prepare("SELECT * FROM `bill_settings` WHERE `company_id`=? AND `page_type`=?");

    $get1->execute(array("'".$_SESSION['COMPANY_ID']."'", $gets['page_type']));

    $get = $get1->fetch(PDO::FETCH_ASSOC);

    $res = $get[$field];

    return $res;

}



function update_bill_value($type_id){

     global  $db;

    $get0 = $db->prepare("SELECT `page_type` FROM `bill_settings` WHERE `id`=?");

    $get0->execute(array($type_id));

    $gets = $get0->fetch(PDO::FETCH_ASSOC);

    

     $res = $db->prepare("UPDATE `bill_settings` SET `current_value`=?  WHERE `company_id`=? AND `page_type`=?");

     $res->execute(array((get_bill_settings('current_value',$type_id) + 1),"'".$_SESSION['COMPANY_ID']."'", $gets['page_type']));   

}



function getTableValue($table,$a, $b) {

    global $db;

    if($table=='print_template' || $table=='email_template'){

        $get0 = $db->prepare("SELECT `page_type` FROM `".$table."` WHERE `id`=?");

        $get0->execute(array($b));

        $gets = $get0->fetch(PDO::FETCH_ASSOC);

        

        $get1 = $db->prepare("SELECT * FROM ".$table." WHERE `company_id`=? AND `page_type`=?");

        $get1->execute(array($_SESSION['COMPANY_ID'],$gets['page_type']));

        $get = $get1->fetch(PDO::FETCH_ASSOC);

        $res = $get[$a];

    }else{

        if ($table == 'states' || $table == 'uom' || $table == 'cities' || $table == 'countries') {

            $swhere = " AND `company_id`='".$_SESSION['COMPANY_ID']."'";

        }

        $get1 = $db->prepare("SELECT * FROM ".$table." WHERE `id`=?$swhere");

        $get1->execute(array($b));

        $get = $get1->fetch(PDO::FETCH_ASSOC);

        $res = $get[$a];

    }    

    return $res;

}







?>