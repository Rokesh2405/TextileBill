<?php

function country_list($id = '', $multiple = '') {
    global $db;
    $country = $db->prepare("SELECT * FROM `countries` WHERE `id`!=''");
    $country->execute();
    $select = '<select name="country' . $multiple . '" id="country' . $multiple . '" class="form-control"><option value="0">Select Country</option>';
    while ($fetch = $country->fetch()) {
        $sel = ($fetch['id'] == $id) ? "selected" : '';
        $select .= '<option value="' . $fetch['id'] . '" ' . $sel . '>' . $fetch['name'] . '</option>';
    }
    $select .= '</select>';
    return $select;
}

function state_list($id = '', $cid = '', $multiple = '') {
    global $db;
    $cid = ($cid) ? " AND `country_id`='$cid'" : " AND `id`='0'";
    $states = $db->prepare("SELECT * FROM `states` WHERE `id`!='' $cid");
    $states->execute();
    $select = '<select name="state' . $multiple . '" id="state' . $multiple . '" class="form-control"><option value="0">Select State</option>';
    while ($fetch = $states->fetch()) {
        $sel = ($fetch['id'] == $id) ? "selected" : '';
        $select .= '<option value="' . $fetch['id'] . '" ' . $sel . '>' . $fetch['name'] . '</option>';
    }
    $select .= '</select>';
    return $select;
}

function city_list($id = '', $sid = '', $multiple = '') {
    global $db;
    $sid = ($sid) ? " AND `state_id`='$sid'" : " AND `id`='0'";
    $cities = $db->prepare("SELECT * FROM `cities` WHERE `id`!='' $sid");
    $cities->execute();
    $select = '<select name="city' . $multiple . '" id="city' . $multiple . '" class="form-control"><option value="0">Select City</option>';
    while ($fetch = $cities->fetch()) {
        $sel = ($fetch['id'] == $id) ? "selected" : '';
        $select .= '<option value="' . $fetch['id'] . '" ' . $sel . '>' . $fetch['name'] . '</option>';
    }
    $select .= '</select>';
    return $select;
}

function null_zero($fields){
    if(!empty($fields)){
        $new_fields = [];
        foreach($fields as $field){
            $new_fields[] = ($field=='' || strtolower($field)=='nan') ? '0' : $field;
        }
    }
    if(!empty($new_fields)){
        return $new_fields;
    }else{
        return $fields;
    }
}

function getsubledger($a, $b) {
    $get = mysql_fetch_array(mysql_query("SELECT * FROM `subledgergroup` WHERE `slid`='$b' "));
    $res = $get[$a];
    return $res;
}

function addsubledger($ledgergroup, $name,$slid) {
	
	list($ledgergroup) = null_zero(array($ledgergroup));
    if ($slid == '') {

        mysql_query("INSERT INTO `subledgergroup` (`ledgergroup`,`sname`) VALUES ('" . $ledgergroup . "','" . $name . "')");

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

function addbank($bankname, $bankcode, $branchname, $Acc_no,$ifsccode, $swift, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $id) {
    global $db;
	list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `BankID` FROM `bank` WHERE `Bank_Code`=?");
        $ress1->execute(array($name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['BankID'] == '') {
            //(`BankID`, `Bank_Name`, `Bank_Code`, `Branch_Name`, `IFSC_Code`, `Address`, `Country`, `State`, `City`, `Area`, `Postal_Code`, `Order`, `Status`, `IP`, `Updated_by`, `Updated_type`, `date`)
            $resa = $db->prepare("INSERT INTO `bank` (`Bank_Name`, `Bank_Code`, `Branch_Name`,`Acc_no`, `IFSC_Code`, `swift_code`, `Address`, `Country`, `State`, `City`, `Area`, `Postal_Code`, `Image`,`Order`, `Status`, `IP`, `Updated_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($bankname, $bankcode, $branchname,$Acc_no, $ifsccode, $swift, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();

            $resa = $db->prepare("INSERT INTO `ledger` (`Name`, `printname` ,`under`,`sub_under`, `status`,`Order` ,`IP` ,`Updated_By`) VALUES (?,?,?,?,?,?,?,?)");
            $resa->execute(array($bankname, $bankname, '15', '0', '1', $order, $ip, $_SESSION['UID']));
            $insertsl_id = $db->lastInsertId();

            $supupdate = $db->prepare("UPDATE `bank` SET `ledger_id`=? WHERE `BankID`=? ");
            $supupdate->execute(array($insertsl_id, $insert_id));


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Bank', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Bank Code</h4></div>';
        }
    } else {

        $ress1 = $db->prepare("SELECT * FROM `bank` WHERE `Bank_Code`=? AND `BankID`!=?");
        $ress1->execute(array($name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);

        if ($ress['BankID'] == '') {

            $resa = $db->prepare("UPDATE `bank` SET `Bank_Name`=?, `Bank_Code`=?, `Branch_Name`=?,`Acc_no`=?, `IFSC_Code`=?,`swift_code`=?, `Address`=?, `Country`=?, `State`=?, `City`=?, `Area`=?, `Postal_Code`=?,`Image`=?, `Order`=?, `Status`=?, `IP`=?, `Updated_by`=? WHERE `BankID`=? ");
            $resa->execute(array($bankname, $bankcode, $branchname,$Acc_no, $ifsccode, $swift, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $_SESSION['UID'], $id));

            $pupdate = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=? WHERE `lid`=? ");
            $pupdate->execute(array($bankname, $bankname, getbank('ledger_id', $id)));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Bank', 3, 'Update', $_SESSION['UID'], $ip, $id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Bank Code</h4></div>';
        }
    }
    return $res;
}

function getbank($a = '', $b = '') {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `bank` WHERE `BankID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delbank($a) {
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    
    $err_del = array();
    
    foreach ($b as $c) {
        $gets = delledger(getbank('ledger_id',$c));
        if($gets[0]=='0'){
            $pimage = getbank('Image', $c);
            if ($pimage != '') {
                unlink("../../images/bank/" . $pimage);
            }
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Bank', '3', 'Delete', $_SESSION['UID'], $ip, $c));

            $get = $db->prepare("DELETE FROM `bank` WHERE `BankID` =? ");
            $get->execute(array($c));
        }else{
            $err_del[] = $c;
        }
    }
    if(!empty($err_del)){
        foreach($err_del as $ers){
           $des .= getbank('Bank_Name',$ers).', ';
        }
        $des = 'Unable to Delete. '.substr($des,0,-2);
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> '.$des.'. Bank(s) have transactions</h4></div>';
    }else{
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    }
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

?>