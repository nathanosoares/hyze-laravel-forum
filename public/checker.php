<?php

header('Content-Type: application/json');

if (!function_exists('getDirContents')) {
    function getDirContents($path, &$results = [])
    {
        $files = scandir($path);

        foreach ($files as $key => $value) {

            $path_ = $path . DIRECTORY_SEPARATOR . $value;

            if (!is_dir($path_)) {
                $results[] = $path_;
            } else if ($value != '.' && $value != '..' && is_dir($path_)) {
                getDirContents($path_, $results);
            }
        }

        return $results;
    }
}

$output = [];

foreach (getDirContents('.') as $result) {
    $output[$result] = sha1_file($result);
}

echo json_encode($output);