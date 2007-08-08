<?
$hostname = explode(".", $_SERVER['SERVER_NAME']);
header("Location: http://frugalware.org/buildlogs/" . $hostname[0]);
?>
