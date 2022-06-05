<?php
    function displayError($error, $index) {
        $msg = '';
        if(isset($error[$index])) {
            $msg = '<b><span class="error">' . $error[$index] . '</span></b>';
        }
        return $msg;
    }

    function updateForm($data, $index) {
        if(isset($data[$index]) && !empty($data[$index]) && trim($data[$index])) {
            return true;
        } else {
            return false;
        }
    }
?>