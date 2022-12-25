// const controller = new AbortController()
// const timeoutId = setTimeout(() => controller.abort(), 10000)


function openUnit(id){
    last = 'units'
    if(window.navigator.onLine === false){
        appendOffile()
        offlineSections(id)
    }
    units.style.display="none";
    unit.style.display="block";
    title.innerText="VÝBER SEKCIE"

    const uniturl = "/api/units?unitId=" + id
    const ms = Date.now();
    fetch(uniturl+"?time="+ms, {cache: "no-cache"}).then(function(response) {
        if (response.status !== 200){
            window.location.replace("index.php");
            return;
        }
        return response.json();
    }).then(function(data) {
        backOnline()
        unit.innerHTML='';
        const h2 = document.createElement("h2")
        h2.innerText = data.name
        unit.append(h2)
        data.sections.forEach(section=>{appendSection(section)})
        localStorage.setItem("unit-"+id,JSON.stringify(data.sections));
    }).catch(function(e) {
        appendOffile()
        offlineSections(id)
        console.log(e)
    });
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
    if(localStorage.getItem("unit-"+id)!=null){
        units.innerHTML='';
        data = JSON.parse(localStorage.getItem("units"))
        data.forEach(section=>{
            appendSection(section)
        })
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

