<?php

$log=new form_logout();
$log->logout();

class form_logout
{
	
	public function logout()
	{
		 session_start();
		 session_destroy();
		 @header('location:home.php');
	}
}
?>