<?php
require_once("File.php");

class Post {
    private $id,
	    $boardId,
	    $parentId,
	    $ip,
	    $flags,
	    $name,
	    $email,
	    $hash,
	    $subject,
	    $content,
	    $time,
	    $file;
    public function __construct($boardId,
				$parentId,
				$ip,
				$name,
				$email,
				$password,
				$subject,
				$content) {
	    $this->boardId = $boardId;
	    if(is_null($parentId))
		$this->parentId = "NULL";
	    else
		$this->parentId = $parentId;
	    $this->ip = $this->formatIp($ip);
	    $this->flags = 0;
	    $this->name = $name;
	    $this->email = $email;
	    $this->hash = $this->genHash($name, $password);
	    $this->subject = $subject;
	    $this->content = $content;
    }
    public static function queryConstruct($assoc) {
	    $instance = new self($assoc["boardId"],
				    $assoc["parentId"],
				    $assoc["ip"],
				    $assoc["name"],
				    $assoc["email"],
				    $assoc["password"],
				    $assoc["subject"],
				    $assoc["content"]);		
	    $instance->id = $assoc["id"];
	    $instance->time = $assoc["time"];
	    if($assoc["fileId"])
		$instance->file = File::queryConstruct($assoc["fileId"], 
						$assoc["postId"], 
						$assoc["fileName"],
						$assoc["mime"]);
	    return $instance;
    }
    private function genHash() {
	$salt = "$2a$09$" . $this->name;
	for($i = 0; $i < (22 - strlen($this->name)); $i++)
	    $salt .= ".";
	$salt .= "$";
	return crypt($this->password, $salt);
    }
    private function formatIp($ip) {
	return ip2long($ip == "::1"? "127.0.0.1" : $ip);
    }
    public function getId() {
	return $this->id;
    }
    public function getBoardId() {
	return $this->boardId;
    }
    public function getParentId() {
	return $this->parentId;
    }
    public function getFileId() {
	return $this->fileId;
    }
    public function getIp() {
	return $this->ip;
    }
    public function getFlags() {
	return $this->flags;
    }
    public function getName() {
	return $this->name;
    }
    public function getEmail() {
	return $this->email;
    }
    public function getHash() {
	return $this->hash;
    }
    public function getSubject() {
	return $this->subject;
    }
    public function getContent() {
	return $this->content;
    }
    public function getTime() {
	return $this->time;
    }
    public function getFile() {
	return $this->file;
    }
    public function setId($id) {
	$this->id = $id;
    }
    public function setFlags($flags) {
	$this->flags = $flags;
    }
    public function setTime($time) {
	$this->time = $time;
    }
    public function setFile($file) {
	$this->file = $file;
    }
    public function outputHtml() {
        $type = $this->parentId == "NULL"? "thread" : "post";
	$nameNoEmail = <<< HTML
			<span class="$type-name">{$this->name}</span>
HTML;
	$nameEmail = <<< HTML
			<a class="$type-email" 
			href="mailto:{$this->email}">
				{$this->name}
			</a>
HTML;
	$nameTag = $this->email? $nameEmail : $nameNoEmail; 
	$shortHash = substr($this->hash, -10);
	if($this->file)
	    $image = "../img/tmb/{$this->file->getThumbFilename()}";
	if($this->parentId != "NULL")
	    $endTags = <<< HTML
		</div>
	</div>

HTML;
		
	return <<< HTML
	<div class="$type">
		<div class="$type-head"> 
			<span class="$type-id">#{$this->id}</span>
$nameTag
			<span class="$type-hash">$shortHash</span>
			<span class="$type-subject">
				{$this->subject}
			</span>
			<span class="$type-time"> {$this->time}</span>
		</div>
		<div class="$type-body">
			<img class="$type-image" src="$image">
			<div class="$type-content">$this->content</div>
$endTags
HTML;
    }
}
?>
