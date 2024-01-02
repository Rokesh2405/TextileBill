<?php
$menu = "3,5,,42";
$thispageid = 64;
include ('../../config/config.inc.php');
//include ('../../js/jquery.printPage.php');
//include ('../../js/jquery-1.4.4.min.php');


$dynamic = '1';
$datatable = '1';
$select2 = 1;
include ('../../require/header.php');
//$_SESSION['additemid'] = $_REQUEST['ledgergroupid'];
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = deltransaction($chk);
}

$params = '';
if ($_POST['ledgergroup'] != '') {
    $ledd = $db->prepare("SELECT GROUP_CONCAT(`lid`) as `ll` FROM `ledger` WHERE `under`='" . $_POST['ledgergroup'] . "'");
    $ledd->execute();
    $ledd = $ledd->fetch();
    if ($ledd['ll'] != '') {
        $params .= "AND `ledger_id` IN (" . $ledd['ll'] . ")";
    }
}
if ($_POST['ledger'] != '') {
    $params .= " AND `ledger_id`='" . $_POST['ledger'] . "'";
}
if ($_POST['screen'] != '') {
    $params .= "AND `screen`='" . $_POST['screen'] . "'";
}
if ($_POST['fdate'] != '' && $_POST['tdate'] != '') {
    //$params .= "AND ( (DATE(`created_date`)>='" . date("Y-m-d", strtotime($_POST['fdate'])) . "' AND DATE(`created_date`)<='" . date("Y-m-d", strtotime($_POST['tdate'])) . "' ) OR ( `bill_date`='" . date("Y-m-d", strtotime($_POST['tdate'])) . "'  ))";
    $params .= "AND (DATE(`created_date`)>='" . date("Y-m-d", strtotime($_POST['fdate'])) . "' AND DATE(`created_date`)<='" . date("Y-m-d", strtotime($_POST['tdate'])) . "' )";
}
if ($_POST['fdate'] != '' && $_POST['tdate'] == '') {
    $params .= "AND ((DATE(`created_date`)>='" . date("Y-m-d", strtotime($_POST['fdate'])) . "' OR DATE(`created_date`)<='" . date("Y-m-d") . "')  )";
}
if ($_POST['fdate'] == '' && $_POST['tdate'] != '') {
    $params .= "AND ((DATE(`created_date`)>='1970-01-01' OR DATE(`created_date`)<='" . date("Y-m-d", strtotime($_POST['tdate'])) . "')   )";
}
$depart = "SELECT * FROM `transactions` WHERE `id`!='' $params ORDER BY `bill_date` ASC";
//echo $depart;exit;
?>
<script type="text/javascript" >
    function validcheck(name)
    {
        var chObj = document.getElementsByName(name);
        var result = false;
        for (var i = 0; i < chObj.length; i++) {
            if (chObj[i].checked) {
                result = true;
                break;
            }
        }
        if (!result) {
            return false;
        } else {
            return true;
        }
    }
    function checkdelete(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Please confirm you want to Delete this?"))
            {
                return true;
            } else
            {
                return false;
            }
        } else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to delete.");
            return false;
        }
    }
</script>
<script type="text/javascript">
    function checkall(objForm) {
        len = objForm.elements.length;
        var i = 0;
        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }
    function setdate(a) {
        if (a === true) {
            $('#tdate').val('<?php echo date('d-M-Y'); ?>');
        } else {
            $('#tdate').val('');
        }
    }

</script>
<style type="text/css">
    .row { margin:0;}
    #transactionexampleex tbody tr td:nth-child(1),tbody tr td:nth-child(2), tbody tr td:nth-child(3),tbody tr td:nth-child(4),tbody tr td:nth-child(8),tbody tr td:nth-child(7) {
        text-align:center;
    }
</style>
<!--<style type="text/css">
    .row { margin:0;}
</style>-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Transaction 
           <!-- <small>Manage all Item </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa fa-money"></i> Accounts</li>
            <li class="active">Transaction</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <!--<h3 class="box-title"><a href="<?php echo $sitename; ?>accounts/addledger.htm">Add Ledger</a></h3>-->
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg;
                ?>

                <form name="searchform" id='searchform' method="post">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Ledger Group</label>
                            <select name="ledgergroup" id="ledgerg" class="form-control" onchange="getledg(this.value);">
                                <option value="">Show all</option>
                                <?php
                                $supp = $db->prepare("SELECT * FROM `ledger_group` ORDER BY `ledgergroupname`");
                                $supp->execute();
                                while ($fsupp = $supp->fetch()) {
                                    ?>
                                    <option value="<?php echo $fsupp['ledgergroupid']; ?>" <?php
                                    if ($_REQUEST['ledgergroup'] == $fsupp['ledgergroupid']) {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $fsupp['ledgergroupname']; ?></option>
                                        <?php } ?>
                            </select>
                        </div>              
                        <div class="col-md-2">
                            <label>Ledger</label>
                            <select name="ledger" id="ledger" class="form-control ledger_select2">
                                <option value="">Show all</option>
                                <?php
                                $searched = ($_POST['ledgergroup']!='') ? " AND `under`='".$_POST['ledgergroup']."'" : '';
                                $supp = $db->prepare("SELECT * FROM `ledger` WHERE `status`='1' $searched ORDER BY `Name`");
                                $supp->execute();

                                while ($fsupp = $supp->fetch()) {
                                    ?>
                                    <option value="<?php echo $fsupp['lid']; ?>" <?php
                                    if ($_REQUEST['ledger'] == $fsupp['lid']) {
                                        echo 'selected';
                                    }
                                    ?>><?php echo $fsupp['Name']; ?></option>
                                        <?php } ?>
                            </select>
                        </div>                       
                        <div class="col-md-2">
                            <label>From Date</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control usedatepicker" name="fdate" id="datete" value="<?php echo $_REQUEST['fdate']; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>To Date</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control usedatepicker" name="tdate" id="tdate" value="<?php
                                if ($_REQUEST['tdate']) {
                                    echo $_REQUEST['tdate'];
                                } else {
                                    echo date("d-M-Y");
                                }
                                ?>">
                            </div>
                            <br />
                            <input style="float:left" type="checkbox" name="asondate" id="asondate"  value="1" <?php
                            if ($_REQUEST['asondate'] == '1') {
                                echo 'checked';
                            }
                            ?> onclick="setdate(this.checked);"> &nbsp;&nbsp;As on date
                        </div>
                        <div class="col-md-2">
                            <label>Screen</label>
                            <select name="screen" id="screen" class="form-control">
                                <option value="">Show all</option>
                                <option value="Purchase_register">Purchase Register</option>
                                <option value="Purchase_return">Purchase Return</option>
                                <option value="Delivery_note">Delivery Note</option>
                                <option value="Payment">Payment</option>
                                <option value="Receipt">Receipt</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><input type="submit" class="btn btn-success" name="ssearch" value="Search"></div>
                        <div class="col-md-2"><input type="button" onclick="javascript:location.href = '<?php echo $sitename; ?>accounts/transaction.htm'" class="btn btn-info" value="Reset"></div>

                        <div class="col-md-2" style="display: none;">
                            <a target="__blank" class="btn btn-info" href="<?php echo $sitename; ?>outstanding/outstandingdetails" ><i class="fa fa-download "></i>&nbsp;&nbsp;EXPORT</a>
                        </div>


                        <div class="col-md-2">
                            <button type="button" class="btn btn-info" onclick="printDiv3(printdivs)"><i class="fa fa-print "></i>&nbsp;&nbsp;Print</button>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12"><hr/></div>
                    </div>
                </form>

                <form name="form1" method="post" action="">


                    <?php
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
                    ?>




                    <div class="table-responsive" id="ajax_details">

                        <?php
                        // $paging = new paging($depart, "10");
                        //   $sel = $paging->sql;

                        $sel = $db->prepare($depart);
                        $sel->execute();
                        // echo $sel->rowCount();
                        ?>

                       <div class="table-responsive" id="printdivs" style="text-align: center" >

                                <h1 style="display: none" id="headtitle">
                                    <?php echo getprofile('firstname', $_SESSION['UID']); ?>
<!-- <small>Manage all Item </small>-->
                                </h1>
                                <?php if ($_REQUEST['ledger'] != '') { ?>

                                    <h4 style="text-align:left">Ledger Name : <?php echo getledger('Name', $_REQUEST['ledger']); ?></h4>
                                <?php } ?>
                          

                            <table id="transactionexampleex" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th align="center"  width="5%">S.id</th>  
                                        <th align="center" width="15%">Date</th>
                                        <?php if ($_REQUEST['ledger'] == '') { ?>
                                            <th align="center" width="12%">Ledger</th> 
                                        <?php } ?>
                                        <th align="center" width="12%">Screen</th>  
                                        <th align="center" width="15%">Debit</th> 
                                        <th align="center" width="15%">Credit</th> 
                                        <th align="center" width="25%">Running Bal.</th> 
                                        <th align="center" width="5%" class="dotprint">View</th> 
                                    </tr>
                                </thead>

                                <tbody >
                                    <?php
                                    $i = '1';
                                    $oldmode = '';
                                    $newmode = '';
                                    $temp = 0;
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
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $i; ?></td>  
                                                <td align="center"><?php echo date('d-m-Y', strtotime($fdepart['created_date'])); ?></td>
                                                <?php if ($_REQUEST['ledger'] == '') { ?>
                                                    <td><?php
                                                        echo getledger('Name', $fdepart['ledger_id']);
                                                        ?></td>

                                                <?php } ?>                                        
                                                <td>
                                                    <?php
                                                    echo $fdepart['screen'];
                                                    ?>
                                                </td>   
                                                <td style="text-align: right;">
                                                    <?php
                                                    if ($fdepart['mode'] == 'D') {
                                                        $damt += $fdepart['amount'];
                                                        echo number_format($fdepart['amount'], '2', '.', '');
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="text-align: right;"> <?php
                                                    if ($fdepart['mode'] == 'C') {
                                                        $camt += $fdepart['amount'];
                                                        echo number_format($fdepart['amount'], '2', '.', '');
                                                    }
                                                    ?></td>
                                                <td align="right" style="text-align: right;"><?php
                                                    ; /*
                                                      if ($oldmode == '') {
                                                      $ramt = $fdepart['amount'];
                                                      $val = formatInIndianStyle($ramt) . ' ' . $mode;
                                                      } elseif ($oldmode == $newmode) {
                                                      // $ramt = ($ramt) + ($fdepart['amount']);
                                                      $ramt = bcadd($ramt,$fdepart['amount'],2);
                                                      if ($ramt > 0 || $ramt == 0) {
                                                      $val = formatInIndianStyle($ramt) . ' ' . $mode;
                                                      $id = 0;
                                                      } else {
                                                      $ramt = ($ramt) * (-1);
                                                      $val = formatInIndianStyle($ramt) . ' ' . $omode;
                                                      $id = 1;
                                                      }

                                                      } else {
                                                      //      $ramt = ($ramt - $fdepart['amount']);
                                                      $ramt = bcsub($ramt,$fdepart['amount'],2);
                                                      if ($ramt > 0 || $ramt == 0) {
                                                      $val = formatInIndianStyle($ramt) . ' ' . $omode;
                                                      $id = 1;
                                                      } else {
                                                      $ramt = ($ramt) * (-1);
                                                      $val = formatInIndianStyle($ramt) . ' ' . $mode;
                                                      $id = 0;
                                                      }

                                                      echo $mode;


                                                      } */
                                                    if ($mode == 'Cr') {
                                                        $ramt = $ramt - $fdepart['amount'];
                                                    } else if ($mode == 'Dr') {
                                                        $ramt = $ramt + $fdepart['amount'];
                                                    } else {
                                                        $ramt += $fdepart['amount'];
                                                    }
                                                    echo str_replace('-', '', number_format($ramt, '2', '.', '')) . ' ' . $mode;
                                                    ?></td>
                                                <td class="dotprint" style="text-align: center;"><span style="color: #000000;cursor: pointer;" onclick='show_details(<?php echo $fdepart['id']; ?>);'  data-toggle="modal" data-target="#myModal"><i class="fa fa-eye" aria-hidden="true"></i></span></td>
                                            </tr>
                                            <?php
                                            $i++;
                                            if ($id == 1) {
                                                $_SESSION['oldmode'] = $oldmode;
                                                $oldmode = $oldmode;
                                            } else {
                                                $_SESSION['newmode'] = $newmode;
                                                $oldmode = $newmode;
                                            }
                                        }
                                    } else {
                                        ?>
                                        <tr><td colspan="8" style="text-align:center"> No Data Found </td></tr>   
                                    <?php }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <?php if ($_REQUEST['ledger'] == '') { ?>
                                            <th colspan="4">&nbsp;</th>
                                        <?php } else { ?>
                                            <th colspan="3">&nbsp;</th>
                                        <?php } ?>

                                        <th align="right" style="text-align: right;"><?php
                                            if ($damt != '' && $camt != '') {

                                                echo number_format($_SESSION['camt'], '2', '.', '');
                                            } else if ($damt != '') {


                                                echo number_format($_SESSION['damt'], '2', '.', '');
                                            } else if ($camt != '') {
                                                echo $closingbalance = number_format($_SESSION['camt'], '2', '.', '');
                                                $closecur = 'Cr';
                                            }
                                            ?></th>
                                        <th align="right" style="text-align: right;"><?php
                                            if ($camt != '' && $damt == '') {
                                                echo $closingbalance = number_format($_SESSION['camt'], '2', '.', '');
                                                $closecur = 'Cr';
                                            } else if ($camt != '' && $damt != '') {

                                                echo number_format($_SESSION['camt'], '2', '.', '');
                                                $closingbalance = number_format($_SESSION['camt'], '2', '.', '') - number_format($_SESSION['damt'], '2', '.', '');
                                            } else if ($camt == '' && $damt != '') {

                                                echo $closingbalance = number_format($_SESSION['damt'], '2', '.', '');
                                            }
                                            ?></th>
                                        <th align="right" style="text-align: right;"><?php
                                            if ($ramt != '') {
                                                //echo '<i class="fa fa-inr"></i>'.formatInIndianStyle($_SESSION['ramt']);
                                            } if ($id == 1) {
                                                //echo     $omode;
                                            } else {
                                                //  echo    $mode;
                                            }
                                            ?></th>
                                    </tr>


                                    <tr style="display: none;">

                                        <?php if ($_REQUEST['ledger'] == '') { ?>
                                            <th colspan="4">&nbsp;</th>
                                        <?php } else { ?>
                                            <th colspan="3">&nbsp;</th>
                                        <?php } ?>

                                        <th align="right" style="text-align: right;">Closing Balance</th>
                                        <th align="right" style="text-align: right;"><?php echo number_format($closingbalance, '2', '.', ''); ?></th>
                                        <th></th>
                                    </tr>


                                </tfoot>




                            </table>

                        </div> 
                        <?php //echo $paging->show_paging_ajax($_REQUEST['URI'], "33", "transactions"); ?>
                    </div>                 

                    <input type="hidden" id="ledgerhidden" value="<?php echo $_REQUEST['ledger'] ?>" />
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
//    function editthis(a)
//    {
//        var did = a;
//        window.location.href = '<?php // echo $sitename;   ?>accounts/' + a + '/editledger';
//    }
    function show_details(a) {
        $('#viewdet').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
        $.post('<?php echo $sitename; ?>pages/master/userajax.php', {transview: '1', id: a}, function (data) {
            $('#viewdet').html(data);
        });
    }


    function printDiv3(printdivs) {

//       $("#headtitle").css("display", "block");
        
//        var newWin = window.open('', 'Print-Window');
//
//        newWin.document.open();
//
//        newWin.document.write('<html><body onload="window.print()">' + printContents.innerHTML + '</body></html>');
//
//        newWin.document.close();
//
//        setTimeout(function () { newWin.close();}, 10);

        var originalContents = document.body.innerHTML;
        $('#printdivs table thead tr th:last').remove();
        $('#printdivs table tbody tr').each(function(){
            $(this).find('td:last').remove();
        });
        var printContents = document.getElementById("printdivs").innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<?php
include ('../../require/footer.php');
?>
<script>
    setTimeout(function () {
        $('.iCheck-helper').eq(0).click(function () {
            setdate(document.getElementById('asondate').checked);
        });
    }, 500);

    /* $('#examplenew').dataTable( {
     "bProcessing": true,
     "bServerSide": true,
     "scrollX": true,
     "searching": false,
     "sAjaxSource": "<?php echo $sitename; ?>pages/accounts/newvalues.php"
     } );*/

</script>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Details</h4>
            </div>
            <div class="modal-body" id="viewdet">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function getledg(l) {
        if (l !== '') {
            $('#ledger').html('<option value=""><i class="fa fa-spinner fa-spin"></i></option>');
            $.post('<?php echo $sitename; ?>pages/master/userajax.php', {get_ledger: '1', ledg_un: l}, function (data) {
                $('#ledger').html(data);
            });
        }
    }
</script>
<!--<script type="text/javascript">
    $('#transactionexampleex').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.htm?types=transactiontable"
    });
</script>-->
