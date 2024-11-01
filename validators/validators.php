<?php

function dateValidator($birthdate)
{
    if (empty($birthdate)) {
        return 'Please submit your date of birth.';
    } elseif (!preg_match('~^([0-9]{2})/([0-9]{2})/([0-9]{4})$~', $birthdate, $parts)) {
        return 'Please return a date in the format MM/DD/YYYY.';
    } elseif (!checkdate($parts[1], $parts[2], $parts[3])) {
        return 'The date of birth is invalid.';
    } else return true;
}

function ageLimitValidator($birthdate)
{
    $age =  new DateTime($birthdate);
    $lowerLimit = new DateInterval('P120Y');
    $maxDobLimit = (new DateTime())->sub($lowerLimit);

    if ($age <= $maxDobLimit) {
        return 'Really! Are you still alive?';
    } else return true;
}

function imageValidator($mediaType, $allowedImageFormats, $image)
{
    $maxImageSize = 2 * 1024 * 1024;

    if (!in_array($mediaType, $allowedImageFormats)) {
        return "Invalid image format.";
    }

    if ($image['size'] > $maxImageSize) {
        return "Image size exceeds the 2MB limit.";
    }

    return true;
}

function isValidDecimal($value)
{
    if (is_numeric($value)) {
        return preg_match('/^\d{1,8}(\.\d{1,2})?$/', $value);
    }
    return false;
}
