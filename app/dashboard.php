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
    <script src="js/nav/storeColorMode.js"></script>
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
                <h1 id="title" class="self-center font-semibold whitespace-nowrap dark:text-white">VÝBER JEDNOTKY</h1>
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
                        <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 my-1">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                        </button>
                    </li>
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
    <p id="offline" class="danger hidden"></p>
</div>
<div id="units">
    <div class="unit"></div>
    <div class="unit"></div>
</div>
<div id="unit">

</div>
<div id="section" class="hidden">
    <div class="sec-item"></div>
    <div class="sec-item"></div>

</div>

<!-- ADD UNIT MODAL-->
<div id="create-unit" class="flex hidden">
    <button id="create-unit-button" data-modal-target="create-unit-modal" data-modal-toggle="create-unit-modal" class="block mx-auto my-4 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Vytvoriť jednotku
    </button>
</div>

<div id="create-unit-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full md:h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Pridať jednotku</h3>
                <button type="button" id="setting-modal-close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="create-unit-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="px-8 pt-8 pb-4 lg:px-24">
                <form class="space-y-6" id="settings-form" action="../api/units/create.php" method="post">
                </form>
            </div>
            <!-- Modal footer -->
            <div class="items-center p-x space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <div id="err-msg-div" class="hidden pt-2.5">
                    <span id="err-msg" class="text-red-600 font-bold"></span>
                </div>
                <button type="button" id="validate-form-unit-button" class="w-3/5 my-4 mx-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pridať</button>
            </div>
        </div>
    </div>
</div>


<!-- ADD SECTION MODAL -->
<div id="create-section" class="flex hidden">
    <button id="create-section-button" data-modal-target="create-section-modal" data-modal-toggle="create-section-modal" class="block mx-auto my-4 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Vytvoriť sekciu
    </button>
</div>

<div id="create-section-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full md:h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Pridať sekciu</h3>
                <button type="button" id="setting-modal-close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="create-section-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="px-8 pt-8 pb-4 lg:px-24">
                <form class="space-y-6" id="settings-form" action="../api/sections/create.php" method="post">
                </form>
            </div>
            <!-- Modal footer -->
            <div class="items-center p-x space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <div id="err-msg-div" class="hidden pt-2.5">
                    <span id="err-msg" class="text-red-600 font-bold"></span>
                </div>
                <button type="button" id="validate-form-section-button" class="w-3/5 my-4 mx-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pridať</button>
            </div>
        </div>
    </div>
</div>

<!-- SECTION SETTINGS MODAL -->
<div id="section-settings" class="flex hidden">
    <button id="settings-button" data-modal-target="settings-modal" data-modal-toggle="settings-modal" class="block mx-auto my-4 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Nastav sekciu
    </button>
</div>

<div id="settings-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full md:h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 id="settings-header" class="text-xl font-semibold text-gray-900 dark:text-white"></h3>
                <button type="button" id="setting-modal-close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="settings-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="px-8 pt-8 pb-4 lg:px-24">
                <form class="space-y-6" id="settings-form" action="../api/sections/settings.php" method="post">
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Zavlažovací mód</h3>
                    <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="radio-manual" type="radio" value="manual" name="mode" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="radio-manual" class="w-full py-3 ml-2 text-base font-medium text-gray-900 dark:text-gray-300">Manuálny</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="radio-auto" type="radio" value="auto" name="mode" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="radio-auto" class="w-full py-3 ml-2 text-base font-medium text-gray-900 dark:text-gray-300">Automatický</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="radio-timed" type="radio" value="timed" name="mode" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="radio-timed" class="w-full py-3 ml-2 text-base font-medium text-gray-900 dark:text-gray-300">Časovaný</label>
                            </div>
                        </li>
                    </ul>

                    <div id="water-amount" class="ms dark:text-white text-black">
                        <div id="ms-div">
                            <label for="watering-time" class="mb-4 font-semibold text-gray-900 dark:text-white">Doba zavlažovania</label>
                            <input type="number" id="watering-time" name="water-time-seconds" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="0">
                        </div>
                    </div>

                    <div id="log-section" class="min dark:text-white text-black4">
                        <div id="min-div">
                            <label for="log-interval" class="mb-4 font-semibold text-gray-900 dark:text-white">Interval logovania</label>
                            <span class="text-gray-900 dark:text-white text-xs">(pre celú jednotku)</span>
                            <input type="number" id="log-interval" name="log-interval-minutes" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="0">
                        </div>
                    </div>
                    <div id="humidity-section">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Minimálna hranica vlhkosti</h3>
                        <div class='range'>
                            <input id="input-range" name="min-humidity-percent" type="range" min='0' max='100' step='1' />
                            <span id="span-range">50%</span>
                        </div>
                    </div>

<!--                    https://www.cssscript.com/demo/material-date-time-picker-simplepicker/-->

                    <div id="time-section" class="hidden text-white">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Čas a rozmedzie závlah</h3>
                        <input type="datetime-local" name="datetime-start" id="date-time-1" class="bg-gray-50 border border-gray-300 text-gray-900 text-base hover:bg-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center mr-2 mb-2 dark:border-gray-600 dark:text-white dark:bg-gray-700 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800"/>
                        <input type="datetime-local" name="datetime-next" id="date-time-2" class="bg-gray-50 border border-gray-300 text-gray-900 text-base hover:bg-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center mr-2 mb-2 dark:border-gray-600 dark:text-white dark:bg-gray-700 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800"/>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="items-center p-x space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <div id="err-msg-div" class="hidden pt-2.5">
                    <span id="err-msg" class="text-red-600 font-bold"></span>
                </div>
                <button type="button" id="validate-form-button" class="w-3/5 my-4 mx-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Vykonaj</button>
            </div>
        </div>
    </div>
</div>

<div>
    <small style="display: block; margin-top: 10px" class="dark:text-white">Posledná aktualizácia:</small>
    <p id="lastUpdate" class="shadow bg-white dark:bg-gray-700 dark:text-white"></p>
</div>

<section  id="sec-history" style="display: none; flex-direction: column">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8 w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <h1 class="self-center font-semibold whitespace-nowrap dark:text-white">Zobrazenie histórie</h1>
            <div date-rangepicker class="flex items-center">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input datepicker name="start" id="date-start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Vyber dátum od">
                </div>
                <span class="mx-4 text-gray-500">to</span>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input datepicker name="end" id="date-end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Vyber dátum do">
                </div>
            </div>
            <button id="set-history-today" type="submit" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Dnes</button>
            <button id="set-history-24" type="submit" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Deň</button>
            <button id="set-history-week" type="submit" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">7 dní</button>
            <button id="set-history-month" type="submit" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">30 dní</button>
            <button id="show-history" type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Zobraziť</button>

        </div>
    </div>
    <section id="graphs" style="margin-left: 2vw; margin-right: 2vw">
        <div class="dx-viewport demo-container">
            <div id="levelChart"></div>
            <div id="levelRangeSelector"></div>
        </div>

        <div class="dx-viewport demo-container">
            <div id="uvChart"></div>
            <div id="uvRangeSelector"></div>
        </div>
        <div class="dx-viewport demo-container">
            <div id="tempChart"></div>
            <div id="tempRangeSelector"></div>
        </div>
        <div class="dx-viewport demo-container">
            <div id="humChart"></div>
            <div id="humRangeSelector"></div>
        </div>

    </section>

</section>

</body>
<script src="js/simplepicker.js"></script>
<script src="js/nav/messages.js"></script>
<script src="js/unit/loadUnit.js"></script>
<script src="js/unit/loadUnits.js"></script>
<script src="js/section/loadSection.js"></script>
<script src="js/nav/navigateBack.js"></script>
<script src="js/settings/loadSettings.js"></script>
<script src="js/section/handleSectionSettings.js"></script>
<script src="js/graphs/dates.js"></script>
<script src="js/inputRange.js"></script>

<!-- ... -->
<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>

<!-- DevExtreme theme -->
<link rel="stylesheet" href="graphs/Lib/css/dx.light.css">

<!--Date Time picker style-->
<link rel="stylesheet" href="css/simplepicker.css">

<!-- DevExtreme library -->
<script type="text/javascript" src="graphs/Lib/js/dx.all.js"></script>

<script src="js/graphs/loadGraphs.js"></script>
<script>
    const messages = document.getElementById("notifications")
    if(window.navigator.onLine === false){
        appendMessage("danger","Internetové pripojenie neexistuje. Skontroluj pripojenie a skús znova.")
    }
    const units = document.getElementById("units")
    const unit = document.getElementById("unit")
    const section = document.getElementById("section")
    const history = document.getElementById("sec-history")
    const loadHistory = document.getElementById("show-history")
    const title = document.getElementById("title")
    const timestamp = document.getElementById("lastUpdate")
    // modals
    const sectionSettings = document.getElementById("section-settings")
    const settingsButton = document.getElementById("settings-button")
    const createUnit= document.getElementById("create-unit")
    const createUnitButton = document.getElementById("create-unit-button")
    const createSection = document.getElementById("create-section")
    const createSectionButton = document.getElementById("create-unit-button")

    let lastUnitId;
    let openedSectionId;
    openUnits();
</script>
<script src="js/libs/flowbite.min.js"></script>
<script src="js/libs/datepicker.min.js"></script>
<script src="js/nav/changeColorMode.js"></script>
</html>