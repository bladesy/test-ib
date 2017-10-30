<?php
require_once("User.php");
require_once("Board.php");

$user = new User($_POST["owner"], $_POST["password"]);
$board = new Board($user->getHash(),
		    $_POST["link"],
		    $_POST["name"],
		    $_POST["category"],
		    $_POST["default"], 
		    $_POST["sfw"]);
$db = new mysqli("localhost", "root", "test", "testchan");

$checkUser = <<< SQL
SELECT userHash FROM User
WHERE hash = "{$board->getOwnerHash()}";
SQL;
$insertUser = <<< SQL
INSERT INTO User VALUES ("{$user->getHash()}", 0);
SQL;
$insertBoard = <<< SQL
INSERT INTO Board
(ownerHash, link, name, category, flags)
VALUES (
"{$board->getOwnerHash()}",
"{$board->getLink()}",
"{$board->getName()}",
"{$board->getCategory()}",
{$board->getFlags()}
);
SQL;
								
$users = $db->query($checkUser);
if(!$users->num_rows)
	$db->query($insertUser);

$db->query($insertBoard);
$board->setId($db->insert_id);

$connectBoard = <<< SQL
INSERT INTO Permit (userHash, boardId, flags)
VALUES (
"{$board->getOwnerHash()}",
{$board->getId()},
0
);
SQL;
$db->query($connectBoard);

$boardId = $board->getId();
$boardDir = "../" . $board->getLink();
mkdir($boardDir);

require("siteIndexBuild.php");
require("boardIndexBuild.php");

$db->close();
?>
