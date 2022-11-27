<?php
session_destroy();
session_start();

// initializing variables
$username = "";
$lastname = "";
$firstname = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'webprog2_cukraszda');
if(!$db){
  die("Error: Failed to connect to database!");
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
  $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Felhasználónév kötelező!"); }
  if (empty($lastname)) { array_push($errors, "Vezetéknév kötelező!"); }
  if (empty($firstname)) { array_push($errors, "Keresztnév kötelező!"); }
  if (empty($email)) { array_push($errors, "Email kötelező!"); }
  if (empty($password_1)) { array_push($errors, "Jelszó kötelező!"); }
  if ($password_1 != $password_2) {
	array_push($errors, "A két jelszó nem egyezik.");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Felhasználónév már létezik!");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Email már létezik!");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, lastname, firstname, email, password) 
  			  VALUES('$username', '$lastname', '$firstname', '$email', '$password')";
  	mysqli_query($db, $query);
  	/*$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";*/
  	header('location: index.php?page=login');
  }
}

// ... 

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Felhasználónév kötelező!");
    }
    if (empty($password)) {
        array_push($errors, "Jelszó kötelező!");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['success'] = "Sikeres bejelentkezés!";
          header('location: index.php');
        }else {
            array_push($errors, "Rossz felhasználónév vagy jelszó!");
        }
    }
  }


  
  ?>