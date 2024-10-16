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
    $allowed_image_formats = [
        "image/jpeg" => ".jpg",
        "image/webp" => ".webp",
        "image/avif" => ".avif",
        "image/png" => ".png"
    ];

    $max_image_size = 2 * 1024 * 1024;

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $media_type = $finfo->file($image['tmp_name']);

    if (!array_key_exists($media_type, $allowed_image_formats)) {
        return "Invalid image format.";
    }

    if ($image['size'] > $max_image_size) {
        return "Image size exceeds the 2MB limit.";
    }

    return true;
}
