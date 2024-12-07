<?php 
        $host = 'localhost';
        $user = 'uzs5ust30l2cr';
        $password = '32;1*Qu@qh`S';
        $dbname = 'dbbgsnjlxnbvya';

        $conn = new mysqli($host, $user, $password, $dbname);
        if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM People WHERE on_campus = 1";
        $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
        <head>
                <meta charset="UTF-8">
                <link rel= "stylesheet" href="style.css">
                <style type="text/css">
                        h1 {
                                text-align: center;
                                color: #3172AE;
                        }
                </style>
        </head>
        <body>
                <nav>
                        <div class="logo">
                            <a href="index.html"><img src="Logo.png" alt="Logo"></a>
                        </div>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li>
                                <a href="#" class="dropdown">About</a>
                                <ul>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="testimony.html">Testimonials</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown">Database</a>
                                <ul>
                                    <li><a href="directory1.php">On-Campus</a></li>
                                    <li><a href="directory2.php">Off-Campus</a></li>
                                </ul>
                            </li>
                            <li><a href="quiz.html">Survey</a></li>
                        </ul>
                    </nav>
                <div class="main-content">
                <h1>On Campus Directory</h1>
                    <div class="result-container">
                        <?php 
                            if ($result->num_rows >0) {
                                        while ($row = $result->fetch_assoc()) {
                                                echo "<div class='person'>";
                                                echo "<img src='" . $row['img'] . "' alt='Photo of " . $row['name'] . "'>";
                                                echo "<h3>" . $row['name'] . "</h3>";
                                                echo "Hometown: " . $row['hometown'] . "<br>";
                                                echo "Major: " . $row['major'] . "<br>";
                                                echo "Gender: " . $row['gender'] . "<br>";
                                                echo "Cleanliness: " . $row['cleanliness'] . "/10<br>";
                                                echo "Wakeup: " . $row['wakeup'] . "<br>";
                                                echo "Bedtime: " . $row['bedtime'] . "<br>";
                                                echo "Smoker: " . ($row['smoker'] ? "Yes" : "No");
                                                echo "</div>";
                                        }
                            }
                        ?>
                    </div>
                </div>
                <footer>
                        <div class="left-footer">
                            <img src="Logo.png" alt="Logo">
                            <p style="padding-top: 35px;">&copy; 2024 JumboMate. All Rights Reserved.</p>
                        </div>
                        <div class="right-footer">
                            <a href= "index.html">Home</a>
                            <a href= "about.html">About Us</a>
                            <a href= "contact.html">Contact</a>
                            <a href= "quiz.html">Quiz</a>
                        </div>
                    </footer>
        </body>
</html>
<?php
    $conn->close();
?>