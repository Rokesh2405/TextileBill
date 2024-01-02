<?php 
$_SESSION['user']=1;
$_SESSION['new']=2;
$_SESSION['newi']=3;
 
foreach($_SESSION as $key => $val)
{
	
	if(($key  != 'new') && ($key  != 'newi'))
	{
		unset($_SESSION[$key]);
	}
	
}


print_r($_SESSION);