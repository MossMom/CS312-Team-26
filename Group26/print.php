<!DOCTYPE html>

<?php
$size = intval($_POST["size"]);
$colors = intval($_POST["colors"]);

$colorList = ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey", "Brown", "Black", "Teal"];
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
        <img src="assets/logo long.png" width=500px class="grayscale" alt="Banner Logo Image">
    </head>

    <body onload="window.print()">

        <h2>Color Grid</h2>

        <!-- Color Selection Table -->
        <h3>Select Colors</h3>
        <table style="width: 90%;">
            <?php
            for ($i = 0; $i < $colors; $i++) {
                echo "<tr>";
                echo "<td style='width: 20%;'>" . $colorList[$i] . "</td>";
                echo "<td style='width: 80%;'>" . $colorList[$i] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <!-- Coordinate Grid -->
        <h3>Coordinate Grid</h3>
        <table style='table-layout: fixed; border-collapse: collapse;'>
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