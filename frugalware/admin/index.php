<?php

#admin site

include("../config.inc");
include("../db.inc");
include("login.inc");

$login = new Login();
$login->doLogin();

include("../header.php");
echo "<div align=\"center\">You are now logged in. If you want to log out, click <a href=\"?logout=\">here</a></div>";
include("../footer.php");

?>