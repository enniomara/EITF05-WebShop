<?php
	
	Class PasswordChecker{
		private $password;
		
		public function __construct($string){
			$this -> password = $string;	
		}
		
		// Check if password is valid
		public function checkIfValid($password){
			if(checkForLetter($password) && checkForNumber($password) && checkForSpecialChar($password){
				return checkNotCommon($password);
				}
			return false;
		}	
		
		// Check if password contains upper case letters
		private function checkForUpperCase($password) {
			return preg_match( '/[A-Z]/', $string );
		}
	
		// Check if password contains lower case letters
		private function checkForLowerCase($password){
			return preg_match( '/[a-z]/', $string );
		}
	
		// Check if password contains numbers
		private function checkForNumbers($password) {
			return preg_match( '/\d/', $string );
		}
	
		// Check if password contains special characters
		private function checkForSpecialChar($password) {
			return preg_match('/[^a-zA-Z\d]/', $string);
		}
	
		// Check if password is common
		private function checkNotCommon($password){
			$file = fopen('commonPasswords.txt','r') or exit("Unable to open file.");
			while (!feof($file)) {
				if($password = fgets($file)){
					fclose($file);
					return false;
				}
			}
			fclose($file);
			return true;
		}
	}
?>