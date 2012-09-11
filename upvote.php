<?php

if (isset($_GET['hash'])) {
	$hash = $_GET['hash'];
	$ip = $_SERVER['REMOTE_ADDR'];

	include('database.php');
	mysql_query("set names utf8;");

	$result = mysql_query("SELECT * FROM qdb_votes WHERE hash='$hash' AND ip='$ip';")
			or die(mysql_error());
	$hasnotvoted = mysql_num_rows($result) == 0 ? true : false;

	$result = mysql_query("SELECT score FROM qdb_quotes WHERE hash='$hash' LIMIT 1;")
			or die(mysql_error());

	if (mysql_num_rows($result) != 0) {
		$score = mysql_result($result, 0, 'score');

		if ($hasnotvoted) {
			$newscore = $score + 1;
			mysql_query("INSERT INTO qdb_votes (hash, ip) VALUES ('$hash', '$ip');")
				or die(mysql_error());
		} else {
			$newscore = $score;
		}

		mysql_query("UPDATE qdb_quotes SET score='$newscore' WHERE hash='$hash';") or die(mysql_error());

		echo $newscore;
	}
}

?>


