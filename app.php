<?php
    include('session.php');
    include('functions.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>FALL DETECTION SYSTEM</title>
    
    <link rel="stylesheet" href="css/reset.min.css">
    <link rel="stylesheet" href="css/style.php?theme=purple">
    <meta http-equiv="refresh" content="5"> 
    
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript"> 
    function delay(ms){
       var start = new Date().getTime();
       var end = start;
       while(end < start + ms) {
         end = new Date().getTime();
      }
    }
    $(document).ready(function() 
    {
        function functionToLoadFile() 
        {
            jQuery.get('getVariables.php?keywords>refresh=1', function(data) 
            {
                if (data == "1") 
                {
                    document.getElementById('buzzer').play();
                    delay(1000);
                    $(location).attr('href', 'app.php');
                    jQuery.get('setVariables.php?keywords>refresh=0');
                }
                setTimeout(functionToLoadFile, 5000);
            });
        }

        setTimeout(functionToLoadFile, 10);
    });
    </script>

</head>

<body>
    <div class="cta" style="float: right; padding-top: 7px;">
        <span class="button-small">Welcome <?= ucfirst($_SESSION['normal_user']) . " "; ?><em><a href="logout.php">Logout</a></em></span>
    </div>
    <div class="pen-title">
    <h1>FALL DETECTION SYSTEM</h1>
    </div>
    <audio id="buzzer"><source src="beep.ogg" type="audio/ogg"></audio>

    <div class="form-module form-module-extra-medium">
        <ul class="top-menu">
            <li><a class="active" href="app.php">Home</a></li>
        </ul>
        
        <div class="content">
        </div>
        
        <div class="content">
            <h2 class="headings">Movement History</h2>
            <div style="clear: both;"> </div>
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Patient</th>
                    <th>AccMag</th>
                    <th>X</th>
                    <th>Y</th>
                    <th>Z</th>
                    <th>FALL</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Clear</th>
                </tr>
                <?php
                    function table_function_with_primary_key_open_history($key)
                    {
                        echo "<tr>";
                        echo "<td>$key</td>";
                        echo "<td>Sharini</td>";

                        $accelMagnitude = floatval(get_ini_value("accelMagnitude_history", "$key"));
                        echo "<td>$accelMagnitude</td>";  

                        echo "<td>" . get_ini_value("gx_history", "$key") . "</td>";
                        echo "<td>" . get_ini_value("gy_history", "$key") . "</td>";
                        echo "<td>" . get_ini_value("gz_history", "$key") . "</td>";
                        
                        // Calculate fall_status live based on accelMagnitude
                        if ($accelMagnitude >= 0.40) {
                            $fall_status = "Normal";
                            $color = "green";
                        } else {
                            $fall_status = "Alert";
                            $color = "red";
                        }

                        echo "<td style='color: $color; font-weight: bold;'>$fall_status</td>";

                        echo "<td>" . get_ini_value("date_history", "$key") . "</td>";
                        echo "<td>" . get_ini_value("time_history", "$key") . "</td>";
                        echo "<td><a href='deleteVariables.php?return_back=1&return_url=app.php&RECORD=$key'><img src='remove.png'></a></td>";
                        echo "</tr>";
                    }

                    foreach_ini_value("table_function_with_primary_key_open_history", "accelMagnitude_history");
                ?>
            </table>
            <div style="clear: both;"> </div>
            <br/>
        </div>

    <script src='js/jquery.min.js'></script>
    <script src="js/canvas-data.php?hour_1=hour_blood_pulse&hour_2=hour_body_temperature&day_1=day_blood_pulse&day_2=day_body_temperature"></script>
    <script src="js/canvasjs.min.js"></script>

</body>
</html>