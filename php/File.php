<?php
class File {
    private $id,
	    $postId,
	    $name,
	    $extension,
	    $mime;
    public function __construct(){}
    public static function manualConstruct($postId, $filename) {
	$instance = new self();
	$instance->postId = $postId;
	$basename = basename($filename);
	$basenameSeparator = strpos($basename, ".");
	$instance->name = substr($basename, 0, $basenameSeparator);
	$instance->extension = substr($basename, 
					$basenameSeparator + 1);
	$instance->mime = mime_content_type($filename);
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$instance->mime = finfo_file($finfo, "../img/src/$filename");
	finfo_close($finfo);
	return $instance;
    }
    public static function queryConstruct($id, $postId, $name, $mime) {
	$instance = new self();
	$instance->id = $id;
	$instance->postId = $postId;
	$nameSeparator = strpos($name, ".");
	$instance->name = substr($name, 0, $nameSeparator);
	$instance->extension = substr($name, $nameSeparator + 1);
	$instance->mime = $mime;
        return $instance;
    }
    public function getId() {
        return $this->id;
    }
    public function getPostId() {
        return $this->postId;
    }
    public function getName() {
        return $this->name;
    }
    public function getExtension() {
        return $this->extension;
    }
    public function getMime() {
        return $this->mime;
    }
    public function getSourceFilename() {
        return "{$this->name}.{$this->extension}";
    }
    public function getThumbFilename() {
        return "{$this->postId}.{$this->extension}";
    }
    public function setId($id) {
        $this->id = $id;
    }
}
?>
