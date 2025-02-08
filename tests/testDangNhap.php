<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli("localhost", "root", "", "comicsweb");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testLoginSuccess()
    {
        $username = 'testuser';
        $password = 'testpassword';
        $sql = "SELECT * FROM nguoidung WHERE username = '$username' AND password = '$password'";
        $result = $this->conn->query($sql);
        $this->assertEquals(1, $result->num_rows);
    }

    public function testLoginFailure()
    {
        $username = 'wronguser';
        $password = 'wrongpassword';
        $sql = "SELECT * FROM nguoidung WHERE username = '$username' AND password = '$password'";
        $result = $this->conn->query($sql);
        $this->assertEquals(0, $result->num_rows);
    }
}