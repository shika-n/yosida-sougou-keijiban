<?php
require_once("../db_open.php");
require_once("posts.php");
require_once("templates.php");
require_once("util.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = get_key_default("id", $_POST);
	$password = get_key_default("password", $_POST);
	$back_link = get_back_link();
	
	if ($id && delete_post($dbh, $id, $password)) {
		echo str_replace("<!-- CONTENT -->", "<h4>ポスト削除しました。</h4><a href='$home_url' class='link-button'>戻る</a>", $html);
		$_SESSION["error"] = null;
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
		$title = escape_html($row["title"]);
		$author = escape_html($row["author"]);
		$posted_at = escape_html($row["posted_at"]);
		$message = escape_html($row["message"]);
		
		$back_link = get_back_link();

		$confirm_html = <<< __END__
			<div class="flex-col-spacing">
				<h4>以下のポストを本当に削除しますか？</h4>
				<div class="post">
					<div class="post-detail">
						<p>{$id} {$title} ({$author})</p>
						<div class="date"><small>{$posted_at}</small></div>
					</div>
					<p>{$message}</p>
				</div>
				<form class="form-style flex-col-spacing" method="POST">
					{$error_p}
					<div>
						<input type="hidden" name="id" value={$id}>
						<input type="password" name="password" value="" placeholder="削除パスワード" required>
						<input type="submit" name="" value="削除" class="link-button">
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

