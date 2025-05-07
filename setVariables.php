<?php
// Example URL format:
// setVariables.php?gx=123&gy=456&gz=789&accelMag=0.35&date=2025-05-06&time=12:34:56

$ini_file = 'data.ini';

// Get all values from query string
$gx = $_GET['gx'] ?? null;
$gy = $_GET['gy'] ?? null;
$gz = $_GET['gz'] ?? null;
$accelMag = $_GET['accelMag'] ?? null;
$date = $_GET['date'] ?? date('Y-m-d');
$time = $_GET['time'] ?? date('H:i:s');

// Load existing data
$data = parse_ini_file($ini_file, true);

// Generate new key index
$next_index = 0;
if (isset($data['accelMagnitude_history'])) {
    $keys = array_keys($data['accelMagnitude_history']);
    $next_index = count($keys);
}

// Append new values
$data['accelMagnitude_history'][$next_index] = $accelMag;
$data['gx_history'][$next_index] = $gx;
$data['gy_history'][$next_index] = $gy;
$data['gz_history'][$next_index] = $gz;
$data['date_history'][$next_index] = $date;
$data['time_history'][$next_index] = $time;

// Convert array back to INI string
function array_to_ini($assoc_arr) {
    $content = '';
    foreach ($assoc_arr as $section => $values) {
        $content .= "[$section]\n";
        foreach ($values as $key => $val) {
            $content .= "$key = $val\n";
        }
        $content .= "\n";
    }
    return $content;
}

// Save updated data
file_put_contents($ini_file, array_to_ini($data));

echo "Data saved successfully.";
?>
