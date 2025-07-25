<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
    exit();
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
            border: 1px solid var(--containerColor);
            color: var(--containerColor);
            box-shadow: var(--containerBoxShadow);
            border-radius: 10px;
            max-width: 700px;
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

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        form div, form label {
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

        .form-container input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="number"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 0.95rem;
            width: 100%;
        }

        .toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            grid-column: span 2; 
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

        .file-upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .file-upload-container input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            background-color: #e0e0e0;
            color: #333;
            font-weight: normal;
            width: 100%; /* Make button fill its column */
            text-align: center;
        }

        .custom-file-upload:hover {
            background-color: #d0d0d0;
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
            background-color: black;
            color: white;
        }

        .clear-btn:hover {
            background-color: #333;
        }

        .submit-btn {
            background-color: black;
            color: white;
        }

        .submit-btn:hover {
            background-color: #333;
        }

        div.threadWrapper {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-end; /* Align button with input */
            gap: 10px;
        }

        input[type="text"]#thread {
            flex-grow: 1; /* Allow thread input to take available space */
        }
        
        #threadButton {
            width: auto; /* Allow button to size according to content */
            padding: 8px 12px;
            font-weight: normal;
            border-radius: 5px;
            background-color: #e0e0e0; /* Match custom-file-upload style */
            color: #333;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        #threadButton:hover {
            background-color: #d0d0d0;
        }


        div.threadAddedWrapper {
            display: none;
            margin-top: 10px; /* Add some space above added threads */
        }

        div.threadAddedLabelWrapper {
            display: flex;
            flex-direction: row;  
            flex-wrap: wrap;    
            gap: 10px;  
            margin-top: 5px;
        }

        div.threadAddedLabelWrapper label {
            font-weight: normal;
            background-color: rgb(243, 243, 243);
            border: 2px solid rgb(190, 190, 190);
            word-wrap: break-word;
            padding: 5px 8px;
            border-radius: 5px;
            transition: 0.3s;
            cursor: pointer;
            color: black;
        }

        div.threadAddedLabelWrapper label:hover {
            border: 2px solid gray;
        }

        /* Adjustments for screenshot layout */
        .grid-item-span-2 {
            grid-column: span 2;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            form {
                grid-template-columns: 1fr;
            }
            .form-container h2 {
                margin-bottom: 10px;
            }
            .buttons-wrapper {
                flex-direction: column;
                gap: 10px;
            }
            #borrow_details_section {
                grid-template-columns: 1fr;
            }
            .toggle {
                grid-column: span 1; /* On small screens, allow toggle to be 1 column */
            }
            .custom-file-upload {
                width: auto; /* Reset width for smaller screens if needed */
            }
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<body>
    
<?php include("header.php"); ?>

    <main>
        <section class="form-container">
            <h2><box-icon name='book-solid' ></box-icon> Add Book to Catalogue</h2>
            <form id="newPostForm" method="POST" action="<?php echo htmlspecialchars("backendLogic/addBookHandling.php"); ?>" enctype="multipart/form-data">
                
                <div class="toggle">
                    <span>Available for Borrow?</span>
                    <label class="switch">
                        <input type="checkbox" id="available_for_borrow_checkbox" name="available_for_borrow">
                        <span class="slider round"></span>
                    </label>
                </div>
                
                <div>
                    <label for="book_title">Book Title</label>
                    <input type="text" id="book_title" name="book_title" placeholder="Enter Title of the book" required>
                </div>

                <div>
                    <label for="genre">Genre</label>
                    <select id="genre" name="genre">
                        <option value="">-- Choose a Genre --</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Action">Action</option>
                        <option value="Thriller">Thriller</option>
                        <option value="Romance">Romance</option>
                        <option value="Horror">Horror</option>
                        <option value="Sci-fi">Sci-fi</option>
                        <option value="Educational">Educational</option>
                        <option value="Crime">Crime</option>
                    </select>
                </div>

                <div class="grid-item-span-2">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" placeholder="Enter Author Name" required>
                </div>
                
                <div class="grid-item-span-2">
                    <label for="thread">Thread</label>
                    <div class="threadWrapper">
                        <input type="text" id="thread" placeholder="Add related thread">
                        <button id="threadButton" type="button">Add Thread</button>
                    </div>
                    <div class="threadAddedWrapper">
                        <label style="margin-top: 15px;">Thread Added (Click to Remove)</label>
                        <div class="threadAddedLabelWrapper">
                        </div>
                    </div>
                </div>

                <div id="cover_upload_section" style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                    <div class="file-upload-container">
                        <label for="front_cover">Front Cover</label>
                        <label for="front_cover" class="custom-file-upload">Upload File</label>
                        <input type="file" id="front_cover" name="front_cover" accept="image/*">
                    </div>

                    <div class="file-upload-container">
                        <label for="back_cover">Back Cover</label>
                        <label for="back_cover" class="custom-file-upload">Upload File</label>
                        <input type="file" id="back_cover" name="back_cover" accept="image/*">
                    </div>
                </div>

                <div class="grid-item-span-2">
                    <label for="synopsis">Synopsis</label>
                    <textarea id="synopsis" name="synopsis" placeholder="Synopsis of the Book... (Optional)"></textarea>
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
            function setupFileUpload(inputId) {
                const inputElement = document.getElementById(inputId);
                const customUploadLabel = inputElement.previousElementSibling;

                inputElement.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        customUploadLabel.textContent = e.target.files[0].name;
                    } else {
                        customUploadLabel.textContent = 'Upload File';
                    }
                });
            }

            setupFileUpload('front_cover');
            setupFileUpload('back_cover');

            const borrowCheckbox = $('#available_for_borrow_checkbox');
            const coverUploadSection = $('#cover_upload_section');
            const synopsisTextarea = $('#synopsis');

            // Initial state based on checkbox
            function toggleCoverUploadAndSynopsis() {
                if (borrowCheckbox.is(':checked')) {
                    coverUploadSection.show();
                    // Set required for covers when available for borrow is checked
                    $('#front_cover').prop('required', true);
                    $('#back_cover').prop('required', true);
                } else {
                    coverUploadSection.hide();
                    // Remove required for covers when not available for borrow
                    $('#front_cover').prop('required', false);
                    $('#back_cover').prop('required', false);
                    // Clear file inputs and reset labels
                    $('#front_cover').val('');
                    $('#back_cover').val('');
                    $('#front_cover').prev('label.custom-file-upload').text('Upload File');
                    $('#back_cover').prev('label.custom-file-upload').text('Upload File');
                }
            }

            toggleCoverUploadAndSynopsis(); // Set initial state on page load

            borrowCheckbox.on('change', toggleCoverUploadAndSynopsis);

            $("#threadButton").click(function (e) {
                e.preventDefault(); 

                let threadInput = $("#thread");
                let thread = threadInput.val().trim();

                if (thread === "") {
                    alert("Please enter a thread name.");
                    return; 
                }

                let duplicate = false;
                $(".threadAddedLabelWrapper label").each(function() {
                    if ($(this).text().toLowerCase() === thread.toLowerCase()) {
                        duplicate = true;
                        return false;
                    }
                });

                if (duplicate) {
                    alert("This thread has already been added.");
                    return;
                }

                $(".threadAddedWrapper").css("display", "block");

                let threadAddedContainer = $(".threadAddedLabelWrapper");

                let label = $("<label>").text(thread).addClass("removeThread");
                threadAddedContainer.append(label);

                let hiddenInput = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "threads[]")
                    .addClass("removeThread-hidden")
                    .val(thread);

                $("#newPostForm").append(hiddenInput);

                threadInput.val("");
            });

            $(document).on("click", ".removeThread", function () {
                const valueToRemove = $(this).text();

                $(this).remove();

                $(`input.removeThread-hidden[value="${valueToRemove}"]`).remove();

                if ($(".threadAddedLabelWrapper label").length === 0) {
                    $(".threadAddedWrapper").css("display", "none");
                }
            });

            $("#newPostForm").submit(function(event) {
                let genreChoose = document.getElementById("genre");

                if (genreChoose.selectedIndex === 0) {
                    event.preventDefault();
                    alert("Please choose a valid genre!");
                    return;          
                }

                if (borrowCheckbox.is(':checked')) {
                    const frontCoverInput = document.getElementById("front_cover");
                    const backCoverInput = document.getElementById("back_cover");

                    if (frontCoverInput.files.length === 0) {
                        event.preventDefault();
                        alert("Please upload the front cover file.");
                        return;
                    }

                    if (backCoverInput.files.length === 0) {
                        event.preventDefault();
                        alert("Please upload the back cover file.");
                        return;
                    }
                }
            });

            $(".clear-btn").on("click", function() {
                $("#newPostForm")[0].reset();
                borrowCheckbox.prop('checked', false);
                toggleCoverUploadAndSynopsis(); // Reset section visibility and required attributes
                $(".threadAddedLabelWrapper").empty();
                $(".removeThread-hidden").remove();
                $(".threadAddedWrapper").css("display", "none");
            });
        });
    </script>
</body>
</html>
<?php
if (isset($conn) && $conn) {
    $conn->close();
}
?>