<?php
$home_url = "/keijiban2/99_sougou";

function get_key_default($key, $dict, $default=null) {
	if (isset($dict[$key])) {
		return $dict[$key];
	}
	return $default;
}

function escape_html($str) {
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function get_back_link() {
	global $home_url;

	$back_link = get_key_default("HTTP_REFERER", $_SERVER, $home_url);
	if ($_SERVER["REQUEST_METHOD"] == "GET" && str_ends_with($back_link, $_SERVER["REQUEST_URI"])) {
		$back_link = $home_url;
	}

	return $back_link;
}

function inject_mentions($str) {
	$offset = 0;
	while (true) {
		$pos = mb_strpos($str, "&gt;&gt;", $offset);
		if ($pos === false) {
			break;
		}

		$endpos = $pos;
		for ($i = $pos; $i < mb_strlen($str); ++$i) {
			if ($i == mb_strlen($str) - 1) {
				$endpos = $i;
			} else if ($str[$i] == " ") {
				$endpos = $i - 1;
				break;
			}
		}

		$mid = mb_substr($str, $pos + 8, $endpos - $pos - 8 + 1);
		if (is_numeric($mid)) {
			$str = substr_replace($str, "<a href='view_post.php?id={$mid}'>&gt;&gt;{$mid}</a>", $pos, $endpos - $pos + 1);
		}
		$offset = $endpos + 1;
	}
	return $str;
}
