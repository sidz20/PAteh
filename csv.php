<?php

// Specify the path to your CSV file
$csvFile = 'C:\xampp\htdocs\PAteh\hasil_prediksi_endpoint.xlsx';

// Open the CSV file
$fileHandle = fopen($csvFile, 'r');

// Initialize an empty array to store the data
$data = [855, 304, 299, 417, 810, 349];

// Read the file line by line
while (($row = fgetcsv($fileHandle)) !== false) {
    // Add the current row to the data array
    $data[] = $row;
}

// Close the file
fclose($fileHandle);

// Print the resulting array
print_r($data);
?>


