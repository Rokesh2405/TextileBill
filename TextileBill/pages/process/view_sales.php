<?php
$menu = "8,8,27";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');

$_SESSION['driver'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delobject($chk);
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
            if (confirm("Do you want to delete the Object(s)"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if (validcheck(name) == false)
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
    #normalexamples tbody tr td:nth-child(2),  tbody tr td:nth-child(6),tbody tr td:nth-child(7),tbody tr td:nth-child(8),tbody tr td:nth-child(9) {
        text-align:left;
        font-size: 19px;
    }
    #normalexamples tbody tr td:nth-child(3),  tbody tr td:nth-child(4) {
        text-align:center;
        font-size: 19px;
    }
</style>
<!-- Content Wrapper. Contains page content -->


<div class="content-wrapper">
    <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>SALES DETAILS:Date:<?php
global $db;
$id = $_GET['id'];
 $link2 = FETCH_all("SELECT * FROM `online_order` WHERE `id`=?", $id);
 echo $link2['date'];
 ?></h2>

<table>
  <tr>
    <th>Sno</th>
    <th>Product</th>
    <th>Qty</th>
    <th>Rate</th>
    <th>Total</th>
  </tr>

  <?php  
    global $db;
$id = $_GET['id'];

 $message1 = $db->prepare("SELECT * FROM `online_order_deatils` WHERE `object_id`=$id");
 $message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
  
   
    
?>
  <tr>
    <td><?php echo $message[id]; ?></td>
    <td><?php 
     $link2 = FETCH_all("SELECT `objectname` FROM `object` WHERE `id`=?", $message[id]);
     echo $link2['objectname']; 
    

    ?></td>
    <td><?php echo $message[qty]; ?></td>
    <td><?php echo $message[rate]; ?></td>
    <td><?php echo $message[total]; ?></td>
  </tr>
  <?php
 }
?>
 
  
</table>
  </div> 
    
          
<?php
include ('../../require/footer.php');
?>  
