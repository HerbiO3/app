function openSection(name, id){
    cleanMessages();
    if(window.navigator.onLine === false){
        appendOffile()
        offlineSection(id)
    }else{
        var uniturl = "/api/sections?sectionId=" + id
        const ms = Date.now();
        fetch(uniturl+"?time="+ms, {cache: "no-cache"}).then(function(response) {
            switch (response.status) {
                case 200:
                    last = 'unit'
                    units.style.display="none";
                    unit.style.display="none";
                    section.style.display="inline-flex";
                    title.innerText="SEKCIA " + name;
                    openedSectionId = id;

                    history.style.display="flex";
                    sectionSettings.style.display="flex";
                    createSection.style.display="none";
                    createUnit.style.display="none";
                    createSensor.style.display="none";

                    settingsButton.addEventListener("click", openSettings)
                    //loadHistory.replaceWith(loadHistory.cloneNode(true));
                    //loadHistory.removeEventListener("click", openGraphs);
                    loadHistory.addEventListener("click", loadAndShow);

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
            console.log(data);
            section.innerHTML='';
            const h2 = document.createElement("h2")
            h2.innerText = data.name
            localStorage.setItem("section-"+id,JSON.stringify(data));
            data.sensors.forEach((sensor)=>{
                createItem(sensor.name,sensor.type,sensor.value,section)
            })

            setTime(data.time);

        }).catch(function(e) {
            console.log(e)
            switch (e.name){
                case "401":
                    window.location.replace("index.php?reqlog=true");
                    return;
                case "404":
                    appendMessage("danger", "Nepodarilo sa nájsť sekciu.")
                    return;
                case "other":
                    appendMessage("danger", "Chyba servera.")
                    return;
                default:
                    console.log("[log] offline section fetch")
                    appendOffile()
                    offlineSection(id)
            }
        });
    }
}
function createItem(name, type, value, section) {
    const item = document.createElement("div")
    const h2 = document.createElement("h2")
    h2.innerText = name
    item.append(h2)
    const h4 = document.createElement("h4")
    switch (type){
        case "level":
            h4.innerText = (value*100).toFixed(0) + "%";
            break;
        case "humidity":
            h4.innerText = (value*100).toFixed(1) + "%";
            break;
        case "temp":
            h4.innerText = parseFloat(value).toFixed(1) + "°";
            break;
        default:
            h4.innerText = parseFloat(value).toFixed(1).toString()
    }
    item.append(h4)

    item.classList.toggle("sec-item")
    item.classList.toggle(type)
    section.append(item)
}


function offlineSection(id) {
    let data;
    if (localStorage.getItem("section-" + id) != null) {
        data = JSON.parse(localStorage.getItem("section-" + id))

        last = 'unit'
        units.style.display="none";
        unit.style.display="none";
        section.style.display="inline-flex";
        history.style.display="flex";
        sectionSettings.style.display="flex";
        // settingsButton.addEventListener("click", openSettings)
        title.innerText="SEKCIA " + name;
        openedSectionId = id;

        section.innerHTML='';
        const h2 = document.createElement("h2")
        h2.innerText = data.name

        setTime(data.time);

        data.sensors.forEach((sensor)=>{
            createItem(sensor.name,sensor.type,sensor.value,section)
        })
    }
}

function setTime(seconds){
    timestamp.innerText = new Date(seconds * 1000).toLocaleString();
}

function openGraphs(id){
    console.log(id)
    loadAndShow(id);
}