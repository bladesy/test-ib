<?php
class Permit {
    private $userHash,
	    $boardId,
	    $flags;
    public function __construct($userHash, $boardId) {
        $this->userHash = $userHash;
	$this->boardId = $boardId;
    }
    public function getUserHash() {
        return $this->userHash;
    }
    public function getBoardId() {
        return $this->boardId;
    }
    public function getFlags() {
        return $this->flags;
    }
}
?>
