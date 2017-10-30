<?php
require_once("Post.php");

$threadPageContentsTop = <<< HTML
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>testchan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/testchan.css">
  </head>
  <body>
    <div class="content">
      <div class="navigation">Navigation Bar</div>
      <div class="container">
	<form class="form" name="post-form" method="POST" 
	enctype="multipart/form-data" target="_self" 
	action="../php/postAdd.php">
		<div class="form-header">Create a new post</div>
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
		<input name="parentId" type="hidden" value="$threadId">
		<input name="boardId" type="hidden" value="$boardId">
		<input class="form-input" name="submit" type="submit" 
		value="Create Post">
	</form>

HTML;
$threadPageContentsBottom = <<< HTML
      </div>
      <div class="footer">Footer</div>
    </div>
  </body>
</html>
HTML;
	
$selectThreadPosts = <<< SQL
SELECT Post.*, 
File.id AS fileId, 
File.postId, 
File.name AS fileName, 
File.mime 
FROM Post 
LEFT JOIN File
ON Post.id = File.postId
WHERE Post.parentId = $threadId
OR Post.id = $threadId
ORDER BY Post.id;
SQL;
$threadPosts = $db->query($selectThreadPosts);

if($threadPosts->num_rows) {
	while($threadPost = $threadPosts->fetch_assoc())
		$threadPagePosts .= 
			Post::queryConstruct($threadPost)->outputHtml();
	$threadPagePosts .= <<< HTML
			</div>
		</div>

HTML;
}

$threadPageContents = $threadPageContentsTop .
			$threadPagePosts .
			$threadPageContentsBottom;

$threadPage = fopen("$boardDir/$threadId.html", "w");
fwrite($threadPage, $threadPageContents);
fclose($threadPage);
?>
