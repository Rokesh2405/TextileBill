<?php

function getpermission($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `permission` WHERE `perid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function delpermission($a) {
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Permission group', 26, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("UPDATE `permission` SET `status`=? WHERE `perid` =? ");
        $get->execute(array(2, $c));
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
    return $res;
}
function getemailtemplate($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `emailtemplate` WHERE `eid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function addbillsettings($prefix,$format, $current_value,$id){
    global  $db;
	list($format, $current_value) = null_zero(array($format, $current_value));
     $res = $db->prepare("UPDATE `bill_settings` SET `prefix`=?,`format`=? , `current_value`=?  WHERE `id`=?");
     $res->execute(array($prefix,$format,$current_value,$id));     
     $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
     return $res;
}

function get_bill_settings($field,$id){
    global $db;
    $get1 = $db->prepare("SELECT * FROM `bill_settings` WHERE `id`=?");
    $get1->execute(array($id));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$field];
    return $res;
}

function update_bill_value($type_id){
     global  $db;
     $res = $db->prepare("UPDATE `bill_settings` SET `current_value`=?  WHERE `id`=?");
     $res->execute(array((get_bill_settings('current_value',$type_id) + 1),$type_id));   
}


function addsendgrid($a, $b, $c,$f,$g, $d, $e) {
    global $db;
    if ($e == '') {

        $resa = $db->prepare("INSERT INTO `sendgrid` (`api_key`,`username`,`password`,`semail`,`saddress`,`ip`) VALUES (?,?,?,?,?,?)");
        $resa->execute(array(trim($a), trim($b),trim($f), trim($g), trim($c), trim($d)));
        $insert_id = $db->lastInsertId();

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('sendgrid', 41, 'Insert', $_SESSION['UID'], $d, $insert_id));


        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Send Grid Detail Successfully Inserted!</h4></div>';
    } else {

        $resa = $db->prepare("UPDATE `sendgrid` SET `api_key`=?,`username`=?,`password`=?,`semail`=?,`saddress`=?,`ip`=? WHERE `sgid`=?");
        $resa->execute(array(trim($a), trim($b), trim($c),trim($f), trim($g), trim($d), $e));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('sendgrid', 41, 'Update', $_SESSION['UID'], $d, $e));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}

function addemailtemplate($subject, $description, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {

        $resa = $db->prepare("INSERT INTO `emailtemplate` (`subject`,`description`,`order`,`status`,`ip`) VALUES (?,?,?,?,?)");
        $resa->execute(array(trim($subject), trim($description),trim($order), trim($status), trim($ip)));
        $insert_id = $db->lastInsertId();

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Email Template', 41, 'Insert', $_SESSION['UID'], $d, $insert_id));


        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted!</h4></div>';
    } else {

        $resa = $db->prepare("UPDATE `emailtemplate` SET `subject`=?,`description`=?,`order`=?,`status`=?,`ip`=? WHERE `eid`=?");
        $resa->execute(array(trim($subject), trim($description), trim($order),trim($status), trim($ip), trim($getid)));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Email Template', 41, 'Update', $_SESSION['UID'], $d, $e));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}
function addgeneral($landingtitle,$image,$landingcontent,$heading1, $content1, $content2, $content3, $map, $Footer_Block, $facebook, $beforehead, $afterbody, $copyrights, $og_tag, $ip, $id) {
    global $db;

    $resa = $db->prepare("UPDATE `generalsettings` SET `landingtitle`=?,`landingimage`=?,`landingcontent`=?,`heading1`=?,`content1`=?,`content2`=?,`content3`=?,`map`=?,`Footer_Block`=?,`OG_Tag`=?,`Facebook_script`=?,`Copyrights`=?,`Before_Head`=?,`After_Body`=?,`ip`=?, `updated_id`=?,`updated_type`=? WHERE `generalid`=?");
    $resa->execute(array(trim($landingtitle),trim($image),trim($landingcontent),trim($heading1), trim($content1), trim($content2), trim($content3), trim($map),trim($Footer_Block), trim($og_tag), trim($facebook), trim($copyrights), trim($beforehead), trim($afterbody), trim($ip), $_SESSION['UID'], $_SESSION['type'], $id));

    $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
    $htry->execute(array('General Settings', 2, 'Update', $_SESSION['UID'], $ip, $id));
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    return $res;
}

function getgeneral($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `generalsettings` WHERE `generalid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
//$res = "SELECT * FROM `sendgrid` WHERE `sgid`='$b'";
    return $res;
}

/* home general  function end here */



/* home banner function start here */

function addhomebanners($title, $externallink, $image_name, $image_alt, $image, $status, $ip, $id) {
    global $db;
    try {
        $resa = $db->prepare("UPDATE `homebanners` SET `title`=?, `externallink`=?, `image`=?,`image_name`=?,`image_alt`=?,`status`=?,`ip`=?, `updated_id`=?,`updated_type`=? WHERE `hid`=?");
        $resa->execute(array(trim($title), trim($externallink), trim($image), trim($image_name), trim($image_alt), trim($status),  trim($ip), $_SESSION['UID'], $_SESSION['type'], $id));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Home Banners', 3, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    } catch (Exception $ex) {
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>' . $ex . '</h4></div>';
    }

    return $res;
}

function gethomebanners($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `homebanners` WHERE `hid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* home banner function start here */



/* home content function start here */

function addhomecontent($title1, $content1, $status1, $title2, $content2, $status2, $title3, $content3, $status3, $ip, $id) {
    //$title1, $content1, $status1, $title2, $content2, $status2, $title3, $content3, $status3, 
    global $db;

    $resa = $db->prepare("UPDATE `homecontent` SET `title1`=?,`content1`=?,`title2`=?,`content2`=?,`status1`=?,`status2`=?,`title3`=?,`content3`=?,`status3`=?,`ip`=?, `updated_id`=?,`updated_type`=? WHERE `hcid`=?");
    $resa->execute(array(trim($title1), trim($content1), trim($title2), trim($content2), trim($status1), trim($status2), trim($title3), trim($content3), trim($status3), trim($ip), $_SESSION['UID'], $_SESSION['type'], $id));

    $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
    $htry->execute(array('Home Content', 5, 'Update', $_SESSION['UID'], $ip, $id));
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    return $res;
}

function gethomecontent($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `homecontent` WHERE `hcid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

/* home content function end  here */

/* home block function start here */

function addhomeblocks($title1, $image_name1, $image_alt1, $image1, $button_name1, $button_link1, $status1, $title2, $image_name2, $image_alt2, $image2, $button_name2, $button_link2, $status2, $ip, $id) {
    global $db;
    try {
        $resa = $db->prepare("UPDATE `homeblocks` SET `title1`=?,`image1`=?,`image_name1`=?,`image_alt1`=?,`button_name1`=?,`button_link1`=?,`status1`=?,`title2`=?,`image2`=?,`image_name2`=?,`image_alt1`=?,`button_name2`=?,`button_link2`=?,`status2`=?,`ip`=?, `updated_id`=?,`updated_type`=? WHERE `hid`=?");
        $resa->execute(array(trim($title1), trim($image1), trim($image_name1), trim($image_alt1), trim($button_name1), trim($button_link1), trim($status1), trim($title2), trim($image2), trim($image_name2), trim($image_alt2), trim($button_name2), trim($button_link2), trim($status2), trim($ip), $_SESSION['UID'], $_SESSION['type'], $id));

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Home Blocks', 3, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    } catch (Exception $ex) {
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>' . $ex . '</h4></div>';
    }

    return $res;
}

function gethomeblocks($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `homeblocks` WHERE `hid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
//$res = "SELECT * FROM `sendgrid` WHERE `sgid`='$b'";
    return $res;
}

/* home block function start here */

function getsocialmedia($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `socialmedia` WHERE `sid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
//$res = "SELECT * FROM `sendgrid` WHERE `sgid`='$b'";
    return $res;
}

function addsocialmedia($social_media, $link, $order, $status, $ip, $id) {
    global $db;

    $resa = $db->prepare("UPDATE `socialmedia` SET `sname`=?,`link`=?,`order`=?,`status`=?,`ip`=?, `updated_id`=? WHERE `sid`=?");
    $resa->execute(array(trim($social_media), trim($link), trim($order), trim($status), trim($ip), $_SESSION['UID'], $id));

    $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
    $htry->execute(array('Social Media', 7, 'Update', $_SESSION['UID'], $ip, $id));
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    return $res;
}

function gethomebanner($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `homebanners` WHERE `hbid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
//$res = "SELECT * FROM `sendgrid` WHERE `sgid`='$b'";
    return $res;
}

function getbreadcrumb_banner($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `breadcrumb_banner` WHERE `hbid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
//$res = "SELECT * FROM `sendgrid` WHERE `sgid`='$b'";
    return $res;
}

function addbreadcrumb_banner($title1, $link1, $content1, $imagealt1, $imagename1, $image1, $title2, $link2, $content2, $imagealt2, $imagename2, $image2, $ip, $thispageid, $getid) {
    global $db;

    //$ress="UPDATE `homebanners` SET `title1`='".$title1."', `link1`='".$link1."', `content1`='".$content1."', `image_alt1`='".$imagealt1."', `image_name1`='".$imagename1."',`image1`='".$image1."',`title2`='".$title2."',`link2`='".$link2."',`content2`='".$content2."',`image_alt2`='".$imagealt2."', `image_name2`='".$imagename2."',`image2`='".$image2."',`title3`='".$title3."',`link3`='".$link3."',`content3`='".$content3."', `image_alt3`='".$imagealt3."', `image_name3`='".$imagename3."',`image3`='".$image3."', `ip`='".$ip."', `updated_by`='".$_SESSION['UID']."' WHERE `hbid`='".$getid."'";

    $resa = $db->prepare("UPDATE `breadcrumb_banner` SET `title1`=?, `link1`=?, `content1`=?, `image_alt1`=?, `image_name1`=?,`image1`=?,`title2`=?,`link2`=?,`content2`=?,`image_alt2`=?, `image_name2`=?,`image2`=?,`ip`=?, `updated_by`=? WHERE `hbid`=?");
    $resa->execute(array(trim($title1), trim($link1), trim($content1), trim($imagealt1), trim($imagename1), trim($image1), trim($title2), trim($link2), trim($content2), trim($imagealt2), trim($imagename2), trim($image2), trim($ip), $_SESSION['UID'], $getid));
    $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
    $htry->execute(array('Home Banners', $thispageid, 'Update', $_SESSION['UID'], $ip, $id));
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button><h4><i class="icon fa fa-check"></i>Successfully Saved</h4></div>';
    return $res;
}

function delhomebanners($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `homebanners` WHERE `hbid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
    $htry->execute(array('Home Banners', $thispageid, 'Update', $_SESSION['UID'], $ip, $id));
    return $res;
}

function getcaptcha($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `captcha` WHERE `cid`=? AND `status`=?");
    $get1->execute(array($b,1));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addcaptcha($sitekey, $secret, $status, $ip, $cid) {
    global $db;
    if ($cid == '') {

        $resa = $db->prepare("INSERT INTO `captcha`(`sitekey`,`secret`,`ip`,`status`,`updated_by`,`updated_type`)VALUES(?,?,?,?,?,?)");
        $resa->execute(array($sitekey, $secret, $ip, $status, $_SESSION['UID'], $_SESSION['UIDD']));
        $insert_id = $db->lastInsertId();

        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Captcha Mgmt', '35', 'Insert', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], trim($insert_id)));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        $resa = $db->prepare("UPDATE `captcha` SET `sitekey`=?,`secret`=?,`ip`=?,`status`=?,`updated_by`=?,`updated_type`=? WHERE `cid`=?");
        $resa->execute(array($sitekey, $secret, $ip, $status, $_SESSION['UID'], $_SESSION['UIDD'], $cid));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Captcha Mgmt', '35', 'Update', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], trim($cid)));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
    }
    return $res;
}


function addusers($name, $username, $password,$merchant, $status, $getid) {
    global $db;
    if ($getid == '') {
        $link22 = FETCH_all("SELECT `id` FROM `users` WHERE `val1`=?", $username);
        if ($link22['id'] == '') {
            $ress="INSERT INTO `users` (`name`, `val1`,`val2`,`val3`,`merchant`) VALUES('".$name."','".$username."','".$password."','".$status."','".$merchant."' )";
            $resa = $db->prepare("INSERT INTO `users` (`name`, `val1`,`val2`,`val3`,`merchant`) VALUES(?,?,?,?,?)");
            $resa->execute(array($name, $username, md5($password), $status,$merchant));
            
            $id=$db->lastInsertId();
            
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Users Mgmt', 40, 'INSERT', $_SESSION['UID'], $ip, $id));
            
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Username already exists!</h4></div>';
        }
    } else {
        $link22 = FETCH_all("SELECT `id` FROM `users` WHERE `val1`=? AND `id`!=?", $username, $getid);
        if ($link22['id'] == '') {
            $resa = $db->prepare("UPDATE `users` SET `merchant`=?,`name`=?,`val1`=?,`val3`=? WHERE `id`=?");
            $resa->execute(array(trim($merchant), trim($name),trim($username),trim($status), $getid));
			

        // $get = $db->prepare("DELETE FROM `homebanners` WHERE `hbid` = ? ");
        // $get->execute(array($c));


            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Users Mgmt', 40, 'UPDATE', $_SESSION['UID'], $ip, $id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Username already exists!</h4></div>';
        }
    }
    return $res;
}

function delusers($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Users Mgmt', 40, 'DELETE', $_SESSION['UID'], $ip, $c));
        

        $get = $db->prepare("DELETE FROM `users` WHERE `id` = ? ");
        $get->execute(array($c));


        // $get = $db->prepare("UPDATE `users` SET `val3`=? WHERE `id` = ? ");
        // $get->execute(array('2',$c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getusers($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `users` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

?>