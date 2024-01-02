<?php 



function sendsms($addheader, $tmessage, $addfooter, $senderid, $message, $noumbers, $ip, $eid, $codevalue) {
    $getheader = gettemplate('message', $addheader);
    $getheadercount = strlen($getheader) + 1;
    $getfooter = gettemplate('message', $addfooter);
    $getfootercount = strlen($getfooter) + 1;
    $gettmessage = gettemplate('message', $tmessage);
    $gettmessagecount = strlen($gettmessage);
    $getmessage = $message;
    $getmessagecount = strlen($getmessage) + 1;
    $totalcount = $getheadercount + $getfootercount + $gettmessagecount + $getmessagecount;
    $totalmessage = $getheader . ' ' . $gettmessage . ' ' . $getmessage . ' ' . $getfooter;

    $mob_num = explode(",", $noumbers);
    $sms_msgv = trim($totalmessage);
    $sms_cnt = ceil(strlen($sms_msgv) / 160);

    $sms_sender_id = $senderid;

    foreach ($mob_num as $val) {
        if ($val != '') {

            $sms_cnt_val = getcustomer('remainsmscount', $_SESSION['UID']);

            if ($sms_cnt_val <= 0) {
                $res = "<span style='color:#f00;padding-left:15px;'><b>SMS count 0 please recharge now. thank you</b></span>";
                return $res;
                break;
            }

            $rsp = "http://smspps.itsolusenz.com/api/sendmsg.php";
            //unicode        
            if ($codevalue == '1') {
                $styp = 'normal';
            } elseif ($codevalue == '2') {
                $styp = 'unicode';
            } else {
                $styp = 'normal';
            }
            $params = array("user" => 'nbaypps', "pass" => 'nbaypps', "phone" => trim($val), "text" => $sms_msgv, "priority" => 'sdnd', "stype" => $styp, "sender" => $senderid);

            $ch = curl_init();

            if (count($params) > 0) {
                $query = http_build_query($params);
                curl_setopt($ch, CURLOPT_URL, "$rsp?$query");
            } else {
                curl_setopt($ch, CURLOPT_URL, $rsp);
            }

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $response = curl_exec($ch);
            $ress .= $rsp . '?' . $query . '?' . $response;
            mysql_query("INSERT INTO `smslog` SET `uid`='" . getcustomer('resellerid', $_SESSION['UID']) . "',`cusid`='" . $_SESSION['UID'] . "',`date`=NOW(),`messagecount`='" . $sms_cnt . "',`remainsmscount`='" . (getcustomer('remainsmscount', $_SESSION['UID']) - $sms_cnt) . "',`unicode`='" . $unicode . "',`delivered`='',`scheduledsms`='',`promotional`='1',`transactional`='0',`groupsms`='0',`ip`='" . $ip . "',`number`='" . $val . "',`message`='" . mysql_real_escape_string($sms_msgv) . "'");

            $iid = mysql_insert_id();

            mysql_query("UPDATE `noti_customer` SET `remainsmscount`='" . (getcustomer('remainsmscount', $_SESSION['UID']) - $sms_cnt) . "' WHERE `id`='" . $_SESSION['UID'] . "'");

            if ($response != '') {
                if ($response == 'No Sufficient Credits') {
                    mysql_query("UPDATE `smslog` SET `serverresponse`='" . $response . "' WHERE `sid`='" . $iid . "'");
                    $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>SMS count 0 please recharge now. thank you</h4></div>';

                    return $res;
                    break;
                } elseif ($response == 'Sender ID Does not Exist or Pending or Route Invalid!') {
                    mysql_query("UPDATE `smslog` SET `serverresponse`='" . $response . "' WHERE `sid`='" . $iid . "'");
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>' . $response . '</h4></div>';
                    return $res;
                    break;
                } elseif ($response == 'Username/Password Incorrect or Account Deactivated') {
                    mysql_query("UPDATE `smslog` SET `serverresponse`='" . $response . "' WHERE `sid`='" . $iid . "'");
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>' . $response . '</h4></div>';
                    return $res;
                    break;
                } else {
                    mysql_query("UPDATE `smslog` SET `serverresponse`='" . $response . "',`delivered`='1' WHERE `sid`='" . $iid . "'");
                    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>SMS Sent Successfully... </h4></div>';
                }
            } else {
                mysql_query("UPDATE `smslog` SET `serverresponse`='SERVER Response Error' WHERE `sid`='" . $iid . "'");
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Could not send the sms... SERVER ERROR</h4></div>';
                //return $res;
                // break;
            }
        }
    }
    return $ress;
    // return $res;
}


function addtemplate($a, $b, $c, $d, $e, $f) {
    if ($f == '') {
        $ress = DB_QUERY("SELECT `tid` FROM `templates` WHERE `title`='" . $a . "' AND `uid`='" . $_SESSION['UID'] . "' AND `status`!='2'");
        if ($ress['tid'] == '') {
            $resa = mysql_query("INSERT INTO `templates` (`uid`,`title`,`type`,`message`,`status`,`ip`,`updated_by`) VALUES ('" . $_SESSION['UID'] . "','" . $a . "','" . $b . "','" . $c . "','" . $d . "','" . $e . "','" . $_SESSION['UID'] . "')");
            $insert_id = mysql_insert_id();
            $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Add Template','2','Insert','" . $_SESSION['UID'] . "','" . $e . "','" . $insert_id . "')");
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Succesfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Template Title</h4></div>';
        }
    } else {
        $ress = DB_QUERY("SELECT `tid` FROM `templates` WHERE `title`='" . $a . "' AND `uid`='" . $_SESSION['UID'] . "' AND `status`!='2' AND `tid`!='" . $f . "'");
        if ($ress['tid'] == '') {
            $resa = mysql_query("UPDATE `templates` SET `title`='" . $a . "',`type`='" . $b . "',`message`='" . $c . "',`status`='" . $d . "',`ip`='" . $e . "',`updated_by`='" . $_SESSION['UID'] . "' WHERE `tid`='" . $f . "'");
            $htry = mysql_query("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES ('Add Template','2','Update','" . $_SESSION['UID'] . "','" . $e . "','" . $f . "')");
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated!</h4></div>';
        }
    }
    return $res;
}



function gettemplate($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `templates` WHERE `tid`=? AND `status`!=?");
    $get1->execute(array($b,2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function deltemplate($a) {
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Templates', $thispageid, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], trim($c)));
        $get = $db->prepare("DELETE FROM `templates` WHERE `tid` =? ");
        $get->execute(array(trim($c)));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}


 ?>