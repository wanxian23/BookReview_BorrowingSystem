<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Redirecting</title>

    <style>
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 130px;
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <main>
        <?php
            require("../database/database.php");

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                
                $username = $_POST['username'];
                $email = $_POST['email'];
                $contact = $_POST['contact'];
                $pass = $_POST['password'];

                $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

                $sql = "SELECT * FROM admin WHERE adminUsername = '$username' OR adminEmail = '$email' OR adminPhone = '$contact'";
                $runSQL = $conn->query($sql);

                if ($runSQL->num_rows > 0) {
                    echo "Fail to Create Account! Username/ Email/ Phone Already Exist! Please Try Again....";
                    echo "<meta http-equiv='refresh' content='3; URL=../admin/adminSignup.php'>";    
                } else {
                    $sql = "INSERT INTO admin(adminUsername, adminEmail, adminPhone, password)
                        VALUES ('$username', '$email', '$contact', '$hashedPass')";
                    $runSQL = $conn->query($sql);

                    if ($runSQL) {
                        echo "Account Created Successfully! Please Login Again! Redirecting....";
                        echo "<meta http-equiv='refresh' content='3; URL=../login.php'>";
                    } else {
                        echo "Fail to Create Account! Please Try Again....";
                        echo "<meta http-equiv='refresh' content='3; URL=../admin/adminSignup.php'>";                 
                    }
                }
            }

            $conn->close();
        ?>
    </main>
</body>
</html>