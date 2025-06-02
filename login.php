<?php 

session_start(); 

// If not null
if (isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    // Clear all $_SESSION variables that create in other form
    // Like username and password
    $_SESSION = array();

    // Destroy the session so that wont crash with others
    session_destroy();
}

?>
<!DOCTYPE html>
<!-- data-xxxx (The "xxxx" is optional - like a variable name) -->
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Free Icon Website -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <!-- put link to jquery library by using google CDN or Microsoft CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- UI jQuery library, which include more animation effect -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script src="script.js"></script>

    <link rel="icon" href="image/logo.png">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>

    <style>
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
            columns: var(--loginContainerColor);
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

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            color: var(--loginContainerColor);
        }

        .form-footer .remember-me {
            display: flex;
            align-items: center;
        }

        .form-footer .remember-me input {
            margin-right: 8px;
        }

        .form-footer .forgot-password {
            color: #4285f4;
            text-decoration: none;
        }

        .form-footer .forgot-password:hover {
            text-decoration: underline;
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
            margin-bottom: 20px;
        }

        .login-button:hover {
            background-color: var(--loginContainerButtonHoverBgColor)
        }

        .signup-link {
            text-align: center;
            color: var(--loginContainerColor);
        }

        .signup-link a {
            color: #4285f4;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 620px) {
            header #secondHeader nav:nth-child(1) {
                display: inline;
            }

            .login-container {
                width: 85%;
            }
        }
    </style>
</head>

<body>
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
            <nav>
                <a href="login.php"><label for="login">Login</label></a>
                <a href="signup.html"><label for="signup">Signup</label></a>
            </nav>
        </div>
    </header>

    <main>
        <form class="login-container" action="backendLogic/loginHandle.php" method="POST">
            <div class="login-header">
                Log In
            </div>
            <div class="login-form">
                <div class="form-group">
                    <label for="username">Username/ Email/ Phone</label>
                    <input type="text" id="username" name="username" autofocus required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-footer">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember Me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                <button type="submit" class="login-button">Log In</button>
                <div class="signup-link">
                    Don't Have An Account? <a href="signup.html">Sign Up</a>
                </div>
            </div>
        </form>
    </main>

    <footer>
        <h1>Our Social Media</h1>
        <a href="https://www.instagram.com/bookspare_?igsh=NDJmMjl2aGtxdWQ0" target="_blank"></a>
        <p>Copyright &copy; 2025 BookSpare. All right reserved</p>
    </footer>

    <!-- <script>
        $(document).ready(function () {
            $(".login-button").click(function (e) {
                let username = $("#username").val();
                let password = $("#password").val();
                let isValid = true;

                if (!username) {
                    $("#username").css("border-color", "red");
                    isValid = false;
                } else {
                    $("#username").css("border-color", "#ccc");
                }

                if (!password) {
                    $("#password").css("border-color", "red");
                    isValid = false;
                } else {
                    $("#password").css("border-color", "#ccc");
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }

                alert("Login form submitted successfully!");
            });
        });
    </script> -->
</body>

</html>