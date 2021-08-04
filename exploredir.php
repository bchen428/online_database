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
  function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
      if( !$length ) {
          return true;
      }
    return substr( $haystack, -$length ) === $needle;
  }

  echo "Please note that for extremely large files, we only load the first 800,000 lines. <br></br><br></br>";

  $pathbase = $_GET['pathbase'];
  $pathappend = $_GET['pathappend'];
  $path = $pathbase . "/" . $pathappend;
  $files = scandir($path);
  $files = array_diff(scandir($path), array('.', '..'));

  foreach($files as $file){
    if(endsWith($file, ".txt") || endsWith($file, ".csv") || endsWith($file, ".fastq")) {
      echo "<a href='readfile.php?pathbase=" . rawurlencode($path) . "&pathappend=" . rawurlencode($file) . "' target='blank'>" . htmlspecialchars($file) . "</a>";
      echo "<br>";
    } else {
      echo "<a href='exploredir.php?pathbase=" . rawurlencode($path) . "&pathappend=" . rawurlencode($file) . "' target='blank'>" . htmlspecialchars($file) . "</a>";
      echo "<br>";
    }
  }
?>
