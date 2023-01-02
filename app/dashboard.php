<!DOCTYPE html>
<html lang="sk">
<head>
    <title>HerbiO3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <link type="text/css" rel="stylesheet" href="css/style.css">-->
    <link href="/app/css/global.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./img/herbio3.svg">
    <script src="/js/script.js"></script>
    <link rel="manifest" href='./manifest.json'>
    <meta name="theme-color" content="#0076BE" />
</head>
<body class="bg-gray-50 dark:bg-gray-800" style="overscroll-behavior-y: contain;">
<div class="shadow">
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between mx-auto max-w-screen-xl px-4 md:px-6 py-2.5">
            <a href="#" class="flex items-center" style="margin-left: auto; margin-right: auto">
                <img src="img/herbio3.svg" class="h-8 mr-3 sm:h-9" alt="HERBIO3 Logo" />
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">HerbiO3</span>
            </a>
        </div>
    </nav>

    <nav class="bg-white border-gray-200 px-2 sm:px-4 py-1.5 dark:bg-gray-900">
        <div class="container flex flex-wrap items-center justify-between mx-auto">
            <div class="flex items-center md:order-1">
                <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false">
                    <img id="back" class="w-10 h-10 rounded-full" src="img/icons/back.svg" alt="back">
                </button>
            </div>
            <div class="flex items-center md:order-2">
                <h1 id="title" class="self-center font-semibold whitespace-nowrap dark:text-white">VÝBER JEDNOTKY</h1>
            </div>
<!--            <div class="flex items-center md:order-3">-->
<!--                <div class="flex items-center md:order-2">-->
<!--                    <a href="settings.php" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">-->
<!--                        <img class="w-10 h-10 rounded-full" src="img/icons/settings.svg" alt="user photo">-->
<!--                    </a>-->
<!--                </div>-->
<!--                <div class="flex items-center md:order-2">-->
<!--                    <a href="/api/auth/logout.php" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">-->
<!--                        <img class="w-10 h-10 rounded-full" src="img/icons/logout.svg" alt="user photo">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
            <button type="button" class="md:order-3 flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <span class="sr-only">Open settings</span>
                <img class="w-10 h-10 rounded-full" src="img/icons/settings.svg" alt="settings">
            </button>

            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">HerbiO3</span>
                    <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">user</span>
                </div>
                <ul class="py-1" aria-labelledby="user-menu-button">
                    <li>
                        <a href="dashboard.php" class="block px-4 py-2 text-bg text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li>
                        <a href="settings.php" class="block px-4 py-2 text-bg text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                    </li>
                    <li>
                        <a href="/api/auth/logout.php" class="block px-4 py-2 text-bg text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
</div>
<div id="notifications">
    <p id="offline" class="danger" style="display: none"></p>
</div>
<div id="units">
    <div class="unit"></div>
    <div class="unit"></div>
</div>
<div id="unit">

</div>
<div id="section" style="display: none">
    <div class="sec-item"></div>
    <div class="sec-item"></div>
</div>
<div>
    <small style="display: block; margin-top: 10px" class="dark:text-white">Posledná aktualizácia:</small>
    <p id="lastUpdate" class="shadow bg-white dark:bg-gray-900 dark:text-white"></p>
</div>


</body>
<script src="js/messages.js"></script>
<script src="js/loadUnit.js"></script>
<script src="js/loadUnits.js"></script>
<script src="js/loadSection.js"></script>
<script src="js/navigateBack.js"></script>
<script>
    const messages = document.getElementById("notifications")
    if(window.navigator.onLine === false){
        appendMessage("danger","Internetové pripojenie neexistuje. Skontroluj pripojenie a skús znova.")
    }
    const units = document.getElementById("units")
    const unit = document.getElementById("unit")
    const section = document.getElementById("section")
    const title = document.getElementById("title")
    const timestamp = document.getElementById("lastUpdate")
    let lastUnitId;
    openUnits();

</script>
<script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>
</html>