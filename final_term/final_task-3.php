<?php
// Lab Task 3

echo "<h3>For Loop (1 to 20):</h3>";
for ($i = 1; $i <= 20; $i++) {
    echo $i . " ";
}

echo "<br><br><h3>While Loop (Even numbers 1 to 20):</h3>";
$j = 1;
while ($j <= 20) {
    if ($j % 2 == 0) {
        echo $j . " ";
    }
    $j++;
}

echo "<br><br><h3>Associative Array (Fruits & Colors):</h3>";
$fruits = [
    "apple" => "red",
    "banana" => "yellow",
    "grape" => "purple",
    "orange" => "orange",
    "mango" => "green"
];

$count = 0;

foreach ($fruits as $fruit => $color) {
    echo "$fruit is $color<br>";
    $count++;

    if ($count == 5) {
        break;   
    }
}
?>