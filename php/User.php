<?php
class User {
    private $hash,
	    $flags,
	    $name, 
	    $password;
    public function __construct($name, $password) {
	$this->name = $name;
	$this->password = $password;
	$this->hash = $this->genHash();
    }
    private function genHash() {
	$salt = "$2a$09$" . $this->name;
	for($i = 0; $i < (22 - strlen($this->name)); $i++)
		$salt .= ".";
	$salt .= "$";
	return crypt($this->password, $salt);
    }
    public function getHash() {
        return $this->hash;
    }
    public function getFlags() {
	return $this->flags;
    }
    public function getName() {
	return $this->name;
    }
    public function getPassword() {
	return $this->password;
    }
}
?>
