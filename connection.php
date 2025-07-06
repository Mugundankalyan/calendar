<?php

// connect to local mysql server using xampp
$conn =new mysqli('localhost', 'root', '', 'calendar');
$conn->set_charset("utf8mb4");