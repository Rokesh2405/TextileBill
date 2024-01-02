<?php

include 'config/config.inc.php';
//$service = $_REQUEST['service'];
//$bankdate = $db->prepare("SELECT * FROM `bankstatus` WHERE `date`=? AND `status`=? LIMIT 20");
$bankdate = $db->prepare("SELECT * FROM `bankstatus`");
$bankdate->execute();

 function dateDiffInDays($date1, $date2) {
        // Calulating the difference in timestamps 
        $diff = strtotime($date2) - strtotime($date1);

        // 1 day = 24 hours 
        // 24 * 60 * 60 = 86400 seconds 
        return abs(round($diff / 86400));
    }
while ($bank = $bankdate->fetch(PDO::FETCH_ASSOC)) {





// PHP code to find the number of days 
// between two given dates 
// Function to find the difference 
// between two dates. 
   

// Start date 
    $date1 = date('d-m-Y');
//echo $date1;
// End date 
    $date2 = $bank['dateofpawn'];
//echo $date2;
// Function call to find date difference 
    $dateDiff = dateDiffInDays($date1, $date2);

// Display the result  
 $qry = FETCH_all("SELECT * FROM `remainder` WHERE `bankid`=? ORDER BY `id` DESC",$bank['id']);
// $j = 5;
if($qry['countdays'] < 6){
//for ($i = 3; $i >= 2; $i--) {
    if ($dateDiff >= 85 && $dateDiff <= 90) {
       
        
        if($qry['bankid'] != ''){
         $count = $qry['countdays'] + 1;    
        }
        else{
           $count = 1; 
        }
        $remainder = $db->prepare("INSERT INTO `remainder` (`bankid`,`dateofpawn`,`currentdate`,`countdays`) VALUES (?,?,?,?)");
        $remainder->execute(array($bank['id'],$bank['dateofpawn'],date('d-m-Y'),$count));
//        echo '<a class="btn btn-danger waves-effect waves-light" href="javascript:;" onclick="$.Notification.notify("error,top left, Sample Notification, Remainder ")">Error</a>';
    
            
        } else {
        doNothing();
    }
}else{
    doNothing();
}
//}



}
function doNothing() {
//    echo '<a class="btn btn-danger waves-effect waves-light" href="javascript:;" onclick="$.Notification.notify("error,top left, Sample Notification, Nothing to Remainder ")">Error</a>';
}
//$pcount = $servlist->rowcount();
//if($pcount>0)
//{ 
?>

<?php // while ($servlisting = $servlist->fetch(PDO::FETCH_ASSOC)) {
?>
<!--        <script src="assets/js/jquery.min.js"></script>
        <script src="plugins/notifyjs/js/notify.js"></script>
        <script src="plugins/notifications/notify-metro.js"></script>-->
 