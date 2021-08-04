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
  $pathbase = '/home/aptamatrix/Sorting/';
  $pathappend = str_replace("-","",$_GET['Date']);
  $path = $pathbase . $pathappend;
  $files = scandir($path);
  $files = array_diff(scandir($path), array('.', '..'));

  foreach($files as $file){
      echo "<a href='exploredir.php?pathbase=" . rawurlencode($path) . "&pathappend=" . rawurlencode($file) ."' target='blank'>" . htmlspecialchars($file) . "</a>";
      echo "<br>";
  }
?>
