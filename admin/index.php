<?php

#admin site

include("../config.inc");
include("../db.inc");
include("login.inc");

$login = new Login();
$login->doLogin();

echo "logged in...";

?>