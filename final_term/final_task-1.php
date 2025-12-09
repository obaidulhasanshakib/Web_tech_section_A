<?php

$stringVar = "Hello PHP";
$intVar = 10;
$floatVar = 5.75;
$boolVar = true;


echo "<h3>Variable Types and Values:</h3>";
var_dump($stringVar);
echo "<br>";
var_dump($intVar);
echo "<br>";
var_dump($floatVar);
echo "<br>";
var_dump($boolVar);
echo "<br><br>";


$add = $intVar + $floatVar;
$sub = $intVar - $floatVar;
$mul = $intVar * $floatVar;
$div = $intVar / $floatVar;

echo "<h3>Arithmetic Results:</h3>";
echo "Addition: $add <br>";
echo "Subtraction: $sub <br>";
echo "Multiplication: $mul <br>";
echo "Division: $div <br><br>";


$num1 = 15;
$num2 = 25;

echo "Using echo: The sum is " . ($num1 + $num2) . "<br>";
print "Using print: The sum is " . ($num1 + $num2);
?>