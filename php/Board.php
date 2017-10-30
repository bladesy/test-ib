<?php
class Board {
    private $id,
	    $ownerHash,
	    $flags,
	    $link,
	    $name,
	    $category;
    public function __construct($ownerHash, 
				$link, 
				$name, 
				$category, 
				...$flags) {
	$this->ownerHash = $ownerHash;
	$this->link = $link;
	$this->name = $name;
	$this->category = $category;
	$this->flags = $this->parseCheckbox($flags);
    }
    private function parseCheckbox($flags) {
	foreach($flags as $flag) {
	    $binaryFlags = $binaryFlags << 1;
	    $binaryFlags |= $flag == "on"? 1 : 0;
	}
        return $binaryFlags;
    }
    public function getId() {
	return $this->id;
    }
    public function getOwnerHash() {
	return $this->ownerHash;
    }
    public function getLink() {
	return $this->link;
    }
    public function getName() {
	return $this->name;
    }
    public function getCategory() {
	return $this->category;
    }
    public function getFlags() {
	return $this->flags;
    }
    public function setId($id) {
	$this->id = $id;
    }
}
?>
