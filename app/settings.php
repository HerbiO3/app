<!DOCTYPE html>
<html lang="sk">
<head>
    <title>HerbiO3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <link type="text/css" rel="stylesheet" href="css/style.css">-->
    <link href="/dist/output.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./img/herbio3.svg">
    <script src="/js/script.js"></script>
    <link rel="manifest" href='./manifest.json'>
    <meta name="theme-color" content="#0076BE" />
</head>
<body>
<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="flex flex-wrap items-center justify-between mx-auto max-w-screen-xl px-4 md:px-6 py-2.5">
        <a href="#" class="flex items-center" style="margin-left: auto; margin-right: auto">
            <img src="img/herbio3.svg" class="h-6 mr-3 sm:h-9" alt="HERBIO3 Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">HerbiO3</span>
        </a>
    </div>
</nav>

<nav class="bg-white border-gray-200 px-2 sm:px-4 py-1.5 dark:bg-gray-900">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <div class="flex items-center md:order-2">
            <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <img id="back" class="w-10 h-10 rounded-full" src="img/icons/back.svg" alt="back">
            </button>
        </div>
        <div class="flex items-center md:order-2">
            <h1 id="title" class="self-center font-semibold whitespace-nowrap dark:text-white">NASTAVENIA</h1>
        </div>
        <div class="flex items-center md:order-3">
            <div class="flex items-center md:order-2">
                <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <img class="w-10 h-10 rounded-full" src="img/icons/settings.svg" alt="user photo">
                </button>
            </div>
            <div class="flex items-center md:order-2">
                <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <img class="w-10 h-10 rounded-full" src="img/icons/logout.svg" alt="user photo">
                </button>
            </div>
        </div>
    </div>
</nav>
<div id="notifications" style="display: none">
    <p id="offline" class="danger"></p>
</div>

</body>

<script>
    const messages = document.getElementById("notifications")
    if(window.navigator.onLine === false){
        const offline = document.createElement("p");
        offline.innerText = "Internetové pripojenie neexistuje. Skontroluj pripojenie a skús znova."
        offline.classList.toggle("danger")
        messages.append(offline);
    }
    const units = document.getElementById("units")
    const unit = document.getElementById("unit")
    const section = document.getElementById("section")
    const title = document.getElementById("title")
    const back = document.getElementById("back")
    let last = "units"
    back.addEventListener("click", ()=>{
        units.style.display = 'none'
        unit.style.display = 'none'
        section.style.display = 'none'
        switch (last) {
            case "units":
                units.style.display = 'inline-flex'
                break
            case "unit":
                last = 'units' // ZNOVA ROBIT OPEN!
                unit.style.display = 'block'
                break
        }
    })

    openUnits();

</script>
</html>