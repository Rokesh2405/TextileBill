<?php
function sendoldmail($subject, $message, $mail, $to) {
    $headers = "MIME-Version: 1.0 \n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "From: " . $mail . " \r\n ";
    mail($to, $subject, $message, $headers);
}

function sendsms($message, $noumbers, $ip, $type) {

    global $db;

    $smstemplate = FETCH_all("SELECT * FROM `templates` WHERE `type` = ?", $type);
    $message = $smstemplate['message'];
    $getmessage = $message;
    $getmessagecount = strlen($getmessage) + 1;
    $totalcount = $getmessagecount;
    $totalmessage = $getmessage;

    $mob_num = explode(",", $noumbers);
    $sms_msgv = trim($totalmessage);
    $sms_cnt = ceil(strlen($sms_msgv) / 160);

    $sms_sender_id ='CLKBUY';

    
        if ($noumbers != '') {

            $rsp = "http://sms1.easven.in/submitsms.jsp";

            $params = array("user" => 'clkbuy', "key" => '42709138eeXX', "mobile" => '+91'.trim($noumbers), "message" => $sms_msgv, "accusage" => '1', "senderid" =>$sms_sender_id);


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
print_r($response); die;

//sent,success,922337203,560354604,+919245141788

            DB("INSERT INTO `smslog` SET `date`=NOW(),`messagecount`='" . $sms_cnt . "',`remainsmscount`='',`unicode`='',`delivered`='',`scheduledsms`='',`promotional`='0',`transactional`='1',`groupsms`='0',`ip`='" . $ip . "',`number`='" . $noumbers . "',`message`='" . mysql_real_escape_string($sms_msgv) . "'");

            $iid = mysqli_insert_id();

            if ($response != '') {
                $rs=explode(",",$response);
                DB("UPDATE `smslog` SET `serverresponse`='" . $response . "' WHERE `sid`='" . $iid . "'");
            } else {
                DB("UPDATE `smslog` SET `serverresponse`='SERVER Response Error' WHERE `sid`='" . $iid . "'");
            }
        }
    
    return $res;
}


function addcontact($cfullname, $cemail, $csubject, $cphone, $cmessage, $ip) {
    global $db;
    global $fsitename;
    $resa = $db->prepare("INSERT INTO `contact_form` ( `firstname`, `emailid`,`subject`, `phoneno`,`comments`,`ip`) VALUES(?,?,?,?,?,?)");
    $resa->execute(array($cfullname, $cemail, $csubject, $cphone, $cmessage, $ip));
    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
    $to = $general['recoveryemail'];
    $subject = "Contact From  " . $cfullname;

    $message = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg' .'" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Contact detail</span>
                    </th>
                    </thead>
                    
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello Admin,<br /><br /> You have a Contact<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Name :</td>
                        <td style="padding:5px;" colspan="2">' . $cfullname . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Email :</td>
                        <td style="padding:5px;" colspan="2">' . $cemail . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Contact Number :</td>
                        <td style="padding:5px;" colspan="2">' . $cphone . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Subject :</td>
                        <td style="padding:5px;" colspan="2">' . $csubject . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Message :</td>
                        <td style="padding:5px;" colspan="2">' . $cmessage . '</td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

    sendgridmail($to, $message, $subject, $cemail, '', '');
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="fa fa-check"></i> Submitted Successfully </h4></div>';

    return $res;
}


function addassistorscomment($assistor,$aname, $aemail, $acomment) {
    global $db;
    global $fsitename;
	$date=date('Y-m-d');
   

 $resa = $db->prepare("INSERT INTO `assistor_faq` (`assistor`, `uname`,`uemail`, `question`,`date`) VALUES (?,?,?,?,?)");
    $resa->execute(array($assistor, $aname, $aemail, $acomment, $date));
   
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="fa fa-check"></i> Submitted Successfully </h4></div>';

    return $res;
}

function addassistorsanswer($assistor,$assid, $answer) {
    global $db;
    global $fsitename;
	$date=date('Y-m-d');
     
	 $ress = pFETCH("UPDATE `assistor_faq` SET `answer`=? WHERE `fid`=?", $answer,$assid);

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="fa fa-check"></i> Replied Successfully </h4></div>';

    return $res;
}

function addsubscribe($newsletter, $ip) {
    global $db;

    $chk = FETCH_all("SELECT `email` FROM `newsletter` WHERE `email`=?", $newsletter);
    if ($chk['email'] == '') {
        $resa = $db->prepare("INSERT INTO `newsletter` (`email`,`ip`) VALUES(?,?)");
        $resa->execute(array($newsletter, $ip));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Subscribed Successfully </h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Already Subscribed</h4></div>';
    }
    return $res;
}

function assistorlogin($loginemail, $logpassword, $ip, $url) {
    global $db;
    global $fsitename;

    $chk = FETCH_all("SELECT * FROM `assistor` WHERE `email`=?", $loginemail);

    $pass = md5($logpassword);
    if (($chk['asid'] != '') && ($chk['email'] == $loginemail)) {
        if ($chk['status'] == '1') {
            if (($chk['password'] == $pass) && ($chk['email'] == $loginemail)) {

                $_SESSION['ASSUID'] = $chk['asid'];

                
                header("location:" . $fsitename);
                exit;
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Login details are incorrect</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4> Invalid Login Details</h4></div>';
        }
    } else {

        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Your Account is Not exist..</h4></div>';
    }
    return $res;
}

function checklogin($loginemail, $logpassword, $ip, $url) {
    global $db;

    $chk = FETCH_all("SELECT `CusID`,`Status`,`Password` FROM `customer` WHERE `E-mail`=?", $loginemail);
    $pass = md5($logpassword);
    if ($chk['Status'] == '1') {
        if ($chk['Password'] == $pass) {
            $_SESSION['GUEST_ID'] = '';
            $_SESSION['GUEST'] = '';
            $_SESSION['FUID'] = $chk['CusID'];
            $stmt1 = pFETCH('INSERT INTO `cus_history` (`CusID`,`Logintime`,`Loginvia`,`IP`) VALUES (?,?,?,?)', $chk['CusID'], date('Y-m-d H:i:s'), $_SERVER['HTTP_USER_AGENT'], $ip);
            $res = 'sucess';
            if ($_SESSION['GUEST_ID'] != '') {
                $ds = $db->prepare("DELETE FROM `guest` WHERE `id`=?");
                $ds->execute(array($_SESSION['GUEST_ID']));
                $ds = $db->prepare("DELETE FROM `bill_ship_address` WHERE `Guest_ID`=?");
                $ds->execute(array($_SESSION['GUEST_ID']));
            }
            header("location:" . $url);
            exit;
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Login details are incorrect</h4></div>';
        }
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4> Invalid Login Details</a></h4></div>';
    }
    return $res;
}

function checkastlogin($aloginemail, $alogpassword, $ip, $url) {
    global $db;

    $chk = FETCH_all("SELECT `email`,`password`,`status`,`asid` FROM `assitors` WHERE `email`=?", $aloginemail);
   
    if ($chk['status'] == '1') {
        if ($chk['password'] == $alogpassword) {
            $_SESSION['AFUID'] = $chk['asid'];
            $stmt1 = pFETCH('INSERT INTO `cus_history` (`CusID`,`Logintime`,`Loginvia`,`IP`) VALUES (?,?,?,?)', $chk['asid'], date('Y-m-d H:i:s'), $_SERVER['HTTP_USER_AGENT'], $ip);
            $res = 'sucess';
           // if ($_SESSION['GUEST_ID'] != '') {
            //    $ds = $db->prepare("DELETE FROM `guest` WHERE `id`=?");
            //    $ds->execute(array($_SESSION['GUEST_ID']));
            //    $ds = $db->prepare("DELETE FROM `bill_ship_address` WHERE `Guest_ID`=?");
            //    $ds->execute(array($_SESSION['GUEST_ID']));
           // }
            header("location:" . $url);
            exit;
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Login details are incorrect</h4></div>';
        }
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4> Invalid Login Details</a></h4></div>';
    }
    return $res;
}



function signupp($fname, $mname, $lname, $address1, $address2, $city, $state, $zipcode, $country, $mobileno, $phoneno, $signupemail, $signuppassword, $newssubscribe, $ip) {
    global $db;
    global $fsitename;

    $chk = FETCH_all("SELECT * FROM `customer` WHERE `E-mail`=? OR `Mobile`=?", $signupemail, $mobileno);
    $chk2 = FETCH_all("SELECT `CusID` FROM `customer` WHERE `E-mail`=? AND `Status`=?", $signupemail, '1');

    if (($chk['CusID'] == '') && ($chk['E-mail'] == '') && ($chk['Mobile'] == '')) {
        $chk = $db->prepare("INSERT INTO `customer` (`FirstName`,`MiddleName`,`LastName`,`Adderss_1`,`Address_2`,`City`,`State`,`Postcode`,`Country`,`Mobile`,`Phone`,`E-mail`,`Password`,`IP`,`Status`,`signupvia`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $chk->execute(array($fname, $mname, $lname, $address1, $address2, $city, $state, $zipcode, $country, $mobileno, $phoneno, $signupemail, md5($signuppassword), $ip, '0', $_SERVER['HTTP_USER_AGENT']));
 $getregobject = getAllRecords('customer', "where  `E-mail`='" . $signupemail. "'", '0'); 

$getinsid = $db->lastInsertId();

//VerificationEmail($signupemail, $getinsid);

     
        if ($newssubscribe == '1') {
            $chk3 = FETCH_all("SELECT `id` FROM `newsletter` WHERE `email`=?", $signupemail);
            if ($chk3['id'] == '') {
                $chk = $db->prepare("INSERT INTO `newsletter` (`name`,`cusid`,`email`,`ip`) VALUES (?,?,?,?)");
                $chk->execute(array($fname, $_SESSION['FUID'], $signupemail, $ip));
            }
        } 

        $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
        $to = $general['recoveryemail'];

    $getactivationkey = time();

    //FETCH_all("UPDATE `customer` SET `activationkey`= ?  WHERE `CusID` = ?", $getactivationkey, $getinsid);

$ress = $db->prepare("UPDATE `customer` SET `activationkey`=? WHERE `CusID`= ?");
        $ress->execute(array($getactivationkey, $getinsid));

$ToEmail = $signupemail;

    $FromEmail = $general['recoveryemail'];

    $SUBJECT = "Welcome to  " . $general['Company_name'];


    $MESSAGE = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Registered - Click2buy.in</span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello ' . $fname . ' ' . $mname . ' ' . $lname . ',
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;" colspan="3">Thank you for Register with us</td>
                    </tr>
                     <tr>
                        <td style="padding:5px;" colspan="3">  <p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;" align="center">It is important that you are able to receive emails from us, because going forward we will be sending all correspondences to this email address.</p>                                            
                     </td>
                    </tr>
                    <tr>
                    <td><p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;">
                                                <a style="color: #fff; background: #1d748e;padding: 10px;border-radius: 3px;text-align: center; margin: 0 auto; display: table;text-decoration: none;" href="' . $fsitename . 'verification/emailverification/?suc=' . base64_encode(base64_encode($getinsid)) . '&activationkey=' . base64_encode(base64_encode($getactivationkey)) . '">Verify email address</a></p></td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

    //echo $MESSAGE;
    //exit;

    sendgridmail($ToEmail, $MESSAGE, $SUBJECT, $FromEmail, '', '');



      $subject = "New User Registered - Click2buy.in";

        $message = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Registered - Click2buy.in</span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello Admin,
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Name :</td>
                        <td style="padding:5px;" colspan="2">' . $fname . ' ' . $mname . ' ' . $lname . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Email :</td>
                        <td style="padding:5px;" colspan="2">' . $signupemail . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Contact Number :</td>
                        <td style="padding:5px;" colspan="2">' . $mobileno . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;" colspan="3">New user has been registered to our site today .Please provide proper services to our most valueable customer  .</td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

        sendgridmail($to, $message, $subject, $signupemail, '', '');

        /*  $to1 = $signupemail;
        $subject1 = "Thanks for Register with Click2buy";

        $message1 = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Registered - Click2buy.in</span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello ' . $fname . ' ' . $mname . ' ' . $lname . ',
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;" colspan="3">Thank you for Register with us</td>
                    </tr>



                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';
        sendgridmail($to1, $message1, $subject1, $general['recoveryemail'], '', ''); */
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Registered Successfully </h4></div>';
    } else {
        if (($chk['E-mail'] == $signupemail) && ($chk['Mobile'] == $mobileno))
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> E-mail Address And Mobile Number Already Exist</h4></div>';
        elseif ($chk['Mobile'] == $mobileno)
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Mobile Number Already Exist</h4></div>';
        elseif ($chk['E-mail'] == $signupemail)
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> E-mail Address Already Exist</h4></div>';
    }
    return $res;
}


function subscribe($email) {
    global $db;
    global $fsitename;

        $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
        $to = $general['recoveryemail'];

$ress = FETCH_all("SELECT * FROM `customer` WHERE `E-mail` = ?", $email);       

    $FromEmail = $general['recoveryemail'];


   $to1 = $email;
        $subject1 = "Thanks for Subscribing Newsletter with Click2buy";

        $message1 = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg" height="50px" border="0" />
                    </th>                    
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello ' . $ress['FirstName']. ' ' .$ress['MiddleName']. ' ' .$ress['LastName'] . ',
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;" colspan="3">Thank you for Subscribing Newsletter with us</td>
                    </tr>



                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

        sendgridmail($to1, $message1, $subject1,$FromEmail, '', '');        
    
  
}

function unsubscribe($email) {
    global $db;
    global $fsitename;

        $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
        $to = $general['recoveryemail'];   
$ToEmail = $email;

$ress = FETCH_all("SELECT * FROM `customer` WHERE `E-mail` = ?", $email);    

    $FromEmail = $general['recoveryemail'];


   $to1 = $signupemail;
        $subject1 = "Unsubscribed Newsletter with Click2buy";

        $message1 = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg" height="50px" border="0" />
                    </th>                   
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello ' . $ress['FirstName']. ' ' .$ress['MiddleName']. ' ' .$ress['LastName'] . ',
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;" colspan="3">You have Unsubscribed Our Newsletter</td>
                    </tr>



                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';
        sendgridmail($ToEmail, $message1, $subject1, $FromEmail, '', ''); 
      
}

function getAllRecords($tablename, $condition, $show) {//testing Completed
    global $db;
    if ($show == '1') {
        $get1 = "SELECT * FROM `$tablename` $condition ";
    } else {
        try {
            $get1 = $db->prepare("SELECT * FROM `$tablename` $condition ");
            $get1->execute();
        } catch (Exception $exc) {
            $get1 = '<div class="alert alert-danger"><button class="close" data-close="alert"></button>' . $exc . '</div>';
        }
    }
    return $get1;
}

function VerificationEmail($signupemail, $getinsid) {
   
    global $fsitename;
    if ($getinsid == '') {
        $getregobject = getAllRecords('customer', "where  `E-mail`='" . $signupemail . "'", '0');
    } else {
        $getregobject = getAllRecords('customer', "where `CusID`='" . $getinsid. "' and `E-mail`='" . $signupemail . "'", '0');
    }

    if (is_object($getregobject)) {
        $getRegisterRec = $getregobject->fetch(PDO::FETCH_ASSOC);
    }
    $getactivationkey = time();

    FETCH_all("UPDATE `customer` SET `activationkey`= ?  WHERE `CusID` = ?", $getactivationkey, $getinsid);

    $general = getAllRecords('manageprofile', "where  `pid`='1'", '0');

    $ToEmail = $signupemail;

    $FromEmail = $general['recoveryemail'];

    $SUBJECT = "Welcome to  " . $general['Company_name'];


    $MESSAGE = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Registered - Click2buy.in</span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello ' . $fname . ' ' . $mname . ' ' . $lname . ',
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;" colspan="3">Thank you for Register with us</td>
                    </tr>
                     <tr>
                        <td style="padding:5px;" colspan="3">  <p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;" align="center">It is important that you are able to receive emails from us, because going forward we will be sending all correspondences to this email address.</p>                                            
                     </td>
                    </tr>
                    <tr>
                    <td><p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;">
                                                <a style="color: #fff; background: #1d748e;padding: 10px;border-radius: 3px;text-align: center; margin: 0 auto; display: table;text-decoration: none;" href="' . $fsitename . 'verification/emailverification/?suc=' . base64_encode(base64_encode($getRegisterRec['CusID'])) . '&activationkey=' . base64_encode(base64_encode($getactivationkey)) . '">Verify email address</a></p></td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

    //echo $MESSAGE;
    //exit;

    sendgridmail($ToEmail, $MESSAGE, $SUBJECT, $FromEmail, '', '');
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="fa fa-check"></i> Submitted Successfully </h4></div>';
    return $res;
}


//
//function signupp($fname, $mname, $lname, $address1, $address2, $city, $state, $zipcode, $country, $mobileno, $phoneno, $signupemail, $signuppassword, $newssubscribe, $ip) {
//    global $db;
//    global $fsitename;
//
//    $chk = FETCH_all("SELECT `CusID` FROM `customer` WHERE `E-mail`=?", $signupemail);
//    $chk1 = FETCH_all("SELECT `CusID` FROM `customer` WHERE `Mobile`=?", $mobileno);
//    $chk2 = FETCH_all("SELECT `CusID` FROM `customer` WHERE `E-mail`=? AND `Status`=?", $signupemail, '1');
//
//    if ($chk['CusID'] == '') {
//        if ($chk1['CusID'] == '') {
//            if ($chk2['CusID'] == '') {
//
//                $chk = $db->prepare("INSERT INTO `customer` (`FirstName`,`LastName`,`MiddleName`,`Adderss_1`,`Address_2`,`City`,`State`,`Postcode`,`Country`,`Mobile`,`Phone`,`E-mail`,`Password`,`IP`,`Status`,`signupvia`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
//                $chk->execute(array($fname, $mname, $lname, $address1, $address2, $city, $state, $zipcode, $country, $mobileno, $phoneno, $signupemail, md5($signuppassword), $ip, '1', $_SERVER['HTTP_USER_AGENT']));
//
//                $_SESSION['FUID'] = $db->lastInsertId();
//
//                $chk3 = FETCH_all("SELECT `id` FROM `newsletter` WHERE `email`=?", $signupemail);
//                if ($chk3['id'] == '') {
//                    $chk = $db->prepare("INSERT INTO `newsletter` (`name`,`cusid`,`email`,`ip`) VALUES (?,?,?,?)");
//                    $chk->execute(array($fname, $_SESSION['FUID'], $signupemail, $ip));
//                }
//                $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
//                $to = $general['recoveryemail'];
//                $subject = "New User Registered - Click2buy.in";
//                
//                $message = '<table style="width:100%;height:100%">
//            <tbody>
//                <tr>
//                    <td align="center" valign="middle">
//                        <table style="border-top:10px solid #006db7;border-bottom:10px solid #006db7;background:#f3f3f3;font-family:sans-serif;font-size:12px" width="600" border="0" cellspacing="0" cellpadding="0">
//                            <tbody>
//                                <tr>
//                                    <td align="left" valign="top" colspan="3">
//                                        <table width="100%" border="0" cellspacing="0" cellpadding="10" bgcolor="#FFFFFF">
//                                            <tbody>
//                                                <tr>
//                                                    <td colspan="2" align="center" valign="top" bgcolor="#FFFFFF" width="50%">
//                                                        <h1>Click2buy</h1>
//                                                    </td>
//                                                </tr>
//                                            </tbody>
//                                        </table>
//                                    </td>
//                                </tr>
//                                <tr>
//                                    <td style="padding:10px" colspan="3">
//                                        <h4>Hello Admin,</h4>
//                                        <p>New User Registered</p>
//                                    </td>
//                                </tr>
//                                <tr>
//                                    <td style="padding:10px">
//                                        Name : 
//                                    </td>
//                                    <td style="padding:10px" colspan="2">' . $signupname . '</td>
//                                </tr>
//                                <tr>
//                                    <td style="padding:10px">
//                                        Email : 
//                                    </td>
//                                    <td style="padding:10px" colspan="2">' . $signupemail . '</td>
//                                </tr>
//                                <tr>
//                                    <td style="padding:10px">
//                                        Contact Number : 
//                                    </td>
//                                    <td style="padding:10px" colspan="2">' . $signupcontact . '</td>
//                                </tr>
//                                
//                                <tr>
//                                    <td bgcolor="#a0cc0e" colspan="3" style="color:#000000; padding:30px 10px; text-align:center;">FROM ' . $fsitename . '</td>
//                                </tr>
//                            </tbody>
//                        </table>
//                    </td>
//                </tr>
//            </tbody>
//        </table>';
//
//                sendoldmail($subject, $message, $signupemail, $to);
//
//                $to1 = '';
//                $subject1 = "Thanks for Register with Click2buy";
//                $message1 = '<table style="width:100%;height:100%">
//            <tbody>
//                <tr>
//                    <td align="center" valign="middle">
//                        <table style="border-top:10px solid #006db7;border-bottom:10px solid #006db7;background:#f3f3f3;font-family:sans-serif;font-size:12px" width="600" border="0" cellspacing="0" cellpadding="0">
//                            <tbody>
//                                <tr>
//                                    <td align="left" valign="top" colspan="3">
//                                        <table width="100%" border="0" cellspacing="0" cellpadding="10" bgcolor="#FFFFFF">

//                                            <tbody>
//                                                <tr>
//                                                    <td colspan="2" align="center" valign="top" bgcolor="#FFFFFF" width="50%">
//                                                        <h1>Click2buy </h1>
//                                                    </td>
//                                                </tr>
//                                            </tbody>
//                                        </table>
//                                    </td>
//                                </tr>
//                                <tr>
//                                    <td style="padding:10px" colspan="3">
//                                        <h4>Hello ' . $signupname . ',</h4>
//                                        <p>Thank you for Register with us</p>
//                                    </td>
//                                </tr>
//                                <tr>
//                                    <td style="padding:10px" colspan="3">
//                                        <!--Content Goes Here...-->
//                                    </td>
//                                </tr>
//                                
//                                <tr>
//                                    <td bgcolor="#a0cc0e" colspan="3" style="color:#000000; padding:30px 10px; text-align:center;">FROM ' . $fsitename . '</td>
//                                </tr>
//                            </tbody>
//                        </table>
//                    </td>
//                </tr>
//            </tbody>
//        </table>';
//
//                sendoldmail($subject1, $message1, $general['recoveryemail'],$to1 );
//
//                $res = 'sucess';
//            } else {
//                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4> Invalid Login Details</h4></div>';
//            }
//        } else {
//            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Contact Number Already Exist</h4></div>';
//        }
//    } else {
//        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> E-mail Address Already Exist</h4></div>';
//    }
//    return $res;
//}

function getcustomerlog($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `cus_history` WHERE `CusID`= ?  ORDER BY `Chid` DESC");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}



function updateprofile12($fname, $mname, $lname, $address1, $address2, $city, $state, $zipcode, $country, $mobileno, $phoneno, $signupemail, $unsubscribe, $newssubscribe, $ip,$image, $id) {
    global $db;
    if ($id != '') {
        if ($newssubscribe == '1') {
            $newsletter = '1';
        } elseif ($unsubscribe == '1') {
            $newsletter = '0';
        }
        $ress = $db->prepare("UPDATE `customer` SET `FirstName`=?,`LastName` =?,`MiddleName`=?,`Adderss_1`=?,`Address_2`=?,`City`=?,`State`=?,`Postcode`=?,`Country`=?,`Mobile`=?,`Phone`=?,`newsletter`=?,`IP`=?,`Image`=?,`Updated_type`=?  WHERE `CusID`= ?");
        $ress->execute(array($fname, $lname, $mname, $address1, $address2, $city, $state, $zipcode, $country, $mobileno, $phoneno,$newsletter, $ip,$image, '2', $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Please Login Again to Update...</h4></div>';
    }
    return $res;
}

function changepassword($newpassword, $ip, $newid) {
    global $db;

    $pass = md5($newpassword);



    $ress = pFETCH("UPDATE `customer` SET `Password`=? WHERE `CusID`=?", $pass, $newid);

    $getCustomer = FETCH_all("SELECT * FROM `customer`  WHERE `CusID`=?", $newid);

    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');

    $to = $general['recoveryemail'];

    $subject = "Change Password - Click2buy.in";
    $message = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                     <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">User Change Password  - Click2buy.in</span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello ' . $getCustomer['FirstName'] . ' ' . $getCustomer['MiddleName'] . ' ' . $getCustomer['LastName'] . ',
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding:5px;" colspan="3">Change your password in your acccount ..! </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    
<tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

    sendgridmail($getCustomer['E-mail'], $message, $subject, $to, '', '');



    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    return $res;
}

function forgetpassword($loginemail, $ip) {
    global $db;
    global $fsitename;
    $rand = mt_rand(100000, 999999);

    $cus = FETCH_all("SELECT * FROM `customer` WHERE `E-mail`=?", $loginemail);

    if ($cus['CusID'] != '') {

        $ress = pFETCH("UPDATE `customer` SET `otp`=? WHERE `E-mail`=?", $rand, $loginemail);


        $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');

        $to = $loginemail;
        $from = $general['recoveryemail'];

        $subject = "Forget Password - Click2buy";

        $message = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">Account Reset Password link</span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello  <br /><br /> You have a Forget Password link <br />
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="height:20px;" colspan="3">Click the link to change the Password : <a class="btn btn-success" href="' . $fsitename . 'forgetpassword-' . base64_encode($rand) . '/' . base64_encode($cus['CusID']) . '/resetpassword.htm" target="_blank">Reset Password</a></td>                        
                    </tr> 
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px; vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

        sendgridmail($to, $message, $subject, $from, '', '');

        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Forget Password Link sent to your mail. Please check now ...!</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4>Your Account not exist ...! </h4></div>';
    }
    return $res;
}

function forgetpassword45($loginemail, $ip) {
    global $db;
    $rand = mt_rand(100000, 999999);
    $ress = pFETCH("UPDATE `customer` SET `otp`=? WHERE `E-mail`=?", $rand, $loginemail);

    $cus = FETCH_all("SELECT * FROM `customer` WHERE `E-mail`=?", $loginemail);

    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
    $from = $general['recoveryemail'];
    $subject = "Reset Password - Click2buy";

    $message = '<table style="width:100%;height:100%">
            <tbody>
                <tr>
                    <td align="center" valign="middle">
                        <table style="border-top:10px solid #006db7;border-bottom:10px solid #006db7;background:#f3f3f3;font-family:sans-serif;font-size:12px" width="600" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td align="left" valign="top" colspan="3">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="10" bgcolor="#FFFFFF">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" align="center" valign="top" bgcolor="#FFFFFF" width="50%">
                                                        <h1>CLICK2BUY </h1>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px" colspan="3">
                                        <h4>Hi ' . $cus['FirstName'] . ',</h4>
                                        <p>if you did not made this request then Please contact admin.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px" colspan="3"> Click the link to change the Password : <a href="https://www.everestgifts.com.au/' . $rand . '/' . base64_encode($loginemail) . '/resetpassword.htm" target="_blank">Reset Password</a>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td bgcolor="#a0cc0e" colspan="3" style="color:#000000; padding:30px 10px; text-align:center;">FROM Click2buy</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';

    sendoldmail($subject, $message, $from, $loginemail);

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Reset Password Link sent to your mail</h4></div>';

    return $res;
}

function updateaddress($myfirstname, $mylastname, $myemail, $mymobile, $myaddress1, $myaddress2, $mycity, $mypostcode, $mystate, $mycountry, $sfirstname, $slastname, $semail, $smobile, $saddress1, $saddress2, $scity, $spostcode, $sstate, $scountry, $ip, $id) {
    global $db;
    if ($id != '') {
        $ress = $db->prepare("UPDATE `bill_ship_address` SET `bfirstname`=?,`blastname` =?, `bemail`=?, `bphone`=?, `baddress1`=?,`baddress2`=?,`bcity`=?,`bstate`=?,`bcountry`=?,`bpostcode`=?,`sfirstname`=?,`slastname`=?,`semail`=?,`sphone`=?,`saddress1`=?,`saddress2`=?,`scity`=?,`sstate`=?,`scountry`=?,`spostcode`=?  WHERE `CusID`= ?");
        $ress->execute(array($myfirstname, $mylastname, $myemail, $mymobile, $myaddress1, $myaddress2, $mycity, $mystate, $mycountry, $mypostcode, $sfirstname, $slastname, $semail, $smobile, $saddress1, $saddress2, $scity, $sstate, $scountry, $spostcode, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Please Login Again to Update...</h4></div>';
    }
    return $res;
}

function mailcart($orderid) {
    global $db;
    if ($orderid != '') {
        $res = '<table style="width:100%; font-size:13px;" cellpadding="5">
                            <thead>
                                <tr style="background:#cc6600; color:#FFF;">
                                    <th style="width:40%; text-align:left;">Item Name</th>                                   
                                    <th style="width:15%; text-align:left;">Unit Price</th>
                                    <th style="width:15%; text-align:left;">Qty</th>
                                    <th style="width:15%; text-align:left;">Total Price</th>
                                </tr>
                            </thead><tbody>';
        $ooor = pFETCH("SELECT * FROM `order` WHERE `Order_id`=?", $orderid);
        while ($foo = $ooor->fetch(PDO::FETCH_ASSOC)) {
            $res .= '<tr>
                <td>' . stripslashes($foo['product_name']) . '</td>                
                <td align="right">' . number_format($foo['product_price'], '2', '.', '') . '</td>
                <td align="center">' . $foo['product_qty'] . '</td>
                <td align="right">' . number_format($foo['product_total_price'], '2', '.', '') . '</td>
            </tr>';
        }
        $res .= '<tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>';
    }
    return $res;
}

function getcustomer1($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `customer` WHERE `CusID`= ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

function getguest1($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `guest` WHERE `id`= ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

function addtestimonial($name, $email, $phone, $comment, $ip) {
    global $db;
    $resa = $db->prepare("INSERT INTO `testimonial` ( `title`, `comments`,`email`,`phoneno`,`ip`, `updated_by` ) VALUES(?,?,?,?,?,?)");
    //$resa = $db->prepare("INSERT INTO `testimonial` ( `title`=?, `comments`=?,`order`=?,`status`=?,`ip`=?, `Updated_by`=? );
    $resa->execute(array($name, $comment, $email, $phone, $ip, $_SESSION['UID']));
    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
    $to = $general['recoveryemail'];
    $subject = "Your New Testimonial From  " . $name;
    $message = '<table style="height:100%; width:100%">
	<tbody>
		<tr>
			<td>
			<table border="0" cellpadding="0" cellspacing="0" style="width:600px">
				<tbody>
					<tr>
						<td colspan="3">
						<table border="0" cellpadding="10" cellspacing="0" style="width:100%">
							<tbody>
								<tr>
									<td colspan="2">
									<h1>EVEREST GIFTS</h1>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td colspan="3">
						<p>Hello Admin,</p>

						<p>You have a New Testimonial</p>
						</td>
					</tr>
					<tr>
						<td>Name :</td>
						<td colspan="2">' . $name . '</td>
					</tr>
					<tr>
						<td>Email :</td>
						<td colspan="2">' . $email . '</td>
					</tr>
					
					<tr>
						<td>Contact Number :</td>
						<td colspan="2">' . $phone . '</td>
					</tr>
					<tr>
						<td>Message :</td>
						<td colspan="2">' . $comment . '</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:center">FROM Click2buy</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
';

    sendoldmail($subject, $message, $email, $to);

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="fa fa-check"></i> Successfully Inserted</h4></div>';

    return $res;
}


?>