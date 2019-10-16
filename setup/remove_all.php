

<?php

	include '../common/cred.php';

	try
	{
		//total 3 places to change...
		$pdo = new PDO('mysql:host='.$db_host.';dbname='.$db_name,$db_user,$db_pass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec('SET NAMES "utf8"');
	}
	catch(Excepton $e)
	{
		//include 'error.php';
		echo 'Unable to connect the database...';
		exit();
	}

	$varsql= 'DROP TABLE expenditure';

	try {
		$pdo->exec($varsql);
	} catch(Excepton $e) {
		echo "<br />Error droping DB expenditure <br /><br />";
	}

	$varsql= 'DROP TABLE mealcount';

	try {
		$pdo->exec($varsql);
	} catch(Excepton $e) {
		echo "<br />Error droping DB mealcount <br /><br />";
	}
	
	$varsql= 'DROP TABLE users';

	try {
		$pdo->exec($varsql);
	} catch(Excepton $e) {
		echo "<br />Error deleting DB users <br /><br />";
	}

	echo 'done';


?>