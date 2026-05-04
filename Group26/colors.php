<!-- colors.php is the new Color Selection page where users can add, edit, and delete colors from the database. Add this page to your site navigation alongside the existing pages. -->
<?php
require 'db.php';
?>

<!DOCTYPE html>

<html>
    <head>
        <link href="style.css" rel="stylesheet">

        <title>
            Palette Perfect Color Selection Page
        </title>
        <link rel="icon" href="/assets/logo icon.png" type="image/png">

        <meta charset="UTF-8">
        <meta name="description" content="T26's Color Selection Page">
        <meta name="keywords" content="Color Selection">
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
                        <a href="colors.php">Color Selection</a>
                    </nav>
                </div>
            </header>

            <div class="mainContentBig">
                <div class="window">
                    <h2>Color Selection</h2>
                    <div class="db">      

                    <table style='border-spacing:10px; margin:10px auto;'> <th>


                    <?php
                    $colorIsPresent = "";
                    $hexIsPresent = "";

                    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM colors");
                    $row = mysqli_fetch_assoc($result);
                    $maxColors = (int)$row['total'];

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['btnSubmit'][0])) {
                            switch (strtolower($_POST['btnSubmit'][0])) {

                                case 'editcolor':
                                    $colorName = mysqli_real_escape_string($conn, strval($_POST["cname"]));
                                    $hexValue  = mysqli_real_escape_string($conn, strval($_POST["hexval"]));
                                    $colorID   = mysqli_real_escape_string($conn, $_POST["colorlist"]);

                                    $color_query = mysqli_query($conn,
                                        "SELECT * FROM colors 
                                        WHERE name = '$colorName' 
                                        AND name != '$colorID'"
                                    );

                                    $hex_query = mysqli_query($conn,
                                        "SELECT * FROM colors 
                                        WHERE hex_value = '$hexValue' 
                                        AND name != '$colorID'"
                                    );

                                    if (!preg_match('/^[A-Fa-f0-9]{6}$/', $hexValue)) {
                                        $hexIsPresent = "Hex value must be exactly 6 valid hex characters.";
                                    }
                                    else if (mysqli_num_rows($color_query) > 0) {
                                        $colorIsPresent = "Color name already exists in database. Choose another name.";
                                    }
                                    else if (mysqli_num_rows($hex_query) > 0) {
                                        $hexIsPresent = "Hex value already exists in database. Choose another hex value.";
                                    }

                                    if ($colorIsPresent || $hexIsPresent) {
                                        echo "<div class='error-box'>";
                                        if ($colorIsPresent) echo "<p>$colorIsPresent</p>";
                                        if ($hexIsPresent) echo "<p>$hexIsPresent</p>";
                                        echo "</div>";
                                    } else {
                                        mysqli_query($conn,
                                            "UPDATE colors 
                                            SET name = '$colorName', hex_value = '$hexValue' 
                                            WHERE name = '$colorID'"
                                        );
                                    }
                                    break;

                                case 'addcolor':
                                    $colorName = mysqli_real_escape_string($conn, strval($_POST["cname"]));
                                    $hexValue  = mysqli_real_escape_string($conn, strval($_POST["hexval"]));

                                    $color_query = mysqli_query($conn,
                                        "SELECT * FROM colors WHERE name = '$colorName'"
                                    );

                                    $hex_query = mysqli_query($conn,
                                        "SELECT * FROM colors WHERE hex_value = '$hexValue'"
                                    );

                                    if (!preg_match('/^[A-Fa-f0-9]{6}$/', $hexValue)) {
                                        $hexIsPresent = "Hex value must be exactly 6 valid hex characters.";
                                    }
                                    else if (mysqli_num_rows($color_query) > 0) {
                                        $colorIsPresent = "Color name already exists in database. Choose another name.";
                                    }
                                    else if (mysqli_num_rows($hex_query) > 0) {
                                        $hexIsPresent = "Hex value already exists in database. Choose another hex value.";
                                    }

                                    if ($colorIsPresent || $hexIsPresent) {
                                        echo "<div class='error-box'>";
                                        if ($colorIsPresent) echo "<p>$colorIsPresent</p>";
                                        if ($hexIsPresent) echo "<p>$hexIsPresent</p>";
                                        echo "</div>";
                                    } else {
                                        mysqli_query($conn,
                                            "INSERT INTO colors (name, hex_value) 
                                            VALUES('$colorName', '$hexValue')"
                                        );
                                    }
                                    break;

                                case 'deletecolor':
                                    if (isset($_POST['deleteCheck'])) {

                                        $colorID = mysqli_real_escape_string($conn, $_POST["colorlist"]);

                                        mysqli_query($conn,
                                            "DELETE FROM colors WHERE name = '$colorID'"
                                        );
                                    }
                                    break;
                            }
                        }
                    }
                    ?>
                    
                    <!-- Form -->
                    <form method="post" action="">
                        <label>Rows and Columns (1-26):</label><br>
                        <input type="number" name="size"><br><br>

                        <label>Number of Colors (1-<?php echo $maxColors; ?>):</label><br>
                        <input type="number" name="colors" max="<?php echo $maxColors; ?>"><br><br>

                        <input type="submit" value="Generate Table">
                    </form>

                    <!-- Edit color values -->
                    <form method="post" action = "">
                        <label for ="sel_color">Select a Color:</label><br>
                        <?php
                            $current_colors = mysqli_query($conn, "SELECT * FROM colors;");
                            echo "<select name='colorlist'>";
                            if (mysqli_num_rows($current_colors) > 0) {
                                while($row = mysqli_fetch_assoc($current_colors)) {
                                   echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                                }
                            }
                            echo "</select><br><br>";
                        ?>

                        <label for="cname">Edit color name:</label><br>
                        <input type="text" name="cname"><br>
                        <label for="hexval">Edit hex value (6 letters or digits):</label><br>
                        <input type="text" name="hexval"><br><br>

                        <button class="changeColor" name="btnSubmit[]" value="editcolor">Change color values</button>
                    </form> </th>

                    <!--  Add color values -->
                    <th>
                    <form method="post" action = "">
                        <label>Add a new color</label><br><br>
                        <label for="cname">Color name:</label><br>
                        <input type="text" name="cname"><br>
                        <label for="hexval">Hex value (6 letters or digits):</label><br>
                        <input type="text" name="hexval"><br><br>

                        <button class="addColor" name="btnSubmit[]" value="addcolor">Add color</button>
                    </form> </th>

                    <!--  Delete color values -->
                    <th>
                    <form method="post" action = "">
                        <label for ="sel_color">Delete a Color:</label><br>
                        <?php
                            $current_colors = mysqli_query($conn, "SELECT * FROM colors;");
                            if (mysqli_num_rows($current_colors) > 2) {
                                echo "<select name='colorlist'>";
                                while($row = mysqli_fetch_assoc($current_colors)) {
                                    echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                                }
                                echo "</select><br><br><button id='deleteColorBtn' name='btnSubmit[]' value='deletecolor'>Delete color</button><br> <input type='checkbox' id='deleteConfirmation' name='deleteCheck' value='DELETE'><label for='deleteConfirmation'> ARE YOU SURE? </label>";
                            }
                            else {
                                echo "<p> Cannot delete a color if there are only 2 colors left. Please add more colors if you want to remove one.</p>";
                            }
                        ?>
                    </form> 
                </th>
             </table>

                    <!-- Display the table of colors -->
                    <?php
                        $current_colors = mysqli_query($conn, "SELECT * FROM colors;");
                        echo "<table style='border-spacing:10px; margin:10px auto;'> <tr><th style='width:15%;'>Color Name</th> <th style='width:15%;'>Hexcode</th> <th style='width:15%;'>Sample color</th></tr>";
                        if (mysqli_num_rows($current_colors) > 0) {
                            while($row = mysqli_fetch_assoc($current_colors)) {
                                echo "<tr>";
                                echo "<td>" . $row["name"]. "</td> <td>#" . $row["hex_value"]. "</td> <td style ='background:#" . $row["hex_value"] . "'></td> ";
                                echo "</tr>";
                            }
                        }
                        else {
                            echo "0 results";
                        }
                        echo "</table>"
                    ?>
                    <br>
                </div>
                </div>
            </div>

            <footer>
                <div class="footer">
                    <h5>Webpage made by Mossy, Jack, & Elijah</h5>
                </div>
            </footer>
        </div>  
    </body>
</html>