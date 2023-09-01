<?php
function generate_upc_checkdigit($upc_code)
{
    $odd_total  = 0;
    $even_total = 0;
 
    for($i=0; $i<12; $i++)
    {
        if((($i+1)%2) == 0) {
            /* Sum even digits */
            $even_total += $upc_code['$i'];
        } else {
            /* Sum odd digits */
            $odd_total += $upc_code['$i'];
        }
    }
 
    $sum = (3 * $even_total) + $odd_total;
 
    /* Get the remainder MOD 10*/
     $check_digit = $sum % 10;
   
   
 
    /* If the result is not zero, subtract the result from ten. */
    return ($check_digit > 0) ? 10 - $check_digit : $check_digit;
}
?>
 