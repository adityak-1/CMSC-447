<?php
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
  die ('Can\'t use db : ' . mysqli_error());
}

//select specific event information
$query = "SELECT * FROM mmEvent WHERE eventID = 7";

$result = $mysqli->query($query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($mysqli));
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";

//create div to hold all tables
echo "<div class = 'eventInfo'>";

//create table of general information
echo '<table>';
echo '<tr><th colspan="2">General Information</th></tr>';

//get general information for event
$row = @mysqli_fetch_assoc($result);

//latitude information
echo '<tr>';
echo '<th>Latitude</th>';
echo '<td>' . $row['latitude'] . '</td>';
echo '</tr>';

//longitude information
echo '<tr>';
echo '<th>Longitude</th>';
echo '<td>' . $row['longitude'] . '</td>';
echo '</tr>';

//category information
echo '<tr>';
echo '<th>Category</th>';
echo '<td>' . $row['category'] . '</td>';
echo '</tr>';

//report submission information
echo '<tr>';
echo '<th>Submission Method</th>';
echo '<td>' . $row['submitMethod'] . '</td>';
echo '</tr>';
echo '</table>';

echo '<br>';

//select event state information
$query = "SELECT * FROM eventState WHERE eventID = 7 ORDER BY updateTime DESC";

$result = $mysqli->query($query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($mysqli));
}

//initialize counter
$ind=0;

//create table of state changes
echo '<table>';
echo '<tr><th colspan="2">Changes in State</th></tr>';
echo '<tr>';
echo '<th>Timestamp</th>';
echo '<th>State</th>';
echo '</tr>';

//iterate through each row and add state change to table
while ($row = @mysqli_fetch_assoc($result)){
  echo '<tr>';
  echo '<td>' . $row["updateTime"] . '</td>';
  echo '<td>' . $row["state"] . "</td>";
  echo '</tr>';

  //increment counter
  $ind = $ind + 1;
}

echo '</table>';

echo '<br>';

//select event notes information
$query = "SELECT * FROM eventNote WHERE eventID = 7 ORDER BY createTime DESC";

$result = $mysqli->query($query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($mysqli));
}

//initialize counter
$ind=0;

//create table of state changes
echo '<table>';
echo '<tr><th colspan="2">Written Notes</th></tr>';
echo '<tr>';
echo '<th>Timestamp</th>';
echo '<th>Note</th>';
echo '</tr>';

//iterate through each row and add state change to table
while ($row = @mysqli_fetch_assoc($result)){
  echo '<tr>';
  echo '<td>' . $row["createTime"] . '</td>';
  echo '<td>' . $row["description"] . "</td>";
  echo '</tr>';

  //increment counter
  $ind = $ind + 1;
}

echo '</table>';

// End XML file
echo '</div>';

?>