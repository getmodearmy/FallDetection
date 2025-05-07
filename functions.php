<?php
// functions.php

function get_ini_value($section, $key) {
    // Load the INI file with sections
    $data = parse_ini_file('data.ini', true);

    // Check if the section and key exist
    if (isset($data[$section][$key])) {
        return $data[$section][$key];
    }

    return ''; // Return empty if not found
}

function foreach_ini_value($callback, $section) {
    // Load the INI file with sections
    $data = parse_ini_file('data.ini', true);

    // Check if section exists
    if (!isset($data[$section])) {
        return;
    }

    // Loop through each key in the section and call the callback function
    foreach ($data[$section] as $key => $value) {
        $callback($key);
    }
}
?>
