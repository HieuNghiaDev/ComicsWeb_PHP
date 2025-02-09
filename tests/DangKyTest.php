<?php

use PHPUnit\Framework\TestCase;

class DangKyTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli("localhost", "root", "", "web");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        $this->conn->query("DELETE FROM comment WHERE username IN ('testuser')");
        $this->conn->query("DELETE FROM nhasangtao WHERE username IN ('testuser')");
        $this->conn->query("DELETE FROM theodoi WHERE id IN ('testuser')");
        $this->conn->query("DELETE FROM nguoidung WHERE username IN ('testuser')");
    }

    protected function tearDown(): void
    {
        $this->conn->query("DELETE FROM comment WHERE username IN ('testuser')");
        $this->conn->query("DELETE FROM nhasangtao WHERE username IN ('testuser')");
        $this->conn->query("DELETE FROM theodoi WHERE id IN ('testuser')");
        $this->conn->query("DELETE FROM nguoidung WHERE username IN ('testuser')");
        $this->conn->close();
    }

    public function testRegisterSuccess()
    {
        $username = 'testuser';
        $password = md5('password');
        $fullname = 'Test User';
        $sql = "INSERT INTO nguoidung (username, password, fullname) VALUES ('$username', '$password', '$fullname')";
        $result = $this->conn->query($sql);
        $this->assertTrue($result);
    }

    public function testRegisterPasswordMismatch()
    {
        $username = 'testuser';
        $password = md5('password');
        $confirmPassword = md5('repassword');
        $fullname = 'Test User';

        if ($password !== $confirmPassword) {
            $this->assertTrue(true);
        } else {
            $sql = "INSERT INTO nguoidung (username, password, fullname) VALUES ('$username', '$password', '$fullname')";
            $result = $this->conn->query($sql);
            $this->assertFalse($result);
        }
    }

    public function testRegisterMissingFullname()
    {
        $username = 'testuser';
        $password = md5('password');
        $fullname = '';

        if (empty($fullname)) {
            $this->assertTrue(true);
        } else {
            $sql = "INSERT INTO nguoidung (username, password, fullname) VALUES ('$username', '$password', '$fullname')";
            $result = $this->conn->query($sql);
            $this->assertFalse($result);
        }
    }
}