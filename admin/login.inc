<?php

#login.inc

class Login
{
	var $db,
	    $level,
	    $triedIt,
	    $loggedIn,
	    $loginName;

	function Login()
	{
		$this->level = 0;
		$this->triedIt = false;
		$this->loggedIn = false;
		$this->loginName = '';
		$this->db = new FwDB();
		$this->db->doConnect();
	}

	function doLogin()
	{
		if (isset($_POST[uName]) && isset($_POST[uPass]) && $_POST[uName] != "" && $_POST[uPass] != "")
		{
			$uName=$_POST[uName];
			$uPass=md5($_POST[uPass]);
			$res = $this->db->doQuery("select upass, level from users where uname='$uName'");
			$arr = $this->db->doFetchRow($res);
			if ($arr['upass'] == $uPass)
			{
				$this->level = $arr['level'];
				$this->triedIt = true;
				$this->loggedIn = true;
				$this->loginName = $uName;
				$_COOKIE['level'] = $this->level;
				$_COOKIE['triedIt'] = 1;
				$_COOKIE['loggedIn'] = 1;
				$_COOKIE['loginName'] = $uName;
			}
			else
			{
				$this->triedIt = true;
			}
		}
		elseif (isset($_COOKIE['loginName']))
		{
			$this->loginName=$_COOKIE['loginName'];
			$this->level = $_COOKIE['level'];
			$this->loggedIn = true;
		}

		if (!$this->loggedIn)
		{
			$this->loginForm();
			exit();
		}
	}

	function loginForm()
	{
		print "foobar";
	}

}

?>