<!DOCTYPE html>
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
    <title>Admin Sign Up</title>

    <style>
        :root {
            --signupContainerBgColor: white;
            --signupContainerColor: black;
            --signupContainerButtonColor: white;
            --signupContainerButtonBgColor: #333;
            --signupContainerButtonHoverBgColor: #444;
            --signupContainerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
        }

        [data-themeColor="darkColor"] {
            --signupContainerBgColor: rgb(50, 50, 50);
            --signupContainerColor: rgb(213, 213, 213);
            --signupContainerButtonBgColor: rgb(157, 157, 157);
            --signupContainerButtonColor: black;
            --signupContainerButtonHoverBgColor: #8f8f8f;
            --signupContainerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 70px 0;
        }

        .signup-container {
            background-color: var(--signupContainerBgColor);
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            box-shadow: var(--signupContainerBoxShadow);
            overflow: hidden;
            color: var(--signupContainerColor);
        }

        .signup-header {
            padding: 20px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .signup-form {
            display: flex;
            flex-wrap: wrap;
            gap: 23px;
            padding: 20px 30px 30px;
        }

        .form-group {
            flex: 1 1 45%;
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            flex: 1 1 100%;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--signupContainerColor);
        }

        .form-group input,
        .form-group select {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 100%;
            box-sizing: border-box;
        }

        .checkbox-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            margin: 5px 0 10px 0;
        }


        .signup-button {
            background-color: var(--signupContainerButtonBgColor);
            color: var(--signupContainerButtonColor);
            border: none;
            border-radius: 5px;
            padding: 14px;
            width: 100%;
            cursor: pointer;
            text-align: center;
            margin-bottom: 20px;
        }

        .signup-button:hover {
            background-color: signupContainerButtonHoverBgColor;
        }

        @media (max-width: 620px) {
            header #secondHeader nav:nth-child(1) {
                display: inline;
            }

            .signup-container {
                width: 85%;
            }

            .form-group {
                flex: 1 1 60%;
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
        <form id="signupForm" class="signup-container" method="post" action="<?php echo htmlspecialchars("backendLogic/adminSignupHandling.php") ?>">
            <div class="signup-header">Admin's Sign Up</div>

            <div class="signup-form">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" maxlength="10" autofocus required>
                </div>

                <div class="form-group full-width">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group full-width">
                    <label for="contact">Contact Number</label>
                    <input type="tel" id="contact" name="contact" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Re-enter Password</label>
                    <input type="password" id="confirm-password" required>
                </div>

                <input type="submit" class="signup-button" id="submit" value="Sign Up">

                <div class="login-link">
                    Already Have An Account? <a href="login.php">Log in</a>
                </div>
            </div>
        </form>
    </main>

    <footer>
        <h1>Our Social Media</h1>
        <a href="https://www.instagram.com/bookspare_?igsh=NDJmMjl2aGtxdWQ0" target="_blank"></a>
        <p>Copyright &copy; 2025 BookSpare. All right reserved</p>
    </footer>

    <script>
        $(document).ready(function () {
            $("#signupForm").submit(function (event) {

                let inputInfoName = [
                    "Username", "Country", "Email", "Contact", "Date Of Birth", "Password", "Re-Enter Password", "Policy & Terms"
                ];

                let inputInfo = [
                    document.getElementById("username").value,
                    document.getElementById("email").value,
                    document.getElementById("contact").value,
                    document.getElementById("password").value,
                    document.getElementById("confirm-password").value,
                ];

                if (!nullValidation(inputInfo, inputInfoName)) {
                    // If put this command on top
                    // It will prevent the form by submitting
                    // So, put it here, the form only restricted from submit when error occur
                    event.preventDefault();
                    return;
                }

                if (!usernameValidation(inputInfo[0])) {
                    event.preventDefault();
                    return;
                }

                if (!contactValidation(inputInfo[2])) {
                    event.preventDefault();
                    return;
                }

                if (!passwordValidation(inputInfo[3], inputInfo[4])) {
                    event.preventDefault();
                    return;
                }

            });

            function nullValidation(inputInfo, inputInfoName) {
                for (let i = 0; i < inputInfo.length; i++) {
                    if (inputInfo[i] === "") {
                        window.alert(inputInfoName[i] + " Cannot Be Null!");
                        return false;
                    }
                }

                return true;
            }

            function usernameValidation(username) {
                if (username.length > 16) {
                    window.alert("Username Cannot Exceed 16 Characters!");
                    return false;
                }

                return true;
            }

            function contactValidation(contact) {
                if (contact.length > 15 || contact.length < 10) {
                    window.alert("Contact Number Must be In The Range 11 to 15!");
                    return false;

                    // Check if the contact is digit
                } else if (!/^\d+$/.test(contact)) {
                    window.alert("Contact Number Must be Number Only!");
                    return false;
                }

                return true;
            }

            function dateValidation(birth) {

                // Initial format is YYYY-MM-DD
                // So, split it by - to get year (index 0)
                let birthYear = parseInt(birth.split("-")[0]);

                if (birthYear < 1910 || birthYear > 2025) {
                    window.alert("Birth Year Can Only In The Range 1910 To 2025!");
                    return false;
                }

                return true;
            }

            function passwordValidation(pass, repass) {
                if (pass !== repass) {
                    window.alert("Password Must Be The Same! Please Try Again!");
                    return false;
                }

                return true;
            }
        });
    </script>

</body>

</html>