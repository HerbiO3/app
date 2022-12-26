<!DOCTYPE html>
<html lang="sk">
<head>
    <title>HerbiO3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <link type="text/css" rel="stylesheet" href="css/style.css">-->
    <link href="/app/css/output.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./img/herbio3.svg">
    <script src="/js/script.js"></script>
    <link rel="manifest" href='./manifest.json'>
    <meta name="theme-color" content="#0076BE" />
</head>
<body class="bg-gray-50 dark:bg-gray-900">

<div id="notifications">
<!--    <p id="offline" class="danger"></p>-->
</div>


<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="img/herbio3.svg" alt="logo">
            HerbiO3
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Prihlásenie
                </h1>
                <form class="space-y-4 md:space-y-6" action="../api/auth">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="username" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Heslo</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Zabudnuté heslo?</a>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Ešte nemáš účet? <a href="register.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Registrácia</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="js/messages.js"></script>
<script>
    const messages = document.getElementById("notifications")
    var myHeaders = new Headers();
    myHeaders.append('pragma', 'no-cache');
    myHeaders.append('cache-control', 'no-cache');
    myHeaders.append('credentials', 'include');

    var myInit = {
        method: 'GET',
        headers: myHeaders,
    };

    if(window.navigator.onLine === false){
        appendMessage("danger", "Internetové pripojenie neexistuje. Skontroluj pripojenie a skús znova.")
    }else{
        const url = "/api/auth/check.php"
        const ms = Date.now();
        fetch(url+"?time="+ms, myInit)
            .then((response) => response.text())
            .then((text) => {
                if (text === "ok"){
                    window.location.replace("dashboard.php");
                }
            }).catch(function(e) {
            console.log(e)
        });
    }


    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });
    if(params.badcred === "true") appendMessage("danger", "Boli zadané nesprávne prihlasovacie údaje!");
    if(params.reqlog === "true") appendMessage("danger", "Najprv sa musíš prihlásiť!");
    if(params.logout === "true") {
        localStorage.clear();
        appendMessage("info", "Odhlásenie prebehlo úspešne!")
    }

</script>
</html>