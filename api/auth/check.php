<?php
session_start();
if(isset($_SESSION["user"])){
    die("ok");
}else{
    sleep(2);
    die("unauthorized");
}