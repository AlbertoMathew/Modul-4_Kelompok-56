<?php
require_once 'Hotel.php';

class Deluxe extends Hotel
{
    public function __construct()
    {
        parent::__construct("Deluxe", 5, 2, 1, 1250000);
    }
}
