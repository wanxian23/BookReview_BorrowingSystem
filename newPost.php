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
<html lang="en">
<head>

<?php include("headDetails.html"); ?>

    <style>

        :root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --buttonColor: #a9a1ee;
            --buttonFontColor: black;
            --buttonHoverColor: #d8d5ec;

            --postHeaderBgColor: rgb(220, 196, 238);
            --postBgColor: white;

            --commentButtonColor: rgb(161, 178, 238);
            --commentButtonFontColor: black;
            --commentButtonFontColorActive: black;
            --commentButtonHoverColor: rgb(205, 212, 234);

            --linkColor: blue;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;

            --postHeaderBgColor: white;
            --postBgColor: white;

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: rgb(134, 155, 195);
            --commentButtonHoverColor: rgb(91, 87, 87);

            --linkColor: blue;
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(34, 34, 34);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
            --contentBgColor: rgb(53, 53, 53);
            --borderColor: white;

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;

            
            --postHeaderBgColor: rgb(1, 1, 1);
            --postBgColor: rgb(45, 45, 45);

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: white;
            --commentButtonHoverColor: rgb(91, 87, 87);

            --linkColor: rgb(119, 167, 190);
        }

        .form-container {
            background: var(--containerBgColor);
            border: 1px solid var(--containercolor);
            color: var(--containerColor);
            box-shadow: var(--containerBoxShadow);
            border-radius: 10px;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .form-container h2 {
            display: flex;
            align-items: center;
            font-size: 1.2rem;
            margin-bottom: 15px;
            grid-column: 1 / -1;
        }

        form#newPostForm {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        form#newPostForm > div:not(.buttons-wrapper):not(.toggle):not(#borrow_details_section):not(.threadWrapper):not(.threadAddedWrapper):not(.threadAddedLabelWrapper) {
            display: flex;
            flex-direction: column;
            font-weight: bold;
            gap: 5px;
        }

        input[type="text"], input[type="file"], select, textarea {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 0.95rem;
        }

        textarea {
            resize: vertical;
            min-height: 115px;
        }

        input[type="number"] {
          padding: 8px;
          border-radius: 5px;
          border: 1px solid #ccc;
          font-size: 0.95rem;
          width: 100%;
        }

        .file-upload-container {
            display: flex;
            flex-direction: column; /* force row */
            align-items: center;
            gap: 10px;
        }

        .file-upload-container input[type="file"] {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            background-color: #e0e0e0;
            color: #333;
            font-weight: normal;
        }

        .buttons-wrapper {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 20px;
            grid-column: span 2;
            margin-top: 30px;
            flex-wrap: nowrap;
        }

        .toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 65px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            background-color: #ccc;
            border-radius: 34px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #333;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .clear-btn,
        .submit-btn {
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .clear-btn {
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
            border: 2px solid #aaa;
        }

        .clear-btn:hover {
            background-color: var(--buttonHoverColor);
        }

        .submit-btn {
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
        }

        .submit-btn:hover {
            background-color: var(--buttonHoverColor);
        }

        div.threadWrapper {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        input[type="text"]#thread {
            width: 200px;
        }
        
        #threadButton {
            width: 90px;
        }

        div.threadAddedWrapper {
            display: none;
            margin-top: 20px;
        }

        div.threadAddedLabelWrapper {
            display: flex;
            flex-direction: row;   
            flex-wrap: wrap;    
            gap: 10px;   
        }

        div.threadAddedLabelWrapper label {
            font-weight: normal;
            background-color:rgb(243, 243, 243);
            border: 2px solid rgb(190, 190, 190);
            word-wrap: break-word;
            padding: 5px;
            border-radius: 5px;
            transition: 0.3s;
        }

        div.threadAddedLabelWrapper label:hover {
            border: 2px solid gray;
        }
    </style>
</head>
<body>
    
<?php include("header.php"); ?>

    <main>
        <section class="form-container">
            <h2><box-icon name='book-open'></box-icon> New Post</h2>
            <form id="newPostForm" method="POST" action="<?php echo htmlspecialchars("backendLogic/newPostHandling.php"); ?>" enctype="multipart/form-data">
                <div class="toggle">
                    <span>Available For Borrow?</span>
                    <label class="switch">
                        <input type="checkbox" id="available_for_borrow_checkbox" name="available_for_borrow" value="YES">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div style="grid-row: span 4;">
                    <label for="book_title">Book Title</label>
                    <input type="text" id="book_title" name="book_title" placeholder="Enter Title of the book" required>

                    <label for="synopsis" style="margin-top: 15px;">Synopsis</label>
                    <textarea id="synopsis" name="synopsis" placeholder="Synopsis of the book.." required></textarea>

                    <div id="borrow_details_section" style="margin-top: 15px;">
                    <div class="file-upload-container">
                        <label for="front_cover">Front Cover</label>
                        <input type="file" id="front_cover" name="front_cover">
                    </div>
                </div>
            </div>

                <div>
                    <label for="genre">Genre</label>
                    <select id="genre" name="genre">
                        <option value="">-- Choose a Genre --</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Action">Action</option>
                        <option value="Thriller">Drama</option>
                        <option value="Romance">Romance</option>
                        <option value="Horror">Horror</option>
                        <option value="Sci-fi">Sci-fi</option>
                        <option value="Educational">Educational</option>
                        <option value="Crime">Crime</option>
                    </select>

                    <label for="author" style="margin-top: 15px;">Author</label>
                    <input type="text" id="author" name="author" placeholder="Enter Author Name" required>
                   
                    <label for="thread" style="margin-top: 15px;">Thread</label>
                    <div class="threadWrapper">
                        <input type="text" id="thread" name="thread" placeholder="Add related thread">
                        <button id="threadButton" type="button">Add Thread</button>
                    </div>
                    
                    <div class="threadAddedWrapper">
                        <label for="" style="margin-top: 15px;">Thread Added (Click to Remove)</label>
                        <div class="threadAddedLabelWrapper">

                        </div>
                    </div>
                </div>

                </div>

                <div class="buttons-wrapper">
                    <input type="reset" class="clear-btn" value="CLEAR">
                    <input type="submit" class="submit-btn" value="SUBMIT">
                </div>

            </form>
        </section>
    </main>
    <?php include("footer.html"); ?>

    <script>
        $(document).ready(function() {

            // Let user add thread
            $("#threadButton").click(function (e) {
                e.preventDefault(); 

                let thread = document.getElementById("thread").value.trim();

                if (thread === "") return; // Prevent adding empty thread

                $(".threadAddedWrapper").css("display", "block");

                let threadAdded = document.querySelector(".threadAddedLabelWrapper");

                let label = document.createElement("label");
                label.textContent = thread; 
                label.setAttribute("class","removeThread");

                threadAdded.appendChild(label);

                let hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "removeThread[]";
                hiddenInput.className = "removeThread";
                hiddenInput.value = thread;
                hiddenInput.value = thread; // thread is the value user added

                document.getElementById("newPostForm").appendChild(hiddenInput);

                document.getElementById("thread").value = "";
            });

            // If user wanna remove thread (Dynamic method cuz thread added after document load)
            // Remove both on click (Label and hidden input)
            $(document).on("click", ".removeThread", function () {
                let valueToRemove = $(this).text(); // get the thread text

                $(".removeThread").each(function () {
                    if (
                        $(this).is("input") && $(this).val() === valueToRemove || // hidden input
                        $(this).is("label") && $(this).text() === valueToRemove    // label
                    ) {
                        $(this).remove();
                    }
                });
            });

            $("#newPostForm").submit(function(event) {
                
                let frontCover = document.getElementById("front_cover");
                let genreChoose = document.getElementById("genre");

                if (genreChoose.selectedIndex === 0) {
                    event.preventDefault(); // prevent form submission
                    window.alert("Please choose a valid genre!");
                    return;                   
                }

                if (frontCover.files.length === 0) {
                    event.preventDefault(); // prevent form submission
                    window.alert("Please upload the front cover file.");
                    return;
                }
            });
        });
    </script>
</body>
</html>