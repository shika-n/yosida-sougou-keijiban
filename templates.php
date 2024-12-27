<?php
require_once("util.php");

$html = <<< __END__
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>掲示板</title>
		<link href="css/style.css" rel="stylesheet">
	</head>
	<body>
		<header>
			<nav>
				<h1><a href="$home_url">掲示板</a></h1>
			</nav>
		</header>
		<main>
			<div class="main-container">
				<!-- CONTENT -->
			</div>
			<!-- EXTRA CONTENT -->
		</main>
	</body>
</html>
__END__;
