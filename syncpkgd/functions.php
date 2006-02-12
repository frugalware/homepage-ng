<?
function list_days()
{
	global $logdir;

	display_header();
	if ($dir = @opendir($logdir))
	{
		while ($file = readdir($dir))
		{
			if ($file != "." and $file != ".." and is_dir($logdir . "/" . $file))
			{
				print("<li><a href=\"$file\">$file</a></li>\n");
			}
		}
	}
	else
	{
		die('could not open $logdir, check your config.php!');
	}
	display_stats();
}

function display_day($day, $param=null)
{
	global $logdir;

	if($param==null)
	{
		if ($dir = @opendir($logdir . "/" . $day))
		{
			while ($file = readdir($dir))
			{
				if ($file != "." and $file != ".." and substr($file, -4, 4) == ".log")
				{
					print(date(DATE_RFC822, filemtime("$logdir/$day/$file")) .
					": <a href=\"$day/$file\">" . substr($file,0,strlen($file)-4) . "</a> " .
					(file_get_contents("$logdir/$day/$file.exitcode")==0 ? "built" : "failed") .
					"<br>\n");
				}
			}
		}
	}
	else
	{
		if(strstr($param, "..") or strchr($param, "/"))
			die("nice try ;)");
		header("Content-type: text/plain");
		include("$logdir/$day/$param");
	}
}

function processtime($pid)
{
	$fp = fopen("/proc/stat", "r");
	while(!feof($fp))
	{
		$str = fgets($fp);
		if(substr($str, 0, 5) == "btime")
			break;
	}
	fclose($fp);
	$btime = substr($str, 6);

	$pid = explode(" ", $pid);
	$str = file_get_contents("/proc/" . $pid[0] . "/stat");
	$ptime = explode(" ", $str);
	return($btime+$ptime[21]/100);
}

function display_stats()
{
	print("</ul>\n");
	print("General statistics:<br>\n");
	$syncpkgdpid = trim(`ps -C syncpkgd -o pid=`);
	if($syncpkgdpid!="")
		printf("The package builder daemon is running, started on " .
		date(DATE_RFC822, processtime($syncpkgdpid)) . ".<br>\n");
	else
		printf("The package builder daemon is not running.<br>\n");
	$syncpkgpid = trim(`ps -C syncpkg -o pid=`);
	if($syncpkgpid!="")
		printf("The package builder is running, started on " .
		date(DATE_RFC822, processtime($syncpkgpid)) . ".<br>\n");
	else
	{
		$syncpkgpid = trim(`ps -C "sleep 2h" -o pid=`);
		printf("The package builder is sleeping, will be started again on " .
		date(DATE_RFC822, processtime($syncpkgpid)+7200) . ".<br>\n");
	}
	$str = explode(" ", file_get_contents("/proc/loadavg"));
	print("Current avarage for the past one minute: " . $str[0] . "<br>\n");
}

function display_header()
{
	printf("Welcome to " . trim(`hostname`) . "." . trim(`dnsdomainname`) . ", the " . trim(`uname -m`) .
	" buildserver of <a href=\"http://frugalware.org\">Frugalware Linux</a>.<br>\n" .
	"The following buildlogs are available:<br><ul>\n");
}
?>
