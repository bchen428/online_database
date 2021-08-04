<?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }
?>

<?php
  $conn = new mysqli('SOMEHOST','SOMEUSER','SOMEPASS','SOMETABLE');
  //echo "<p> testing </p>";
  $sql = "SELECT * FROM `Run_Summary` WHERE TRUE ORDER BY `Date` DESC;";
  $stmt = $conn->prepare($sql);
  //$stmt->bind_param();
  if(!$stmt->execute()){
    echo "<p>" . mysqli_error($conn) . "</p>";
  }

/*
tbody {
  display: block;
  overflow: auto;
  width: 100%;
  height: 300px;
}
*/
  echo "<table id='run_summary' border='1' cellspacing='2' cellpadding='2'>";
  echo "<style>    table {
        display: block;
        max-width: 70%;
        max-height: 80%;
        table-layout: fixed;
        overflow: auto;
        position: relative;
        z-index: 0;
      }
      table#run_summary th:nth-child(2) {
        background: white;
        position: sticky;
        left: 0;
        z-index: 2;
      }
      th {
        background: white;
        position: sticky;
        top: 0;
      }
      table#run_summary tr:nth-child(odd) {
        background-color: #A0A0A0;
      }
      table#run_summary tr:nth-child(even) {
        background-color: #FFFFFF;
      }
      table#run_summary td:nth-child(2) {
        background: inherit;
        position: sticky;
        left: 0;
        z-index: 1;
      }
      </style>";
  if ($_POST['edit'] == "false") {
    echo "<style>
    table#run_summary th:nth-child(1) { display: none; }
    table#run_summary td:nth-child(1) { display: none; }
    </style>";
  }
  echo "<thead><tr>
        <th>Edit</th>
        <th>Date</th>
        <th>Description</th>
        <th>Flowcell ID</th>
        <th>Chemistry Version</th>
        <th>[Loading] dsDNA (pM)</th>
        <th>Density [K\mm<sup>2</sup>]</th>
        <th>Cluster PF %</th>
        <th>Reads (M)</th>
        <th>Reads PF (M)</th>
        <th>R1 %>Q30</th>
        <th>(I) %>Q30</th>
        <th>R2 %>Q30</th>
        <th>PhiX % ([PhiX])</th>
        <th>Aligned (%)</th>
        <th>R2 Aligned (%) (PE Only)</th>
        <th>Chemistry</th>
        <th>CIF</th>
        <th>Focus Images</th>
        <th>Comments</th>
        <th>Errors</th>
        </tr></thead>";

  $result = $stmt->get_result();
  echo "<tbody>";
  while($row = mysqli_fetch_assoc($result)) {
    $Date = $row['Date'];
    echo "<tr>";
    foreach($row as $key => $value) {
      if($key == "runid"){
        echo "<td><a href='javascript:openedit($value);'>Edit</a></td>";
      } else if ($key == "Date") {
        echo "<td><a href='opensrcdir.php?Date=" . rawurlencode($Date) . "' target='blank'>" . htmlspecialchars($value) . "</a></td>";
      } else if($key == "CIF"){
        if ($value == "1") {
          echo "<td>true</td>";
        } else {
          echo "<td>false</td>";
        }
      } else if ($key == "Focus Images") {
        if ($value == "1") {
          echo "<td>true</td>";
        } else {
          echo "<td>false</td>";
        }
      } else {
        echo "<td>" . htmlspecialchars($value) . "</td>";
      }
    }
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";

  $stmt->free_result();
  $stmt->close();
  $conn->close();
?>
