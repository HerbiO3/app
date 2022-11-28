function openUnits() {
    if(window.navigator.onLine === false){
        appendOffile()
        offlineUnits()
    }else{
        url = "/api/units"
        fetch(url).then(function(response) {
            return response.json();
        }).then(function(data) {
            backOnline()
            units.innerHTML='';
            data.forEach(unit=>{appendUnit(unit)})
            localStorage.setItem("units",JSON.stringify(data));
        }).catch(function(e) {
            console.log(e)
            appendOffile()
            offlineUnits()
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

