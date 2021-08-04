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
  if (empty($_POST['sampleid'])) {
    exit("<script>alert('No sampleid was supplied.');</script>");
  }

  $conn = new mysqli('SOMEHOST','SOMEUSER','SOMEPASS','SOMETABLE');
  $sql = "SELECT `Date`, `Name`, `Indices`, `qPCR Loading`, `qPCR Loading Percent`, `Percent PF`, `Percent Index ratio PF`, `Summary` FROM `Sample_Summary` WHERE `sampleid` = ? LIMIT 1;";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $sampleid);
  $sampleid = $_POST['sampleid'];

  if(!$stmt->execute()){
    exit('echo "<p>"' . mysqli_error($conn) . '"</p>";');
  }

  $result = $stmt->get_result();
  $row = mysqli_fetch_assoc($result);
  echo "<p>Date: " . htmlspecialchars($row['Date']) . "</p>";
  echo "<p>Name: " . htmlspecialchars($row['Name']) . "</p>";

  echo '<label for="Indices_Edit">Indices: </label><input type="text" id="Indices_Edit" name="Indices_Edit" value="' . htmlspecialchars($row["Indices"]) . '"><br></br>';
  echo '<label for="qPCR Loading_Edit">qPCR Loading (pmol): </label><input type="text" id="qPCR Loading_Edit" name="qPCR Loading_Edit" value="' . htmlspecialchars($row["qPCR Loading"]) . '"><br></br>';
  echo '<label for="qPCR Loading Percent_Edit">qPCR Loading %: </label><input type="text" id="qPCR Loading Percent_Edit" name="qPCR Loading Percent_Edit" value="' . htmlspecialchars($row["qPCR Loading Percent"]) . '"><br></br>';
  echo '<label for="Pass Filter Percent_Edit">Pass-Filter %: </label><input type="text" id="Percent PF_Edit" name="Percent PF_Edit" value="' . htmlspecialchars($row["Percent PF"]) . '"><br></br>';
  echo '<label for="Percent Index Ratio PF_Edit">Index Ratio PF %: </label><input type="text" id="Percent Index ratio PF_Edit" name="Percent Index ratio PF_Edit" value="' . htmlspecialchars($row["Percent Index ratio PF"]) . '"><br></br>';
  echo '<label for="Summary_Edit">Summary: </label><input type="text" id="Summary_Edit" name="Summary_Edit" value="' . htmlspecialchars($row["Summary"]) . '"><br></br>';

  $stmt->free_result();
  $stmt->close();
  $conn->close();
?>
