
<?php
/* ledger */
function updatepayment2($payamounts, $tids, $banks, $date, $paytypes, $cheques, $cdates, $desc, $total, $user, $invoice_nos, $paidnums, $type)
{
    $tid = explode('#', $tids);
    $received_amount = explode('#', $payamounts);
    $paytype = $paytypes;
    $bank = $banks;
    $cheque = $cheques;
    $cdate = $cdates;
    $invoice_no = explode('#', $invoice_nos);
    $paidnum = explode('#', $paidnums);
    for ($i = 0; $i < (count($received_amount)); $i++) {
        if ($received_amount[$i] != 0 || $received_amount[$i] != '') {
            $lst = DB_QUERY("SELECT `last` FROM `receipts` ORDER BY `rid` DESC");
            if ($lst['last'] == '' || $lst['last'] == '0') {
                $val = 0;
                $purid = 'RE' . str_pad(1, 8, '0', STR_PAD_LEFT);
            } else {
                $val = $lst['last'];
                $purid = 'RE' . str_pad($lst['last'] + 1, 8, '0', STR_PAD_LEFT);
            }
            $supplier = $user;
            $receipt_type = '2';
            $mode = 2;
            $type1 = 'P';
            $omode = 1;
            $screen = 6;
            if ($paytype == 1) {
                $ledgerids = 26;
            } elseif ($paytype == 2) {
                $ledgerids = getbank('ledger', $bank[$i]);
            } elseif ($paytype == 3) {
                $ledgerids = 24;
            }
            mysql_query("INSERT INTO `receipts` SET `receipt_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype . "',`customer`='" . $customer . "',`supplier`='" . $supplier . "',`amount`='$total',`bank`='" . $bank . "',`receipt_date`='" . date("Y-m-d", strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc . "',`receipt_type`='" . $receipt_type . "',`com_id`='" . $_SESSION['UID'] . "' $appstatus");
            
            $insert_id = mysql_insert_id();
            $ts = DB_QUERY("SELECT * FROM `transactions` WHERE `tid`='$tid[$i]' ");
            mysql_query("INSERT INTO `receipt_details` SET `rid`='" . $insert_id . "',`tid`='" . $tid[$i] . "',`amount`='" . $received_amount[$i] . "'");
            if ($cdate != '') {
                $date = $cdate;
            }
            mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='" . $ts['bill_no'] . "',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='" . $ts['ledger_id'] . "',`bill_type`='" . $paytype . "',`amount`='" . $received_amount[$i] . "',`ref_id`='" . $ts['ref_id'] . "',`screen`='" . $screen . "',`mode`='$mode',`ip`='" . $_SERVER['REMOTE_ADDR'] . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='" . $type1 . "',`invoice_no`='" . $invoice_no[$i] . "' $appstatus ");
            $transaction_id = mysql_insert_id();

            mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='" . $ts['bill_no'] . "',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='" . $ledgerids . "',`bill_type`='" . $paytype . "',`amount`='" . $received_amount[$i] . "',`ref_id`='" . $ts['ref_id'] . "',`screen`='" . $screen . "',`mode`='$omode',`ip`='" . $_SERVER['REMOTE_ADDR'] . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='" . $type2 . "',`transaction_id`='$transaction_id',`invoice_no`='" . $invoice_no[$i] . "' $appstatus  ");
            $transaction_id2 = mysql_insert_id();
            echo $paidnum[$i];
            if ($paidnum[$i] != '') {
                DB_QUERY("UPDATE `transactions` SET  `ref_col`='" . $transaction_id2 . "' WHERE  `tid`='" . $paidnum[$i] . "' ");
            }
            if ($paytype[$i] == 2) {
                mysql_query("UPDATE `transactions` SET `bank_trans_id`='$transaction_id2' WHERE `tid`='$transaction_id' ");
            }
            mysql_query("UPDATE `receipts` SET `transaction_id`='$transaction_id' WHERE `rid`='$insert_id' ");
        }
    }
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated!</h4></div>';

    return $res;
}

function addledger($name, $printname, $aliasname, $under, $undersub, $openbal, $status, $ip, $paymode, $lid) {

    global $session_value_id;

	list($undersub,$status, $paymode) = null_zero(array($undersub,$status, $paymode));
        $undersub = trim($undersub) == '' ? '0' : trim($undersub);
    if ($lid == '') {

        $ledgercheck = DB_NUM("SELECT * FROM `ledger` WHERE `Name`='" . $name . "' AND $session_value_id ");

        if ($ledgercheck > 0) {
            $ress = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i>Ledger already exists!</h4> </div>';

            $ress = '';
        } else {
            $resa = mysql_query("INSERT INTO `ledger`  SET `Name`='" . $name . "', `printname`='" . $printname . "',`aliasname`='" . $aliasname . "',`under` ='" . $under . "',`subledger`='" . $undersub . "',`openbal` ='" . $openbal . "',`default`= '$status',`IP`= '" . $ip . "',`Updated_By`='" . $_SESSION['UID'] . "',$session_value_id,`paymode`='$paymode',`status`='1' ");
            $insert_id = mysql_insert_id();
            $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`Date`) VALUES ('addledger','1','Insert','" . $_SESSION['UID'] . "','" . $ip . "','" . $insert_id . "')");
            $ress = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Succesfully Inserted</h4></div>';
        }
    } else {
        
        $resa = mysql_query("UPDATE `ledger` SET `Name`='" . $name . "',`printname`='" . $printname . "', `aliasname`='" . $aliasname . "', `under`='" . $under . "', `subledger`='" . $undersub . "',`openbal`='" . $openbal . "',`default`='$status',`IP`='" . $ip . "',`Updated_By`='" . $_SESSION['UID'] . "',`paymode`='" . $paymode . "',`status`='1',$session_value_id WHERE `lid`='" . $lid . "'");

        $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('addledger','23','Update','" . $_SESSION['UID'] . "','" . $ip . "','" . $insert_id . "')");
        $ress = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated!</h4><!--<a href="' . $sitename . 'cheque/addbook.htm">Back to Listings Page</a>--></div>';
        
    }
    
    return $ress;
}

function getledger($a, $b) {
    $get = mysql_fetch_array(mysql_query("SELECT * FROM `ledger` WHERE `lid`='$b' AND `status`!='2'"));
    $res = $get[$a];
    return $res;
}

function delledger($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('addledger','23','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query(" DELETE FROM `ledger` WHERE `lid` ='" . $c . "' ");

        $taxcheck = DB_QUERY("SELECT * FROM `tax` WHERE FIND_IN_SET('$c',`outputledgers`) OR FIND_IN_SET('$c',`inputledgers`) ");
        $taxid = $taxcheck['tid'];
        $taxrow = DB_NUM("SELECT * FROM `tax` WHERE FIND_IN_SET('$c',`outputledgers`) OR FIND_IN_SET('$c',`inputledgers`)");
        if ($taxrow > 0) {
            $newin = '';
            $newout = '';
            $inputled = explode(",", $taxcheck['inputledgers']);
            $outputled = explode(",", $taxcheck['outputledgers']);
            foreach ($inputled as $i => $in) {
                if ($c == $in) {
                    
                } else {
                    $newin .= $in . ',';
                }
            }
            foreach ($outputled as $out)
            {
                if ($c == $out) {
                    
                } else {
                    $newout .= $out . ',';
                }
            }

            mysql_query("UPDATE `tax` SET `inputledgers`='" . substr($newin, 0, -1) . "' ,`outputledgers`='" . substr($newout, 0, -1) . "' WHERE `tid`='$taxid'  ");
        }
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4><!--<a href="' . $sitename . 'cheque/addcustomer.htm">Try Again</a>--></div>';
    return $res;
}

function delledgergroup($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('ledgergroup','23','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("DELETE FROM `ledger_group` WHERE `ledgergroupid` ='" . $c . "' ");
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4><!--<a href="' . $sitename . 'cheque/addcustomer.htm">Try Again</a>--></div>';
    return $res;
}

function getledgergroup($a, $b) {
    $get = mysql_fetch_array(mysql_query("SELECT * FROM `ledger_group` WHERE `ledgergroupid`='$b' "));
    $res = $get[$a];
    return $res;
}

/* voucher section */

function addvoucher($ledgers, $bank, $dates, $paytype, $cheque, $cdate, $descs, $amounts, $suspenses, $approvals, $void) {
// addvoucher($papadcompany, $date, $papadbalance, $paymentbalance, $papadless,$paymentless, $remark, $type,$status, $ip, $void)
    global $session_value_id;
    if ($void == '') {
        $ip = $_SERVER['REMOTE_ADDR'];

        $lst = DB_QUERY("SELECT `last` FROM `voucher` WHERE `com_id`='" . $_SESSION['UID'] . "' ORDER BY `vid`  DESC");
        if ($lst['last'] == '' || $lst['last'] == '0') {
            $val = 0;
            $purid = 'VOU' . str_pad(1, 8, '0', STR_PAD_LEFT);
        } else {
            $val = $lst['last'];
            $purid = 'VOU' . str_pad($lst['last'] + 1, 8, '0', STR_PAD_LEFT);
        }
        
        $uid = $_SESSION['UID'];
        if ($paytype == 1) {
            $bank = '';
            $ledger_id = 26;
        } else if ($paytype == 2) {
            $ledger_id = getbank('ledger', $bank);
        } else if ($paytype == 3) {
            $ledger_id = 24;
            $appstatus = ",`status`='0'";
        }
        $ledger = explode('##', $ledgers);
        $amount = explode('##', $amounts);
        $date = explode('##', $dates);
        $desc = explode('##', $descs);
        $approval = explode('##', $approvals);

        $suspense = explode('##', $suspenses);
        foreach ($ledger as $i => $voucher) {
            if ($cdate != '') {
                if ($paytype == 2) {
                    $date[$i] = $cdate;
                }
            }

            mysql_query("INSERT INTO `voucher` SET `voucher_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype . "',`bank`='" . $bank . "',`voucherto`='" . $voucher . "',`amount`='" . $amount[$i] . "',`voucher_date`='" . date("Y-m-d", strtotime($date[$i])) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc[$i] . "',`com_id`='" . $_SESSION['UID'] . "',`updated_by`='" . $_SESSION['UID'] . "',`suspense`='" . $suspense[$i] . "' ,`approval`='" . $approval[$i] . "',`ip`='" . $ip . "' ");

            $vid = mysql_insert_id();
            $ref_id = $vid . '_VOUC';

            if ($voucher == 21 || $voucher == 22 || $voucher == 23) {

                $mode = 1;
                $omode = 2;
                $screen_type = 11;
            } else {
                $mode = 2;
                $omode = 1;
                $screen_type = 6;
            }


            mysql_query("INSERT INTO `transactions` SET $session_value_id, `bill_no`='$vid',`bill_date`='" . date("Y-m-d", strtotime($date[$i])) . "',`ledger_id`='$voucher',`bill_type`='$paytype',`amount`='" . $amount[$i] . "',`ref_id`='$ref_id',`screen`='$screen_type',`mode`='$mode',`ip`='" . $ip . "',`updated_by`='" . $uid . "',`narration`='$desc[$i]',`suspense`='" . $suspense[$i] . "',`approval`='" . $approval[$i] . "'  $appstatus");

            $transaction_id = mysql_insert_id();

            mysql_query("UPDATE `voucher` SET `transaction_id`='$transaction_id' WHERE `vid`='$vid' ");

            mysql_query("INSERT INTO `transactions` SET $session_value_id, `bill_no`='$vid',`bill_date`='" . date("Y-m-d", strtotime($date[$i])) . "',`ledger_id`='$ledger_id',`bill_type`='$paytype',`amount`='" . $amount[$i] . "',`ref_id`='$ref_id',`screen`='$screen_type',`mode`='$omode',`ip`='" . $ip . "',`updated_by`='" . $uid . "',`transaction_id`='$transaction_id',`suspense`='" . $suspense[$i] . "',`approval`='" . $approval[$i] . "'  $appstatus");
            if ($paytype == 2) {
                mysql_query("UPDATE `transactions` SET `bank_trans_id`='$ledger_id' WHERE `tid`='$transaction_id' ");
            }
        }

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Inserted</h4></div>';
    } else {
        $uid = $_SESSION['UID'];
        if ($paytype == 1) {
            $bank = '';
        } else if ($paytype == 2) {
            $ledger_id = getbank('ledger', $bank);
        } else if ($paytype == 3) {
            $ledger_id = 24;
            $appstatus = ",`status`='0'";
        }
        $ref_id = $void . '_VOUC';

        $datetime = mysql_fetch_array(mysql_query("SELECT * FROM `transactions` WHERE `ref_id`='$ref_id' AND `mode`='1' "));

        mysql_query("DELETE FROM `transactions` WHERE `ref_id`='" . $ref_id . "' ");

        $ledger = explode('##', $ledgers);
        $amount = explode('##', $amounts);
        $date = explode('##', $dates);
        $desc = explode('##', $descs);
        $suspense = explode('##', $suspenses);
        $approval = explode('##', $approvals);
        foreach ($ledger as $i => $voucher) {
            if ($cdate != '') {
                if ($paytype == 2) {
                    $date[$i] = $cdate;
                }
            }

            mysql_query("UPDATE `voucher` SET  `last`='" . ($val + 1) . "',`type`='" . $paytype . "',`bank`='" . $bank . "',`voucherto`='" . $voucher . "',`amount`='$amount[$i]',`voucher_date`='" . date("Y-m-d", strtotime($date[$i])) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc[$i] . "',$session_value_id,`updated_by`='" . $_SESSION['UID'] . "',`ip`='" . $ip . "',`suspense`='" . $suspense[$i] . "',`approval`='" . $approval[$i] . "' WHERE `vid`='$void' ");


            if ($voucher == 21 || $voucher == 22 || $voucher == 23) {

                $mode = 1;
                $omode = 2;
                $screen_type = 11;
            } else {
                $mode = 2;
                $omode = 1;
                $screen_type = 6;
            }



            mysql_query("INSERT INTO `transactions` SET `com_id`='" . $uid . "', `bill_no`='$void',`bill_date`='" . date("Y-m-d", strtotime($date[$i])) . "',`ledger_id`='$voucher',`bill_type`='$paytype',`amount`='$amount[$i]',`ref_id`='$ref_id',`screen`='$screen_type',`mode`='$mode',`ip`='" . $ip . "',`updated_by`='" . $uid . "',`narration`='$desc[$i]',`date`='" . $date[$i] . "',`suspense`='" . $suspense[$i] . "',`approval`='" . $approval[$i] . "'  $appstatus");
            $transaction_id = mysql_insert_id();

            mysql_query("UPDATE `voucher` SET `transaction_id`='$transaction_id' WHERE `vid`='$void' ");

            mysql_query("INSERT INTO `transactions` SET `com_id`='" . $uid . "', `bill_no`='$void',`bill_date`='" . date("Y-m-d", strtotime($date[$i])) . "',`ledger_id`='$ledger_id',`bill_type`='$paytype',`amount`='$amount[$i]',`ref_id`='$ref_id',`screen`='$screen_type',`mode`='$omode',`ip`='" . $ip . "',`updated_by`='" . $uid . "',`transaction_id`='$transaction_id',`suspense`='" . $suspense[$i] . "' ,`approval`='" . $approval[$i] . "' $appstatus");

            if ($paytype == 2) {
                mysql_query("UPDATE `transactions` SET `bank_trans_id`='$ledger_id' WHERE `tid`='$transaction_id' ");
            }
        }
    }
    return $res;
}

function getvoucher($a, $b) {
    $get = mysql_fetch_array(mysql_query("SELECT * FROM `voucher` WHERE `vid`='$b' "));
    $res = $get[$a];
    return $res;
}

function delvoucher($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Area Master','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("DELETE FROM `voucher` WHERE `vid` ='" . $c . "' ");
        $ref_id = $c . '_VOUC';
        mysql_query("DELETE FROM `transactions` WHERE `ref_id`='" . $ref_id . "' ");
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}

/* voucher section */
/* advance section */

function addadvance($papadcompany, $flourmill, $date, $amount, $paytype, $paymode, $remark, $status, $ip, $eid) {
// addadvance($papadcompany,$date,$amount,$paytype,$paymode,$remark,$ip,$_SESSION['sender_id']);
    if ($eid == '') {
        $ress = DB_QUERY("SELECT `ADid` FROM `advance` WHERE `status`!='2' ");

        $resa = mysql_query("INSERT INTO `advance` (`papadcompany`,`flourmill`,`date`,`amount`,`paytype`,`paymode`,`remark`,`status`,`IP`,`updated-by`,`com_id`) VALUES ('" . $papadcompany . "','" . $flourmill . "','" . date("Y-m-d", strtotime($date)) . "','" . $amount . "','" . $paytype . "','" . $paymode . "','" . $remark . "','" . $status . "','" . $ip . "','" . $_SESSION['UID'] . "','" . $_SESSION['UID'] . "')");
        $insert_id = mysql_insert_id();
        $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`Date`) VALUES ('Area Master','1','Insert','" . $_SESSION['UID'] . "','" . $ip . "','" . $insert_id . "')");
        /* $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4><i class="icon fa fa-check"></i>Succesfully Inserted</h4></div>';
          $res=("INSERT INTO `advance` (`papadcompany`,`date`,`amount`,`paytype`,`paymode`,`remark`,`status`,`IP` ,`updated-by`) VALUES ('" . $papadcompany . "','" . $date . "','" . $amount . "','" . $paytype . "','" . $paymode. "','" . $remark . "','" . $status . "','" . $ip . "','" . $_SESSION['UID'] . "')"); */

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4><i class="icon fa fa-check"></i> Succesfully inserted!</h4></div>';
    } else {

        $resa = mysql_query("UPDATE `advance` SET `papadcompany`='" . $papadcompany . "',`flourmill`='" . $flourmill . "',`date`='" . date("Y-m-d", strtotime($date)) . "',`amount`='" . $amount . "',`paytype`='" . $paytype . "',`paymode`='" . $paymode . "',`remark`='" . $remark . "',`status`='" . $status . "',`IP`='" . $ip . "',`updated-by`='" . $_SESSION['UID'] . "',`com_id`='" . $_SESSION['UID'] . "' WHERE `ADid`='" . $eid . "'");
        $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`Date`) VALUES ('Area Master','1','Update','" . $_SESSION['UID'] . "','" . $ip . "','" . $eid . "')");
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Succesfully Updated!</h4></div>';
    }

    return $res;
}

function getadvance($a, $b) {
    $get = mysql_fetch_array(mysql_query("SELECT * FROM `advance` WHERE `ADid`='$b' AND `status`!='2'"));
    $res = $get[$a];
    return $res;
}

function deladvance($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Area Master','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("DELETE FROM  `advance`  WHERE `ADid` ='" . $c . "' ");
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";


    return $res;
}

/* advance section */

function getreceipts($a, $b) {
    $get = mysql_fetch_array(mysql_query("SELECT * FROM `receipts` WHERE `transaction_id`='$b' "));
    $res = $get[$a];
    return $res;
}

/* receipt section */

function addpapad_payment($user, $bank, $date, $paytype, $cheque, $cdate, $desc, $type, $total, $tid) {

    if ($tid == '') {
        $ip = $_SERVER['REMOTE_ADDR'];

        $lst = DB_QUERY("SELECT `last` FROM `receipts` ORDER BY `rid` DESC");
        if ($lst['last'] == '' || $lst['last'] == '0') {
            $val = 0;
            $purid = 'RE' . str_pad(1, 8, '0', STR_PAD_LEFT);
        } else {
            $val = $lst['last'];
            $purid = 'RE' . str_pad($lst['last'] + 1, 8, '0', STR_PAD_LEFT);
        }
        if ($type == 'papad') {
            $papadcompany = $user;
            $receipt_type = '3';
            $ledgerid = getcompany('ledger', $user);
            // $ledgerid=$user;
        } elseif ($type == 'flourmill') {
            $flourmill = $user;
            $receipt_type = '4';
            $ledgerid = getflourmill('ledger', $user);
        }

        if ($paytype == 1) {

            $ledgerids = 26;
        } elseif ($paytype == 2) {
            //$ledgerids=25;
            $ledgerids = getbank('ledger', $bank);
        } elseif ($paytype == 3) {
            //$ledgerids=25;
            $ledgerids = 24;
            $appstatus = ",`status`='0'";
        }
        if ($paytype == 2) {
            $date = $cdate;
        }

        mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerid',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='2',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`narration`='$desc' $appstatus");
        $insert_id = mysql_insert_id();
        mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerids',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='1',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`transaction_id`='$insert_id',`narration`='$desc' $appstatus ");

        mysql_query("INSERT INTO `receipts` SET `receipt_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype . "',`bank`='" . $bank . "',`papadcompany`='" . $papadcompany . "',`flourmill`='" . $flourmill . "',`amount`='$total',`receipt_date`='" . date("Y-m-d", strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc . "',`receipt_type`='" . $receipt_type . "',`com_id`='" . $_SESSION['UID'] . "',`updated_by`='" . $_SESSION['UID'] . "',`transaction_id`='$insert_id' $appstatus  ");

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Inserted</h4></div>';
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];

        $lst = DB_QUERY("SELECT `last` FROM `receipts` ORDER BY `rid` DESC");
        if ($lst['last'] == '' || $lst['last'] == '0') {
            $val = 0;
            $purid = 'RE' . str_pad(1, 8, '0', STR_PAD_LEFT);
        } else {
            $val = $lst['last'];
            $purid = 'RE' . str_pad($lst['last'] + 1, 8, '0', STR_PAD_LEFT);
        }
        if ($type == 'papad') {
            $papadcompany = $user;
            $receipt_type = '3';
            $ledgerid = getcompany('ledger', $user);
        } elseif ($type == 'flourmill') {
            $flourmill = $user;
            $receipt_type = '4';
            $ledgerid = getflourmill('ledger', $user);
        }

        if ($paytype == 1) {

            $ledgerids = 26;
        } elseif ($paytype == 2) {
            //$ledgerids=25;
            $ledgerids = getbank('ledger', $bank);
        } elseif ($paytype == 3) {
            //$ledgerids=25;
            $ledgerids = 24;
            $appstatus = ",`status`='0'";
        }

        mysql_query("UPDATE `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerid',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='2',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`narration`='$desc' WHERE `tid`='$tid' ");
        $insert_id = $tid;
        mysql_query("UPDATE `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerids',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='1',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`transaction_id`='$insert_id',`narration`='$desc' WHERE `transaction_id`='$tid' ");

        mysql_query("UPDATE`receipts` SET `receipt_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype . "',`bank`='" . $bank . "',`papadcompany`='" . $papadcompany . "',`flourmill`='" . $flourmill . "',`amount`='$total',`receipt_date`='" . date("Y-m-d", strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc . "',`receipt_type`='" . $receipt_type . "',`com_id`='" . $_SESSION['UID'] . "',`updated_by`='" . $_SESSION['UID'] . "',`transaction_id`='$insert_id'  WHERE `transaction_id`='$tid'  ");

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated</h4></div>';
    }
    return $res;
}

/* receipt section */

function updatereceipt($payamounts, $tids, $bank, $date, $paytype, $cheque, $cdate, $desc, $total, $user, $paidnums, $type) {

    $tid = explode('#', $tids);
    $paidnum = explode('#', $paidnums);


    $received_amount = explode('#', $payamounts);
    $lst = DB_QUERY("SELECT `last` FROM `receipts` ORDER BY `rid` DESC");
    if ($lst['last'] == '' || $lst['last'] == '0') {
        $val = 0;
        $purid = 'RE' . str_pad(1, 8, '0', STR_PAD_LEFT);
    } else {
        $val = $lst['last'];
        $purid = 'RE' . str_pad($lst['last'] + 1, 8, '0', STR_PAD_LEFT);
    }
    if ($type == 'receipt') {
        $customer = $user;
        $receipt_type = '1';
        $mode = 1;
        $type1 = 'R';
        $omode = 2;
        $screen = 11;
    } elseif ($type == 'payment') {
        $supplier = $user;
        $receipt_type = '2';
        $mode = 2;
        $type1 = 'P';
        $omode = 1;
        $screen = 6;
    }
    if ($paytype == 1) {

        $ledgerids = 26;
    } elseif ($paytype == 2) {
        // $ledgerids=25;
        $ledgerids = getbank('ledger', $bank);
    } elseif ($paytype == 3) {
        //$ledgerids=25;
        $ledgerids = 24;
        $appstatus = ",`status`='0'";
    }

    mysql_query("INSERT INTO `receipts` SET `receipt_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype . "',`customer`='" . $customer . "',`supplier`='" . $supplier . "',`amount`='$total',`bank`='" . $bank . "',`receipt_date`='" . date("Y-m-d", strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . mysql_real_escape_string($desc) . "',`receipt_type`='" . $receipt_type . "',`com_id`='" . $_SESSION['UID'] . "' $appstatus");
    $insert_id = mysql_insert_id();


    for ($i = 0; $i < (count($received_amount)); $i++) {

        if ($received_amount[$i] != 0) {
            $ts = DB_QUERY("SELECT * FROM `transactions` WHERE `tid`='$tid[$i]' ");
            /*
              $amountt = $ts['amount'];
              $balance = $amountt - $received_amount[$i];

              $rece_amount = $received_amount[$i] + $ts['received_amount'];

              mysql_query("UPDATE `transactions` SET `received_amount`='" . $rece_amount . "',`return_amount`='" . $balance . "' WHERE `tid`='" . $tid[$i] . "'");
             */
            /* mysql_query("INSERT INTO `transactions` SET `com_id`='". $_SESSION['UID']."', `bill_no`='".$ts['bill_no']."',`bill_date`='". date("Y-m-d",strtotime($date)) ."',`ledger_id`='".$ts['ledger_id']."',`bill_type`='".$ts['bill_type']."',`amount`='".$received_amount[$i]."',`return_amount`='$rtotal',`received_amount`='($total-$rtotal)',`ref_id`='".$ts['bill_no']."',`screen`='".$ts['screen']."',`mode`='2',`ip`='".$_SERVER['REMOTE_ADDR']."',`updated_by`='". $_SESSION['UID']."'  "); */
            mysql_query("INSERT INTO `receipt_details` SET `rid`='" . $insert_id . "',`tid`='" . $tid[$i] . "',`amount`='" . $received_amount[$i] . "'");

            mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='" . $ts['bill_no'] . "',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='" . $ts['ledger_id'] . "',`bill_type`='" . $paytype . "',`amount`='" . $received_amount[$i] . "',`ref_id`='" . $ts['ref_id'] . "',`screen`='" . $screen . "',`mode`='$mode',`narration`='" . mysql_real_escape_string($desc) . "', `ip`='" . $_SERVER['REMOTE_ADDR'] . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='" . $type1 . "' $appstatus ");
            $transaction_id = mysql_insert_id();

            if ($paidnum[$i] != '') {
                DB_QUERY("UPDATE `transactions` SET  `ref_col`='" . $transaction_id . "' WHERE  `tid`='" . $paidnum[$i] . "' ");
            }

            mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='" . $ts['bill_no'] . "',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='" . $ledgerids . "',`bill_type`='" . $paytype . "',`amount`='" . $received_amount[$i] . "',`ref_id`='" . $ts['ref_id'] . "',`screen`='" . $screen . "',`mode`='$omode',`narration`='" . mysql_real_escape_string($desc) . "',`ip`='" . $_SERVER['REMOTE_ADDR'] . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='" . $type2 . "',`transaction_id`='$transaction_id' $appstatus  ");

            if ($ts['bill_type'] == 2) {
                mysql_query("UPDATE `transactions` SET `bank_trans_id`='$ledgerids' WHERE `tid`='$transaction_id' ");
            }
        }




        // $res="UPDATE `transactions` SET `received_amount`='" . $received_amount[$i] . "',`balance`='" . $balance . "' WHERE `tid`='" .  $tid[$i] . "'";
        /* $resa = mysql_query("INSERT INTO `ledger` (`Name`, `printname`,`aliasname`,`under` ,`subledger`,`openbal` ,`default` ,`IP` ,`Updated_By`,`com_id`,`paymode`) VALUES ('" . $name . "','" . $printname . "','" . $aliasname . "','" . $under . "','" . $undersub . "','" . $openbal . "','$status','" . $ip . "','" . $_SESSION['UID'] . "','" . $_SESSION['UID'] . "','".$paymode."')");
         */
    }
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated!</h4></div>';

    return $res;
}

function editsupplierpayments($amount, $date, $paytype, $bank, $cheque, $cdate, $desc, $tid) {
    $daten = $date;

    if ($paytype == 1) {

        $ledgerids = 26;
    } elseif ($paytype == 2) {
        // $ledgerids=25;
        $ledgerids = getbank('ledger', $bank);
        $daten = $cdate;
    } elseif ($paytype == 3) {
        //$ledgerids=25;
        $ledgerids = 24;
        //   $appstatus=",`status`='0'";
    }
    $receipt = DB_QUERY("SELECT * FROM `receipts`  WHERE `transaction_id`='" . $tid . "'");

    mysql_query("UPDATE `receipts` SET  `type`='" . $paytype . "' ,`amount`='$amount',`bank`='" . $bank . "',`receipt_date`='" . date("Y-m-d", strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc . "'  $appstatus");


    mysql_query("UPDATE `transactions` SET  `bill_date`='" . date("Y-m-d", strtotime($daten)) . "',`amount`='" . $amount . "',`updated_by`='" . $_SESSION['UID'] . "', `bill_type`='" . $paytype . "'  WHERE `tid`='$tid' ");



    mysql_query("UPDATE `transactions` SET  `bill_date`='" . date("Y-m-d", strtotime($daten)) . "',`amount`='" . $amount . "',`updated_by`='" . $_SESSION['UID'] . "' , `bill_type`='" . $paytype . "',`ledger_id`='" . $ledgerids . "'  WHERE `transaction_id`='$tid' ");

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated!</h4></div>';

    return $res;
}

function updatepayment($payamounts, $tids, $banks, $date, $paytypes, $cheques, $cdates, $desc, $total, $user, $invoice_nos, $type) {

    $tid = explode('#', $tids);
    $received_amount = explode('#', $payamounts);
    $paytype = explode('#', $paytypes);
    $bank = explode('#', $banks);
    $cheque = explode('#', $cheques);
    $cdate = explode('#', $cdates);
    $invoice_no = explode('#', $invoice_nos);

    for ($i = 0; $i < (count($received_amount)); $i++) {

        if ($received_amount[$i] != 0 || $received_amount[$i] != '') {

            $lst = DB_QUERY("SELECT `last` FROM `receipts` ORDER BY `rid` DESC");
            if ($lst['last'] == '' || $lst['last'] == '0') {
                $val = 0;
                $purid = 'RE' . str_pad(1, 8, '0', STR_PAD_LEFT);
            } else {
                $val = $lst['last'];
                $purid = 'RE' . str_pad($lst['last'] + 1, 8, '0', STR_PAD_LEFT);
            }

            $supplier = $user;
            $receipt_type = '2';
            $mode = 2;
            $type1 = 'P';
            $omode = 1;
            $screen = 6;

            if ($paytype[$i] == 1) {

                $ledgerids = 26;
            } elseif ($paytype[$i] == 2) {
                // $ledgerids=25;
                $ledgerids = getbank('ledger', $bank[$i]);
            } elseif ($paytype[$i] == 3) {
                $ledgerids = 24;
            }

            mysql_query("INSERT INTO `receipts` SET `receipt_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype[$i] . "',`customer`='" . $customer . "',`supplier`='" . $supplier . "',`amount`='$total',`bank`='" . $bank[$i] . "',`receipt_date`='" . date("Y-m-d", strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate[$i])) . "',`bank_no`='" . $cheque[$i] . "',`description`='" . $desc . "',`receipt_type`='" . $receipt_type . "',`com_id`='" . $_SESSION['UID'] . "' $appstatus");
            $insert_id = mysql_insert_id();



            $ts = DB_QUERY("SELECT * FROM `transactions` WHERE `tid`='$tid[$i]' ");

            mysql_query("INSERT INTO `receipt_details` SET `rid`='" . $insert_id . "',`tid`='" . $tid[$i] . "',`amount`='" . $received_amount[$i] . "'");

            if ($cdate[$i] != '') {
                $date = $cdate[$i];
            }

            mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='" . $ts['bill_no'] . "',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='" . $ts['ledger_id'] . "',`bill_type`='" . $paytype[$i] . "',`amount`='" . $received_amount[$i] . "',`ref_id`='" . $ts['ref_id'] . "',`screen`='" . $screen . "',`mode`='$mode',`ip`='" . $_SERVER['REMOTE_ADDR'] . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='" . $type1 . "',`invoice_no`='" . $invoice_no[$i] . "' $appstatus ");
            $transaction_id = mysql_insert_id();

            mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='" . $ts['bill_no'] . "',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='" . $ledgerids . "',`bill_type`='" . $paytype[$i] . "',`amount`='" . $received_amount[$i] . "',`ref_id`='" . $ts['ref_id'] . "',`screen`='" . $screen . "',`mode`='$omode',`ip`='" . $_SERVER['REMOTE_ADDR'] . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='" . $type2 . "',`transaction_id`='$transaction_id',`invoice_no`='" . $invoice_no[$i] . "' $appstatus  ");
            $transaction_id2 = mysql_insert_id();

            if ($paytype[$i] == 2) {
                mysql_query("UPDATE `transactions` SET `bank_trans_id`='$transaction_id2' WHERE `tid`='$transaction_id' ");
            }

            mysql_query("UPDATE `receipts` SET `transaction_id`='$transaction_id' WHERE `rid`='$insert_id' ");
        }




        // $res="UPDATE `transactions` SET `received_amount`='" . $received_amount[$i] . "',`balance`='" . $balance . "' WHERE `tid`='" .  $tid[$i] . "'";
        /* $resa = mysql_query("INSERT INTO `ledger` (`Name`, `printname`,`aliasname`,`under` ,`subledger`,`openbal` ,`default` ,`IP` ,`Updated_By`,`com_id`,`paymode`) VALUES ('" . $name . "','" . $printname . "','" . $aliasname . "','" . $under . "','" . $undersub . "','" . $openbal . "','$status','" . $ip . "','" . $_SESSION['UID'] . "','" . $_SESSION['UID'] . "','".$paymode."')");
         */
    }
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated!</h4></div>';

    return $res;
}

function addsalary($employee, $date, $amount, $paytype, $paymode, $remark, $ip, $said) {
    /*
      $resa = mysql_query("INSERT INTO `salarydetails` (`employee`,`date`,`paymode`,`paytype`,`salaryamount`,`remark`,`type`,`status`,`ip`,`update-by`,`com_id`) VALUES ('" . $employee . "','" . date("Y-m-d", strtotime($date)) . "','" . $paymode . "','" . $paytype . "','" . $amount . "','" . $remark . "','" . $ip . "','" . $_SESSION['UID'] . "','" . $_SESSION['UID'] . "')");
      $insert_id = mysql_insert_id(); */

    mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerid',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='1',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "'");



    mysql_query("INSERT INTO `receipts` SET `receipt_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype . "',`papadcompany`='" . $papadcompany . "',`flourmill`='" . $flourmill . "',`amount`='$total',`receipt_date`='" . date("Y-m-d", strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc . "',`receipt_type`='" . $receipt_type . "',`com_id`='" . $_SESSION['UID'] . "',`updated_by`='" . $_SESSION['UID'] . "'");
}

function getsalary($a, $b) {

    $get = mysql_fetch_array(mysql_query("SELECT * FROM `salary_details` WHERE `sid`='$b' "));
    $res = $get[$a];
    return $res;
}

/* getsubledger */

function getsubledger($a, $b) {
    $get = mysql_fetch_array(mysql_query("SELECT * FROM `subledgergroup` WHERE `slid`='$b' "));
    $res = $get[$a];
    return $res;
}

function addsubledger($name, $ledgergroup, $slid) {
	
	list($ledgergroup) = null_zero(array($ledgergroup));
    if ($slid == '') {

        $resa = mysql_query("INSERT INTO `subledgergroup` (`ledgergroup`,`sname`) VALUES ('" . $ledgergroup . "','" . $name . "')");

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Succesfully Inserted</h4></div>';
    } else {
        mysql_query("UPDATE `subledgergroup` SET `ledgergroup`='" . $ledgergroup . "',`sname`='" . $name . "' WHERE `slid`='" . $slid . "' ");

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Succesfully Updated</h4></div>';
    }
    return $res;
}

function delsubledger($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        //  $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Area Master','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("DELETE FROM `subledgergroup` WHERE `slid` ='" . $c . "' ");
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";


    return $res;
}

function addtransaction($uid, $bill_no, $bill_date, $ledgerid, $bill_type, $amount, $ref_id, $screen, $mode, $ip, $usid, $purid, $salid) {
    mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$bill_no',`bill_date`='" . date("Y-m-d", strtotime($bill_date)) . "',`ledger_id`='$ledgerid',`bill_type`='$bill_type',`amount`='$amount',`ref_id`='$ref_id',`screen`='$screen',`mode`='$mode',`ip`='" . $ip . "',`updated_by`='" . $usid . "',`invoice_purchase`='$purid',`invoice_sales`='$salid'  ");

    return mysql_insert_id();
}

function addopeningbal($uid, $bill_no, $bill_date, $ledgerid, $bill_type, $amount, $desc, $screen, $mode, $ip, $uid, $tid) {
    global $session_value_id;

    if ($tid == '') {
        mysql_query("INSERT INTO `transactions` SET  $session_value_id, `bill_no`='$bill_no',`bill_date`='" . date("Y-m-d", strtotime($bill_date)) . "',`ledger_id`='$ledgerid',`bill_type`='$bill_type',`amount`='$amount',`narration`='$desc',`screen`='$screen',`mode`='$mode',`ip`='" . $ip . "',`updated_by`='" . $uid . "'");
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Inserted</h4></div>';
    } else {
        mysql_query("UPDATE `transactions` SET $session_value_id, `bill_no`='$bill_no',`bill_date`='" . date("Y-m-d", strtotime($bill_date)) . "',`ledger_id`='$ledgerid',`bill_type`='$bill_type',`amount`='$amount',`narration`='$desc',`screen`='$screen',`mode`='$mode',`ip`='" . $ip . "',`updated_by`='" . $uid . "' WHERE `tid`='" . $tid . "'");
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated</h4></div>';
    }





    return $res;
}

function delopenbal($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        //  $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Area Master','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("DELETE FROM `transactions` WHERE `tid` ='" . $c . "' ");
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";


    return $res;
}

function gettransaction($a, $b) {
    $get = mysql_fetch_array(mysql_query("SELECT * FROM `transactions` WHERE `tid`='$b' "));
    $res = $get[$a];
    return $res;
}

function updatepapadflouradvance($user, $bank, $date, $paytype, $cheque, $cdate, $desc, $type, $total) {

    $ip = $_SERVER['REMOTE_ADDR'];

    $lst = DB_QUERY("SELECT `last` FROM `receipts` ORDER BY `rid` DESC");
    if ($lst['last'] == '' || $lst['last'] == '0') {
        $val = 0;
        $purid = 'RE' . str_pad(1, 8, '0', STR_PAD_LEFT);
    } else {
        $val = $lst['last'];
        $purid = 'RE' . str_pad($lst['last'] + 1, 8, '0', STR_PAD_LEFT);
    }
    if ($type == 'papad') {
        $papadcompany = $user;
        $receipt_type = '3';
        $ledgerid = getcompany('adledger', $user);
    } elseif ($type == 'flourmill') {
        $flourmill = $user;
        $receipt_type = '4';
        $ledgerid = getflourmill('adledger', $user);
    }

    if ($paytype == 1) {

        $ledgerids = 26;
    } elseif ($paytype == 2) {
        //$ledgerids=25;
        $ledgerids = getbank('ledger', $bank);
    } elseif ($paytype == 3) {
        //$ledgerids=25;
        $ledgerids = 24;

        $appstatus = ",`status`='0'";
    }

    mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerid',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='1',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "' $appstatus");

    $transactionid = mysql_insert_id();

    mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerids',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='2',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`transaction_id`='$transactionid' $appstatus ");
    if ($paytype == 2) {
        mysql_query("UPDATE `transactions` SET `bank_trans_id`='$ledgerids' WHERE `tid`='$transaction_id' ");
    }
    /*  mysql_query("INSERT INTO `receipts` SET `receipt_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype . "',`bank`='".$bank."',`papadcompany`='" . $papadcompany. "',`flourmill`='" . $flourmill . "',`amount`='$total',`receipt_date`='" . date("Y-m-d",strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc . "',`receipt_type`='" . $receipt_type . "',`com_id`='" . $_SESSION['UID'] . "',`updated_by`='" . $_SESSION['UID'] . "',`transaction_id`='$transactionid' "); */

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Inserted</h4></div>';

    return $res;
}

function editpapadadvance($user, $bank, $date, $paytype, $cheque, $cdate, $desc, $type, $total, $tid) {
    mysql_query("DELETE FROM `transactions` WHERE `tid` ='" . $tid . "' ");

    mysql_query("DELETE FROM `transactions` WHERE `transaction_id` ='" . $tid . "' ");
    mysql_query("DELETE FROM `receipts` WHERE `transaction_id` ='" . $tid . "' ");

    $ip = $_SERVER['REMOTE_ADDR'];

    $lst = DB_QUERY("SELECT `last` FROM `receipts` ORDER BY `rid` DESC");
    if ($lst['last'] == '' || $lst['last'] == '0') {
        $val = 0;
        $purid = 'RE' . str_pad(1, 8, '0', STR_PAD_LEFT);
    } else {
        $val = $lst['last'];
        $purid = 'RE' . str_pad($lst['last'] + 1, 8, '0', STR_PAD_LEFT);
    }

    $papadcompany = $user;
    $receipt_type = '3';
    $ledgerid = getcompany('adledger', $user);

    if ($paytype == 1) {

        $ledgerids = 26;
    } elseif ($paytype == 2) {
        //$ledgerids=25;
        $ledgerids = getbank('ledger', $bank);
    } elseif ($paytype == 3) {
        //$ledgerids=25;
        $ledgerids = 24;
        $appstatus = ",`status`='0'";
    }

    mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerid',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='1',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "' $appstatus");

    $transactionid = mysql_insert_id();

    mysql_query("INSERT INTO `transactions` SET `com_id`='" . $_SESSION['UID'] . "', `bill_no`='$userid',`bill_date`='" . date("Y-m-d", strtotime($date)) . "',`ledger_id`='$ledgerids',`bill_type`='$paytype',`amount`='$total',`ref_id`='$userid',`screen`='6',`mode`='2',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`transaction_id`='$transactionid' $appstatus ");

    /* mysql_query("INSERT INTO `receipts` SET `receipt_no`='$purid',`last`='" . ($val + 1) . "',`type`='" . $paytype . "',`bank`='".$bank."',`papadcompany`='" . $papadcompany. "',`flourmill`='" . $flourmill . "',`amount`='$total',`receipt_date`='" . date("Y-m-d",strtotime($date)) . "',`bank_date`='" . date("Y-m-d", strtotime($cdate)) . "',`bank_no`='" . $cheque . "',`description`='" . $desc . "',`receipt_type`='" . $receipt_type . "',`com_id`='" . $_SESSION['UID'] . "',`updated_by`='" . $_SESSION['UID'] . "',`transaction_id`='$transactionid' "); */

    $res = $transactionid;

    return $res;
}

function delnotes($a, $mode) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        //  $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Area Master','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("DELETE FROM `transactions` WHERE `tid` ='" . $c . "' ");

        $cid = $c . '_' . $mode;
        mysql_query("DELETE FROM `transactions` WHERE `note` ='" . $cid . "' ");
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";


    return $res;
}

function delpapadadvances($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        //  $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Area Master','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("DELETE FROM `transactions` WHERE `tid` ='" . $c . "' ");
        if ($c != '') {
            mysql_query("DELETE FROM `transactions` WHERE `transaction_id` ='" . $c . "' ");

            mysql_query("DELETE FROM `transactions` WHERE `ref_col` ='" . $c . "' ");
            mysql_query("DELETE FROM `receipts` WHERE `transaction_id` ='" . $c . "' ");
        }
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';

    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";


    return $res;
}

function approvetransactions($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        //  $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Area Master','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("UPDATE`transactions` SET `status`='0' WHERE `tid` ='" . $c . "' ");
        if ($c != '') {
            mysql_query("UPDATE `transactions` SET `status`='0' WHERE `transaction_id` ='" . $c . "' ");
            mysql_query("UPDATE `receipts` SET `status`='0' WHERE `transaction_id` ='" . $c . "' ");
        }
    }
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Approved</h4></div>';

    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";


    return $res;
}

function approvevoucher($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        //  $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Area Master','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        $get = mysql_query("UPDATE `voucher`  SET `approval`='0'  WHERE `vid` ='" . $c . "' ");


        $ref_id = $c . '_VOUC';
        mysql_query("UPDATE `transactions`  SET `approval`='0'  WHERE `ref_id`='" . $ref_id . "' ");
    }
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Approved</h4></div>';

    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";


    return $res;
}

function getrtransaction($b, $a) {
    $customer = DB_QUERY("SELECT * FROM `receipts` WHERE `transaction_id`='$a' ");

    $name = $customer[$b];

    return $name;
}

function getcustomerbyledgerid($a) {
    $customer = DB_QUERY("SELECT * FROM `customermaster` WHERE `ledger`='$a' ");

    $name = $customer['firstname'];

    return $name;
}

function getsupplierbyledgerid($a) {
    $customer = DB_QUERY("SELECT * FROM `supplier` WHERE `ledger`='$a' ");

    $name = $customer['companyname'];

    return $name;
}

function addbankacc($ledgerb, $ledgers, $dates, $crdrs, $amounts, $ip, $textarea, $tid, $typs) {
    global $session_value_id;
    if ($tid == '') {

        /*         * ********** BAnk Entry *********************** */
        $ledgers2 = explode(',', $ledgerb);
        $ledgers1 = explode(',', $ledgers);
        $dates1 = explode(',', $dates);
        $crdrs1 = explode(',', $crdrs);
        $amounts1 = explode(',', $amounts);
        foreach ($ledgers1 as $i => $bankled) {
            if ($bankled != '') {


                if (DB_NUM("SELECT * FROM `supplier` WHERE `ledger`='$ledgers2[$i]' ") > 0) {

                    $type_update = ",`newtype`='P'";
                }
                if (DB_NUM("SELECT * FROM `customermaster` WHERE `ledger`='$ledgers2[$i]' ") > 0) {

                    $type_update = ",`newtype`='R'";
                }

                if ($crdrs1[$i] == '1') {
                    $mm = '2';
                    $screen = 11;
                } else {


                    $mm = '1';
                    $screen = 6;
                }

                $resa = mysql_query("INSERT INTO `transactions`  SET $session_value_id,`bill_type`='2',`ledger_id`='" . $ledgers2[$i] . "',`bill_date`='" . date("Y-m-d", strtotime($dates1[$i])) . "',`mode`='" . $crdrs1[$i] . "',`amount`='" . $amounts1[$i] . "',`ip`='" . $ip . "',`narration`='" . $textarea . "',`updated_by`='" . $_SESSION['UID'] . "',`screen`='$screen',`type`='$typs' $type_update ");
                $insert_id = mysql_insert_id();
                $resa = mysql_query("INSERT INTO `transactions` SET $session_value_id,`bill_type`='2',`ledger_id`='" . $bankled . "',`bill_date`='" . date("Y-m-d", strtotime($dates1[$i])) . "',`mode`='" . $mm . "',`amount`='" . $amounts1[$i] . "',`ip`='" . $ip . "',`narration`='" . $textarea . "',`updated_by`='" . $_SESSION['UID'] . "',`screen`='$screen',`type`='$typs',`transaction_id`='$insert_id' ");


                mysql_query("UPDATE `transactions` SET `bank_trans_id`='$bankled' WHERE `tid`='$insert_id'  ");



                $transaction_id2 = mysql_insert_id();

                mysql_query("UPDATE `transactions` SET `transaction_id`='$transaction_id2' WHERE `tid`='$insert_id'  ");
            }
        }


        return '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';

        /*         * *************** BAnk Entry End ******************* */
    }

    return $res;
}

function addnewjournals($ledger1, $ledger2, $date1, $date2, $mode1, $mode2, $amount1, $amount2, $ip, $textarea, $tid) {
    global $session_value_id;
    if ($tid == '') {


        /*         * *************** Journal Entry ******************** */

        mysql_query("INSERT INTO `transactions` SET $session_value_id, `bill_no`='$ledger1',`bill_date`='" . date("Y-m-d", strtotime($date1)) . "',`ledger_id`='$ledger1',`bill_type`='1',`amount`='$amount1',`ref_id`='$ledger1',`screen`='10',`mode`='" . $mode1 . "',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='J',`narration`='$textarea'  ");


        $insert_id = mysql_insert_id();

        mysql_query("INSERT INTO `transactions` SET $session_value_id, `bill_no`='$ledger2',`bill_date`='" . date("Y-m-d", strtotime($date2)) . "',`ledger_id`='$ledger2',`bill_type`='1',`amount`='$amount2',`ref_id`='$ledger2',`screen`='10',`mode`='" . $mode2 . "',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='J',`narration`='$textarea',`transaction_id`='$insert_id'  ");

        $insert_id2 = mysql_insert_id();

        mysql_query("UPDATE `transactions` SET `transaction_id`='$insert_id2' WHERE `tid`='$insert_id' ");

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        delpapadadvances($tid);
        mysql_query("INSERT INTO `transactions` SET $session_value_id, `bill_no`='$ledger1',`bill_date`='" . date("Y-m-d", strtotime($date1)) . "',`ledger_id`='$ledger1',`bill_type`='1',`amount`='$amount1',`ref_id`='$ledger1',`screen`='10',`mode`='" . $mode1 . "',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='J',`narration`='$textarea'  ");


        $insert_id = mysql_insert_id();

        mysql_query("INSERT INTO `transactions` SET $session_value_id, `bill_no`='$ledger2',`bill_date`='" . date("Y-m-d", strtotime($date2)) . "',`ledger_id`='$ledger2',`bill_type`='1',`amount`='$amount2',`ref_id`='$ledger2',`screen`='10',`mode`='" . $mode2 . "',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='J',`narration`='$textarea',`transaction_id`='$insert_id'  ");

        $insert_id2 = mysql_insert_id();

        mysql_query("UPDATE `transactions` SET `transaction_id`='$insert_id2' WHERE `tid`='$insert_id' ");

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }
    return $res;
}

function addjournal($ledgers, $dates, $crdrs, $amounts, $ip, $textarea, $tid, $typs)
{
    if ($tid == '')
    {
        /***************** Journal Entry *********************/
        $ledgers1 = explode(',', $ledgers);
        $dates1 = explode(',', $dates);
        $crdrs1 = explode(',', $crdrs);
        $amounts1 = explode(',', $amounts);
        foreach ($ledgers1 as $i => $journal) {

            delpapadadvances($journal);

            if ($journal != '') {
                if ($crdrs1[$i] != '') {
                    $resa = mysql_query("INSERT INTO `transactions` (`com_id`,`bill_type`,`ledger_id`,`bill_date`,`mode`,`amount`,`ip`,`narration`,`updated_by`,`screen`,`type`) VALUES ('" . $_SESSION['UID'] . "','1','" . $journal . "','" . date("Y-m-d", strtotime($dates1[$i])) . "','1','" . $crdrs1[$i] . "','" . $ip . "','" . $textarea . "','" . $_SESSION['UID'] . "','10','$typs')");
                    $insert_id = mysql_insert_id();
                }
                if ($amounts1[$i] != '') {
                    $resa = mysql_query("INSERT INTO `transactions` (`com_id`,`bill_type`,`ledger_id`,`bill_date`,`mode`,`amount`,`ip`,`narration`,`updated_by`,`screen`,`type`,`transaction_id`) VALUES ('" . $_SESSION['UID'] . "','1','" . $journal . "','" . date("Y-m-d", strtotime($dates1[$i])) . "','2','" . $amounts1[$i] . "','" . $ip . "','" . $textarea . "','" . $_SESSION['UID'] . "','10','$typs','$insert_id')");
                    $insert_id2 = mysql_insert_id();

                    mysql_query("UPDATE `transactions` SET `transaction_id`='$insert_id2' WHERE `tid`='$insert_id' ");
                }
            }
        }

        /*         * **************** Journal Entry End ****************** */


        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    }

    return $res;
}

function addcashacc($ledgers, $dates, $crdrs, $amounts, $ip, $textarea, $tid, $typs, $ledgeracc, $billtype) {
    global $session_value_id;
    if ($tid == '') {

        /************ Cash Entry ************************/

        $ledgers1 = explode(',', $ledgers);
        $dates1 = explode(',', $dates);
        $crdrs1 = explode(',', $crdrs);
        $amounts1 = explode(',', $amounts);
        if ($billtype == 3)
        {
            $appstatus = ",`status`='0'";
        }
        foreach ($ledgers1 as $i => $ledgers1s) {
            if ($ledgers1s != '') {

                if ($crdrs1[$i] == '1') {
                    $mm = '2';
                    $screen = 11;
                } else {
                    $mm = '1';
                    $screen = 6;
                }
                mysql_query("INSERT INTO `transactions` SET $session_value_id, `bill_no`='$voucher',`bill_date`='" . date("Y-m-d", strtotime($dates1[$i])) . "',`ledger_id`='$ledgers1s',`bill_type`='$billtype',`amount`='$amounts1[$i]',`ref_id`='$ref_id',`screen`='$screen',`mode`='" . $crdrs1[$i] . "',`ip`='" . $_SESSION['UID'] . "',`updated_by`='" . $uid . "',`type`='$typs',`narration`='$textarea' $appstatus");

                $transaction_id = mysql_insert_id();
                mysql_query("INSERT INTO `transactions` SET $session_value_id, `bill_no`='$voucher',`bill_date`='" . date("Y-m-d", strtotime($dates1[$i])) . "',`ledger_id`='$ledgeracc',`bill_type`='$billtype',`amount`='$amounts1[$i]',`ref_id`='$ref_id',`screen`='$screen',`mode`='" . $mm . "',`ip`='" . $ip . "',`updated_by`='" . $_SESSION['UID'] . "',`type`='$typs',`narration`='$textarea',`transaction_id`='$transaction_id' $appstatus");
                $transaction_id2 = mysql_insert_id();
                mysql_query("UPDATE `transactions` SET `transaction_id`='$transaction_id2' WHERE `tid`='$transaction_id'  ");
            }
        }

        /***************** Cash Entry End ********************/

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    }
    return $res;
}
?>