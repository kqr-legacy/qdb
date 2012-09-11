<?php
if (isset($_GET['p'])) {
	$page = (int) $_GET['p'];
} else {
	$page = 1;
}

if (!isset($_GET['q']) || trim($_GET['q']) == "") {
	echo '<form action="/index.php?action=search" method="get">
			<input type="hidden" name="action" value="search" />
		<ul>
			<li>Sök efter:
				<input type="text" name="q" /></li>
			<li><input type="hidden" name="fromform" value="arst" /></li>
			<li><button type="submit">Sök!</button></li>
		</ul>
	</form>';
	$q = '';
} else {
	$q = trim($_GET['q']);

	if (isset($_GET['fromform'])) {
		header("Location: /search/$q");
		exit();
	}

	include('database.php');
	mysql_query("set names utf8;");

	$q = mysql_real_escape_string($q);
	$numrows = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM qdb_quotes WHERE quote COLLATE 'utf8_swedish_ci' LIKE '%$q%';"))
			or die(mysql_error());
	$numrows = $numrows[0];

	if ($numrows == 0) {
		echo "<p>No hits, sorry!</p>\n\n";
	}

	$totalpages = ceil($numrows / 10);

	if ($page > $totalpages) {
		$page = $totalpages;
	} else if ($page < 1) {
		$page = 1;
	}

	$offset = ($page - 1) * 10;

	$query = "SELECT * FROM qdb_quotes WHERE quote COLLATE 'utf8_swedish_ci' LIKE '%$q%' ORDER BY pubdate DESC LIMIT $offset, 10;";
	include("quote.php");
	if ($page < $totalpages) {
		$nextpage = $page + 1;
		echo "<p><a href=\"/search/$q/p$nextpage\">mer</a></p>";
	}

}

?>
