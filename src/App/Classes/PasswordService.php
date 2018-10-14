<?php

namespace App\Classes;

use App\Interfaces\PasswordServiceInterface;

class PasswordService implements PasswordServiceInterface
{
    private $errorMessages = array("Please change your password.");
    private $password;
    private $databaseConnection;

    /**
     * PasswordService constructor.
     * @param \PDO $databaseConnection
     */
    public function __construct(\PDO $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }


    /**
     * Checks if password in PasswordService is valid
     *
     * @param string passwordString
     * @return bool
     */
    public function isValid(string $password): bool
    {
        $this->password = $password;
        return ($this->hasUppercase() && $this->hasLowercase() && $this->hasNumber() && $this->hasSpecialChar() && $this->checkSymbolLength() && $this->isNotCommon());
    }

    /**
     * Hashes password using php standard function password_hash() with Bcrypt
     *
     * @param string $password
     * @return string
     */
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Returns array with error messages
     *
     * @return array $errorMessages
     */
    public function getError(): array
    {
        return $this->errorMessages;
    }

    /**
     * Checks if there is an uppercase letter in the password
     *
     * @return bool
     */
    private function hasUppercase(): bool
    {
        if (1 == preg_match('/\p{Lu}/', $this->password)) {
            return true;
        }
        array_push($this->errorMessages, "Uppercase letter missing.");
        return false;
    }

    /**
     * Checks if there is an lowercase letter in the password
     *
     * @return bool
     */
    private function hasLowercase(): bool
    {
        if (1 == preg_match('/\p{Ll}/', $this->password)) {
            return true;
        }
        array_push($this->errorMessages, "Lowercase letter missing.");
        return false;
    }

    /**
     * Checks if there is a number in the password
     *
     * @return bool
     */
    private function hasNumber(): bool
    {
        if (1 == preg_match('/\d/', $this->password)) {
            return true;
        }
        array_push($this->errorMessages, "Number missing.");
        return false;
    }

    /**
     * Checks if there is a special character in the password
     *
     * @return bool
     */
    private function hasSpecialChar(): bool
    {
        if (1 == preg_match('/[^\p{Lu}\p{Ll}\d]/', $this->password)) {
            return true;
        }
        array_push($this->errorMessages, "Special character missing.");
        return false;
    }

    /**
     * Checks if the password has atleast 7 characters.
     *
     * @return boolean
     */
    private function checkSymbolLength(): bool
    {
        $passwordLength = strlen($this->password);
        if ($passwordLength > 6) {
            return true;
        }
        array_push($this->errorMessages, "Please add  atleast " . 7 - $passwordLength . " characters to your password");
        return false;
    }

    /**
     * Checks if the password exists in the table blacklistedPasswords.
     *
     * @return bool
     */
    private function isNotCommon(): bool
    {
        $query = $this->databaseConnection->prepare("SELECT count() FROM 'blacklistedPasswords' WHERE password = :passwordString");
        $query->bindValue(':passwordString', $this->password);
        $result = $query->execute();
        if ($result == 0) {
            return true;
        }
        array_push($this->errorMessages, "Not a valid password.");
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
