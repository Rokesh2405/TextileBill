<?php
if (isset($_REQUEST['uid']) != '') {
    $thispageeditid = 40;
} else {
    $thispageaddid = 40;
}

include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['uid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // $msg = addusers($userid, $username, $password, $merchant,$permissiongroup, $status, $getid);
    $msg = addusers($userid, $username, $password, $merchant , $status, $getid);
}
?>
<script>
    function randomString()
    {
        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var string_length = 6;
        var randomstring = '';
        for (var i = 0; i < string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum, rnum + 1);
        }
        document.getElementById('password').value = randomstring;
        document.getElementById('changepwd').value = randomstring;
    }
    
    function loademail(a)
    {
        var asd = '';
        if (a != '') {
            var aa = a.split("##&&**");
            asd = aa[1];
        }
        document.getElementById('recoveryemailid').value = asd;
    }
    
    function chekusernm(auser)
    {
        if (auser !== '') {
            $.post(
                '<?php echo $sitename; ?>config/functions_ajax.php',
                {auser: auser},
                function (data) {
                    $('#vieum').html(data);
                }
            );
        }
    }
    
    function chekusav() {
        var k = $('#usav').val();
        if (k !== '') {
            if (k === '1') {
                $('#username').focus();
                return false;
            } else if (k === '0') {
                return true;
            }
        } else {
            return true;
        }
    }


    $(function () {
        $(".form_control").blur(function () {
            var PasswordVal = $('.password').val();
            var ConfirmPasswordVal = $('.confirmpassword').val();
            if (PasswordVal != ConfirmPasswordVal && ConfirmPasswordVal.length > 0 && PasswordVal.length > 0)
                $('reg-textbox').show();
            else
                $('reg-textbox').hide();

        });
    });

    function validatePassword()
    {
        var password = document.getElementById("password"), conpassword = document.getElementById("changepwd");
        if (password.value != conpassword.value) {
            conpassword.setCustomValidity("Confirm Password should match with the Password");
        } else {
            conpassword.setCustomValidity('');
        }
    }

    function multiple_company()
    {
        if ($('#check_mul').is(':checked')) {

            $("#multiple_company").css("display", "block");
        } else
        {
            $("#multiple_company").css("display", "none");
        }
    }

    function multiple_papad_company()
    {
        if ($('#check_mul_papad').is(':checked')) {

            $("#multiple_papad_company").css("display", "block");
        } else
        {
            $("#multiple_papad_company").css("display", "none");
        }
    }

    // password.onchange = validatePassword;
    //  conpassword.onkeyup = validatePassword;


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User 
            <small><?php
                if ($_REQUEST['uid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> User</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master</a></li>
            <li><a href="<?php echo $sitename; ?>settings/usermaster.htm"> User </a></li>
            <li class="active"><?php
                if ($_REQUEST['uid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form   action="#" method="post" autocomplete="off">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['uid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> User</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Name: <span style="color:#FF0000;">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter the Name" name="userid" id="userid" size="60"   required="required" value="<?php echo getusers('name', $_REQUEST['uid']); ?>"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Merchant<span style="color:#FF0000;">*</span></label>
                            <select name="merchant" id="merchant" class="form-control" required="required" >
                                <option value="">--Select Merchant--</option>
                               <?php
                            $merchantlist = pFETCH("SELECT * FROM `sales_merchant` WHERE `status`=?", '1');
                            while ($merchantfetch = $merchantlist->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                              <option value="<?php echo $merchantfetch['id']; ?>" <?php if ($merchantfetch['id'] == getusers('merchant', $_REQUEST['uid'])) {
                                    echo 'selected';
                                } ?>><?php echo $merchantfetch['merchantname'].' - '.$merchantfetch['merchantid']; ?></option>
                             <?php } ?> 


                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Login id<span style="color:#FF0000;">*</span></label>

                            <input type="text" min="6" class="form-control" placeholder="Enter the Login User Name" name="username" id="username" required="required" pattern="[0-9A-Za-z.-]{3,60}" title="Allowed Attributes (0-9A-Za-z.-)" onkeyup="chekusernm(this.value);" value="<?php echo getusers('val1', $_REQUEST['uid']); ?>" />
                            <br>

                            <span id='vieum' style="color: #F00;">

                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <?php if($_REQUEST['uid']=='') { ?>
                        <div class="col-md-4">
                            <label>Password <span style="color:#FF0000;">*</span></label>
                            <div class="input-group">  <span class="input-group-addon">
                                    <i class="fa fa-clock-o"  onclick="randomString();" style="cursor:pointer;"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Enter the password" name="password" id="password" size="60" minlength="6" maxlength="128" class="form-text" required="required" value="<?php //echo getusers('val2', $_REQUEST['uid']); ?>"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Confirm Password <span style="color:#FF0000;">*</span></label>
                            <div class="input-group"> <span class="input-group-addon">
                                    <i class="fa fa-clock-o"  onclick="randomString();" style="cursor:pointer;"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Retype password" name="changepwd" id="changepwd" size="60" minlength="6" maxlength="128" class="form-text" required="required" value="<?php //echo getusers('val2', $_REQUEST['uid']); ?>"  />
                            </div>
                        </div>
                         <?php } ?>
                        <div class="col-md-4">
                            <label>Status  <span style="color:#FF0000;">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php
                                if (getusers('val3', $_REQUEST['uid']) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if (getusers('val3', $_REQUEST['uid']) == '0') {
                                    echo 'selected';
                                }
                                ?>>Inactive</option>
                            </select>
                        </div>	
                    </div><br/>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?php echo $sitename; ?>settings/usermaster.htm">Back to Listings page</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;" onclick="validatePassword();"><?php
                                    if ($_REQUEST['uid'] != '') {
                                        echo 'UPDATE';
                                    } else {
                                        echo 'SAVE';
                                    }
                                    ?></button>
                            </div>
                        </div>
                    </div></div>
            </div>  </form>



        <!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#example-getting-started').multiselect();
        $('#example-getting-started1').multiselect();
    });
<?php if ($_REQUEST['uid'] == '') { ?>
        $('#username').blur(function () {
            chkinvo(0);
        });

        $('#submit').click(function () {
            return chkinvo(1);
        });
        function chkinvo(a) {
            var val = $('#username').val();
            if (val != '') {
                if (a == 0) {
                    $('#invoiceerr').html('<i class="fa fa-spinner fa-spin"></i>').css('color', '#000');
                }
                $.post('<?php echo $sitename; ?>pages/purchase/checkinvoice.php', {username: val}, function (data) {
                    if (data['res'] == '0') {
                        $('#username').focus();
                        $('#invoiceerr').html('Username already exist...').css({

                            'color': '#f00'
                        });
                        return false;
                    } else {
                        $('#invoiceerr').html('');
                        return true;
                    }
                }, 'json');
            }
        }
<?php } ?>
</script>

<script src="<?php echo $sitename; ?>bootstrap/js/multiselect.js" type="text/javascript"></script>