

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

	if(isset($_GET['user']) && isset($_GET['paidto'])) {

		// $varsql= 'INSERT INTO users VALUES("'.$_GET['user'].'", "'.$_GET['pass'].'")';
		// $pdo->exec($varsql);
		// echo "DONE INSERTING";

		$varsql= 'INSERT INTO expenditure (date_, user_name, item, price, added_by) values ("-----", '

	}

	else {
		echo "NEED an user and paidto...";
	}

?>