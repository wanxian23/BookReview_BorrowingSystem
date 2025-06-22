<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'OR email = '$username' OR phone = '$username'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();

$postCode = $_REQUEST['postCode'];

$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      WHERE post.postCode = '$postCode'";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_assoc();

$sqlGetThreads = "SELECT
                    thread.*
                  FROM Thread_Post threadPost
                  INNER JOIN Thread thread USING (threadID)
                  INNER JOIN Post_Review post USING (postCode)
                  WHERE threadPost.postCode = '$postCode'";
$resultGetThreads = $conn->query($sqlGetThreads);
$thread = $resultGetThreads->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<?php include("headDetails.html"); ?>

    <style>

        .form-container {
            background: white;
            border: 1px solid #aaa;
            border-radius: 10px;
            max-width: 700px;
            margin: 30px auto;
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
            background-color: white;
            color: #444;
            border: 2px solid #aaa;
        }

        .clear-btn:hover {
            background-color: #eee;
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
        }

        input[type="text"]#thread {
            width: 200px;
        }
        
        #threadButton {
            width: 100px;
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
            background-color:rgb(222, 222, 222);
            border: 2px solid rgb(190, 190, 190);
            word-wrap: break-word;
            padding: 5px;
            border-radius: 5px;
            transition: 0.3s;
        }

        div.threadAddedLabelWrapper label.removeThread {  
            background-color:rgb(243, 243, 243);    
        }

        div.threadAddedLabelWrapper label:hover {
            border: 2px solid gray;
        }
    </style>
</head>
<body>
    
<?php include("header.php"); ?>

    <main>

    <?php if ($post['frontCover_img'] != null) { ?>
        <section class="form-container">
            <h2><box-icon name='book-open'></box-icon> New Post</h2>
            <form id="newPostForm" method="POST" action="<?php echo htmlspecialchars("backendLogic/editPostHandling.php?postCode=$postCode"); ?>" enctype="multipart/form-data">
                <div class="toggle">
                    <span>Public Your Phone Number?</span>
                    <label class="switch">
                        <?php 
                            if ($post['statusPhone'] == "YES") {
                                echo '<input type="checkbox" name="public_phone_number" checked>';
                            } else {
                                echo '<input type="checkbox" name="public_phone_number">';
                            }
                        ?>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div style="grid-row: span 4;">
                    <label for="book_title">Book Title</label>
                    <input type="text" id="book_title" name="book_title" placeholder="Enter Title of the book" value="<?php echo $post['bookTitle']; ?>" required>

                    <label for="your_opinion" style="margin-top: 15px;">Your Opinion</label>
                    <textarea id="your_opinion" name="your_opinion" placeholder="Opinion about the book...." required><?php echo $post['ownerOpinion']; ?></textarea>

                    <div class="threadAddedWrapper">
                        <?php
                            if (!empty($thread)) {
                                echo '<label for="" style="margin-top: 15px;">Thread Added <br>(Thread Existed Cannot Be Removed)<br>(New Thread Can Click To Remove)</label>';
                                echo '<div class="threadAddedLabelWrapper">';
                                foreach ($thread as $theadData) {
                                    echo '<label>'.$theadData['thread'].'</label>';
                                }
                                echo '</div>';
                            }
                        ?>
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
                        <option value="Thriller">Thriller</option>
                        <option value="Romance">Romance</option>
                        <option value="Horror">Horror</option>
                        <option value="Sci-fi">Sci-fi</option>
                        <option value="Educational">Educational</option>
                        <option value="Crime">Crime</option>
                    </select>

                    <label for="author" style="margin-top: 15px;">Author</label>
                    <input type="text" id="author" name="author" placeholder="Enter Author Name" value="<?php echo $post['author']; ?>" required>

                    <label for="review" style="margin-top: 15px;">Review</label>
                    <input type="number" id="review" name="review" min="1" max="10" placeholder="1-10" value="<?php echo $post['ownerRating']; ?>" required>

                    <label for="thread" style="margin-top: 15px;">Thread</label>
                    <div class="threadWrapper">
                        <input type="text" id="thread" name="thread" placeholder="Add related thread">
                        <button id="threadButton" type="button">Add Thread</button>
                    </div>
                </div>

                <div id="borrow_details_section" style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                    <div class="file-upload-container">
                        <label for="front_cover">Front Cover (Optional To Change)</label>
                        <label for="front_cover" class="custom-file-upload">Upload File</label>
                        <input type="file" id="front_cover" name="front_cover">
                    </div>

                    <div class="file-upload-container">
                        <label for="back_cover">Back Cover (Optional To Change)</label>
                        <label for="back_cover" class="custom-file-upload">Upload File</label>
                        <input type="file" id="back_cover" name="back_cover">
                    </div>

                    <div style="grid-column: span 2;">
                        <label for="synopsis">Synopsis</label>
                        <textarea id="synopsis" name="synopsis" placeholder="Synopsis of the Book... (Optional)"><?php echo $post['synopsis']; ?></textarea>
                    </div>
                </div>

                <div class="buttons-wrapper">
                    <input type="reset" class="clear-btn" value="CLEAR">
                    <input type="submit" class="submit-btn" value="SUBMIT">
                </div>

            </form>
        </section>

        <?php } else { ?>
            <section class="form-container">
            <h2><box-icon name='book-open'></box-icon> New Post</h2>
            <form id="newPostForm" method="POST" action="<?php echo htmlspecialchars("backendLogic/editPostHandling.php?postCode=$postCode"); ?>" enctype="multipart/form-data">
                <div class="toggle">
                    <span>Public Your Phone Number?</span>
                    <label class="switch">
                        <?php 
                            if ($post['statusPhone'] == "YES") {
                                echo '<input type="checkbox" name="public_phone_number" checked>';
                            } else {
                                echo '<input type="checkbox" name="public_phone_number">';
                            }
                        ?>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div style="grid-row: span 4;">
                    <label for="book_title">Book Title</label>
                    <input type="text" id="book_title" name="book_title" placeholder="Enter Title of the book" value="<?php echo $post['bookTitle'] ?>" required>

                    <label for="your_opinion" style="margin-top: 15px;">Your Opinion</label>
                    <textarea id="your_opinion" name="your_opinion" placeholder="Opinion about the book...." required></textarea>

                    <div class="threadAddedWrapper">
                            <?php
                            if (!empty($thread)) {
                                echo '<label for="" style="margin-top: 15px;">Thread Added (Click to Remove)</label>';
                                echo '<div class="threadAddedLabelWrapper">';
                                foreach ($thread as $theadData) {
                                    echo '<label>'.$theadData['thread'].'</label>';
                                }
                                echo '</div>';
                            }
                            ?>
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
                        <option value="Thriller">Thriller</option>
                        <option value="Romance">Romance</option>
                        <option value="Horror">Horror</option>
                        <option value="Sci-fi">Sci-fi</option>
                        <option value="Educational">Educational</option>
                        <option value="Crime">Crime</option>
                    </select>

                    <label for="author" style="margin-top: 15px;">Author</label>
                    <input type="text" id="author" name="author" placeholder="Enter Author Name" required>

                    <label for="review" style="margin-top: 15px;">Review</label>
                    <input type="number" id="review" name="review" min="1" max="10" placeholder="1-10" required>

                    <label for="thread" style="margin-top: 15px;">Thread</label>
                    <div class="threadWrapper">
                        <input type="text" id="thread" name="thread" placeholder="Add related thread">
                        <button id="threadButton" type="button">Add Thread</button>
                    </div>
                </div>

                <div class="buttons-wrapper">
                    <input type="reset" class="clear-btn" value="CLEAR">
                    <input type="submit" class="submit-btn" value="SUBMIT">
                </div>

            </form>
        </section>       
        <?php } ?>
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
                
                let genreChoose = document.getElementById("genre");

                if (genreChoose.selectedIndex === 0) {
                    event.preventDefault(); // prevent form submission
                    window.alert("Please choose a valid genre!");
                    return;                   
                }
            });
        });
    </script>
</body>
</html>