<?php
$menu = "11,29";
$thispageid = 40;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';

include ('../../require/header.php');

$_SESSION['sendgrid_id'] = '';

if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delsendgrid($chk);
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
            if (confirm("Please confirm you want to Delete this Send Grid(s)"))
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
</script>
<style type="text/css">
    .row { margin:0;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Send Grid 
            <small>Manage All The Send Grid Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-users"></i>Send grid</a></li>
            <li class="active">Send grid </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>settings/addsendgrid.htm">Add Send Grid</a></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
<?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:10%;">API KEY</th>
                                    <th style="width:10%;">User Name</th>
                                    <th style="width:15%;">Password</th>
                                    <th data-sortable="false" style="text-align: center; padding-right:0; padding-left: 0;  width: 10%;">Edit</th>
                                    <th data-sortable="false" style="text-align: center; padding-right:0; padding-left: 0;  width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead>
<?php
    $depart = $db->prepare("SELECT * FROM `sendgrid`");
    $depart->execute();
    $ndepart = $depart->rowCount();


if ($ndepart > 0) {
    ?>
                                <tbody>
                                <?php
                                $i = '1';
                                while ($fdepart = $depart->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td align="center" style="width:5%;"><?php echo $i; ?></td>
                                            <td> <?php echo getsendgrid('api_key', $fdepart['sgid']); ?> </td>
                                             <td> <?php echo getsendgrid('username', $fdepart['sgid']); ?> </td>
                                              <td> <?php echo getsendgrid('password', $fdepart['sgid']); ?> </td>
                                            <td align="center"><i class="fa fa-edit" onclick="javascript:editthis('<?php echo $fdepart['sgid']; ?>');" style="cursor:pointer;"></i></td>
                                            <td align="center"><input type="checkbox" name="chk[]" id="chk[]" value="<?php echo $fdepart['sgid']; ?>" /></td>
                                        </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th <?php if ($_SESSION['type'] == 'admin') { ?> colspan="5" <?php } else { ?> colspan="7" <?php } ?>> &nbsp;</th>
                                <a href="../.htaccess"></a>
                                        <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                    </tr>
                                </tfoot>
<?php } ?>
                        </table>
                    </div>
                </form>

            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>settings/' + a + '/editsendgrid.htm';
         
    }
</script>
<?php
include ('../../require/footer.php');
?>
