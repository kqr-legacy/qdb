<?php
//ini_set("display_errors", 1);
//error_reporting(E_ALL);


ob_start();
mb_internal_encoding("UTF-8"); 



include("header.html");


if (isset($_GET['action'])) {
	$action=$_GET['action'];
} else {
	$action="latest";
}

if (isset($_GET['p'])) {
	$page = (int) $_GET['p'];
} else {
	$page = 1;
}

include('database.php');
mysql_query("set names utf8;");

$numrows = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM qdb_quotes"));
$numrows = $numrows[0];

$totalpages = ceil($numrows / 10);

if ($page > $totalpages) {
	$page = $totalpages;
} else if ($page < 1) {
	$page = 1;
}

$offset = ($page - 1) * 10;

if ($action=="latest") {
	$query = "SELECT * FROM qdb_quotes ORDER BY pubdate DESC LIMIT $offset, 10;";
	include("quote.php");
	if ($page < $totalpages) {
		$nextpage = $page + 1;
		echo "<p><a href=\"/latest/p$nextpage\">mer</a></p>";
	}
}

else if ($action=="single") {
	if (isset($_GET['hash'])) {
		if (isset($_GET['delete']) && $_GET['delete'] == $delpasswd) {
               		$hash = $_GET['hash'];
			mysql_query("DELETE FROM qdb_quotes WHERE hash='$hash' LIMIT 1;");
			echo '<p>Citatet borttaget.</p>';
		} else {
               		$hash = $_GET['hash'];
			$query = "SELECT * FROM qdb_quotes WHERE hash='$hash' LIMIT 1;";
			include("quote.php");
		}
	}
}

else if ($action=="highest") {
	$query = "SELECT * FROM qdb_quotes ORDER BY score DESC, pubdate DESC LIMIT $offset, 10;";
	include("quote.php");
	if ($page < $totalpages) {
		$nextpage = $page + 1;
		echo "<p><a href=\"/highest/p$nextpage\">mer</a></p>";
	}
}

else if ($action=="random") {
	$query = "SELECT * FROM qdb_quotes ORDER BY RAND() LIMIT 0, 10;";
	include("quote.php");
	echo '<p><a href="/random">mer</a></p>';
}

else if ($action=="search") {
	include("search.php");
}

else if ($action=="add") {
	include("add.php");
}

else {
	include("demi-404.php");
}

include("footer.html");

ob_flush();

?>
