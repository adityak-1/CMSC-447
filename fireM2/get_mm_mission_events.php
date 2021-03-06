<?php
/*
 * Team Name: FIRE^2 (First Responder Framework Improvement Researchers)
 * Product Name: FIRE-M^2 (First Responder Mission Management)
 * File Name: get_mm_mission_events.php
 *
 * Date Last Modified: November 20, 2018 (Stanislav Babenko)
 *
 * Copyright: (c) 2018 by FIRE^2
 * and all corresponding participants which include:
 * Aditya Kaliappan
 * Lorenzo Neil
 * Robert Duguay
 * Stanislav Babenko
 * Daniel Volinski
 *
 * File Description:
 * This file returns the events in the selected mission, the current
 * state, as well as toggles to alternative states, all in tabular
 * format.
 */

require("db.php");

// Set the active MySQL database
$db_selected = mysqli_select_db( $mysqli ,"FIREM2");
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error($mysqli));
}

//select events in mission
$query = "SELECT * FROM mmEvent natural join eventState " .
    "WHERE (eventID, updateTime) in (SELECT eventID, max(updateTime) ".
    "from eventState group by eventID) and missionID = " . $_GET['missionID'];

$result = $mysqli->query($query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($mysqli));
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo "<div>";

//create div to hold table
echo "<div class = 'tableInfo'>";

//create table of general information
echo '<h2>Change Event State</h2>';
echo '<table id = "changeEventStateTable">';
echo '<col style="width:40%">';
echo '<col style="width:15%">';
echo '<col style="width:15%">';
echo '<col style="width:15%">';
echo '<col style="width:15%">';
echo '<tr>';
echo '<th></th>';
echo '<th>Current State</th>';
echo '<th>On Hold</th>';
echo '<th>In Progress</th>';
echo '<th>Completed</th>';

// Iterate through the rows
while ($row = @mysqli_fetch_assoc($result)){
  //add new event
  echo '<tr data-value=' . $row["eventID"] . '>';
  //add event name
  echo '<td><a href="javascript:openEvent(' . $row["eventID"] . ',`' .
      $row["eventName"] . '`, true, false)">';
  echo $row["eventName"];
  echo '</a></td>';
    
  //add current state
  echo '<td>' . $row["state"] . '</td>';
    
  //add checkbox for on hold state
  echo '<td><input type="checkbox" name="stateRow" onChange="updateStateRow(this)" value="on hold"';

  if($row["state"] != 'assigned'){
    echo ' disabled';
  }

  echo '></td>';
  
  //add checkbox for in progress state
  echo '<td><input type="checkbox" name="stateRow" onChange="updateStateRow(this)" value="in progress"';
  
  if($row["state"] != 'assigned' && $row["state"] != 'on hold'){
    echo ' disabled';
  }

  echo '></td>';

  //add checkbox for completed state
  echo '<td><input type="checkbox" name="stateRow" onChange="updateStateRow(this)" value="completed"';
      
  if($row["state"] != 'in progress'){
    echo ' disabled';
  }

  echo '></td>';

  echo '</tr>';
}

echo '</table>';
echo '</div>';

//add update button
echo '<button id="myBtn" onclick="updateMissionEvents()">UPDATE</button>';

//add refresh button
echo '<button style="left:400px;" id="myBtn" onclick="refreshMissionEvents()">REFRESH</button>';

// End XML file
echo '</div>';

?>