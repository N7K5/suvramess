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
				$per_meal_cost= $total/$res_arr['id'];
				echo number_format((float)$per_meal_cost, 2, '.', '');
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
				<th title="Total no of meal eaten by individual" style="cursor: help"> Meal </th>
				<th title="Total meal charge of individual" style="cursor: help"> Total </th>
				<th title="Total ammount deposited by individual" style="cursor: help"> Deposit </th>
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
						echo '<td class="z" >'.$count_res["co"].'</td>';

						$total_cost= $per_meal_cost*$count_res["co"];
						echo '<td class="z" title="Meal charge for '.$count_res["co"].' meals" style="cursor: help">'.number_format((float)$total_cost, 2, '.', '').' ₹</td>';

						if($total_cost<$res_arr["total"]) {
							echo '<td class="z grater" title="'.number_format((float)($res_arr["total"]-$total_cost), 2, '.', '').' ₹ extra" style="cursor: help">'.$res_arr["total"].' ₹ </td>';
						} else {
							echo '<td class="z less" title="'.number_format((float)($total_cost-$res_arr["total"]), 2, '.', '').' ₹ due" style="cursor: help">'.$res_arr["total"].' ₹ </td>';
						}
						echo '</tr>';
					} else {
						echo '<tr class="y">';
						echo '<td class="y">'.$res_arr["user_name"].'</td>';
						$varsql= 'SELECT COUNT(id) as co FROM mealcount WHERE user_name="'.$res_arr["user_name"].'"';
						$count_res=$pdo->query($varsql)->fetch();
						echo '<td class="y">'.$count_res["co"].'</td>';
						
						$total_cost= $per_meal_cost*$count_res["co"];
						echo '<td class="y" title="Meal charge for '.$count_res["co"].' meals" style="cursor: help">'.number_format((float)$total_cost, 2, '.', '').' ₹</td>';

						if($total_cost<$res_arr["total"]) {
							echo '<td class="y grater" title="'.number_format((float)($res_arr["total"]-$total_cost), 2, '.', '').' ₹ extra" style="cursor: help">'.$res_arr["total"].' ₹ </td>';
						} else {
							echo '<td class="y less" title="'.number_format((float)($total_cost-$res_arr["total"]), 2, '.', '').' ₹ due" style="cursor: help">'.$res_arr["total"].' ₹ </td>';
						}
						echo '</tr>';
					}
					$current_col= 1-$current_col;
				}
			?>
		</table><br />
	</div>
	<div id="all_records_holder">
		<a id="table_title">
			<select id="whos_rec">
				<option value="everyone">Everyone's</option>
			<?php
				$varsql= "SELECT name FROM users";
				$res_all= $pdo->query($varsql);
				while($res_arr= $res_all->fetch()) {
					echo ' <option value="'.$res_arr['name'].'">'.$res_arr['name']."'s".'</option>';
				}
			?>
			</select>
		 record-</a>
		<table id="table_main">
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
		<table id="table_js">

		</table>
	</div>

	
</body>


<script type="text/javascript">
	
	let oldTbl= document.getElementById("table_main");
	let newTbl= document.getElementById("table_js");

	let showOnly= (name) => {
		oldTbl.style.display="none";
		newTbl.innerHTML= "<tr><th>Date</th><th>Baught by</th><th>Items</th><th>Price</th></tr>";
		let rowLength= oldTbl.rows.length;
		let counter= -1;
		let tblClass= "z";
		let innerStr= "";
		for(let i=1; i<rowLength; i++) {
			innerStr= "";
			let cellArray= oldTbl.rows.item(i).cells;
			let cellLength= cellArray.length;
			if(name == "everyone" || name == "Everyone") {
				// console.log(name);
				(++counter%2==0)?tblClass="z":tblClass="y";
				// innerStr+='<tr class="'+tblClass+'">';
				for(let j=0; j<cellLength; j++) {
					// console.log(cellArray.item(j).innerText);
					innerStr+='<td class="'+tblClass+'">'+cellArray.item(j).innerText+'</td>';
				}
				// innerStr+='</tr>';

			} else {
				if(name==cellArray.item(1).innerText) {
					(++counter%2==0)?tblClass="z":tblClass="y";
					// innerStr+='<tr class="'+tblClass+'">';
					for(let j=0; j<cellLength; j++) {
						innerStr+='<td class="'+tblClass+'">'+cellArray.item(j).innerText+'</td>';
					}
					// innerStr+='</tr>';
				}
			}
			newTbl.innerHTML+=innerStr;
		}

	}

	document.getElementById("whos_rec").addEventListener("change", function(e) {
		// console.log(this.value);
		// console.log(this.value.substring(0, this.value.length-2));
		// console.log(e);
		showOnly(this.value);

	}, false);

</script>
</html>