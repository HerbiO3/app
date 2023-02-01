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
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false">
                    <img id="back" class="w-10 h-10 rounded-full" src="img/icons/back.svg" alt="back">
                </button>
            </div>
            <div class="flex items-center md:order-2">
                <h1 id="title" class="self-center font-semibold whitespace-nowrap dark:text-white">NASTAVENIA</h1>
            </div>
            <button type="button" class="md:order-3 flex text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
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
                        <a href="settings.php" class="font-bold block px-4 py-2 text-bg text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
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
<section class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <div class="bg-gray-50 dark:bg-gray-900 w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Nastavenia sekcie
            </h1>
        </div>
    </div>
</section>

<section class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <div class="bg-gray-50 dark:bg-gray-900 w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Pridanie užívateľa
            </h1>
            <form class="space-y-4 md:space-y-6" action="../api/auth/register.php">
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="username" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Heslo</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                </div>
                <div>
                    <label for="password2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zopakuj heslo</label>
                    <input type="password" name="password2" id="password2" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                </div>
                <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
            </form>
        </div>
    </div>
</section>

<div>
    <small style="display: block; margin-top: 10px" class="dark:text-white">Posledná aktualizácia:</small>
    <p id="lastUpdate" class="shadow bg-white dark:bg-gray-700 dark:text-white"></p>
</div>

</body>
<script src="js/messages.js"></script>
<script>
    const messages = document.getElementById("notifications")
    if(window.navigator.onLine === false){
        appendMessage("danger","Internetové pripojenie neexistuje. Skontroluj pripojenie a skús znova.")
    }
</script>
<script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>
<script src="js/datepicker.min.js"></script>
</html>