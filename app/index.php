<!DOCTYPE html>
<html lang="sk">
<head>
    <title>HerbiO3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="./img/herbio3.svg">
    <script src="/js/script.js"></script>
    <link rel="manifest" href='./manifest.json'>
    <meta name="theme-color" content="#0076BE" />
</head>
<body>

<header>
    <a href="dashboard.php"><img src="img/herbio3.svg" height="100" width="100"></a>
    <h1 id="title">PRIHLÁSENIE</h1>
</header>
<div id="notifications"></div>

<form>
    <label>
        <input type="email"> Email
    </label>
    <label>
        <input type="password"> Heslo
    </label>
    <input type="submit" title="Prihlásiť sa">
</form>

</body>
<script>
    const messages = document.getElementById("notifications")
    if(window.navigator.onLine === false){
        const offline = document.createElement("p");
        offline.innerText = "Internetové pripojenie neexistuje. Skontroluj pripojenie a skús znova."
        offline.classList.toggle("danger")
        messages.append(offline);
    }
</script>
</html>