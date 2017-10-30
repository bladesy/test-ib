<?php
require_once("Post.php");

$db = new mysqli("localhost", "root", "test", "testchan");
$post = new Post($_POST["boardId"],
			$_POST["parentId"], 
			$_SERVER["REMOTE_ADDR"],
			$_POST["name"], 
			$_POST["email"], 
			$_POST["password"], 
			$_POST["subject"], 
			$_POST["content"]);

$insertPost = <<< SQL
INSERT INTO Post
(boardId, parentId, ip, flags, name, email, hash, subject, content) 
VALUES (
{$post->getBoardId()},
{$post->getParentId()},
{$post->getIp()},
{$post->getFlags()},
"{$post->getName()}",
"{$post->getEmail()}",
"{$post->getHash()}",
"{$post->getSubject()}",
"{$post->getContent()}"
);
SQL;
$db->query($insertPost);
$post->setId($db->insert_id);

if(is_uploaded_file($_FILES["file"]["tmp_name"])) {
	$file = File::manualConstruct($post->getId(),
					$_FILES["file"]["name"]);
	$post->setFile($file);
	$insertFile = <<< SQL
INSERT INTO File (postId, name, mime)
VALUES (
{$file->getPostId()}, 
"{$file->getName()}.{$file->getExtension()}",
"{$file->getMime()}"
);
SQL;
	$db->query($insertFile);
	move_uploaded_file($_FILES["file"]["tmp_name"], 
		"../img/src/{$file->getSourceFilename()}");
	$thumbnail = new Imagick(
		"../img/src/{$file->getSourceFilename()}");
	$thumbnail->thumbnailImage(196, 0);
	$thumbnail->writeImage(
		"../img/tmb/{$file->getThumbFilename()}");
}

$boardId = $_POST["boardId"];
$selectBoard = <<< SQL
SELECT link from Board WHERE id = $boardId;
SQL;
$boardLink = $db->query($selectBoard)->fetch_assoc()["link"];
$boardDir = "../$boardLink";
$threadId = $post->getParentId() == "NULL"?
	$post->getId() : $post->getParentId();

require("boardIndexBuild.php");
require("threadPageBuild.php");

$db->close();
?>
