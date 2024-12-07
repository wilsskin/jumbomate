<!DOCTYPE html>
<html>
        <head>
                <meta charset="UTF-8">
                <link rel= "stylesheet" href="style.css">
                <style type="text/css">
                        h1{
                                text-align: center;
                        }
                </style>
        </head>
        <body>
            <?php
                $server = "localhost";
                $userid = "uhre7kvsp1iov"; // your user id
                $pw = "Armann5467!"; // your pw
                $db= "dbxzmlalr1kjuk"; // your database

                $conn = new mysqli($server, $userid, $pw);
                //Check connection
                if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }
                echo "Connected successfully<br>";
                $conn->select_db($db);

                // Query to fetch items from the database
                $sql = "SELECT id, name, hometown, major, gender, cleanliness, wakeup, bedtime, smoker, number, image, on_campus FROM roommates WHERE on_campus = 0";
                $result = $conn->query($sql);
            ?>
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
                                    <li><a href="directory1.html">On-Campus</a></li>
                                    <li><a href="directory2.html">Off-Campus</a></li>
                                </ul>
                            </li>
                            <li><a href="quiz.html">Survey</a></li>
                        </ul>
                </nav>
                <div class="main-content">
                <h1> Off Campus Directory</h1>
                <div class="result-container">
                        <?php
                        if ($result->num_rows > 0) {
                            // Output each row from the database
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='person'>";
                                echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Photo of " . htmlspecialchars($row['name']) . "'>";
                                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                                echo "Hometown: " . htmlspecialchars($row['hometown']) . "<br>";
                                echo "Major: " . htmlspecialchars($row['major']) . "<br>";
                                echo "Gender: " . htmlspecialchars($row['gender']) . "<br>";
                                echo "Cleanliness: " . htmlspecialchars($row['cleanliness']) . "/10<br>";
                                echo "Wakeup: " . htmlspecialchars($row['wakeup']) . "<br>";
                                echo "Bedtime: " . htmlspecialchars($row['bedtime']) . "<br>";
                                echo "Smoker: " . ($row['smoker'] ? "Yes" : "No") . "<br>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No records found.</p>";
                        }
                        $conn->close();
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