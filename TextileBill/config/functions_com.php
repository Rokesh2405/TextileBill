<?php

function LoginCheck($a = '', $b = '', $c = '', $d = '', $e = '') {

    global $db;
    if (($a == '') || ($b == '')) {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i>Email or Password was empty</div>';
    } else {
        if ($e == '') {
            $stmt = $db->prepare("SELECT * FROM `users` WHERE `val1`=? AND `val3`=?");
            $stmt->execute(array($a, 1));
            $ress = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($ress['id'] != '') {
                if ($ress['val2'] == md5($b)) {
                    $res = "Hurray! You will redirect into dashboard soon";
                    $_SESSION['UID'] = $ress['id'];
                    if ($ress['id'] == '1') {
                        $_SESSION['type'] = 'admin';
                    }
					 $_SESSION['usertype'] = $ress['usertype'];
                     $_SESSION['merchant'] =$ress['merchant'] ;
                    $_SESSION['permissionid'] = $ress['usergroup'];
                    @extract($ress);
                    if ($id != '') {
                        $e = date('Y-m-d H:i:s');
                        $sql = 'INSERT INTO `admin_history`(admin_uid,ip,checkintime) VALUES(?,?,?)';
                        $stmt1 = $db->prepare($sql);
                        $stmt1->execute(array($id, $c, $e));
                        $_SESSION['admhistoryid'] = $db->lastInsertId();
                       // if ($d == '1') {
							
							
                            //if rememberme checkbox checked
                            setcookie('lemail', $a, time() + (60 * 60 * 24 * 10)); //Means 10 days change value of 10 to how many days as you want to remember the user details on user's computer
                            setcookie('lpass', $b, time() + (60 * 60 * 24 * 10));  //Here two coockies created with username and password as cookie names, $username,$password (login crediantials) as corresponding values
                       // }
                    }
                } elseif ($ress['val3'] == '2') {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i> Your Account was deactivated by Admin</div>';
                } else {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i> Email or Password was incorrect</div>';
                }
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i> Invalid login details!</div>';
            }
            return $res;
        }
    }
}

function logout() {
    global $db;
    $sql = $db->prepare("UPDATE `admin_history` SET `checkouttime`='" . date('Y-m-d H:i:s') . "' WHERE `id`=?");
    $sql->execute(array($_SESSION['admhistoryid']));
    // DB("UPDATE `admin_history` SET `checkouttime`='" . date('Y-m-d H:i:s') . "' WHERE `id`='" . $_SESSION['admhistoryid'] . "'");
}

function companylogos($a) {
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

function addprofile($footer_content,$terms,$tax,$title, $firstname, $lastname, $image, $cmpnyname, $recoveryemail, $phonenumber,$mail_option, $caddress, $abn, $ip,$bank_name,$branch_name,$account_name,$account_no,$ifsc_code,$swift_code,$branch_address, $id) {
    global $db;
    if ($id == '') {
        $resa = $db->prepare("INSERT INTO `manageprofile` (`footer_content`,`terms`,`tax`,`title`,`firstname`,`lastname`,`image`,`Company_name`,`recoveryemail`,`phonenumber`,`caddress`,`abn`,`ip`,`mail`,`bank_name`,`branch_name`,`account_name`,`account_no`,`ifsc_code`,`swift_code`,`branch_address`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($footer_content,$terms,$tax,$title, $firstname, $lastname, $image, $cmpnyname, $recoveryemail, $phonenumber, $caddress, $abn, $ip,$mail_option,$bank_name,$branch_name,$account_name,$account_no,$ifsc_code,$swift_code,$branch_address));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        
        $resa = $db->prepare("UPDATE `manageprofile` SET `footer_content`=?,`terms`=?,`tax`=?,`title`=?,`firstname`=?,`lastname`=?,`image`=?,`Company_name`=?,`recoveryemail`=?,`phonenumber`=?,`caddress`=?,`abn`=?,`ip`=?,`mail`=?,`bank_name`=?,`branch_name`=?,`account_name`=?,`account_no`=?,`ifsc_code`=?,`swift_code`=?,`branch_address`=? WHERE `pid`=?");
        $resa->execute(array($footer_content,$terms,$tax,$title, $firstname, $lastname, $image, $cmpnyname, $recoveryemail, $phonenumber, $caddress, $abn, $ip,$mail_option,$bank_name,$branch_name,$account_name,$account_no,$ifsc_code,$swift_code,$branch_address, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    }

    return $res;
}

function getprofile($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `manageprofile` WHERE `pid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function gettax($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `tax` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addtax($title, $percentage, $type, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link22 = FETCH_all("SELECT * FROM `tax` WHERE `title`=?", $title);
        if ($link22['title'] == '') {

            $resa = $db->prepare("INSERT INTO `tax` ( `title`, `percentage`,`type`,`order`, `status`, `ip`, `updated_by`) VALUES(?,?,?,?,?,?,?)");
            $resa->execute(array($title, $percentage, $type, $order, $status, $ip, $_SESSION['UID']));
            
            $id=$db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Tax Mgmt', 42, 'INSERT', $_SESSION['UID'], $ip, $id));
            
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Title already exists!</h4></div>';
        }
    } else {
        $link22 = FETCH_all("SELECT * FROM `tax` WHERE `title`=? AND `id`!=?", $title, $getid);
        if ($link22['title'] == '') {
            $resa = $db->prepare("UPDATE `tax` SET `title`=?,`type`=?,`percentage`=?,`order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `id`=?");
            $resa->execute(array(trim($title),trim($type), trim($percentage), trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
			
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Tax Mgmt', 42, 'UPDATE', $_SESSION['UID'], $ip, $id));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Title already exists!</h4></div>';
        }
    }
    return $res;
}

function deltax($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `tax` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}


function words($ammt) {
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
            $str [] = ($number < 21) ? ucfirst($words[$number]) .
                    " " . $digits[$counter] . $plural . " " . $hundred :
                    ucfirst($words[floor($number / 10) * 10])
                    . " " . ucfirst($words[$number % 10]) . " "
                    . ucfirst($digits[$counter]) . $plural . " " . $hundred;
        } else
            $str[] = null;
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

function compress_image($destination_url, $quality) {

    $info = getimagesize($destination_url);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($destination_url);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($destination_url);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($destination_url);

    imagejpeg($image, $destination_url, $quality);
    return $destination_url;
}

function show_toast($type, $msg) {
    return '
    <script id="thissc">
        window.onload = function(){
            toastr.' . $type . '("' . $msg . '");
                $("#thissc").remove();
        }
        
    </script>';
}

function getTable($table, $auto_id, $id) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `$table` WHERE `$auto_id`=?");
    $get1->execute(array($id));
    $get = $get1->fetch();
    return $get;
}

function getValue($table, $auto_id, $id, $field) {
    global $db;
    $get1 = FETCH_all("SELECT * FROM `$table` WHERE `$auto_id`=?", $id);
    $get = $get1[$field];
    return $get;
}

?>