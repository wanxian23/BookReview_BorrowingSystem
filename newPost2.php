<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];

// User Information
$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();

// Book Information
if (isset($_POST['bookSearch'])) {
  require("database/database.php");
  $keyword = $conn->real_escape_string($_POST['bookSearch']);

  $sqlBook = "SELECT bookTitle FROM book_record WHERE bookTitle LIKE '%$keyword%'";
  $resultSqlBook = $conn->query($sqlBook);

  if ($resultSqlBook->num_rows > 0) {
      while ($row = $resultSqlBook->fetch_assoc()) {
          echo "<article>" . htmlspecialchars($row['bookTitle']) . "</article>";
      }
  } else {
    echo "<article>No Matches Book</article>";
  }

  exit(); // 👈 Prevent the rest of the HTML from rendering
}

// Book Information
if (isset($_POST['threadSearch'])) {
  require("database/database.php");
  $keyword = $conn->real_escape_string($_POST['threadSearch']);

  $sqlThread = "SELECT thread FROM thread WHERE thread LIKE '%$keyword%'";
  $resultSqlThread = $conn->query($sqlThread);

  if ($resultSqlThread->num_rows > 0) {
      while ($row = $resultSqlThread->fetch_assoc()) {
          echo "<article>" . htmlspecialchars($row['thread']) . "</article>";
      }
  } else {
    echo "<article>No Matches Book</article>";
  }

  exit(); // 👈 Prevent the rest of the HTML from rendering
}

?>
<!DOCTYPE html>
<html lang="en">

<!-- head -->

<head>

  <?php include("headDetails.html"); ?>

  <title>New Post</title>

  <!-- style -->
  <style>
    body {
            background-color: #fdf4cc;
            color: #333;
            font-family: Arial, sans-serif;
        }

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

        form div, label {
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
            min-height: 80px;
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

        footer {
            background-color: #aaa;
            color: white;
            padding: 20px;
        }

        footer h1 {
            margin: 10px 0;
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

    div.bookSearch, div.threadSearch {
      border: 1px solid lightgray;
      background-color: white;
      width: 558px;
      margin: 8px 0 0 0;
      padding: 10px 15px;
      border-radius: 6px;
      position: absolute;
      display: none;
    }
    
    div.scroll {
      height: 150px;
      overflow-y: scroll;
    }

    div.bookSearch article, div.threadSearch article {
      background-color:rgb(246, 246, 246);
      padding: 10px 15px;
      margin: 5px 0;
    }
  </style>
</head>

<!-- body -->

<body>

  <?php include("header.php"); ?>

    <main>
      <!-- new post form -->
      <section class="form-container">
        <h2>📖 New Post</h2>

        <form>
          <!-- Toggle switches -->
          <label>
            Available for Borrow?
            <input type="checkbox" />
          </label>
          <label>
            Public your Phone Number?
            <input type="checkbox" />
          </label>

          <!-- book info -->

          <!-- title -->
          <div class="bookTitle">
            <label>Book Title</label>
            <input type="text" placeholder="Enter Title of the book" id="bookTitleInput" />
            <div class="bookSearch">
              <div class="scroll">
                <!-- Book Search -->
              </div>
            </div>
          </div>

          <!-- opinion -->
          <div>
            <label>Your Opinion</label>
            <textarea placeholder="Opinion about the book..."></textarea>
          </div>

          <!-- genre (banyak choices) -->
          <div>
            <label>Genre</label>
            <select name="genre">
              <option>-- Choose a Genre --</option>
              <option value="Romance">Romance</option>
              <option value="Horror">Horror</option>
              <option value="Fantasy">Fantasy</option>
              <option value="SCI-FI">SCI-FI</option>
              <option value="Thriller">Thriller</option>
              <option value="Comedy">Comedy</option>
              <option value="Mystery">Mystery</option>
              <option value="Action">Action</option>
              <option value="Crime">Crime</option>
              <option value="Educational">Educational</option>
            </select>
          </div>

          <!-- author -->
          <div>
            <label>Author</label>
            <input type="text" placeholder="Enter Author Name" />
          </div>

          <!-- thread -->
          <div>
            <label>Thread</label>
            <input type="text" placeholder="Add related thread" id="threadInput"/>
            <div class="threadSearch">
              <div class="scroll">
                <!-- Thread Search -->
              </div>
            </div>
          </div>

          <!-- rating (numbers je)(check balik) -->
          <div>
            <label>Review</label>
            <input type="number" min="1" max="10" value="1"/>
          </div>

          <!-- nak upload file (depan and back cover) -->
          <div>
            <label>Front Cover</label>
            <input type="file" />
          </div>

          <div>
            <label>Back Cover</label>
            <input type="file" />
          </div>

          <div>
            <label>Synopsis</label>
            <textarea placeholder="Synopsis of the Book... [Optional]"></textarea>
          </div>

          <!-- button reset n submit -->
          <div>
            <button type="reset">CLEAR</button>
            <button type="submit" name="submit">SUBMIT</button>
          </div>
        </form>
      </section>
    </main>

    <!-- footer -->
    <footer>
      <h1>Our Social Media</h1>
      <a href="https://www.instagram.com/bookspare_?igsh=NDJmMjl2aGtxdWQ0" target="_blank"></a>
      <p>Copyright &copy; 2025 BookSpare. All right reserved</p>
    </footer>

    <script>
  $(document).ready(function () {
    $("#bookTitleInput").on("input", function () {
      let keyword = $("#bookTitleInput").val().trim(); // Trim whitespace

      if (keyword === "") {
        $(".bookSearch").hide();
        $(".bookSearch .scroll").empty();
        return;
      }

      $.ajax({
        url: "newPost.php",
        method: "POST",
        data: { bookSearch: keyword },
        success: function (data) {
          // Fill the scroll area only
          $(".bookSearch .scroll").html(data);
        
          // Check if there's a valid result
          if (data.includes("No Matches Book")) {
            $(".bookSearch").hide();
          } else {
            $(".bookSearch").show();
          }
        }
      });
    });

    $("#threadInput").on("input", function () {
      let keyword = $("#threadInput").val().trim(); // Trim whitespace

      if (keyword === "") {
        $(".threadSearch").hide();
        $(".threadSearch .scroll").empty();
        return;
      }

      $.ajax({
        url: "newPost.php",
        method: "POST",
        data: { threadSearch: keyword },
        success: function (data) {
          // Fill the scroll area only
          $(".threadSearch .scroll").html(data);
        
          // Check if there's a valid result
          if (data.includes("No Matches Book")) {
            $(".threadSearch").hide();
          } else {
            $(".threadSearch").show();
          }
        }
      });
    });
  });
</script>
</body>

</html>