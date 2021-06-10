<?php

require_once(__DIR__."/../header.inc.php");

function q_error_popup($message) {
    echo '
        <link rel="stylesheet" href="'.__DIR__.'/../../css/popup.css"/>
        <div class="error-alert">
          <span class="close-alert-button" onclick="this.parentElement.style.display=\'none\';">&times;</span>
          <strong>Error!</strong> ', $message,'
        </div>';
}

function q_info_popup($message) {
    echo '
        <link rel="stylesheet" href="'.__DIR__.'/../../css/popup.css"/>
        <div class="info-alert">
          <span class="close-alert-button" onclick="this.parentElement.style.display=\'none\';">&times;</span>
          <strong>Info!</strong> ', $message,'
        </div>';
}

function q_warn_popup($message) {
    echo '
        <link rel="stylesheet" href="'.__DIR__.'/../../css/popup.css"/>
        <div class="warn-alert">
          <span class="close-alert-button" onclick="this.parentElement.style.display=\'none\';">&times;</span>
          <strong>Warning!</strong> ', $message,'
        </div>';
}

function q_success_popup($message) {
    echo '
        <link rel="stylesheet" href="'.__DIR__.'/../../css/popup.css"/>
        <div class="success-alert">
          <span class="close-alert-button" onclick="this.parentElement.style.display=\'none\';">&times;</span>
          <strong>Success!</strong> ', $message,'
        </div>';
}

function q_custom_popup($params) {
    if (isset($params["cus_r"]) and isset($params["cus_g"]) and isset($params["cus_b"]) and isset($params["cus_strong"]) and isset($params["cus_message"])) {

        // Get RGB

        $r = $params["cus_r"];
        $g = $params["cus_g"];
        $b = $params["cus_b"];

        // Validate RGB

        $rgb["r"] = $r;
        $rgb["g"] = $g;
        $rgb["b"] = $b;

        if (!(is_rgb($rgb))) { q_error_popup("cus_r, cus_g and cus_b must form valid rgb; e.g cus_r=255&cus_g=255&cus_b=255"); exit();}

        // Correct unwanted vals
        $strong = $params["cus_strong"];
        if ($strong == "null") { $strong=""; }
        $message = $params["cus_message"];
        if ($message == "null") { $message=""; }

        // Export using custom values

        echo '
        <link rel="stylesheet" href="'.__DIR__.'/../../css/popup.css"/>
        <style>
            .custom-alert {
                padding: 20px;
                background-color: rgb(', $r, ', ', $g, ', ', $b, '); 
                color: white;
                width: 300px;
                float: center;
                margin: 10px auto;
            }
        </style>
        <div class="custom-alert">
            <span class="close-alert-button" onclick="this.parentElement.style.display=\'none\';">&times;</span>
            <strong>', $strong, '</strong> ', $message,'
        </div>';

    }
    else {
        q_error_popup("Make sure all of required parameters exist: 'cus_r', 'cus_g', 'cus_b', 'cus_strong', 'cus_message'");
    }
}

function q_custom_popup_make($r, $g, $b, $strong, $message) {
    $alert["cus_r"] = strval($r);
    $alert["cus_g"] = strval($g);
    $alert["cus_b"] = strval($b);
    $alert["cus_strong"] = strval($strong);
    $alert["cus_message"] = strval($message);
    q_custom_popup($alert);
}