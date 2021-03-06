<?php
/*
 * Team Name: FIRE^2 (First Responder Framework Improvement Researchers)
 * Product Name: FIRE-M^2 (First Responder Mission Management)
 * File Name: get_oc_mission_info.php
 *
 * Date Last Modified: November 19, 2018 (Stanislav Babenko)
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
 * This file returns the list of active and completed missions.
 */

require("db.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Set the active MySQL database
$db_selected = mysqli_select_db( $mysqli ,"FIREM2");
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error($mysqli));
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<div class="events">';

//display all active missions
echo '<h2>Active Missions</h2>';

//query to get all active events
$query = "SELECT * FROM mission where isActive = true";

$result = $mysqli->query($query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($mysqli));
}

// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<div class = "eventObject">';

  //gives the event object the name of the event
  echo '<br>';
  echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'
   . parseToXML($row['missionName']) . ' ';
  
  //produces the "open" and "completed?" buttons
  echo '<br>';
  echo '<span class="mission_info_buttons">';
  echo '<button id="myBtn" onclick="openMission(this, ' . $row["missionID"] .
      ',`' . $row["missionName"] . '`)">OPEN</button>';
  echo '&nbsp&nbsp';
  echo '<button id="delBtn" onclick="updateMissionInfo(' . $row["missionID"] .
      ')">COMPLETED?</button>';

  echo '</span>';
  echo '</div>';
}

echo '<br>';

//display all inactive missions
echo '<h2>Completed Missions</h2>';

//query to get all inactive events
$query = "SELECT * FROM mission where isActive = false";

$result = $mysqli->query($query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($mysqli));
}

// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<div class = "eventObject">';
  echo '<br>';
  //gives the event object the name of the event
  echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . parseToXML($row['missionName']) . ' ';
  
  //produces the "open" button
  echo '<br>';
  echo '<span class="mission_info_buttons">';
  echo '<button style="left:190px;" id="myBtn" onclick="openMission(this, ' . $row["missionID"] .
      ',`' . $row["missionName"] . '`)">OPEN</button>';
  echo '</span>';
  echo '</div>';
}

// End XML file
echo '</div>';

?>