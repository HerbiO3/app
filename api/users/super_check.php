<?php

session_start();
if (!isset($_SESSION["user"]) || !$_SESSION["super"]) {
    header("HTTP/1.1 206 Partial Content");
} else {
    header("HTTP/1.1 202 Accepted");
}
