
<html>
<head>
    <title>HERBIO 3.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>

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
<script>
    const units = document.getElementById("units")
    const unit = document.getElementById("unit")
    const section = document.getElementById("section")
    const title = document.getElementById("title")

    url = "/api/units"
    fetch(url).then(function(response) {
        return response.json();
    }).then(function(data) {
        console.log(data);
        units.innerHTML='';
        data.forEach(unit=>{
            const unitDiv = document.createElement("div")
            const h2 = document.createElement("h2")
            h2.innerText = unit.name
            unitDiv.append(h2)
            unitDiv.classList.toggle("unit")
            unitDiv.addEventListener("click",() => openUnit(unit.id))
            units.append(unitDiv)
        })
    }).catch(function(e) {
        console.log(e)
    });

    function openUnit(id){
        units.style.display="none";
        unit.style.display="block";
        title.innerText="VÝBER SEKCIE"
        const secSh1 = document.createElement("div")
        const secSh2 = document.createElement("div")
        secSh1.classList.toggle("section")
        secSh2.classList.toggle("section")
        unit.append(secSh1)
        unit.append(secSh2)
        var uniturl = "/api/units?unitId=" + id
        fetch(uniturl).then(function(response) {
            return response.json();
        }).then(function(data) {
            console.log(data);
            unit.innerHTML='';
            const h2 = document.createElement("h2")
            h2.innerText = data.name
            unit.append(h2)
            data.sections.forEach(section=>{
                const secDiv = document.createElement("div")
                const h2 = document.createElement("h2")
                h2.innerText = section.name
                secDiv.append(h2)
                secDiv.classList.toggle("section")
                secDiv.addEventListener("click",() => openSection(section.name, section.id))
                unit.append(secDiv)
            })

        }).catch(function(e) {
            console.log(e)
        });
    }


    function openSection(name, id){
        units.style.display="none";
        unit.style.display="none";
        section.style.display="inline-flex";
        title.innerText="SEKCIA " + name;
        var uniturl = "/api/sections?sectionId=" + id
        fetch(uniturl).then(function(response) {
            return response.json();
        }).then(function(data) {
            console.log(data);
            section.innerHTML='';
            const h2 = document.createElement("h2")
            h2.innerText = data.name
            //section.append(h2)

            createItem("Hladina v nádrži","level",data.waterLevel*100 + "%",section)
            createItem("UV index","uv",data.uvIndex,section)
            createItem("Teplota vzduchu","temp",data.airTemperature + "°",section)
            data.humidity.forEach((sensor)=>{
                createItem("Vlhkosť v kvetináči ("+sensor.sensorId+")","hum",sensor.value*100 + "%",section)
            })

        }).catch(function(e) {
            console.log(e)
        });
    }
    function createItem(name, type, value, section) {
        const item = document.createElement("div")
        const h2 = document.createElement("h2")
        h2.innerText = name
        item.append(h2)
        const h4 = document.createElement("h4")
        h4.innerText = value
        item.append(h4)

        item.classList.toggle("sec-item")
        item.classList.toggle(type)
        section.append(item)
    }

</script>
</html>