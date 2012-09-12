<?php

header('Content-type: application/atom+xml; charset=utf-8');

echo '<?xml version="1.0" encoding="utf-8"?>';

include('database.php');

echo '<feed xmlns="http://www.w3.org/2005/Atom">

	<title>qdb</title>
	<link href="http://qdb.xqkr.org/"/>
	<link rel="self" href="http://qdb.xkqr.org/atom.php" />
	<id>http://qdb.xqkr.org/</id>' . "\n";
mysql_query("set names utf8;");
$query = "SELECT * FROM qdb_quotes ORDER BY pubdate DESC LIMIT 20;";

$result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {
		$pubdate = strftime("%Y-%m-%dT%H:%M:%S+01:30", $row['pubdate']);
		$hash = $row['hash'];
		$quote =$row['quote'];

		// Ugly shit-ass hack, but i don't care; this i php baby
		if (!isset($latestupdate)) {
			$latestupdate = $pubdate;
			echo "	<updated>$latestupdate</updated>\n";
		}

		$quote = trim(htmlentities($quote, ENT_COMPAT, 'UTF-8'));
		
		$content = "";

		$quote = str_replace('\r\n', "\n", $quote);
		$quote = stripslashes($quote);
		$quote = preg_split('/\n/', $quote);
		foreach($quote as $line) {
			$line = htmlentities(trim($line) . "<br />", ENT_COMPAT, 'UTF-8');
			// $line = preg_replace("@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@", "<a href=\"$0\" target=\"_BLANK\">$0</a>", $line);
			$content .= "		$line\n";
		}

		$content = preg_replace("/&lt;br \/&gt;\n$/", "", $content);

		echo "	<entry>
		<title>$hash</title>
		<content type=\"html\">
		$content
		</content>
		<author>
			<name>qdb</name>
		</author>
		<id>http://qdb.xkqr.org/single/$hash</id>
		<updated>$pubdate</updated>
		<link rel=\"alternate\" href=\"http://qdb.xkqr.org/single/$hash\"/>
	</entry>\n";
	}
echo "</feed>";

?>