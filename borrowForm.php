<?php
// ─────────────────────────────────────────────────────────────
// borrowForm.php
// Borrow Request Form – Book Review & Borrowing System
// ─────────────────────────────────────────────────────────────
?>
<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Request Form</title>

    <!-- External icons / libraries (jika perlu) -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <link rel="icon" href="image/logo.png">
    <link rel="stylesheet" href="style.css"><!-- Reuse your main CSS -->

    <style>
        /* ───────── dynamic colour variables (reuse from login) ───────── */
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

        /* ───────── basic form styling (copy dari login) ───────── */
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
            max-width: 650px;
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
        .login-form { padding: 20px 30px 30px; }
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: var(--loginContainerColor);
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
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
            margin-top: 5px;
        }
        .login-button:hover { background-color: var(--loginContainerButtonHoverBgColor); }

        @media (max-width: 650px) { .login-container { width: 88%; } }
    </style>

    <script>
        /* ───────── simple JS validation ───────── */
        function validateBorrowForm() {
            const phone = document.getElementById('phone').value.trim();
            const start = document.getElementById('borrowDate').value;
            const end   = document.getElementById('returnDate').value;

            // phone: only digits 10-15
            const phoneOK = /^\d{10,15}$/.test(phone);
            if (!phoneOK) {
                alert("Phone number should contain 10-15 digits only.");
                return false;
            }

            if (start && end && end < start) {
                alert("Return date cannot be earlier than borrow date.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <!-- ───────── HEADER (optional – reuse your own header) ───────── -->
    <header>
        <div id="firstHeader">
            <a href="index.php" id="logo"><img src="image/logoTitle.png" alt="logo" id="logoImage"></a>
        </div>
    </header>

    <!-- ───────── MAIN FORM ───────── -->
    <main>
        <form class="login-container"
              action="backendLogic/borrowFormHandle.php"
              method="POST"
              onsubmit="return validateBorrowForm();">
            <div class="login-header">Borrow Request Form</div>
            <div class="login-form">

                <div class="form-group">
                    <label for="name">Full&nbsp;Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone&nbsp;Number</label>
                    <input type="text" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="email">Email&nbsp;Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="address">Full&nbsp;Address</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="borrowDate">Preferred&nbsp;Borrow&nbsp;Date</label>
                    <input type="date" id="borrowDate" name="borrowDate" required>
                </div>

                <div class="form-group">
                    <label for="returnDate">Expected&nbsp;Return&nbsp;Date</label>
                    <input type="date" id="returnDate" name="returnDate" required>
                </div>

                <div class="form-group">
                    <label for="reason">Why do you want to borrow this book? <small>(optional)</small></label>
                    <textarea id="reason" name="reason" rows="2"></textarea>
                </div>

                <button type="submit" class="login-button">Submit Request</button>
            </div>
        </form>
    </main>

    <!-- ───────── FOOTER (optional) ───────── -->
    <footer style="text-align:center; padding:20px 0;">
        <p>&copy; 2025 BookSpare. All rights reserved.</p>
    </footer>
</body>
</html>
