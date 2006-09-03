<?php
/**
 * $Project: Pastebin $
 * $Id: layout.php,v 1.1 2006/04/27 16:22:39 paul Exp $
 * 
 * Pastebin Collaboration Tool
 * http://pastebin.com/
 *
 * This file copyright (C) 2006 Paul Dixon (paul@elphin.com)
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
 
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<!--
pastebin.com Copyright 2006 Paul Dixon - email suggestions to lordelph at gmail.com
-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $page['title'] ?></title>
<meta name="ROBOTS" content="NOARCHIVE"/>
<link rel="stylesheet" type="text/css" media="screen" href="/paste/pastebin.css?ver=4" />

<?php if (isset($page['post']['codecss']))
{
	echo '<style type="text/css">';
	echo $page['post']['codecss'];
	echo '</style>';
}
?>
<script type="text/javascript" src="/paste/pastebin.js?ver=3"></script>
</head>


<body onload="initPastebin()">
<div style="display:none;">
<h1 style="display: none;">pastebin - collaborative debugging</h1>
<p style="display: none;">pastebin is a collaborative debugging tool allowing you to share
and modify code snippets while chatting on IRC, IM or a message board.</p>
<p style="display: none;">This site is developed to XHTML and CSS2 W3C standards.  
If you see this paragraph, your browser does not support those standards and you 
need to upgrade.  Visit <a href="http://www.webstandards.org/upgrade/" target="_blank">WaSP</a>
for a variety of options.</p>
</div>

<div id="titlebar"><?php 
	echo $page['title'];
	if ($subdomain=='')
	{
		echo " <a href=\"{$CONF['this_script']}?help=1\">View Help</a>";
	}
	else
	{
		echo " <a href=\"{$CONF['this_script']}?help=1\">What's a private pastebin?</a>";
	}
?>
</div>



<div id="menu">

<h1>Recent Posts</h1>
<ul>
<?php  
	foreach($page['recent'] as $idx=>$entry)
	{
		if ($entry['pid']==$pid)
			$cls=" class=\"highlight\"";
		else
			$cls="";
			
		echo "<li{$cls}><a href=\"{$entry['url']}\">";
		echo $entry['poster'];
		echo "</a><br/>{$entry['agefmt']}</li>\n";
	}
?>
<li><a href="<?php echo $CONF['this_script'] ?>">Make new post</a></li>
</ul>

<h1>About</h1>
<p>Pastebin is a tool for collaborative debugging or editing, <a href="<?php echo $CONF['this_script'].'?help=1' ?>">see help</a>
for more information.</p>

<div id="content">
	
	<?php
/*
 * Google AdWords block is below - if you re-use this script, be sure
 * to configure your own AdWords client id!
 */
if (strlen($CONF['google_ad_client'])) 
{
?>
<script type="text/javascript"><!--
google_ad_client = "<?php echo $CONF['google_ad_client'] ?>";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
google_ad_channel ="";
google_color_border = "FFFFFF";
google_color_bg = "FFFFFF";
google_color_link = "0099CC";
google_color_url = "888888";
google_color_text = "000000";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<br/>
<br/>
<?php
}

///////////////////////////////////////////////////////////////////////////////
// show processing errors
//
if (count($pastebin->errors))
{
	echo "<h1>Errors</h1><ul>";
	foreach($pastebin->errors as $err)
	{
		echo "<li>$err</li>";
	}
	echo "</ul>";
	echo "<hr />";
}


if (isset($_REQUEST["diff"]))
{
	
	$newpid=intval($_REQUEST['diff']);
	
	$newpost=$pastebin->getPost($newpid);
	if (count($newpost))
	{
		$oldpost=$pastebin->getPost($newpost['parent_pid']);	
		if (count($oldpost))
		{
			$page['pid']=$newpid;
			$page['current_format']=$newpost['format'];
			$page['editcode']=$newpost['code'];
			$page['posttitle']='';
	
			//echo "<div style=\"text-align:center;border:1px red solid;padding:5px;margin-bottom:5px;\">Diff feature is in BETA! If you have feedback, send it to lordelph at gmail.com</div>";
			echo "<h1>Difference between<br/>modified post <a href=\"".$pastebin->getPostUrl($newpost['pid'])."\">{$newpost['pid']}</a> by {$newpost['poster']} on {$newpost['postdate']} and<br/>".
				"original post <a href=\"".$pastebin->getPostUrl($oldpost['pid'])."\">{$oldpost['pid']}</a> by {$oldpost['poster']} on {$oldpost['postdate']}<br/>";
			
			echo "Show ";
			echo "<a title=\"Don't show inserted or changed lines\" style=\"padding:1px 4px 3px 4px;\" id=\"oldlink\" href=\"javascript:showold()\">old version</a> | ";
			echo "<a title=\"Don't show lines removed from old version\" style=\"padding:1px 4px 3px 4px;\" id=\"newlink\" href=\"javascript:shownew()\">new version</a> | ";
			echo "<a title=\"Show both insertions and deletions\"  style=\"background:#880000;padding:1px 4px 3px 4px;\" id=\"bothlink\" href=\"javascript:showboth()\">both versions</a> ";
			echo "</h1>";
			
			$newpost['code']=preg_replace('/^'.$CONF['highlight_prefix'].'/m', '', $newpost['code']);
			$oldpost['code']=preg_replace('/^'.$CONF['highlight_prefix'].'/m', '', $oldpost['code']);
			
			$a1=explode("\n", $newpost['code']);
			$a2=explode("\n", $oldpost['code']);
			
			$diff=new Diff($a2,$a1, 1);
			
			echo "<table cellpadding=\"0\" cellspacing=\"0\" class=\"diff\">";
			echo "<tr><td></td><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td></td></tr>";
			echo $diff->output;
			echo "</table>";
		}
		
	}
	
	
}

///////////////////////////////////////////////////////////////////////////////
// show a post
//

if (isset($_GET['help']))
	$page['posttitle']="";
	
if (strlen($page['post']['posttitle']))
{
		echo "<h1>{$page['post']['posttitle']}";
		if ($page['post']['parent_pid']>0)
		{
			echo " (modification of post by <a href=\"{$page['post']['parent_url']}\" title=\"view original post\">{$page['post']['parent_poster']}</a> ";
			echo "<a href=\"{$page['post']['parent_diffurl']}\" title=\"compare differences\">view diff</a>)";
		}
		
		echo "<br/>";
		
		$followups=count($page['post']['followups']);
		if ($followups)
		{
			echo "View followups from ";
			$sep="";
			foreach($page['post']['followups'] as $idx=>$followup)
			{
				echo $sep."<a title=\"posted {$followup['postfmt']}\" href=\"{$followup['followup_url']}\">{$followup['poster']}</a>";
				$sep=($idx<($followups-2))?", ":" and ";	
			}
			
			echo " | ";
		}
		
		if ($page['post']['parent_pid']>0)
		{
			echo "<a href=\"{$page['post']['parent_diffurl']}\" title=\"compare differences\">diff</a> | ";
		} 
		
		echo "<a href=\"{$page['post']['downloadurl']}\" title=\"download file\">download</a> | ";
		
		echo "<span id=\"copytoclipboard\"></span>";
		
		echo "<a href=\"/\" title=\"make new post\">new post</a>";
		
		echo "</h1>";
}
if (isset($page['post']['pid']))
{
	echo "<div class=\"syntax\">".$page['post']['codefmt']."</div>";
	echo "<br /><b>Submit a correction or amendment below. (<a href=\"{$CONF['this_script']}\">click here to make a fresh posting</a>)</b><br/>";
	echo "After submitting an amendment, you'll be able to view the differences between the old and new posts easily.";
}	



if (isset($_GET['help']))
{
	?>
	<h1>What is pastebin?</h1>
	<p>pastebin is here to help you collaborate on debugging code snippets. If you're
	not familiar with the idea, most people use it like this:</p>
	<ul>
	<li><a href="/">submit</a> a code fragment to pastebin, getting a url like http://pastebin.com/1234</li>
	<li>paste the url into an IRC or IM conversation</li>
	<li>someone responds by reading and perhaps submitting a modification of your code</li>
	<li>you then view the modification, maybe using the built in diff tool to help locate the changes</li>
	</ul>
	
	<h1>How can I view the differences between two posts?</h1>
	<p>When you view a post, you have the opportunity of editing the text - 
		<strong>this creates a new post</strong>, but when you view it, you'll be given a 
	'diff' link which allows you to compare the changes between the old and the new version</p>
<p>This is a powerful feature, great for seeing exactly what lines someone changed.</p>	

	
	<h1>What's a private pastebin and how do I get one?</h1>
	<p>You get a private pastebin simply by thinking up a domain name no-one else is using,
	e.g. http://private.pastebin.com or http://this-is-my.pastebin.com. Posts made into a
	subdomain only show up on that domain, making it easy for you to collaborate without the
	'noise' of the regular service at <a href="http://pastebin.com">http://pastebin.com</a>.</p>
	
	<p>All you need to do is change the web address in your browser to access a private pastebin,
	or you can simply enter the domain you'd like below</p>
	
	<form method="get" action="<?php echo $CONF['this_script']?>">
	<input type="hidden" name="help" value="1"/>
	<p>Go to http://<input type="text" name="goprivate" value="<?php echo stripslashes($_GET['goprivate']) ?>" size="10"/>.pastebin.com 
	<input type="submit" name="go" value="Go"/></p>
	<?php if (isset($_GET['goprivate'])) { echo "<p>Please use only characters a-z,0-9, dash '-' and period '.'. Your name must start and end with a letter or number.</p>"; } ?>
	</form>
	
	<p>Please note that there is no password protection - subdomains are accessible to anyone
	who knows the domain name you've chosen, but we do not publish a list of domains used.</p>
	
	<h1>Subdomains for your language...</h1>
	
	<p>If a subdomain matches a language name, the required syntax highlighting is selected
		for you, so ruby.pastebin.com will preselect Ruby automatically. </p>
	
	<p><?php 
	
	$sep="";
	foreach($CONF['all_syntax'] as $langcode=>$langname)
	{
		if ($langcode=='text')
			$langname="Plain Text";
		echo "{$sep}<a title=\"{$langname} Pastebin\" href=\"http://{$langcode}.pastebin.com\">{$langname}</a>";
		$sep=", ";
	}	
		
		
		?></p>
	
	<h1>And this is all free?</h1>
	<p>It will always be free, our hosting and maintenance costs are paid for through advertising.</p>
	
	<h1>Can I get the source?</h1>
	<p>The source code to this site is available under a GPL licence. You can <a title="Pastebin source code, 130Kb" href="pastebin.tar.gz">download it here</a></p>
	
	<p>More news available on my <a title="View pastebin related posts on my blog" href="http://blog.dixo.net/category/pastebin/">blog</a>.</p>

	
	<h1>I have some feedback, who do I contact?</h1>
	<p>Use the feedback box in the sidebar or email <script type="text/javascript">eval(unescape('%64%6f%63%75%6d%65%6e%74%2e%77%72%69%74%65%28%27%3c%61%20%68%72%65%66%3d%22%6d%61%69%6c%74%6f%3a%70%61%75%6c%40%65%6c%70%68%69%6e%2e%63%6f%6d%22%20%3e%50%61%75%6c%20%44%69%78%6f%6e%3c%2f%61%3e%27%29%3b'))</script> 
	</p>
	
 
	<?php
}
else
{
?>
<form name="editor" method="post" action="<?php echo $CONF['this_script']?>">
<input type="hidden" name="parent_pid" value="<?php echo $page['post']['pid'] ?>"/>

<br/>Use <select name="format">
<?php

//show the popular ones
foreach ($CONF['all_syntax'] as $code=>$name)
{
	if (in_array($code, $CONF['popular_syntax']))
	{
		$sel=($code==$page['current_format'])?"selected=\"selected\"":"";
		echo "<option $sel value=\"$code\">$name</option>";
	}
}

echo "<option value=\"text\">----------------------------</option>";

//show all formats
foreach ($CONF['all_syntax'] as $code=>$name)
{
	$sel=($code==$page['current_format'])?"selected=\"selected\"":"";
	if (in_array($code, $CONF['popular_syntax']))
		$sel="";
	echo "<option $sel value=\"$code\">$name</option>";
	
}
?>
</select> syntax highlighting<br/>
<br/>

To highlight particular lines, prefix each line with <?php echo $CONF['highlight_prefix'] ?><br/>
<textarea id="code" class="codeedit" name="code2" cols="80" rows="10" onkeydown="return catchTab(this,event)"><?php 
echo htmlentities($page['post']['editcode']) ?></textarea>

<div id="namebox">
	
<label for="poster">Your Name</label><br/>
<input type="text" maxlength="24" size="24" id="poster" name="poster" value="<?php echo $page['poster'] ?>" />
<input type="submit" name="paste" value="Send"/>
<br />
<input type="checkbox" name="remember" value="1" <?php echo $page['remember'] ?>/>Remember my settings

</div>


<div id="expirybox">


<div id="expiryradios">
<label>How long should your post be retained?</label><br/>

<input type="radio" id="expiry_day" name="expiry" value="d" <?php if ($page['expiry']=='d') echo 'checked="checked"'; ?> />
<label id="expiry_day_label" for="expiry_day">a day</label>

<input type="radio" id="expiry_month" name="expiry" value="m" <?php if ($page['expiry']=='m') echo 'checked="checked"'; ?> />
<label id="expiry_month_label" for="expiry_month">a month</label>

<input type="radio" id="expiry_forever" name="expiry" value="f" <?php if ($page['expiry']=='f') echo 'checked="checked"'; ?> />
<label id="expiry_forever_label" for="expiry_forever">forever</label>
</div>

<div id="expiryinfo"></div>
	
</div>

<div id="end"></div>

</form>
<?php 
} 
?>

</div>
</body>
</html>
