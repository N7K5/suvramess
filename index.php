<?php
	include 'common/cred.php';

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
		Suvra Mess
	</title>
	<link href="script/common.css" type="text/css" rel="stylesheet" />
	<link href="script/index.css" type="text/css" rel="stylesheet" />
	<link rel="icon" href="res/icon.png">
</head>

<body>

	<a id="login" href= "admin">Log-in</a>

	<div id="total_holder">
		<div id="tot">Total Expenditure- <a id="money">
		<?php
			$varsql= 'SELECT SUM(price) AS total FROM expenditure';
			try {
				$res_arr= $pdo->query($varsql)->fetch();
				echo $res_arr['total'];
				$total= $res_arr['total'];
			} catch(Excepton $e) {
				echo "error no SUM...";
				exit();
			}
		?> ₹ </a> <br />
	</div>
	<div id="permeal">
		per meal cost till now-
		<?php
			$varsql= 'SELECT COUNT(id) AS id FROM mealcount';
			try {
				$res_arr= $pdo->query($varsql)->fetch();
				echo intval($total/$res_arr['id']);
			} catch(Excepton $e) {
				echo "error no SUM...";
				exit();
			}
		?> ₹
	</div>

		<br />
		<a id="table_title">Deposit- </a> 
		<table>
			<tr>
				<th> User </th>
				<th> Meal </th>
				<th> Deposit </th>
			</tr>
			<?php

				$varsql= 'SELECT user_name, SUM(price) AS total FROM expenditure GROUP BY user_name';

				$res_all= $pdo->query($varsql);
				$current_col= 0;
				while($res_arr= $res_all->fetch()) {
					if($current_col==0) {
						echo '<tr class="z">';
						echo '<td class="z">'.$res_arr["user_name"].'</td>';
						$varsql= 'SELECT COUNT(id) as co FROM mealcount WHERE user_name="'.$res_arr["user_name"].'"';
						$count_res=$pdo->query($varsql)->fetch();
						echo '<td class="z">'.$count_res["co"].'</td>';
						echo '<td class="z">'.$res_arr["total"].' ₹ </td>';
						echo '</tr>';
					} else {
						echo '<tr class="y">';
						echo '<td class="y">'.$res_arr["user_name"].'</td>';
						$varsql= 'SELECT COUNT(id) as co FROM mealcount WHERE user_name="'.$res_arr["user_name"].'"';
						$count_res=$pdo->query($varsql)->fetch();
						echo '<td class="y">'.$count_res["co"].'</td>';
						echo '<td class="y">'.$res_arr["total"].' ₹ </td>';
						echo '</tr>';
					}
					$current_col= 1-$current_col;
				}
			?>
		</table><br />
	</div>
	<div id="all_records_holder">
		<a id="table_title">All records-</a>
		<table>
			<tr>
				<th>Date</th>
				<th>Baught by</th>
				<th>Items</th>
				<th>Price</th>
			</tr>
			<?php

				// $varsql= 'SELECT * FROM expenditure ORDER BY id DESC';
			$varsql= 'SELECT * FROM expenditure ORDER BY id';
				$current_col= 0;
				$res_all= $pdo->query($varsql);
				while($res_arr= $res_all->fetch()) {
					if($current_col==0) {
						echo '<tr class="z">';
						echo '<td class="z">'.$res_arr["date_"].'</td>';
						echo '<td class="z">'.$res_arr["user_name"].'</td>';
						echo '<td class="z">'.$res_arr["item"].'</td>';
						echo '<td class="z">'.$res_arr["price"].' ₹ </td>';
						echo '</tr>';
					} else {
						echo '<tr class="y">';
						echo '<td class="y">'.$res_arr["date_"].'</td>';
						echo '<td class="y">'.$res_arr["user_name"].'</td>';
						echo '<td class="y">'.$res_arr["item"].'</td>';
						echo '<td class="y">'.$res_arr["price"].' ₹ </td>';
						echo '</tr>';
					}
					$current_col= 1-$current_col;
				}
			?>
		</table>
	</div>

	
</body>
</html>