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
                    $sizeError = "";
                    $colorError = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $size = intval($_POST["size"]);
                        $colors = intval($_POST["colors"]);

                        if ($size < 1 || $size > 26) {
                            $sizeError = "Rows and Columns must be between 1 and 26.";
                        }

                        if ($colors < 1 || $colors > 10) {
                            $colorError = "Number of Colors must be between 1 and 10.";
                        }

                        if ($sizeError || $colorError) {
                            echo "<div class='error-box'>";
                            if ($sizeError) echo "<p>$sizeError</p>";
                            if ($colorError) echo "<p>$colorError</p>";
                            echo "</div>";
                        }
                    }
                    ?>

                    <!-- Form -->
                    <form method="post" action="">
                        <label>Rows and Columns (1-26):</label><br>
                        <input type="number" name="size"><br><br>

                        <label>Number of Colors (1-10):</label><br>
                        <input type="number" name="colors"><br><br>

                        <input type="submit" value="Generate Table">
                    </form>

                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !$sizeError && !$colorError) {

                        $colorList = ["Red","Orange","Yellow","Green","Blue","Purple","Grey","Brown","Black","Teal"];

                        echo "<h3>Select Colors</h3>";

                        // Message area
                        echo "<div id='message' style='color:red; margin-bottom:10px;'></div>";

                        echo "<table style='width:90%; border-collapse:collapse;'>";

                        for ($i = 0; $i < $colors; $i++) {

                            echo "<tr>";

                            // LEFT COLUMN (radio + dropdown)
                            echo "<td style='width:20%; padding:5px;'>";

                            $checked = ($i == 0) ? "checked" : "";
                            // Radio button for selected color
                            echo "<input type='radio' name='activeColor' class='activeRadio' $checked>";

                            echo "<select class='colorSelect'>";

                            foreach ($colorList as $index => $color) {
                                $selected = ($index == $i) ? "selected" : "";
                                echo "<option value='$color' $selected>$color</option>";
                            }

                            echo "</select>";
                            echo "</td>";

                            // RIGHT COLUMN (coordinates for selected colors. One row per selected color.)
                            echo "<td class='coordCell' style='width:80%; padding:5px;'></td>";

                            echo "</tr>";
                        }

                        echo "</table>";

                        // GRID
                        echo "<h3>Coordinate Grid</h3>";
                        echo "<table style='table-layout:fixed; border-collapse:collapse;'>";

                        for ($row = 0; $row <= $size; $row++) {

                            echo "<tr>";

                            for ($column = 0; $column <= $size; $column++) {

                                // HEADER CELLS
                                if ($row == 0 || $column == 0) {
                                    echo "<td style='border:1px solid black; text-align:center; width:30px; height:30px;'>";

                                    if ($row == 0 && $column == 0) {
                                        echo "";
                                    } elseif ($row == 0) {
                                        echo chr(64 + $column);
                                    } elseif ($column == 0) {
                                        echo $row;
                                    }

                                    echo "</td>";

                                } else {
                                    // CLICKABLE GRID CELL
                                    $coord = chr(64 + $column) . $row;

                                    echo "<td 
                                            class='gridCell' 
                                            data-coord='$coord'
                                            style='border:1px solid black; text-align:center; width:30px; height:30px; cursor:pointer;'>
                                        </td>";
                                }
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