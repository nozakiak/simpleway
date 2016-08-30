<?php
session_start();

// CSRFファイル読み込み
require_once( __DIR__ . '/csrf.php');

// セッションデータ取得
$inquiry_data = isset($_SESSION['inquiry_data']) ? $_SESSION['inquiry_data'] : array();

// CSRF対策
if (!isset($inquiry_data['token']) || $inquiry_data['token'] !== getToken()) {
    $_SESSION = array();
    header("Location: error.html");
    exit();
} else {
    $_SESSION = array();
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>お問い合わせありがとうございました</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="page">
            <div class="container">
                <h1>お問い合わせありがとうございました</h1>
            </div><!-- /container -->
        </div><!-- /page -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
