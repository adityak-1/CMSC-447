<?php
//verify that file is accessed via OCdash tab
if(!defined('OC_Tab')) {
    //redirect back to correct dashboard
    header("location: profile.php");
}
?>

<div class = "contentPanel create-mission-panel">

<script>
$(document).ready(function() {
    //setInterval(function(){   NO interval
       $.ajax({
           url: "get_resources.php",
           type: "GET",
           dataType: "html",
           success: function(html) {
           $(".resourcesPane").html(html);
        }
      });//end ajax call
    //},1000);//end setInterval
});//end docReady 
</script>

<h2 align="center">Create Mission</h2>
<form id="myform" method="post" action="/teamSix/fireM2/oc_create_mission.php">  

  <!--mission name label-->
  <label align="center" style="z-index:-5;opacity: 0.3;position:relative;left:3.9em;top:30px;
    font-size: 20px;">Mission Name</label>


  <input autofocus maxlength="80" style="display:block;width:80%;margin:auto;" type="text" name="input_mission_name">
 
  

  <!-- Resources objects generated from inside "get_resources.php" 
       and are placed here -->
  <h3 align="center">Resources</h3>
  <div class = "resource-box">
    <div class = "resourcesPane">No Resources Available</div>
  </div>


  <h3 align="center">Assign To Mission Manager</h3>
  <div class="sel_mission_manage">
    Select Mission Manager:
  </div>
    <span class="custom-dropdown" style="margin: -7px 0px 00px 285px;" style="box-shadow: 5px 5px 8px #222222;">
      <select name="input_mission_manager" style="margin: 0px 0px 20px 0px;">
    </span>
<br>
<br>
<script>
$(document).ready(function () {
    $('#myform').on('submit', function(e) {

        //Empty Mission Name Validation Block
        var x = document.forms["myform"]["input_mission_name"].value;
        if (x == "") {
          alert("Mission name must be filled out");
          document.getElementById("myform").reset();
          return false;
        }

        e.preventDefault();
        $.ajax({
            url : $(this).attr('action') || window.location.pathname,
            type: "GET",
            data: $(this).serialize(),
            success: function (data) {
                document.getElementById("myform").reset();
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });

      var resultString = $('form').serialize();
      //prompt(resultString);

      $.ajax({
        type: 'POST',
        url: 'oc_create_mission_submit.php',
        data: {passedInFormData: resultString},
        success: function(html) {
          //alert('oc_create_mission_submit.php called successfully');
          $("#result").html(html);
        }
      });

      $.ajax({
        url: "get_resources.php",
        type: "GET",
        dataType: "html",
        success: function(html) {
        $(".resourcesPane").html(html);
        }
      });//end ajax call

      //location.reload();//fuck it, just refresh the whole thing
    
    });
});
</script>

<?php 
$sql = mysqli_query($mysqli, "SELECT * FROM userAccount WHERE role='MM'");
while ($row = $sql->fetch_assoc()){
echo "<option value=\" " . $row['firstName'] ." ". $row['lastName'] . "\">" . $row['firstName'] ." ". $row['lastName'] .  "</option>";
}
?>
</select>
  <br><br>

  <div class="createMissionbutton" style="width:100%;margin:auto;">
    <input type="submit" name="submit" value="Create" style="margin: -21px 0px 0px -100px;">
  </div>  
</form>
  <div id="result" style="position:absolute;top:-100px;"></div>
</div>