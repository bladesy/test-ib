<?php
class Ban {
    private $id,
	    $ip,
	    $postId,
	    $content,
	    $time,
	    $expire;
    public function __construct($ip,
			        $postId,
			        $content,
			        $time,
			        $expire) {
	$this->ip = $ip;
	$this->postId = $postId;
	$this->content = $content;
	$this->time = $time;
	$this->date = $expire;
    }
    public function getId() {
	return $this->id;
    }
    public function getIp() {
	return $this->post;
    }
    public function getPostId() {
	return $this->name;
    }
    public function getContent() {
	return $this->mime;
    }
    public function getTime() {
	return $this->time;
    }
    public function getExpire() {
	return $this->expire;
    }
    public function setId($id) {
	$this->id = $id;
    }
}
?>
