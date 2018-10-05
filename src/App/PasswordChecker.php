<?php
	Class PasswordChecker implements PasswordServiceInterface{
        // return hash of password
        public static function hash($password){
            return password_hash($password, PASSWORD_BCRYPT);
        }
        
		// Check if password is valid
		public static function isValid($password){
			if(checkForLetter($password) && checkForNumber($password) && checkForSpecialChar($password) && checkSymbolLength($password)){
				return checkNotCommon($password);
				}
			return false;
		}	
		
        // Check if password is aleast 7 in symbol lenght
        private function checkSymbolLenght($password){
            return preg_match();
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
