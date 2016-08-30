<?php

// 管理者のメールアドレス
define('MAIL_ADMIN', 'nozakiak@gmail.com');

/**
 * 管理者へメール送信
 */
function sendMailAdmin($data) {

	$result = false;
	
	$to = MAIL_ADMIN;
	$subject = "お問い合わせ: " . $data['name'] . "様より";
	$message  = "";
	$message .= "**********************************************\n";
	$message .= "件名: " . $data['subject'] . "\n\n";
	$message .= "名前: " . $data['name'] . "\n\n";
	$message .= "メールアドレス: " . $data['email'] . "\n\n";
	$message .= "電話番号: " . $data['tel'] . "\n\n";
	$message .= "お問い合わせ内容: " . $data['message'] . "\n\n";
	$message .= "**********************************************\n";
	// 文字コードをセット
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");
	$result = mb_send_mail($to, $subject, $message);
	
	return $result;
}

/**
 * ユーザーへメール送信
 */
function sendMailUser($data) {

	$result = false;
	
	$to = $data['email'];
	$subject = "お問い合わせ内容（お客様控え）" ;
	$message  = "この度はお問い合わせありがとうございました。\n";
	$message .= "送信して頂いた内容は以下の通りです。\n\n";
	$message .= "**********************************************\n";
	$message .= "件名: " . $data['subject'] . "\n\n";
	$message .= "名前: " . $data['name'] . "\n\n";
	$message .= "メールアドレス: " . $data['email'] . "\n\n";
	$message .= "電話番号: " . $data['tel'] . "\n\n";
	$message .= "お問い合わせ内容: " . $data['message'] . "\n\n";
	$message .= "**********************************************\n";
	
	// 文字コードをセット
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");
	$result = mb_send_mail($to, $subject, $message);
	
	return $result;
}
?>
