<?php
/*
 * Team Name: FIRE^2 (First Responder Framework Improvement Researchers)
 * Product Name: FIRE-M^2 (First Responder Mission Management)
 * File Name: oc_active_missions.php
 *
 * Date Last Modified: November 14, 2018 (Robert Duguay)
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
 * This file returns the percent completion of all active missions.
 */

require 'db.php';

header('Content-Type: application/json');

//set active MySQL database
$db_selected = mysqli_select_db( $mysqli ,"FIREM2");
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error($mysqli));
}

//query to execute
$query = "select missionName, sum(percent) / count(*) * 100 as totalPercent from (select *, (case when state = 'assigned' then 0 when state = 'on hold' then 0.33 when state = 'in progress' then 0.66 when state = 'completed' then 1 end) as percent from mission natural join mmEvent natural join eventState where (eventID, updateTime) in (select eventID, max(updateTime) from eventState group by eventID) and missionID is not null and isActive = true) as eventPercent group by missionID;";

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);

?>