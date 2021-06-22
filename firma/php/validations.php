<?php
$form_valid = true;
$_SESSION['form_validation'] = array();

function validate_name($new_name, $input_name)
{
    if ((strlen($new_name) < 2)) {
        array_push($_SESSION['form_validation'], $input_name);
        echo "error<br>";
    } else {
        $new_name = mb_strtolower($new_name);
        $new_name = ucwords($new_name);
        if (!preg_match("/^[A-Za-zęółśążźćńĘÓŁŚĄŻŹĆŃ]+$/", $new_name)) {
            array_push($_SESSION['form_validation'], $input_name);
        }
    }
}

function validate_space_name($new_space_name, $input_name)
{
    if ((strlen($new_space_name) < 2)) {
        array_push($_SESSION['form_validation'], $input_name);
    } else {
        $new_space_name = mb_strtolower($new_space_name);
        $new_space_name = ucwords($new_space_name);
        if (!preg_match("/^[A-Za-z ęółśążźćńĘÓŁŚĄŻŹĆŃ]+$/", $new_space_name)) {
            array_push($_SESSION['form_validation'], $input_name);
        }
    }
}

function validate_postal_code($new_postal_code, $input_name)
{
    if ((strlen($new_postal_code) != 6)) {
        array_push($_SESSION['form_validation'], $input_name);
    } else {
        if (!preg_match("/^[0-9]{2}(?:-[0-9]{3})?$/", $new_postal_code)) {
            array_push($_SESSION['form_validation'], $input_name);
        }
    }
}

function validate_address($new_address, $input_name)
{
    if ((strlen($new_address) < 2)) {
        array_push($_SESSION['form_validation'], $input_name);
    } else {
        $new_address = mb_strtolower($new_address);
        $new_address = ucwords($new_address);
        if (!preg_match('/^[A-Za-zęółśążźćńĘÓŁŚĄŻŹĆŃ ]+\s+[0-9]/', $new_address)) {
            array_push($_SESSION['form_validation'], $input_name);
        }
    }
}


function validate_apartment($new_apartment, $input_name)
{
    $new_apartment = mb_strtolower($new_apartment);
    $new_apartment = ucwords($new_apartment);
    if (preg_match("#[\W]+[ ]+#", $new_apartment)) {
        array_push($_SESSION['form_validation'], $input_name);
    }
}

function validate_number($new_number, $input_name, $length)
{
    if ((strlen($new_number) != $length)) {
        array_push($_SESSION['form_validation'], $input_name);
    } else {
        if (!preg_match("#[0-9]+#", $new_number)) {
            array_push($_SESSION['form_validation'], $input_name);
        }
    }
}

function validate_value_min($new_value, $input_name, $limit)
{
    if ($new_value < $limit) {
        array_push($_SESSION['form_validation'], $input_name);
    }
}

function validate_value_max($new_value, $input_name, $limit)
{
    if ($new_value > $limit) {
        array_push($_SESSION['form_validation'], $input_name);
    }
}

function validate_email($new_email, $input_name)
{
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        array_push($_SESSION['form_validation'], $input_name);
    }
}

function validate_status($new_status, $input_name)
{
    if ($new_status != "0" && $new_status != "1") {
        array_push($_SESSION['form_validation'], $input_name);
    }
}

function validate_date($new_date, $input_name)
{
    if ((strlen($new_date) < 10)) {
        array_push($_SESSION['form_validation'], $input_name);
    } else {
        $date_list = explode("-", $new_date);
        if (!checkdate($date_list[1], $date_list[2], $date_list[0])) {
            array_push($_SESSION['form_validation'], $input_name);
        }
    }
}

function validate_similar($new_value, $similar, $input_name)
{
    $similarity = false;
    foreach ($similar as $value) {
        if ($new_value == $value) {
            $similarity = true;
        }
    }
    if ($similarity == false) {
        array_push($_SESSION['form_validation'], $input_name);
    }
}

function validate_password($new_password, $input_name)
{
    if ((strlen($new_password) < 8)) {
        array_push($_SESSION['form_validation'], $input_name);
    } else {
        if (!preg_match("#[0-9]+#", $new_password)) {
            array_push($_SESSION['form_validation'], $input_name);
        } elseif (!preg_match("#[A-Z]+#", $new_password)) {
            array_push($_SESSION['form_validation'], $input_name);
        } elseif (!preg_match("#[a-z]+#", $new_password)) {
            array_push($_SESSION['form_validation'], $input_name);
        } elseif (!preg_match("#[\W]+#", $new_password)) {
            array_push($_SESSION['form_validation'], $input_name);
        }
    }
}

function validate_checkbox($new_checkbox, $input_name)
{
    if (empty($new_checkbox)) {
        array_push($_SESSION['form_validation'], $input_name);
    }
}

function validate_form($location)
{
    $count = count($_SESSION["form_validation"]);
    echo "Errors: " . $count . "<br>";
    if ($count > 0) {
        $_SESSION["form_validation"] = array_unique($_SESSION["form_validation"]);
        $_SESSION["form_valid_info"] = "Podano nieprawidłowe wartości.";
        header("location: ../$location");
        exit();
    }
}
