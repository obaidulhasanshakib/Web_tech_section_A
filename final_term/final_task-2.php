<?php


$temperature = 22; 
$day = 3;          

echo "<h3>Temperature Check:</h3>";

if (!is_numeric($temperature)) {
    echo "Invalid temperature!<br>";
} else {
    if ($temperature < 10) {
        echo "It's cold<br>";
    } elseif ($temperature >= 10 && $temperature <= 25) {
        echo "It's warm<br>";
    } else {
        echo "It's hot<br>";
    }
}

echo "<br><h3>Day of the Week:</h3>";

if (!is_numeric($day)) {
    echo "Invalid day!<br>";
} else {
    switch ($day) {
        case 1: echo "Monday"; break;
        case 2: echo "Tuesday"; break;
        case 3: echo "Wednesday"; break;
        case 4: echo "Thursday"; break;
        case 5: echo "Friday"; break;
        case 6: echo "Saturday"; break;
        case 7: echo "Sunday"; break;
        default: echo "Invalid day number!";
    }
}
?>