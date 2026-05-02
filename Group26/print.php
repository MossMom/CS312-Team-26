<!DOCTYPE html>

<?php

$size = intval($_POST["size"]);
$colors = intval($_POST["colors"]);

$gridData = json_decode($_POST["gridData"], true);

$grouped = [];

if (!empty($_POST["gridData"])) {

    $gridData = json_decode($_POST["gridData"], true);

    if (is_array($gridData)) {
        foreach ($gridData as $coord => $data) {

            // safety check (IMPORTANT)
            if (!isset($data["color"])) continue;

            $color = $data["color"];

            if (!isset($grouped[$color])) {
                $grouped[$color] = [];
            }

            $grouped[$color][] = $coord;
        }
    }
}

$colorHex = [
    "Red" => "#FF0000",
    "Orange" => "#FFA500",
    "Yellow" => "#FFFF00",
    "Green" => "#008000",
    "Blue" => "#0000FF",
    "Purple" => "#800080",
    "Grey" => "#808080",
    "Brown" => "#A52A2A",
    "Black" => "#000000",
    "Teal" => "#008080"
];
?>

<html>
    <head>
        <link href="print style.css" rel="stylesheet">
        <title>
            Print Color Grid
        </title>
        <style>
        @media print {
            button { display: none; }
            table { border-collapse: collapse; width: 100%; }
            td { border: 1px solid black; text-align: center; padding: 5px; }
        }
        </style>
        <img src="assets/logo long.png" width=350px class="grayscale" alt="Banner Logo Image">
    </head>

    <body onload="window.print()">

        <h2>Color Grid</h2>

        <!-- Color Selection Table -->
        <h3>Select Colors</h3>

        <table style="width: 90%;">
            <?php
            foreach ($grouped as $color => $coords) {

                $hex = $colorHex[$color] ?? "";

                sort($coords);

                echo "<tr>";

                // LEFT: Color + HEX
                echo "<td style='width: 20%;'>";
                echo "$color — $hex";
                echo "</td>";

                // RIGHT: coordinate list
                echo "<td style='width: 80%;'>";
                echo implode(", ", $coords);
                echo "</td>";

                echo "</tr>";
            }
            ?>
        </table>

        <!-- Coordinate Grid -->
        <h3>Coordinate Grid</h3>
        <table class="grid" style="table-layout: fixed; border-collapse: collapse;">
            <?php
            for ($row = 0; $row <= $size; $row++) {
                echo "<tr>";

                for ($column = 0; $column <= $size; $column++) {
                    echo "<td style='border: 1px solid black; text-align: center; width: 30px; height: 30px;'>";

                    if ($row == 0 && $column == 0) {
                        echo "";
                    } elseif ($row == 0) {
                        echo chr(64 + $column);
                    } elseif ($column == 0) {
                        echo $row;
                    }

                    echo "</td>";
                }

                echo "</tr>";
            }
            ?>
        </table>
    </body>
</html>