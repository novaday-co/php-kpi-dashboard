<?php

namespace App\Controllers;

class AuthController
{
    public function checkPassword($enteredPassword)
    {
        $correctAdminPassword = $_ENV['AdminPassword'];
        $SuperadminPassword = $_ENV['SuperadminPassword'];

        if ($enteredPassword == $correctAdminPassword) {
            $_SESSION['authenticated'] = true;
            $_SESSION['role'] = 'admin';
            return true;
        }elseif($enteredPassword == $SuperadminPassword) {
            $_SESSION['authenticated'] = true;
            $_SESSION['role'] = 'superadmin';
            return true;
        }
        return false;
    }

    public function logout(){
        // Clear all session data
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect the user to the login page or any other desired page
        header("Location: /");
        exit();
    }
}
