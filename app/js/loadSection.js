function openSection(name, id){
    last = 'unit'
    if(window.navigator.onLine === false){
        appendOffile()
        offlineSection()
    }else{
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
            localStorage.setItem("section-"+id,JSON.stringify(data));

            createItem("Hladina v nádrži","level",data.waterLevel*100 + "%",section)
            createItem("UV index","uv",data.uvIndex,section)
            createItem("Teplota vzduchu","temp",data.airTemperature + "°",section)
            data.humidity.forEach((sensor)=>{
                createItem("Vlhkosť v kvetináči ("+sensor.sensorId+")","hum",sensor.value*100 + "%",section)
            })

        }).catch(function(e) {
            console.log(e)
            appendOffile()
            offlineSection()
        });
    }
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


function offlineSection(id) {
    if(localStorage.getItem("units")!=null){
        units.innerHTML='';
        data = JSON.parse(localStorage.getItem("section-"+id))
        createItem("Hladina v nádrži","level",data.waterLevel*100 + "%",section)
        createItem("UV index","uv",data.uvIndex,section)
        createItem("Teplota vzduchu","temp",data.airTemperature + "°",section)
        data.humidity.forEach((sensor)=>{
            createItem("Vlhkosť v kvetináči ("+sensor.sensorId+")","hum",sensor.value*100 + "%",section)
        })
    }
}