<?php
require_once("../db_open.php");
require_once("posts.php");
require_once("templates.php");
require_once("util.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$title = get_key_default("title", $_POST);
	$message = get_key_default("message", $_POST);
	$password = get_key_default("password", $_POST);
	$author = get_key_default("author", $_POST);
	$back_link = get_back_link();

	// エラー発生する可能性があるので、入力した内容を保存
	$_SESSION["submit_title"] = $title;
	$_SESSION["submit_author"] = $author;
	$_SESSION["submit_message"] = $message;

	if (!$title || !$message || !$password) {
		$_SESSION["error"] = "タイトル、メッセージ、パスワードは必要です。";
		header("Location: {$_SERVER['HTTP_REFERER']}#submit-form", true, 303);
		return;
	}

	if (mb_strlen($message) > 255) {
		$_SESSION["error"] = "メッセージは255文字までです";
		header("Location: {$_SERVER['HTTP_REFERER']}#submit-form", true, 303);
		return;
	}
	if (mb_strlen($title) > 100) {
		$_SESSION["error"] = "タイトルは100文字までです";
		header("Location: {$_SERVER['HTTP_REFERER']}#submit-form", true, 303);
		return;
	}
	if ($author && mb_strlen($author) > 50) {
		$_SESSION["error"] = "名前は50文字までです";
		header("Location: {$_SERVER['HTTP_REFERER']}#submit-form", true, 303);
		return;
	}

	if (post($dbh, $title, $message, $password, $author)) {
		echo str_replace("<!-- CONTENT -->", "<h4>投稿しました。</h4><a href='$back_link' class='link-button'>戻る</a>", $html);
		$_SESSION["error"] = null;
		$_SESSION["submit_title"] = null;
		$_SESSION["submit_author"] = null;
		$_SESSION["submit_message"] = null;
	} else {
		$_SESSION["error"] = "投稿が失敗しました。";
		header("Location: {$back_link}#submit-form", true, 303);
	}
} else {
	http_response_code(405);
	echo str_replace("<!-- CONTENT -->", "<h1>405 - メソッドが違います</h1>", $html);
}
