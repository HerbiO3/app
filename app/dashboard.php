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
<nav id="up-nav">
    <img class="nav-img" id="back" src="img/icons/back.svg">
    <div>
        <img class="nav-img" src="img/icons/settings.svg">
        <img class="nav-img" src="img/icons/settings.svg">
    </div>
</nav>
<div id="notifications" style="display: none">
    <p id="offline" class="danger"></p>
</div>
<header>
    <a href="dashboard.php"><img src="img/herbio3.svg" height="100" width="100"></a>
<h1 id="title">VÝBER JEDNOTKY</h1>
</header>
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

</body>
<script src="js/loadUnit.js"></script>
<script src="js/loadUnits.js"></script>
<script src="js/loadSection.js"></script>
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