<?php
// Number of codes to generate
$totalCodes = 1000;
$length = 16;

// Use an array to ensure uniqueness
$codes = [];

while (count($codes) < $totalCodes) {
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        // First digit must be 1–9 (no leading 0)
        if ($i === 0) {
            $code .= mt_rand(1, 9);
        }
        // Last digit must be 1–9 (no trailing 0)
        elseif ($i === $length - 1) {
            $code .= mt_rand(1, 9);
        }
        // Middle digits can be 0–9
        else {
            $code .= mt_rand(0, 9);
        }
    }

    // Add only if unique
    $codes[$code] = true;
}

// Open CSV file for writing
$file = fopen("unique_codes.csv", "w");

foreach (array_keys($codes) as $code) {
    // Force text type in Excel by wrapping in ="..."
    fputcsv($file, ['="' . $code . '"']);
}

fclose($file);

echo "CSV file 'unique_codes.csv' created with $totalCodes unique codes.\n";
?>