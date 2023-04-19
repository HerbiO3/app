<?php

function audit_log($conn, $user, $logType, $logInfo){
    $query = "INSERT into audit_log (user, type, info) VALUES  (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iss', $user, $logType, $logInfo);
    $stmt->execute();
}