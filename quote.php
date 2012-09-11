
<?php

if (isset($query)) {
	$result = mysql_query($query);

	while ($row = mysql_fetch_array($result)) {
		$pubdate = $row['pubdate'];
		$hash = $row['hash'];
		$quote = $row['quote'];
		$score = $row['score'];

		include('printquote.php');
	}
}


?>

