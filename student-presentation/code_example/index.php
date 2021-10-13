<?php
    $guest1 = 'Spencer Powell';
    $guest2 = 'Billy Corgan';
    $guest3 = 'Merchant of Venice';

    // Numeric Array
    $guest_list = array('Spencer Powell', 'Billy Corgan', 'Merchant of Venice');

    $guests = array(
        'favorite' => 'Spencer Powell', 
        'popular' => 'Billy Corgan', 
        'disliked' => 'Merchant of Venice'
    );
    echo 'Selected via a variable: ' . $guest2;
    echo "<br>";
    echo 'Selected via a numeric index in a Numeric Array: ' . $guest_list[1];
    echo "<br>";
    echo 'Selected via a string or key in an Associative Array: ' . $guests['popular'];
    echo "<br>";

?>