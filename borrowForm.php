<!DOCTYPE html>
<html>
<head>
    <title>Borrow Request Form</title>
</head>
<body>

    <h2>Borrow Request Form</h2>

    <form action="backendLogic/borrowFormHandle.php" method="POST">
        <label for="name">Full Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="email">Email Address:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="address">Full Address:</label><br>
        <textarea id="address" name="address" rows="3" required></textarea><br><br>

        <label for="borrowDate">Preferred Borrow Date:</label><br>
        <input type="date" id="borrowDate" name="borrowDate" required><br><br>

        <label for="returnDate">Expected Return Date:</label><br>
        <input type="date" id="returnDate" name="returnDate" required><br><br>

        <label for="reason">Reason for Borrowing (optional):</label><br>
        <textarea id="reason" name="reason" rows="2"></textarea><br><br>

        <input type="submit" value="Submit Request">
    </form>

</body>
</html>
