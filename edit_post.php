<?php
require_once("../db_open.php");
require_once("posts.php");
require_once("templates.php");
require_once("util.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = get_key_default("id", $_POST);
	$title = get_key_default("title", $_POST);
	$message = get_key_default("message", $_POST);
	$password = get_key_default("password", $_POST);
	$author = get_key_default("author", $_POST);
	$back_link = get_back_link();
	
	// エラー発生する可能性があるので、入力した内容を保存
	$_SESSION["submit_title"] = $title;
	$_SESSION["submit_author"] = $author;
	$_SESSION["submit_message"] = $message;

	if (!$title || !$author || !$message || !$password) {
		$_SESSION["error"] = "タイトル、名前、メッセージ、パスワードは必要です。";
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
	if (mb_strlen($author) > 50) {
		$_SESSION["error"] = "名前は50文字までです";
		header("Location: {$_SERVER['HTTP_REFERER']}#submit-form", true, 303);
		return;
	}

	if ($id && edit_post($dbh, $id, $title, $message, $author, $password)) {
		echo str_replace("<!-- CONTENT -->", "<h4>ポスト内容変更しました。</h4><a href='$home_url' class='link-button'>戻る</a>", $html);
		$_SESSION["error"] = null;
		$_SESSION["submit_title"] = null;
		$_SESSION["submit_author"] = null;
		$_SESSION["submit_message"] = null;
	} else {
		$_SESSION["error"] = "パスワードが異なります。";
		header("Location: {$back_link}", true, 303);
		return;
	}
} else {
	$id = get_key_default("id", $_GET, 0);
	$post = get_post($dbh, $id);
	$error = get_key_default("error", $_SESSION);
	$_SESSION["error"] = null;
	
	$error_p = "";
	if ($error) {
		$error_p = "<p class='error-text'>{$error}</p>";
	}
	
	if ($post) {
		$row = $post[0];
		$id = escape_html($row["id"]);
		$title =  escape_html($row["title"]);
		$author = escape_html($row["author"]);
		$message = escape_html($row["message"]);
		
		if (get_key_default("edit_id", $_SESSION) == $id) {
			$title = get_key_default("submit_title", $_SESSION) ?? $title;
			$message = get_key_default("submit_message", $_SESSION) ?? $message;
			$author = get_key_default("submit_author", $_SESSION) ?? $author;
		} else {
			$_SESSION["error"] = null;
			$_SESSION["submit_title"] = null;
			$_SESSION["submit_author"] = null;
			$_SESSION["submit_message"] = null;
		}
		$_SESSION["edit_id"] = $id;

		$back_link = get_back_link();

		$confirm_html = <<< __END__
			<div class="flex-col-spacing">
				<h4>以下のポストの編集</h4>
				<form id="submit-form" class="form-style flex-col-spacing" method="POST">
					{$error_p}
					<div class="submit-form-grid">
						<input type="hidden" name="id" value={$id}>
						<label for="title">タイトル</label>
						<input type="text" id="title" name="title" value="{$title}" required maxlength="100">
						<label for="author">名前（任意）</label>
						<input type="text" id="author" name="author" value="{$author}" maxlength="50">
						<textarea id="message" name="message" rows="" cols="" required maxlength="255">{$message}</textarea>
					</div>
					<div>
						<input type="password" name="password" value="" placeholder="削除パスワード" required>
						<input type="submit" name="" value="編集" class="link-button">
						<a href="$back_link" class="link-button">キャンセル</a>
					</div>
				</form>
			</div>
		__END__;
		echo str_replace("<!-- CONTENT -->", $confirm_html, $html);
	} else {
		http_response_code(404);
		echo str_replace("<!-- CONTENT -->", "<h1>404 - ページ見つかりません</h1>", $html);
	}
}

