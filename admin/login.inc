<?php

#login.inc

class Login ()
{
	var triedIt = false;
	var loggedIn = false;
	var loginId = -1;
	var loginName = "";

	function Login()
	{
	}

	function doLogin()
	{
		if (!$this->loggedIn)
		{
			if (defined($_GET[uName]) && defined($_GET[uPass]) && $_GET[uName] != "" && $_GET[uPass] != "")
			{
				$uName=$_GET[uName];
				$uPass=md5($_GET[uPass]);
				#foo
			}
			else
			{
				$this->loginForm();
			}
		}
	}
}

?>