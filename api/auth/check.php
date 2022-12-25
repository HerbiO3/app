<?php
session_start();
if(isset($_SESSION["user"])){
    die("ok");
}else{
    die("unauthorized");
}