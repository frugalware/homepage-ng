<?php

# functions.inc

function fwsidebox($boxhead="", $content)
{
	if ($boxhead != "")
	{
		print "    <div class=\"boxpadding\">
      <div class=\"boxheader\">
        $boxhead
      </div>
      <div class=\"sidecontent\">
        $content
      </div>
    </div>
    <div class=\"freespace\">&nbsp;</div>\n";
	}
	else
	{
		print "    <div class=\"boxpadding\">
      $content
    </div>\n";
	}
}

function fwmiddlebox($boxhead="", $content)
{
	if ($boxhead != "")
	{
		print "    <div class=\"boxpadding\">
      <div class=\"boxheader\">
        $boxhead
      </div>
      <div class=\"boxcontent\">
        $content
      </div>
    </div>
    <div class=\"freespace\">&nbsp;</div>\n";
	}
	else
	{
		print "    <div class=\"boxpadding\">
      $content
    </div>\n";
	}
}

?>