<?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("location: login.php");
      exit;
  }

  //check if user has enough privileges
  if ($_SESSION['usertype'] < 2) {
    exit("<script>alert('Insufficient privileges to access this function.');</script>");
  }
?>

<?php
  if (empty($_POST['runid'])) {
    exit("<script>alert('No sampleid was supplied.');</script>");
  }

  $conn = new mysqli('SOMEHOST','SOMEUSER','SOMEPASS','SOMETABLE');

  $sql = "SELECT * FROM `Run_Summary` WHERE `runid` = ? LIMIT 1;";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $runid);
  $runid = $_POST['runid'];

  if(!$stmt->execute()){
    exit('echo "<p>"' . mysqli_error($conn) . '"</p>";');
  }

  $result = $stmt->get_result();
  $row = mysqli_fetch_assoc($result);

  foreach($row as $key => $value) {
    if ($key == 'runid') {
      continue;
    }
    if ($key == 'Date') {
      echo "<p>Date: " . $value . "</p>";
    } else {
      switch($key) {
        case "dsDNA loading":
          $colname = "[Loading] dsDNA (pM)";
          break;
        case "Density":
          $colname = "Density [K/mm^2]";
          break;
        case "Cluster PF":
          $colname = "Cluster PF %";
          break;
        case "Reads Total":
          $colname = "Reads (M)";
          break;
        case "Reads PF":
          $colname = "Reads PF (M)";
          break;
        case "Q30 R1":
          $colname = "R1 %>Q30";
          break;
        case "Q30 I":
          $colname = "(I) %>Q30";
          break;
        case "Q30 R2":
          $colname = "R2 $>Q30";
          break;
        case "PhiX":
          $colname = "PhiX % ([PhiX])";
          break;
        case "Aligned R1":
          $colname = "Aligned (%)";
          break;
        case "Aligned R2":
          $colname = "R2 Aligned (%) (PE Only)";
          break;
        default:
          $colname = $key;
          break;
      }
      if ($key == 'CIF' || $key == 'Focus Images') {
        $value = $value? "true" : "false";
      }
      echo '<label for="' . $key . '_Edit">' . $colname . ': </label><input type="text" id="' . $key . '_Edit" name="' . $key . '_Edit" value="' . htmlspecialchars($value) . '"></input><br></br>';
    }
  }

  $stmt->free_result();
  $stmt->close();
  $conn->close();
?>
