 
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
	
	$varsql= ' CREATE TABLE users (
		name varchar(32) NOT NULL PRIMARY KEY,
		pass TEXT
	)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB';

	try {
		$pdo->exec($varsql);
	} catch(Excepton $e) {
		echo "<br />Error creating DB users <br /><br />";
	}

	$varsql= ' CREATE TABLE expenditure (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		date_ TEXT NOT NULL,
		user_name varchar(32),
		item varchar(100) DEFAULT "Lots of item",
		price INT NOT NULL,
		added_by varchar(32),
		FOREIGN KEY (user_name) REFERENCES users(name),
		FOREIGN KEY (added_by) REFERENCES users(name)
	)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB';

	try {
		$pdo->exec($varsql);
	} catch(Excepton $e) {
		echo "<br />Error creating DB expenditure <br /><br />";
	}

	$varsql= ' CREATE TABLE mealcount (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		date_ TEXT NOT NULL,
		user_name varchar(32),
		dorn varchar(1),
		FOREIGN KEY (user_name) REFERENCES users(name)
	)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB';

	try {
		$pdo->exec($varsql);
	} catch(Excepton $e) {
		echo "<br />Error creating DB mealcount <br /><br />";
	}



	

	echo "<br />DONE CREATING";
?>

