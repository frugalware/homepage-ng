<?php

#login.inc
$parts=explode('/', $_SERVER[REQUEST_URI]);
$_SELF=$parts[count($parts)-1];

if (defined("login.class"))
	return;
define("login.class", "1");

class Login
{
	var $db,
	    $level,
	    $triedIt,
	    $loggedIn,
	    $loginName;

	function Login()
	{
		$logout = $_GET["logout"];
		$this->level = 0;
		$this->triedIt = false;
		$this->loggedIn = false;
		$this->loginName = '';
		$this->db = new FwDB();
		$this->db->doConnect();

		if (isset($logout))
		{
			$this->doLogout();
		}
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
				$_SESSION['level'] = $this->level;
				$_SESSION['loginName'] = $uName;
			}
			else
			{
				$this->triedIt = true;
			}
		}
		elseif (isset($_SESSION['loginName']))
		{
			$this->loginName=$_SESSION['loginName'];
			$this->level = $_SESSION['level'];
			$this->loggedIn = 1;
		}

		if (!$this->loggedIn)
		{
			$this->loginForm();
			exit();
		}
	}

	function loginForm()
	{
		global $_SELF, $fwng_root, $lang, $copydate;
		include("../header.php");
?>
<form action="<?php echo $_SELF; ?>" method="post" enctype="multipart/form-data">
<p align="center">
  <b>
<?php ($this->triedIt) ? print gettext("You have entered wrong password!") : print gettext("You have to login to view this site!"); ?>
  </b>
</p>
<br />
<div align="center">
  <table align="center" border="0" cellspacing="2" cellpadding="0" width="60%">
    <tr valign="middle">
      <td width="50%" align="right"><?php echo gettext("Login name"); ?>:&nbsp;&nbsp;&nbsp;</td>
      <td><input type="text" name="uName" class="input" /></td>
    </tr>
    <tr valign="middle">
      <td width="50%" align="right"><?php echo gettext("Password"); ?>:&nbsp;&nbsp;&nbsp;</td>
      <td><input type="password" name="uPass" class="input" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" value="<?php echo gettext("Enter"); ?>" class="button" /></td>
    </tr>
  </table>
</div>
</form>
<?php
		include("../footer.php");
	}

	function doLogout()
	{
		unset($_SESSION["loginName"]);
		unset($_SESSION["level"]);
		$this->loginName="";
		$this->loggedIn=false;
		$this->triedIt=false;
		$this->level=0;
		header("Location: index.php");
	}

	function printInfo($user)
	{
	}

}

?>
