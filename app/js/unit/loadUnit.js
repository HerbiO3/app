function openUnit(id){
    cleanMessages();
    last = 'units'
    lastUnitId = id;
    if(window.navigator.onLine === false){
        appendOffile()
        offlineSections(id)
    }else {
        const uniturl = "/api/units?unitId=" + id
        const ms = Date.now();
        fetch(uniturl+"?time="+ms, {cache: "no-cache"}).then(function(response) {
            switch (response.status) {
                case 200:
                    units.style.display="none";
                    section.style.display="none";
                    history.style.display="none";
                    sectionSettings.style.display="none";
                    document.getElementById("graphs").style.display="none";
                    unit.style.display="block";

                    createSensor.style.display="flex";
                    createSection.style.display="flex";
                    createUnit.style.display="none";

                    title.innerText="VÝBER SEKCIE"
                    break;
                case 401:
                    const error = new Error("Unauthorized");
                    error.name = '401';
                    throw error;
                case 404:
                    const error404 = new Error("Not found");
                    error404.name = '404';
                    throw error404;
                default:
                    const errordef = new Error("Server Error");
                    errordef.name = 'other';
                    throw errordef;
            }
            return response.json();
        }).then(function(data) {
            backOnline()
            unit.innerHTML='';
            const h2 = document.createElement("h2")
            h2.classList.add('text-gray-900', 'dark:text-white', 'font-semibold')
            h2.innerText = data.name
            unit.append(h2)
            setTime(data.time);
            if(!data.sections) {
                appendMessage("info", "Pre túto jednotku neexistujú žiadne sekcie")
                return
            }
            data.sections.forEach(section=>{appendSection(section)})
            localStorage.setItem("unit-"+id,JSON.stringify(data));
        }).catch(function(e) {
            console.log(e)
            switch (e.name){
                case "401":
                    window.location.replace("index.php?reqlog=true");
                    return;
                case "404":
                    appendMessage("danger", "Nepodarilo sa nájsť jednotku.")
                    return;
                case "other":
                    appendMessage("danger", "Chyba servera.")
                    return;
                default:
                    appendOffile()
                    offlineSections(id)
            }
        });
    }
}


function appendSection(section){
    const secDiv = document.createElement("div")
    const h2 = document.createElement("h2")
    h2.innerText = section.name
    secDiv.append(h2)
    secDiv.classList.toggle("section")
    secDiv.addEventListener("click",() => openSection(section.name, section.id))
    unit.append(secDiv)
}

function offlineSections(id){
    let data;
    if (localStorage.getItem("unit-" + id) != null) {
        data = JSON.parse(localStorage.getItem("unit-" + id))

        units.style.display = "none";
        section.style.display = "none";
        history.style.display="none";
        sectionSettings.style.display="none";
        document.getElementById("graphs").style.display="none";
        unit.style.display = "block";
        title.innerText = "VÝBER SEKCIE"

        unit.innerHTML = '';
        const h2 = document.createElement("h2")
        h2.innerText = data.name
        unit.append(h2)

        data.sections.forEach(section => {
            appendSection(section)
        })
        setTime(data.time);
    }
}


function appendOffile(){
    const offline = document.getElementById("offline");
    offline.innerText = "Nepodarilo sa spojiť so serverom. Skontroluj pripojenie a skús znova."
    offline.classList.toggle("danger")
    offline.style.display="block"
}

function backOnline(){
    const offline = document.getElementById("offline");
    offline.style.display="none"
}

function setTime(seconds){
    timestamp.innerText = new Date(seconds * 1000).toLocaleString();
}