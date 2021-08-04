<?php
  session_start();

  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
  }
?>

<?php
  $username = "";
  $password = "";
  $error = "";
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
      $error = "Please enter username.";
    } else{
      $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $error = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    $sql = "SELECT `Username`, `Password`, `usertype` FROM Users WHERE Username = ? AND `Password` = ?;";
    $conn = new mysqli('localhost','root','Aptamatrix1@','AptaMatrix'); // we need to change this to be a different login other than root...
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    if($stmt->execute()){
      $result = $stmt->get_result();
      if($result->num_rows == 1){
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $row['Username']; //$username;
        $_SESSION["usertype"] = $row['usertype']; //temporary value. we'll update the SQL db to include usertype soon.
        $stmt->free_result();
        $stmt->close();
        $conn->close();
        header("location: home.php");
      } else if ($stmt->num_rows > 1){
        $error = "More than one user with this combination of username and password.";
      } else {
        $error = "Username and password combination incorrect.";
      }
    } else {
      $error = "Something went wrong with the login query.";
    }
    $stmt->free_result();
    $stmt->close();
    $conn->close();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Login</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
      <style type="text/css">
          body{ font: 14px sans-serif; }
          .wrapper{ width: 350px; padding: 20px; }
      </style>
  </head>
  <body>
      <div class="wrapper">
          <h2>Login</h2>
          <p>Please fill in your credentials to login.</p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($error)) ? '' : ''; ?>">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                  <span class="help-block"><?php echo $error; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($error)) ? '' : ''; ?>">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                  <span class="help-block"><?php echo $error; ?></span>
              </div>
              <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Login">
              </div>
          </form>
      </div>
  </body>
</html>
