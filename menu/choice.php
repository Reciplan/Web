<?php
header("Content-Type:text/html;charset=UTF-8");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-env="Content-Type" conten="text/html;charset=UTF-8">
	<link rel="stylesheet"type="text/css"href="choice.css">
	<title>Reciprice</title>

</head>
<body>
	<!--ヘッダとサイド-->
	<div class="side">
	</div>
	<div class="header">        
		<a href="/top/main.php"><img src = "/Reciprice.png"width="350.7"height="92.4"></a>
	</div>
	<a href="/user/user.php">
		<input class="button_1"type="button"value="ユーザ管理">
	</a>
	<a href="menu.php">
		<input class="button_2"type="button"value="献立表示">
	</a>
	<a href="/price/price.php">
		<input class="button_3"type="button"value="価格予測">
	</a>
	<a href="menu.php">
		<input class="button_4"type="button"value="1週目">
	</a>
	<a href="menu2.php">
		<input class="button_5"type="button"value="2週目">
	</a>
	<a href="menu3.php">
		<input class="button_6"type="button"value="3週目">
	</a>
	<a href="menu4.php">
		<input class="button_7"type="button"value="4週目">
	</a>
	<a href="menu5.php">
		<input class="button_8"type="button"value="5週目">
	</a>
	
	<!--ヘッダとサイドおわり-->
	<!--ページごとに週を送る→-日付を得る→日付ごとのメニューを表示→-それぞれのボタンにメニューIDを→遷移先にメニューID送る→IDをもとに材料表示-->
	
	<?php
	$money=0;
	$button=0;
	
	for($i = 0; $i <=10; $i++)
		$flag[$i] = 0;

	if(isset($_POST['submit'])){
		$button=key($_POST['submit']);
		$flag[$button] = 1;
		$money=$_POST['hidden'][$button];
		$name=$_POST['food'][$button];
		$yosan=$_POST['kane'];
		$nametotal = $_POST['recipe']."|".$name;
	}
	else{
		$yosan = 1000;
	}

	// $yen = 1;
	$yosan = $yosan - $money;

		//挿入部 

		/*
			現状ランダムな金額を挿入していきている．
			また，今のままだとページリセットがかかるごとに，データベースもしくはデータが更新されてしまうため，トランザクションが多いかも？
			そもそも出力する献立は，1000円以下なら1000円以下の料理しか表示しないようにしたい．(選択して消えた部分に対して更にデータ挿入．)
		 */

		require('ramdom.php');
		$source = array();

		$kind = 1; // 1:dish, 2:main, 3:sub, 4:soup
		$obj= new hoge;
		// $food = $obj->GET_DATA($kind);
		// $food = $obj->GET_NAME($kind);
		// print_r($food);

		$recipe = $obj->GET_MONEY($yosan);
		// var_dump($recipe);

		// $yen = array();
		// $food_id = array();              //料理名を格納した配列データ
		// foreach ($food as $key => $value) {
			// $yen[$key] = $obj->GET_MONEY($value);
			// printf("%s回目\n", $value);
		// }

		for($i = 0; $i <= 10; $i++ ){
			$subfood[$i] = "サラダ";
			$subyen[$i] = 4;
		}


		echo'<div class="menu_table">';
		echo' <table cellpadding="10">';
		echo'<form method="post"action="">';
		
		function printButton( $yosan, $yen, $i, $food){
			if($yosan >= $yen){
				echo $i % 2 == 1 ? '<tr>' : '';
				echo "<td><input type='hidden' name='hidden[$i]' value='$yen'>
				<input class='kadomaru' type='submit' name='submit[$i]' value='$food $yen 円'>
				<input type='hidden' name='food[$i]' value='$food'>
				</td>";
			}
			else{
				echo $i % 2 == 1 ? '<tr>' : '';
				echo'<td><input class="kadomaru"type="button"value='.'></a></td>';
			}
		}

		$i = 1;
		foreach ($recipe as $key => $value) {
			printButton($yosan, $value, $i, $key);
			$i++;
		}

		// $aaa = explode( '|', $nametotal);
		// var_dump($nametotal);
		// var_dump($aaa);

		echo'<input type="hidden"name="kane"value="'.$yosan.'">';
		echo'<input type="hidden"name="recipe"value="'.$nametotal.'">';
		echo'</form></table></div>';

		


		echo'<div class="menu_table2">';
		echo'<table cellpadding="10">';
		echo'<form method="post"action="">';

		$NameArray = explode( '|', $nametotal);
		// var_dump($nametotal);
		// var_dump($aaa);
		for($i = 1; $i < count($NameArray); $i++ ){
			printButton($yosan, $NameArray[$i], $i, $food);
		}
	
		// echo'<input type="hidden"name="kane"value="'.$yosan.'">';
		// echo'<input type="hidden"name="recipe"value="'.$nametotal.'">';
		
		echo'</form>';
		echo'</form></table></div>';

		/*
		echo'<div class="menu_table3">';
		echo' <table cellpadding="10">';
		echo'<form method="post"action="">';

		for($i = 1; $i <= 10; $i++ ){
			printButton($yosan, $yen[$i], $i, $food);
		}


		echo'<input type="hidden"name="kane"value="'.$yosan.'">';

		echo'</form></table></div>';

		echo'<div class="menu_table4">';
		echo'<table cellpadding="10">';
		echo'<form method="post"action="">';

		for($i = 1; $i <= 10; $i++ ){
			printButton($yosan, $yen[$i], $i, $food);
		}

		
		// echo'<input type="hidden"name="kane"value="'.$yosan.'">';
		// echo'<input type="hidden"name="recipe"value="'.$nametotal.'">';
		
		echo'</form>';
		echo'</form></table></div>';
	*/
		?>
		
	</table>
	
	<div>

		<table class="Day2" cellpadding="10">
			<tr>
				<?php
				for($i = 1;$i <= 4; $i++){
					if($i==1)
						echo'<td>主菜</td>';
					else if($i==2)
						echo'<td>主食</td>';
					else if($i==3)
						echo'<td>サブ</td>';
				}
				?>
			</tr>
		</table>
	</div>
	
	<?php
	echo'<input class="button_9"type="button"value='.'残予算'.''.$yosan.''.'円'.'>';
	echo'<form action="choice.php"method="get">';
	echo'<input class="button_10"type="submit"value="やりなおし">';
	echo "</form>";

	echo'<form action="menu.php" method="get">';
	echo'<input class="button_11"type="submit" name=text value=kakutei>';
	echo'<input type="hidden"name="recipe"value="'.$nametotal.'">';
	echo"</form>";

	?>

</body>
</html>
