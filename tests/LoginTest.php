<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli("localhost", "root", "", "web");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        $this->conn->query("DELETE FROM nguoidung WHERE username = 'testcase'");
        $username = 'testcase';
        $password = md5('1');
        $fullname = 'Test User';
        $sql = "INSERT INTO nguoidung (username, password, fullname) VALUES ('$username', '$password', '$fullname')";
        $this->conn->query($sql);
    }

    protected function tearDown(): void
    {
        $this->conn->query("DELETE FROM nguoidung WHERE username = 'testcase'");
        $this->conn->close();
    }

    public function testLoginSuccess()
    {
        $username = 'testcase';
        $password = md5('1');
        $sql = "SELECT * FROM nguoidung WHERE username = '$username' AND password = '$password'";
        $result = $this->conn->query($sql);
        $this->assertEquals(1, $result->num_rows);
    }

    public function testLoginFailure()
    {
        $username = 'testcase';
        $password = md5('11');
        $sql = "SELECT * FROM nguoidung WHERE username = '$username' AND password = '$password'";
        $result = $this->conn->query($sql);
        $this->assertEquals(0, $result->num_rows);
    }
}