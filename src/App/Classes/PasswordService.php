<?php

namespace App\Classes;

use App\Interfaces\PasswordServiceInterface;

class PasswordService implements PasswordServiceInterface
{
    private static $errorMessages = array("Please change your password.");

    /**
     * Checks if password in PasswordService is valid
     * @param string passwordString
     * @param \PDO $databaseConnection
     * @return bool
     */
    public static function isValid(string $passwordString, \PDO $databaseConnection)
    {
        if (self::checkForUppercase($passwordString) || self::checkForLowercase($passwordString) || self::checkForNumber($passwordString) || self::checkForSpecialChar($passwordString) || self::checkSymbolLength($passwordString) || self::checkNotCommon($passwordString, $databaseConnection)) {
            return true;
        }
        return false;
    }

    /**
     * Hashes password using php standard function password_hash() with Bcrypt.
     * @param string $passwordString
     * @return string
     */
    public static function hash(string $passwordString)
    {
        return password_hash($passwordString, PASSWORD_BCRYPT);
    }

    /**
     * Clears error message
     */
    public function clearError()
    {
        unset($errorMessages);
        $errorMessages = "Please change your password.";

    }

    /**
     * Checks if there is an uppercase letter in the password
     * @param string $passwordString
     * @return boolean
     */
    private static function checkForUppercase($passwordString)
    {
        if (1 == preg_match('/[A-Z]/', $passwordString)) {
            return true;
        }
        array_push($errorMessages, "Uppercase letter missing.");
        return false;
    }

    /**
     * Checks if there is an lowercase letter in the password
     * @param string $passwordString
     * @return boolean
     */
    private static function checkForLowercase(string $passwordString)
    {
        if (1 == preg_match('/[a-z]/', $passwordString)) {
            return true;
        }
        array_push($errorMessages, "Lowercase letter missing.");
        return false;
    }

    /**
     * Checks if there is a number in the password.
     * @param string $passwordString
     * @return boolean
     */
    private static function checkForNumbers(string $passwordString)
    {
        if (1 == preg_match('/\d/', $passwordString)) {
            return true;
        }
        array_push($errorMessages, "Number missing.");
        return false;
    }

    /**
     * Checks if there is a special character in the password.
     * @param string $passwordString
     * @return boolean
     */
    private static function checkForSpecialChar(string $passwordString)
    {
        if (1 == preg_match('/[^a-zA-Z\d]/', $passwordString)) {
            return true;
        }
        array_push($errorMessages, "Special character missing.");
        return false;
    }

    /**
     * Checks if the password has atleast 7 characters.
     * @param string $passwordString
     * @return boolean
     */
    private static function checkSymbolLenght(string $passwordString)
    {
        $passwordLength = strlen($passwordString);
        if ($passwordLength > 6) {
            return true;
        }
        array_push($errorMessages, "Please add  atleast " . 7 - $passwordLength . " characters to your password");
        return false;
    }

    /**
     * Checks if the password exists in the table blacklistedPasswords.
     * @param string $passwordString
     * @param \PDO $databaseConnection
     * @return boolean
     */
    private static function checkNotCommon(string $passwordString, \PDO $databaseConnection)
    {
        $query = $databaseConnection->prepare("SELECT count() FROM 'blacklistedPasswords' WHERE password = :passwordString");
        $query->bindValue(':passwordString', $passwordString);
        try {
            $result = $query->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
        if ($result == 0) {
            return true;
        }
        array_push($errorMessages, "Not a valid password.");
        return false;
    }
}
