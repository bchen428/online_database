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

  $notempty_len = count($_POST['edit_notempty']);
  $values_len = count($_POST['editvalues']);

  if ($notempty_len != $values_len) {
    exit("<script>alert('Error with input parameters.');</script>");
  }

  if ($notempty_len == 0) {
    exit("<script>alert('No values to update.');</script>");
  }

  if ($_POST['runid'] <= -1) {
    exit("<script>alert('Invalid runid: '" . $_POST['runid'] . "')");
  }

  $update = "UPDATE `Run_Summary`";
  $set = "SET";
  $types = "";
  foreach($_POST['edit_notempty'] as $column) {
    $set .= " `" . $column . "` = ?,";
    switch($column) {
      case "Description":
      case "Flowcell ID":
      case "Chemistry Version":
      case "dsDNA loading":
      case "Density":
      case "Cluster PF":
      case "PhiX":
      case "Aligned R1":
      case "Aligned R2":
      case "Chemistry":
      case "Comments":
      case "Errors":
        $types .= "s";
        break;
      case "Reads Total":
      case "Reads PF":
      case "Q30 R1":
      case "Q30 I":
      case "Q30 R2":
        $types .= "d";
        break;
      case "CIF":
      case "Focus Images":
        $types .= "i";
        break;
      default:
        exit("<script>alert('Something went horribly wrong with bind_param() type generation.');</script>");
        break;
    }
  }
  $set = substr($set, 0, -1); //remove trailing comma

  $where = "WHERE `runid` = '" . $_POST['runid'] . "'";

  $sql = $update . " " . $set . " " . $where . ";";

  for ($i = 0; $i < $notempty_len; $i++) {
    if (($_POST['edit_notempty'][$i] == "CIF") || ($_POST['edit_notempty'][$i] == 'Focus Images')) {
      if (strcasecmp($_POST['editvalues'][$i], "true") == 0 || strcasecmp($_POST['editvalues'][$i], "t") == 0) {
        $_POST['editvalues'][$i] = "1";
      } else if (strcasecmp($_POST['editvalues'][$i], "false") == 0 || strcasecmp($_POST['editvalues'][$i], "f") == 0) {
        $_POST['editvalues'][$i] = "0";
      }
    } else {
      $_POST['editvalues'][$i] = $_POST['editvalues'][$i];
    }
  }

  $conn = new mysqli('SOMEHOST','SOMEUSER','SOMEPASS','SOMETABLE');
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($types, ...$_POST['editvalues']);

  if(!$stmt->execute()){
    exit('echo "<p>"' . mysqli_error($conn) . '"</p>";');
  }

  $stmt->close();
  $conn->close();
?>
