<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];
$readerID = $_SESSION['readerID'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

    <?php include("headDetails.html"); ?>
    <title>BookSpare - Search Results</title>

    <style>
    
    :root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: #a9a1ee;
            --buttonFontColor: black;
            --buttonHoverColor: #d8d5ec;

            --postHeaderBgColor: rgb(220, 196, 238);
            --postBgColor: white;

            --bookBoxShadow: 1px 1px 10px 3px rgba(0, 0, 0, 0.225);

            --anchorColor: rgb(65, 116, 227);
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;

            --postHeaderBgColor: white;
            --postBgColor: white;

            --bookBoxShadow: 1px 1px 10px 3px rgba(0, 0, 0, 0.225);

            --anchorColor: rgb(65, 116, 227);
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(40, 39, 39);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;

            --postHeaderBgColor: rgb(1, 1, 1);
            --postBgColor: rgb(45, 45, 45);

            --bookBoxShadow: 1px 1px 10px 3px rgba(237, 237, 237, 0.225);

            --anchorColor: rgb(149, 178, 241);
        }

        main {
            display: flex;
            gap: 50px;
            margin: 0;
        }

        main section {
            display: flex;
            flex-direction: column;
            margin-left: 15%;
            width: 100%;
        }

        main form#asideSection {
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 100vh;
            width: 250px;
            background-color:rgb(212, 210, 229);
            box-shadow: 1px 1px 10px darkgray;
            position: fixed;
            padding: 30px 0;
        }

        main form#asideSection button {
            text-align: center;
            text-decoration: none;
            padding: 20px 50px;
            transition: 0.2s;
            color: black;
            border: none;
            background-color:rgb(212, 210, 229);
        }

        main form#asideSection button:hover {
            box-shadow: 1px 1px 10px rgb(157, 132, 188);
        }

        main form#asideSection button.active {
            font-weight: bold;
            background-color: rgb(197, 193, 230);
        } 

    .search-results-header {
        background: transparent;
        border-radius: 0;
        padding: 0 0 10px 0;
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 16px;
        color: #333;
        margin-top: 10px;
    }

    .my-posts-header {
        padding: 15px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: sticky;
        min-height: 50px;
        position: relative;
        border-bottom: 2px solid black;
    }
    
    .back-button {
        position: absolute;
        left: 20px;
        font-size: 1.3em;
        font-weight: bold;
        color: var(--containerColor);;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .my-posts-title {
        font-size: 24px;
        font-weight: bold;
        color: var(--containerColor);;
        text-align: center;
        flex-grow: 1;
        margin-right: 60px;
    }

    .my-posts-header::after {
        content: '';
        display: block;
        margin-top: 10px;
        margin-left: -20px;
        margin-right: -20px;
        padding: 0 20px;
    }


    .result-post{
        border-bottom: 2px solid black;
    }


    .results-container {
        color: var(--containerColor);
        border-radius: 15px;
        width: 100%;
        display: flex;
        justify-content: flex-start;
        gap: 40px;
        flex-wrap: wrap;
        padding: 50px 80px;
    }

    form.asideMainButtonContainer {
        color: var(--containerColor);
        width: 100%;
        display: flex;
        gap: 10px;
        padding: 30px 80px 0 80px;   
        background-color:rgb(228, 237, 238);  
        box-shadow: var(--bookBoxShadow);  
    }

    form.asideMainButtonContainer button {
            text-align: center;
            text-decoration: none;
            padding: 20px 10px;
            width: 140px;
            transition: 0.2s;
            color: black;
            border: none;
            background-color:rgb(228, 237, 238);  
    }

    form.asideMainButtonContainer button:hover {
            box-shadow: 1px 1px 10px rgb(157, 132, 188);
        }

    form.asideMainButtonContainer button.active {
            font-weight: bold;
            background-color: rgb(212, 225, 235);
        } 

    @media (max-width: 768px) {
        .results-grid {
            grid-template-columns: 1fr;
        }
    }

        div.post {
            margin: 0 0 25px 0;
            border: 2px solid var(--containerColor);
            border-radius: 15px;
            width: 22%;
            background-color: var(--postBgColor);
        }

        div.post.received {
            width: 48%;
            height: 450px;
        }


        div.post div.head {
            border-bottom: 2px solid;
            padding: 15px;
            background-color: var(--postHeaderBgColor);
            border-radius: 15px 15px 0 0;
        }

        div.post div.head div.postProfile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        div.post div.head div.postProfile img {
            display: inline-block;
            border-radius: 40px;
            height: 100%;
            width: 100%;    
        }

        div.post div.head div.postProfile a {
            display: inline-flex;
            text-decoration: none;
            border-radius: 40px;
            height: 40px;
            width: 40px;
            border: 4px solid var(--containerColor);
            background-color: #d8d5ec;
            align-items: center;
            justify-content: center;
            color: black;
        }

        div.post div.body {
            display: flex;
            flex-direction: column;
        }

        div.post.received div.body {
            flex-direction: row;
            font-size: 1.4em;
        }

        div.post div.body div.left {
            border-right: 2px solid;
            width: 70%;
        }

        div.post div.body div.right {
            padding: 20px 30px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-bottom: 2px solid;
        }

        div.post.received div.body div.right {
            width: 50%;
        }

        div.post.received div.body div.right:nth-child(2) {
            gap: 20px;
            border-left: 2px solid;
        }

        div.post div.body div.right img {
            width: 90%;
            height: 200px;
            box-shadow: var(--bookBoxShadow);
            cursor: pointer;
        }

        div.post.received div.body div.right:nth-child(2) img {
            width: 90px;
            height: 90px;
            border: 7px solid;
            border-radius: 50px;
        }

        div.post.received div.body div.right:nth-child(2) a {
            width: 90px;
            height: 90px;
            border: 7px solid black;
            border-radius: 50px;
            text-decoration: none;
            align-items: center;
            display: flex;
            justify-content: center;
            background-color: #d8d5ec;
            color: black;
        }
        
        div.post div.right h3 {
            font-size: 0.85em;
        }

        div.post div.right h4 {
            font-weight: normal;
            font-size: 0.75em;
        }

        div.post div.body div.left div.review {
            padding: 15px;
            border-bottom: 2px solid;
        }

        div.post div.body div.left div.review h3 {
            display: flex;
            justify-content: space-between;
        }

        div.post div.body div.left div.description {
            overflow-wrap: anywhere;
            padding: 15px;
        }

        div.post div.body div.left div.description p a {
            text-decoration: none;
            color: var(--linkColor);
        }

        div.post div.body div.left div.review section.postContainer article:nth-of-type(2) div.post div.bottom {
            padding: 10px;
        }

        div.post .bottom {
            padding: 15px;
            display: flex;
            gap: 10px;
            flex-direction: column;
            align-items: center;
        }

        div.post .statusButton {
            flex-direction: row;
            justify-content: space-around;
        }

        div.post .bottom h3 {
            font-size: 0.85em;
        }

        div.post .bottom h4 {
            font-weight: normal;
            font-size: 0.75em;
        }

        div.post .bottom a {
            padding: 5px 0;
            text-align: center;
            width: 80px;
            background-color:rgb(186, 180, 242);
            border-radius: 5px;
            transition: 0.2s;
            text-decoration: none;
            border: 2px solid;
            color: black;
        }

        div.post .bottom a:hover {
            background-color:rgb(206, 203, 234);
        }

        div.post div.right div.left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        div.post div.bottom input {
            width: 70%;
            font-size: 0.7em;
            border-radius: 5px;
            padding: 5px;
            border: 1px solid var(--postHeaderBgColor);
            transition: 0.3s;
        }

        div.post div.bottom input:active {
            border: 1px solid black;
        }
</style>

</head>

<body>
    <?php include("header.php"); ?>

    <main>

    <?php

        echo '<form id="asideSection" method="GET">';
        // echo '    <input type="hidden" name="postCode" value="' . $postCode . '">';
        $borrowRequestActive = (!isset($_GET['section']) || $_GET['section'] === 'borrowRequest') ? 'active' : '';
        $pendingApproveActive = (isset($_GET['section']) && $_GET['section'] === 'pendingApprove') ? 'active' : '';
        $actionNeededActive = (isset($_GET['section']) && $_GET['section'] === 'actionNeeded') ? 'active' : '';

        echo '<button type="submit" name="section" value="borrowRequest" class="' . $borrowRequestActive . '">Borrow Request Received</button>';
        echo '<button type="submit" name="section" value="pendingApprove" class="' . $pendingApproveActive . '">Request Pending Approval</button>';
        echo '<button type="submit" name="section" value="actionNeeded" class="' . $actionNeededActive . '">Action Needed</button>';

        echo '</form>';     
                
    ?>
        <section>

            <?php 

            if (isset($_GET['section'])) {

                if ($_GET['section'] === 'borrowRequest') {

                    echo '<form class="asideMainButtonContainer" method="GET">';
                    echo '<input type="hidden" name="section" value="borrowRequest">';

                    $receiveActive = (!isset($_GET['sectionAside']) || $_GET['sectionAside'] === 'receivedRequest') ? 'active' : '';
                    $approveBorrowActive = (isset($_GET['sectionAside']) && $_GET['sectionAside'] === 'approveBorrowRequest') ? 'active' : '';
                    $rejectBorrowActive = (isset($_GET['sectionAside']) && $_GET['sectionAside'] === 'rejectBorrowRequest') ? 'active' : '';
            
                    echo '<button type="submit" name="sectionAside" value="receivedRequest" class="' . $receiveActive . '">Received</button>';
                    echo '<button type="submit" name="sectionAside" value="approveBorrowRequest" class="' . $approveBorrowActive . '">Approved</button>';
                    echo '<button type="submit" name="sectionAside" value="rejectBorrowRequest" class="' . $rejectBorrowActive . '">Rejected</button>';
    
                    echo '</form>';

                    echo '<div class="results-container">';
                    
                    if (isset($_GET['sectionAside'])) {

                        if ($_GET['sectionAside'] === 'receivedRequest') {
                            include 'borrowDetailsSection/borrowRequestSection/receivedRequest.php';
                        } else if ($_GET['sectionAside'] === 'approveBorrowRequest') {
                            include 'borrowDetailsSection/borrowRequestSection/approvedBorrowRequest.php';
                        } else {
                            include 'borrowDetailsSection/borrowRequestSection/rejectBorrowRequest.php';
                        }

                    } else {
                        include 'borrowDetailsSection/borrowRequestSection/receivedRequest.php';
                    }

                    echo '</div>';

                } elseif ($_GET['section'] === 'pendingApprove') {

                    echo '<form class="asideMainButtonContainer" method="GET">';
                    echo '<input type="hidden" name="section" value="pendingApprove">';

                    $pendingRequestActive = (!isset($_GET['sectionAside']) || $_GET['sectionAside'] === 'pendingRequest') ? 'active' : '';
                    $approveRequestActive = (isset($_GET['sectionAside']) && $_GET['sectionAside'] === 'approveRequest') ? 'active' : '';
                    $rejectRequestActive = (isset($_GET['sectionAside']) && $_GET['sectionAside'] === 'rejectRequest') ? 'active' : '';
            
                    echo '<button type="submit" name="sectionAside" value="pendingRequest" class="' . $pendingRequestActive . '">Pending</button>';
                    echo '<button type="submit" name="sectionAside" value="approveRequest" class="' . $approveRequestActive . '">Approved</button>';
                    echo '<button type="submit" name="sectionAside" value="rejectRequest" class="' . $rejectRequestActive . '">Rejected</button>';
    
                    echo '</form>';

                    echo '<div class="results-container">';
                    
                    if (isset($_GET['sectionAside'])) {

                        if ($_GET['sectionAside'] === 'pendingRequest') {
                            include 'borrowDetailsSection/pendingApprovalSection/pendingRequest.php';
                        } else if ($_GET['sectionAside'] === 'approveRequest') {
                            include 'borrowDetailsSection/pendingApprovalSection/approvedRequest.php';
                        } else {
                            include 'borrowDetailsSection/pendingApprovalSection/rejectedRequest.php';
                        }

                    } else {
                        include 'borrowDetailsSection/pendingApprovalSection/pendingRequest.php';
                    }

                    echo '</div>';

                } else {

                    echo '<form class="asideMainButtonContainer" method="GET">';
                    echo '<input type="hidden" name="section" value="actionNeeded">';

                    $toCompleteActive = (!isset($_GET['sectionAside']) || $_GET['sectionAside'] === 'toComplete') ? 'active' : '';
                    $formReceivedActive = (isset($_GET['sectionAside']) && $_GET['sectionAside'] === 'formReceived') ? 'active' : '';
            
                    echo '<button type="submit" name="sectionAside" value="toComplete" class="' . $toCompleteActive . '">To Complete</button>';
                    echo '<button type="submit" name="sectionAside" value="formReceived" class="' . $formReceivedActive . '">Form Received</button>';
    
                    echo '</form>';

                    echo '<div class="results-container">';
                    
                    if (isset($_GET['sectionAside'])) {

                        if ($_GET['sectionAside'] === 'toComplete') {
                            include 'borrowDetailsSection/actionNeededSection/toComplete.php';
                        } else {
                            include('borrowDetailsSection/actionNeededSection/formReceived.php');
                        }

                    } else {
                        include 'borrowDetailsSection/actionNeededSection/toComplete.php';
                    }

                    echo '</div>';

                }
            } else {

                    echo '<form class="asideMainButtonContainer" method="GET">';
                    echo '<input type="hidden" name="section" value="borrowRequest">';

                    $receiveActive = (!isset($_GET['sectionAside']) || $_GET['sectionAside'] === 'receivedRequest') ? 'active' : '';
                    $approveBorrowActive = (isset($_GET['sectionAside']) && $_GET['sectionAside'] === 'approveBorrowRequest') ? 'active' : '';
                    $rejectBorrowActive = (isset($_GET['sectionAside']) && $_GET['sectionAside'] === 'rejectBorrowRequest') ? 'active' : '';
            
                    echo '<button type="submit" name="sectionAside" value="receivedRequest" class="' . $receiveActive . '">Received</button>';
                    echo '<button type="submit" name="sectionAside" value="approveBorrowRequest" class="' . $approveBorrowActive . '">Approved</button>';
                    echo '<button type="submit" name="sectionAside" value="rejectBorrowRequest" class="' . $rejectBorrowActive . '">Rejected</button>';
    
                    echo '</form>';

                    echo '<div class="results-container">';
                    
                    if (isset($_GET['sectionAside'])) {

                        if ($_GET['sectionAside'] === 'receivedRequest') {
                            include 'borrowDetailsSection/borrowRequestSection/receivedRequest.php';
                        } else if ($_GET['sectionAside'] === 'approveBorrowRequest') {
                            include 'borrowDetailsSection/borrowRequestSection/approvedBorrowRequest.php';
                        } else {
                            include 'borrowDetailsSection/borrowRequestSection/rejectBorrowRequest.php';
                        }

                    } else {
                        include 'borrowDetailsSection/borrowRequestSection/receivedRequest.php';
                    }

                    echo '</div>';

            }

            ?>

            <?php include("footer.html"); ?>
        </section>
    </main>

    <script>
        $(document).ready(function() {
            
            $(".postCode").click(function () {
                let postCode = this.getAttribute("data-postCode");
                window.location.href = "bookDetail.php?postCode=" + postCode;
            })

            $(".borrowerProfile").click(function() {
                let postCode = this.getAttribute("data-postCode");
                let readerID = this.getAttribute("data-readerID");
                window.location.href = "viewGeneralBorrowDetailsUser.php?postCode=" + postCode + "&readerID=" + readerID;               
            });

            $(".replyForm").click(function() {
                event.stopPropagation(); // Prevent triggering parent click
                let postCode = this.getAttribute("data-postCode");
                let readerID = this.getAttribute("data-readerID");
                window.location.href = "borrowForm.php?postCode=" + postCode + "&borrowerReaderID=" + readerID;        
            });

            $(".viewReplyForm").click(function() {
                event.stopPropagation(); // Prevent triggering parent click
                let postCode = this.getAttribute("data-postCode");
                let readerID = this.getAttribute("data-readerID");
                window.location.href = "viewBorrowForm.php?postCode=" + postCode + "&borrowerReaderID=" + readerID;        
            });
        })
    </script>
</body>

</html>