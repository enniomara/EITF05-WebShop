<?php
class PasswordService implements PasswordServiceInterface{
    private $errorMessages = array("Please change your password.");
    private $notCommon = false;
    private $databaseConnection;
    private $passwordString;
		
    /**
    * @var \PDO
    */
    public function __construct(\PDO $databaseConnection, $passwordString){
        $this->databaseConnection = $databaseConnection;
        $this->passwordString = $passwordString;
    }
        
        
	/** 
    * Checks if password in PasswordSerice is valid
    * @return boolean
    */
	public static function isValid(){
		return 	checkForUppercase() || checkForLowercase() || checkForNumber() || checkForSpecialChar() || checkSymbolLength() || checkNotCommon();
	}
		
    /** 
    * Hashes password using php standard function password_hash() with Bcrypt.
    * @return string
    */
    public static function hash(){
        return password_hash(self::passwordString, PASSWORD_BCRYPT);
    }
		
	/** 
    * Returns attribute errorMessage.
    * @return string
    */
	public static function stringError(){
	    if(notCommon == true){
			return self::errorMessages;
		}
		return "Please pick another password.";
	}
               
	/** 
    * Checks if there is an uppercase letter in the password
    * @return boolean
    */
	private function checkForUppercase() {
		if (1 == preg_match( '/[A-Z]/', $this->passwordString)){
			return true;
        }	
		array_push($errorMessages, "Uppercase letter missing.");
		return false;
	}
	
	/** 
    * Checks if there is an lowercase letter in the password
    * @return boolean
    */
	private function checkForLowercase(){
		if(1 == preg_match( '/[a-z]/', $this->passwordString)){
			return true;	
		}
		array_push($errorMessages, "Lowercase letter missing.");
		return false;
	}
	
	/** 
    * Checks if there is a number in the password.
    * @return boolean
    */
	private function checkForNumbers() {
		if(1 == preg_match( '/\d/', $this->passwordString)){
			return true;
		}
		array_push($errorMessages, "Number missing.");
		return false;
	}
	
	/** 
    * Checks if there is a special character in the password.
    * @return boolean
    */
	private function checkForSpecialChar() {
		if(1== preg_match('/[^a-zA-Z\d]/', $this->passwordString)){
			return true;
		}
	array_push($errorMessages, "Special character missing.");
		return false;
	}
		
	/** 
    * Checks if the password has atleast 7 characters.
    * @return boolean
    */
    private function checkSymbolLenght(){
        $passwordLength = strlen($this->passwordString);
		if($this->passwordLenght > 6){
			return true;
		}
		$this->errorMessage .= "Please add  atleast " . 7 - $passwordLength . " characters to your password";
		return false;
    }
	
	/** 
    * Checks if the password exists in the table blacklistedPasswords.
    * @return boolean
    */
	private function checkNotCommon(){
		if($this->databaseConnection->connect_error){
			die("Connection failed: " . $this->databaseConnection->connect_error);
		}
		$query = $this->databaseConnection->prepare("SELECT count() FROM 'blacklistedPasswords' WHERE password = ?");
		$query->bind_param('s', $this->passwordString);
		$result = $query->execute();
		$query->close();
		if($result == 0){
			return true;
		}
		array_push($errorMessages, "Not a valid password.");
		return false;
	}
}
?>
