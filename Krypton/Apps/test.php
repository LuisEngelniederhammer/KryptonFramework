<?php
namespace Krypton\Apps;

require_once 'Krypton/App.php';

use Krypton\App;

class test implements App
{
    public static function run(): string
    {
        return "Debug from test.php: FILE:" . __FILE__ . ' FUNCTION:' . __FUNCTION__ . ' CLASS:' . __CLASS__;
    }
}
