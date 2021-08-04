<?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("location: login.php");
      exit;
  }

  //check if user has enough privileges
  if ($_SESSION['usertype'] < 1) {
    exit("<script>alert('Insufficient privileges to access this function.');</script>");
  }
?>

<?php
  $pathbase = $_GET['pathbase'];
  $pathappend = $_GET['pathappend'];
  if ($pathappend != "runinfo.txt" || $pathappend != "export.csv"){
    $line_size = 1024;
  } else {
    $line_size = 50;
  }
  $file = $pathbase . "/" . $pathappend;
  $myfile = fopen($file, "r") or die("Unable to open file!");
  $line_limit = 800000;
  $line_count = 0;
  while($line_count < $line_limit && !feof($myfile)){
    echo htmlspecialchars(fgets($myfile, $line_size));
    echo "<br>";
    $line_count++;
  }
  fclose($myfile);
?>
