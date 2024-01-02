<?php

/* Driver Start here */ 

function adddriver($title,$firstname, $lastname, $email, $password, $mobile, $landline,$address1, $address2, $suburb,  $state, $country, $postcode, $license, $licensenumber,  $photo, $dob, $doj, $dot, $designation, $basic_salary,$salary_frequency,$documentlist,$emp_group,$status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `did` FROM `driver` WHERE `email`=?", $email);
        if ($link1['did'] == '') {
            $link2 = FETCH_all("SELECT `did` FROM `driver` WHERE `mobile`=?", $mobile);
            if ($link2['did'] == '') {
                $resa = $db->prepare("INSERT INTO `driver` (`title`,`firstname`,`lastname`,`email`,`password`,`mobile`,`landline`,`address1`,`address2`,`suburb`,`state`,`country`,`postcode`,`license`,`licensenumber`,`photo`,`dob`,`doj`,`dot`, `designation`,`basic_salary`,`salary_frequency`,`emp_group`,`documents`,`status`,`ip`,`inserted_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($title,$firstname, $lastname, $email, $password, $mobile, $landline,$address1, $address2, $suburb,  $state, $country, $postcode, $license, $licensenumber,  $photo, $dob, $doj, $dot, $designation, $basic_salary,$salary_frequency,$emp_group, $documentlist,$status, $ip, $_SESSION['UID']));

                $id = $db->lastInsertId();
                $driverid = '5AABD' . str_pad($id, 5, 0, STR_PAD_LEFT);

                $resa = pFETCH("UPDATE `driver` SET `driverid`=? WHERE `did`=?", $driverid, $id);
                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Driver Mgmt', 9, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Mobile Number already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `did` FROM `driver` WHERE `email`=? AND `did`!=?", $email, $getid);
        if ($link1['did'] == '') {
            $link2 = FETCH_all("SELECT `did` FROM `driver` WHERE `mobile`=? AND `did`!=?", $mobile, $getid);
            if ($link2['did'] == '') {
                $resa = $db->prepare("UPDATE `driver` SET `title`=?,`firstname`=?,`lastname`=?,`email`=?,`password`=?,`mobile`=?,`landline`=?,`address1`=?,`address2`=?,`suburb`=?,`state`=?,`country`=?,`postcode`=?,`license`=?,`licensenumber`=?,`photo`=?,`dob`=?,`doj`=?,`dot`=?, `designation`=?,`basic_salary`=?,`salary_frequency`=?,`emp_group`=?,`documents`=?,`status`=?,`ip`=?,`inserted_by`=? WHERE `did`=?");
                $resa->execute(array(trim($title),trim($firstname), trim($lastname), trim($email), trim($password), trim($mobile), trim($landline),trim($address1), trim($address2), trim($suburb), trim($state), trim($country), trim($postcode), trim($license), trim($licensenumber),  trim($photo), trim($dob), trim($doj), trim($dot), trim($designation), trim($basic_salary), trim($salary_frequency),  trim($emp_group), trim($documentlist),trim($status), $ip, $_SESSION['UID'], $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Driver Mgmt', 9, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Mobile Number already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    }
    return $res;
}

function deldriver($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("UPDATE `driver` SET `status`=? WHERE `did` = ? ");
        $get->execute(array('2',$c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getdriver($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `driver` WHERE `did`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* Driver Code start here */


/* Employee Group Code Start Here */

function addemployeegroup($groupname,  $status, $ip, $getid) {
    global $db;   
    if ($getid == '') {
            $link2 = FETCH_all("SELECT `id` FROM `employeegroup` WHERE `groupname`=?", $groupname);
            if ($link2['id'] == '') {
                $resa = $db->prepare("INSERT INTO `employeegroup` (`groupname`,`status`,`ip`,`inserted_by`) VALUES(?,?,?,?)");
                $resa->execute(array($groupname,  $status,$ip, $_SESSION['UID']));
                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('employeegroup Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } 
        else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Group Name exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `employeegroup` WHERE `groupname`=? AND `id`!=?", $groupname, $getid);
        if ($link1['id'] == '') {           
                $resa = $db->prepare("UPDATE `employeegroup` SET `groupname`=?,  `status`=?, `ip`=?, `updated_by`=? WHERE `id`=?");
                $resa->execute(array(trim($groupname),  $status, trim($ip), $_SESSION['UID'], $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Customer Group Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    }
    return $res;
}

function delemployeegroup($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
         $get = $db->prepare("DELETE FROM `employeegroup` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getemployeegroup($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `employeegroup` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* Employee Group Code  End Here */


/* Customer Group Code Start Here */

function addcustomergroup($groupname,$discount, $status,$ip,  $getid) {
    global $db;   
    if ($getid == '') {
            $link2 = FETCH_all("SELECT `id` FROM `customergroup` WHERE `groupname`=?", $groupname);
            if ($link2['id'] == '') {
                $resa = $db->prepare("INSERT INTO `customergroup` (`groupname`,`discount`,`status`,`ip`,`inserted_by`) VALUES(?,?,?,?,?)");
                $resa->execute(array($groupname, $discount, $status,$ip, $_SESSION['UID']));
                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('CustomerGroup Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } 
        else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Group Name exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `customergroup` WHERE `groupname`=? AND `id`!=?", $groupname, $getid);
        if ($link1['id'] == '') {           
                $resa = $db->prepare("UPDATE `customergroup` SET `discount`=?,`groupname`=?,  `status`=?, `ip`=?, `updated_by`=? WHERE `id`=?");
                $resa->execute(array($discount,trim($groupname), $status, trim($ip), $_SESSION['UID'], $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Customer Group Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    }
    return $res;
}

function delcustomergroup($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
         $get = $db->prepare("DELETE FROM `customergroup` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getcustomergroup($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `customergroup` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* Customer Group Code  End Here */



/* Customer Code Start Here */

function addcustomer($companyname,$cmpyabnno,$contactperson,$title,$firstname, $lastname, $mobile, $landline, $email, $photo, $address1, $address2, $suburb, $state, $postcode, $country, $status, $cus_group, $ip, $getid) {
    global $db;
     
    if ($getid == '') {
	
        $link1 = FETCH_all("SELECT `cid` FROM `customer` WHERE `email`=?", $email);
        if ($link1['cid'] == '') {
            $link2 = FETCH_all("SELECT `cid` FROM `customer` WHERE `mobile`=?", $mobile);
            if ($link2['cid'] == '') {
                $resa = $db->prepare("INSERT INTO `customer` (`companyname`,`cmpyabnno`,`contactperson`,`title`,`firstname`,`lastname`,`email`,`mobile`,`landline`,`address1`,`address2`,`suburb`,`state`,`country`,`postcode`,`photo`,`ip`,`status`,`cus_group`,`inserted_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($companyname,$cmpyabnno,$contactperson,$title, $firstname, $lastname, $email, $mobile, $landline, $address1, $address2, $suburb, $state, $country, $postcode, $photo, $ip, $status,$cus_group,$_SESSION['UID']));

                $id = $db->lastInsertId();
                $driverid = '5AABC' . str_pad($id, 5, 0, STR_PAD_LEFT);

                $resa = pFETCH("UPDATE `customer` SET `customerid`=? WHERE `cid`=?", $driverid, $id);
                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Customer Mgmt', 10, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Mobile Number already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `cid` FROM `customer` WHERE `email`=? AND `cid`!=?", $email, $getid);
        if ($link1['did'] == '') {
            $link2 = FETCH_all("SELECT `cid` FROM `customer` WHERE `mobile`=? AND `cid`!=?", $mobile, $getid);
            if ($link2['did'] == '') {
                $resa = $db->prepare("UPDATE `customer` SET `companyname`=?,`cmpyabnno`=?,`contactperson`=?,`title`=?,`firstname`=?,`lastname`=?,`email`=?,`mobile`=?,`landline`=?, `address1`=?, `address2`=?, `suburb`=?, `state`=?, `country`=?, `postcode`=?, `photo`=?, `ip`=?, `status`=?, `cus_group`=?,`updated_by`=? WHERE `cid`=?");
                $resa->execute(array(trim($companyname),trim($cmpyabnno),trim($contactperson),trim($title), trim($firstname), trim($lastname), trim($email), trim($mobile), trim($landline), trim($address1), trim($address2), $suburb, $state, trim($country), trim($postcode), trim($photo), trim($ip), $status, $cus_group, $_SESSION['UID'], $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Customer Mgmt', 10, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Mobile Number already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Email already exists!</h4></div>';
        }
    }
    return $res;
}

function delcustomer($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("UPDATE `customer` SET `status`=? WHERE `cid` = ? ");
        $get->execute(array('2',$c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getcustomer($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `customer` WHERE `cid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* Customer Code End Here */


function addempcategory($designation,$status,$ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `id` FROM `employee_category` WHERE `category`=?", $category);
        if ($link1['id'] == '') {
           
                $resa = $db->prepare("INSERT INTO `employee_category` ( `designation`,`status`) VALUES(?,?)");
                $resa->execute(array($designation,$status));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Employee Designation Mgmt', 15, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
           
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Category already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `employee_category` WHERE `category`=? AND `id`!=?", $category, $getid);
        if ($link1['id'] == '') {
           
                $resa = $db->prepare("UPDATE `employee_category` SET `designation`=?,`status`=? WHERE `id`=?");
                $resa->execute(array(trim($designation), $status, $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Employee Designation Category Mgmt', 15, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
          
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Category already exists!</h4></div>';
        }
    }
    return $res;
}

function delempcategory($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `employee_category` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getempcategory($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `pricingcategory` WHERE `cid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function addimage($image, $imagename, $imagealt, $status, $ip, $thispageid, $getid)
{
    global $db;
    if ($getid == '') {

        $link23 = $db->prepare("SELECT * FROM `imageup` WHERE `image_name` = ? ");
        $link23->execute(array($imagename));
        $link22 = $link23->fetch();
        if ($link22['image_name'] == '') {

            $qa = $db->prepare("INSERT INTO `imageup`(`image`, `image_name`, `image_alt`, `status`, `ip`, `updated_by`) values(?, ?, ?, ?, ?, ?) ");
            $qa->execute(array($image, $imagename, $imagealt, $status, $ip, $_SESSION['UID']));

            $id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history`(`page`, `pageid`, `action`, `userid`, `ip`, `actionid`) VALUES(?, ?, ?, ?, ?, ?)");
            $htry->execute(array('imageup', 40, 'Insert', $_SESSION['UID'], $ip, $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button><h4><i class="icon fa fa-close"></i> Image Name already exists!</h4></div>';
        }
        return $res;
    }
}

function getimage($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `imageup` WHERE `aiid` = ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}
function getstaticpages($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `static_pages` WHERE `stid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
//$res = "SELECT * FROM `sendgrid` WHERE `sgid`='$b'";
    return $res;
}

function delstaticpages($a) {
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('staticPages', $thispageid, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], trim($c)));
        $get = $db->prepare("DELETE FROM `static_pages` WHERE `stid` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
?>