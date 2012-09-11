
<?php


if (isset($pubdate) && isset($hash) && isset($quote)) {
	$utctime = strftime("%Y-%m-%dT%H:%M:%S+01:30", $pubdate);
	$readabletime = strftime("%e %B %Y %l.%M %P", $pubdate);
	$hashlink = "/single/$hash";

	echo "<article>\n";
	echo "    <header>\n";
	echo "        <time datetime=\"$utctime\" pubdate>$readabletime</time>\n";
	echo "        — <a href=\"javascript:upvote('$hash')\">poäng: ";
		echo "<span id=\"" . $hash . "_score\">$score</span> (+)</a> — \n";
	echo "        <a rel=\"bookmark\" href=\"$hashlink\">#$hash</a>\n";
	echo "    </header>\n";
	echo "    <blockquote>\n";
	echo "        <ol>\n";

	$quote = str_replace('\r\n', "\n", $quote);
	$quote = stripslashes($quote);
	$quote = preg_split('/\n/', $quote);
	foreach($quote as $line) {
		$line = htmlentities(trim($line), ENT_COMPAT, 'UTF-8');
		$line = preg_replace("@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@", "<a href=\"$0\" target=\"_BLANK\">$0</a>", $line);
		echo "            <li>$line</li>\n";
	}

	echo "        </ol>\n";
	echo "    </blockquote>\n";
	echo "</article>\n";
}


?>

