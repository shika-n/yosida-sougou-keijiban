<?php
require_once("../db_open.php");
require_once("posts.php");
require_once("templates.php");

session_start();

$id = get_key_default("id", $_GET, 0);
$post = get_post($dbh, $id);
if ($post) {
	$row = $post[0];
	$id = escape_html($row["id"]);
	$title = escape_html($row["title"]);
	$author = escape_html($row["author"]);
	$posted_at = escape_html($row["posted_at"]);
	$message = escape_html($row["message"]);
	
	$back_link = get_back_link();

	$message = inject_mentions($message);

	$confirm_html = <<< __END__
		<div class="flex-col-spacing">
			<div class="post">
				<div class="post-detail">
					<p>{$id} {$title} ({$author})</p>
					<div class="date"><small>{$posted_at}</small></div>
				</div>
				<p>{$message}</p>
			</div>
		</div>
	__END__;
	echo str_replace("<!-- CONTENT -->", $confirm_html, $html);
} else {
	http_response_code(404);
	echo str_replace("<!-- CONTENT -->", "<h1>404 - ページ見つかりません</h1>", $html);
}
