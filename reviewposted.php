<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

?>
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
    <title>Review Posted!</title>

    <style>
        :root {
            --containerBgColor: white;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: rgb(244, 244, 244);
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(40, 39, 39);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;

            --anchorColor: rgb(149, 178, 241);
        }

        main {
            margin: 5% 6%;
        }

        .review-container {
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            box-shadow: var(--containerBoxShadow);
            border-radius: 12px;
            padding: 30px;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
        }

        .review-header {
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--containerColor);
        }

        .confirm-btn {
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        .confirm-btn:hover {
            background-color: var(--buttonHoverColor);
        }

        .confirm-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <main>
        <div class="review-container">
            <div class="review-header">
                <h2 class="review-success"
                    style="text-align: center; font-size: 1.6em;">Success
                </h2>
            </div>

            <div style="display: flex; gap: 20px; width: 100%; justify-content: center;">
                <box-icon name='check-circle' class="downArrow" color="green" size="lg"></box-icon>
                <p
                    style="display: inline-block; margin-bottom: auto; margin-top:auto; font-weight: bold; text-align: center; font-size: 1.6em;">
                    Successfully Posted!
                </p>
            </div>


            <div class="confirm-container">
                <button type="button" class="confirm-btn">CONFIRM</button>
            </div>

        </div>


        </form>
        </div>

    </main>

    <?php include("footer.php"); ?>
</body>

</html>