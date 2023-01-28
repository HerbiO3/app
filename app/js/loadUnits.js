function openUnits() {
    cleanMessages();
    if(window.navigator.onLine === false){
        appendOffile()
        offlineUnits()
    }else{
        url = "/api/units"
        const ms = Date.now();
        fetch(url+"?time="+ms, {cache: 'no-store'}).then(function(response) {
            switch (response.status) {
                case 200:
                    units.style.display="block";
                    unit.style.display="none";
                    section.style.display="none";
                    history.style.display="none";

                    title.innerText="VÝBER JEDNOTKY"
                    break;
                case 401:
                    const error = new Error("Unauthorized");
                    error.name = '401';
                    throw error;
                default:
                    const errordef = new Error("Server Error");
                    errordef.name = 'other';
                    throw errordef;
            }
            return response.json();
        }).then(function(data) {
            backOnline()
            units.innerHTML='';
            data.units.forEach(unit=>{appendUnit(unit)})

            setTime(data.time);
            localStorage.setItem("units",JSON.stringify(data));
        }).catch(function(e) {
            console.log(e)
            switch (e.name){
                case "401":
                    window.location.replace("index.php?reqlog=true");
                    return;
                case "404":
                    appendMessage("danger", "Nepodarilo sa nájsť.")
                    return;
                case "other":
                    appendMessage("danger", "Chyba servera.")
                    return;
                default:
                    appendOffile()
                    offlineUnits()
            }
        });
    }
}

function appendUnit(unit) {
    const unitDiv = document.createElement("div")
    const h2 = document.createElement("h2")
    h2.innerText = unit.name
    unitDiv.append(h2)
    unitDiv.classList.toggle("unit")
    unitDiv.addEventListener("click",() => openUnit(unit.id))
    units.append(unitDiv)
}

function offlineUnits() {
    let data;
    if (localStorage.getItem("units") != null) {
        data = JSON.parse(localStorage.getItem("units"))

        units.style.display = "block";
        unit.style.display = "none";
        section.style.display = "none";
        history.style.display="none";

        title.innerText = "VÝBER JEDNOTKY"

        units.innerHTML = '';
        data.units.forEach(unit => {
            appendUnit(unit)
        })
        setTime(data.time);
    }
}



function appendOffile(){
    const offline = document.getElementById("offline");
    offline.innerText = "Nepodarilo sa spojiť so serverom. Skontroluj pripojenie a skús znova."
    //offline.classList.toggle("danger")
    offline.style.display="block"
}

function backOnline(){
    const offline = document.getElementById("offline");
    offline.style.display="none"
}

function setTime(seconds){
    timestamp.innerText = new Date(seconds * 1000).toLocaleString();
}