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
<body background="bg.jpeg">
    <nav id="navbar">
        <div id="logo">
            <img src="logo2.jpg" alt="MyOnlinebooks.com">
        </div>
        <ul>
            <li class="item"><a href="#home">Home</a></li>
            <li class="item"><a href="category.html">Category</a></li>
            <li class="itemicon"><a href="about.html">About</a></li>
            <li class="item"><a href="login.php">LOG IN</a></li>
            <li class="item"><a href="contact.html">Contact Us</a></li>
        </ul>
    </nav>
    <div class="rightNav">

        <input type="text" name="search" id="search">

        <button class="btn btn-sm">Browse The Books You need</button>


        <script src="script.js"></script>


    <section id="home">

        <h1 class="h-primary">Welcome to your BookClub</h1>
        <hr>
        <hr>
        <p> “A book is not only a friend, it makes friends for you. When you have possessed a book with mind and spirit, you are enriched.. But when you pass it on you are enriched threefold.”</p>
            <p> — Henry Miller The Books In My Life (1969)
            </p>
            <p>BookClub is the act of releasing your books "into the wild" for a stranger to find, or via "controlled release" to another BookClub member, and tracking where they go via journal entries from around the world..</p>
            
          <a href="register.php">Register Now</a>
    </section>
    <section class="services-container">
        <h1 class="h-primary center">Our Assistance</h1>
        <hr>
        <hr>
    </section>
    <div id="services">
        <div class="box">
            <img src="exchanging.jpg" alt="exchange of books">
            <h2 class="h-secondary center">Book Exchanging Platform</h2>
            <p class="center">Now you can exchange your books </p>
                <p class="center"> and read new books also save your money too...</p>        </div>
        <div class="box">
            <img src="buySell.jpg" alt="Buy or Sell your books">
            <h2 class="h-secondary center">Buy or Sell your books</h2>
            <p class="center">you can even buy or sell your books here.</p>
        </div>
        <div class="box">
            <img src="renting.jpg" alt="Get books on Rent">
            <h2 class="h-secondary center">Get books on Rent</h2>
            <p class="center">Do you want to earn money?? You can rent your books</p>
        </div>
    </div>
    
</body>
</html>