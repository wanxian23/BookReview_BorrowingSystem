<?php
session_start(); 

if (isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    $_SESSION = array();
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        function validatePasswords() {
            let pass = document.getElementById("new_password").value;
            let repass = document.getElementById("confirm_password").value;
            if (pass !== repass) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>

    <link rel="icon" href="image/logo.png">
    <link rel="stylesheet" href="style.css">

    <style>
        /* REUSE your existing style here (same as login.php) */
        :root {
            --loginContainerBgColor: white;
            --loginContainerColor: black;
            --loginContainerButtonColor: white;
            --loginContainerButtonBgColor: #333;
            --loginContainerButtonHoverBgColor: #444;
            --loginContainerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
        }

        [data-themeColor="darkColor"] {
            --loginContainerBgColor: rgb(50, 50, 50);
            --loginContainerColor: rgb(213, 213, 213);
            --loginContainerButtonBgColor: rgb(157, 157, 157);
            --loginContainerButtonColor: black;
            --loginContainerButtonHoverBgColor: #8f8f8f;
            --loginContainerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 70px 0;
        }

        .login-container {
            background-color: var(--loginContainerBgColor);
            color: var(--loginContainerColor);
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            box-shadow: var(--loginContainerBoxShadow);
            overflow: hidden;
        }

        .login-header {
            padding: 20px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            color: var(--loginContainerColor);
        }

        .login-form {
            padding: 20px 30px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--loginContainerColor);
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-button {
            background-color: var(--loginContainerButtonBgColor);
            color: var(--loginContainerButtonColor);
            border: none;
            border-radius: 5px;
            padding: 14px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            margin-top: 10px;
        }

        .login-button:hover {
            background-color: var(--loginContainerButtonHoverBgColor);
        }

        @media (max-width: 620px) {
            .login-container {
                width: 85%;
            }
        }
    </style>
</head>


 <header>
        <div id="firstHeader">
            <a href="login.php" id="logo"><img src="image/logoTitle.png" alt="logo" id="logoImage"></a>

            <nav>
                <div>
                    <span class="colorButton"><label for="color">Color<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility colorAccessibility">
                        <div class="default option" data-color="defaultColor">Default</div>
                        <div class="option" data-color="lightColor">Light</div>
                        <div class="option" data-color="darkColor">Dark</div>
                    </div>
                </div>

                <div>
                    <span class="fontSizeButton"><label for="fontSize">Font Size<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility fontSizeAccessibility">
                        <div class="option" data-setFontSize="smallFontSize">Small</div>
                        <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                        <div class="option" data-setFontSize="largeFontSize">Large</div>
                        <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
                    </div>
                </div>
                <div>
                    <span class="supportButton"><label for="support">Support<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility support">
                        <span style="color: black;">Follow Us At Instagram!</span>
                        <div>
                            <img src="image/socialMedia/ig_clicked.png" alt="IG Logo">
                            <label for="bookSpare">@BookSpare</label>
                        </div>
                    </div>
                </div>

            </nav>
            <box-icon name='menu' id="burgerIcon" size="10"></box-icon>
        </div>
        <aside>
            <div class="accessibility colorAccessibility">
                <div class="default option" data-color="defaultColor">Default</div>
                <div class="option" data-color="lightColor">Light</div>
                <div class="option" data-color="darkColor">Dark</div>
            </div>
            <span class="accessibilityButton colorButton"><label for="color">Color</label></span>
            <div class="accessibility fontSizeAccessibility">
                <div class="option" data-setFontSize="smallFontSize">Small</div>
                <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                <div class="option" data-setFontSize="largeFontSize">Large</div>
                <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
            </div>
            <span class="accessibilityButton fontSizeButton"><label for="fontSize">Font Size</label></span>
            <div class="accessibility support">
                <span style="color: black;">Follow Us At Instagram!</span>
                <div>
                    <img src="image/socialMedia/ig_clicked.png" alt="IG Logo">
                    <label for="bookSpare">@BookSpare</label>
                </div>
            </div>
            <span class="accessibilityButton supportButton"><label for="support">Support</label></span>
        </aside>
        <div id="secondHeader">
           
        </div>
    </header>












<body>
    <!-- HEADER copied from login.php -->
    <!-- <header>
        <div id="firstHeader">
            <a href="login.php" id="logo"><img src="image/logoTitle.png" alt="logo" id="logoImage"></a>
            <nav>
                <div>
                    <span class="colorButton"><label for="color">Color<box-icon name='chevron-down' class="downArrow"></box-icon></label></span>
                    <div class="accessibility colorAccessibility">
                        <div class="default option" data-color="defaultColor">Default</div>
                        <div class="option" data-color="lightColor">Light</div>
                        <div class="option" data-color="darkColor">Dark</div>
                    </div>
                </div>
                <div>
                    <span class="fontSizeButton"><label for="fontSize">Font Size<box-icon name='chevron-down' class="downArrow"></box-icon></label></span>
                    <div class="accessibility fontSizeAccessibility">
                        <div class="option" data-setFontSize="smallFontSize">Small</div>
                        <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                        <div class="option" data-setFontSize="largeFontSize">Large</div>
                        <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
                    </div>
                </div>
            </nav>
            <box-icon name='menu' id="burgerIcon" size="10"></box-icon>
        </div>
    </header> -->

    <!-- MAIN FORGOT PASSWORD FORM -->
    <main>
        <form class="login-container" action="backendLogic/resetPasswordHandle.php" method="POST" onsubmit="return validatePasswords()">
            <div class="login-header">Reset Password</div>
            <div class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Re-enter Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="login-button">Reset Password</button>
            </div>
        </form>
    </main>

    <footer>
        <h1>Our Social Media</h1>
        <a href="https://www.instagram.com/bookspare_?igsh=NDJmMjl2aGtxdWQ0" target="_blank"></a>
        <p>&copy; 2025 BookSpare. All rights reserved.</p>
    </footer>
</body>
</html>
