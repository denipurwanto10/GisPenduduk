<?php
// Start session to manage error/success messages
session_start();

// Check if there are any messages in the session
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Remove the message after displaying
}

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Remove the message after displaying
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style1.css">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <title>Login Form</title>  
    <style>
        /* Popup style */
        .popup {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            z-index: 999;
        }
        .popup.success {
            background-color: green;
        }
        .popup.error {
            background-color: red;
        }
        .popup button {
            background: none;
            color: #fff;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }
        .form__button.back-button {
    display: block; /* Ensures the button is on a new line */
    text-align: center;
    background-color: #ddd; /* Background color */
    color: #000; /* Text color */
    border: 1px solid #ddd;
    margin-top: -30px; /* Reduce the margin between buttons */
    text-decoration: none; /* Remove underline */
    padding: 10px 20px; /* Padding size */
    transition: background-color 0.3s, color 0.3s;
}

.form__button.back-button:hover {
    background-color: #4f52ba; /* Hover background color */
    color: #fff; /* Hover text color */
}

    </style>
</head>
<body>
    <div class="l-form">
        <div class="shape1"></div>
        <div class="shape2"></div>

        <div class="form">
            <img src="img/authentication.svg" alt="Authentication" class="form__img">

            <!-- Updated form with action attribute pointing to the login processing script -->
            <form action="login.php" method="POST" class="form__content">
                <h1 class="form__title">Selamat Datang</h1>

                <div class="form__div form__div-one">
                    <div class="form__icon">
                        <i class='bx bx-user-circle'></i>
                    </div>

                    <div class="form__div-input">
                        <label for="username" class="form__label">Username</label>
                        <input type="text" id="username" name="username" class="form__input" required>
                    </div>
                </div>

                <div class="form__div">
                    <div class="form__icon">
                        <i class='bx bx-lock'></i>
                    </div>

                    <div class="form__div-input">
                        <label for="password" class="form__label">Password</label>
                        <input type="password" id="password" name="password" class="form__input" required>
                    </div>
                </div>

                <input type="submit" name="submit" class="form__button" value="Login">
                <a href="index.php" class="form__button back-button">Kembali</a>
            </form>
        </div>
    </div>

    <!-- Popup notification -->
    <div id="popup" class="popup">
        <span id="popup-message"></span>
        <button onclick="closePopup()">Close</button>
    </div>

    <script src="style/js/main.js"></script>
    
    <script>
        // Check if there is any success or error message from PHP
        <?php if (isset($error_message)): ?>
            displayPopup('error', '<?= htmlspecialchars($error_message); ?>', 'form_login.php');
        <?php elseif (isset($success_message)): ?>
            displayPopup('success', '<?= htmlspecialchars($success_message); ?>', 'index.php');
        <?php endif; ?>

        // Function to display popup
        function displayPopup(type, message, redirectUrl) {
            var popup = document.getElementById('popup');
            var popupMessage = document.getElementById('popup-message');
            
            popupMessage.textContent = message;
            popup.className = 'popup ' + type;  // Add type (success or error)
            popup.style.display = 'block';  // Show the popup

            // Set the redirect URL after the popup is closed
            popup.onclick = function() {
                window.location.href = redirectUrl;
            };
        }

        // Function to close popup
        function closePopup() {
            var popup = document.getElementById('popup');
            popup.style.display = 'none';
        }
    </script>
</body>
</html>
