<?
function display_day($day, $param=null)
{
	global $logdir;

	if($param==null)
	{
		if ($dir = @opendir($logdir . "/" . $day))
		{
			$packages = array();
			while ($file = readdir($dir))
			{
				if ($file != "." and $file != ".." and substr($file, -4, 4) == ".log")
				{
					$pkg["date"] = date(DATE_RFC822, filemtime("$logdir/$day/$file"));
					$pkg["url"] = "$day/$file";
					$pkg["fullname"] = substr($file,0,strlen($file)-4);
					$pkg["exitcode"] = !trim(file_get_contents("$logdir/$day/$file.exitcode"));
					$packages[] = $pkg;
				}
			}
			include("templates/day.php");
		}
	}
	else
	{
		// sanility checks
		if(strstr($param, "..") or strchr($param, "/"))
			die("nice try ;)");
		$log="$logdir/$day/$param";
		include("templates/log.php");
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

function query_hardware()
{
	global $providers;

	$host = trim(`hostname`);
	$cpuinfo = file("/proc/cpuinfo");
	$cpuinfo = trim(substr($cpuinfo[4], 13));
	$provider = $providers[$host];
	$pp = popen("free", "r");
	fgets($pp);
	$meminfo = (int)(trim(substr(trim(substr(fgets($pp), 4)), 0, 10))/1000);
	pclose($pp);
	// TODO: disk space

	include("templates/hardware.php");
}

function list_days()
{
	global $logdir, $providers;

	$host = trim(`hostname`) . "." . trim(`dnsdomainname`);
	$arch = trim(`uname -m`);
	$days = array();
	if ($dir = @opendir($logdir))
	{
		while ($file = readdir($dir))
		{
			if ($file != "." and $file != ".." and is_dir($logdir . "/" . $file))
			{
				$days[] = $file;
			}
		}
		sort($days);
	}
	else
	{
		die('could not open $logdir, check your config.php!');
	}
	$syncpkgdpid = trim(`ps -C syncpkgd -o pid=`);
	if($syncpkgdpid!="")
	{
		$syncd = true;
		$syncddate = date(DATE_RFC822, processtime($syncpkgdpid));
	}
	else
		$syncd = false;
	$syncpkgpid = trim(`ps -C syncpkg -o pid=`);
	if($syncpkgpid!="")
		$sync = true;
	else
		$sync = false;
	if($sync)
		$syncdate = date(DATE_RFC822, processtime($syncpkgpid));
	else
	{
		$syncpkgpid = trim(`ps -C "sleep 2h" -o pid=`);
		$syncdate = date(DATE_RFC822, processtime($syncpkgpid)+7200);
	}
	$str = explode(" ", file_get_contents("/proc/loadavg"));
	$loadstat = $str[0];

	include("templates/main.php");
}
?>
