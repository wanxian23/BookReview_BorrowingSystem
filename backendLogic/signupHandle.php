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
                $country = $_POST['country'];
                $email = $_POST['email'];
                $contact = $_POST['contact'];
                $dateBirth = $_POST['dateBirth'];
                $pass = $_POST['password'];

                $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

                $sqlAdminChecking = "SELECT * FROM Reader_User WHERE username = '$username' OR email = '$email' OR phone = '$contact'";
                $runSQLAdminChecking = $conn->query($sqlAdminChecking);

                $sql = "SELECT * FROM admin WHERE adminUsername = '$username' OR adminEmail = '$email' OR adminPhone = '$contact'";
                $runSQL = $conn->query($sql);

                if ($runSQL->num_rows > 0 || $runSQLAdminChecking->num_rows > 0) {
                    echo "Fail to Create Account! Username/ Email/ Phone Already Exist! Please Try Again....";
                    echo "<meta http-equiv='refresh' content='3; URL=../signup.html'>";    
                } else {
                    $sql = "INSERT INTO Reader_User(username, country, email, phone, dateOfBirth, password)
                        VALUES ('$username', '$country', '$email', '$contact', '$dateBirth', '$hashedPass')";
                    $runSQL = $conn->query($sql);

                    if ($runSQL) {
                        echo "Account Created Successfully! Please Login Again! Redirecting....";
                        echo "<meta http-equiv='refresh' content='3; URL=../login.php'>";
                    } else {
                        echo "Fail to Create Account! Please Try Again....";
                        echo "<meta http-equiv='refresh' content='3; URL=../signup.html'>";                 
                    }
                }
            }

            $conn->close();
        ?>
    </main>
</body>
</html>