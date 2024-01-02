<?php 
include ('../config/config.inc.php');
if(isset($_POST['export_csv'])){   
    $params = '';
if ($_GET['ledgergroup'] != '') {
        $params .= "AND `ledger_id` IN (" . $_GET['ledgergroup'] . ")";
   
}
if ($_GET['ledger'] != '') {
    $params .= " AND `ledger_id`='" . $_GET['ledger'] . "'";
}
if ($_GET['screen'] != '') {
    $params .= "AND `screen`='" . $_GET['screen'] . "'";
}
if ($_GET['fdate'] != '' && $_GET['tdate'] != '') {
    $params .= "AND (DATE(`created_date`)>='" . date("Y-m-d", strtotime($_GET['fdate'])) . "' AND DATE(`created_date`)<='" . date("Y-m-d", strtotime($_GET['tdate'])) . "' )";
}
if ($_GET['fdate'] != '' && $_GET['tdate'] == '') {
    $params .= "AND ((DATE(`created_date`)>='" . date("Y-m-d", strtotime($_GET['fdate'])) . "' OR DATE(`created_date`)<='" . date("Y-m-d") . "')  )";
}
if ($_GET['fdate'] == '' && $_GET['tdate'] != '') {
    $params .= "AND ((DATE(`created_date`)>='1970-01-01' OR DATE(`created_date`)<='" . date("Y-m-d", strtotime($_GET['tdate'])) . "')   )";
}
    $depart = "SELECT * FROM `transactions` WHERE `id`!='' AND `company_id`='".$_SESSION['COMPANY_ID']."' $params ORDER BY `bill_date` ASC";
   
    
    $i='1';
    $header = "Transaction";
    $data2.="S.no,Date,Ledger,Screen,Debit,Credit,Running Bal, \n";

   
    $sdepart = $db->prepare($depart);
                    $sdepart->execute();
                    $i = '1';
                    $oldmode = '';
                    $newmode = '';
                    $temp = 0;
                    while ($fdepart = $sdepart->fetch()) {
                        $newmode = $fdepart['mode'];
                        if ($fdepart['mode'] == 'C') {
                            $mode = 'Cr';
                            $omode = 'Dr';
                        } elseif ($fdepart['mode'] == 'D') {
                            $mode = 'Dr';
                            $omode = 'Cr';
                        }

                        if ($fdepart['mode'] == 'D') {
                            $damt += $fdepart['amount'];
                        }

                        if ($fdepart['mode'] == 'C') {
                            $camt += $fdepart['amount'];
                        }

                        if ($oldmode == '') {
                            $ramt = $fdepart['amount'];
                            $val = $ramt . ' ' . $mode;
                        } elseif ($oldmode == $newmode) {
                            // $ramt = ($ramt) + ($fdepart['amount']);
                            $ramt = bcadd($ramt, $fdepart['amount'], 2);
                            if ($ramt > 0 || $ramt == 0) {
                                $val = $ramt . ' ' . $mode;
                                $id = 0;
                            } else {
                                $ramt = ($ramt) * (-1);
                                $val = $ramt . ' ' . $omode;
                                $id = 1;
                            }
                        } else {
                            //      $ramt = ($ramt - $fdepart['amount']);
                            $ramt = bcsub($ramt, $fdepart['amount'], 2);
                            if ($ramt > 0 || $ramt == 0) {
                                $val = $ramt . ' ' . $omode;
                                $id = 1;
                            } else {
                                $ramt = ($ramt) * (-1);
                                $val = $ramt . ' ' . $mode;
                                $id = 0;
                            }
                        }


                        $i++;
                        if ($id == 1) {

                            $oldmode = $oldmode;
                        } else {

                            $oldmode = $newmode;
                        }

                        $_SESSION['damt'] = $damt;

                        $_SESSION['ramt'] = $ramt;

                        $_SESSION['camt'] = $camt;
                    }
                    
                    
                        $sel = $db->prepare($depart);
                        $sel->execute();
                     
                                    $i = '1';
                                    $oldmode = '';
                                    $newmode = '';
                                    $temp = 0;
                                    $temp1 = 0;
                                    $temp3 = 0;
                                    $damt = 0;
                                    $ramt = 0;
                                    $camt = 0;
                                    if ($sel->rowCount() > 0) {
                                       
                                        while ($fdepart = $sel->fetch()) {
                                            $newmode = $fdepart['mode'];
                                            if ($fdepart['mode'] == 'C') {
                                                $mode = 'Cr';
                                                $omode = 'Dr';
                                            } elseif ($fdepart['mode'] == 'D') {
                                                $mode = 'Dr';
                                                $omode = 'Cr';
                                            }
                                 
                                                    if ($fdepart['mode'] == 'D') {
                                                        $damt += $fdepart['amount'];
                                                        $temp =  ($fdepart['amount']);
                                                    }
                                                 
                                                    if ($fdepart['mode'] == 'C') {
                                                        
                                                        
                                                        $camt += $fdepart['amount'];
                                                        $temp1 =  ($fdepart['amount']);
                                                    }
                                                    if ($mode == 'Cr') {
                                                        $ramt = $ramt - $fdepart['amount'];
                                                    } else if ($mode == 'Dr') {
                                                        $ramt = $ramt + $fdepart['amount'];
                                                    } else {
                                                        $ramt += $fdepart['amount'];
                                                    }
                                                   
                                                    $temp3 =  str_replace('-', '', ($ramt)) . ' ' . $mode;
                                                    
                                            $i++;
                                            if ($id == 1) {
                                                $_SESSION['oldmode'] = $oldmode;
                                                $oldmode = $oldmode;
                                            } else {
                                                $_SESSION['newmode'] = $newmode;
                                                $oldmode = $newmode;
                                            }
                                        
                                        
                                        
      $data2.= $i . "," .date('d-m-Y', strtotime($fdepart['bill_date'])). "," . getledger('Name', $fdepart['ledger_id']). "," .stripslashes($fdepart['screen']).",".($temp).",".($temp1).",".($temp3)."\n";
        $i++;$temp3 = "";$temp1= "";$temp="";
        
                                    } 
                                        if ($damt != '' && $camt != '') {
                                               $no = ($damt);
                                            } else if ($damt != '') {
                                                $no = ($_SESSION['damt']);
                                            } else if ($camt != '') {
                                                $no3 =  ($_SESSION['camt']);
                                                $closecur = 'Cr';
                                            }
                                            if ($camt != '' && $damt == '') {
                                                $no3 = ($_SESSION['camt']);
                                                $closecur = 'Cr';
                                            } else if ($camt != '' && $damt != '') {
                                                $no1 = ($_SESSION['camt']);
                                                $no3 = ($_SESSION['camt']) - ($_SESSION['damt']);
                                            } else if ($camt == '' && $damt != '') {                                       
                                                $no3 =($_SESSION['damt']);
                                            }
                                                                                    if ($ramt != '') {
                                                //echo '<i class="fa fa-inr"></i>'.formatInIndianStyle($_SESSION['ramt']);
                                            } if ($id == 1) {
                                                //echo     $omode;
                                            } else {
                                                //  echo    $mode;
                                            }
                                            
                                            
                                            
                                        $no3 = $no1;
                                    
                                   $data2 .= " "." , "." ".", "." ".", "." ".", ".$no.", "."$no1"; 
                                        
                                        
                                        
                                    }
                   

    if ($data2 == "") {
        $data2 = "\n(0) Records Found!\n";
    }

    //echo $data2; exit;

    
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=transaction-export.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$data2";
}