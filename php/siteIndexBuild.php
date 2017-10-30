<?php
$siteIndexContentsTop = <<< HTML
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Testchan</title>
		<meta charset="utf-8">
		<meta name="viewport" 
		content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/testchan.css">
	</head>
	<body>
		<div class="index-content">
			<div class="index-container">
				<img class="logo" src="logo.png" 
				alt="logo">
				<div class="boards">
					<div class="boards-header">
						Boards
					</div>
					<div class="boards-content">

HTML;
$siteIndexContentsBottom = <<< HTML
					</div>
				</div>
			</div>
			<div class="index-footer">Footer</div>
		</div>
	</body>
</html>
HTML;

$selectBoardCategories = <<< SQL
SELECT DISTINCT category FROM Board;
SQL;
$boardCategories = $db->query($selectBoardCategories);

if($boardCategories->num_rows)
	while($boardCategory = 
			$boardCategories->fetch_assoc()["category"]) {
		$selectBoards = <<< SQL
SELECT link, name FROM Board
WHERE category = "$boardCategory";
SQL;
		$boards = $db->query($selectBoards);
		$boardEntries = "";
		if($boards->num_rows) {
			while($boardData = $boards->fetch_assoc())
				$boardEntries .= <<< HTML
					<li><a class="boards-link" 
					href="{$boardData["link"]}">
					{$boardData["name"]}
					</a></li>

HTML;
			$boardsTable .= <<< HTML
					<div class="boards-column">
					<div class="boards-category">
					$boardCategory
					</div>
					<ul class="boards-list">
$boardEntries
					</ul>
					</div>

HTML;
		}
	}
	
$siteIndexContents = $siteIndexContentsTop . 
			$boardsTable .
			$siteIndexContentsBottom;

$siteIndex = fopen("../index.html", "w");
fwrite($siteIndex, $siteIndexContents);
fclose($siteIndex);
?>
