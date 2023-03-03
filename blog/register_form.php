<?php
   @include 'config.php';
   if(isset($_POST['submit'])){
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $pass = md5($_POST['password']);
      $cpass = md5($_POST['cpassword']);
      // Get the highest current primary key value
      $select = "SELECT MAX(id) AS max_id FROM users";
      $result = mysqli_query($conn, $select);
      $row = mysqli_fetch_assoc($result);
      $max_id = $row['max_id'];
      // Generate a new primary key value
      $new_id = $max_id + 1;
      $select = "SELECT * FROM users WHERE email = '$email' || username='$username'";
      $result = mysqli_query($conn, $select);
      if(mysqli_num_rows($result) > 0){
         $error[] = 'user already exist!';
      }else{
         if($pass != $cpass){
            $error[] = 'password not matched!';
         }else{
            $insert = "INSERT INTO users(id, name, email, username, password) VALUES('$new_id','$name','$email','$username','$pass')";
            mysqli_query($conn, $insert);
            header('location:login_form.php');
         }
      }
   };
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Sign Up</title>
      <!-- custom css file link  -->
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <?php
         @include 'bar.php';
      ?>
      <div class="form-container">
         <form action="" method="post">
            <h3>register now</h3>
            <?php
            if(isset($error)){
               foreach($error as $error){
                  echo '<span class="error-msg">'.$error.'</span>';
               };
            };
            ?>
            <input type="text" name="name" required placeholder="enter your name">
            <input type="text" name="username" required placeholder="enter your username">
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="password" name="cpassword" required placeholder="confirm your password">
            <input type="submit" name="submit" value="register now" class="form-btn">
            <p>already have an account? <a href="login_form.php">Log In</a></p>
         </form>
      </div>
   </body>
</html>
