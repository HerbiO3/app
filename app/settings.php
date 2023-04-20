<!DOCTYPE html>
<html lang="sk">
<head>
    <title>HerbiO3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/app/css/global.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./img/herbio3.svg">
    <script src="/js/script.js"></script>
    <link rel="manifest" href='./manifest.json'>
    <meta name="theme-color" content="#0076BE" />
     <script src="js/nav/storeColorMode.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-800" style="overscroll-behavior-y: contain;">
<?php include("html/settingsNav.html")?>
<div id="notifications">
    <p id="offline" class="danger" style="display: none"></p>
</div>

<?php include("html/settingsAuditLogs.html")?>
<?php include("html/settingsAddUser.html")?>
<?php include("html/settingsUserList.html")?>

</body>
<script src="js/nav/messages.js"></script>
<script src="js/settings/auditLogs.js"></script>
<script src="js/settings/userManager.js"></script>
<script src="js/nav/changeColorMode.js"></script>
<script src="js/libs/flowbite.min.js"></script>
<script src="js/libs/datepicker.min.js"></script>
</html>