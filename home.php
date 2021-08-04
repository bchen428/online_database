<?php
  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }

  $usertype = $_SESSION["usertype"];
?>

<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <title>AptaMatrix</title>
  </head>
  <body>
    <input type="button" class="button" name="Logout" value="Logout" id="Logout" style="float: right;">
    <h1 style="text-align:center;">AptaMatrix Database</h1>
    <input type="button" class="buton" name= "Sample_Summary" value ="Sample Summary" id="ShowSampleSummary"></input>
    <input type="button" class="buton" name= "Run_Summary" value ="Run Summary" id="ShowRunSummary"></input>
    <br /><br />
    <!--<h1 style="text-align:center;">If weird things appear/the page goes blank, it is because I am testing things -Brian</h1>-->

    <button id="Filter" style="visibility:hidden;">Filter</button>
    <div id="Filter_Form" class="modal">
      <div id="Filter_Form_content" class="modal-content">
        <span class="close">&times;</span>
        <form>
          <label for="Date">Date: </label>
          <input type="text" id="Date" name="Date">
          <select name="Date" id="Date">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
            <option value="R">Range</option>
            <option value="LI">List</option>
          </select>
          <label for="Date"> Show: </label>
          <input type="checkbox" id="Date" name="Date">
          <br>

          <label for="Name">Name: </label>
          <input type="text" id="Name" name="Name">
          <select name="Name" id="Name">
            <option value="">Select:</option>
            <option value="M">Match</option>
            <option value="C">Contain</option>
          </select>
          <label for="Name"> Show: </label>
          <input type="checkbox" id="Name" name="Name">
          <br>

          <label for="Total Reads">Total Reads: </label>
          <input type="text" id="Total Reads" name="Total Reads">
          <select name="Total Reads" id="Total Reads">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Total Reads"> Show: </label>
          <input type="checkbox" id="Total Reads" name="Total Reads">
          <br>

          <label for="Good Reads">Good Reads: </label>
          <input type="text" id="Good Reads" name="Good Reads">
          <select name="Good Reads" id="Good Reads">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Good Reads"> Show: </label>
          <input type="checkbox" id="Good Reads" name="Good Reads">
          <br>

          <label for="Candidate Reads">Candidate Reads: </label>
          <input type="text" id="Candidate Reads" name="Candidate Reads">
          <select name="Candidate Reads" id="Candidate Reads">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Candidate Reads"> Show: </label>
          <input type="checkbox" id="Candidate Reads" name="Candidate Reads">
          <br>

          <label for="Bad Reads">Bad Reads: </label>
          <input type="text" id="Bad Reads" name="Bad Reads">
          <select name="Bad Reads" id="Bad Reads">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Bad Reads"> Show: </label>
          <input type="checkbox" id="Bad Reads" name="Bad Reads">
          <br>

          <label for="Good Percent">Good Percent: </label>
          <input type="text" id="Good Percent" name="Good Percent">
          <select name="Good Percent" id="Good Percent">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Good Percent"> Show: </label>
          <input type="checkbox" id="Good Percent" name="Good Percent">
          <br>

          <label for="Candidate Percent">Candidate Percent: </label>
          <input type="text" id="Candidate Percent" name="Candidate Percent">
          <select name="Candidate Percent" id="Candidate Percent">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Candidate Percent"> Show: </label>
          <input type="checkbox" id="Candidate Percent" name="Candidate Percent">
          <br>

          <label for="Bad Percent">Bad Percent: </label>
          <input type="text" id="Bad Percent" name="Bad Percent">
          <select name="Bad Percent" id="Bad Percent">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Bad Percent"> Show: </label>
          <input type="checkbox" id="Bad Percent" name="Bad Percent">
          <br>

          <label for="Library Length">Library Length: </label>
          <input type="text" id="Library Length" name="Library Length">
          <select name="Library Length" id="Library Length">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Library Length"> Show: </label>
          <input type="checkbox" id="Library Length" name="Library Length">
          <br>

          <label for="Offset">Offset: </label>
          <input type="text" id="Offset" name="Offset">
          <select name="Offset" id="Offset">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Offset"> Show: </label>
          <input type="checkbox" id="Offset" name="Offset">
          <br>

          <label for="Head">Head: </label>
          <input type="text" id="Head" name="Head">
          <select name="Head" id="Head">
            <option value="">Select:</option>
            <option value="M">Match</option>
            <option value="C">Contain</option>
          </select>
          <label for="Head"> Show: </label>
          <input type="checkbox" id="Head" name="Head">
          <br>

          <label for="Tail">Tail: </label>
          <input type="text" id="Tail" name="Tail">
          <select name="Tail" id="Tail">
            <option value="">Select:</option>
            <option value="M">Match</option>
            <option value="C">Contain</option>
          </select>
          <label for="Tail"> Show: </label>
          <input type="checkbox" id="Tail" name="Tail"><br>

          <label for="Good Errors">Good Errors: </label>
          <input type="text" id="Good Errors" name="Good Errors">
          <select name="Good Errors" id="Good Errors">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Good Errors"> Show: </label>
          <input type="checkbox" id="Good Errors" name="Good Errors"><br>

          <label for="Max Errors">Max Errors: </label>
          <input type="text" id="Max Errors" name="Max Errors">
          <select name="Max Errors" id="Max Errors">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Max Errors"> Show: </label>
          <input type="checkbox" id="Max Errors" name="Max Errors"><br>

          <label for="Indices">Indices: </label>
          <input type="text" id="Indices" name="Indices">
          <select name="Indices" id="Indices">
            <option value="">Select:</option>
            <option value="M">Match</option>
            <option value="C">Contain</option>
          </select>
          <label for="Indices"> Show: </label>
          <input type="checkbox" id="Indices" name="Indices">
          <br>

          <label for="qPCR Loading">qPCR Loading: </label>
          <input type="text" id="qPCR Loading" name="qPCR Loading">
          <select name="qPCR Loading" id="qPCR Loading">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="qPCR Loading"> Show: </label>
          <input type="checkbox" id="qPCR Loading" name="qPCR Loading"><br>

          <label for="qPCR Loading Percent">qPCR Loading %: </label>
          <input type="text" id="qPCR Loading Percent" name="qPCR Loading Percent">
          <select name="qPCR Loading Percent" id="qPCR Loading Percent">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="qPCR Loading Percent"> Show: </label>
          <input type="checkbox" id="qPCR Loading Percent" name="qPCR Loading Percent"><br>

          <label for="Percent PF">PF %: </label>
          <input type="text" id="Percent PF" name="Percent PF">
          <select name="Percent PF" id="Percent PF">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Percent PF"> Show: </label>
          <input type="checkbox" id="Percent PF" name="Percent PF"><br>

          <label for="Percent Index ratio PF">Index Ratio PF %: </label>
          <input type="text" id="Percent Index ratio PF" name="Percent Index ratio PF">
          <select name="Percent Index ratio PF" id="Percent Index ratio PF">
            <option value="">Select:</option>
            <option value="GE">Greater/Equal</option>
            <option value="G">Greater</option>
            <option value="E">Equal</option>
            <option value="L">Lesser</option>
            <option value="LE">Lesser/Equal</option>
          </select>
          <label for="Percent Index ratio PF"> Show: </label>
          <input type="checkbox" id="Percent Index ratio PF" name="Percent Index ratio PF"><br>

          <label for="Summary">Summary: </label>
          <input type="text" id="Summary" name="Summary">
          <select name="Summary" id="Summary">
            <option value="">Select:</option>
            <option value="M">Match</option>
            <option value="C">Contain</option>
          </select>
          <label for="Summary"> Show: </label>
          <input type="checkbox" id="Summary" name="Summary">
          <br>
        </form>
        <input type="submit" id="submitq" value="Submit Query">
        <input type="button" id="resetform" value="Reset">
      </div>

      <style>
        /* The Modal (background) */
        div#Filter_Form {
          display: none; /* Hidden by default */
          position: absolute; /* Stay in place */
          z-index: 3; /* Sit on top */
          left: 0;
          top: 0;
          width: 100%; /* Full width */
          height: 100%; /* Full height */
          overflow: auto; /* Enable scroll if needed */
          background-color: rgb(0,0,0); /* Fallback color */
          background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        div#Filter_Form_content {
          background-color: #fefefe;
          margin: 5% auto; /* 5% from the top and centered */
          padding: 20px;
          border: 1px solid #888;
          width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
          color: #aaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
        }

        .close:hover,
        .close:focus {
          color: black;
          text-decoration: none;
          cursor: pointer;
        }
      </style>

      <script>
        var modal = document.getElementById("Filter_Form");
        var filter = document.getElementById("Filter");
        var span = document.getElementsByClassName("close")[0];

        filter.onclick = function() {
          if(currentstate == 1){
            modal.style.display = "block";
          } else {
            alert("Filter feature is currently only enabled for Sample Summary.");
          }
        }

        span.onclick = function() {
          modal.style.display = "none";
        }

        //note see the window.onclick function further down to see how this closes when clicking off modal
      </script>
    </div>

    <div id="editmodal" class="modal">
      <style>
        /* The Modal (background) */
        div#editmodal {
          display: none; /* Hidden by default */
          position: fixed; /* Stay in place */
          z-index: 3; /* Sit on top */
          left: 0;
          top: 0;
          width: 100%; /* Full width */
          height: 100%; /* Full height */
          overflow: auto; /* Enable scroll if needed */
          background-color: rgb(0,0,0); /* Fallback color */
          background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        div#editmodal_content {
          background-color: #fefefe;
          margin: 15% auto; /* 15% from the top and centered */
          padding: 20px;
          border: 1px solid #888;
          width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .closeedit {
          color: #aaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
        }

        .closeedit:hover,
        .closeedit:focus {
          color: black;
          text-decoration: none;
          cursor: pointer;
        }
      </style>
      <div id="editmodal_content" class="modal-content">
        <span class="closeedit">&times;</span>
        <div id="editmodaltext"></div>
        <input type="submit" id="confirmedit" value="Update">
      </div>
      <script>
      var editmodal = document.getElementById("editmodal");
      var closeedit = document.getElementsByClassName("closeedit")[0];
      var editsampleid = -1;
      var editrunid = -1;

      function openedit(id){
        if (currentstate == 1) { //sample summary edit
          if (usertype >= 2){
            editsampleid = id;
            editmodal.style.display = "block";
            $.ajax({
              type: "POST",
              url: "edit_sample.php",
              data: {
                sampleid : id
              },
              success: function(response) { //returns the output as html. it appears that the success can read output from ajax post and can be passed to this function
                $('#editmodaltext').html(response);
              }
            });
          } else {
            alert("Editing is not available for your access level. Please contact the administrator for more details.");
          }
        } else if (currentstate == 2) { //run summary edit
          if (usertype >= 2) {
            editrunid = id;
            editmodal.style.display = "block";
            $.ajax({
              type: "POST",
              url: "edit_run.php",
              data: {
                runid : id
              },
              success: function(response) { //returns the output as html. it appears that the success can read output from ajax post and can be passed to this function
                $('#editmodaltext').html(response);
              }
            });
          } else {
            alert("Editing is not available for your access level. Please contact the administrator for more details.");
          }
        } else { //should not be reachable?
          exit("Stop trying to hack.");
        }
      }

      document.getElementById("confirmedit").onclick = function(){
        var editboxes = $("input:text[id$='_Edit']");
        var editvalues = [];
        var edit_notempty = [];
        editboxes.each(function(){
          if ($(this).val() != "") {
            editvalues.push($(this).val());
            edit_notempty.push((this.name).replace("_Edit", ""));
          }
        });
        if (confirm("Are you sure you want to save these changes into the database?\nThese changes cannot be undone.")) {

          if (currentstate == 1) { //edit sample summary

            $.ajax({
              type: "POST",
              url: "edit_sample_submit.php",
              data: {
                sampleid : editsampleid,
                editvalues : editvalues,
                edit_notempty : edit_notempty
              },
              success: function() {
                editmodal.style.display = "none";
                var sopts = getsopts();
                var wopts = getwopts();
                if (sopts.length == 0) {
                  if (oopts.length == 0) {
                    updateTable('', wopts, '', true);
                  } else {
                    updateTable('', wopts, oopts, true);
                  }
                } else {
                  if (oopts.length == 0) {
                    updateTable(sopts, wopts, oopts, true);
                  } else {
                    updateTable(sopts, wopts, oopts, true);
                  }
                }
              },
              error:function(x,e){
                ajaxerrors(x,e);
              }
            });

            editsampleid = -1; //reset it

          } else if (currentstate == 2) { //edit runsummary
            $.ajax({
              type: "POST",
              url: "edit_run_submit.php",
              data: {
                runid : editrunid,
                editvalues : editvalues,
                edit_notempty : edit_notempty
              },
              success: function() {
                editmodal.style.display = "none";
                updateTable('', '', '', true);
              },
              error:function(x,e){
                ajaxerrors(x,e);
              }
            });

            editrunid = -1; //resetit

          } else {
            exit("STOP HACKING!!");
          }

        }
      }

      closeedit.onclick = function(){
        $('#editmodaltext').html(""); //empty the modal just in case
        editmodal.style.display = "none";
      }

      window.onclick = function(event) {
        if (event.target == editmodal) {
          $('#editmodaltext').html(""); //empty the modal just in case
          editmodal.style.display = "none";
        } else if (event.target == modal) {
          modal.style.display = "none";
        }
      }
      </script>
    </div>

    <!--<input type="button" class="button" name="InsertButton" value="Insert(undergoingtesting...)" id="InsertButton">-->
    <input type="button" class="button" name="EditButton" value="Edit" id="EditButton" style="visibility: hidden;">
    <div class="scroll" style="overflow-y: auto;" id = 'samples'>
      <!--<table id= 'samples' border='1' cellspacing='2' cellpadding='2'></table>-->
      <style>
      </style>
    </div>

    <div id = "help" style="visibility:visible">
      Click the 'Sample Summary' or 'Run Summary' buttons to show the respective summaries.<br /><br />
      These buttons also function as reset buttons (to display the entire summary again).<br /><br />
      <br /><br />
      Sample Summary additionally has these features:<br /><br />
      Click on the 'Filter' button to open a form that lets you filter which rows you see.<br /><br />
      Note that the 'Date' column allows you to specifically filter a range (to be entered as two dates in YYYY-MM-DD format). It takes the first 10 characters and the last 10 characters, so it does not matter what your delimiter is. <br /><br />
      Click on the column headers to sort the data (by that column) in ascending/descending order. Click it again to sort the opposite.<br /><br />
      Click on the Sample name to see the top 100 sequences of both the good and total reads (where count > 2).<br /><br />
      <br /><br />
      Run Summary additionally has these features:<br /><br />
      Click on the specific Date to access the files for that run.<br /><br />
      <br /><br />
      Both summaries have the Edit function enabled.<br /><br />
      Click on the 'Edit' button to show the Edit column. Click it again to hide the column.<br /><br />
      Click the 'Edit' text that appears next to a given row to edit that row. Editable options will then be able to be changed in the pop-up menu.<br /><br />
    </div>

    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script>
      //get session variables
      var usertype='<?php echo $usertype;?>';

      //Editing
      var currentlyediting = false;

      //declare some variables
      var $checkboxes = $("div#Filter_Form input:checkbox");
      var $drops = $('div#Filter_Form select');
      var $textboxes = $("div#Filter_Form input:text");

      //return which columns to SELECT
      function getsopts() {
        var opts = [];
        $checkboxes.each(function() {
          if(this.checked) {
            opts.push(this.name);
          }
        });
        return opts;
      }

      //return the WHERE options
      function getwopts() {
        var cnames = [];
        var comps = [];
        var opts = [];
        $drops.each(function() {
          var text = $('input:text[name="'+this.id+'"]').val(); //does storing this into a variable prevent the htmlinjection?
          var comp = this.options[this.selectedIndex].value;
          if(comp && text){ //only add to array if there is both text and comparison selected
            cnames.push(this.id);
            comps.push(comp);
            (comp != "C") ? opts.push(text) : opts.push("%"+text+"%"); //for specifically "C" comp, opt needs to be WHERE `col` LIKE '%text%'
          }
        });
        return {cnames: cnames, comps: comps, opts: opts};
      }

      //AJAX/JQuery to update the table (calls submit.php which returns as html)
      //
      function updateTable(sopts, wopts, oopts, edit = false) {
        if (currentstate == 1) {
          $.ajax({
            type: "POST",
            url: "submit.php",
            data: {
              select_options: sopts,
              where_columns: wopts.cnames,
              where_comparisons: wopts.comps,
              where_options: wopts.opts,
              order_options: oopts,
              edit: edit
            },
            success: function(response) { //returns the output as html. it appears that the success can read output from ajax post and can be passed to this function
              $('#samples').html(response);
            },
            error: function(x,e) {
                if (x.status==0) {
                    alert('You are offline!!\n Please Check Your Network.');
                } else if(x.status==404) {
                    alert('Requested URL not found.');
                } else if(x.status==500) {
                    alert('Internel Server Error.');
                } else if(e=='parsererror') {
                    alert('Error.\nParsing JSON Request failed.');
                } else if(e=='timeout'){
                    alert('Request Time out.');
                } else {
                    alert('Unknown Error.\n'+x.responseText);
                }
            }
          });
        } else if (currentstate == 2) {
          $.ajax({
            type: "POST",
            url: "run_summary.php",
            data: {
              select_options: sopts,
              where_columns: wopts.cnames,
              where_comparisons: wopts.comps,
              where_options: wopts.opts,
              order_options: oopts,
              edit : edit
            },
            success: function(response) { //returns the output as html. it appears that the success can read output from ajax post and can be passed to this function
              $('#samples').html(response);
            },
            error:function(x,e) {
              ajaxerrors(x,e);
            }
          });
        } else {
          alert("updatetable called on state 0, placeholder -- doing nothing");
        }
      }

      function ajaxerrors(x,e) {
        if (x.status==0) {
            alert('You are offline!!\n Please Check Your Network.');
        } else if(x.status==404) {
            alert('Requested URL not found.');
        } else if(x.status==500) {
            alert('Internel Server Error.');
        } else if(e=='parsererror') {
            alert('Error.\nParsing JSON Request failed.');
        } else if(e=='timeout'){
            alert('Request Time out.');
        } else {
            alert('Unknown Error.\n'+x.responseText);
        }
      }

      //sortby
      class Descending { //creates static variable
        static Descending = false;
        static Change() {
          this.Descending = !this.Descending;
        }
      }

      var oopts;

      function sortby(column) {
        Descending.Change(); //makes true/false
        var sopts = getsopts();
        var wopts = getwopts();
        oopts = [column, Descending.Descending]; //column type and a statically remembered true/false for sort direction (imperfect, but good enough)
        if (currentlyediting) {
          updateTable(sopts, wopts,oopts,true);
        } else {
          updateTable(sopts,wopts,oopts); //calls updateTable .. now to build the ORDER BY function...
        }
      }
      //end sortby

      //uncomment the below line to have the homepage have the sample summary open by default (remember set currentstate to 1 though)
      //updateTable('','',''); //calling this with empty parameters returns entire table to default homepage

      //for updating the table every time you resubmit the filter form
      document.getElementById("submitq").onclick = function() {
        var sopts = getsopts();
        var wopts = getwopts();
        updateTable(sopts,wopts,'', currentlyediting);
      };

      //reset the filter form when you hit reset button
      document.getElementById("resetform").onclick = function() {
        $checkboxes.prop('checked', false);
        $drops.each(function() { this.selectedIndex = 0 });
        $textboxes.each(function() { this.value = ''; });
      };

      //redirect to logout.php when you click the logout button
      document.getElementById("Logout").onclick = function() {
        location.href = "logout.php";
      };

      var currentstate = 0; // 0 = nothing loaded, 1 = sample summary, 2 = run summary
      //ajax sample summary
      document.getElementById("ShowSampleSummary").onclick = function() {
        currentstate = 1;
        $checkboxes.prop('checked', false);
        $drops.each(function() { this.selectedIndex = 0 });
        $textboxes.each(function() { this.value = ''; });
        currentlyediting = false;
        $('#editmodaltext').html(""); //empty the modal just in case
        document.getElementById('help').style.visibility='hidden';
        if (usertype >= 1) {
          document.getElementById('Filter').style.visibility='visible';
        }
        if (usertype >= 2) {
          document.getElementById("EditButton").style.visibility='visible';
        }
        updateTable('','',["Date", true]);
        Descending.Descending = true;
      };

      //ajax run summary
      document.getElementById("ShowRunSummary").onclick = function() {
        currentstate = 2;
        currentlyediting = false;
        $('#editmodaltext').html(""); //empty the modal just in case
        document.getElementById('help').style.visibility='hidden';
        document.getElementById('Filter').style.visibility='hidden';
        if (usertype >= 2) {
          document.getElementById("EditButton").style.visibility='visible';
        }
        updateTable('','','', currentlyediting);
      };

      document.getElementById("EditButton").onclick = function() {
        if (currentlyediting) {
          var sopts = getsopts();
          var wopts = getwopts();
          if (sopts.length == 0) {
            updateTable('', wopts, oopts, false);
          } else {
            updateTable(sopts,wopts, oopts, false);
          }
          currentlyediting = false;
        } else {
          var sopts = getsopts();
          var wopts = getwopts();
          if (sopts.length == 0) {
            updateTable('', wopts, oopts, true);
          } else {
            updateTable(sopts,wopts,oopts, true);
          }
          currentlyediting = true;
        }
      };
    </script>
  </body>
</html>
