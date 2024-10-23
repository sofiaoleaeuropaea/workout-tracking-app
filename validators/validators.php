<?php

function dateValidator($birthdate)
{
    $dateParts = explode('-', $birthdate);

    if (count($dateParts) == 3) {
        $year = (int)$dateParts[0];
        $month = (int)$dateParts[1];
        $day = (int)$dateParts[2];

        if (checkdate($month, $day, $year)) {
            return true;
        } else {
            return "Please, enter a valid birthdate.";
        }
    } else {
        return "Please, enter a valid birthdate.";
    }
}

function imageValidator($image)
{
    $allowedImageFormats = [
        "image/jpeg" => ".jpg",
        "image/webp" => ".webp",
        "image/avif" => ".avif",
        "image/png" => ".png"
    ];

    $maxImageSize = 2 * 1024 * 1024;

    $fileInfo = new finfo(FILEINFO_MIME_TYPE);
    $mediaType = $fileInfo->file($image['tmp_name']);

    if (!array_key_exists($mediaType, $allowedImageFormats)) {
        return "Invalid image format.";
    }

    if ($image['size'] > $maxImageSize) {
        return "Image size exceeds the 2MB limit.";
    }

    return true;
}
