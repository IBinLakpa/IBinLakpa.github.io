<link rel="stylesheet" href="css/bar.css">
<header>
    <div>
        <a href="home.php?page=1#" class="home-btn">Home</a>
    </div>
        
    <?php
        if(!isset($_SESSION['name'])){
            echo '<div>
                    <a href="login_form.php" class="home-btn">Log In / Sign up</a>
                </div>
            ';
        }
        else if(isset($_SESSION['name'])){
            echo '
                <div>
                    <a href="write.php" class="home-btn">Write</a>
                </div>
                <div class="dropdown">
                    <button class="dropbtn">Hi '.$_SESSION["name"].' ▼</button>
                    <div class="dropdown-content">
                        <a href="logout.php" class="btn">Logout</a>
                    </div>
                </div>
            ';
        }
    ?>
</header>
