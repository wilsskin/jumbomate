<?php 
        $host = 'localhost';
        $user = 'uzs5ust30l2cr';
        $password = '32;1*Qu@qh`S';
        $dbname = 'dbbgsnjlxnbvya';

        $conn = new mysqli($host, $user, $password, $dbname);
        if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        function timeDiff($t1, $t2) {
                $h1 = (int)explode(":", $t1)[0];
                $m1 = (int)explode(":", $t1)[1];
                $h2 = (int)explode(":", $t2)[0];
                $m2 = (int)explode(":", $t2)[1];
                $minuteDiff = abs($h1 * 60 + $m1 - ($h2 * 60 + $m2));
                if ($minuteDiff > 720) {
                    $minuteDiff = 1440 - $minuteDiff;
                }
                return $minuteDiff / 60;
        }
        function calculateCompatibility($user, $person) {
                $score = 100;
                $wakeupDiff = timeDiff($user['wakeup'], $person['wakeup']);
                $bedtimeDiff = timeDiff($user['bedtime'], $person['bedtime']);
                $cleanDiff = abs($user['cleanliness'] - $person['cleanliness']);
                if ($wakeupDiff > 1) {
                    $score -= 5 * $wakeupDiff;
                }
                if ($bedtimeDiff > 1) {
                    $score -= 5 * $bedtimeDiff;
                }
                $score -= 3 * $cleanDiff;
                if ($user['smoker'] != $person['smoker']) {
                    $score -= 20;
                }
                $score = round($score);
                return max($score, 0);
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Quiz for Directory Entry</title>
        <link rel= "stylesheet" href="style.css">
        <link rel="stylesheet" href="style2.css">
        <style type="text/css">
                h1{
                        text-align: center;
                }
                .form-container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 50px; 
                    padding-left: 125px;
                    padding-right: 125px;
                    background-color: #f8f8f8;
                    border-radius: 10px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                }

                .form-section-label {
                    font-size: 24px;
                    font-weight: bold;
                    text-align: center;
                    margin-top: 10px;
                    margin-bottom: 40px; 
                    color: #333;
                }

                .form-row {
                    display: flex;
                    flex-direction: column;
                    padding: 0;
                }

                .form-group {
                    display: flex;
                    flex-direction: column;
                    text-align: center;
                    margin-bottom: 40px;
                }

                label {
                    font-size: 16px;
                    margin-bottom: 8px; 
                    color: #666;
                }

                input[type="text"],
                input[type="number"],
                input[type="time"],
                select {
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    font-size: 16px;
                    background-color: #fff;
                    outline: none;
                    box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.1);
                    transition: box-shadow 0.2s;
                    margin: 0;
                }

                .cta-button {
                    width: 100%;
                    padding: 12px;
                    font-size: 18px;
                    color: #fff;
                    background-color: #6496fa;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    transition: background-color 0.2s;
                    margin-top: 20px;
                }

                /* Error Styling */
                .error {
                    color: #d9534f;
                    font-size: 14px;
                    margin-top: 5px;
                    text-align: left;
                    display: none;
                }
                footer{
                        margin-top: auto;
                }
                @media (max-width: 768px) {
                    .form-container {
                        max-width: 90%; 
                        padding: 20px; 
                    }

                    .form-row {
                        flex-direction: column; 
                    }

                    .form-group {
                        text-align: left;
                        margin-bottom: 20px; 
                    }

                    .cta-button {
                        font-size: 16px; 
                    }
                }
        </style>
    </head>
    <body>
        <!-- Navbar -->
    <nav>
        <div class="logo">
            <a href="index.html"><img src="NewLogo.png" alt="Logo"></a>
        </div>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li>
                <a href="#" class="dropdown">About</a>
                <ul class="dropdown-menu">
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="testimony.html">Testimonials</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown">Database</a>
                <ul class="dropdown-menu">
                    <li><a href="directory1.php">On-Campus</a></li>
                    <li><a href="directory2.php">Off-Campus</a></li>
                </ul>
            </li>
            <li><a href="quiz.php">Survey</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <h1>Here are Your Potential Matches</h1>
    <div class="result-container" id="results">


        <?php 
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $user = [
                                'name' => $_POST['name'],
                                'hometown' => $_POST['hometown'],
                                'phone' => $_POST['phone'],
                                'major' => $_POST['major'],
                                'gender' => $_POST['gender'],
                                'onCampus' => $_POST['onCampus'] === 'true' ? 1 : 0,
                                'wakeup' => $_POST['wakeup'],
                                'bedtime' => $_POST['bedtime'],
                                'smoker' => (int)$_POST['smoker'],
                                'cleanliness' => (int)$_POST['cleanliness'],
                                'img' => 'default.png' // Default image placeholder
                        ];
                        $sql = "SELECT * FROM People WHERE on_campus = {$user['onCampus']}";
                        $result = $conn->query($sql);
                        $compatibilityScores = [];
                        while ($row = $result->fetch_assoc()) {
                                $person = [
                                        'wakeup' => $row['wakeup'],
                                        'bedtime' => $row['bedtime'],
                                        'smoker' => (bool)$row['smoker'],
                                        'cleanliness' => (int)$row['cleanliness']  
                                ];
                                $compatibilityScores[] = [
                                    'score' => $score,
                                    'person' => $row
                                ];
                                $score = calculateCompatibility($user, $person);
                        }
                        usort($compatibilityScores, function ($a, $b) {
                            return $b['score'] - $a['score'];
                        });

                        foreach ($compatibilityScores as $entry) {
                            $row = $entry['person'];
                            $score = $entry['score'];

                            echo "<div class='person'>";
                            echo "<img src='" . $row['img'] . "' alt='Photo of " . $row['name'] . "'>";
                            echo "<h3>" . $row['name'] . "(" . $score . "% match)</h3>";
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


            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const hamburger = document.querySelector(".hamburger");
                    const navLinks = document.querySelector(".nav-links");
        
                    hamburger.addEventListener("click", () => {
                        navLinks.classList.toggle("active");
                    });
                });
            </script>
    </body>
</html>



<?php
    $conn->close();
?>