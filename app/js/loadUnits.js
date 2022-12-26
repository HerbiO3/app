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
            data.forEach(unit=>{appendUnit(unit)})
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
                    offlineSections(id)
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
    if(localStorage.getItem("units")!=null){
        units.innerHTML='';
        data = JSON.parse(localStorage.getItem("units"))
        data.forEach(unit=>{appendUnit(unit)})
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

