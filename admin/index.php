<?php
	session_start();
?>
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

?>

<!DOCTYPE html>
<html>
<head>
	<title>
		ADMIN- Suvra Mess
	</title>
	<link href="../script/common.css" type="text/css" rel="stylesheet" />
	<link href="admin.css" type="text/css" rel="stylesheet" />
	<link rel="icon" href="res/icon.png">
</head> 

<body>

	<?php 
		if(isset($_GET['logout'])) {
			session_destroy();
			include "login_form.php";
			echo '</body></html>';
			exit();
		}
	?>

	<?php
		if(isset($_POST['user']) && strlen($_POST['user'])>0 &&
		   isset($_POST['pass']) && strlen($_POST['pass'])>0) {
			$varsql= 'SELECT * FROM users WHERE name="'.$_POST['user'].'" AND pass="'.$_POST['pass'].'"';
			try {
				if($pdo->query($varsql)->fetch()) {
					$_SESSION['user']= $_POST['user'];
				} else {
					echo "<br />INVALID USER / PASSWORD<br /><br />";
					session_destroy();
				}
			} catch (Excepton $e) {
				echo "SOMETHING WRONG... ";
				session_destroy();
				exit();
			}
		}

	?>

	<?php
		if(isset($_GET['remove']) && isset($_SESSION['user'])) {
			$varsql= 'DELETE FROM expenditure where id="'.$_GET['remove'].'"';
			try {
				$pdo->exec($varsql);
				echo "<a id='noti'>Removed successfully</a>";
			} catch(Excepton $e) {
				echo "error Deleting";
				session_destroy();
				exit();
			}
		}

	?>

	<?php
		if(isset($_POST['date']) && strlen($_POST['date'])>0 &&
			isset($_POST['user']) && strlen($_POST['user'])>0 &&
			isset($_POST['price']) && strlen($_POST['price'])>0) {

			$varsql= 'INSERT INTO expenditure (date_, user_name	, price, added_by) values 
						("'.$_POST['date'].'","'.$_POST['user'].'","'.$_POST['price'].'","'.$_SESSION['user'].'")';
			if(isset($_POST['item']) && strlen($_POST['item'])>0) {
				$varsql= 'INSERT INTO expenditure (date_, user_name, item, price, added_by) values
						("'.$_POST['date'].'","'.$_POST['user'].'","'.$_POST['item'].'","'.$_POST['price'].'","'.$_SESSION['user'].'")';
			}
			try{
				$pdo->exec($varsql);
				echo "<a id='noti'>added successfully</a>";
			} catch(Excepton $e) {
				echo "error inserting";
				session_destroy();
				exit();
			}

		}

	?>
	
	<?php
		if(isset($_SESSION['user'])) {
			include "valid_user.php";
			echo '<a href= "index.php?logout" id="logout">LOG OUT</a>';
		} else {
			include "login_form.php";
		}
	?>
	
</body>
</html>