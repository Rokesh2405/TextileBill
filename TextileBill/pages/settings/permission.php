<?php
$thispageid = 41;
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
$_SESSION['pid'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
$chk = $_REQUEST['chk'];
$chk = implode('.', $chk);
$msgg = delpermission($chk);
}
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
            if (confirm("Please confirm you want to Delete this  Employee(s) In Permission Group(s)"))
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

    function chagenstatus(a, b) {

        var act = $('#statchng' + b).val();
        var method = '';
        if (act === '1') {
            method = 'Inactive';
        } else if (act === '0') {
            method = 'Active';
        }
        if (confirm("Do you want to change this as " + method + "?")) {

            $.post('<?php echo $sitename; ?>pages/changestatus.php',
                    {id: a, type: act, row: b, page: 'permission'},
                    function (data) {
                        $('#chgsta' + b).html(data);
                    }
            );
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
</script>
<style type="text/css">
    .row { margin:0;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Permission Groups
            <small>Permission Groups Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i>&nbsp;Settings</a></li>

            <li class="active"><i class="fa fa-user"></i>&nbsp;&nbsp;Permission Groups</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>settings/permissionx.htm">Add New Permission</a></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">S.id</th>
                                    <th>Name</th>
                                    <th align="center" width="10%">Status</th>
                                    <th data-sortable="false" align="center" width="10%" style="text-align: center; padding-right:0; padding-left: 0;">Edit</th>
                                    <th data-sortable="false" align="center" width="10%" style="text-align: center; padding-right:0; padding-left: 0;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = '1';
                                $depart = pFETCH("SELECT * FROM `permission` WHERE `perid`!=?", '');
                                while ($fdepart = $depart->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo getpermission('pername', $fdepart['perid']); ?></td>
                                    <td width="10%"><?php
                                        if ($fdepart['status'] == '1') {
                                        echo 'Active';
                                        } else {
                                        echo 'Inactive';
                                        }
                                        ?></td>
                                    <td align="center" width="10%"><i class="fa fa-edit" onclick="javascript:editthis('<?php echo $fdepart['perid']; ?>');" style="cursor:pointer;"></i></td>
                                    <td align="center" width="10%"><input type="checkbox" name="chk[]" id="chk[]" value="<?php echo $fdepart['perid']; ?>" /></td>
                                </tr>
                                <?php
                                $i++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">&nbsp;</th>
                                    <th style="margin:0px auto;"><button type="submit" class="btn btn-danger"  style="width:100%;" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>

            </div><!-- /.box-body -->
        </div>
</div>

</div>
<!-- /.box -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>settings/' + a + '/permissionx.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>
