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
            $comp = $db->prepare("SELECT * FROM `companies` WHERE `username`=? AND `status`=?");
            $comp->execute(array($a, 1));
            $comp_res = $comp->fetch(PDO::FETCH_ASSOC);
            if ($ress['id'] != '') {
                if ($ress['val2'] == md5($b)) {
                    $res = "Hurray! You will redirect into dashboard soon";
                    $_SESSION['UID'] = $ress['id'];
                    $_SESSION['PROJECT_NAME'] = 'LEO-AGRI';
                    $_SESSION['COM_ID'] = $ress['id'];
                    $_SESSION['COMPANY_ID'] = "0";
                    $_SESSION['type'] = 'admin';
                    $_SESSION['company_type'] = 'admin';
                    @extract($ress);
                    if ($id != '') {
                        $e = date('Y-m-d H:i:s');
                        $sql = 'INSERT INTO `admin_history`(admin_uid,ip,checkintime,`company_id`) VALUES(?,?,?,?)';
                        $stmt1 = $db->prepare($sql);
                        $stmt1->execute(array($id, $c, $e, $_SESSION['COMPANY_ID']));
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
            } else if ($comp_res['id'] != '') {
                if ($comp_res['password'] == $b) {
                    $res = "Hurray! You will redirect into dashboard soon";
                    $_SESSION['UID'] = $comp_res['id'];
                    $_SESSION['COM_ID'] = $comp_res['id'];
                    $_SESSION['COMPANY_ID'] = $comp_res['id'];
                    $_SESSION['type'] = 'company';
                    $_SESSION['company_type'] = 'company';
                } elseif ($comp_res['status'] == '2') {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Your Account was deactivated by Admin</div>';
                } else {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Email or Password was incorrect</div>';
                }
            } else {
                //$sql = DB_QUERY("SELECT * FROM `usermaster` WHERE `username`='" . $a . "'");
                $stmt2 = $db->prepare("SELECT * FROM `usermaster` WHERE `userid`=?");
                $stmt2->execute(array($a));
                $sql = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($sql['uid'] != '') {
                    if ($sql['status'] == '1') {
                        // $per = DB_QUERY("SELECT `pid`,`status` FROM `permission` WHERE `pid`='" . $sql['permissiongroup'] . "'");
                        $stmt3 = $db->prepare("SELECT * FROM `permission` WHERE `pid`=?");
                        $stmt3->execute(array($sql['permissiongroup']));
                        $per = $stmt3->fetch(PDO::FETCH_ASSOC);
                        if ($per['status'] == '1') {
                            if (($a == $sql['userid']) && (md5($b) == $sql['password'])) {
                                $_SESSION['UID'] = $sql['uid'];
                                $_SESSION['PROJECT_NAME'] = 'LEO-AGRI';
                                $_SESSION['COM_ID'] = getpermission('last_upd_by', $sql['permissiongroup']);
                                $_SESSION['COMPANY_ID'] = $sql['company_id'] == '0' ? "0" : $sql['company_id'];
                                $_SESSION['company_type'] = $sql['company_id'] == '0' ? 'admin' : 'company';
                                $_SESSION['UIDD'] = $sql['userid'];
                                $_SESSION['USER_APPROVE'] = $sql['approve'];
                                $_SESSION['permissionid'] = $sql['permissiongroup'];
                                $_SESSION['type'] = 'user';
                                $res = "User";
                            }
                        } else {
                            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i>Access denied !</div>';
                        }
                    } else {
                        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i>Your account is Inactive!</div>';
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
function addprofile($z, $a, $b, $l, $m, $address1, $address2, $state, $city, $postcode, $country, $n, $o, $v, $p, $q, $r, $s, $t, $u, $c, $d, $e, $f, $ci, $g, $h, $i, $j, $margin, $margin_type, $terms, $tax, $default_tax, $mail_type, $mailer_host, $mailer_secure, $mailer_port, $mailer_username, $mailer_password, $sendgrid_username, $sendgrid_password, $digit, $k)
{
    global $db;
    if ($_SESSION['UID'] != '') {
        //$ress = DB_QUERY("SELECT `pid` FROM `manageprofile` WHERE `uid`='" . $_SESSION['UID'] . "'");
        $ress1 = $db->prepare("SELECT `pid` FROM `manageprofile` WHERE `uid`=?");
        $ress1->execute(array($_SESSION['UID']));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['pid'] == '') {
            //$resa = mysql_query("INSERT INTO `manageprofile` (`title`,`recoveryemail`,`phonenumber`,`senderid`,`password`,`securityanswer2`,`image`,`firstname`,`uid`,`lastname`,`onlinestatus`,`ip`) VALUES ('" . $z . "','" . $a . "','" . $b . "','" . $c . "','" . $d . "','" . $e . "','" . $f . "','" . $g . "','" . $h . "','" . $i . "','" . $j . "','" . $k . "')");
            $resa = $db->prepare("INSERT INTO `manageprofile` (`title`,`recoveryemail`,`phonenumber`,`Company_name`,`Company_reg`,`Adderss1`,`Adderss2`,`State`,`City`,`Country`,`Postcode`,`gst`,`currency`,`Bank_name`,`Branch_name`,`Acc_hold`,`Acc_no`,`ifsc_code`,`swift_code`,`notes`,`senderid`,`password`,`securityanswer2`,`image`,`cimage`,`firstname`,`uid`,`lastname`,`onlinestatus`,`margin`,`margin_type`,`tax`,`default_tax`,`mail_type`,`mailer_username`,`mailer_password`,`mailer_host`,`mailer_secure`,`mailer_port`,`sendgrid_username`,`sendgrid_password`,`digit`,`ip`,`terms`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($z, $a, $b, $l, $m, $address1, $address2, $state, $city, $postcode, $country, $n, $o, $v, $p, $q, $r, $s, $t, $u, $c, $d, $e, $f, $ci, $g, $h, $i, $j, $margin, $margin_type, $tax, $default_tax, $mail_type, $mailer_username, $mailer_password, $mailer_host, $mailer_secure, $mailer_port, $sendgrid_username, $sendgrid_password, $digit, $k, $terms));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4><!--<a href="' . $sitename . 'settings/addunitmeasurementmaster.htm">Add another one</a>--></div>';
        } else {
            // $resa = mysql_query("UPDATE `manageprofile` SET `title`='" . $z . "',`recoveryemail`='" . $a . "',`phonenumber`='" . $b . "',`senderid`='" . $c . "',`password`='" . $d . "',`securityanswer2`='" . $e . "',`image`='" . $f . "',`firstname`='" . $g . "',`uid`='" . $h . "',`lastname`='" . $i . "',`onlinestatus`='" . $j . "',`ip`='" . $k . "' WHERE `uid`='" . $_SESSION['UID'] . "'");
            $resa = $db->prepare("UPDATE `manageprofile` SET `title`=?,`recoveryemail`=?,`phonenumber`=?,`Company_name`=?,`Company_reg`=?,`Adderss1`=?,`Adderss2`=?, `State`=?,`City`=?,`Country`=?,`Postcode`=?,`gst`=?,`currency`=?,`Bank_name`=?,`Branch_name`=?,`Acc_hold`=?,`Acc_no`=?,`ifsc_code`=?,`swift_code`=?,`notes`=?,`senderid`=?,`password`=?,`securityanswer2`=?,`image`=?,`cimage`=?,`firstname`=?,`uid`=?,`lastname`=?,`onlinestatus`=?,`margin`=?,`margin_type`=?,`tax`=?,`default_tax`=?,`mail_type`=?,`mailer_username`=?,`mailer_password`=?,`mailer_host`=?,`mailer_secure`=?,`mailer_port`=?,`sendgrid_username`=?,`sendgrid_password`=?,`digit`=?,`ip`=?,`terms`=? WHERE `uid`=?");
            $resa->execute(array($z, $a, $b, $l, $m, $address1, $address2, $state, $city, $country, $postcode, $n, $o, $v, $p, $q, $r, $s, $t, $u, $c, $d, $e, $f, $ci, $g, $h, $i, $j, $margin, $margin_type, $tax, $default_tax, $mail_type, $mailer_username, $mailer_password, $mailer_host, $mailer_secure, $mailer_port, $sendgrid_username, $sendgrid_password, $digit, $k, $terms, $_SESSION['UID']));
            if ($margin != '') {
                if ($margin_type == '1') {
                    $upd = $db->prepare("UPDATE `item_master` SET `Margin`=? WHERE `company_id`=?");
                    $upd->execute(array($margin, $_SESSION['COMPANY_ID']));
                } elseif ($margin_type == '2') {
                    $upd = $db->prepare("UPDATE `item_master` SET `Margin`=? WHERE IFNULL(`Margin`,'0')=? AND `company_id`=?");
                    $upd->execute(array($margin, '0', $_SESSION['COMPANY_ID']));
                }
            }
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
        }
    }
    unset($_SESSION['CD']);
    return $res;
}
function getprofile($a, $b = '')
{
    global $db;
    if ($_SESSION['company_type'] == 'company') {
        $field_changes = array(
            'image' => 'logo',
            'cimage' => 'logo',
            'Company_name' => 'company_name',
            'phonenumber' => 'phone_number',
            'Company_reg' => 'company_reg_no',
            'recoveryemail' => 'email_address',
            'Address1' => 'address1',
            'Address2' => 'address2',
            'City' => 'city',
            'State' => 'state',
            'Country' => 'country',
            'Bank_name' => 'bank_name',
            'Branch_name' => 'branch_name',
            'Acc_hold' => 'acc_hold',
            'Acc_no' => 'acc_no',
            'firstname' => 'contact_name',
        );
        $fields = [];
        foreach ($field_changes as $new_field => $field) {
            $fields[] = "`$field` AS `$new_field`";
        }
        $get1 = $db->prepare("SELECT *," . implode(',', $fields) . " FROM `companies` WHERE `id`=?");
        $b = $_SESSION['COMPANY_ID'];
    } else {
        $get1 = $db->prepare("SELECT * FROM `manageprofile` WHERE `pid`=?");
        $b = 1;
    }
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function admin_currency($curr)
{
    global $db;
    if ($_SESSION['company_type'] == 'admin') {
        $sql = $db->prepare("UPDATE `manageprofile` SET `currency_mgnt` = ?  WHERE `pid` = ? ");
        $sql->execute(array(implode(",", $curr), "1"));
    } else if ($_SESSION['company_type'] == 'company') {
        $sql = $db->prepare("UPDATE `companies` SET `currency_mgnt` = ?  WHERE `id` = ? ");
        $sql->execute(array(implode(",", $curr), $_SESSION['COMPANY_ID']));
    }
    /* $cus = $db->prepare("SELECT * FROM `currency_new` WHERE `id` IN (" . getprofile('currency_mgnt') . ")");
    $cus->execute();
    $trunc = $db->prepare("TRUNCATE TABLE `currency_rates`");
    $trunc->execute();
    $currat = $db->prepare("INSERT INTO `currency_rates` SET `name`= ? , `value` = ? ");
    while ($fcu = $cus->fetch()) {
    $currsy = currencycv("MYR", $fcu['code'], 1);
    $currat->bindParam(1, $fcu['code']);
    $currat->bindParam(2, $currsy);
    $currat->execute();
    } */
    update_currency_rates();
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
    return $res;
}
function update_currency_rates()
{
    global $db;
    /* $cus = $db->prepare("SELECT * FROM `currency_new` WHERE `id` IN (" . getprofile('currency_mgnt') . ")");
    $cus->execute();
    $trunc = $db->prepare("TRUNCATE TABLE `currency_rates`");
    $trunc->execute();
    $currat = $db->prepare("INSERT INTO `currency_rates` SET `name`= ? , `value` = ? ");
    while ($fcu = $cus->fetch()) {
    $currsy = currencycv("MYR", $fcu['code'], 1);
    $currat->bindParam(1, $fcu['code']);
    $currat->bindParam(2, $currsy);
    $currat->execute();
    } */
    update_new_rates();
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
    return $res;
}
function currencycv_old_yahoo_csv($from_Currency, $to_Currency, $amount)
{
    $from = $from_Currency;
    $to = $to_Currency;
    $url = 'http://finance.yahoo.com/d/quotes.csv?f=l1d1t1&s=' . $from . $to . '=X';
    $handle = fopen($url, 'r');
    if ($handle) {
        $result = fgetcsv($handle);
        fclose($handle);
    }
    return $result[0];
}
function currencycv($from_Currency, $to_Currency, $amount)
{
    $from = $from_Currency;
    $to = $to_Currency;
    if ($from != $to) {
        if ($_SESSION['currency_rates'][$from . '_' . $to] != '') {
            return $_SESSION['currency_rates'][$from . '_' . $to];
        } else {
            $url = "https://api.fixer.io/latest?base=" . $from . "&symbols=" . $to;
            $handle = file_get_contents($url);
            $data = json_decode($handle, true);
            if ($data['rates'][$to] != '') {
                return $data['rates'][$to];
            } else {
                $data = file_get_contents('http://www.xe.com/currencyconverter/convert/?Amount=1&From=' . $from . '&To=' . $to);
                preg_match("/<span class='uccResultAmount'>(.+?)<\/span>/i", $data, $matches);
                $newprce = explode(' ', $matches[1]);
                $newprce = ($newprce[0] != '') ? $newprce[0] : '0';
                if ($newprce == '0') {
                    $data = file_get_contents('https://finance.google.com/finance/converter?a=1&from=' . $from . '&to=' . $to);
                    preg_match("/<span class=bld>(.+?)<\/span>/i", $data, $matches);
                    $newprce = explode(' ', $matches[1]);
                    $newprce = ($newprce[0] != '') ? $newprce[0] : '0';
                }
                //$data = file_get_contents('https://finance.google.com/finance/converter?a=1&from='.$from.'&to='.$to);
                //preg_match("/<span class=bld>(.+?)<\/span>/i", $data, $matches);
                //$newprce = explode(' ',$matches[1]);
                return $newprce;
            }
        }
    } else {
        return '1';
    }
}
function currency_product($a, $b)
{
    global $db;
    $code = getcurrency_new('code', getprofile('currency'));
    $symbol = Currency($code);
    $cur_rate = $db->prepare("SELECT * FROM `currency_rates` WHERE `name` != ? ");
    $myr = "MYR";
    $cur_rate->execute(array($myr));
    while ($frate = $cur_rate->fetch()) {
        if ($code == $frate['name']) {
            $newvalue = $a * $frate['value'];
        }
    }
    if ($code == "MYR") {
        $newvalue = $a;
    }
    if ($b == 1) {
        $form_sym = $symbol . " ";
    }
    if ($b == 2) {
        $form_sym = $code . ' ' . $symbol;
    }
    if ($b == 3) {
        $form_sym = $symbol . " ";
    }
    if ($b == 4) {
        $form_sym = '';
    }
    if ($b == 5) {
        return $symbol;
    }if ($b == 6) {
        return $symbol . ' ' . $db_class->cur_format(round($newvalue)) . ' ' . $code;
    }
    //$newvalue="12345612";
    return $form_sym . $db_class->cur_format(round($newvalue));
}
function currency_product_rev($a, $b, $c = '')
{
    global $db_class;
    $code_sym = $db_class->getcurrency('code', $db_class->getstore('currency', $_SESSION['FRONT_STORE_ID']));
    $code = $code_sym;
    $symbol = $db_class->Currency($code_sym);
    $cur_rate = $db_class->db->prepare("SELECT * FROM `currency_rates` WHERE `name` != ? ");
    $cur_rate->bindParam(1, $usd);
    $usd = "USD";
    $cur_rate->execute();
    while ($frate = $cur_rate->fetch()) {
        if ($code == $frate['name']) {
            $newvalue = $a / $frate['value'];
            $_SESSION['revfvalue'] = $frate['value'];
        }
    }
    if ($b == 1) {
        $form_sym = $symbol . " ";
    }
    if ($b == 2) {
        $form_sym = $code . ' ' . $symbol;
    }
    if ($b == 3) {
        $form_sym = $symbol . " ";
    }
    if ($b == 4) {
        $form_sym = '';
    }
    //$newvalue="12345612";
    if ($c == 'db') {
        return round($newvalue);
    } else {
        return $form_sym . $db_class->cur_format(round($newvalue));
    }
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
    list($b, $c) = null_zero(array($b, $c));
    $b = 0;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `did` FROM `department` WHERE `company_id`=? AND `department`=? AND `status`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], trim($a), 2));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['did'] == '') {
            $resa = $db->prepare("INSERT INTO `department` (`department`,`order`,`status`,`ip`,`updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Department', 27, 'Insert', $_SESSION['UID'], $d, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Department</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `did` FROM `department` WHERE `company_id`=? AND `department`=? AND `status`!=? AND `did`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], trim($a), 2, $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['did'] == '') {
            $resa = $db->prepare("UPDATE `department` SET `department`=?,`order`=?,`status`=?,`ip`=?,`updated_by`=? WHERE `company_id`=? AND `did`=?");
            $resa->execute(array(trim($a), 0, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Department', 27, 'Update', $_SESSION['UID'], $d, $e, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `department` WHERE `company_id`=? AND `did`=? AND `status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Department', 1, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `department` WHERE `company_id`=? AND `did` =? ");
        $get->execute(array($$_SESSION['COMPANY_ID'], c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Department Section End */
/* Designation Section Start */
function adddesignation($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `id` FROM `designation` WHERE `company_id`=? AND `department_id`=? AND `designation`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $a, strtolower(trim($b))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['id'] == '') {
            $resa = $db->prepare("INSERT INTO `designation` (`department_id`,`designation`,`status`,`ip`,`updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array($a, strtolower(trim($b)), $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Designation', 28, 'Insert', $_SESSION['UID'], $d, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Designation</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `id` FROM `designation` WHERE `company_id`=? AND `department_id`=? AND `designation`=? AND `id`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $a, strtolower(trim($b)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['id'] == '') {
            $resa = $db->prepare("UPDATE `designation` SET `department_id`=?,`designation`=?,`status`=?,`ip`=?,`updated_by`=? WHERE `company_id`=? AND `id`=?");
            $resa->execute(array(trim($a), trim($b), $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Designation', '28', 'Update', $_SESSION['UID'], $d, $e, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Designation</h4></div>';
        }
    }
    return $res;
}
function getdesignation($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `designation` WHERE `company_id`=? AND `id`=? AND `status` != ?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function deldesignation($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Designation', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `designation` WHERE `company_id`=? AND `id` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    //$res=$b;
    return $res;
}
/* Designation Section End */
function addusers($username, $per_group, $userid, $password, $image, $approve, $status, $ip, $up_id)
{
    global $db;
    list($per_group, $status) = null_zero(array($per_group, $status));
    if ($up_id == '') {
        /*   $ress1 = $db->prepare("SELECT `did` FROM `usermaster` WHERE `department`=? AND `status`!=?");
        $ress1->execute(array(trim($a), 2));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['did'] == '') {
        $resa = $db->prepare("INSERT INTO `department` (`department`,`order`,`status`,`ip`,`updated_by`) VALUES (?,?,?,?,?)");
        $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Department', 27, 'Insert', $_SESSION['UID'], $d, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
        $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Department</h4></div>';
        } */
        //  echo 'mkkkk';
        $insert = $db->prepare("INSERT INTO `usermaster` (`username`,`permissiongroup`,`userid`,`password`,`changepwd`,`image`,`approve`,`status`,`ip`,`updated_by`,`sitelocid`,`company_id`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?)");
        $insert->execute(array($username, $per_group, $userid, md5($password), '', $image, $approve, $status, $ip, $_SESSION['UID'], '1', $_SESSION['COMPANY_ID']));
        //  echo 'kumar';exit;
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        /*  $ress1 = $db->prepare("SELECT `did` FROM `department` WHERE `department`=? AND `status`!=? AND `did`!=?");
        $ress1->execute(array(trim($a), 2, $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['did'] == '') {
        $resa = $db->prepare("UPDATE `department` SET `department`=?,`order`=?,`status`=?,`ip`=?,`updated_by`=? WHERE `did`=?");
        $resa->execute(array(trim($a), 0, $c, $d, $_SESSION['UID'], $e));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Department', 27, 'Update', $_SESSION['UID'], $d, $e));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
        $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Department</h4></div>';
        } */
        if ($password != '') {
            $insert = $db->prepare("UPDATE `usermaster` SET `username`=? ,`permissiongroup`=? ,`userid`=? ,`password`=?,`changepwd`=?,`image`=?, `approve`=? ,`status`=?,`ip`=?,`updated_by`=?,`sitelocid`=? WHERE `company_id`=? AND `uid`=? ");
            $insert->execute(array($username, $per_group, $userid, md5($password), '', $image, $approve, $status, $ip, $_SESSION['UID'], '1', $_SESSION['COMPANY_ID'], $up_id));
        } else {
            $insert = $db->prepare("UPDATE `usermaster` SET `username`=? ,`permissiongroup`=? ,`userid`=?,`image`=?, `approve`=? ,`status`=?,`ip`=?,`updated_by`=?,`sitelocid`=?  WHERE `company_id`=? AND `uid`=?  ");
            $insert->execute(array($username, $per_group, $userid, $image, $approve, $status, $ip, $_SESSION['UID'], '1', $_SESSION['COMPANY_ID'], $up_id));
        }
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}
function getusers($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `usermaster` WHERE `company_id`=? AND `uid`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delusers($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Department', 1, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `usermaster` WHERE `company_id`=? AND `uid` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Supplier Group Start */
function addsupplier_group($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    list($b, $c) = null_zero(array($b, $c));
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `SgID` FROM `supplier_group` WHERE  `company_id`=? AND `SupplierGroup`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SgID'] == '') {
            $resa = $db->prepare("INSERT INTO `supplier_group` (`SupplierGroup`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Supplier Group', 2, 'Insert', $_SESSION['UID'], $d, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Supplier Group</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `SgID` FROM `supplier_group` WHERE `company_id`=? AND `SupplierGroup`=? AND `SgID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SgID'] == '') {
            $resa = $db->prepare("UPDATE `supplier_group` SET `SupplierGroup`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=?  WHERE `company_id`=? AND `SgID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Supplier Group', 2, 'Update', $_SESSION['UID'], $d, $e, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `supplier_group` WHERE `company_id`=? AND `SgID`=? AND `status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Supplier Group', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `supplier_group` WHERE `company_id`=? AND `SgID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Supplier Group Ends */
/* Suppliers Starts */
function addsupplier($suppliername, $supplier_company, $supplier_code, $invoice_name, $currrency, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $suppliergroup, $img, $description, $bankname, $branch, $accname, $accno, $ifsccode, $swiftcode, $note, $status, $order, $taxtype, $paymentterm, $paymentmode, $ip, $group, $sub_group, $id)
{
    global $db;
    list($currrency, $credit, $suppliergroup, $status, $order, $ip) = null_zero(array($currrency, $credit, $suppliergroup, $status, $order, $ip));
    $credit = ($credit) ? $credit : 0;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `SupID` FROM `suppliers` WHERE (`Company`=?) AND `company_id`=?");
        $ress1->execute(array($supplier_company, $_SESSION['COMPANY_ID']));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SupID'] == '') {
            $resa = $db->prepare("INSERT INTO `suppliers` (`Supplier_name`, `Company`, `Supplier_code`,`Invoice_name`,`Currency`, `Adderss_1`, `Address_2`, `State`, `City`, `Postcode`, `Country`, `E-mail`, `Website`, `Mobile`, `Phone`, `GSTNum`, `Credit`, `Creditdate`, `SupplierGroup`, `Image`, `Description`,`Bank_name`,`Branch_name`,`Account_name`,`Account_no`,`IFSC_code`,`SWIFT_Code`,`notes`, `Status`,`Order`,`TaxType`,`paymentterm`,`paymentmode`, `IP`, `Updated_by`,`group`,`subgroup`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($suppliername, $supplier_company, $supplier_code, $invoice_name, $currrency, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $suppliergroup, $img, $description, $bankname, $branch, $accname, $accno, $ifsccode, $swiftcode, $note, $status, $order, $taxtype, $paymentterm, $paymentmode, $ip, $_SESSION['UID'], implode(',', array_unique($group)), implode(',', array_unique($sub_group)), $_SESSION['COMPANY_ID']));
            $insert_id1 = $db->lastInsertId();
            update_bill_value('15');
            $resa = $db->prepare("INSERT INTO `ledger` (`Name`, `printname` ,`under`,`sub_under`, `status`,`supplier_id`,`Order` ,`IP` ,`Updated_By`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($supplier_company, $supplier_company, '16', '0', '1', $insert_id1, $order, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $supupdate = $db->prepare("UPDATE `suppliers` SET `Ledger_id`=? WHERE `SupID`=? ");
            $supupdate->execute(array($insert_id, $insert_id1));
            /* if (!empty($Item_name)) {
            foreach ($Item_name as $item_n) {
            $os = explode(',', getitem('supplier_id', $item_n));
            if (!in_array($insert_id, $os)) {
            $os[] = $insert_id;
            }
            $upi = $db->prepare("UPDATE `item_master` SET `supplier_id`='" . implode(',', $os) . "' WHERE `Item_Id`=?");
            $upi->execute(array($item_n));
            }
            } */
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Supplier ', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id1, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Company Name or Email</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `SupID` FROM `suppliers` WHERE `company_id`=? AND (`Company`=?) AND `SupID` != ?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $supplier_company, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SupID'] == '') {
            $resa = $db->prepare("UPDATE `suppliers` SET `Supplier_name`=?, `Company`=?,`Supplier_code`=?,`Invoice_name`=?,`Currency`=?, `Adderss_1`=?, `Address_2`=?, `State`=?, `City`=?, `Postcode`=?, `Country`=?, `E-mail`=?, `Website`=?, `Mobile`=?, `Phone`=?, `GSTNum`=?, `Credit`=?, `Creditdate`=?, `SupplierGroup`=?, `Image`=?, `Description`=?,`Bank_name`=?,`Branch_name`=?,`Account_name`=?,`Account_no`=?,`IFSC_code`=?,`SWIFT_Code`=?,`notes`=?, `Status`=?,`Order`=?,`TaxType`=?,`paymentterm`=?,`paymentmode`=?, `IP`=?, `Updated_by`=?,`group`=?,`subgroup`=? WHERE `company_id`=? AND `SupID`=? ");
            $resa->execute(array($suppliername, $supplier_company, $supplier_code, $invoice_name, $currrency, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $suppliergroup, $img, $description, $bankname, $branch, $accname, $accno, $ifsccode, $swiftcode, $note, $status, $order, $taxtype, $paymentterm, $paymentmode, $ip, $_SESSION['UID'], implode(',', array_unique($group)), implode(',', array_unique($sub_group)), $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=?,`Order`=?,`ip`=? WHERE `company_id`=? AND `supplier_id`=?");
            $htry->execute(array($supplier_company, $supplier_company, $order, $ip, $_SESSION['COMPANY_ID'], $id));
            /* if (!empty($Item_name)) {
            foreach ($Item_name as $item_n) {
            $os = explode(',', getitem('supplier_id', $item_n));
            if (!in_array($id, $os)) {
            $os[] = $id;
            }
            $upi = $db->prepare("UPDATE `item_master` SET `supplier_id`='" . implode(',', $os) . "' WHERE `Item_Id`=?");
            $upi->execute(array($item_n));
            }
            } */
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Supplier', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Company Name or Email</h4></div>';
        }
    }
    unset($_SESSION['CD']);
    return $res;
}
function delsupplier($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    $err_del = array();
    foreach ($b as $c) {
        $gets = delledger(getsupplier('Ledger_id', $c));
        if ($gets[0] == '0') {
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Supplier ', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
            $get = $db->prepare("DELETE FROM `suppliers` WHERE `company_id`=? AND `SupID` =? ");
            $get->execute(array($_SESSION['COMPANY_ID'], $c));
        } else {
            $err_del[] = $c;
        }
    }
    if (!empty($err_del)) {
        foreach ($err_del as $ers) {
            $des .= getsupplier('Company', $ers) . ', ';
        }
        $des = 'Unable to Delete. ' . substr($des, 0, -2);
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> ' . $des . '. Supplier(s) have transactions</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    }
    unset($_SESSION['CD']);
    return $res;
}
function getsupplier($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `suppliers` WHERE `company_id`=? AND `SupID`=? AND `Status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
/* Suppliers End */
/* AGENT STARTS */
function getagent($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `agent` WHERE `company_id`=? AND `AID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function addagent($agent_name, $agent_code, $invoice_name, $currrency, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $img, $description, $status, $order, $ip, $id)
{
    global $db;
    $credit = ($credit) ? $credit : 0;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `AID` FROM `agent` WHERE `company_id`=? AND `Mobile`=? AND `Phone`=? AND `E-mail`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $mobile, $phone, $email));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['AID'] == '') {
            $resa = $db->prepare("INSERT INTO `agent` (`Agent_name`, `Agent_code`,`Invoice_name`,`Currency`, `Adderss_1`, `Address_2`, `State`, `City`, `Postcode`, `Country`, `E-mail`, `Website`, `Mobile`, `Phone`, `GSTNum`, `Credit`, `Creditdate`, `Image`, `Description`, `Status`,`Order`, `IP`, `Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($agent_name, $agent_code, $invoice_name, $currrency, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $img, $description, $status, $order, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id1 = $db->lastInsertId();
            $resa = $db->prepare("INSERT INTO `ledger` (`Name`, `printname` ,`under`,`sub_under`, `status`,`Agent_id`,`Order` ,`IP` ,`Updated_By`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($agent_name, $agent_name, '16', '0', '1', $insert_id1, $order, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $supupdate = $db->prepare("UPDATE `agent` SET `Ledger_id`=? WHERE `company_id`=?  AND `AID`=? ");
            $supupdate->execute(array($insert_id, $_SESSION['COMPANY_ID'], $insert_id1));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Agent ', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id1, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Agent or Agent name </h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `AID` FROM `agent` WHERE `company_id`=? AND `Mobile`=? AND `Phone`=? AND `E-mail`=? AND `AID` != ?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $mobile, $phone, $email, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['AID'] == '') {
            $resa = $db->prepare("UPDATE `agent` SET `Agent_name`=?, `Agent_code`=?,`Invoice_name`=?,`Currency`=?, `Adderss_1`=?, `Address_2`=?, `State`=?, `City`=?, `Postcode`=?, `Country`=?, `E-mail`=?, `Website`=?, `Mobile`=?, `Phone`=?, `GSTNum`=?, `Credit`=?, `Creditdate`=?,  `Image`=?, `Description`=?, `Status`=?,`Order`=?, `IP`=?, `Updated_by`=? WHERE `company_id`=? AND `AID`=? ");
            $resa->execute(array($agent_name, $agent_code, $invoice_name, $currrency, $address1, $address2, $state, $city, $postcode, $country, $email, $website, $mobile, $phone, $gstvalue, $credit, $creditdate, $img, $description, $status, $order, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=?,`Order`=?,`ip`=? WHERE `company_id`=? AND `Agent_id`=?");
            $htry->execute(array($agent_name, $agent_name, $order, $ip, $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Agent', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Agent or Agent Name </h4></div>';
        }
    }
    return $res;
}
function delagent($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    $err_del = array();
    foreach ($b as $c) {
        $gets = delledger(getagent('Ledger_id', $c));
        if ($gets[0] == '0') {
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Supplier ', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
            $get = $db->prepare("DELETE FROM `agent` WHERE `company_id`=? AND `AID` =? ");
            $get->execute(array($_SESSION['COMPANY_ID'], $c));
        } else {
            $err_del[] = $c;
        }
    }
    if (!empty($err_del)) {
        foreach ($err_del as $ers) {
            $des .= getagent('Agent_name', $ers) . ', ';
        }
        $des = 'Unable to Delete. ' . substr($des, 0, -2);
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> ' . $des . ' Agent(s) have transactions</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* AGENT ENDS */
/* Item Group Start */
function additem_group($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    list($b, $c) = null_zero(array($b, $c));
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `ItemID` FROM `item_group` WHERE `company_id`=? AND `ItemGroup`=?");
        $ress1->execute(array(trim($_SESSION['COMPANY_ID']), trim($a)));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("INSERT INTO `item_group` (`ItemGroup`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Item Group', 2, 'Insert', $_SESSION['UID'], $d, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Group</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `ItemID` FROM `item_group` WHERE `company_id`=? AND `ItemGroup`=? AND `ItemID`!=?");
        $ress1->execute(array(strtolower($_SESSION['COMPANY_ID']), trim($a), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("UPDATE `item_group` SET `ItemGroup`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `ItemID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Item Group', 2, 'Update', $_SESSION['UID'], $d, $e, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `item_group` WHERE `company_id`=? AND `ItemID`=? AND `status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Item Group', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `item_group` WHERE `company_id`=? AND `ItemID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Item Group Ends */
/* Item Type Start */
function additem_type($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    list($b, $c) = null_zero(array($b, $c));
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `ItemID` FROM `item_type` WHERE `company_id`=? AND `ItemType`=?");
        $ress1->execute(array(strtolower($_SESSION['COMPANY_ID']), trim($a)));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("INSERT INTO `item_type` (`ItemType`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Item Type', 2, 'Insert', $_SESSION['UID'], $d, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Type</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `ItemID` FROM `item_type` WHERE `company_id`=? AND `ItemType`=? AND `ItemID`!=?");
        $ress1->execute(array(strtolower($_SESSION['COMPANY_ID']), trim($a), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("UPDATE `item_type` SET `ItemType`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `ItemID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Item Type', 2, 'Update', $_SESSION['UID'], $d, $e, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `item_type` WHERE `company_id`=? AND `ItemID`=? AND `status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Item Group', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `item_type` WHERE  `company_id`=? AND `ItemID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Item Type Ends */
/* Manufacturer Start */
function addmanufacturer($a = '', $b = '', $c = '', $d = '', $e = '')
{
    global $db;
    list($b, $c) = null_zero(array($b, $c));
    if ($e == '') {
        $ress1 = $db->prepare("SELECT `MID` FROM `manufacturer` WHERE `company_id`=? AND `Manufacturer`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], strtolower(trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MID'] == '') {
            $resa = $db->prepare("INSERT INTO `manufacturer` (`Manufacturer`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Manufacurer', 2, 'Insert', $_SESSION['UID'], $d, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Manufacturer</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `MID` FROM `manufacturer` WHERE `company_id`=? AND `Manufacturer`=? AND `MID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MID'] == '') {
            $resa = $db->prepare("UPDATE `manufacturer` SET `Manufacturer`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `MID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Manufacturer', 2, 'Update', $_SESSION['UID'], $d, $e, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `manufacturer` WHERE `company_id`=? AND `MID`=? AND `Status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Manufacturer', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `manufacturer` WHERE `company_id`=? AND `MID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
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
        $ress1 = $db->prepare("SELECT `ShipID` FROM `shipping_type` WHERE `company_id`=? AND `ShippingType`=?");
        $ress1->execute(array(strtolower($_SESSION['COMPANY_ID'], trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ShipID'] == '') {
            $resa = $db->prepare("INSERT INTO `shipping_type` (`ShippingType`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Shipping Type', 2, 'Insert', $_SESSION['UID'], $d, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Shipping Type</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `ShipID` FROM `shipping_type` WHERE `company_id`=? AND `ShippingType`=? AND `ItemID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') {
            $resa = $db->prepare("UPDATE `shipping_type` SET `ShippingType`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `ItemID`=?");
            $resa->execute(array(trim($a), $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Shipping Type', 2, 'Update', $_SESSION['UID'], $d, $e, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `shipping_type` WHERE `company_id`=? AND `ShipID`=? AND `status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Shipping Group', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `shipping_type` WHERE `company_id`=? AND  `ShipID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Shipping Type Ends */
/* Warehouse Start */
function addwarehouse($a = '', $b = '', $c = '', $d = '', $e = '', $f = '', $g = '')
{
    global $db;
    list($d, $e) = null_zero(array($d, $e));
    if ($g == '') {
        $ress1 = $db->prepare("SELECT `WhID` FROM `warehouse` WHERE `company_id`=? AND `Warehouse_Code`=?");
        $ress1->execute(array(strtolower($_SESSION['COMPANY_ID']), trim($b)));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['WhID'] == '') {
            $resa = $db->prepare("INSERT INTO `warehouse` (`Warehouse_Name`,`Warehouse_Code`,`Description`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?)");
            $resa->execute(array($a, $b, $c, $d, $e, $f, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Warehouse', 10, 'Insert', $_SESSION['UID'], $f, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Warehouse Code Exist</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `WhID` FROM `warehouse` WHERE `company_id`=? AND `Warehouse_Code`=? AND `WhID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $b, $g));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['WhID'] == '') {
            $resa = $db->prepare("UPDATE `warehouse` SET `Warehouse_Name`=?,`Warehouse_Code`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `WhID`=?");
            $resa->execute(array($a, $b, $c, $d, $e, $f, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $g));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Warehouse', 10, 'Update', $_SESSION['UID'], $f, $g, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `warehouse` WHERE `company_id`=? AND `WhID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Warehouse', 10, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `warehouse` WHERE `company_id`=? AND `WhID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
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
        $ress1 = $db->prepare("SELECT `Partner_id` FROM `partner_type` WHERE `company_id`=? AND `Partner_type`=?");
        $ress1->execute(array(strtolower($_SESSION['COMPANY_ID'], trim($a))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['Partner_id'] == '') {
            $resa = $db->prepare("INSERT INTO `partner_type` (`Partner_type`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array($a, $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Partner Type', 13, 'Insert', $_SESSION['UID'], $d, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Partner Type already Exist</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `Partner_id` FROM `partner_type` WHERE `company_id`=? AND `Partner_type`=? AND `Partner_id`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $a, $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['PID'] == '') {
            $resa = $db->prepare("UPDATE `partner_type` SET `Partner_type`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `Partner_id`=?");
            $resa->execute(array($a, $b, $c, $d, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $e));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Partner Type', 13, 'Update', $_SESSION['UID'], $d, $e), $_SESSION['COMPANY_ID']);
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
    $get1 = $db->prepare("SELECT * FROM `partner_type` WHERE `company_id`=? AND `Partner_id`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Partner Type', 13, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `partner_type` WHERE `company_id`=? AND `Partner_id` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Partner Type End */
/* Partner Type Start */
function addsubledger($ledgergroup, $name, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `slid` FROM `subledgergroup` WHERE `company_id`=? AND `sname`=?");
        $ress1->execute(array(strtolower($_SESSION['COMPANY_ID']), trim($name)));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['slid'] == '') {
            $resa = $db->prepare("INSERT INTO `subledgergroup` (`ledgergroup`,`sname`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?)");
            $resa->execute(array($ledgergroup, $name, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Partner Type', 13, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Partner Type already Exist</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `slid` FROM `subledgergroup` WHERE `company_id`=? AND `sname`=? AND `slid`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['slid'] == '') {
            $resa = $db->prepare("UPDATE `subledgergroup` SET `ledgergroup`=?,`sname`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `slid`=?");
            $resa->execute(array($ledgergroup, $name, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Sub Ledger Group', 13, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Partner Type already Exist</h4></div>';
        }
    }
    return $res;
}
function getsubledger($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `subledgergroup` WHERE `company_id`=? AND `slid`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delsubledger($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Sub Ledger Group', 13, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `subledgergroup` WHERE `company_id`=? AND `slid` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Partner Type End */
/* Payment Terms Start */
function addpaymentterm($paymentterm, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `PID` FROM `payment_term` WHERE `company_id`=? AND `PaymentTerm`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $paymentterm));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['PID'] == '') {
            $resa = $db->prepare("INSERT INTO `payment_term` (`PaymentTerm`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array($paymentterm, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('PaymentTerm', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Payment Term</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `PID` FROM `payment_term` WHERE `company_id`=? AND `PaymentTerm`=? AND `PID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $paymentterm, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['PID'] == '') {
            $resa = $db->prepare("UPDATE `payment_term` SET `PaymentTerm`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `PID`=?");
            $resa->execute(array($paymentterm, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('PaymentTerm', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `payment_term` WHERE `company_id`=? AND `PID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('PaymentTerm', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `payment_term` WHERE `company_id`=? AND `PID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Payment Terms Ends */
/* Currency Start */
function getcurrency_new($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `currency_new` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
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
/* Delivery Term Start */
function adddeliveryterm($deliveryterm, $description, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `DTID` FROM `deliveryterm` WHERE `company_id`=? AND `Title`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $deliveryterm));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['DTID'] == '') {
            $resa = $db->prepare("INSERT INTO `deliveryterm` (`DeliveryTerm`,`Description`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($deliveryterm, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('DeliveryTerm', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this DeliveryTerm</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `DTID` FROM `deliveryterm` WHERE `company_id`=? AND `DeliveryTerm`=? AND `DTID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $deliveryterm, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['DTID'] == '') {
            $resa = $db->prepare("UPDATE `deliveryterm` SET `DeliveryTerm`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `DTID`=?");
            $resa->execute(array($deliveryterm, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Delivery Term', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Delivery Term</h4></div>';
        }
    }
    return $res;
}
function getdeliveryterm($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `deliveryterm` WHERE `company_id`=? AND `DTID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function deldeliveryterm($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('DeliveryTerm', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `deliveryterm` WHERE `company_id`=? AND `DTID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Delivery Term Ends */
/* Mode of Shipment Start */
function addshipment($shipment, $description, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `MSID` FROM `shipment` WHERE `company_id`=? AND `Shipment`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $shipment));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MSID'] == '') {
            $resa = $db->prepare("INSERT INTO `shipment` (`Shipment`,`Description`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($shipment, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('shipment', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Mode of Shipment</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `MSID` FROM `shipment` WHERE `company_id`=? AND `Shipment`=? AND `MSID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $shipment, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MSID'] == '') {
            $resa = $db->prepare("UPDATE `shipment` SET `Shipment`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `MSID`=?");
            $resa->execute(array($shipment, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('shipment', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Mode of Shipment</h4></div>';
        }
    }
    return $res;
}
function getshipment($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `shipment` WHERE `company_id`=? AND `MSID`=? AND `status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delshipment($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('shipment', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `shipment` WHERE `company_id`=? AND `MSID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Mode of Shipment Ends */
/* Mode of Payment Start */
function addpayment($payment, $description, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `MPID` FROM `payment` WHERE `company_id`=? AND `Payment`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $payment));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MPID'] == '') {
            $resa = $db->prepare("INSERT INTO `payment` (`Payment`,`Description`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($payment, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Payment', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Mode of Payment</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `MPID` FROM `payment` WHERE `company_id`=? AND `Payment`=? AND `MPID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $payment, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MPID'] == '') {
            $resa = $db->prepare("UPDATE `payment` SET `Payment`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `MPID`=?");
            $resa->execute(array($payment, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Payment', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Mode of Payment</h4></div>';
        }
    }
    return $res;
}
function getpayment($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `payment` WHERE `company_id`=? AND `MPID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delpayment($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Payment', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `payment` WHERE `company_id`=? AND `MPID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Mode of Payment Ends */
/* Enquiry Type Start */
function addenquiry($enquiry, $description, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `EID` FROM `enquiry` WHERE `company_id`=? AND `EnquiryType`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $enquiry));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['EID'] == '') {
            $resa = $db->prepare("INSERT INTO `enquiry` (`EnquiryType`,`Description`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($enquiry, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Enquiry Type', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Enquiry Type</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `EID` FROM `enquiry` WHERE `company_id`=? AND `EnquiryType`=? AND `EID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $enquiry, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['EID'] == '') {
            $resa = $db->prepare("UPDATE `enquiry` SET `EnquiryType`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `EID`=?");
            $resa->execute(array($enquiry, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Enquiry Type', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Enquiry Type</h4></div>';
        }
    }
    return $res;
}
function getenquiry($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `enquiry` WHERE `company_id`=? AND `EID`=? AND `status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delenquiry($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Enquiry Type', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `enquiry` WHERE `company_id`=? AND `EID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Enquiry Type Ends */
/* Vessel Start */
function addvessel($vessel, $description, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `VID` FROM `vessel` WHERE `Vessel`=? AND `company_id` = ?");
        $ress1->execute(array($Vessel, $_SESSION['COMPANY_ID']));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['VID'] == '') {
            $resa = $db->prepare("INSERT INTO `vessel` (`Vessel`,`Description`,`Order`,`Status`,`IP`,`Updated_by` ,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($vessel, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Vessel', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Vessel</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `VID` FROM `vessel` WHERE `Vessel`=? AND `VID`!=?");
        $ress1->execute(array($vessel, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['VID'] == '') {
            $resa = $db->prepare("UPDATE `vessel` SET `Vessel`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `VID`=? AND `company_id`=?");
            $resa->execute(array($vessel, $description, $order, $status, $ip, $_SESSION['UID'], $id, $_SESSION['COMPANY_ID']));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Vessel', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Vessel </h4></div>';
        }
    }
    return $res;
}
function getvessel($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `vessel` WHERE `VID`=? AND `company_id` =? ");
    $get1->execute(array($b, $_SESSION['COMPANY_ID']));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delvessel($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Vessel', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `vessel` WHERE `VID` =? AND `company_id` =? ");
        $get->execute(array($c, $_SESSION['COMPANY_ID']));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Vessel Ends */
/* Validity Start */
function addvalidity($validity, $status, $ip, $id)
{
    global $db;
    list($status) = null_zero(array($status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `VAID` FROM `validity` WHERE `Validity`=? AND `company_id` =?  ");
        $ress1->execute(array($validity, $_SESSION['COMPANY_ID']));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['VAID'] == '') {
            $resa = $db->prepare("INSERT INTO `validity` (`Validity`, `Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?)");
            $resa->execute(array($validity, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`, `company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Validity', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Validity</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `VAID` FROM `validity` WHERE `Validity`=? AND `VAID`!=? AND `company_id` =? ");
        $ress1->execute(array($validity, $id, $_SESSION['COMPANY_ID']));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['VAID'] == '') {
            $resa = $db->prepare("UPDATE `validity` SET `Validity`=?, `Status`=?,`IP`=?,`Updated_by`=? WHERE `VAID`=? AND `company_id` = ?");
            $resa->execute(array($validity, $status, $ip, $_SESSION['UID'], $id, $_SESSION['COMPANY_ID']));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`, `company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Validity', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Validity</h4></div>';
        }
    }
    return $res;
}
function getvalidity($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `validity` WHERE `VAID`=? AND `company_id` =? ");
    $get1->execute(array($b, $_SESSION['COMPANY_ID']));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delvalidity($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Validity', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `validity` WHERE `VAID` =? AND `company_id`=? ");
        $get->execute(array($c, $_SESSION['COMPANY_ID']));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Validity Ends */
/* Validity Start */
function adddeliverydays($deliveryday, $status, $ip, $id)
{
    global $db;
    list($status) = null_zero(array($status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `DDID` FROM `deliveryday` WHERE `company_id`=? AND `Deliverydate`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $deliveryday));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['DDID'] == '') {
            $resa = $db->prepare("INSERT INTO `deliveryday` (`Deliverydate`, `Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?)");
            $resa->execute(array($deliveryday, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Validity', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Validity</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `DDID` FROM `deliveryday` WHERE `company_id`=? AND `Deliverydate`=? AND `DDID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $deliveryday, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['DDID'] == '') {
            $resa = $db->prepare("UPDATE `deliveryday` SET `Deliverydate`=?, `Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `DDID`=?");
            $resa->execute(array($deliveryday, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Delivery Days', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Validity</h4></div>';
        }
    }
    return $res;
}
function getdeliverydays($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `deliveryday` WHERE `company_id`=? AND `DDID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function deldeliverydays($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Delivery Days', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `deliveryday` WHERE `company_id`=? AND `DDID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Validity Ends */
/* Quotation Start */
function addquotation($quotation, $description, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `QID` FROM `quotation` WHERE `company_id`=? AND `Quotation`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $quotation));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['QID'] == '') {
            $resa = $db->prepare("INSERT INTO `quotation` (`Quotation`,`Description`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($quotation, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Quotation', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Quotation</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `QID` FROM `quotation` WHERE `company_id`=? AND `Quotation`=? AND `QID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $quotation, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['QID'] == '') {
            $resa = $db->prepare("UPDATE `quotation` SET `Quotation`=?,`Description`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `QID`=?");
            $resa->execute(array($quotation, $description, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Quotation', 2, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Quotation </h4></div>';
        }
    }
    return $res;
}
function getquotation($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `quotation` WHERE `company_id`=? AND `QID`=? AND `status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delquotation($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Quotation', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `quotation` WHERE `company_id`=? AND `QID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Quotation Ends */
/* Other Terms Start */
function addotherterms($name, $amount, $tax, $ledgergroup, $subledgergroup, $description, $status, $ip, $id)
{
    global $db;
    list($tax, $status) = null_zero(array($tax, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `OTID` FROM `otherterms` WHERE `company_id`=? AND `Name`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['OTID'] == '') {
            $resa = $db->prepare("INSERT INTO `otherterms` (`Name`,`Amount`,`Tax`,`ledgergroup`,`subledgergroup`,`Description`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($name, $amount, $tax, $ledgergroup, $subledgergroup, $description, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $resa = $db->prepare("INSERT INTO `ledger` (`Name`, `printname` ,`under`,`sub_under`, `status`,`otherterm_id`,`Order` ,`IP` ,`Updated_By`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($name, $name, '30', '0', '1', $insert_id, $order, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id1 = $db->lastInsertId();
            $supupdate = $db->prepare("UPDATE `otherterms` SET `Ledger_id`=? WHERE `company_id`=? AND `OTID`=? ");
            $supupdate->execute(array($insert_id1, $_SESSION['COMPANY_ID'], $insert_id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Other terms', 10, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Other terms</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `OTID` FROM `otherterms` WHERE `company_id`=? AND `Name`=? AND `OTID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['OTID'] == '') {
            $resa = $db->prepare("UPDATE `otherterms` SET `Name`=?,`Amount`=?,`Tax`=?,`ledgergroup`=?,`subledgergroup`=?,`Description`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `OTID`=?");
            $resa->execute(array($name, $amount, $tax, $ledgergroup, $subledgergroup, $description, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=?,`Order`=?,`ip`=? WHERE `company_id`=? AND `otherterm_id`=?");
            $htry->execute(array($name, $name, $order, $ip, $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Other terms', 10, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Other terms</h4></div>';
        }
    }
    return $res;
}
function getotherterms($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `otherterms` WHERE `company_id`=? AND `OTID`=? AND `Status` !=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delotherterms($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    $err_del = array();
    foreach ($b as $c) {
        $gets = delledger(getotherterms('Ledger_id', $c));
        if ($gets[0] == '0') {
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Other terms', 10, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
            $get = $db->prepare("DELETE FROM `otherterms` WHERE `company_id`=? AND `OTID` =? ");
            $get->execute(array($_SESSION['COMPANY_ID'], $c));
        } else {
            $err_del[] = $c;
        }
    }
    if (!empty($err_del)) {
        foreach ($err_del as $ers) {
            $des .= getotherterms('Name', $ers) . ', ';
        }
        $des = 'Unable to Delete. ' . substr($des, 0, -2);
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> ' . $des . '. Other Charge(s) have transactions</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    }
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Other terms', 10, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $id, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `otherterms` WHERE `company_id`=? AND `OTID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
        $get = $db->prepare("DELETE FROM `ledger` WHERE `company_id`=? AND `otherterm_id` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Other Terms Ends */
/* City Zone Start */
function addcitys($country, $state, $city, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `id` FROM `cities` WHERE `name`=?");
        $ress1->execute(array(strtolower(trim($city))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['id'] == '') {
            $resa = $db->prepare("INSERT INTO `cities` (`name`,`state_id`) VALUES (?,?)");
            $resa->execute(array($city, $state));
            $insert_id = $db->lastInsertId();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this City</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `id` FROM `cities` WHERE `name`=? AND `id`!=?");
        $ress1->execute(array($city, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['id'] == '') {
            $resa = $db->prepare("UPDATE `cities` SET `name`=?,`state_id`=? WHERE `id`=?");
            $resa->execute(array($city, $state, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this City</h4></div>';
        }
    }
    return $res;
}
function addcity($countryname, $state_name, $city, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `CTID` FROM `city` WHERE `CityName`=?");
        $ress1->execute(array(strtolower(trim($city))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CTID'] == '') {
            $resa = $db->prepare("INSERT INTO `city` (`CountryName`,`State_name`,`CityName`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($countryname, $state_name, $city, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('City', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this City Name</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `CTID` FROM `city` WHERE `CityName`=? AND `CTID`!=?");
        $ress1->execute(array($city, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CTID'] == '') {
            $resa = $db->prepare("UPDATE `city` SET `CountryName`=?,`State_name`=?,`CityName`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `CTID`=?");
            $resa->execute(array($countryname, $state_name, $city, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('City', 2, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this City Name</h4></div>';
        }
    }
    return $res;
}
function getcity($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `city` WHERE `CTID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delcity($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('City', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `city` WHERE `CTID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* City Ends */
/* Employee Group Start Here */
function addemplpyeegroup($group_name, $group_code, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `GrID` FROM `employee_group` WHERE `company_id`=? AND `Group_Code`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $group_code));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['GrID'] == '') {
            $resa = $db->prepare("INSERT INTO `employee_group` (`Group_Name`,`Group_Code`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($group_name, $group_code, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Employee Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Employee Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `GrID` FROM `employee_group` WHERE `company_id`=? AND `Group_Code`=? AND `GrID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $group_code, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['GrID'] == '') {
            $resa = $db->prepare("UPDATE `employee_group` SET `Group_Name`=?,`Group_Code`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `GrID`=? ");
            $resa->execute(array($group_name, $group_code, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Employee Group', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `employee_group` WHERE `company_id`=? AND `GrID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Employee Group', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `employee_group` WHERE `company_id`=? AND `GrID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Employee Group end Here */
/* Employee Start Here */
function addemployee($empname, $empcode, $enroll, $title, $first_name, $middle_name, $last_name, $dobdate, $gender, $designation, $department, $hiredon, $terminate, $terminatereason, $image, $address, $country, $state, $city, $area, $postal, $address1, $country1, $state1, $city1, $area1, $postal1, $phone, $mobile, $emailid, $website, $description, $workshift, $salaryfre, $emptype, $isdailywages, $grossamount, $grosspercetage, $basicsalary, $mrppackprice, $maxleaveallowed, $overtimerate, $maxexpenalloed, $salaryaccthead, $casleavealloed, $ourbank, $bankacctname, $bankacctnumber, $bankaccttype, $micrcode, $ifsccode, $incenttivepln, $conemail, $conpassword, $conserver, $conport, $enableserver, $order, $status, $document_id, $document_name, $file_names, $ip, $id)
{
    global $db;
    list($title, $gender, $designation, $department, $workshift, $salaryfre, $emptype, $isdailywages, $grossamount, $grosspercetage, $basicsalary, $mrppackprice, $maxleaveallowed, $overtimerate, $maxexpenalloed, $salaryaccthead, $casleavealloed, $ourbank, $incenttivepln, $enableserver, $order, $status) = null_zero(array($title, $gender, $designation, $department, $workshift, $salaryfre, $emptype, $isdailywages, $grossamount, $grosspercetage, $basicsalary, $mrppackprice, $maxleaveallowed, $overtimerate, $maxexpenalloed, $salaryaccthead, $casleavealloed, $ourbank, $incenttivepln, $enableserver, $order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `EmpID` FROM `employee` WHERE `company_id`=? AND `EmpCode`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $empcode));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['EmpID'] == '') {

            $checksubledger = FETCH_all("SELECT `slid` FROM `subledgergroup` WHERE LOWER(`sname`)='salary' AND `com_id`=?", $_SESSION['COMPANY_ID']);

            $resa = $db->prepare("INSERT INTO `employee` (`EmpName`, `EmpCode`, `Enrollno`, `Title`, `First_Name`, `Middle_Name`, `Last_Name`, `DoB`, `Gender`, `Designation`, `Department`, `Hired_On`, `Terminate_On`, `Reson_Terminat`, `Image`, `Address_1`, `Country_1`, `State_1`, `City_1`, `Area_1`, `Postal_Code_1`, `Address_2`, `Country_2`, `State_2`, `City_2`, `Area_2`, `Postal_Code_2`, `Phone_Number`, `Mobile_Number`, `E-Mail`, `Website`, `Description`, `Work_Shift`, `Salary_Frequent`, `Employee_Type`, `IsDailyWages`, `GrossAmount`, `Gross_Percentage`, `Basic_Salary`, `Max_Over_Allowed`, `Max_Leve_Allowed`, `OverTime_Rate`, `Max_Expe_Allowed`, `Salary_Accu_Head`, `Cas_Leve_Allowed`, `Our_bank_Name`, `Bank_Account_Name`, `Bank_Account_Num`, `Bank_Account_Type`, `MICR_Code`, `IFSC_Code`, `Incentive_Plan`, `E-mail-Config`, `Password`, `Server`, `Port`, `Enable_server`,`Order`, `Status`, `IP`, `Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $basicsalary = $basicsalary ? $basicsalary : '0';
            $maxleaveallowed = $maxleaveallowed ? $maxleaveallowed : '0';
            $maxexpenalloed = $maxexpenalloed ? $maxexpenalloed : '0';
            $mrppackprice = $mrppackprice ? $mrppackprice : '0';
            $resa->execute(array($empname, $empcode, $enroll, $title, $first_name, $middle_name, $last_name, $dobdate, $gender, $designation, $department, $hiredon, $terminate, $terminatereason, $image, $address, $country, $state, $city, $area, $postal, $address1, $country1, $state1, $city1, $area1, $postal1, $phone, $mobile, $emailid, $website, $description, $workshift, $salaryfre, $emptype, $isdailywages, $grossamount, $grosspercetage, $basicsalary, $mrppackprice, $maxleaveallowed, $overtimerate, $maxexpenalloed, $salaryaccthead, $casleavealloed, $ourbank, $bankacctname, $bankacctnumber, $bankaccttype, $micrcode, $ifsccode, $incenttivepln, $conemail, $conpassword, $conserver, $conport, $enableserver, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            update_bill_value('11');

            if ($checksubledger['slid'] != '') {
                $resa = $db->prepare("INSERT INTO `ledger` (`Name`,`printname`,`under`,`sub_under`,`status`,`IP`,`Updated_By`,`customer_id`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($empname, $empname . $empcode, '48', $checksubledger['slid'], '1', $ip, $_SESSION['UID'], $insert_id, $_SESSION['COMPANY_ID']));
                $insert_id = $db->lastInsertId();
            } else {

                $resa = $db->prepare("INSERT INTO `ledger` (`Name`, `printname` ,`under`,`sub_under`, `status` ,`IP` ,`Updated_By` ,`customer_id`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($empname, $empname . $empcode, '48', '8', '1', $ip, $_SESSION['UID'], $insert_id, $_SESSION['COMPANY_ID']));
                $insert_id = $db->lastInsertId();
            }

            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Employee', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            foreach ($document_name as $k => $VV) {
                $dc = $db->prepare("INSERT INTO `employee_documents` SET `company_id`=?, `emp_id`=?,`document_name`=?,`document`=?");
                $dc->execute(array($_SESSION['COMPANY_ID'], $insert_id, $document_name[$k], $file_names[$k]));
            }
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Employee Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `EmpID` FROM `employee` WHERE `company_id`=? AND `EmpCode`=? AND `EmpID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $empcode, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['EmpID'] == '') {
            $resa = $db->prepare("UPDATE `employee` SET `EmpName`=?, `EmpCode`=?, `Enrollno`=?, `Title`=?, `First_Name`=?, `Middle_Name`=?, `Last_Name`=?, `DoB`=?, `Gender`=?, `Designation`=?, `Department`=?, `Hired_On`=?, `Terminate_On`=?, `Reson_Terminat`=?, `Image`=?, `Address_1`=?, `Country_1`=?, `State_1`=?, `City_1`=?, `Area_1`=?, `Postal_Code_1`=?, `Address_2`=?, `Country_2`=?, `State_2`=?, `City_2`=?, `Area_2`=?, `Postal_Code_2`=?, `Phone_Number`=?, `Mobile_Number`=?, `E-Mail`=?, `Website`=?, `Description`=?, `Work_Shift`=?, `Salary_Frequent`=?, `Employee_Type`=?, `IsDailyWages`=?, `GrossAmount`=?, `Gross_Percentage`=?, `Basic_Salary`=?, `Max_Over_Allowed`=?, `Max_Leve_Allowed`=?, `OverTime_Rate`=?, `Max_Expe_Allowed`=?, `Salary_Accu_Head`=?, `Cas_Leve_Allowed`=?, `Our_bank_Name`=?, `Bank_Account_Name`=?, `Bank_Account_Num`=?, `Bank_Account_Type`=?, `MICR_Code`=?, `IFSC_Code`=?, `Incentive_Plan`=?, `E-mail-Config`=?, `Password`=?, `Server`=?, `Port`=?, `Enable_server`=?,`Order`=?, `Status`=?, `IP`=?, `Updated_by`=? WHERE `company_id`=? AND `EmpID`=? ");
            $resa->execute(array($empname, $empcode, $enroll, $title, $first_name, $middle_name, $last_name, $dobdate, $gender, $designation, $department, $hiredon, $terminate, $terminatereason, $image, $address, $country, $state, $city, $area, $postal, $address1, $country1, $state1, $city1, $area1, $postal1, $phone, $mobile, $emailid, $website, $description, $workshift, $salaryfre, $emptype, $isdailywages, $grossamount, $grosspercetage, $basicsalary, $mrppackprice, $maxleaveallowed, $overtimerate, $maxexpenalloed, $salaryaccthead, $casleavealloed, $ourbank, $bankacctname, $bankacctnumber, $bankaccttype, $micrcode, $ifsccode, $incenttivepln, $conemail, $conpassword, $conserver, $conport, $enableserver, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Employee', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            foreach ($document_name as $k => $VV) {
                if ($document_id[$k] != '') {
                    $dc = $db->prepare("UPDATE `employee_documents` SET `document_name`=?,`document`=? WHERE `company_id`=? AND `emp_id`=? AND `id`=?");
                    $dc->execute(array($document_name[$k], $file_names[$k], $_SESSION['COMPANY_ID'], $id, $document_id[$k]));
                } else {
                    $dc = $db->prepare("INSERT INTO `employee_documents` SET  `company_id`=?,`emp_id`=?,`document_name`=?,`document`=?");
                    $dc->execute(array($_SESSION['COMPANY_ID'], $id, $document_name[$k], $file_names[$k]));
                }
            }
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
    $get1 = $db->prepare("SELECT * FROM `employee` WHERE `company_id`=? AND `EmpID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Employee', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `employee` WHERE `company_id`=? AND `EmpID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Employee end Here */
/* Brand Start Here */
function addbrand($menuf, $brand_name, $brand_code, $order, $status, $ip, $id)
{
    global $db;
    list($menuf, $order, $status) = null_zero(array($menuf, $order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `BrID` FROM `brand` WHERE `company_id`=? AND `Brand_Code`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $brand_code));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['BrID'] == '') {
            $resa = $db->prepare("INSERT INTO `brand` (`Manufacturer`,`Brand_Name`,`Brand_Code`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?)");
            $resa->execute(array($menuf, $brand_name, $brand_code, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Brand', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Brand Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `BrID` FROM `brand` WHERE `company_id`=? AND `Brand_Code`=? AND `BrID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $brand_code, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['BrID'] == '') {
            $resa = $db->prepare("UPDATE `brand` SET `Manufacturer`=?,`Brand_Name`=?,`Brand_Code`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND`BrID`=? ");
            $resa->execute(array($menuf, $brand_name, $brand_code, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Brand', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `brand` WHERE `company_id`=? AND `BrID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Brand', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `brand` WHERE `company_id`=? AND `BrID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
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
        $resa = $db->prepare("INSERT INTO `itemsubgroup` (`ItemGroup`,`ItemSub`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $resa->execute(array($group_name, $subgroup, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Sub Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        $resa = $db->prepare("UPDATE `itemsubgroup` SET `ItemGroup`=?,`ItemSub`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `ItSubID`=? ");
        $resa->execute(array($group_name, $subgroup, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Sub Group', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}
function getsubgroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `itemsubgroup` WHERE `company_id`=? AND `ItSubID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Sub Group', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `itemsubgroup` WHERE `company_id`=? AND `ItSubID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
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
        $resa = $db->prepare("INSERT INTO `iteminnergroup` (`Group`,`SubGroup`,`InnerGroup`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?)");
        $resa->execute(array($group_name, $subgroup, $innergroup, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Inner Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        $resa = $db->prepare("UPDATE `iteminnergroup` SET `Group`=?,`SubGroup`=?,`InnerGroup`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `ItinnerID`=? ");
        $resa->execute(array($group_name, $subgroup, $innergroup, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Inner Group', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}
function getinnergroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `iteminnergroup` WHERE `company_id`=? AND `ItinnerID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Inner Group', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `iteminnergroup` WHERE `company_id`=? AND `ItinnerID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Inner Group end Here */
/* UOM Start Here */
function adduom($name, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `UomID` FROM `uom` WHERE `company_id`=? AND `Name`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['UomID'] == '') {
            $resa = $db->prepare("INSERT INTO `uom` (`Name`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array($name, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('UOM', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this UOM Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `UomID` FROM `uom` WHERE `company_id`=? AND `Name`=? AND `UomID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['UomID'] == '') {
            $resa = $db->prepare("UPDATE `uom` SET `Name`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `UomID`=? ");
            $resa->execute(array($name, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`, `company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('UOM', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `uom` WHERE `company_id`=? AND `UomID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('UOM', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `uom` WHERE `company_id`=? AND `UomID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* UOM end Here */
/* Margin Start Here */
function addmargin($name, $margincode, $order, $status, $ip, $id)
{
    global $db;
    list($name, $order, $status) = null_zero(array($name, $order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `MaID` FROM `margin` WHERE `company_id`=? AND `Code`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $margincode));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MaID'] == '') {
            $resa = $db->prepare("INSERT INTO `margin` (`Name`,`Code`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($name, $margincode, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Margin', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Margin Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `MaID` FROM `margin` WHERE `company_id`=? AND `Code`=? AND `MaID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $margincode, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['MaID'] == '') {
            $resa = $db->prepare("UPDATE `margin` SET `Name`=?,`Code`=?, `Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `MaID`=? ");
            $resa->execute(array($name, $margincode, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Margin', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `margin` WHERE `company_id`=? AND `MaID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Margin', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `margin` WHERE `company_id`=? AND `MaID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Margin end Here  */
/*  Group Start Here */
function addcusgroup($name, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `CuGID` FROM `customergroup` WHERE `company_id`=? AND `Group_Name`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CuGID'] == '') {
            $resa = $db->prepare("INSERT INTO `customergroup` (`Group_Name`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?)");
            $resa->execute(array($name, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Customer Group', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Customer Group Name</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `CuGID` FROM `customergroup` WHERE `company_id`=? AND `Group_Name`=? AND `CuGID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CusID'] == '') {
            $resa = $db->prepare("UPDATE `customergroup` SET `Group_Name`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `CuGID`=? ");
            $resa->execute(array($name, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Cutomer Group', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `customergroup` WHERE `company_id`=? AND `CuGID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Customer Group', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `customergroup` WHERE `company_id`=? AND `CuGID` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* Customer Group end Here */
function addbank($bankname, $bankcode, $branchname, $Acc_no, $ifsccode, $swift, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `BankID` FROM `bank` WHERE `company_id`=? AND `Bank_Code`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['BankID'] == '') {
            //(`BankID`, `Bank_Name`, `Bank_Code`, `Branch_Name`, `IFSC_Code`, `Address`, `Country`, `State`, `City`, `Area`, `Postal_Code`, `Order`, `Status`, `IP`, `Updated_by`, `Updated_type`, `date`)
            $resa = $db->prepare("INSERT INTO `bank` (`Bank_Name`, `Bank_Code`, `Branch_Name`,`Acc_no`, `IFSC_Code`, `swift_code`, `Address`, `Country`, `State`, `City`, `Area`, `Postal_Code`, `Image`,`Order`, `Status`, `IP`, `Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($bankname, $bankcode, $branchname, $Acc_no, $ifsccode, $swift, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $resa = $db->prepare("INSERT INTO `ledger` (`Name`, `printname` ,`under`,`sub_under`, `status`,`Order` ,`IP` ,`Updated_By`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($bankname, $bankname, '15', '0', '1', $order, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insertsl_id = $db->lastInsertId();
            $supupdate = $db->prepare("UPDATE `bank` SET `ledger_id`=? WHERE `company_id`=? AND `BankID`=? ");
            $supupdate->execute(array($insertsl_id, $_SESSION['COMPANY_ID'], $insert_id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Bank', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Bank Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT * FROM `bank` WHERE `company_id`=? AND `Bank_Code`=? AND `BankID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['BankID'] == '') {
            $resa = $db->prepare("UPDATE `bank` SET `Bank_Name`=?, `Bank_Code`=?, `Branch_Name`=?,`Acc_no`=?, `IFSC_Code`=?,`swift_code`=?, `Address`=?, `Country`=?, `State`=?, `City`=?, `Area`=?, `Postal_Code`=?,`Image`=?, `Order`=?, `Status`=?, `IP`=?, `Updated_by`=? WHERE `company_id`=? AND `BankID`=? ");
            $resa->execute(array($bankname, $bankcode, $branchname, $Acc_no, $ifsccode, $swift, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $pupdate = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=? WHERE `company_id`=? AND `lid`=? ");
            $pupdate->execute(array($bankname, $bankname, $_SESSION['COMPANY_ID'], getbank('ledger_id', $id)));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Bank', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
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
    $get1 = $db->prepare("SELECT * FROM `bank` WHERE `company_id`=? AND `BankID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
    $err_del = array();
    foreach ($b as $c) {
        $gets = delledger(getbank('ledger_id', $c));
        if ($gets[0] == '0') {
            $pimage = getbank('Image', $c);
            if ($pimage != '') {
                unlink("../../images/bank/" . $pimage);
            }
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Bank', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
            $get = $db->prepare("DELETE FROM `bank` WHERE `company_id`=? AND `BankID` =? ");
            $get->execute(array($_SESSION['COMPANY_ID'], $c));
        } else {
            $err_del[] = $c;
        }
    }
    if (!empty($err_del)) {
        foreach ($err_del as $ers) {
            $des .= getbank('Bank_Name', $ers) . ', ';
        }
        $des = 'Unable to Delete. ' . substr($des, 0, -2);
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> ' . $des . '. Bank(s) have transactions</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    }
    return $res;
}
/* Customer Group end Here */
function getcustomer($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `customer` WHERE `company_id`=? AND `CusID`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
/* Customer Start Here */
function addcustomer($employee, $agent_name, $customer_company, $cont_person, $customer_code, $invoice_name, $currency, $address1, $address2, $area, $state, $city, $postcode, $country, $billing_address1, $billing_address2, $billing_area, $billing_state, $billing_city, $billing_postcode, $billing_country, $email, $website, $mobile, $phone, $mobile1, $gstvalue, $credit, $creditdate, $margin, $referen, $group_name, $img, $description, $bankname, $branch, $accname, $accno, $ifsccode, $swiftcode, $note, $status, $taxtype, $paymentterm, $paymentmode, $cust_address, $cust_address2, $cust_country, $cust_state, $cust_city, $cust_pincode, $cust_ids, $cdesignation, $ip, $representative_name, $id)
{
    global $db;
    list($employee, $credit, $margin, $group_name, $status) = null_zero(array($employee, $credit, $margin, $group_name, $status));
    //$credit = ($credit) ? $credit : 0;
    $invoice_name = $customer_company;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `CusID` FROM `customer` WHERE `company_id`=? AND LOWER(TRIM(`Company`))=? AND `E-mail`=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], strtolower(trim($customer_company)), $email));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CusID'] == '') {
            //,$invoice_name,$currency,
            $resa = $db->prepare("INSERT INTO `customer` ( `Employee`, `Agent_name`, `Company`, `Person`,`Customer_code`, `Invoice_name`,`Currency`, `Adderss_1`, `Address_2`,`Area`, `State`, `City`, `Postcode`, `Country`,`Billing_Address_1`, `Billing_Address_2`,`Billing_Area`, `Billing_State`, `Billing_City`, `Billing_Postcode`, `Billing_Country`,  `E-mail`, `Website`, `Mobile`, `Phone`,`Mobile1`, `GSTNum`, `Credit`, `Creditdate`,`Margin`,`Reference`, `CustomerGroup`, `Image`, `Description`,`Bank_name`,`Branch_name`,`Account_name`,`Account_no`,`IFSC_code`,`SWIFT_Code`,`notes`, `Status`,`taxtype`,`paymentterm`,`paymentmode`, `IP`, `Updated_by`,`cdesignation`,`representative_name`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($employee, $agent_name, $customer_company, $cont_person, $customer_code, $invoice_name, $currency, $address1, $address2, $area, $state, $city, $postcode, $country, $billing_address1, $billing_address2, $billing_area, $billing_state, $billing_city, $billing_postcode, $billing_country, $email, $website, $mobile, $phone, $mobile1, $gstvalue, $credit, $creditdate, $margin, $referen, $group_name, $img, $description, $bankname, $branch, $accname, $accno, $ifsccode, $swiftcode, $note, $status, $taxtype, $paymentterm, $paymentmode, $ip, $_SESSION['UID'], $cdesignation, $representative_name, $_SESSION['COMPANY_ID']));
            $insert_id1 = $db->lastInsertId();
            update_bill_value('9');
            $resa = $db->prepare("INSERT INTO `ledger` (`Name`, `printname` ,`under`,`subledger`, `status` ,`IP` ,`Updated_By` ,`customer_id`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($customer_company, $customer_company, '19', '0', '1', $ip, $_SESSION['UID'], $insert_id1, $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $supupdate = $db->prepare("UPDATE `customer` SET `Ledger_id`=? WHERE `company_id`=? AND `CusID`=? ");
            $supupdate->execute(array($insert_id, $_SESSION['COMPANY_ID'], $insert_id1));
            foreach ($cust_address as $ki => $addrs) {
                if ($addrs != '') {
                    $cus_add = $db->prepare("INSERT INTO `customer_address` SET `customer_id`=?,`address`=?,`address2`=?,`city`=?,`state`=?,`country`=?,`pincode`=?,`company_id`=? ");
                    $cus_add->execute(array($insert_id1, $cust_address[$ki], $cust_address2[$ki], $cust_city[$ki], $cust_state[$ki], $cust_country[$ki], $cust_pincode[$ki], $_SESSION['COMPANY_ID']));
                }
            }
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Customer', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id1, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Email or Company name </h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `CusID` FROM `customer` WHERE `company_id`=? AND LOWER(TRIM(`Company`))=? AND `E-mail`=? AND `CusID`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], strtolower(trim($customer_company)), $email, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        $ressup1 = $db->prepare("SELECT `Agent_name` FROM `customer` WHERE `company_id`=? AND `CusID`=?");
        $ressup1->execute(array($_SESSION['COMPANY_ID'], $id));
        $ressup = $ressup1->fetch(PDO::FETCH_ASSOC);
        if ($ressup['Agent_name'] != $agent_name) {
            $ressup2 = $db->prepare("SELECT `Agent_name` FROM `customer` WHERE `company_id`=? AND `Agent_name`=?");
            $ressup2->execute(array($_SESSION['COMPANY_ID'], $agent_name));
            $ressupate = $ressup2->fetch(PDO::FETCH_ASSOC);
        } else {
            $ressupate['Agent_name'] = '';
        }
        //if ($ress['CusID'] == '' && $ressupate['Agent_name'] == '') {
        if ($ress['CusID'] == '') {
            $resa = $db->prepare("UPDATE `customer` SET `Employee`=?, `Agent_name`=?, `Company`=?, `Person`=?,`Customer_code`=?,`Invoice_name`=?,`Currency`=?, `Adderss_1`=?, `Address_2`=?,`Area`=?, `State`=?, `City`=?, `Postcode`=?, `Country`=?,  `Billing_Address_1`=?, `Billing_Address_2`=?,`Billing_Area`=?, `Billing_State`=?, `Billing_City`=?, `Billing_Postcode`=?, `Billing_Country`=?,`E-mail`=?, `Website`=?, `Mobile`=?, `Phone`=?,`Mobile1`=?, `GSTNum`=?, `Credit`=?, `Creditdate`=?,`Margin`=?,`Reference`=?, `CustomerGroup`=?, `Image`=?, `Description`=?,`Bank_name`=?,`Branch_name`=?,`Account_name`=?,`Account_no`=?,`IFSC_code`=?,`SWIFT_Code`=?,`notes`=?, `Status`=?,`taxtype`=?,`paymentterm`=?,`paymentmode`=?, `IP`=?, `Updated_by`=?,`cdesignation`=?,`representative_name`=? WHERE `company_id`=? AND `CusID`=? ");
            $resa->execute(array($employee, $agent_name, $customer_company, $cont_person, $customer_code, $invoice_name, $currency, $address1, $address2, $area, $state, $city, $postcode, $country, $billing_address1, $billing_address2, $billing_area, $billing_state, $billing_city, $billing_postcode, $billing_country, $email, $website, $mobile, $phone, $mobile1, $gstvalue, $credit, $creditdate, $margin, $referen, $group_name, $img, $description, $bankname, $branch, $accname, $accno, $ifsccode, $swiftcode, $note, $status, $taxtype, $paymentterm, $paymentmode, $ip, $_SESSION['UID'], $cdesignation, $representative_name, $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=?,`ip`=? WHERE `company_id`=? AND `customer_id`=?");
            $htry->execute(array($customer_company, $customer_company, $ip, $_SESSION['COMPANY_ID'], $id));
            foreach ($cust_address as $ki => $addrs) {
                if ($cust_ids[$ki] != '') {
                    $cus_add = $db->prepare("UPDATE `customer_address` SET `customer_id`=?,`address`=?,`address2`=?,`city`=?,`state`=?,`country`=?,`pincode`=? WHERE `company_id`=? AND `id`=?");
                    $cus_add->execute(array($id, $cust_address[$ki], $cust_address2[$ki], $cust_city[$ki], $cust_state[$ki], $cust_country[$ki], $cust_pincode[$ki], $_SESSION['COMPANY_ID'], $cust_ids[$ki]));
                } else {
                    if ($addrs != '') {
                        $cus_add = $db->prepare("INSERT INTO `customer_address` SET `customer_id`=?,`address`=?,`address2`=?,`city`=?,`state`=?,`country`=?,`pincode`=?,`company_id`=?");
                        $cus_add->execute(array($id, $cust_address[$ki], $cust_address2[$ki], $cust_city[$ki], $cust_state[$ki], $cust_country[$ki], $cust_pincode[$ki], $_SESSION['COMPANY_ID']));
                    }
                }
            }
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Cutomer', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Email or Company name</h4></div>';
        }
    }
    unset($_SESSION['CD']);
    return $res;
}
function delcustomer($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    $err_del = array();
    foreach ($b as $c) {
        $gets = delledger(getcustomer('Ledger_id', $c));
        if ($gets[0] == '0') {
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Customer', '3', 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
            $get = $db->prepare("DELETE FROM `customer` WHERE `company_id`=? AND `CusID` =? ");
            $get->execute(array($_SESSION['COMPANY_ID'], $c));
        } else {
            $err_del[] = $c;
        }
    }
    if (!empty($err_del)) {
        foreach ($err_del as $ers) {
            $des .= getcustomer('Company', $ers) . ', ';
        }
        $des = 'Unable to Delete. ' . substr($des, 0, -2);
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> ' . $des . '. Customer(s) have transactions</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    }
    unset($_SESSION['CD']);
    return $res;
}
/* Customer  end Here */
/* State Zone Start */
function addstates($country, $state, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `id` FROM `states` WHERE `name`=?");
        $ress1->execute(array(strtolower(trim($state))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['id'] == '') {
            $resa = $db->prepare("INSERT INTO `states` (`country_id`,`name`) VALUES (?,?)");
            $resa->execute(array($country, $state));
            $insert_id = $db->lastInsertId();
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this State</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `id` FROM `states` WHERE `name`=? AND `id`!=?");
        $ress1->execute(array($state, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['id'] == '') {
            $resa = $db->prepare("UPDATE `states` SET `country_id`=?,`name`=? WHERE `id`=?");
            $resa->execute(array($country, $state, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this State</h4></div>';
        }
    }
    return $res;
}
function addstate($countryname, $state_name, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `SID` FROM `state` WHERE `State_name`=?");
        $ress1->execute(array(strtolower(trim($state_name))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SID'] == '') {
            $resa = $db->prepare("INSERT INTO `state` (`CountryName`,`State_name`,`Order`,`Status`,`IP`,`Updated_by`) VALUES (?,?,?,?,?)");
            $resa->execute(array($countryname, $state_name, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('State', 2, 'Insert', $_SESSION['UID'], $d, $insert_id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this State Name</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `SID` FROM `state` WHERE `State_name`=? AND `SID`!=?");
        $ress1->execute(array($state_name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['SID'] == '') {
            $resa = $db->prepare("UPDATE `state` SET `CountryName`=?,`State_name`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `SID`=?");
            $resa->execute(array($countryname, $state_name, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('State', 2, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this State Name</h4></div>';
        }
    }
    return $res;
}
function getstate($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `state` WHERE `SID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delstate($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('State', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        $get = $db->prepare("DELETE FROM `state` WHERE `SID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* State Ends */
/* country Zone Start */
function addcountry($countryname, $country_iso_code2, $country_iso_code3, $order, $status, $ip, $id)
{
    global $db;
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `CID` FROM `countries` WHERE `CountryName`=?");
        $ress1->execute(array(strtolower(trim($countryname))));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CID'] == '') {
            $resa = $db->prepare("INSERT INTO `countries`(`CountryName`,`countries_iso_code_2`,`countries_iso_code_3`,`Order`,`Status`,`IP`, `Updated_by`) VALUES (?,?,?,?,?,?,?)");
            $resa->execute(array($countryname, $country_iso_code2, $country_iso_code3, $order, $status, $ip, $_SESSION['UID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Country', 2, 'Insert', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Country Name</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `CID` FROM `countries` WHERE `CountryName`=? AND `CID`!=?");
        $ress1->execute(array($countryname, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['CID'] == '') {
            $resa = $db->prepare("UPDATE `countries` SET `CountryName`=?,`countries_iso_code_2`=?,`countries_iso_code_3`=?, `Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `CID`=?");
            $resa->execute(array($countryname, $country_iso_code2, $country_iso_code3, $order, $status, $ip, $_SESSION['UID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
            $htry->execute(array('Country', 2, 'Update', $_SESSION['UID'], $ip, $id));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Country Name</h4></div>';
        }
    }
    return $res;
}
function getcountry($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `countries` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function getcountry1($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `countries` WHERE `CID`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delcountry($a)
{
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        $htry->execute(array('Country', '3', 'Delete', $_SESSION['UID'], $ip, $id));
        $get = $db->prepare("DELETE FROM `countries` WHERE `CID` =? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
/* country Ends */
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
function gettax1($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `tax` WHERE `company_id`=? AND `tid`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function addtax1($tax_name, $tax_per, $order, $status, $ip, $id)
{
    global $db;
    list($order, $status) = null_zero(array($order, $status));
    if ($id == '') {
        $ress1 = $db->prepare("SELECT `tid` FROM `tax` WHERE `company_id`=? AND `taxname`=? ");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $tax_name));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['tid'] == '') {
            $tti = $tax_name . ' Input';
            $tto = $tax_name . ' Output';
            $ttp = $tax_name . ' Purchase';
            $tts = $tax_name . ' Sales';
            $resi = $db->prepare("INSERT INTO `ledger` (`Name`,`printname`,`under`,`IP`,`Updated_By`,`status`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resi->execute(array($tti, $tti, '22', $ip, $_SESSION['UID'], $status, $_SESSION['COMPANY_ID']));
            $iinsert_id = $db->lastInsertId();
            $reso = $db->prepare("INSERT INTO `ledger` (`Name`,`printname`,`under`,`IP`,`Updated_By`,`status`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $reso->execute(array($tto, $tto, '22', $ip, $_SESSION['UID'], $status, $_SESSION['COMPANY_ID']));
            $oinsert_id = $db->lastInsertId();
            $resp = $db->prepare("INSERT INTO `ledger` (`Name`,`printname`,`under`,`IP`,`Updated_By`,`status`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $resp->execute(array($ttp, $ttp, '26', $ip, $_SESSION['UID'], $status, $_SESSION['COMPANY_ID']));
            $pinsert_id = $db->lastInsertId();
            $ress = $db->prepare("INSERT INTO `ledger` (`Name`,`printname`,`under`,`IP`,`Updated_By`,`status`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $ress->execute(array($tts, $tts, '44', $ip, $_SESSION['UID'], $status, $_SESSION['COMPANY_ID']));
            $sinsert_id = $db->lastInsertId();
            $resa = $db->prepare("INSERT INTO `tax` (`taxname`,`taxpercentage`,`pledger`,`sledger`,`iledger`,`oledger`,`Order`,`Status`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $resa->execute(array($tax_name, $tax_per, $pinsert_id, $sinsert_id, $iinsert_id, $oinsert_id, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
            $insert_id = $db->lastInsertId();
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Tax', 3, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Tax Code</h4></div>';
        }
    } else {
        $ress1 = $db->prepare("SELECT `tid` FROM `tax` WHERE `company_id`=? AND `taxname`=? AND `tid`!=?");
        $ress1->execute(array($_SESSION['COMPANY_ID'], $tax_name, $id));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['tid'] == '') {
            $tti = $tax_name . ' Input';
            $tto = $tax_name . ' Output';
            $ttp = $tax_name . ' Purchase';
            $tts = $tax_name . ' Sales';
            $resi = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=?,`IP`=?,`Updated_By`=?,`status`=? WHERE `company_id`=? AND `lid`=?");
            $resi->execute(array($tti, $tti, $ip, $_SESSION['UID'], $status, $_SESSION['COMPANY_ID'], gettax1('iledger', $id)));
            $resi = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=?,`IP`=?,`Updated_By`=?,`status`=? WHERE `company_id`=? AND `lid`=?");
            $resi->execute(array($tto, $tto, $ip, $_SESSION['UID'], $status, $_SESSION['COMPANY_ID'], gettax1('oledger', $id)));
            $resi = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=?,`IP`=?,`Updated_By`=?,`status`=? WHERE `company_id`=? AND `lid`=?");
            $resi->execute(array($ttp, $ttp, $ip, $_SESSION['UID'], $status, $_SESSION['COMPANY_ID'], gettax1('pledger', $id)));
            $resi = $db->prepare("UPDATE `ledger` SET `Name`=?,`printname`=?,`IP`=?,`Updated_By`=?,`status`=? WHERE `company_id`=? AND `lid`=?");
            $resi->execute(array($tts, $tts, $ip, $_SESSION['UID'], $status, $_SESSION['COMPANY_ID'], gettax1('sledger', $id)));
            $resa = $db->prepare("UPDATE `tax` SET `taxname`=?,`taxpercentage`=?,`Order`=?,`Status`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `tid`=? ");
            $resa->execute(array($tax_name, $tax_per, $order, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Tax', 3, 'Update', $_SESSION['UID'], $ip, $id, $_SESSION['COMPANY_ID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        } else {
            $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Tax Code</h4></div>';
        }
    }
    return $res;
}
function deltax1($a)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    global $db;
    $Count =0;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    $err_del = array();
    foreach ($b as $c) {
        $db->beginTransaction();
        $gets1 = delledger(gettax1('pledger', $c));
        $gets2 = delledger(gettax1('sledger', $c));
        $gets3 = delledger(gettax1('iledger', $c));
        $gets4 = delledger(gettax1('oledger', $c));
        if ($gets1[0] == '0' && $gets2[0] == '0' && $gets3[0] == '0' && $gets4[0] == '0') {
            $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
            $htry->execute(array('Tax', 3, 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
            $get = $db->prepare("DELETE FROM `tax` WHERE `company_id`=? AND `tid` =? ");
            $get->execute(array($_SESSION['COMPANY_ID'], $c));
            $Count = $get->rowCount();
            $db->commit();
        } else {
            $db->rollBack();
            $err_del[] = $c;
        }
    }
    if (!empty($err_del)) {
        foreach ($err_del as $ers) {
            $des .= gettax1('taxname', $ers) . ', ';
        }
        $des = 'Unable to Delete. ' . substr($des, 0, -2);
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> ' . $des . '. Tax(s) have transactions</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted. Affected rows '. $Count .'</h4></div>';
    }
    return $res;
}
function addtax($a, $b, $c, $d)
{
    global $db;
    $resa = $db->prepare("UPDATE `tax` SET `tax`=?,`status`=?,`ip`=?,`updated_by`=? WHERE `company_id`=? AND `tid`=?");
    $resa->execute(array(strtolower(trim($a)), $b, $c, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $d));
    $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
    $htry->execute(array('Tax', 38, 'Update', $_SESSION['UID'], $c, $d, $_SESSION['COMPANY_ID']));
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    return $res;
}
function gettax($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `tax` WHERE `company_id`=? AND `tid`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
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
function addledger($name, $printname, $under, $undersub, $status, $ip, $id)
{
    global $db;
    global $session_value_id;
    list($undersub, $status) = null_zero(array($undersub, $status));
    if ($id == '') {
        $resa = $db->prepare("INSERT INTO `ledger` (`Name`, `printname`, `under`, `subledger`,`status`,`ip`, `Updated_By`,`company_id`) VALUES(?,?,?,?,?,?,?,?)");
        $resa->execute(array($name, $printname, $under, $undersub, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
        $insert_id = $db->lastInsertId();
        // $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        // $htry->execute(array('Ledger', 13, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        $resa = $db->prepare("UPDATE `ledger` SET `Name`=?, `printname`=?, `under`=?, `subledger`=?,`status`=?,`ip`=?, `Updated_By`=? WHERE `company_id`=? AND `lid`=?");
        $resa->execute(array($name, $printname, $under, $undersub, $status, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $id));
        // $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        // $htry->execute(array('Ledger', 13, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}
function getledger($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `ledger` WHERE `company_id`=? AND `lid`=? and `Status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delledger($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    $err_ids = array();
    foreach ($b as $c) {
        //$htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        //$htry->execute(array('Ledger', 13, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c));
        try {
            $get = $db->prepare("DELETE FROM `ledger` WHERE `company_id`=? AND `lid` =? ");
            $get->execute(array($_SESSION['COMPANY_ID'], $c));
        } catch (PDOException $e) {
            $err_ids[] = $c;
        }
    }
    if (!empty($err_ids)) {
        if (count($err_ids) > '1') {
            foreach ($err_ids as $ers) {
                $des .= getledger('Name', $ers) . ', ';
            }
            $des = 'Unable to Delete. ' . substr($des, 0, -2);
        } else {
            $des = 'Unable to Delete.';
        }
        $ret = '1';
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>' . $des . ' Ledger(s) have transactions.</h4></div>';
    } else {
        $ret = '0';
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    }
    return array($ret, $res);
}
function getledger_by_field($a = '', $b = '', $type = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `ledger` WHERE `company_id`=? AND `$type`=? and `status`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 1));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function addledgergroup($name, $classification, $order, $ip, $lgid)
{
    global $db;
    global $session_value_id;
    if ($lid == '') {
        $resa = $db->prepare("INSERT INTO `ledgergroup` (`ledgergroupname`, `Classification`, `Order`,  `IP`, `Updated_By`) VALUES(?,?,?,?,?)");
        $resa->execute(array($name, $classification, $order, $ip, $_SESSION['UID']));
        $insert_id = $db->lastInsertId();
        // $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        // $htry->execute(array('Ledger', 13, 'Insert', $_SESSION['UID'], $ip, $insert_id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        $resa = $db->prepare("UPDATE `ledgergroup` SET `ledgergroupname`=?, `Classification`=?, `Order`=?,  `IP`=?, `Updated_By`=? WHERE `ledgergroupid`=?");
        $resa->execute(array($name, $classification, $order, $ip, $_SESSION['UID'], $lgid));
        // $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        // $htry->execute(array('Ledger', 13, 'Update', $_SESSION['UID'], $ip, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
    }
    return $res;
}
function delledgergroup($a)
{
    echo $ip = $_SERVER['REMOYR_ADDR'];
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?) ");
        $resa->execute(array("ledgergroup", "23", 'Delete', $_SESSION['UID'], $ip, $c, $_SESSION['COMPANY_ID']));
        $get = pFetch("DELETE FROM `ledgergroup` WHERE `ledgergroupid` =?", $c);
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4><!--<a href="' . $sitename . 'cheque/addcustomer.htm">Try Again</a>--></div>';
    return $res;
}
function getledgergroup($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `ledger_group` WHERE `ledgergroupid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function additem($itemcode = '', $barcode = '', $itemname = '', $invoicename = '', $isinventory = '', $issales = '', $ispurchasable = '', $isasset = '', $logo = '', $manufacturer = '', $brand = '', $group = '', $subgroup = '', $innergroup = '', $packageuom = '', $qtyperpackage = '', $unituom = '', $issku = '', $packsku = '', $unitsku = '', $margin = '', $purchasepackprice = '', $purchaseunitprice = '', $mrppackprice = '', $mrpunitprice = '', $salespackprice = '', $salesunitprice = '', $tax = '', $hsnsac = '', $inleger = '', $outleger = '', $warehouse = '', $mintax = '', $maintainstock = '', $getsup = '', $order = '', $status = '', $commoditycode = '0', $conversion = '0', $bom = '0', $ip = '', $itemid = '')
{
    global $db;
    list($isinventory, $issales, $ispurchasable, $isasset, $manufacturer, $brand, $group, $subgroup, $innergroup, $packageuom, $qtyperpackage, $unituom, $issku, $packsku, $unitsku, $margin, $purchasepackprice, $purchaseunitprice, $mrppackprice, $mrpunitprice, $salespackprice, $salesunitprice, $inleger, $outleger, $mintax, $maintainstock, $getsup, $order, $status, $ip, $conversion, $bom) = null_zero(array($isinventory, $issales, $ispurchasable, $isasset, $manufacturer, $brand, $group, $subgroup, $innergroup, $packageuom, $qtyperpackage, $packageuom/* $unituom */, $issku, $packsku, $unitsku, $margin, $purchasepackprice, $purchaseunitprice, $mrppackprice, $mrpunitprice, $salespackprice, $salesunitprice, $inleger, $outleger, $mintax, $maintainstock, $getsup, $order, $status, $ip, $conversion, $bom));
    if ($itemid == '') {
        /* $ress1 = $db->prepare("SELECT `Item_Code` FROM `item_master` WHERE `Status`!=?");
        $ress1->execute(array('2'));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') { */
        if ($brand == '') {
            $brand = '0';
        }
        if ($subgroup == '') {
            $subgroup = '0';
        }
        if ($innergroup == '') {
            $innergroup = '0';
        }
        if ($purchasepackprice == '') {
            $purchasepackprice = '0';
        }
        if ($purchaseunitprice == '') {
            $purchaseunitprice = '0';
        }
        if ($mrppackprice == '') {
            $mrppackprice = '0';
        }
        if ($mrpunitprice == '') {
            $mrpunitprice = '0';
        }
        if ($salespackprice == '') {
            $salespackprice = '0';
        }
        if ($salesunitprice == '') {
            $salesunitprice = '0';
        }
        if ($inleger == '') {
            $inleger = '0';
        }
        if ($outleger == '') {
            $outleger = '0';
        }
        if ($packageuom == '') {
            $packageuom = '0';
        }
        $resa = $db->prepare("INSERT INTO `item_master` (`Item_Code`,`Barcode`,`Item_Name`,`Invoice_Name`,`Is_Inventory`,`Is_Sales`,`Is_Purchase`,`Is_Asset`,`Logo`,`Manufacturer`,`Brand`,`Group`,`Sub_Group`,`Inner_Group`,`Package_UOM`,`Qty_Per_Package`,`Unit_UOM`,`Is_SKU`,`Pack_SKU`,`Unit_SKU`,`Margin`,`Purchase_Pack_Price`,`Purchase_Unit_Price`,`MRP_Pack_Price`,`MRP_Unit_Price`,`Sales_Pack_Price`,`Sales_Unit_price`,`Tax`,`HSN_SAC`,`InLedger`,`OuLedger`,`Warehouse`,`Minimum_Tax`,`Maintain_Stock`,`supplier_id`,`Order`,`Status`,`commodity_code`,`conversion`,`conversion_type`,`IP`,`Updated_by`,`company_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $resa->execute(array($itemcode, $barcode, $itemname, $invoicename, $isinventory, $issales, $ispurchasable, $isasset, $logo, $manufacturer, $brand, $group, $subgroup, $innergroup, $packageuom, $qtyperpackage, $unituom, $issku, $packsku, $unitsku, $margin, $purchasepackprice, $purchaseunitprice, $mrppackprice, $mrpunitprice, $salespackprice, $salesunitprice, $tax, $hsnsac, $inleger, $outleger, $warehouse, $mintax, $maintainstock, $getsup, $order, $status, $commoditycode, $conversion, $bom, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID']));
        $insert_id = $db->lastInsertId();
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Item', 2, 'Insert', $_SESSION['UID'], $ip, $insert_id, $_SESSION['COMPANY_ID']));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        /* } else {
    $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Type</h4></div>';
    } */
    } else {
        /* $ress1 = $db->prepare("SELECT `ItemID` FROM `item_type` WHERE `ItemType`=? AND `ItemID`!=?");
        $ress1->execute(array(strtolower(trim($a)), $e));
        $ress = $ress1->fetch(PDO::FETCH_ASSOC);
        if ($ress['ItemID'] == '') { */
        if ($brand == '') {
            $brand = '0';
        }
        if ($subgroup == '') {
            $subgroup = '0';
        }
        if ($innergroup == '') {
            $innergroup = '0';
        }
        if ($purchasepackprice == '') {
            $purchasepackprice = '0';
        }
        if ($purchaseunitprice == '') {
            $purchaseunitprice = '0';
        }
        if ($mrppackprice == '') {
            $mrppackprice = '0';
        }
        if ($mrpunitprice == '') {
            $mrpunitprice = '0';
        }
        if ($salespackprice == '') {
            $salespackprice = '0';
        }
        if ($salesunitprice == '') {
            $salesunitprice = '0';
        }
        if ($packageuom == '') {
            $packageuom = '0';
        }
        $resa = $db->prepare("UPDATE `item_master` SET `Item_Code`=?,`Barcode`=?,`Item_Name`=?,`Invoice_Name`=?,`Is_Inventory`=?,`Is_Sales`=?,`Is_Purchase`=?,`Is_Asset`=?,`Logo`=?,`Manufacturer`=?,`Brand`=?,`Group`=?,`Sub_Group`=?,`Inner_Group`=?,`Package_UOM`=?,`Qty_Per_Package`=?,`Unit_UOM`=?,`Is_SKU`=?,`Pack_SKU`=?,`Unit_SKU`=?,`Margin`=?,`Purchase_Pack_Price`=?,`Purchase_Unit_Price`=?,`MRP_Pack_Price`=?,`MRP_Unit_Price`=?,`Sales_Pack_Price`=?,`Sales_Unit_price`=?,`Tax`=?,`HSN_SAC`=?,`InLedger`=?,`OuLedger`=?,`Warehouse`=?,`Minimum_Tax`=?,`Maintain_Stock`=?,`supplier_id`=?,`Order`=?,`Status`=?,`commodity_code`=?,`conversion`=?,`conversion_type`=?,`IP`=?,`Updated_by`=? WHERE `company_id`=? AND `Item_Id`=?");
        $resa->execute(array($itemcode, $barcode, $itemname, $invoicename, $isinventory, $issales, $ispurchasable, $isasset, $logo, $manufacturer, $brand, $group, $subgroup, $innergroup, $packageuom, $qtyperpackage, $unituom, $issku, $packsku, $unitsku, $margin, $purchasepackprice, $purchaseunitprice, $mrppackprice, $mrpunitprice, $salespackprice, $salesunitprice, $tax, $hsnsac, $inleger, $outleger, $warehouse, $mintax, $maintainstock, $getsup, $order, $status, $commoditycode, $conversion, $bom, $ip, $_SESSION['UID'], $_SESSION['COMPANY_ID'], $itemid));
// $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
        // $htry->execute(array('Item', 2, 'Update', $_SESSION['UID'], $ip, $itemid));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated!</h4></div>';
        /* } else {
    $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Item Type</h4></div>';
    } */
    }
    return $res;
}
function getitem($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `item_master` WHERE `company_id`=? AND  `Item_id`=? AND `Status`!=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b, 2));
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
        $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`,`company_id`) VALUES (?,?,?,?,?,?,?)");
        $htry->execute(array('Item', 2, 'Delete', $_SESSION['UID'], $_SERVER['REMOTE_ADDR'], $c, $_SESSION['COMPANY_ID']));
        $get = $db->prepare("DELETE FROM `item_master` WHERE `company_id`=? AND `Item_Id` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
function getconversion($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `conversion` WHERE `company_id`=? AND `id`=?");
    $get1->execute(array($_SESSION['COMPANY_ID'], $b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delconversion($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $get = $db->prepare("DELETE FROM `conversion_details` WHERE `company_id`=? AND `conversion_id` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
        $get = $db->prepare("DELETE FROM `conversion` WHERE `company_id`=? AND `id` =? ");
        $get->execute(array($_SESSION['COMPANY_ID'], $c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    return $res;
}
function addcompanies($company_name, $contact_name, $email_address, $phone_number, $mobile_number, $username, $password, $address1, $address2, $area, $country, $state, $city, $postcode, $status, $ip, $logo, $margin, $margin_type, $tax, $default_tax, $mail_type, $mailer_host, $mailer_port, $mailer_secure, $mailer_username, $mailer_password, $sendgrid_username, $sendgrid_password, $bank_name, $branch_name, $acc_hold, $acc_no, $ifsc_code, $swift_code, $notes, $company_reg_no, $gst, $currency, $terms, $id)
{
    global $db;
    list($country, $state, $city, $currency, $margin, $margin_type, $default_tax, $mail_type, $status) = null_zero(array($country, $state, $city, $currency, $margin, $margin_type, $default_tax, $mail_type, $status));
    if ($id == '') {
        $add_comp = $db->prepare("INSERT INTO `companies` SET `company_name`=?,`contact_name`=?,`email_address`=?,`phone_number`=?,`mobile_number`=?,`username`=?,`password`=?,`address1`=?,`address2`=?,`area`=?,`country`=?,`state`=?,`city`=?,`postcode`=?,`status`=?,`ip`=?,`logo`=?,`margin`=?,`margin_type`=?,`tax`=?,`default_tax`=?,`mail_type`=?,`mailer_host`=?,`mailer_port`=?,`mailer_secure`=?,`mailer_username`=?,`mailer_password`=?,`sendgrid_username`=?,`sendgrid_password`=?,`bank_name`=?,`branch_name`=?,`acc_hold`=?,`acc_no`=?,`ifsc_code`=?,`swift_code`=?,`notes`=?,`company_reg_no`=?,`gst`=?,`currency`=?,`terms`=?,`datetime`=?");
        $add_comp->execute(array($company_name, $contact_name, $email_address, $phone_number, $mobile_number, $username, $password, $address1, $address2, $area, $country, $state, $city, $postcode, $status, $ip, $logo, $margin, $margin_type, $tax, $default_tax, $mail_type, $mailer_host, $mailer_port, $mailer_secure, $mailer_username, $mailer_password, $sendgrid_username, $sendgrid_password, $bank_name, $branch_name, $acc_hold, $acc_no, $ifsc_code, $swift_code, $notes, $company_reg_no, $gst, $currency, $terms, date("Y-m-d H:i:s")));
        $ins = $db->lastInsertId();
        $ins_bs = $db->prepare("INSERT INTO `bill_settings`(`type`,`prefix`,`format`,`current_value`,`page_type`,`company_id`) SELECT `type`,`prefix`,`format`,'1',`page_type`,'" . $ins . "' FROM `bill_settings` WHERE `company_id`='0'");
        $ins_bs->execute();
        $em_bs = $db->prepare("INSERT INTO `email_template`(`name`,`subject`,`message`,`instructions`,`page_type`,`company_id`) SELECT `name`,`subject`,`message`,`instructions`,`page_type`,'" . $ins . "' FROM `email_template` WHERE `company_id`='0'");
        $em_bs->execute();
        $pt_bs = $db->prepare("INSERT INTO `print_template`(`name`,`subject`,`footer_message`,`message`,`instructions`,`sign1`,`sign2`,`sign3`,`sign4`,`title1`,`title2`,`title3`,`title4`,`name1`,`name2`,`name3`,`name4`,`page_type`,`company_id`) SELECT `name`,`subject`,`footer_message`,`message`,`instructions`,`sign1`,`sign2`,`sign3`,`sign4`,`title1`,`title2`,`title3`,`title4`,`name1`,`name2`,`name3`,`name4`,`page_type`,'" . $ins . "' FROM `print_template` WHERE `company_id`='0'");
        $pt_bs->execute();
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
    } else {
        $upd_comp = $db->prepare("UPDATE `companies` SET `company_name`=?,`contact_name`=?,`email_address`=?,`phone_number`=?,`mobile_number`=?,`username`=?,`password`=?,`address1`=?,`address2`=?,`area`=?,`country`=?,`state`=?,`city`=?,`postcode`=?,`status`=?,`ip`=?,`logo`=?,`margin`=?,`margin_type`=?,`tax`=?,`default_tax`=?,`mail_type`=?,`mailer_host`=?,`mailer_port`=?,`mailer_secure`=?,`mailer_username`=?,`mailer_password`=?,`sendgrid_username`=?,`sendgrid_password`=?,`bank_name`=?,`branch_name`=?,`acc_hold`=?,`acc_no`=?,`ifsc_code`=?,`swift_code`=?,`notes`=?,`company_reg_no`=?,`gst`=?,`currency`=?,`terms`=? WHERE `id`=?");
        $upd_comp->execute(array($company_name, $contact_name, $email_address, $phone_number, $mobile_number, $username, $password, $address1, $address2, $area, $country, $state, $city, $postcode, $status, $ip, $logo, $margin, $margin_type, $tax, $default_tax, $mail_type, $mailer_host, $mailer_port, $mailer_secure, $mailer_username, $mailer_password, $sendgrid_username, $sendgrid_password, $bank_name, $branch_name, $acc_hold, $acc_no, $ifsc_code, $swift_code, $notes, $company_reg_no, $gst, $currency, $terms, $id));
        if ($margin != '') {
            if ($margin_type == '1') {
                $upd = $db->prepare("UPDATE `item_master` SET `Margin`=? WHERE `company_id`=?");
                $upd->execute(array($margin, $id));
            } elseif ($margin_type == '2') {
                $upd = $db->prepare("UPDATE `item_master` SET `Margin`=? WHERE IFNULL(`Margin`,'0')=? AND `company_id`=?");
                $upd->execute(array($margin, '0', $id));
            }
        }
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    }
    return $res;
}
function getcompanies($a = '', $b = '')
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `companies` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function delcompanies($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $log = getcompanies('logo', $c);
        if ($log != '') {
            unlink('../../images/company/' . $log);
        }
        $get = $db->prepare("DELETE FROM `companies` WHERE `id`='" . $c . "' ");
        $get->execute();
        if ($c != '0') {
            $get = $db->prepare("DELETE FROM `bill_settings` WHERE `company_id`='" . $c . "' ");
            $get->execute();
            $get = $db->prepare("DELETE FROM `email_template` WHERE `company_id`='" . $c . "' ");
            $get->execute();
            $get = $db->prepare("DELETE FROM `print_template` WHERE `company_id`='" . $c . "' ");
            $get->execute();
            $get = $db->prepare("DELETE FROM `currency_rates_new` WHERE `company_id`='" . $c . "' ");
            $get->execute();
        }
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";
    return $res;
}
function del_acc_payment($a)
{
    global $db;
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        $get = $db->prepare("DELETE FROM `accounts_payment` WHERE  `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND `id`='" . $c . "' ");
        $get->execute();
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Successfully Deleted</h4></div>';
    //$res="UPDATE `usermaster` SET `Status`='2' WHERE `uid` ='" . $c . "' ";
    return $res;
}
function addsalesregisterretail($customer, $freight_charges, $date, $paytype, $taxtype, $type, $billno, $order, $items, $total, $ftotal, $total_discount, $address1, $address2, $city, $state, $pincode, $rid)
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
        $resa = $db->prepare("INSERT INTO `sales_register_retail` SET `freight_charges`='" . $freight_charges . "', `customer`='" . $customer . "',`date`='" . $date . "', `paytype`='" . $paytype . "',`taxtype`='" . getcustomer('TaxType', $customer) . "',`billno`='" . $billno . "',`total`='" . $total . "',`ftotal`='" . $ftotal . "',`total_discount`='" . $total_discount . "', `company_id` ='" . $_SESSION['COMPANY_ID'] . "'   ");
        $resa->execute();
        $insert_id = $db->lastInsertId();
        $tdid = $insert_id . "_S";
        foreach ($item as $i => $im) {
            $resa_i = '';
            $resa_i = $db->prepare("INSERT INTO `sales_register_details_retail` SET `company_id`= '" . $_SESSION['COMPANY_ID'] . "' , `sid`='$insert_id',`item`='$im',`itemdesc`='$itemdesc[$i]', `qty`='$qty[$i]' ,`rate`='$uprice[$i]',`tax`='$tax[$i]',`discount`='$discount[$i]',`amount`='$amount[$i]' ,`discount_value`='$dval[$i]',`tax_value`='$tval[$i]' ,`igst_i`='$igst_i[$i]',`igst_ival`='$igst_ival[$i]',`sgst_i`='$sgst_i[$i]',`sgst_ival`='$sgst_ival[$i]',`cgst_i`='$cgst_i[$i]',`cgst_ival`='$cgst_ival[$i]' ,`unit`='$unit[$i]',`unitval`='" . getuom('Name', $unit[$i]) . "' ");
            $resa_i->execute();
        }
        $process = 'Inserted';
    } else {
        $resa = $db->prepare("UPDATE `sales_register_retail` SET `freight_charges`='" . $freight_charges . "', `customer`='" . $customer . "',`date`='" . $date . "', `paytype`='" . $paytype . "',`taxtype`='" . getcustomer('TaxType', $customer) . "',`billno`='" . $billno . "',`total`='" . $total . "',`ftotal`='" . $ftotal . "',`total_discount`='" . $total_discount . "' 	 WHERE `company_id`='" . $_SESSION['COMPANY_ID'] . "' AND `id`='$rid' ");
        $resa->execute();
        $insert_id = $rid;
        $tdid = $insert_id . "_S";
        foreach ($item as $i => $im) {
            $resa_i = '';
            if ($lastid[$i] == '') {
                $resa_i = $db->prepare("INSERT INTO `sales_register_details_retail` SET `company_id`='" . $_SESSION['COMPANY_ID'] . "', `sid`='$insert_id',`item`='$im',`itemdesc`='$itemdesc[$i]',`qty`='$qty[$i]' ,`rate`='$uprice[$i]',`tax`='$tax[$i]',`discount`='$discount[$i]',`amount`='$amount[$i]' ,`discount_value`='$dval[$i]',`tax_value`='$tval[$i]' ,`igst_i`='$igst_i[$i]',`igst_ival`='$igst_ival[$i]',`sgst_i`='$sgst_i[$i]',`sgst_ival`='$sgst_ival[$i]',`cgst_i`='$cgst_i[$i]',`cgst_ival`='$cgst_ival[$i]',`unit`='$unit[$i]',`unitval`='" . getuom('Name', $unit[$i]) . "'  ");
                $resa_i->execute();
            } else {
                $resa_i = $db->prepare("UPDATE `sales_register_details_retail` SET `company_id`='" . $_SESSION['COMPANY_ID'] . "', `sid`='$insert_id',`item`='$im',`itemdesc`='$itemdesc[$i]',`qty`='$qty[$i]' ,`rate`='$uprice[$i]',`tax`='$tax[$i]',`discount`='$discount[$i]',`amount`='$amount[$i]' ,`discount_value`='$dval[$i]',`tax_value`='$tval[$i]'   ,`igst_i`='$igst_i[$i]',`igst_ival`='$igst_ival[$i]',`sgst_i`='$sgst_i[$i]',`sgst_ival`='$sgst_ival[$i]',`cgst_i`='$cgst_i[$i]',`cgst_ival`='$cgst_ival[$i]',`unit`='$unit[$i]',`unitval`='" . getuom('Name', $unit[$i]) . "' WHERE `id`='$lastid[$i]' ");
                $resa_i->execute();
            }
        }
        $process = 'Updated';
    }
    $res['msg'] = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Succesfully ' . $process . '</h4></div>';
    $res['id'] = $insert_id;
    return $res;
}
function country_list($id = '', $multiple = '')
{
    global $db;
    $country = $db->prepare("SELECT * FROM `countries` WHERE `id`!=''");
    $country->execute();
    $select = '<select name="country' . $multiple . '" id="country' . $multiple . '" class="form-control" ><option value="0">Select Country</option>';
    while ($fetch = $country->fetch()) {
        $sel = ($fetch['id'] == $id) ? "selected" : '';
        $select .= '<option value="' . $fetch['id'] . '" ' . $sel . '>' . $fetch['name'] . '</option>';
    }
    $select .= '</select>';
    return $select;
}
function state_list($id = '', $cid = '', $multiple = '')
{
    global $db;
    $cid = ($cid) ? " AND `country_id`='$cid'" : " AND `id`='0'";
    $states = $db->prepare("SELECT * FROM `states` WHERE `id`!='' $cid");
    $states->execute();
    $select = '<select name="state' . $multiple . '" id="state' . $multiple . '" class="form-control" ><option value="0">Select State</option>';
    while ($fetch = $states->fetch()) {
        $sel = ($fetch['id'] == $id) ? "selected" : '';
        $select .= '<option value="' . $fetch['id'] . '" ' . $sel . '>' . $fetch['name'] . '</option>';
    }
    $select .= '</select>';
    return $select;
}
function city_list($id = '', $sid = '', $multiple = '')
{
    global $db;
    $sid = ($sid) ? " AND `state_id`='$sid'" : " AND `id`='0'";
    $cities = $db->prepare("SELECT * FROM `cities` WHERE `id`!='' $sid");
    $cities->execute();
    $select = '<select name="city' . $multiple . '" id="city' . $multiple . '" class="form-control" ><option value="0">Select City</option>';
    while ($fetch = $cities->fetch()) {
        $sel = ($fetch['id'] == $id) ? "selected" : '';
        $select .= '<option value="' . $fetch['id'] . '" ' . $sel . '>' . $fetch['name'] . '</option>';
    }
    $select .= '</select>';
    return $select;
}
function co($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `countries` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function st($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `states` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function ci($a, $b)
{
    global $db;
    $get1 = $db->prepare("SELECT * FROM `cities` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
function stock_del($id, $module_type)
{
    global $db;
    $val = ['PR' => 'purid', 'PRT' => 'pur_reid', 'SR' => 'salid', 'SRT' => 'salreid', 'DC' => 'dcinwid', 'DCRT' => 'dcreid'];
    $del = $db->prepare("DELETE FROM `stocks` WHERE `company_id`=? AND `$val[$module_type]`=?");
    $del->execute(array($_SESSION['COMPANY_ID'], $id));
}
function stock_add($id, $module_type, $stock_type, $screen, $item, $supplier, $qty, $pack_qty, $pack_uom, $item_uom, $total_qty, $pack_rate, $item_rate, $taxname, $taxable_amt, $tax_amt, $net_amt, $date)
{
    global $db;

    $val = ['PR' => 'purid', 'PRT' => 'pur_reid', 'SR' => 'salid', 'SRT' => 'salreid', 'DC' => 'dcinwid', 'DCRT' => 'dcreid', 'CONVERSION' => 'conversion'];

    //echo "INSERT INTO `stocks` SET `type`=?,`$val[$module_type]`=?,`stocktype`=?,`screen`=?,`proid`=?,`supplier_id`=?,`qty`=?,`packqty`=?,`package_uom`=?,`unit_uom`=?,`total_qty`=?,`packrate`=?,`salitemrate`=?,`taxid`=?,`taxableamt`=?,`taxamt`=?,`amount`=?,`date`=?,`created_date`=?,`ip`=?,`company_id`=?";

    $st = $db->prepare("INSERT INTO `stocks` SET `type`=?,`$val[$module_type]`=?,`stocktype`=?,`screen`=?,`proid`=?,`supplier_id`=?,`qty`=?,`packqty`=?,`package_uom`=?,`unit_uom`=?,`total_qty`=?,`packrate`=?,`salitemrate`=?,`taxid`=?,`taxableamt`=?,`taxamt`=?,`amount`=?,`date`=?,`created_date`=?,`ip`=?,`company_id`=?");
    $st->execute(array(
        $module_type,
        $id,
        $stock_type,
        $screen,
        $item,
        $supplier,
        $qty,
        $pack_qty,
        $pack_uom,
        $item_uom,
        $total_qty,
        $pack_rate,
        $item_rate,
        ($taxname) ? $taxname : '0',
        ($taxable_amt) ? $taxable_amt : '0',
        ($tax_amt) ? $tax_amt : '0',
        ($net_amt != '') ? $net_amt : '0',
        $date,
        date("Y-m-d H:i:s"),
        $_SERVER['REMOTE_ADDR'],
        $_SESSION['COMPANY_ID'],
    ));

}
function transaction_del($id, $type)
{
    global $db;
    $del = $db->prepare("DELETE FROM `transactions` WHERE `company_id`=? AND `ref_id`=? AND `screen`=?");
    $del->execute(array($_SESSION['COMPANY_ID'], $id, $type));
}
function add_transaction($bill_no, $bill_date, $ledger_id, $amount, $ref_id, $screen, $mode)
{
    global $db;
    $trs = $db->prepare("INSERT INTO `transactions` SET `created_date`=?,`bill_no`=?,`bill_date`=?,`ledger_id`=?,`amount`=?, `ref_id`=?,`screen`=?,`mode`=?,`ip`=?,`company_id`=?");
    $trs->execute(array(
        date("Y-m-d H:i:s"),
        $bill_no,
        date('Y-m-d', strtotime($bill_date)),
        $ledger_id,
        $amount,
        $ref_id,
        $screen,
        $mode,
        $_SERVER['REMOTE_ADDR'],
        $_SESSION['COMPANY_ID'],
    ));
}
function Currency($var)
{
    $var = str_replace("ALL", "Lek", $var);
    $var = str_replace("AED", "د.إ", $var);
    $var = str_replace("AFN", "؋", $var);
    $var = str_replace("ARS", "$", $var);
    $var = str_replace("AWG", "ƒ", $var);
    $var = str_replace("AUD", "$", $var);
    $var = str_replace("AZN", "ман", $var);
    $var = str_replace("BSD", "$", $var);
    $var = str_replace("BBD", "$", $var);
    $var = str_replace("BYR", "p.", $var);
    $var = str_replace("BZD", "BZ$", $var);
    $var = str_replace("BMD", "$", $var);
    $var = str_replace("BOB", '$b', $var);
    $var = str_replace("BAM", "KM", $var);
    $var = str_replace("BWP", "P", $var);
    $var = str_replace("BGN", "лв", $var);
    $var = str_replace("BRL", "R$", $var);
    $var = str_replace("BND", "$", $var);
    $var = str_replace("KHR", "៛", $var);
    $var = str_replace("CAD", "$", $var);
    $var = str_replace("KYD", "$", $var);
    $var = str_replace("CLP", "$", $var);
    $var = str_replace("CNY", "¥", $var);
    $var = str_replace("COP", "$", $var);
    $var = str_replace("CRC", "₡", $var);
    $var = str_replace("HRK", "kn", $var);
    $var = str_replace("CUP", "₱", $var);
    $var = str_replace("CZK", "KĿ", $var);
    $var = str_replace("DKK", "kr", $var);
    $var = str_replace("DOP", "RD$", $var);
    $var = str_replace("XCD", "$", $var);
    $var = str_replace("EGP", "£", $var);
    $var = str_replace("SVC", "$", $var);
    $var = str_replace("EUR", "€", $var);
    $var = str_replace("FKP", "£", $var);
    $var = str_replace("FJD", "$", $var);
    $var = str_replace("GHS", "¢", $var);
    $var = str_replace("GIP", "£", $var);
    $var = str_replace("GTQ", "Q", $var);
    $var = str_replace("GGP", "£", $var);
    $var = str_replace("GYD", "$", $var);
    $var = str_replace("HNL", "L", $var);
    $var = str_replace("HKD", "$", $var);
    $var = str_replace("HUF", "Ft", $var);
    $var = str_replace("ISK", "kr", $var);
    $var = str_replace("INR", "₹", $var);
    $var = str_replace("IDR", "Rp", $var);
    $var = str_replace("IRR", "﷼", $var);
    $var = str_replace("IMP", "£", $var);
    $var = str_replace("ILS", "₪", $var);
    $var = str_replace("JMD", "J$", $var);
    $var = str_replace("JPY", "¥", $var);
    $var = str_replace("JEP", "£", $var);
    $var = str_replace("KZT", "лв", $var);
    $var = str_replace("KPW", "₩", $var);
    $var = str_replace("KRW", "₩", $var);
    $var = str_replace("KGS", "лв", $var);
    $var = str_replace("LAK", "₭", $var);
    $var = str_replace("LBP", "£", $var);
    $var = str_replace("LRD", "$", $var);
    $var = str_replace("MKD", "ден", $var);
    $var = str_replace("MYR", "RM", $var);
    $var = str_replace("MUR", "₨", $var);
    $var = str_replace("MXN", "$", $var);
    $var = str_replace("MNT", "₮", $var);
    $var = str_replace("MZN", "MT", $var);
    $var = str_replace("NAD", "$", $var);
    $var = str_replace("NPR", "₨", $var);
    $var = str_replace("ANG", "ƒ", $var);
    $var = str_replace("NZD", "$", $var);
    $var = str_replace("NIO", "C$", $var);
    $var = str_replace("NGN", "₦", $var);
    $var = str_replace("KPW", "₩", $var);
    $var = str_replace("NOK", "kr", $var);
    $var = str_replace("OMR", "﷼", $var);
    $var = str_replace("PKR", "₨", $var);
    $var = str_replace("PAB", "B/.", $var);
    $var = str_replace("PYG", "Gs", $var);
    $var = str_replace("PEN", "S/.", $var);
    $var = str_replace("PHP", "₱", $var);
    $var = str_replace("PLN", "zł", $var);
    $var = str_replace("QAR", "﷼", $var);
    $var = str_replace("RON", "lei", $var);
    $var = str_replace("RUB", "руб", $var);
    $var = str_replace("SHP", "£", $var);
    $var = str_replace("SAR", "﷼", $var);
    $var = str_replace("RSD", "Дин.", $var);
    $var = str_replace("SCR", "₨", $var);
    $var = str_replace("SGD", "$", $var);
    $var = str_replace("SBD", "$", $var);
    $var = str_replace("SOS", "S", $var);
    $var = str_replace("ZAR", "R", $var);
    $var = str_replace("KRW", "₩", $var);
    $var = str_replace("LKR", "₨", $var);
    $var = str_replace("SEK", "kr", $var);
    $var = str_replace("CHF", "CHF", $var);
    $var = str_replace("SRD", "$", $var);
    $var = str_replace("SYP", "£", $var);
    $var = str_replace("TWD", "NT$", $var);
    $var = str_replace("THB", "฿", $var);
    $var = str_replace("TTD", "TT$", $var);
    $var = str_replace("TRY", "₺", $var);
    $var = str_replace("TVD", "$", $var);
    $var = str_replace("UAH", "₴", $var);
    $var = str_replace("GBP", "£", $var);
    $var = str_replace("USD", "$", $var);
    $var = str_replace("UYU", '$U', $var);
    $var = str_replace("UZS", "лв", $var);
    $var = str_replace("VEF", "Bs", $var);
    $var = str_replace("VND", "₫", $var);
    $var = str_replace("YER", "﷼", $var);
    $var = str_replace("ZWD", "Z$", $var);
    return $var;
}
function getNotifications($type = '', $table = '')
{
    global $db;
    $rfq = $db->prepare("SELECT * FROM `rfq` WHERE `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND  `status_approve`='wait_approve'");
    $rfq->execute();
    $rfq_count = $rfq->rowCount();
    $sq = $db->prepare("SELECT * FROM `sales_quote` WHERE `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND `status_approve`='wait_approve'");
    $sq->execute();
    $sq_count = $sq->rowCount();
    $so = $db->prepare("SELECT * FROM `sales_order` WHERE `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND `status_approve`='wait_approve'");
    $so->execute();
    $so_count = $so->rowCount();
    $po = $db->prepare("SELECT * FROM `purchase_order` WHERE `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND `status_approve`='wait_approve'");
    $po->execute();
    $po_count = $po->rowCount();
    $pr = $db->prepare("SELECT * FROM `purchase` WHERE `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND `status_approve`='wait_approve'");
    $pr->execute();
    $pr_count = $pr->rowCount();
    $dn = $db->prepare("SELECT * FROM `delivery_note` WHERE `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND `status_approve`='wait_approve'");
    $dn->execute();
    $dn_count = $dn->rowCount();
    $piv = $db->prepare("SELECT * FROM `perform_a_invoice` WHERE `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND `status_approve`='wait_approve'");
    $piv->execute();
    $piv_count = $piv->rowCount();
    $iv = $db->prepare("SELECT * FROM `invoice` WHERE `company_id`= '" . $_SESSION['COMPANY_ID'] . "' AND `status_approve`='wait_approve'");
    $iv->execute();
    $iv_count = $iv->rowCount();
    $total_count = $rfq_count + $sq_count + $so_count + $po_count + $pr_count + $dn_count + $piv_count + $iv_count;
    if ($type == 'count' && $table == 'total') {
        return $total_count;
    } else if ($type == 'count') {
        return ${$table . '_count'};
    } else {
        $data = ${$table};
        return $data->fetchAll();
    }
}
function null_zero($fields)
{
    if (!empty($fields)) {
        $new_fields = [];
        foreach ($fields as $field) {
            $new_fields[] = ($field == '' || strtolower($field) == 'nan') ? '0' : $field;
        }
    }
    if (!empty($new_fields)) {
        return $new_fields;
    } else {
        return $fields;
    }
}
function getCURL($url)
{
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
    $query = curl_exec($curl_handle);
    curl_close($curl_handle);
    return $query;
}
function update_new_rates1()
{
    global $db;
    $all_rates = array();
    $rates = json_decode(getCURL("https://api.fixer.io/latest?base=USD"), true);
    $all_rates[] = $rates;
    foreach ($rates['rates'] as $key => $newrates) {
        $rates1 = json_decode(getCURL("https://api.fixer.io/latest?base=" . $key), true);
        $all_rates[] = $rates1;
        sleep(1);
    }
    $trun = $db->prepare("TRUNCATE TABLE `currency_rates_new`");
    $trun->execute();
    foreach ($all_rates as $rates) {
        foreach ($rates['rates'] as $to => $value) {
            $add_rate = $db->prepare("INSERT INTO `currency_rates_new` SET `from_cur`=?,`to_cur`=?,`value`=?,`datetime`=?");
            $add_rate->execute(array($rates['base'], $to, $value, date("Y-m-d H:i:s")));
        }
    }
}
function update_new_rates()
{
    global $db;
    /* $data = file_get_contents('https://finance.google.com/finance/converter');
    preg_match('/<select name=from value="">(.*?)<\/select>/s', $data, $matches);
    $options = trim($matches[1]);
    preg_match_all('/<option (.*?)>(.*?)<\/option>/s', $options, $matches);
    $new_curr = [];
    foreach ($matches[1] as $val) {
    $nn = explode('=',$val);
    $new_curr[] = str_replace('"','',$nn[1]);
    } */
    $new_curr = [];
    $trun = $db->prepare("DELETE FROM `currency_rates_new` WHERE `company_id`=?");
    $trun->execute(array($_SESSION['COMPANY_ID']));
    $selected_currencies = getprofile('currency_mgnt') != '' ? getprofile('currency_mgnt') : 0;
    $cus = $db->prepare("SELECT * FROM `currency_new` WHERE `id` IN (" . $selected_currencies . ")");
    $cus->execute();
    while ($fcus = $cus->fetch()) {
        $new_curr[] = $fcus['code'];
    }
    if (!empty($new_curr)) {
        foreach ($new_curr as $from) {
            foreach ($new_curr as $to) {
                if ($from != $to) {
                    $data = file_get_contents('http://www.xe.com/currencyconverter/convert/?Amount=1&From=' . $from . '&To=' . $to);
                    preg_match("/<span class='uccResultAmount'>(.+?)<\/span>/i", $data, $matches);
                    $newprce = explode(' ', $matches[1]);
                    $newprce = ($newprce[0] != '') ? $newprce[0] : '0';
                    if ($newprce == '0') {
                        $url = "https://api.fixer.io/latest?base=" . $from . "&symbols=" . $to;
                        $handle = file_get_contents($url);
                        $data = json_decode($handle, true);
                        if ($data['rates'][$to] != '') {
                            $newprce = $data['rates'][$to];
                        } else {
                            $data = file_get_contents('https://finance.google.com/finance/converter?a=1&from=' . $from . '&to=' . $to);
                            preg_match("/<span class=bld>(.+?)<\/span>/i", $data, $matches);
                            $newprce = explode(' ', $matches[1]);
                            $newprce = ($newprce[0] != '') ? $newprce[0] : '0';
                        }
                    }
                    $add_rate = $db->prepare("INSERT INTO `currency_rates_new` SET `from_cur`=?,`to_cur`=?,`value`=?,`datetime`=?,`company_id`=?");
                    $add_rate->execute(array($from, $to, str_replace(',', '', $newprce), date("Y-m-d H:i:s"), $_SESSION['COMPANY_ID']));
                    sleep(0.5);
                }
            }
        }
    }
    unset($_SESSION['currency_rates']);
}
/*
$data = file_get_contents('https://finance.google.com/finance/converter',false,$context);
preg_match('/<select name=from value="">(.*?)<\/select>/s', $data, $matches);
$options = trim($matches[1]);
preg_match_all('/<option (.*?)>(.*?)<\/option>/s', $options, $matches);
$new_curr = [];
foreach ($matches[1] as $val) {
$nn = explode('=',$val);
$new_curr[] = str_replace('"','',$nn[1]);
}
$converted = [];
foreach($new_curr as $from){
foreach($new_curr as $to){
if($from != $to){
$converted[] = $from . "_" . $to;
}
/*if($from != $to){
$data = file_get_contents('https://finance.google.com/finance/converter?a=1&from='.$from.'&to='.$to);
preg_match("/<span class=bld>(.+?)<\/span>/i", $data, $matches);
$newprce = explode(' ',$matches[1]);
$converted[] = $from . "_" . $to . "=>" . ($newprce[0]!='') ? $newprce[0] : '0';
}
}
}
print_r($converted); */
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
function Send_Mail($TO, $SUBJECT, $MESSAGE)
{
    $mail_type = getprofile('mail_type');
    $FROM = getprofile('recoveryemail');
    $COMPANY = getprofile('Company_name');
    if ($mail_type == '2') {
        require 'phpmailer/vendor/autoload.php';
        $mail = new PHPMailer(true);
        try {
            //Use this link if error occurs on authentication, and enable that. https://accounts.google.com/DisplayUnlockCaptcha
            //Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = getprofile('mailer_host'); // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = getprofile('mailer_username'); // SMTP username
            $mail->Password = getprofile('mailer_password'); // SMTP password
            $mail->SMTPSecure = getprofile('mailer_secure'); // Enable TLS encryption, `ssl` also accepted
            $mail->Port = getprofile('mailer_port'); // TCP port to connect to
            //Recipients
            $mail->setFrom($FROM, $COMPANY);
            $mail->addAddress($TO); // Add a recipient
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $SUBJECT;
            $mail->Body = $MESSAGE;
            if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.1.81') {
                $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
            }
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            //$res='success';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } else if ($mail_type == '3') {
        require 'sendgrid/vendor/autoload.php';
        $sendgrid_username = getprofile('sendgrid_username');
        $sendgrid_password = getprofile('sendgrid_password');
        $sendgrid = new SendGrid($sendgrid_username, $sendgrid_password, array("turn_off_ssl_verification" => true));
        $email = new SendGrid\Email();
        $email->addTo($TO)->
            setFrom($COMPANY . ' ' . '<' . $FROM . '>')->
            setSubject($SUBJECT)->
            setText('')->
            setHtml($MESSAGE);
        //addSubstitution("%yourname%", array($COMPANY))->
        //addSubstitution("%how%", array("Owl"))->
        //addHeader('X-Sent-Using', 'SendGrid-API')->
        //addHeader('X-Transport', 'web');/*->
        //  addAttachment($attachment, $attchment_name);*/
        $response = $sendgrid->send($email);
    } else {
        $HEADERS = "From: " . $COMPANY . " < " . $FROM . " >\n";
        $HEADERS .= "X-Sender: " . $COMPANY . " < " . $FROM . " >\n";
        $HEADERS .= 'X-Mailer: PHP/' . phpversion();
        $HEADERS .= "X-Priority: 1\n"; // Urgent message!
        //$headers .= "Return-Path: itsolusenz1@gmail.com\n"; // Return path for errors
        $HEADERS .= "MIME-Version: 1.0\r\n";
        $HEADERS .= "Content-Type: text/html; charset=iso-8859-1\n";
        mail($TO, $SUBJECT, $MESSAGE, $HEADERS);
    }
}
if (isset($_REQUEST['sendmail'])) {
//Send_Mail('itsolusenz1@gmail.com', 'Test Subject', '<table><tr><td>Hi</td></tr></table>');
}
