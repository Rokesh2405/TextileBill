<?php
if (isset($_REQUEST['id'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,28";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];


    for ($i = 0; $i < count($_FILES['proof1']['name']); $i++) {

        if ($_FILES['proof1']['name'][$i]) {
            $main = $_FILES['proof1']['name'][$i];
            $tmp = $_FILES['proof1']['tmp_name'][$i];
            $extension = getExtension($main);
            $extension = strtolower($extension);
            $m = time() . rand();
            $image = $m . "." . $extension;
            move_uploaded_file($tmp, '../../../img/proof/' . $image);


            if ($proof1 == '') {
                $proof1 = $image;
            } else {
                $proof1 .= "," . $image;
            }
        }
    }
    $proofname = implode(',', $proofname1);
    $proof = implode(',', $proof1);

    $object = implode(',', $object1);
    $quantity = implode(',', $quantity1);



    $msg = addobjectsilver($objectname, $status, $getid);
}

// if (isset($_REQUEST['id']) && ($_REQUEST['id'] != '')) {
//     $get1 = $db->prepare("SELECT * FROM `object` WHERE `id`=?");
//     $get1->execute(array($_REQUEST['id']));
//     $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
// }
function addenquiry($name, $emailid, $phone, $message, $ip, $getid) {
    if ($getid == '') {
        $link22 = FETCH_ALL("SELECT * FROM `customer_enquiry` WHERE `cid`=?", $getid);
        if ($link22['id'] == '') {
            $resa = $db->prepare("INSERT INTO `customer_enquiry` (`name`,`emailid`, `phone`,`message`) VALUES(?,?,?,?)");
            $resa->execute(array($name, $emailid, $phone, $message));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            $_SESSION['msg'] = $res;
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> already exists!</h4></div>';
            $_SESSION['msg'] = $res;
        }
    }
}
?>

<script>
    // function randomString()
    // {
    //     var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    //     var string_length = 6;
    //     var randomstring = '';
    //     for (var i = 0; i < string_length; i++) {
    //         var rnum = Math.floor(Math.random() * chars.length);
    //         randomstring += chars.substring(rnum, rnum + 1);
    //     }
    //     document.getElementById('password').value = randomstring;
    //     document.getElementById('changepwd').value = randomstring;
    // }

    // $(function () {
    //     $(".form_control").blur(function () {
    //         var PasswordVal = $('.password').val();
    //         var ConfirmPasswordVal = $('.confirmpassword').val();
    //         if (PasswordVal != ConfirmPasswordVal && ConfirmPasswordVal.length > 0 && PasswordVal.length > 0)
    //             $('reg-textbox').show();
    //         else
    //             $('reg-textbox').hide();

    //     });
    // });

</script>   


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Silver Object
            <small><?php
if ($_REQUEST['id'] != '') {
    echo 'Edit';
} else {
    echo 'Add New';
}
?>Silver Object</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/object.htm"><i class="fa fa-circle-o"></i> Silver Object</a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Silver Object</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Silver Object</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
<?php echo $msg; ?>
                    <div class="row">

                        <div class="col-md-4">
                            <label>Object name<span style="color:#FF0000;">*</span></label>
<?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
?>
                            <input type="text" name="objectname" id="objectname" class="form-control" placeholder="Enter the Object name" value="<?php echo getobjectsilver('objectname', $_REQUEST['id']); ?>" />
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" <?php
if (stripslashes(getobjectsilver('status', $_REQUEST['id'])) == '1') {
    echo 'selected';
}
?>>Active</option>
                                <option value="0" <?php
                                if (stripslashes(getobjectsilver('status', $_REQUEST['id']) == '0')) {
                                    echo 'selected';
                                }
                                ?>>Inactive</option>

                            </select>

                        </div>             
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>pages/process/object.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">

    function show_contacts(id) {
        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            data: {get_contacts_of_customer: id}
        }).done(function (data) {
            $('#choose_contacts_grid_table tbody').html(data);
        });
    }


    function delrec(elem, id) {
        if (confirm("Are you sure want to delete this Object?")) {
            $(elem).parent().remove();
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getobjectsilver('id', $_REQUEST['id']); ?>/editprovider.htm?delid=" + id;
        }
    }


    $(document).ready(function (e) {

        $('#add_task').click(function () {


            var data = $('#firsttasktr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Offer?")) {
                    $(this).parent().remove();
                    re_assing_serial();

                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#task_table tbody').append(data);
            $('.usedatepicker').datepicker({
                autoclose: true
            });


            re_assing_serial();

        });

        $('#add_proof').click(function () {


            var data = $('#firstprooftr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Proof?")) {
                    $(this).parent().remove();
                    re_assing_serial();

                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#proof_table tbody').append(data);
            $('.usedatepicker').datepicker({
                autoclose: true
            });


            re_assing_serial();

        });



    });

    function del_addi(elem) {
        if (confirm("Are you sure want to remove this?")) {
            elem.parent().parent().remove();
            additionalprice();
        }
    }





    function re_assing_serial() {
        $("#task_table tbody tr").not('#firsttasktr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1 + 1);
        });
        $("#proof_table tbody tr").not('#firstprooftr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1 + 1);
        });
    }

</script>