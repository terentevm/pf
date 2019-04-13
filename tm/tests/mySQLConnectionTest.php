<?php
// declare(strict_types=1);

namespace tm\tests;

use PHPUnit\Framework\TestCase;
//use tm\database\Connection as Conn;
use tm\database\mySQLConnection as MySql;

class mySQLConnectionTest extends TestCase
{
    private function getFakeConfig()
    {
        return [
            "dsn" => "localhost:4052",
            "user" => "vasya",
            "password" => "123"
        ];

    }

    /**
     * @expectedException PDOException
     */
    public function testInitFakeConfig()
    {
        $configFake = $this->getFakeConfig(); 
        
        $conn = MySql::init($configFake);
    }
}