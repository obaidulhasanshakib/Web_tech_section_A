<?php


function sum($a, $b) {
    return $a + $b;
}

echo "Sum of 5 and 10 is: " . sum(5, 10) . "<br>";
echo "Sum of 3 and 7 is: " . sum(3, 7) . "<br><br>";



function factorial($n) {
    if ($n == 0 || $n == 1) {
        return 1;
    } else {
        return $n * factorial($n - 1);
    }
}

echo "Factorial of 5 is: " . factorial(5) . "<br>";
echo "Factorial of 7 is: " . factorial(7) . "<br><br>";



function is_prime($n) {
    if ($n <= 1) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}


$numbers = [2, 3, 4, 10, 13, 15];
foreach ($numbers as $num) {
    if (is_prime($num)) {
        echo "$num is a prime number.<br>";
    } else {
        echo "$num is NOT a prime number.<br>";
    }
}

?>