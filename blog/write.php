<?php
   @include 'config.php';
   session_start();
   if(!isset($_SESSION['name'])){
      header('location:login_form.php');
   }
   if(isset($_POST['submit'])){
      $title=mysqli_real_escape_string($conn, $_POST['title']);
      $content=mysqli_real_escape_string($conn, $_POST['content']);
      // Get the highest current primary key value
      $select = "SELECT MAX(id) AS max_id FROM blog";
      $result = mysqli_query($conn, $select);
      $row = mysqli_fetch_assoc($result);
      $max_id = $row['max_id'];
      // Generate a new primary key value
      $new_id = $max_id + 1;
      $timestamp = time();  // Get the current Unix timestamp
      $formatted_time = date("Y-m-d H:i:s", $timestamp);
      $insert = "INSERT INTO blog(id, blog_title, blog_content, user_id,timestamp) VALUES('$new_id', '$title', '$content', '{$_SESSION['user_id']}','$formatted_time')";
      mysqli_query($conn, $insert);
      header('location:home.php');
   };
   
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Write</title>
      <!-- custom css file link  -->
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <?php
         @include 'bar.php';
      ?>
      <div class="form-container">
         <form action="" method="post">
            <h3>Write</h3>
            <?php
               if(isset($error)){
                  foreach($error as $error){
                     echo '<span class="error-msg">'.$error.'</span>';
                  };
               };
            ?>
            <input type="text" name="title" required placeholder="Title">
            <textarea name="content" id="blog_content" required placeholder="Write something"></textarea>
            <input type="submit" name="submit" value="Submit" class="form-btn">
         </form>
      </div>
   </body>
</html>
