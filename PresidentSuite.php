<?php
require_once 'Hotel.php';

class PresidenSuite extends Hotel
{
    public function __construct()
    {
        parent::__construct("Deluxe", 7, 3, 2, 2500000);
    }
}
