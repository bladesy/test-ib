<?php
require_once("Post.php");

$boardIndexContentsTop = <<< HTML
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>testchan</title>
    <meta charset="utf-8">
    <meta name="viewport"content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/testchan.css">
  </head>
  <body>
    <div class="content">
      <div class="navigation">Navigation Bar</div>
      <div class="container">
	<form class="form" name="thread-form" method="POST" 
	enctype="multipart/form-data" target="_self" 
	action="../php/postAdd.php">
		<div class="form-header">Create a new thread</div>
		<div class="form-group">
			<label class="form-label" for="password">
				Password
			</label>
			<input id="password" class="form-input" 
			name="password" type="password">
		</div>
		<div class="form-group">
			<label class="form-label" for="name">
				Name
			</label>
			<input id="name" class="form-input" name="name" 
			type="text">
		</div>
		<div class="form-group">
			<label class="form-label" for="email">
				Email
			</label>
			<input id="email" class="form-input" 
			name="email" type="email">
		</div>
		<div class="form-group">
			<label class="form-label" for="subject">
				Subject
			</label>
			<input id="subject" class="form-input" 
			name="subject" type="text">
		</div>
		<div class="form-group">
			<label class="form-label" for="content">
				Content
			</label>
			<textarea id="content" class="form-input" 
			name="content" type="text"></textarea>
		</div>
		<div class="form-group">
			<label class="form-label" for="file">
				File
			</label>
			<input id="file" class="form-input" name="file" 
			type="file">
		</div>
		<input name="boardId" type="hidden" value="$boardId">
		<input class="form-input" name="submit" type="submit" 
		value="Create Thread">
	</form>

HTML;
$boardIndexContentsBottom = <<< HTML
      </div>
      <div class="footer">Footer</div>
    </div>
  </body>
</html>
HTML;

$selectThreads = <<< SQL
SELECT Post.*, 
File.id AS fileId, 
File.postId, 
File.name AS fileName, 
File.mime 
FROM Post 
LEFT JOIN File
ON Post.id = File.postId
WHERE parentId IS NULL
AND boardId = $boardId
ORDER BY Post.id;
SQL;
$threads = $db->query($selectThreads);
if($threads->num_rows) {
    while($thread = $threads->fetch_assoc()) {
	$thread = Post::queryConstruct($thread);
	$selectPostPreviews = <<< SQL
SELECT Post.*, 
File.id AS fileId, 
File.postId, 
File.name AS fileName, 
File.mime 
FROM Post 
LEFT JOIN File
ON Post.id = File.postId
WHERE Post.parentId = {$thread->getId()}
ORDER BY Post.id DESC
LIMIT 3;
SQL;
	$postPreviews = $db->query($selectPostPreviews);
	$boardIndexThreads .= $thread->outputHtml();
	if($postPreviews->num_rows)
		while($postPreview = $postPreviews->fetch_assoc())
			$boardIndexThreads .= 
				Post::queryConstruct($postPreview)
				->outputHtml();
	$boardIndexThreads .= <<< HTML
			</div>
		</div>

HTML;
    }
}
		
$boardIndexContents = $boardIndexContentsTop . 
			$boardIndexThreads .
			$boardIndexContentsBottom;

$boardIndex = fopen("$boardDir/index.html", "w");
fwrite($boardIndex, $boardIndexContents);
fclose($boardIndex);
?>
