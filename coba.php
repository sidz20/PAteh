<?php

// PHP function to read CSV to array
function csvToArray($csv)
{
    // create file handle to read CSV file
    $csvToRead = fopen($csv, 'r');

    // read CSV file using comma as delimiter
    while (! feof($csvToRead)) {
        $csvArray[] = fgetcsv($csvToRead, 1000, ',');
    }

    fclose($csvToRead);
    return $csvArray;
}

// CSV file to read into an Array
$csvFile = 'csv-to-read.csv';
$csvArray = csvToArray($csvFile);

echo '<pre>';
print_r($csvArray);
echo '</pre>';
?>