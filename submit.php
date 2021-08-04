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
  echo "<table id='sample_summary' border='1' cellspacing='2' cellpadding='2'>";
  echo "<style>    table {
        display: block;
        width: 80%;
        max-height: 800px;
        table-layout: fixed;
        overflow: auto;
        position: relative;
        z-index: 0;
      }
      table#sample_summary tr#whiterow {
        background: white;
      }
      table#sample_summary tr#greyrow {
        background: #A0A0A0;
      }
      table#sample_summary th:nth-child(2) {
        position: sticky;
        left: 0;
        z-index: 2;
      }
      table#sample_summary td:nth-child(2) {
        background: inherit;
        position: sticky;
        left: 0;
        z-index: 1;
      }
      th {
        background: white;
        position: sticky;
        top: 0;
      }
      </style>";
  if ($_POST['edit'] == "false") {
    echo "<style>
    table#sample_summary td:nth-child(1) { display: none; }
    table#sample_summary th:nth-child(1) { display: none; }
    </style>";
  }
  $empty_sopts = empty($_POST['select_options']);
  $conn = new mysqli('SOMEHOST','SOMEUSER','SOMEPASS','SOMETABLE');
  $select = $empty_sopts? selectall() : selectfunction();

  //prepares the header table
  function selectfunction(){
    echo "<tr>";
    echo "<th>Edit</th>";
    $select_string = 'SELECT `sampleid`, ';
    foreach ($_POST['select_options'] as $column){
      $select_string .=  "`" . $column . "`,"; //appends it to the "SELECT (x, x, x ...)"
      //generates the columns on the table --have to use switch since $column is not always the string we want to display
      //could have opted for default to just display $column for the ones that are the same... but then could also display erroneous $column
      switch ($column){
        case "Date":
          echo "<th onclick='sortby(`".$column."`)'>Date</th>"; //refers to sortby() function on home.php
          break;
        case "Name":
          echo "<th onclick='sortby(`".$column."`)'>Sample</th>";
          break;
        case "Total Reads":
          echo "<th onclick='sortby(`".$column."`)'>Total Reads</th>";
          break;
        case "Good Reads":
          echo "<th onclick='sortby(`".$column."`)'>Good Reads</th>";
          break;
        case "Candidate Reads":
          echo "<th onclick='sortby(`".$column."`)'>Candidate Reads</th>";
          break;
        case "Bad Reads":
          echo "<th onclick='sortby(`".$column."`)'>Bad Reads</th>";
          break;
        case "Good Percent":
          echo "<th onclick='sortby(`".$column."`)'>Good %</th>";
          break;
        case "Candidate Percent":
          echo "<th onclick='sortby(`".$column."`)'>Candidate %</th>";
          break;
        case "Bad Percent":
          echo "<th onclick='sortby(`".$column."`)'>Bad %</th>";
          break;
        case "Library Length":
          echo "<th onclick='sortby(`".$column."`)'>Library Length</th>";
          break;
        case "Offset":
          echo "<th onclick='sortby(`".$column."`)'>Offset</th>";
          break;
        case "Head":
          echo "<th onclick='sortby(`".$column."`)'>Head</th>";
          break;
        case "Tail":
          echo "<th onclick='sortby(`".$column."`)'>Tail</th>";
          break;
        case "Good Errors":
          echo "<th onclick='sortby(`".$column."`)'>Good Errors</th>";
          break;
        case "Max Errors":
          echo "<th onclick='sortby(`".$column."`)'>Max Errors</th>";
          break;
        case "Indices":
          echo "<th onclick='sortby(`".$column."`)'>Indices</th>";
          break;
        case "qPCR Loading":
          echo "<th onclick='sortby(`".$column."`)'>qPCR Loading</th>";
          break;
        case "qPCR Loading Percent":
          echo "<th onclick='sortby(`".$column."`)'>qPCR Loading %</th>";
          break;
        case "Percent PF":
          echo "<th onclick='sortby(`".$column."`)'>PF %</th>";
          break;
        case "Percent Index ratio PF":
          echo "<th onclick='sortby(`".$column."`)'>Index Ratio PF %</th>";
          break;
        case "Summary":
          echo "<th onclick='sortby(`".$column."`)'>Summary</th>";
          break;
        default:
          echo "<th>Error: column " . $column . " not found</th>";
          break;
      }
    }
    echo "</tr>";
    return substr($select_string, 0, -1);
  }

  //just output all columns
  function selectall(){
    //$test = 'Total Reads';
    echo "<tr>
    <th>Edit</th>
    <th onclick='sortby(`Date`)'>Date</th>
    <th onclick='sortby(`Name`)'>Sample</th>
    <th onclick='sortby(`Total Reads`)'>Total Reads</th>
    <th onclick='sortby(`Good Reads`)'>Good Reads</th>
    <th onclick='sortby(`Candidate Reads`)'>Candidate Reads</th>
    <th onclick='sortby(`Bad Reads`)'>Bad Reads</th>
    <th onclick='sortby(`Good Percent`)'>Good %</th>
    <th onclick='sortby(`Candidate Percent`)'>Candidate %</th>
    <th onclick='sortby(`Bad Percent`)'>Bad %</th>
    <th onclick='sortby(`Library Length`)'>Library Length</th>
    <th onclick='sortby(`Offset`)'>Offset</th>
    <th onclick='sortby(`Head`)'>Head</th>
    <th onclick='sortby(`Tail`)'>Tail</th>
    <th onclick='sortby(`Good Errors`)'>Good Errors</th>
    <th onclick='sortby(`Max Errors`)'>Max Errors</th>
    <th onclick='sortby(`Indices`)'>Indices</th>
    <th onclick='sortby(`qPCR Loading`)'>qPCR Loading (pmol)</th>
    <th onclick='sortby(`qPCR Loading Percent`)'>qPCR Loading %</th>
    <th onclick='sortby(`Percent PF`)'>Pass-Filter %</th>
    <th onclick='sortby(`Percent Index ratio PF`)'>Index Ratio PF %</th>
    <th onclick='sortby(`Summary`)'>Summary</th>
    </tr>";
    return "SELECT *";
  }

  $from = 'FROM `Sample_Summary`';
  $where = 'WHERE TRUE';
  $order = '';
  $empty_oopts = empty($_POST['order_options']);

  if (!$empty_oopts) {
    $order .= 'ORDER BY `' . $_POST["order_options"][0] . '`'; //tells it to order by a particular column
    $order .= ($_POST['order_options'][1] == 'true')? ' DESC' : ' ASC'; //does the ascending/descending (not perfect, but it works)
  }

  $empty_wopts = empty($_POST['where_options']) && empty($_POST['where_comparisons']) && empty($_POST['where_columns']); //check if all the where are empty

  //builds the prepared statement for the WHERE clause
  if (!$empty_wopts) {
    $wcolcount = count($_POST['where_columns']);
    if ($wcolcount > 0 && $wcolcount == count($_POST['where_options']) && $wcolcount == count($_POST['where_comparisons'])) { //just in case length of these three are different for some odd reason or if empty() failed to catch it
      $where .= ' AND';
      for ($i = 0; $i < $wcolcount; $i++){ //appends " `colname` operator ? AND" (e.g. `Date` = ? AND)
        $where .= ' `' . $_POST['where_columns'][$i] . '`';
        switch($_POST['where_comparisons'][$i]){
          case "X": //no selection
            $where .= "= ? AND";
            break;
          case "M": //match is same as equal
          case "E": //equal
            $where .= "= ? AND";
            break;
          case "GE": //greater/equal
            $where .= ">= ? AND";
            break;
          case "LE": //lesser/equal
            $where .= "<= ? AND";
            break;
          case "L": //lesser
            $where .= "< ? AND";
            break;
          case "G": //greater
            $where .= "> ? AND";
            break;
          case "C": //contain
            $where .= " LIKE ? AND";
            break;
          case "R": //range
            $where .= " BETWEEN ? AND ? AND";
            break;
          case "LI": //list
            echo "<p>THISISAPLACEHOLDER</p>";
            //$qq = formatdate($_POST['where_options'][$i]);
            //Secho "<p>" . $qq . "</p>";
            die();
            break;
          default:
            die("Something went horribly wrong with the wopts string constructor.");
            break;
        }
      }
      $where = substr($where, 0, -4); //deletes the trailing " AND"
    } else {
      die('<p>Something is wrong with the number of WHERE parameters.</p>');
    }
  }

  $sql = $select . ' ' . $from . ' ' . $where . ' ' . $order . ';'; //need include ORDER BY for when click column headers.
  //echo "<script>alert('" . $sql ."');</script>";
  $stmt = $conn->prepare($sql); //prepared statement to prevent injections

  //builds the string to declare types necessary for bind_param($types, ...$params)
  if (!$empty_wopts) {
    $wcount = count($_POST['where_options']);
    $types = "";
    for ($i = 0; $i < $wcount; $i++) {
      switch($_POST['where_comparisons'][$i]) {
        case "X": //no selection
        case "C": //contain
        case "M": //match is same as equal
          $types .= "s";
          break;
        case "E": //equal
        case "GE": //greater/equal
        case "LE": //lesser/equal
        case "L": //lesser
        case "G": //greater
          if($_POST['where_columns'][$i] != "Date") { //date is a string
            $types .= "i";
          } else {
            $types .= "s";
          }
          break;
        case "R": //range
          if($_POST['where_columns'][$i] != "Date") { //date is a string
            $types .= "ii";
          } else {
            $types .= "ss";
            $temparray = $_POST['where_options'];
            $firstdate = substr($_POST['where_options'][$i], 0, 10);
            $seconddate = substr($_POST['where_options'][$i], -10);
            $_POST['where_options'][$i] = $firstdate;
            array_splice($_POST['where_options'], 1 + $i, 0, $seconddate);
          }
        break;
        default:
          die("Something went horribly wrong with the bind_param.");
          break;
      }
    }
  }

  $stmt->bind_param($types, ...$_POST['where_options']); //the ellipsis apparently allow it to work for an array.
  if(!$stmt->execute()) {
    echo "<p>" . mysqli_error($conn) . "</p>";
  }
  $result = $stmt->get_result();
  $prevdate = '';
  $rowid = 'whiterow';

  //fetch results back as an associative array then return as html table
  while($row = mysqli_fetch_assoc($result)) {
    $sampleid = $row['sampleid'];
    $Date = $row['Date'];
    if ($Date != $prevdate) {
      $rowid = ($rowid == 'whiterow') ? 'greyrow' : 'whiterow';
      $prevdate = $Date;
    }
    $Name = $row['Name'];
    echo "<tr id='" . $rowid . "'>";
    if ($empty_sopts){
      foreach($row as $key => $value) {
        if ($key == "sampleid") {
          echo "<td><a href='javascript:openedit($sampleid);'>Edit</a></td>";
        }
        if ($key != "sampleid" && $key != "runid"){
          if ($key != "Name"){
            echo "<td>" . htmlspecialchars($value) . "</td>";
          } else {
            echo "<td><a href='sample_sequences.php?sampleid=$sampleid' id='myLink' target='_blank'>" . htmlspecialchars($value) . "</a></td>"; //instead of datename send sampleid
            //this will require that we make the mysql table for sample sequences have (sample id references (sample_summary.sampleid))
          }
        }
      }
    } else {
      foreach($row as $key => $value) {
        if ($key == "sampleid"){
          echo "<td><a href='javascript:openedit($sampleid);'>Edit</a></td>";
        }
        if(in_array($key, $_POST['select_options'])){
          if($key == "Name"){
            echo "<td><a href='sample_sequences.php?sampleid=$sampleid' id='myLink' target='_blank'>" . htmlspecialchars($value) . "</a></td>"; //instead of datename send sampleid
          } else {
            echo "<td>" . htmlspecialchars($value) . "</td>";
          }
        }
      }
    }
    echo "</tr>";
  }
  echo "</table>";
  $stmt->free_result();
  $stmt->close();
  $conn->close();
?>

<?php

  function formatdate (string $s) {
    $datecharacters = "0123456789-";
    $formatteddate = "";
    $len = strlen($s);
    for ($i = 0; $i < $len; $i++) {
      if (strpos($datecharacters, $s[$i]) != false) {
        $formatteddate .= $s[$i];
      }
    }
    return $formatteddate;
  }

?>
