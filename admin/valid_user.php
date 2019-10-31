

ADDED BY YOU-

<table>
	<tr>
		<th> Date </th>
		<th> Name </th>
		<th> Price </th>
		<th> action </th>
	</tr>

<?php

	$varsql= 'SELECT * FROM expenditure WHERE added_by= "'.$_SESSION['user'].'"';

	$res_all= $pdo->query($varsql);
	$count= 1;
	while($res_arr= $res_all->fetch()) {
		if($count==1) {
			echo '<tr class="z">';
			echo '<td class="z">'.$res_arr["date_"].'</th>';
			echo '<td class="z">'.$res_arr["user_name"].'</th>';
			echo '<td class="z">'.$res_arr["price"].'</th>';
			echo '<td class="z"><a class="button_rem" href="index.php?remove='.$res_arr["id"].'">Remove</a></th>';
			echo '</tr>';
		} else {
			echo '<tr class="y">';
			echo '<td class="y">'.$res_arr["date_"].'</th>';
			echo '<td class="y">'.$res_arr["user_name"].'</th>';
			echo '<td class="y">'.$res_arr["price"].'</th>';
			echo '<td class="y"><a class="button_rem" href="index.php?remove='.$res_arr["id"].'">Remove</a></th>';
			echo '</tr>';
		}
		$count= 1-$count;

	}
?>
</table>

<br /><br /><br />

Meal count

<table>
	<tr>
		<th> Date </th>
		<th> Name </th>
		<th> time </th>
		<th> action </th>
	</tr>

<?php

	$varsql= 'SELECT * FROM mealcount';

	$res_all= $pdo->query($varsql);
	$count= 1;
	while($res_arr= $res_all->fetch()) {
		if($count==1) {
			echo '<tr class="z">';
			echo '<td class="z">'.$res_arr["date_"].'</th>';
			echo '<td class="z">'.$res_arr["user_name"].'</th>';
			if($res_arr["dorn"]=="D") echo '<td class="z day">Day</th>'; else echo '<td class="z night">Night</th>';
			echo '<td class="z"><a class="button_rem" href="index.php?remove_m='.$res_arr["id"].'">Remove</a></th>';
			echo '</tr>';
		} else {
			echo '<tr class="y">';
			echo '<td class="y">'.$res_arr["date_"].'</th>';
			echo '<td class="y">'.$res_arr["user_name"].'</th>';
			if($res_arr["dorn"]=="D") echo '<td class="y day">Day</th>'; else echo '<td class="y night">Night</th>';
			echo '<td class="y"><a class="button_rem" href="index.php?remove_m='.$res_arr["id"].'">Remove</a></th>';
			echo '</tr>';
		}
		$count= 1-$count;

	}
?>
</table>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<div id="form_container">
<div id= "insert">
Insert new expenditure

<form action="index.php" method="post">

	<input type="text" class="ins" id="date_form" name="date" placeholder="Date*" autocomplete="off" required="required">

	<select required name="user" class="ins">
		<option selected="true" disabled="disabled">Baught by</option>
		<?php

	$varsql= 'SELECT name FROM users';

	$res_all= $pdo->query($varsql);
	while($res_arr= $res_all->fetch()) {
		echo '<option value="';
		echo $res_arr['name'];
		echo '"> '.$res_arr['name'].'</option>';
	}
?>

	</select><br />

	<input type="number" name="price" class="ins" placeholder="price*" autocomplete="off" required="required">
	<input type="text" name="item" class="ins" placeholder="Item" autocomplete="off" >
	<input type="submit"  class="button" value="go">
</form>
</div>


<div id="meal_insert">
	Add new Meal
	<form action="index.php" method="post">
		<input type="text" class="ins" id="date_form2" name="date2" placeholder="Date*" autocomplete="off" required="required">

	<select required name="user2" class="ins">
		<option selected="true" disabled="disabled">Eaten by</option>
		<option value="everyone" class="everyone"> Everyone </option>
		<?php

			$varsql= 'SELECT name FROM users';

			$res_all= $pdo->query($varsql);
			while($res_arr= $res_all->fetch()) {
				echo '<option value="';
				echo $res_arr['name'];
				echo '"> '.$res_arr['name'].'</option>';
			}
	?>

		</select><br />
		<select required name="dorn" class="ins">
			<option selected="true" disabled="disabled">day/night</option>
			<option value="D">Day</option>
			<option value="N">Night</option>
		</select> <br />
		<input type="text" class="ins" placeholder="comment" >
		<input type="submit"  class="button" value="go">
</form>
</div>
</div>


<script type="text/javascript">

	let chng2digit= (num) => {
		if(num>9) return num;
		else return "0"+num;
	}


	let dateF= document.getElementById("date_form");
	let dateF2= document.getElementById("date_form2");
	let d= new Date();
	dateF.value=chng2digit(d.getDate())+"/"+chng2digit(d.getMonth());
	dateF2.value=chng2digit(d.getDate())+"/"+chng2digit(d.getMonth());

</script>