<?php
session_start();

//操作アクションを取得
$act = isset($_POST["act"]) ? intval($_POST["act"]) : 1;

if ($act == 1) {

    // セッションデータクリア
    $contact_data = array();
    // 初期値セット
    $subject = '';
    $name = '';
    $email = '';
    $tel = '';
    $message = '';
    $error = array();
} elseif ($act == 2) { // 確認ボタンを押下された場合
    // POSTデータをセッションに格納
    $_SESSION['inquiry_data'] = isset($_POST['inquiry_data']) ? $_POST['inquiry_data'] : array();

    // セッションデータを配列にセット
    $inquiry_data = $_SESSION['inquiry_data'];

    // バリデーション
    $subject = isset($inquiry_data['subject']) ? $inquiry_data['subject'] : '';
    $name = isset($inquiry_data['name']) ? $inquiry_data['name'] : '';
    $email = isset($inquiry_data['email']) ? $inquiry_data['email'] : '';
    $tel = isset($inquiry_data['tel']) ? $inquiry_data['tel'] : '';
    $message = isset($inquiry_data['message']) ? $inquiry_data['message'] : '';
    $error = array();

    if (empty($subject)) {
        $error['subject'] = '選択が必須の項目です';
    }

    if (empty($name)) {
        $error['name'] = '入力が必須の項目です';
    }

    if (empty($email)) {
        $error['email'] = '入力が必須の項目です';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'メールアドレスが正しくありません';
        }
    }

    if (empty($tel)) {
        $error['tel'] = '入力が必須の項目です';
    } else {
        if (!preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $tel)) {
            $error['tel'] = '電話番号が正しくありません';
        }
    }

    if (empty($message)) {
        $error['message'] = '入力が必須の項目です';
    }

    // バリデーションエラーが無い場合、確認ページへ遷移する
    if (empty($error)) {
        header('Location: confirm.php');
        exit();
    }
} else {
    // セッションデータを配列にセット
    $inquiry_data = isset($_SESSION["inquiry_data"]) ? $_SESSION["inquiry_data"] : array();

    // バリデーション
    $subject = isset($inquiry_data['subject']) ? $inquiry_data['subject'] : '';
    $name = isset($inquiry_data['name']) ? $inquiry_data['name'] : '';
    $email = isset($inquiry_data['email']) ? $inquiry_data['email'] : '';
    $tel = isset($inquiry_data['tel']) ? $inquiry_data['tel'] : '';
    $message = isset($inquiry_data['message']) ? $inquiry_data['message'] : '';
}

/**
 * HTMLエスケープ
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// CSRFファイル読み込み
require_once( __DIR__ . '/csrf.php');
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>お問い合わせフォーム</title>
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
                <h1>お問い合わせフォーム</h1>

                <div class="row">
                    <div class="col-sm-9">
                        <form action="" class="form-horizontal" method="post">
                            <input type="hidden" name="inquiry_data[token]" value="<?php echo getToken(); ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">件名</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="inquiry_data[subject]" size="1" required="required">
                                        <option value="">選択してください</option>
                                        <option value="ご意見"<?= $subject === 'ご意見' ? ' selected' : ''; ?>>ご意見</option>
                                        <option value="ご感想"<?= $subject === 'ご感想' ? ' selected' : ''; ?>>ご感想</option>
                                        <option value="その他"<?= $subject === 'その他' ? ' selected' : ''; ?>>その他</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-name" class="col-sm-2 control-label">お名前</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input-name" name="inquiry_data[name]" value="<?php if (isset($name)) echo h($name); ?>" placeholder="お名前" required="required">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-mail" class="col-sm-2 control-label">メールアドレス</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="input-mail" name="inquiry_data[email]" value="<?php if (isset($email)) echo h($email); ?>" placeholder="メールアドレス" required="required">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-name" class="col-sm-2 control-label">電話番号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input-name" name="inquiry_data[tel]" value="<?php if (isset($tel)) echo h($tel); ?>" placeholder="090-0000-0000" required="required">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">お問い合わせ内容</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="5" name="inquiry_data[message]" required="required" maxlength="1000" minlength="10" placeholder="10文字以上 1000文字以内"><?php if (isset($message)) echo h($message); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">送信</button>
                                    <input type="hidden" name="act" value="2">
                                </div>
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
