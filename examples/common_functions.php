<?php
/**
* These are functions for working with the
* examples on the Redde Api.
*/

/**
 * A function to generate random numbers
 * @param  int [$length = 6] 
 * @return int 
 */
function generateNumber($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomNumber = '';
    for ($i = 0; $i < $length; $i++) {
        $randomNumber .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomNumber;
}

/**
 * A function to generate random string
 * @param  int [$length = 10]
 * @return string 
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
