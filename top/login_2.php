<?php
require'password.php';
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのurl
$db['user'] = "root";
$db['pass'] = "";
$db['dbname'] = "Users";

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
  // １．ユーザIDの入力チェック
  if (empty($_POST["userid"])) {
    $errorMessage = "ユーザIDが未入力です。";
  } else if (empty($_POST["password"])) {
    $errorMessage = "パスワードが未入力です。";
  } 

  // ２．ユーザIDとパスワードが入力されていたら認証する
  if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
    // mysqlへの接続
    $mysqli = new mysqli($db['host'], $db['user'], $db['pass']);
    if ($mysqli->connect_errno) {
      print('<p>データベースへの接続に失敗しました。</p>' . $mysqli->connect_error);
      exit();
    }

    // データベースの選択
    $mysqli->select_db($db['dbname']);

    // 入力値のサニタイズ
    $userid = $mysqli->real_escape_string($_POST["userid"]);

    // クエリの実行
    $query = "SELECT * FROM Users WHERE Users_name = '" . $userid . "'";
    $result = $mysqli->query($query);
    if (!$result) {
      print('クエリーが失敗しました。' . $mysqli->error);
      $mysqli->close();
      exit();
    }

    while ($row = $result->fetch_assoc()) {
      // パスワード(暗号化済み）の取り出し
      $db_hashed_pwd = $row['Psssword'];
    }

    // データベースの切断
    $mysqli->close();

    // ３．画面から入力されたパスワードとデータベースから取得したパスワードのハッシュを比較します。
    //if ($_POST["password"] == $pw) {
    if (password_verify($_POST["password"], $db_hashed_pwd)) {
      // ４．認証成功なら、セッションIDを新規に発行する
      session_regenerate_id(true);
      $_SESSION["USERID"] = $_POST["userid"];
      header("Location: /top/main.php");
      exit;
    } 
    else {
      // 認証失敗
      $errorMessage = "ユーザIDあるいはパスワードに誤りがあります。";
    } 
  } else {
    // 未入力なら何もしない
  } 
} 
 
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-env="Content-Type" conten="text/html;charset=UTF-8">
	<link rel="stylesheet"type="text/css"href="login_2.css">
	<title>Reciplan</title>

</head>
 	<body>
		<!--ヘッダ-->
		<div class="header">		
		<a href="top.html"><img src = "/Reciprice.png"width="350.7"height="92.4"></a>
		</div>
		<!--ヘッダ終わり-->
		
		<div class="table">
		<form id="loginForm"name="loginForm"method="post"action=""accept-charset="UTF-8">
		<table cellspacing="30">
		<tr>
			<td>User Name</td><td><input type="text"name="userid"pattern="^[a-zA-Z0-9]+$"maxlength="20"required></td>
		</tr>
		<tr>
			<td>Pass Word</td><td><input type="password"name="password"pattern="^[a-zA-Z0-9]+$"maxlength="20"required></td>
		</tr>
		<tr>
			<?php echo $errorMessage?>
		</tr>
		</table>
			<div class="button">
			<input class="button_1"id="login"type="submit"name="login"value="ログイン"onclick="document.charset='utf-8';">
			</div>
		</div>

	</body>
</html>



