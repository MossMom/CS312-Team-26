<!-- colors.php is the new Color Selection page where users can add, edit, and delete colors from the database. Add this page to your site navigation alongside the existing pages. -->
<?php
require 'db.php';
?>

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

    <!-- Script (currently) to check that color choices are unique -->
    <script src="script.js"></script>  
    
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
                    <?php 
                        if ($conn) {
                            echo "<p>DB connected</p>";
                        }
                        else {
                            echo "<p>DB is not connected</p>";
                        }

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

                    <!-- Form -->
                    <form method="post" action="">
                        <label>Rows and Columns (1-26):</label><br>
                        <input type="number" name="size"><br><br>

                        <label>Number of Colors (1-10):</label><br>
                        <input type="number" name="colors"><br><br>

                        <input type="submit" value="Generate Table">
                    </form>

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