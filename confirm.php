<?php
session_start();

// ファイル読み込み
require_once( __DIR__ . '/mail.php');

// セッションデータ取得
$inquiry_data = isset($_SESSION['inquiry_data']) ? $_SESSION['inquiry_data'] : array();

$subject = isset($inquiry_data['subject']) ? $inquiry_data['subject'] : "";
$name = isset($inquiry_data['name']) ? $inquiry_data['name'] : "";
$email = isset($inquiry_data['email']) ? $inquiry_data['email'] : "";
$tel = isset($inquiry_data['tel']) ? $inquiry_data['tel'] : "";
$message = isset($inquiry_data['message']) ? $inquiry_data['message'] : "";

//操作アクションを取得
$act = isset($_POST["act"]) ? intval($_POST["act"]) : 1;

// 送信ボタンを押下された場合
if ($act == 3) {

    // 管理者へメール送信
    $send_mail_admin_result = sendMailAdmin($inquiry_data);
    sleep(5);
    // ユーザーへメール送信
    $send_mail_user_result = sendMailUser($inquiry_data);

    if ($send_mail_admin_result && $send_mail_user_result) {
        header("Location: complete.php");
        exit();
    } else {
        $_SESSION = array();
        header("Location: error.html");
        exit();
    }
}

// CSRFファイル読み込み
require_once( __DIR__ . '/csrf.php');

// CSRF対策
if (!isset($inquiry_data['token']) || $inquiry_data['token'] !== getToken()) {
    header("Location: error.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>お問い合わせ内容確認</title>
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

                <h1 >お問い合わせ内容確認</h1>
                <div class="row">
                    <div class="col-sm-9">

                        <form action="" class="form-horizontal" method="post">
                            <div class="form-group">
                                <table class="table table-bordered confirm">
                                    <tr>
                                        <th>件名</th>
                                        <td><?php echo $subject; ?></td>
                                    </tr>
                                    <tr>
                                        <th>名前</th>
                                        <td><?php echo $name; ?></td>
                                    </tr>
                                    <tr>
                                        <th>メールアドレス</th>
                                        <td><?php echo $email; ?></td>
                                    </tr>
                                    <tr>
                                        <th>電話番号</th>
                                        <td><?php echo $tel; ?></td>
                                    </tr>
                                    <tr>
                                        <th>お問い合わせ内容</th>
                                        <td><?php echo $message; ?></td>
                                    </tr>
                                </table>
                                <p><input type="submit" onclick="action = 'index.php';" value="修正"></p>
                                <p><input type="submit" value="送信"></p>
                                <input type="hidden" name="act" value="3">
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /container -->
        </div><!-- /page -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
