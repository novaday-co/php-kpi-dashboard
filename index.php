<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\KPIController;
use App\Controllers\AuthController;

session_start(); // Start the session

// Load the environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// check if user wants to logout
if(isset($_GET['logout'])){
    $AuthController = new AuthController();
    $AuthController->logout();
}

// Check if the user is already authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // User is authenticated, fetch the grouped KPI data and display the dashboard
    renderDashboard();
} else {
    // User is not authenticated, check the submitted password
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'];
        $AuthController = new AuthController();

        if ($AuthController->checkPassword($password)) {
            // Password is correct, store the authentication state in the session
            renderDashboard();
        } else {
            echo "Invalid password! Please try again.";
        }
    } else {
        // Show the password form
        showPasswordForm();
    }
}

function showPasswordForm()
{
    ?>
    <!DOCTYPE html>
    <html>
    <body>
        <div class="container">
            <h1>KPI Dashboard Password</h1>
            <form method="post">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
                <button type="submit">Enter</button>
            </form>
        </div>
    </body>
    </html>
    <?php
}

function renderDashboard()
{
    $kpiController = new KPIController();
    $kpiController->getGroupedKPIData();
}

?>
