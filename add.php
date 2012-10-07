<?php
if (isset($_POST['quote']) && isset($_POST['password'])) {
	$pubdate = time(0);
	$quote = mysql_real_escape_string($_POST['quote']);
	$hash = sha1($quote);
	$ip = $_SERVER['REMOTE_ADDR'];
	$password = $_POST['password'];

	include('database.php');

	if ($quote == '') {
		header('Location: /add/empty');
		exit;
	}

	if ($password != $addpasswd) {
                header('Location: /add/password');
                exit;
	}

        if (mysql_num_rows(mysql_query("SELECT hash FROM qdb_quotes WHERE hash = '$hash';")) > 0) {
                header('Location: /add/hashuniq');
                exit;
        }

	$quote = mysql_real_escape_string($quote);
	mysql_query("INSERT INTO qdb_quotes ( pubdate, hash, quote, ip )
			VALUES ( '$pubdate', '$hash', '$quote', '$ip' );") or die(mysql_error());
	mysql_close();

	header('Location: /');
} else {

	if (isset($_GET['err'])) {
		$err = $_GET['err'];

		echo '<p><strong>Error: ';
		switch ($err) {
		case "hashuniq": echo 'Haschet finns redan.' . 
			' Det betyder troligtvis att citatet också gör det.'; break;
		case "password": echo 'Fel lösenord.'; break;
		case "empty": echo 'Citatet kan föfan inte vara tomt!'; break;
		}
		echo '</strong></p>';
	}

	echo '<form action="index.php?action=add" method="post">
		<ul>
			<li>Citat:
				<textarea name="quote"></textarea></li>
			<li>Lösenord:
				<input type="password" name="password" /></li>
			<li><button type="submit">Lägg till!</button></li>
		</ul>
	</form>';
}
?>

