<?php
   @include 'config.php';
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Home</title>
      <!-- custom css file link  -->
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
   <?php
      @include 'bar.php';
   ?>
      <div class="container">
         <div class="content">
            <?php

               // Define how many items to show per page
               $itemsPerPage = 5;

               // Get the current page number from the query string, or default to page 1
               $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

               // Calculate the offset based on the current page number and the number of items per page
               $offset = ($page - 1) * $itemsPerPage;

               // Retrieve a limited number of rows based on the offset and the number of items per page
               $sql = "SELECT id, blog_title, blog_content, user_id, timestamp FROM blog ORDER BY id DESC LIMIT $itemsPerPage OFFSET $offset";

               // Execute the query and get the result
               $result = $conn->query($sql);

               // Check if there are any rows returned
               if ($result->num_rows > 0) {
               // Loop through each row in the result set
                  while ($row = $result->fetch_assoc()) {
                     // Access the data from the current row
                     $id=$row["id"];
                     $topic = $row["blog_title"];
                     $content = $row["blog_content"];
                     $user_id = $row["user_id"];
                     $timestamp = $row["timestamp"];
                     $select = "SELECT username FROM users WHERE id = $user_id";
                     $result2 = mysqli_query($conn, $select);
                     if (mysqli_num_rows($result2) > 0) {
                        $row2 = mysqli_fetch_assoc($result2);
                        $by = $row2['username'];
                     } else {
                        $by = "Unknown";
                     }
                     $maxWidth = 600;
                     // Wrap the content to the maximum width and replace line breaks with <br> tags
                     $content = str_replace("\n", "<br>", wordwrap($content, $maxWidth, "\n"));
                     echo "<section>
                        <h3 id=#$id><a href='post.php?post=$id'>$topic</a></h3>
                        <span>-By $by</span>
                        <div class='blog-content'>$content</div>
                        <span>$timestamp<br>#$id</span>
                     </section>";
                  }

                  // Add pagination links if there are more than one page
                  $sql = "SELECT COUNT(*) as count FROM blog";
                  $result = $conn->query($sql);
                  $row = $result->fetch_assoc();
                  $totalItems = $row['count'];
                  $totalPages = ceil($totalItems / $itemsPerPage);

                  if ($totalPages > 1) {
                     echo "<div class='pagination'>";
                     for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $page) {
                           echo "<a href='#' class='current'>$i</a>";
                        } else {
                           echo "<a href='home.php?page=$i#'>$i</a>";
                        }
                     }
                     echo "</div>";
                  }

               } else {
                  echo "0 results";
               }
            ?>
         </div>
      </div>
   </body>
</html>
