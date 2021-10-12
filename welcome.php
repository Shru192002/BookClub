<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Book Exchange System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tamma+2:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">
</head>
<body >
    <nav id="navbar">
        <div id="logo">
            <img src="logo2.jpg" alt="MyOnlinebooks.com">
        </div>
        <ul>
            <li class="item"><a href="#home">Home</a></li>
            <li class="item"><a href="#browse-container">Browse</a></li>
            <li class="itemicon"><a href="#about-section">About</a></li>
            <li class="item"><a href="#join">Join</a></li>
            <li class="item"><a href="login.php">LOG IN</a></li>
            <li class="item"><a href="#contact">Contact Us</a></li>
        </ul>
    </nav>
    <section id="home">
        <h1 class="h-primary">Welcome to your BookClub</h1>
          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eaque, facilis.</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, fuga! Mollitia eaque corrupti at ratione adipisci ea minima incidunt explicabo!</p>
          <a href="register.php">Register Now</a>
    </section>
    <section class="services-container">
        <h1 class="h-primary center">Our Assistance</h1>
    </section>
    <div id="services">
        <div class="box">
            <img src="exchanging.jpg" alt="exchange of books">
            <h2 class="h-secondary center">Book Exchanging Platform</h2>
            <p class="center">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laboriosam labore vero placeat voluptas aspernatur eaque quibusdam voluptatem quos iure repellendus.</p>
        </div>
        <div class="box">
            <img src="buySell.jpg" alt="Buy or Sell your books">
            <h2 class="h-secondary center">Buy or Sell your books</h2>
            <p class="center">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laboriosam labore vero placeat voluptas aspernatur eaque quibusdam voluptatem quos iure repellendus.</p>
        </div>
        <div class="box">
            <img src="renting.jpg" alt="Get books on Rent">
            <h2 class="h-secondary center">Get books on Rent</h2>
            <p class="center">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laboriosam labore vero placeat voluptas aspernatur eaque quibusdam voluptatem quos iure repellendus.</p>
        </div>
    </div>
    
</body>
</html>