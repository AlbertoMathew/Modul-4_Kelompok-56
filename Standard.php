<?php
require_once 'Hotel.php';

class Standard extends Hotel
{
    public function __construct()
    {
        parent::__construct("Standard", 4, 1, 0, 850000);
    }
}
