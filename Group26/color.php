<!DOCTYPE html>

<html>
    <head>
        <link href="style.css" rel="stylesheet">

        <title>
            Palette Perfect Color Page
        </title>
        <link rel="icon" href="/assets/logo icon.png" type="image/png">

        <meta charset="UTF-8">
        <meta name="description" content="T26's Color Page">
        <meta name="keywords" content="Color Picker">
        <meta name="author" content="Mossy Jimmerson, Jack Birlingmair, Elijah Gillit">
    </head>

   <body>
        <div class="boxConstraint">
            <header>
                <div id="banner" class="window">
                    <img src="assets/logo long.png" width=500px alt="Banner Logo Image">
                </div>
                <br>
                <div id="navBar">
                    <nav>
                        <a href="index.php">Home</a>
                        <a href="about.php">About</a>
                        <a href="color.php">Color Coordinator</a>
                    </nav>
                </div>
            </header>

            <div class="mainContentBig">
                <div class="window">
                    <h2>Create Color Grid</h2>

                    <?php
                        // 4.2: Input validation

                        // Possible errors
                        $sizeError = "";
                        $colorError = "";

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            $size = intval($_POST["size"]);
                            $colors = intval($_POST["colors"]);

                            // Validate number of rows, columns
                            if ($size < 1 || $size > 26) {
                                $sizeError = "Rows and Columns must be between 1 and 26.";
                            }

                            // Validate Number of Colors
                            if ($colors < 1 || $colors > 10) {
                                $colorError = "Number of Colors must be between 1 and 10.";
                            }

                            // Show error box if there are errors
                            if ($sizeError || $colorError) {
                                echo "<div class='error-box'>";

                                if ($sizeError) {
                                    echo "<p>$sizeError</p>";
                                }

                                if ($colorError) {
                                    echo "<p>$colorError</p>";
                                }

                                echo "</div>";
                            }
                        }
                        ?>
                        <!-- 4.1: Input Form -->
                        <form method="post" action="">
                            <label for="size">Rows and Columns (1-26):</label><br>
                            <input type="number" id="size" name="size"><br><br>

                            <label for="colors">Number of Colors (1-10):</label><br>
                            <input type="number" id="colors" name="colors" ><br><br>

                            <input type="submit" value="Generate Table">
                        </form>

                        <?php

                        // 4.3: Top Table: Color List
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && !$sizeError && !$colorError) {

                            $colorList = ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey", "Brown", "Black", "Teal"];

                            echo "<h3>Select Colors</h3>";

                            // Space for duplicate warnings
                            echo "<div id='message' style='color: red; margin-bottom: 10px;'></div>";

                            echo "<table style='width: 90%;'>";

                            for ($i = 0; $i < $colors; $i++) {

                                echo "<tr>";

                                // Left column. 20%
                                echo "<td style='width: 20%; padding: 5px;'>";

                                echo "<select class='colorSelect'>";

                                foreach ($colorList as $index => $color) {

                                    // Set unique default selection
                                    $selected = ($index == $i) ? "selected" : "";

                                    echo "<option value='$color' $selected>$color</option>";
                                }

                                echo "</select>";
                                echo "</td>";

                                // Right column. 80% 
                                echo "<td class='preview' style='width: 80%; padding: 5px;'>";
                                echo $colorList[$i];
                                echo "</td>";

                                echo "</tr>";
                            }

                            echo "</table>";

                            // 4.4 Bottom Table: Coordinate Grid. displayed: n+1 rows, n+1 columns. Row labeled with numbers, column letters.
                            echo "<h3>Coordinate Grid</h3>";

                            echo "<table style='table-layout: fixed; border-collapse: collapse;'>";

                            // rows 0 to n
                            for ($row = 0; $row <= $size; $row++) {

                                echo "<tr>";

                                // columns 0 to n
                                for ($column = 0; $column <= $size; $column++) {

                                    echo "<td style='border: 1px solid black; text-align: center; width: 30px; height: 30px;'>";

                                    // Top left corner is empty
                                    if ($row == 0 && $column == 0) {
                                        echo "";

                                    // Top row (A–Z)
                                    } elseif ($row == 0) {
                                        echo chr(64 + $column); //ASCII A=65 

                                    // Left column (1–n)
                                    } elseif ($column == 0) {
                                        echo $row;

                                    // Grid cells all empty for now
                                    } else {
                                        echo "";
                                    }

                                    echo "</td>";
                                }

                                echo "</tr>";
                            }

                            echo "</table>";
                        }
                        ?>
                        <br>
                        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$sizeError && !$colorError): ?>
                            <form method="post" action="print.php" target="_blank">
                                <input type="hidden" name="size" value="<?php echo $size; ?>">
                                <input type="hidden" name="colors" value="<?php echo $colors; ?>">
                                <button type="submit">Print Color Scheme</button>
                            </form>
                        <?php endif; ?>
                </div>
            </div>

            <footer>
                <div class="footer">
                    <h5>Webpage made by Mossy, Jack, & Elijah</h5>
                </div>
            </footer>
        </div> 

        <!-- Script (currently) to check that color choices are unique -->
        <script src="script.js"></script>   
    </body>
</html>