<?php
if($menu!='')
{
    $m=explode(",",$menu);
    $i=$m['0'];
    $j=$m['1'];
    $k=$m['2'];
    $l=$m['3'];
    ${"tree" . $i}='active';
    ${"menutree" . $j}='menu-open" style="display: block;';
    ${"smenuitem" . $k}='class="active"';
}
?>