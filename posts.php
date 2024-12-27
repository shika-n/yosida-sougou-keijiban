<?php
require_once("util.php");

function get_total_posts(PDO $dbh) {
	$statement = $dbh->prepare("SELECT COUNT(id) FROM posts;");
	$statement->execute();
	return $statement->fetchAll()[0][0];
}

function get_posts(PDO $dbh, $page_size = null, $page = 1) {
	$offset = ($page - 1) * $page_size;
	if ($page_size) {
		$statement = $dbh->prepare("SELECT * FROM posts LIMIT {$page_size} OFFSET {$offset};");
	} else {
		$statement = $dbh->prepare("SELECT * FROM posts;");
	}
	$statement->execute();
	return $statement->fetchAll();
}

function get_post(PDO $dbh, $id) {
	$id = escape_html($id);
	$statement = $dbh->prepare("SELECT * FROM posts WHERE id = :id;");
	$statement->bindParam("id", $id);
	$statement->execute();
	return $statement->fetchAll();
}

function post(PDO $dbh, $title, $message, $password, $author = null) {
	$hashed_password = password_hash($password, PASSWORD_ARGON2I);

	if ($author) {
		$statement = $dbh->prepare("INSERT INTO posts (title, message, password, author) VALUES (?, ?, ?, ?);");
		return $statement->execute([$title, $message, $hashed_password, $author]);
	}
	$statement = $dbh->prepare("INSERT INTO posts (title, message, password) VALUES (?, ?, ?);");
	return $statement->execute([$title, $message, $hashed_password]);
}

function delete_post(PDO $dbh, $id, $password) {
	$id = escape_html($id);
	$statement = $dbh->prepare("SELECT id, password FROM posts WHERE id = :id;");
	$statement->bindParam("id", $id);
	$statement->execute();
	$result = $statement->fetchAll();
	
	if (!isset($result[0])) {
		return false;
	}

	$stored_password = $result[0]["password"];
	if (password_verify($password, $stored_password)) {
		$statement = $dbh->prepare("DELETE FROM posts WHERE id = :id;");
		$statement->bindParam("id", $id);
		return $statement->execute();
	}
	return false;
}

function edit_post(PDO $dbh, $id, $title, $message, $author, $password) {
	$id = escape_html($id);
	$statement = $dbh->prepare("SELECT id, password FROM posts WHERE id = :id;");
	$statement->bindParam("id", $id);
	$statement->execute();
	$result = $statement->fetchAll();
	
	if (!isset($result[0])) {
		return false;
	}

	$stored_password = $result[0]["password"];
	if (password_verify($password, $stored_password)) {
		$statement = $dbh->prepare("UPDATE posts SET title = :title, message = :message, author = :author WHERE id = :id;");
		$statement->bindParam("id", $id);
		$statement->bindParam("title", $title);
		$statement->bindParam("message", $message);
		$statement->bindParam("author", $author);
		return $statement->execute();
	}
	return false;
}
