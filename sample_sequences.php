<?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }
?>

<!DOCTYPE HTML>
<html>
  <head>
    <style>
    </style>
  </head>
  <body>
    <?php
      $conn = new mysqli('SOMEHOST','SOMEUSER','SOMEPASS','SOMETABLE');

      $sql = "SELECT `Date`, `Name` FROM `Sample_Summary` WHERE `sampleid` = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $sampleid);
      $sampleid = $_GET['sampleid'];
      if(!$stmt->execute()){
        echo "<p>" . mysqli_error($conn) . "</p>";
      }
      $result = $stmt->get_result();
      $row = mysqli_fetch_array($result);
      echo "<p>Date: " . $row['Date'] . "</p>";
      echo "<p>Sample: " . $row['Name'] . "</p>";

      $stmt->free_result();
      $stmt->close();

      $sql = "SELECT * FROM `Sequences` WHERE `sampleid` = ? AND `sequence_type` = '0' ORDER BY `count` DESC;";
      $stmt = $conn->prepare($sql); //prepared statement to prevent injections
      $stmt->bind_param("s", $sampleid);
      //$sampleid = $_GET['sampleid'];

      if(!$stmt->execute()){
        echo "<p>" . mysqli_error($conn) . "</p>";
      }

      $result = $stmt->get_result();

      if($result->num_rows > 0){
        echo "<table style='float: right; margin-right: 500px' id= 'sequences' border='1' cellspacing='2' cellpadding='2'>";
        echo "<tr>
        <td>Sequence</td>
        <td>Count</td>
        <td>Type</td>
        </tr>";
        while($row = mysqli_fetch_array($result)) {
          echo "<tr>
          <td>" . $row['sequence'] . "</td>
          <td>" . $row['count'] . "</td>
          <td>";
          if($row['sequence_type']){
            echo "Good";
          } else {
            echo "Total";
          }
          echo "</td>
          </tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No results found for query: " . $sql . "</p>";
        echo "<p>Ignore the ? mark, it is the prepared statement (effectively the sampleid you see in the url).</p>";
        echo "<p>This could be due to there having been no good reads sequences with a count >= 2 for this sample.</p>";
        echo "<p>If you think this message has been reached in error, please check the raw data.</p>";
      }
      $stmt->free_result();
      $stmt->close();

      $sql = "SELECT * FROM `Sequences` WHERE `sampleid` = ? AND `sequence_type` = '1' ORDER BY `count` DESC;";
      $stmt = $conn->prepare($sql); //prepared statement to prevent injections
      $stmt->bind_param("s", $sampleid);
      //$sampleid = $_GET['sampleid'];

      if(!$stmt->execute()){
        echo "<p>" . mysqli_error($conn) . "</p>";
      }

      $result = $stmt->get_result();

      if($result->num_rows > 0){
        echo "<table style='float: left; margin-left: 500px' id= 'sequences' border='1' cellspacing='2' cellpadding='2'>";
        echo "<tr>
        <td>Sequence</td>
        <td>Count</td>
        <td>Type</td>
        </tr>";
        while($row = mysqli_fetch_array($result)) {
          echo "<tr>
          <td>" . $row['sequence'] . "</td>
          <td>" . $row['count'] . "</td>
          <td>";
          if($row['sequence_type']){
            echo "Good";
          } else {
            echo "Total";
          }
          echo "</td>
          </tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No results found for query: " . $sql . "</p>";
        echo "<p>Ignore the ? mark, it is the prepared statement (effectively the sampleid you see in the url).</p>";
        echo "<p>This could be due to there having been no sequences with a count >= 2 for this sample.</p>";
        echo "<p>If you think this message has been reached in error, please check the raw data.</p>";
      }
      $stmt->free_result();
      $stmt->close();
      $conn->close();
    ?>
  </body>
</html>
