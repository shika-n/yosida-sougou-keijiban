<?php
require_once("../db_open.php");
require_once("posts.php");
require_once("templates.php");

session_start();
// ページネーション用
if ($new_page_size = get_key_default("page_size", $_GET)) {
	$_SESSION["page_size"] = $new_page_size;
}
$page_size = get_key_default("page_size", $_SESSION, 10);
$total_pages = ceil(get_total_posts($dbh) / $page_size);
$page = max(1, min($total_pages, get_key_default("page", $_GET, 1)));

// ポスト
$content_html = "";
foreach (get_posts($dbh, $page_size, $page) as $row) {
	$id = escape_html($row["id"]);
	$title = escape_html($row["title"]);
	$author = escape_html($row["author"]);
	$posted_at = escape_html($row["posted_at"]);
	$message = escape_html($row["message"]);

	$message = inject_mentions($message);

	$content_html .= <<< __END__
		<div class="post">
			<div class="post-detail">
				<p>{$id} {$title} ({$author})</p>
				<div class="date"><small>{$posted_at}</small></div>
			</div>
			<p>{$message}</p>
			<a class="link-button" href="edit_post.php?id={$id}">編集</a>
			<a class="link-button" href="delete_post.php?id={$id}">削除</a>
		</div>
	__END__;
}

$content_html .= <<< ___EOF
	<div class="page-size-selector">
		<p>1ページにポスト数</p>
		<a href="?page_size=5">5</a>
		<a href="?page_size=10">10</a>
		<a href="?page_size=20">20</a>
	</div>
___EOF;

// ページネーション
$content_html .= "<div class='paging'>";
if ($page != 1) {
	$prev_page = max(1, $page - 1); 
	$content_html .= "<a href='?page=1'>最初</a>";
	$content_html .= "<a href='?page={$prev_page}'>&lt;</a>";
}
for ($i = max(1, $page - 3); $i <= min($total_pages, $page + 3); ++$i) {
	if ($page != $i) {
		$content_html .= "<a href='?page={$i}'>$i</a>";
	} else {
		$content_html .= "<a class='current-page'>$i</a>";
	}
}
if ($page != $total_pages) {
	$next_page = min($total_pages, $page + 1); 
	$content_html .= "<a href='?page={$next_page}'>&gt;</a>";
	$content_html .= "<a href='?page={$total_pages}'>最後</a>";
}
$content_html .= "</div>";


// 投稿フォーム
$error = escape_html(get_key_default("error", $_SESSION));
$submit_title = escape_html(get_key_default("submit_title", $_SESSION));
$submit_author = escape_html(get_key_default("submit_author", $_SESSION));
$submit_message = escape_html(get_key_default("submit_message", $_SESSION));
$_SESSION["error"] = null;

$error_p = "";
if ($error) {
	$error_p = "<p class='error-text'>{$error}</p>";
}

$extra_content_html = <<< __END__
	<div class="main-container">
		<form id="submit-form" class="form-style flex-col-spacing" method="POST" action="submit_post.php">
			{$error_p}
			<div class="submit-form-grid">
				<label for="title">タイトル</label>
				<input type="text" id="title" name="title" value="{$submit_title}" required maxlength="100">
				<label for="author">名前（任意）</label>
				<input type="text" id="author" name="author" value="{$submit_author}" maxlength="50">
				<textarea id="message" name="message" rows="" cols="" required maxlength="255">{$submit_message}</textarea>
				<label for="password">削除パスワード</label>
				<input type="password" id="password" name="password" value="" required>
				<input type="submit" name="" value="投稿" class="link-button">
			</div>
		</form>
	</div>
__END__;

$html = str_replace("<!-- CONTENT -->", $content_html, $html);
$html = str_replace("<!-- EXTRA CONTENT -->", $extra_content_html, $html);
echo $html;
