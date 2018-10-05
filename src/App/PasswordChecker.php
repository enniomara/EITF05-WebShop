<?php
	Class PasswordChecker implements PasswordServiceInterface{
		private $errorMessage = "Please include in your password:<br/>";
		private $notCommon = false;
		$dbhost = 'localhost:3036';
		$dbuser = 'root';
		$dbpass = 'rootpassword';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
		
		// Check if password is valid and echo 
		public static function isValid($password, $conn){
			return 	checkForUppercase($password) && checkForLowercase($password) && checkForNumber($password) && 
			checkForSpecialChar($password) && checkSymbolLength($password) && checkNotCommon($password, $conn);
		}
		
        // return hash of password
        public static function hash($password){
            return password_hash($password, PASSWORD_BCRYPT);
        }
		
		// returns string with error message, use only if case of invalid password
		public static function stringError(){
			if(notCommon == true){
				return $errorMessage
			}
			return $errorMessage = "Please pick another password.";
		}
               
		// Check if password contains upper case letters
		private function checkForUppercase($password) {
			if (1 == preg_match( '/[A-Z]/', $password)){
				return true;
			
			$errorMessage .= "- An uppercase letter<br/>"
			return false;
		}
	
		// Check if password contains lower case letters
		private function checkForLowercase($password){
			if(1 == preg_match( '/[a-z]/', $password)){
				return true;	
			}
			$errorMessage .= "- A lowercase letter<br/>"
			return false;
		}
	
		// Check if password contains numbers
		private function checkForNumbers($password) {
			if(1 == preg_match( '/\d/', $password)){
				return true;
			}
			$errorMessage .= "- A number<br/>"
			return false;
		}
	
		// Check if password contains special characters
		private function checkForSpecialChar($password) {
			if(1== preg_match('/[^a-zA-Z\d]/', $password)){
				return true;
			}
			$errorMessage .= "- A special character<br/>"
			return false;
		}
		
		// Check if password is aleast 7 in symbol lenght
        private function checkSymbolLenght($password){
			$n = ;
			if(strlen($password) > 6){
				return true;
			}
			$errorMessage .= "- Password length of atleast 7 characters";
			return false;
        }
	
		// Check if password is common toward database with table blacklistedPasswords
		private function checkNotCommon($password, $conn){
			if($conn->connect_error){
				die("Connection failed: " . $conn->connect_error);
			}
			$query = $conn->prepare("SELECT count() FROM 'blacklistedPasswords' WHERE password = ?"));
			$query->bind_param('s', $password);
			$result = $query->execute();
			$query->close();
			if($result == 0){
				return true;
			}
			$notCommon = true;
			return true;
		}
	}
?>
