<?php

include ('../config/config.inc.php');
if (isset($_POST['export_csv'])) {
    $loan = $db->prepare("SELECT * FROM `loan` ");
    $loan->execute();
    $i = '1';
    $header = "Loan";
    $data2.="S.no,CustomerID,Name,Mobile,Date_of_Pawn,TotalQuantity,Netweight,Amount,Interest,Status \n";


    while ($loanlist = $loan->fetch()) {
        if($loanlist['returnstatus'] == '2' || $loanlist['returnstatus'] == '1'){
            $status = 'Pawned';
        }else{
            $status = 'Returned';
        }
        
        $data2.= $i . "," . stripslashes($loanlist['customerid']) . "," . stripslashes($loanlist['name']) . "," . stripslashes($loanlist['mobileno']) . "," . stripslashes($loanlist['date']) . "," . stripslashes($loanlist['totalquantity']) . "," . stripslashes($loanlist['netweight']) . "," . $loanlist['amount'] . "," . $loanlist['interest'] . "," .$status. "\n";
        $i++;
        
    }

    if ($data2 == "") {
        $data2 = "\n(0) Records Found!\n";
    }

    //echo $data2; exit;


    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=invoice-export.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$data2";
}