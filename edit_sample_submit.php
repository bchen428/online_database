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

  if ($_POST['sampleid'] <= -1) {
    exit("<script>alert('Invalid sampleid: '" . $_POST['sampleid'] . "')");
  }

  $update = "UPDATE `Sample_Summary`";
  $set = "SET";
  $types = "";
  foreach($_POST['edit_notempty'] as $column) {
    $set .= " `" . $column . "` = ?,";
    switch($column) {
      case "Indices":
      case "qPCR Loading":
      case "Summary":
        $types .= "s";
        break;
      case "qPCR Loading Percent":
      case "Percent PF":
      case "Percent Index ratio PF":
        $types .= "d";
        break;
      default:
        exit("<script>alert('Something went horribly wrong with bind_param() type generation.');</script>");
        break;
    }
  }
  $set = substr($set, 0, -1); //remove trailing comma

  $where = "WHERE `sampleid` = '" . $_POST['sampleid'] . "'";
  $sql = $update . " " . $set . " " . $where . ";";

  $conn = new mysqli('SOMEHOST','SOMEUSER','SOMEPASS','SOMETABLE');
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($types, ...$_POST['editvalues']);

  if(!$stmt->execute()){
    echo "<p>" . mysqli_error($conn) . "</p>";
  }

  $stmt->close();
  $conn->close();
?>
