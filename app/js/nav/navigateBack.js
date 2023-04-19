const back = document.getElementById("back")
let last = "units"
back.addEventListener("click", ()=>{
    units.style.display = 'none'
    unit.style.display = 'none'
    section.style.display = 'none'
    switch (last) {
        case "units":
            openUnits();
            break
        case "unit":
            last = 'units'
            openUnit(lastUnitId)
            break
    }
})
