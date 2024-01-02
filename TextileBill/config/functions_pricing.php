<?php

/* Pricing Category Start here */

function addpricingcategory($category, $order, $status,$ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `cid` FROM `pricingcategory` WHERE `category`=?", $category);
        if ($link1['cid'] == '') {
           
                $resa = $db->prepare("INSERT INTO `pricingcategory` (`category`,`order`,`status`) VALUES(?,?,?)");
                $resa->execute(array($category, $order, $status));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Pricing Category Mgmt', 15, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
           
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Category already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `cid` FROM `pricingcategory` WHERE `category`=? AND `cid`!=?", $category, $getid);
        if ($link1['cid'] == '') {
           
                $resa = $db->prepare("UPDATE `pricingcategory` SET `category`=?,`order`=?,`status`=? WHERE `cid`=?");
                $resa->execute(array(trim($category), trim($order), $status, $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Pricing Category Mgmt', 15, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
          
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Category already exists!</h4></div>';
        }
    }
    return $res;
}

function delpricingcategory($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
		$get = $db->prepare("DELETE FROM `pricingcategory` WHERE `cid` = ? ");
        $get->execute(array($c));
		
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getpricingcategory($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `pricingcategory` WHERE `cid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function addpricing($title, $riskfactors, $priceperuom,$minamount,$status,$ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `id` FROM `pricing` WHERE `title`=?", $title);
        if ($link1['id'] == '') {
           
                $resa = $db->prepare("INSERT INTO `pricing` (`title`,`riskfactors`,`priceperuom`,`status`) VALUES(?,?,?,?)");
                $resa->execute(array($title, $riskfactors,$priceperuom,$status));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Pricing Mgmt', 17, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
           
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `pricing` WHERE `title`=? AND `id`!=?", $title, $getid);
        if ($link1['id'] == '') {
           
                $resa = $db->prepare("UPDATE `pricing` SET `title`=?,`riskfactors`=?,`priceperuom`=?,`status`=? WHERE `id`=?");
                $resa->execute(array(trim($title), trim($riskfactors),  trim($priceperuom), $status, $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Pricing Mgmt', 17, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
          
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Title already exists!</h4></div>';
        }
    }
    return $res;
}

function delpricing($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
		 $get = $db->prepare("DELETE FROM `pricing` WHERE `id` = ? ");
        $get->execute(array($c));
        
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getpricing($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `pricing` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function adduom($name, $purpose, $order, $status,$ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `id` FROM `uom` WHERE `name`=?", $name);
        if ($link1['id'] == '') {
           
                $resa = $db->prepare("INSERT INTO `uom` (`name`,`purpose`,`order`,`status`) VALUES(?,?,?,?)");
                $resa->execute(array($name, $purpose,$order, $status));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Pricing UOM Mgmt', 16, 'INSERT', $_SESSION['UID'], $ip, $id));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
           
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `uom` WHERE `name`=? AND `id`!=?", $name, $getid);
        if ($link1['id'] == '') {
           
                $resa = $db->prepare("UPDATE `uom` SET `name`=?,`purpose`=?,`order`=?,`status`=? WHERE `id`=?");
                $resa->execute(array(trim($name), trim($purpose), trim($order), $status, $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Pricing UOM Mgmt', 16, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Name already exists!</h4></div>';
        }
    }
    return $res;
}

function deluom($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("UPDATE `uom` SET `status`=? WHERE `id` = ? ");
        $get->execute(array('2',$c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getuom($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `uom` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addpricingrange($title,$pricecategory, $min_range, $max_range,$price,$ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `id` FROM `pricingrange` WHERE `title`=? AND `pricecategory`=?", $title,$pricecategory);
        if ($link1['id'] == '') {
           
		$resa = $db->prepare("INSERT INTO `pricingrange` (`title`,`pricecategory`,`min_range`,`max_range`,`price`) VALUES(?,?,?,?,?)");
		$resa->execute(array($title,$pricecategory, $min_range, $max_range,$price));

		$htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
		$htry->execute(array('Pricing Range Mgmt', 17, 'INSERT', $_SESSION['UID'], $ip, $id));

		$res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
   
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `pricingrange` WHERE `title`=? AND `pricecategory`=? AND `id`!=?", $title, $pricecategory , $getid);
        if ($link1['id'] == '') {
           
                $resa = $db->prepare("UPDATE `pricingrange` SET `title`=?,`pricecategory`=?,`min_range`=?,`max_range`=?,`price`=? WHERE `id`=?");
                $resa->execute(array(trim($title), trim($pricecategory), trim($min_range),  trim($max_range),  trim($price), $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Pricing Range Mgmt', 17, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
          
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Title already exists!</h4></div>';
        }
    }
    return $res;
}



function delpricingrange($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `pricingrange` WHERE `id` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getpricingrange($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `pricingrange` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addadditionalcharge($name, $charge, $description,$status,$ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `id` FROM `additional_charges` WHERE `name`=?", $name);
        if ($link1['id'] == '') {
           
		$resa = $db->prepare("INSERT INTO `additional_charges` (`name`,`charge`,`description`,`status`) VALUES(?,?,?,?)");
		$resa->execute(array($name, $charge, $description,$status));

		$htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
		$htry->execute(array('Additional Charges Mgmt', 17, 'INSERT', $_SESSION['UID'], $ip, $id));

		$res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
   
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `id` FROM `additional_charges` WHERE `name`=? AND `id`!=?", $name, $getid);
        if ($link1['id'] == '') {
           
                $resa = $db->prepare("UPDATE `additional_charges` SET `name`=?,`charge`=?,`description`=?,`status`=? WHERE `id`=?");
                $resa->execute(array(trim($name), trim($charge), trim($description),  trim($status),  $getid));

                $htry = $db->prepare("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)");
                $htry->execute(array('Additional Charges Mgmt', 17, 'UPDATE', $_SESSION['UID'], $ip, $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
          
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Name already exists!</h4></div>';
        }
    }
    return $res;
}



function deladditionalcharge($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
		$get = $db->prepare("DELETE FROM `additional_charges` WHERE `id` = ? ");
        $get->execute(array($c));
		
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getadditioncharge($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `additional_charges` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}
?>