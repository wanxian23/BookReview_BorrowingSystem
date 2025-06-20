<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New Post - BookSpare</title>
  <link rel="stylesheet" href="style.css">
</head>


<body>
    <div class="container">
    <h2>New Book Post</h2>

    <!-- Success message (if using $_SESSION) -->
    <?php if (isset($_SESSION['message'])): ?>
      <div class="message">
        <?php
          echo $_SESSION['message'];
          unset($_SESSION['message']);
        ?>
      </div>
    <?php endif; ?>

    <form action="submit.php" method="POST" enctype="multipart/form-data">
      
      <!-- Book Title -->
      <label for="title">Book Title</label>
      <input type="text" id="title" name="title" required>

      <!-- Opinion -->
      <label for="opinion">Your Opinion</label>
      <textarea id="opinion" name="opinion" rows="4" required></textarea>

      <!-- Genre -->
      <label for="genre">Genre</label>
      <select id="genre" name="genre" required>
        <option value="" disabled selected>Select a genre</option>
        <option value="Romance">Romance</option>
        <option value="Fantasy">Fantasy</option>
        <option value="Thriller">Thriller</option>
        <option value="Non-fiction">Non-fiction</option>
        <!-- Add more genres if needed -->
      </select>

      <!-- Author -->
      <label for="author">Author</label>
      <input type="text" id="author" name="author" required>

      <!-- Thread -->
      <label for="thread">Thread</label>
      <input type="text" id="thread" name="thread">

      <!-- Review Rating -->
      <label for="review">Review Rating</label>
      <select id="review" name="review" required>
        <option value="" disabled selected>Rate this book</option>
        <option value="1">1 - Poor</option>
        <option value="2">2 - Fair</option>
        <option value="3">3 - Good</option>
        <option value="4">4 - Very Good</option>
        <option value="5">5 - Excellent</option>
      </select>

      <!-- Synopsis -->
      <label for="synopsis">Synopsis</label>
      <textarea id="synopsis" name="synopsis" rows="4"></textarea>

      <!-- Upload Front Cover -->
      <label for="front_cover">Front Book Cover</label>
      <input type="file" id="front_cover" name="front_cover" accept="image/*" required>

      <!-- Upload Back Cover -->
      <label for="back_cover">Back Book Cover</label>
      <input type="file" id="back_cover" name="back_cover" accept="image/*">

      <!-- Available for Borrow Switch -->
      <label>
        <input type="checkbox" name="borrow_available" value="1">
        Available for Borrow
      </label>

      <!-- Show Phone Number Switch -->
      <label>
        <input type="checkbox" name="show_phone" value="1">
        Show My Phone Number
      </label>

      <!-- Submit & Clear Buttons -->
      <div class="form-buttons">
        <button type="submit">Submit</button>
        <button type="reset">Clear</button>
      </div>

    </form>
  </div>

</body>
</html>