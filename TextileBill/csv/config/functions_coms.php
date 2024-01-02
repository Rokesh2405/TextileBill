<?php
function LoginCheck($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if (($a == '') || ($b == '')) {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i>Email or Password was empty</div>';
    } else {
        if ($e == '') {
            $stmt = $db->prepare("SELECT * FROM `users` WHERE `val1`=? AND `val3`=?");
            $stmt->execute(array($a, 1));
            $ress = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($ress['id'] != '') {
                if ($ress['val2'] == md5($b)) {
                    $res = "Hurray! You will redirect into dashboard soon";
                    $_SESSION['UID'] = $ress['id'];
                    $_SESSION['type'] = 'admin';
                    @extract($ress);
                    if ($id != '') {
                        $e = date('Y-m-d H:i:s');
                        $sql = 'INSERT INTO `admin_history`(admin_uid,ip,checkintime) VALUES(?,?,?)';
                        $stmt1 = $db->prepare($sql);
                        $stmt1->execute(array($id, $c, $e));
                        $_SESSION['admhistoryid'] = $db->lastInsertId();
                        if ($d == '1') {
                            //if rememberme checkbox checked
                            setcookie('lemail', $a, time() + (60 * 60 * 24 * 10)); //Means 10 days change value of 10 to how many days as you want to remember the user details on user's computer
                            setcookie('lpass', $b, time() + (60 * 60 * 24 * 10)); //Here two coockies created with username and password as cookie names, $username,$password (login crediantials) as corresponding values
                        }
                    }
                } elseif ($ress['val3'] == '2') {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Your Account was deactivated by Admin</div>';
                } else {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Email or Password was incorrect</div>';
                }
            } else {
                //$sql = DB_QUERY("SELECT * FROM `usermaster` WHERE `username`='" . $a . "'");
                $stmt2 = $db->prepare("SELECT * FROM `usermaster` WHERE `username`=?");
                $stmt2->execute(array($a));
                $sql = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($sql['uid'] != '') {
                    // $per = DB_QUERY("SELECT `pid`,`status` FROM `permission` WHERE `pid`='" . $sql['permissiongroup'] . "'");
                    $stmt3 = $db->prepare("SELECT * FROM `permission` WHERE `pid`=?");
                    $stmt3->execute(array($sql['permissiongroup']));
                    $per = $stmt3->fetch(PDO::FETCH_ASSOC);
                    if ($per['status'] == '1') {
                        if (($a == $sql['username']) && ($b == $sql['password'])) {
                            $_SESSION['UID'] = $sql['uid'];
                            $_SESSION['UIDD'] = $sql['userid'];
                            $_SESSION['permissionid'] = $sql['permissiongroup'];
                            $res = "User";
                        }
                    } else {
                        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i>Access denied !</div>';
                    }
                } else {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Invalid login details!</div>';
                }
            }
            return $res;
        }
    }
}
function logout()
{
    global $db;
    $sql = $db->prepare("UPDATE `admin_history` SET `checkouttime`='" . date('Y-m-d H:i:s') . "' WHERE `id`=?");
    $sql->execute(array($_SESSION['admhistoryid']));
    // DB("UPDATE `admin_history` SET `checkouttime`='" . date('Y-m-d H:i:s') . "' WHERE `id`='" . $_SESSION['admhistoryid'] . "'");
}
function companylogin($a)
{
    /* $getlogo = mysql_fetch_array(mysql_query("SELECT * FROM `profile_area` WHERE `pid`='" . $_SESSION['UID'] . "'"));
    $res = $getlogo[$a];
    return $res; */
    /* global $db;
$get1 =$db->prepare("SELECT * FROM `profile_area` WHERE `pid`=?");
$get1->execute(array($_SESSION['UID']));
$get=$get1->fetch(PDO::FETCH_ASSOC);
$res = $get[$a];
return $res; */
}
function companylogos($a)
{
    //$getlogo = mysql_fetch_array(mysql_query("SELECT `image` FROM `profile_area` WHERE `pid`='" . $a . "'"));
    global $db;
    $getlogo1 = $db->prepare("SELECT `image` FROM `profile_area` WHERE `pid`=?");
    $getlogo1->execute(array($a));
    $getlogo = $getlogo1->fetch(PDO::FETCH_ASSOC);
    if ($getlogo['image'] != '') {
        $res = $getlogo['image'];
    } else {
        $res = $sitename . 'data/profile/logo.png';
    }
    return $res;
}
function addprofile($z, $a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k)
{
    global $db;
    if ($_SESSION['UID'] != '') {
        //$ress = DB_QUERY("SELECT `pid` FROM `manageprofile` WHERE `uid`='" . $_SESSION['UID'] . "'");
        $ress1 = $db->prepare("SELECT `pid` FROM `manageprofile` WHERE `uid`=?");
        $ress1->execute(array($_SESSION['UID']));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['pid'] == '') {
            //$resa = mysql_query("INSERT INTO `manageprofile` (`title`,`recoveryemail`,`phonenumber`,`senderid`,`password`,`securityanswer2`,`image`,`firstname`,`uid`,`lastname`,`onlinestatus`,`ip`) VALUES ('" . $z . "','" . $a . "','" . $b . "','" . $c . "','" . $d . "','" . $e . "','" . $f . "','" . $g . "','" . $h . "','" . $i . "','" . $j . "','" . $k . "')");
            $resa = $db->prepare("INSERT INTO `manageprofile` (`title`,`recoveryemail`,`phonenumber`,`senderid`,`password`,`securityanswer2`,`image`,`firstname`,`uid`,`lastname`,`onlinestatus`,`ip`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($z, $a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4><!--<a href="' . $sitename . 'settings/addunitmeasurementmaster.htm">Add another one</a>--></div>';
        } else {
            // $resa = mysql_query("UPDATE `manageprofile` SET `title`='" . $z . "',`recoveryemail`='" . $a . "',`phonenumber`='" . $b . "',`senderid`='" . $c . "',`password`='" . $d . "',`securityanswer2`='" . $e . "',`image`='" . $f . "',`firstname`='" . $g . "',`uid`='" . $h . "',`lastname`='" . $i . "',`onlinestatus`='" . $j . "',`ip`='" . $k . "' WHERE `uid`='" . $_SESSION['UID'] . "'");
            $resa = $db->prepare("UPDATE `manageprofile` SET `title`=?,`recoveryemail`=?,`phonenumber`=?,`senderid`=?,`password`=?,`securityanswer2`=?,`image`=?,`firstname`=?,`uid`=?,`lastname`=?,`onlinestatus`=?,`ip`=? WHERE `uid`=?");
            $resa->execute(array($z, $a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $_SESSION['UID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
        }
    }
    return $res;
}
function getprofile($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `manageprofile` WHERE `pid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
//    $get = mysql_fetch_array(mysql_query("SELECT * FROM `manageprofile` WHERE `pid`='$b'"));
    //    $res = $get[$a];
    //    return $res;
}
function companylogo($a)
{
    /* global $db;
$getlogo1 = $db->prepare("SELECT `logo` FROM `settings` WHERE `cus_id`=?");
$getlogo1->execute(array($a));
$getlogo=$getlogo1->fetch(PDO::FETCH_ASSOC);
if ($getlogo['logo'] != '') {
$res = WEB_ROOT . 'pages/master/images/' . $getlogo['logo'];
} else {
$res = WEB_ROOT . 'data/profile/logo.png';
}
return $res;
 */
}
/* Department Section Start */
function adddepartment($a = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `did` FROM `department` WHERE `department`=? AND `status`!=?");
        $ress1->execute(array(strtolower(trim($a)), 2));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['did'] == '') {
            $resa = $db->prepare("INSERT INTO `department` (`department`,`order`,`status`,`ip`,`updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array(strtolower(trim($a)), 0, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Department', 27, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Department</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `did` FROM `department` WHERE `department`=? AND `status`!=? AND `did`!=?");
        $ress1->execute(array(strtolower(trim($a)), 2, $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['did'] == '') {
            $resa = $db->prepare("UPDATE `department` SET `department`=?,`order`=?,`status`=?,`ip`=?,`updated_by`=? WHERE `did`=?");
            $resa->execute(array(strtolower(trim($a)), 0, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Department', 27, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Department</h4></div>';
        }
    }
    return $res;
}
function getdepartment($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `department` WHERE `did`=? AND `status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function deldepartment($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Department', 1, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `department` WHERE `did` =? ");
        $get->execute(array($c));
        //$htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Department','1','Delete','" . $_SESSION['UID'] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $c . "')");
        // $get = mysql_query("DELETE FROM `department` WHERE `did` ='" . $c . "' ");
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Department Section End */
/* Supplier Group Start */
function addsupplier_group($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `SgID` FROM `supplier_group` WHERE `SupplierGroup`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SgID'] == '') {
            $resa = $db->prepare("INSERT INTO `supplier_group` (`SupplierGroup`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Supplier Group', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Supplier Group</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `SgID` FROM `supplier_group` WHERE `SupplierGroup`=? AND `SgID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SgID'] == '') {
            $resa = $db->prepare("UPDATE `supplier_group` SET `SupplierGroup`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `SgID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Supplier Group', 2, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Supplier Group</h4></div>';
        }
    }
    return $res;
}
function getsupplier_group($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `supplier_group` WHERE `SgID`=? AND `status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delsuppliergroup($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Supplier Group', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `supplier_group` WHERE `SgID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Supplier Group Ends */
/* Supplier Start */
function addsupplier($a = '', $b = '', $c = '', $d = '', $e = '', $f = '', $g = '', $h = '', $i = '', $j = '', $k = '')
{
    global $db;
    if ($k == '') {
        $ress1 = $db->prepare("SELECT `SupID` FROM `supplier` WHERE `Supplier_name`=? AND `SgID`=?");
        $ress1->execute(array(strtolower(trim($b)), $a));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SupID'] == '') {
            $resa = $db->prepare("INSERT INTO `supplier` (`SgID`,`Supplier_name`,`Contact_person`,`Contact_Number`,`Contact_email`,`Description`,`Image`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Supplier', 3, 'Insert', $_SESSION['UID'], $j, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Supplier</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `SupID` FROM `supplier` WHERE `Supplier_name`=? AND `SgID`=? AND `SupID`!=?");
        $ress1->execute(array($b, $a, $k));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SupID'] == '') {
            $resa = $db->prepare("UPDATE `supplier` SET `SgID`=?,`Supplier_name`=?,`Contact_person`=?,`Contact_Number`=?,`Contact_email`=?,`Description`=?,`Image`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `SupID`=?");
            $resa->execute(array($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $_SESSION['UID'], $k));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Supplier', 3, 'Update', $_SESSION['UID'], $j, $k));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Supplier</h4></div>';
        }
        //$res="UPDATE `supplier` SET `SgID`=$a,`Supplier_name`=$b,`Contact_person`=$c,`Contact_Number`=$d,`Contact_email`=$e,`Description`=$f,`Image`=$g,`Order`=$h,`Status`=$i,`IP`=$j,`Updated_by`='".$_SESSION['uid']."' WHERE `SupID`=$k";
    }
    return $res;
}
function getsupplier($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `supplier` WHERE `SupID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delsupplier($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $image = explode(",", getsupplier('image', $a));
        foreach ($image as $images) {
            if ($images != '') {
                unlink("../images/supplier/big/" . $images);
                unlink("../images/supplier/thumb/" . $images);
            }
        }
        $htry->execute(array('Supplier', 3, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `supplier` WHERE `SupID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Supplier Group Ends */
/* Item Group Start */
function additem_group($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `ItemID` FROM `item_group` WHERE `ItemGroup`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("INSERT INTO `item_group` (`ItemGroup`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Item Group', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Group</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `ItemID` FROM `item_group` WHERE `ItemGroup`=? AND `ItemID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("UPDATE `item_group` SET `ItemGroup`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `ItemID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Item Group', 2, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Group</h4></div>';
        }
    }
    return $res;
}
function getitem_group($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `item_group` WHERE `ItemID`=? AND `status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delitemgroup($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Item Group', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `item_group` WHERE `ItemID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Item Group Ends */
/* Item Type Start */
function additem_type($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `ItemID` FROM `item_type` WHERE `ItemType`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("INSERT INTO `item_type` (`ItemType`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Item Type', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Type</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `ItemID` FROM `item_type` WHERE `ItemType`=? AND `ItemID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("UPDATE `item_type` SET `ItemType`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `ItemID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Item Type', 2, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Type</h4></div>';
        }
    }
    return $res;
}
function getitem_type($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `item_type` WHERE `ItemID`=? AND `status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delitemtype($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Item Group', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `item_type` WHERE `ItemID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Item Type Ends */
/* Manufacturer Start */
function addmanufacturer($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `MID` FROM `manufacturer` WHERE `Manufacturer`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MID'] == '') {
            $resa = $db->prepare("INSERT INTO `manufacturer` (`Manufacturer`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Manufacurer', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Manufacturer</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `MID` FROM `manufacturer` WHERE `Manufacturer`=? AND `MID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MID'] == '') {
            $resa = $db->prepare("UPDATE `manufacturer` SET `Manufacturer`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `MID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Manufacturer', 2, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this manufacturer</h4></div>';
        }
    }
    return $res;
}
function getmanufacturer($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `manufacturer` WHERE `MID`=? AND `Status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delmanufacturer($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Manufacturer', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `manufacturer` WHERE `MID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Manufacturer Ends */
/* Shipping Type Start */
function addshipping_type($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `ShipID` FROM `shipping_type` WHERE `ShippingType`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ShipID'] == '') {
            $resa = $db->prepare("INSERT INTO `shipping_type` (`ShippingType`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Shipping Type', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Shipping Type</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `ShipID` FROM `shipping_type` WHERE `ShippingType`=? AND `ItemID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("UPDATE `shipping_type` SET `ShippingType`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `ItemID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Shipping Type', 2, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Shipping Type</h4></div>';
        }
    }
    return $res;
}
function getshipping_type($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `shipping_type` WHERE `ShipID`=? AND `status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delshippingtype($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Shipping Group', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `shipping_type` WHERE `ShipID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Shipping Type Ends */
/* Warehouse Start */
function addwarehouse($a = '', $b = '', $c = '', $d = '', $e = '', $f = '', $g = '')
{
    global $db;
    if ($g == '') {
        $ress1 = $db->prepare("SELECT `WhID` FROM `warehouse` WHERE `Warehouse_Code`=?");
        $ress1->execute(array(strtolower(trim($b))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['WhID'] == '') {
            $resa = $db->prepare("INSERT INTO `warehouse` (`Warehouse_Name`,`Warehouse_Code`,`Description`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($a, $b, $c, $d, $e, $f, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Warehouse', 10, 'Insert', $_SESSION['UID'], $f, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Warehouse Code Exist</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `WhID` FROM `warehouse` WHERE `Warehouse_Code`=? AND `WhID`!=?");
        $ress1->execute(array($b, $g));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['WhID'] == '') {
            $resa = $db->prepare("UPDATE `warehouse` SET `Warehouse_Name`=?,`Warehouse_Code`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `WhID`=?");
            $resa->execute(array($a, $b, $c, $d, $e, $f, $_SESSION['UID'], $g));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Warehouse', 10, 'Update', $_SESSION['UID'], $f, $g));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Warehouse Code Exist</h4></div>';
        }
    }
    return $res;
}
function getwarehouse($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `warehouse` WHERE `WhID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delwarehouse($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Warehouse', 10, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `warehouse` WHERE `WhID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Warehouse End */
/* Partner Type Start */
function addpartnertype($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `Partner_id` FROM `partner_type` WHERE `Partner_type`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['Partner_id'] == '') {
            $resa = $db->prepare("INSERT INTO `partner_type` (`Partner_type`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array($a, $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Partner Type', 13, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Partner Type already Exist</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `Partner_id` FROM `partner_type` WHERE `Partner_type`=? AND `Partner_id`!=?");
        $ress1->execute(array($a, $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['PID'] == '') {
            $resa = $db->prepare("UPDATE `partner_type` SET `Partner_type`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `Partner_id`=?");
            $resa->execute(array($a, $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Partner Type', 13, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Partner Type already Exist</h4></div>';
        }
    }
    return $res;
}
function getpartnertype($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `partner_type` WHERE `Partner_id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delpartnertype($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Partner Type', 13, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `partner_type` WHERE `Partner_id` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Partner Type End */
/* Language Start */
function addlanguage($a = '', $b = '', $c = '', $d = '', $e = '', $f = '')
{
    global $db;
    if ($f == '') {
        $ress1 = $db->prepare("SELECT `Language_id` FROM `language` WHERE `Language`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['Language_id'] == '') {
            $resa = $db->prepare("INSERT INTO `language` (`Language`,`language_code`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array($a, $b, $c, $d, $e, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('language', 13, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Language already Exist</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `Language_id` FROM `language` WHERE `Language`=? AND `Language_id`!=?");
        $ress1->execute(array($a, $f));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['Language_id'] == '') {
            $resa = $db->prepare("UPDATE `language` SET `Language`=?, `language_code`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `Language_id`=?");
            $resa->execute(array($a, $b, $c, $d, $e, $_SESSION['UID'], $f));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Language', 13, 'Update', $_SESSION['UID'], $e, $f));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Language already Exist</h4></div>';
        }
    }
    return $res;
}
function getlanguage($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `language` WHERE `Language_id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function dellanguage($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Language', 14, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `language` WHERE `Language_id` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Language End */
/* Properties Start */
function addproperties($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `PID` FROM `properties` WHERE `Property`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['PID'] == '') {
            $resa = $db->prepare("INSERT INTO `properties` (`Property`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array($a, $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('properties', 11, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Property already Exist</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `PID` FROM `properties` WHERE `Property`=? AND `PID`!=?");
        $ress1->execute(array($a, $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['PID'] == '') {
            $resa = $db->prepare("UPDATE `properties` SET `Property`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `PID`=?");
            $resa->execute(array($a, $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('properties', 11, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Property already Exist</h4></div>';
        }
    }
    return $res;
}
function getproperties($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `properties` WHERE `PID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delproperties($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('properties', 11, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `properties` WHERE `PID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Properties End */
/* Industry Start */
function addindustry($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `InID` FROM `industry` WHERE `Industry`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['InID'] == '') {
            $resa = $db->prepare("INSERT INTO `industry` (`Industry`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Industry', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Industry</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `InID` FROM `industry` WHERE `Industry`=? AND `InID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['InD'] == '') {
            $resa = $db->prepare("UPDATE `industry` SET `Industry`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `InID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Industry', 2, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Industry</h4></div>';
        }
    }
    return $res;
}
function getindustry($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `industry` WHERE `InID`=? AND `Status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delindustry($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Industry', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `industry` WHERE `InID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Industry Ends */
/* Payment Terms Start */
function addpaymentterm($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `PID` FROM `payment_term` WHERE `PaymentTerm`=?");
        $ress1->execute(array(strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['InID'] == '') {
            $resa = $db->prepare("INSERT INTO `payment_term` (`PaymentTerm`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('PaymentTerm', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Payment Term</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `PID` FROM `payment_term` WHERE `PaymentTerm`=? AND `PID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['PID'] == '') {
            $resa = $db->prepare("UPDATE `payment_term` SET `PaymentTerm`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `PID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('PaymentTerm', 2, 'Update', $_SESSION['UID'], $d, $e));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Payment Term</h4></div>';
        }
    }
    return $res;
}
function getpaymentterm($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `payment_term` WHERE `PID`=? AND `Status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delpaymentterm($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('PaymentTerm', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `payment_term` WHERE `PID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Payment Terms Ends */
/* Currency Start */
function addcurrency($a = '', $b = '', $c = '', $d = '', $e = '', $f = '', $g = '')
{
    global $db;
    if ($g == '') {
        $ress1 = $db->prepare("SELECT `CID` FROM `currency` WHERE `Currency_Name`=?");
        $ress1->execute(array(strtolower(trim($b))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CID'] == '') {
            $resa = $db->prepare("INSERT INTO `currency` (`Currency_Name`,`Currency_Code`,`Currency_Icon`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($a, $b, $c, $d, $e, $f, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('currency', 10, 'Insert', $_SESSION['UID'], $f, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Currency Already Exist</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `CID` FROM `currency` WHERE `Currency_Name`=? AND `CID`!=?");
        $ress1->execute(array($b, $g));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CID'] == '') {
            $resa = $db->prepare("UPDATE `currency` SET `Currency_Name`=?,`Currency_Code`=?,`Currency_Icon`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `CID`=?");
            $resa->execute(array($a, $b, $c, $d, $e, $f, $_SESSION['UID'], $g));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('currency', 10, 'Update', $_SESSION['UID'], $f, $g));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Currency Already Exist</h4></div>';
        }
    }
    return $res;
}
function getcurrency($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `currency` WHERE `CID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delcurrency($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('currency', 10, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `currency` WHERE `CID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* currency end */
/* Channel Start Here */
function addchannel($channel_name, $ch_code, $description, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `ChID` FROM `channel` WHERE `Channel_code`=? ");
        $ress1->execute(array($ch_code));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ChID'] == '') {
            $resa = $db->prepare("INSERT INTO `channel` (`Channel_code`,`Channel_Name`,`Description`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($ch_code, $channel_name, $description, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Channel', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Channel Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `ChID` FROM `channel` WHERE `Channel_code`=? AND `ChID`!=?");
        $ress1->execute(array($ch_code, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ChID'] == '') {
            $resa = $db->prepare("UPDATE `channel` SET `Channel_code`=?,`Channel_Name`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `ChID`=? ");
            $resa->execute(array($ch_code, $channel_name, $description, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('channel', 3, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this channel Code</h4></div>';
        }
    }
    return $res;
}
function getchannel($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `channel` WHERE `ChID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delchannel($a)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Channel', 3, 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `channel` WHERE `ChID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Channel end */
/* Employee Group Start Here */
function addemplpyeegroup($group_name, $group_code, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `GrID` FROM `employee_group` WHERE `Group_Code`=?");
        $ress1->execute(array($group_code));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['GrID'] == '') {
            $resa = $db->prepare("INSERT INTO `employee_group` (`Group_Name`,`Group_Code`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array($group_name, $group_code, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Employee Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Employee Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `GrID` FROM `employee_group` WHERE `Group_Code`=? AND `GrID`!=?");
        $ress1->execute(array($group_code, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['GrID'] == '') {
            $resa = $db->prepare("UPDATE `employee_group` SET `Group_Name`=?,`Group_Code`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `GrID`=? ");
            $resa->execute(array($group_name, $group_code, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Employee Group', 3, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Employee Code</h4></div>';
        }
    }
    return $res;
}
function getempgroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `employee_group` WHERE `GrID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delemplpyeegroup($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Employee Group', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `employee_group` WHERE `GrID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Employee Group end Here */
/* Employee Start Here */
function addemployee($empname, $empcode, $enroll, $title, $first_name, $middle_name, $last_name, $dobdate, $gender, $designation, $department, $hiredon, $terminate, $terminatereason, $image, $address, $country, $state, $city, $area, $postal, $address1, $country1, $state1, $city1, $area1, $postal1, $phone, $mobile, $emailid, $website, $description, $workshift, $salaryfre, $emptype, $isdailywages, $grossamount, $grosspercetage, $basicsalary, $mrppackprice, $maxleaveallowed, $overtimerate, $maxexpenalloed, $salaryaccthead, $casleavealloed, $ourbank, $bankacctname, $bankacctnumber, $bankaccttype, $micrcode, $ifsccode, $incenttivepln, $conemail, $conpassword, $conserver, $conport, $enableserver, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `EmpID` FROM `employee` WHERE `EmpCode`=?");
        $ress1->execute(array($empcode));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['EmpID'] == '') {

            $resa = $db->prepare("INSERT INTO `employee` (`EmpName`, `EmpCode`, `Enrollno`, `Title`, `First_Name`, `Middle_Name`, `Last_Name`, `DoB`, `Gender`, `Designation`, `Department`, `Hired_On`, `Terminate_On`, `Reson_Terminat`, `Image`, `Address_1`, `Country_1`, `State_1`, `City_1`, `Area_1`, `Postal_Code_1`, `Address_2`, `Country_2`, `State_2`, `City_2`, `Area_2`, `Postal_Code_2`, `Phone_Number`, `Mobile_Number`, `E-Mail`, `Website`, `Description`, `Work_Shift`, `Salary_Frequent`, `Employee_Type`, `IsDailyWages`, `GrossAmount`, `Gross_Percentage`, `Basic_Salary`, `Max_Over_Allowed`, `Max_Leve_Allowed`, `OverTime_Rate`, `Max_Expe_Allowed`, `Salary_Accu_Head`, `Cas_Leve_Allowed`, `Our_bank_Name`, `Bank_Account_Name`, `Bank_Account_Num`, `Bank_Account_Type`, `MICR_Code`, `IFSC_Code`, `Incentive_Plan`, `E-mail-Config`, `Password`, `Server`, `Port`, `Enable_server`,`Order`, `Status`, `IP`, `Updated_by` ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($empname, $empcode, $enroll, $title, $first_name, $middle_name, $last_name, $dobdate, $gender, $designation, $department, $hiredon, $terminate, $terminatereason, $image, $address, $country, $state, $city, $area, $postal, $address1, $country1, $state1, $city1, $area1, $postal1, $phone, $mobile, $emailid, $website, $description, $workshift, $salaryfre, $emptype, $isdailywages, $grossamount, $grosspercetage, $basicsalary, $mrppackprice, $maxleaveallowed, $overtimerate, $maxexpenalloed, $salaryaccthead, $casleavealloed, $ourbank, $bankacctname, $bankacctnumber, $bankaccttype, $micrcode, $ifsccode, $incenttivepln, $conemail, $conpassword, $conserver, $conport, $enableserver, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Employee', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Employee Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `EmpID` FROM `employee` WHERE `EmpCode`=? AND `EmpID`!=?");
        $ress1->execute(array($empcode, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['EmpID'] == '') {
            $resa = $db->prepare("UPDATE `employee` SET `EmpName`=?, `EmpCode`=?, `Enrollno`=?, `Title`=?, `First_Name`=?, `Middle_Name`=?, `Last_Name`=?, `DoB`=?, `Gender`=?, `Designation`=?, `Department`=?, `Hired_On`=?, `Terminate_On`=?, `Reson_Terminat`=?, `Image`=?, `Address_1`=?, `Country_1`=?, `State_1`=?, `City_1`=?, `Area_1`=?, `Postal_Code_1`=?, `Address_2`=?, `Country_2`=?, `State_2`=?, `City_2`=?, `Area_2`=?, `Postal_Code_2`=?, `Phone_Number`=?, `Mobile_Number`=?, `E-Mail`=?, `Website`=?, `Description`=?, `Work_Shift`=?, `Salary_Frequent`=?, `Employee_Type`=?, `IsDailyWages`=?, `GrossAmount`=?, `Gross_Percentage`=?, `Basic_Salary`=?, `Max_Over_Allowed`=?, `Max_Leve_Allowed`=?, `OverTime_Rate`=?, `Max_Expe_Allowed`=?, `Salary_Accu_Head`=?, `Cas_Leve_Allowed`=?, `Our_bank_Name`=?, `Bank_Account_Name`=?, `Bank_Account_Num`=?, `Bank_Account_Type`=?, `MICR_Code`=?, `IFSC_Code`=?, `Incentive_Plan`=?, `E-mail-Config`=?, `Password`=?, `Server`=?, `Port`=?, `Enable_server`=?,`Order`=?, `Status`=?, `IP`=?, `Updated_by`=? WHERE `EmpID`=? ");
            $resa->execute(array($empname, $empcode, $enroll, $title, $first_name, $middle_name, $last_name, $dobdate, $gender, $designation, $department, $hiredon, $terminate, $terminatereason, $image, $address, $country, $state, $city, $area, $postal, $address1, $country1, $state1, $city1, $area1, $postal1, $phone, $mobile, $emailid, $website, $description, $workshift, $salaryfre, $emptype, $isdailywages, $grossamount, $grosspercetage, $basicsalary, $mrppackprice, $maxleaveallowed, $overtimerate, $maxexpenalloed, $salaryaccthead, $casleavealloed, $ourbank, $bankacctname, $bankacctnumber, $bankaccttype, $micrcode, $ifsccode, $incenttivepln, $conemail, $conpassword, $conserver, $conport, $enableserver, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Employee', 3, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Employee Code</h4></div>';
        }
    }
    return $res;
}
function getemployee($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `employee` WHERE `EmpID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delemployee($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $pimage = getbank('Image', $c);
        if ($pimage != '') {
            unlink("../../images/employee/" . $pimage);
        }
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Employee', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `employee` WHERE `EmpID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Employee end Here */
/* Brand Start Here */
function addbrand($menuf, $brand_name, $brand_code, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `BrID` FROM `brand` WHERE `Brand_Code`=?");
        $ress1->execute(array($brand_code));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['BrID'] == '') {
            $resa = $db->prepare("INSERT INTO `brand` (`Manufacturer`,`Brand_Name`,`Brand_Code`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($menuf, $brand_name, $brand_code, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Brand', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `BrID` FROM `brand` WHERE `Brand_Code`=? AND `BrID`!=?");
        $ress1->execute(array($brand_code, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['BrID'] == '') {
            $resa = $db->prepare("UPDATE `brand` SET `Manufacturer`=?,`Brand_Name`=?,`Brand_Code`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `BrID`=? ");
            $resa->execute(array($menuf, $brand_name, $brand_code, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Brand', 3, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        }
    }
    return $res;
}
function getbrand($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `brand` WHERE `BrID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delbrand($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Brand', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `brand` WHERE `BrID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Brand end Here */
/* Sub Group Start Here */
function addsubgroup($group_name, $subgroup, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
//        $ress1 = $db->prepare("SELECT `ItSubID` FROM `itemsubgroup` WHERE `ItemSub`=?");
        //        $ress1->execute(array($brand_code));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //        if ($ress['ItSubID'] == '') {
        $resa = $db->prepare("INSERT INTO `itemsubgroup` (`ItemGroup`,`ItemSub`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?)");
        $resa->execute(array($group_name, $subgroup, $order, $status, $ip, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Sub Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    } else {
//        $ress1 = $db->prepare("SELECT `ItSubID` FROM `itemsubgroup` WHERE `ItemSub`=? AND `ItSubID`!=?");
        //        $ress1->execute(array($brand_code, $id));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //
        //        if ($ress['ItSubID'] == '') {
        $resa = $db->prepare("UPDATE `itemsubgroup` SET `ItemGroup`=?,`ItemSub`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `ItSubID`=? ");
        $resa->execute(array($group_name, $subgroup, $order, $status, $ip, $_SESSION['UID'], $id));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Sub Group', 3, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    }
    return $res;
}
function getsubgroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `itemsubgroup` WHERE `ItSubID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delsubgroup($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Sub Group', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `itemsubgroup` WHERE `ItSubID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Sub Group end Here */
/* Inner Group Start Here */
function addinnergroup($group_name, $subgroup, $innergroup, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        //       $ress1 = $db->prepare("SELECT `ItinnerID` FROM `iteminnergroup` WHERE `InnerGroup`=?");
        //        $ress1->execute(array($brand_code));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //        if ($ress['ItinnerID'] == '') {
        $resa = $db->prepare("INSERT INTO `iteminnergroup` (`Group`,`SubGroup`,`InnerGroup`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?)");
        $resa->execute(array($group_name, $subgroup, $innergroup, $order, $status, $ip, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Inner Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
//        } else {
        ///          $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    } else {
        //      $ress1 = $db->prepare("SELECT `ItinnerID` FROM `iteminnergroup` WHERE `InnerGroup`=? AND `ItinnerID`!=?");
        //    $ress1->execute(array($brand_code, $id));
        //    $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //        if ($ress['ItinnerID'] == '') {
        $resa = $db->prepare("UPDATE `iteminnergroup` SET `Group`=?,`SubGroup`=?,`InnerGroup`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `ItinnerID`=? ");
        $resa->execute(array($group_name, $subgroup, $innergroup, $order, $status, $ip, $_SESSION['UID'], $id));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Inner Group', 3, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
//        } else {
        //         $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    }
    return $res;
}
function getinnergroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `iteminnergroup` WHERE `ItinnerID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delinnergroup($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Inner Group', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `iteminnergroup` WHERE `ItinnerID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Inner Group end Here */
/* UOM Start Here */
function adduom($name, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `UomID` FROM `uom` WHERE `Name`=?");
        $ress1->execute(array($name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['UomID'] == '') {
            $resa = $db->prepare("INSERT INTO `uom` (`Name`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array($name, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('UOM', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this UOM Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `UomID` FROM `uom` WHERE `Name`=? AND `UomID`!=?");
        $ress1->execute(array($name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['UomID'] == '') {
            $resa = $db->prepare("UPDATE `uom` SET `Name`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `UomID`=? ");
            $resa->execute(array($name, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('UOM', 3, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this UOM Code</h4></div>';
        }
    }
    return $res;
}
function getuom($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `uom` WHERE `UomID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function deluom($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('UOM', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `uom` WHERE `UomID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* UOM end Here */
/* Margin Start Here */
function addmargin($name, $margincode, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `MaID` FROM `margin` WHERE `Code`=?");
        $ress1->execute(array($margincode));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MaID'] == '') {
            $resa = $db->prepare("INSERT INTO `margin` (`Name`,`Code`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array($name, $margincode, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Margin', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Margin Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `MaID` FROM `margin` WHERE `Code`=? AND `MaID`!=?");
        $ress1->execute(array($margincode, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MaID'] == '') {
            $resa = $db->prepare("UPDATE `margin` SET `Name`=?,`Code`=?, `Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `MaID`=? ");
            $resa->execute(array($name, $margincode, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Margin', 3, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Margin Code</h4></div>';
        }
    }
    return $res;
}
function getmargin($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `margin` WHERE `MaID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delmargin($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Margin', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `margin` WHERE `MaID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Margin end Here  */
/* Customer Group Start Here */
function addcusgroup($name, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `CuGID` FROM `customergroup` WHERE `Group_Name`=?");
        $ress1->execute(array($name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CuGID'] == '') {
            $resa = $db->prepare("INSERT INTO `customergroup` (`Group_Name`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array($name, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Customer Group Name</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `CuGID` FROM `customergroup` WHERE `Group_Name`=? AND `CuGID`!=?");
        $ress1->execute(array($name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CusID'] == '') {
            $resa = $db->prepare("UPDATE `customergroup` SET `Group_Name`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `CuGID`=? ");
            $resa->execute(array($name, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Cutomer Group', 3, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Customer Group Name</h4></div>';
        }
    }
    return $res;
}
function getcusgroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `customergroup` WHERE `CuGID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delcusgroup($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer Group', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `customergroup` WHERE `CuGID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Customer Group end Here */
/* Customer Group Start Here */
function addbank($bankname, $bankcode, $branchname, $ifsccode, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `BankID` FROM `bank` WHERE `Bank_Code`=?");
        $ress1->execute(array($name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['BankID'] == '') {
            //(`BankID`, `Bank_Name`, `Bank_Code`, `Branch_Name`, `IFSC_Code`, `Address`, `Country`, `State`, `City`, `Area`, `Postal_Code`, `Order`, `Status`, `IP`, `Updated_by`, `Updated_type`, `date`)
            $resa = $db->prepare("INSERT INTO `bank` (`Bank_Name`, `Bank_Code`, `Branch_Name`, `IFSC_Code`, `Address`, `Country`, `State`, `City`, `Area`, `Postal_Code`, `Image`,`Order`, `Status`, `IP`, `Updated_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($bankname, $bankcode, $branchname, $ifsccode, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
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

            $resa = $db->prepare("UPDATE `bank` SET `Bank_Name`=?, `Bank_Code`=?, `Branch_Name`=?, `IFSC_Code`=?, `Address`=?, `Country`=?, `State`=?, `City`=?, `Area`=?, `Postal_Code`=?,`Image`=?, `Order`=?, `Status`=?, `IP`=?, `Updated_by`=? WHERE `BankID`=? ");
            $resa->execute(array($bankname, $bankcode, $branchname, $ifsccode, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $_SESSION['UID'], $id));

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Bank', 3, 'Update', $_SESSION['UID'], $ip, $id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Bank Code</h4></div>';
        }
    }
    return $res;
}
function getbank($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `bank` WHERE `BankID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delbank($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $pimage = getbank('Image', $c);
        if ($pimage != '') {
            unlink("../../images/bank/" . $pimage);
        }
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Bank', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `bank` WHERE `BankID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Customer Group end Here */
/* Customer Group Start Here */
function addcustomer($employee, $customer_company, $cont_person, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $margin, $referen, $group_name, $img, $description, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `CusID` FROM `customer` WHERE `Company`=?");
        $ress1->execute(array($customer_company));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CusID'] == '') {

            $resa = $db->prepare("INSERT INTO `customer` ( `Employee`,`Company`, `Person`, `Adderss_1`, `Address_2`, `State`, `City`, `Postcode`, `Country`, `E-mail`, `Website`, `Mobile`, `Phone`, `GSTNum`, `Credit`, `Creditdate`,`Margin`, `Reference`, `CustomerGroup`, `Image`, `Description`, `Status`, `IP`, `Updated_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($employee, $customer_company, $cont_person, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $margin, $referen, $group_name, $img, $description, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Customer', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Customer Group Name</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `CusID` FROM `customer` WHERE `Company`=? AND `CusID`!=?");
        $ress1->execute(array($customer_company, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CusID'] == '') {
            $resa = $db->prepare("UPDATE `customer` SET `Employee`=?,`Company`=?, `Person`=?, `Adderss_1`=?, `Address_2`=?, `State`=?, `City`=?, `Postcode`=?, `Country`=?, `E-mail`=?, `Website`=?, `Mobile`=?, `Phone`=?, `GSTNum`=?, `Credit`=?, `Creditdate`=?,`Margin`=?,`Reference`=?, `CustomerGroup`=?, `Image`=?, `Description`=?, `Status`=?, `IP`=?, `Updated_by`=? WHERE `CusID`=? ");
            $resa->execute(array($employee, $customer_company, $cont_person, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $margin, $referen, $group_name, $img, $description, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Cutomer', 3, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Customer Group Name</h4></div>';
        }
    }
    return $res;
}
function getcustomer($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `customer` WHERE `CusID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delcustomer($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Customer', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `customer` WHERE `CusID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Customer  end Here */
/* Holiday GroupStart Here */
function addholidaygroup($holiday_name, $holiday_code, $description, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
//        $ress1 = $db->prepare("SELECT `HoliID` FROM `holiday_group` WHERE `holiday_Code`=?");
        //        $ress1->execute(array($holiday_code));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //        if ($ress['HoliID'] == '') {
        $resa = $db->prepare("INSERT INTO `holiday_group` (`holiday_Name`,`holiday_Code`,`Description`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?)");
        $resa->execute(array($holiday_name, $holiday_code, $description, $order, $status, $ip, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Holiday Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    } else {
//        $ress1 = $db->prepare("SELECT `HoliID` FROM `holiday_group` WHERE `holiday_Code`=? AND `HoliID`!=?");
        //        $ress1->execute(array($holiday_code, $id));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //
        //        if ($ress['HoliID'] == '') {
        $resa = $db->prepare("UPDATE `holiday_group` SET `holiday_Name`=?,`holiday_Code`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `HoliID`=? ");
        $resa->execute(array($holiday_name, $holiday_code, $description, $order, $status, $ip, $_SESSION['UID'], $id));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Holiday Group', 3, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    }
    return $res;
}
function getholidaygroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `holiday_group` WHERE `HoliID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delholidaygroup($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Holiday Group', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `holiday_group` WHERE `HoliID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Holiday Group  end Here */
/*  Salary Frequent Start Here */
function addsalaryfrequent($frequent_name, $frequent_salary, $salary_period_start, $salary_period_end, $salary_date, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
//        $ress1 = $db->prepare("SELECT `SaFID` FROM `salary_frequent` WHERE `Name`=?");
        //        $ress1->execute(array($frequent_name));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //        if ($ress['SaFID'] == '') {
        $resa = $db->prepare("INSERT INTO `salary_frequent`(`Name`,`Salary_Frequent`,`Salary_Period_Start`,`Salary_Period_end`,`Salary_Date`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($frequent_name, $frequent_salary, $salary_period_start, $salary_period_end, $salary_date, $order, $status, $ip, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Holiday Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    } else {
//        $ress1 = $db->prepare("SELECT `SaFID` FROM `salary_frequent` WHERE `Name`=? AND `SaFID`!=?");
        //        $ress1->execute(array($frequent_name, $id));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //
        //        if ($ress['SaFID'] == '') {
        $resa = $db->prepare("UPDATE `salary_frequent` SET `Name`=?,`Salary_Frequent`=?,`Salary_Period_Start`=?,`Salary_Period_end`=?,`Salary_Date`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `SaFID`=? ");
        $resa->execute(array($frequent_name, $frequent_salary, $salary_period_start, $salary_period_end, $salary_date, $order, $status, $ip, $_SESSION['UID'], $id));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Holiday Group', 3, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    }
    return $res;
}
function getsalaryfrequent($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `salary_frequent` WHERE `SaFID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delsalaryfrequent($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Salary Frequent', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `salary_frequent` WHERE `SaFID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/*  Salary Frequent  end Here */
/*  Work Shift Start Here */
function addworkshift($holidaygroup, $shift_code, $shift_name, $sh_str_time, $sh_end_time, $min_reg_time, $max_reg_time, $break_time, $min_break_time, $weekoff, $holiday, $description, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
//        $ress1 = $db->prepare("SELECT `WoShID` FROM `work_shift` WHERE `Name`=?");
        //        $ress1->execute(array($shift_name));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //        if ($ress['WoShID'] == '') {
        $resa = $db->prepare("INSERT INTO `work_shift`(`Holiday_Group`, `Shift_Code`, `Shift_Name`, `Shift_Start_Time`, `Shift_End_Time`, `Minimum_Register_Time`, `Maximum_Register_Time`, `Break_Time`, `Minimum_Break_Time`, `Descriprion`, `WeekOff`, `Holidays`, `Order`, `Status`, `IP`, `Updated_by`  ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($holidaygroup, $shift_code, $shift_name, $sh_str_time, $sh_end_time, $min_reg_time, $max_reg_time, $break_time, $min_break_time, $description, $weekoff, $holiday, $order, $status, $ip, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Holiday Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    } else {
//        $ress1 = $db->prepare("SELECT `WoShID` FROM `work_shift` WHERE `Name`=? AND `WoShID`!=?");
        //        $ress1->execute(array($shift_name, $id));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //
        //        if ($ress['WoShID'] == '') {
        $resa = $db->prepare("UPDATE `work_shift` SET `Holiday_Group`=?, `Shift_Code`=?, `Shift_Name`=?, `Shift_Start_Time`=?, `Shift_End_Time`=?, `Minimum_Register_Time`=?, `Maximum_Register_Time`=?, `Break_Time`=?, `Minimum_Break_Time`=?, `Descriprion`=?, `WeekOff`=?, `Holidays`=?, `Order`=?, `Status`=?, `IP`=?, `Updated_by`=? WHERE `WoShID`=? ");
        $resa->execute(array($holidaygroup, $shift_code, $shift_name, $sh_str_time, $sh_end_time, $min_reg_time, $max_reg_time, $break_time, $min_break_time, $description, $weekoff, $holiday, $order, $status, $ip, $_SESSION['UID'], $id));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Holiday Group', 3, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    }
    return $res;
}
function getworkshift($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `work_shift` WHERE `WoShID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delworkshift($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Work Shift', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `work_shift` WHERE `WoShID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/*  Work Shift end Here */
/* Incentive Plan Start Here */
function addincentiveplan($group_name, $schedule, $incent_value, $targettype, $description, $item, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
//        $ress1 = $db->prepare("SELECT `IncentID` FROM `incentive_plan` WHERE `Group_Name`=?");
        //        $ress1->execute(array($group_name));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //        if ($ress['IncentID'] == '') {
        $resa = $db->prepare("INSERT INTO `incentive_plan`(`Group_Name`,`Schedule`,`Description`,`Incentive_Value`,`Target_Type`,`Item`, `Order`, `Status`, `IP`, `Updated_by` ) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($group_name, $schedule, $description, $incent_value, $targettype, $item, $order, $status, $ip, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Incentive Plan', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    } else {
//        $ress1 = $db->prepare("SELECT `IncentID` FROM `incentive_plan` WHERE `Name`=? AND `IncentID`!=?");
        //        $ress1->execute(array($group_name, $id));
        //        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        //
        //        if ($ress['IncentID'] == '') {
        $resa = $db->prepare("UPDATE `incentive_plan` SET `Group_Name`=?,`Schedule`=?,`Description`=?,`Incentive_Value`=?,`Target_Type`=?,`Item`=?, `Order`=?, `Status`=?, `IP`=?, `Updated_by`=? WHERE `IncentID`=? ");
        $resa->execute(array($group_name, $schedule, $description, $incent_value, $targettype, $item, $order, $status, $ip, $_SESSION['UID'], $id));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Incentive Plan', 3, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
//        } else {
        //            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        //        }
    }
    return $res;
}
function getincentiveplan($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `incentive_plan` WHERE `IncentID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delincentiveplan($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Incentive Plan', '3', 'Delete', $_SESSION['UID'], $ip, $c));
        $get = $db->prepare("DELETE FROM `incentive_plan` WHERE `IncentID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/*  Incentive Plan end Here */
function words($ammt)
{
    $number = $ammt;
    $no = round($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? ucfirst($words[$number]) .
            " " . $digits[$counter] . $plural . " " . $hundred :
            ucfirst($words[floor($number / 10) * 10])
            . " " . ucfirst($words[$number % 10]) . " "
            . ucfirst($digits[$counter]) . $plural . " " . $hundred;
        } else {
            $str[] = null;
        }

    }
    $str = array_reverse($str);
    $result = implode('', $str);
    if ($point < 19) {
        $points = ($point) ? " " . ucfirst($words[$point]) : '';
    } else {
        $points = ($point) ? " " . ucfirst($words[floor($point / 10) * 10]) . " " . ucfirst($words[$point = $point % 10]) : '';
    }
    $res .= $result . "";
    if ($points != '') {
        $res .= " and " . $points . ' Paisa Only';
    } else {
        $res .= ' Only';
    }
    return $res;
}
function addtax($a, $b, $c, $d)
{
    global $db;
    $resa = $db->prepare("UPDATE `tax` SET `tax`=?,`status`=?,`ip`=?,`updated_by`=? WHERE `tid`=?");
    $resa->execute(array(strtolower(trim($a)), $b, $c, $_SESSION['UID'], $d));
    $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
    $htry->execute(array('Tax', 38, 'Update', $_SESSION['UID'], $c, $d));
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    return $res;
}
function gettax($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `tax` WHERE `tid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function compress_image($destination_url, $quality)
{
    $info = getimagesize($destination_url);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($destination_url);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($destination_url);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($destination_url);
    }

    imagejpeg($image, $destination_url, $quality);
    return $destination_url;
}
function addledger($name, $printname, $aliasname, $under, $undersub, $openbal, $status, $ip, $paymode, $lid)
{
    global $db;
    global $session_value_id;
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
function getledger($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `ledger` WHERE `lid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delledger($a)
{
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
            foreach ($outputled as $out) {
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
function delledgergroup($a)
{
    echo $ip = $_SERVER['REMOYR_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?) ");
        $resa->execute(array("ledgergroup", "23", 'Delete', $_SESSION['UID'], $ip, $c));
        $get = pFetch("DELETE FROM `ledger-group` WHERE `ledgergroupid` ='?" . $c . "' ");
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4><!--<a href="' . $sitename . 'cheque/addcustomer.htm">Try Again</a>--></div>';
    return $res;
}
function getledgergroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `ledger-group` WHERE `ledgergroupid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function additem($itemcode = '', $barcode = '', $itemname = '', $invoicename = '', $isinventory = '', $issales = '', $ispurchasable = '', $isasset = '', $logo = '', $manufacturer = '', $brand = '', $group = '', $subgroup = '', $innergroup = '', $packageuom = '', $qtyperpackage = '', $unituom = '', $issku = '', $packsku = '', $unitsku, $margin = '', $purchasepackprice = '', $purchaseunitprice = '', $mrppackprice = '', $mrpunitprice = '', $salespackprice = '', $salesunitprice = '', $tax = '', $hsnsac = '', $warehouse = '', $mintax = '', $maintainstock = '', $properties = '', $order = '', $status = '', $ip = '', $itemid = '')
{
    global $db;
    if ($itemid == '') {
        /*$ress1 = $db->prepare("SELECT `Item_Code` FROM `item_master` WHERE `Status`!=?");
        $ress1->execute(array('2'));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {*/
        $resa = $db->prepare("INSERT INTO `item_master` (`Item_Code`,`Barcode`,`Item_Name`,`Invoice_Name`,`Is_Inventory`,`Is_Sales`,`Is_Purchase`,`Is_Asset`,`Logo`,`Manufacturer`,`Brand`,`Group`,`Sub_Group`,`Inner_Group`,`Package_UOM`,`Qty_Per_Package`,`Unit_UOM`,`Is_SKU`,`Pack_SKU`,`Unit_SKU`,`Margin`,`Purchase_Pack_Price`,`Purchase_Unit_Price`,`MRP_Pack_Price`,`MRP_Unit_Price`,`Sales_Pack_Price`,`Sales_Unit_price`,`Tax`,`HSN_SAC`,`Warehouse`,`Minimum_Tax`,`Maintain_Stock`,`Properties`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($itemcode, $barcode, $itemname, $invoicename, $isinventory, $issales, $ispurchasable, $isasset, $logo, $manufacturer, $brand, $group, $subgroup, $innergroup, $packageuom, $qtyperpackage, $unituom, $issku, $packsku, $unitsku, $margin, $purchasepackprice, $purchaseunitprice, $mrppackprice, $mrpunitprice, $salespackprice, $salesunitprice, $tax, $hsnsac, $warehouse, $mintax, $maintainstock, $properties, $order, $status, $ip, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Item', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        /*} else {
    $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Type</h4></div>';
    }*/
    } else {
        /*$ress1 = $db->prepare("SELECT `ItemID` FROM `item_type` WHERE `ItemType`=? AND `ItemID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {*/
        $resa = $db->prepare("UPDATE `item_master` SET `Item_Code`=?,`Barcode`=?,`Item_Name`=?,`Invoice_Name`=?,`Is_Inventory`=?,`Is_Sales`=?,`Is_Purchase`=?,`Is_Asset`=?,`Logo`=?,`Manufacturer`=?,`Brand`=?,`Group`=?,`Sub_Group`=?,`Inner_Group`=?,`Package_UOM`=?,`Qty_Per_Package`=?,`Unit_UOM`=?,`Is_SKU`=?,`Pack_SKU`=?,`Unit_SKU`=?,`Margin`=?,`Purchase_Pack_Price`=?,`Purchase_Unit_Price`=?,`MRP_Pack_Price`=?,`MRP_Unit_Price`=?,`Sales_Pack_Price`=?,`Sales_Unit_price`=?,`Tax`=?,`HSN_SAC`=?,`Warehouse`=?,`Minimum_Tax`=?,`Maintain_Stock`=?,`Properties`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `Item_Id`=?");
        $resa->execute(array($itemcode, $barcode, $itemname, $invoicename, $isinventory, $issales, $ispurchasable, $isasset, $logo, $manufacturer, $brand, $group, $subgroup, $innergroup, $packageuom, $qtyperpackage, $unituom, $issku, $packsku, $unitsku, $margin, $purchasepackprice, $purchaseunitprice, $mrppackprice, $mrpunitprice, $salespackprice, $salesunitprice, $tax, $hsnsac, $warehouse, $mintax, $maintainstock, $properties, $order, $status, $ip, $_SESSION['UID'], $itemid));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Item', 2, 'Update', $_SESSION['UID'], $ip, $itemid));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        /*} else {
    $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Type</h4></div>';
    }*/
    }
    return $res;
}
function getitem($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `item_master` WHERE `Item_id`=? AND `Status`!=?");
    $get1->execute(array($b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delitem($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Item', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `item_master` WHERE `Item_Id` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
function addsalesregister($customer, $date, $paytype, $taxtype, $type, $billno, $order, $items, $total, $ftotal, $total_discount, $address1, $address2, $city, $state, $pincode, $rid)
{
    global $db;
    $item = explode("##", $items[0]);
    $itemdesc = explode("##", $items[1]);
    $uprice = explode('##', $items[2]);
    $qty = explode('##', $items[3]);
    $tax = explode('##', $items[4]);
    $discount = explode('##', $items[5]);
    $amount = explode('##', $items[6]);
    $dval = explode('##', $items[7]);
    $tval = explode('##', $items[8]);
    $igst_i = explode('##', $items[9]);
    $igst_ival = explode('##', $items[10]);
    $sgst_i = explode('##', $items[11]);
    $sgst_ival = explode('##', $items[12]);
    $cgst_i = explode('##', $items[13]);
    $cgst_ival = explode('##', $items[14]);
    $unit = explode('##', $items[15]);
    $lastid = explode('##', $items[16]);

    if ($paytype == 'credit') {
        $ledgerid = getcustomer('ledger', $customer);
        $paytypes = '2';
    } else {
        $ledgerid = 26;
        $paytypes = '1';
    }

    if ($rid == '') {

        $resa = $db->prepare("INSERT INTO `sales_register` SET `customer`='" . $customer . "',`date`='" . $date . "', `paytype`='" . $paytype . "',`taxtype`='" . $taxtype . "',`billno`='" . $billno . "',`total`='" . $total . "',`ftotal`='" . $ftotal . "',`total_discount`='" . $total_discount . "'   ");
        $resa->execute();
        $insert_id = $db->lastInsertId();

        $tdid = $insert_id . "_S";

        foreach ($item as $i => $im) {
            $resa_i = '';
            $resa_i = $db->prepare("INSERT INTO `sales_register_details` SET `sid`='$insert_id',`item`='$im',`itemdesc`='$itemdesc[$i]', `qty`='$qty[$i]' ,`rate`='$uprice[$i]',`tax`='$tax[$i]',`discount`='$discount[$i]',`amount`='$amount[$i]' ,`discount_value`='$dval[$i]',`tax_value`='$tval[$i]' ,`igst_i`='$igst_i[$i]',`igst_ival`='$igst_ival[$i]',`sgst_i`='$sgst_i[$i]',`sgst_ival`='$sgst_ival[$i]',`cgst_i`='$cgst_i[$i]',`cgst_ival`='$cgst_ival[$i]' ,`unit`='$unit[$i]',`unitval`='" . getuom('Name', $unit[$i]) . "' ");
            $resa_i->execute();
        }

        $process = 'Inserted';

    } else {

        $resa = $db->prepare("UPDATE `sales_register` SET `customer`='" . $customer . "',`date`='" . $date . "', `paytype`='" . $paytype . "',`taxtype`='" . $taxtype . "',`billno`='" . $billno . "',`total`='" . $total . "',`ftotal`='" . $ftotal . "',`total_discount`='" . $total_discount . "' 	 WHERE `id`='$rid' ");
        $resa->execute();
        $insert_id = $rid;

        $tdid = $insert_id . "_S";

        foreach ($item as $i => $im) {

            $resa_i = '';
            if ($lastid[$i] == '') {

                $resa_i = $db->prepare("INSERT INTO `sales_register_details` SET `sid`='$insert_id',`item`='$im',`itemdesc`='$itemdesc[$i]',`qty`='$qty[$i]' ,`rate`='$uprice[$i]',`tax`='$tax[$i]',`discount`='$discount[$i]',`amount`='$amount[$i]' ,`discount_value`='$dval[$i]',`tax_value`='$tval[$i]' ,`igst_i`='$igst_i[$i]',`igst_ival`='$igst_ival[$i]',`sgst_i`='$sgst_i[$i]',`sgst_ival`='$sgst_ival[$i]',`cgst_i`='$cgst_i[$i]',`cgst_ival`='$cgst_ival[$i]',`unit`='$unit[$i]',`unitval`='" . getuom('Name', $unit[$i]) . "'  ");
                $resa_i->execute();
            } else {

                $resa_i = $db->prepare("UPDATE `sales_register_details` SET `sid`='$insert_id',`item`='$im',`itemdesc`='$itemdesc[$i]',`qty`='$qty[$i]' ,`rate`='$uprice[$i]',`tax`='$tax[$i]',`discount`='$discount[$i]',`amount`='$amount[$i]' ,`discount_value`='$dval[$i]',`tax_value`='$tval[$i]'   ,`igst_i`='$igst_i[$i]',`igst_ival`='$igst_ival[$i]',`sgst_i`='$sgst_i[$i]',`sgst_ival`='$sgst_ival[$i]',`cgst_i`='$cgst_i[$i]',`cgst_ival`='$cgst_ival[$i]',`unit`='$unit[$i]',`unitval`='" . getuom('Name', $unit[$i]) . "' WHERE `id`='$lastid[$i]' ");
                $resa_i->execute();
            }

        }

        $process = 'Updated';

    }

    $res['msg'] = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Succesfully ' . $process . '</h4></div>';

    $res['id'] = $insert_id;
    return $res;
}

function delsalesregister($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {

        $get = $db->prepare("DELETE FROM `sales_register` WHERE `id` ='" . $c . "' ");
        $get->execute();
        $get1 = $db->prepare("DELETE FROM `sales_register_details` WHERE `sid`= '$c'");
        $get1->execute();
    }

    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";
    return $res;
}
