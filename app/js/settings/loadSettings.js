const wateringTime = document.getElementById('watering-time')

function openSettings() {
    const dateTime1 = document.getElementById('date-time-1');
    const dateTime2 = document.getElementById('date-time-2');

    if (!openedSectionId){
        return;
    }
    let url = "/api/sections/settings.php?id="+openedSectionId
    const ms = Date.now();
    fetch(url+"&time="+ms, {cache: 'no-store'}).then(function(response) {
        switch (response.status) {
            case 200:
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
        console.log(data)
        const settingsHeader = document.getElementById('settings-header')
        settingsHeader.innerHTML = "Nastavenia - " + data.name
        const autoRadio = document.getElementById('radio-auto')
        const timedRadio = document.getElementById('radio-timed')
        const manualRadio = document.getElementById('radio-manual')
        // const humiditySlider = document.getElementById('slider-humidity')
        // const wateringTimeSection = document.getElementById('water-amount')
        const humiditySection = document.getElementById('humidity-section')
        const timeSection = document.getElementById('time-section')
        wateringTime.value = Math.round(data.waterTime / 1000)
        const humidityInput = document.getElementById('input-range')
        const humidityText = document.getElementById('span-range')
        humidityInput.value = data.minHumidity
        humidityText.textContent = data.minHumidity + '%'
        const logInterval = document.getElementById('log-interval')
        logInterval.value = Math.round(data.logInterval / 60000)
        if (data.waterStart != null) {
            if (new Date(data.waterStart) < new Date()) {
                console.log('prepocitat');
                console.log(new Date() - new Date(data.waterStart))
                let offset = new Date(data.waterNext) - new Date(data.waterStart)
                let current = new Date(data.waterStart)
                while(current.getTime() < Date.now()){
                    console.log("here")
                    current = new Date(current.getTime() + offset);
                    console.log("IN " + current)
                }
                console.log("NEW1 " + current)
                let next = new Date(current.getTime() + offset);
                console.log("NEW2 " + next)
                dateTime1.value = (new Date(current.getTime() - current.getTimezoneOffset() * 60000).toISOString()).slice(0, -1);
                dateTime2.value = (new Date(next.getTime() - next.getTimezoneOffset() * 60000).toISOString()).slice(0, -1);

            } else {
                console.log('vsecko v poradku');
                dateTime1.value = data.waterStart.replace(/\s/g, "T");
                if (data.waterNext != null) {
                    dateTime2.value = data.waterNext.replace(/\s/g, "T");
                }
            }


        }
        // pickedTimestamp = data.waterStart
        // nextPickedTimestamp = data.waterNext
        switch (data.mode) {
            case 'auto':
                autoRadio.checked = true;
                humiditySection.classList.remove('hidden')
                timeSection.classList.add('hidden')
                break
            case 'timed':
                timedRadio.checked = true;
                timeSection.classList.remove('hidden')
                humiditySection.classList.add('hidden')
                break
            case 'manual':
                manualRadio.checked = true;
                humiditySection.classList.add('hidden')
                timeSection.classList.add('hidden')
                break
        }
    }).catch(function(e) {
        console.log(e)
        switch (e.name){
            case "401":
                window.location.replace("index.php?reqlog=true");
                return;
            case "404":
                appendMessage("danger", "Nepodarilo sa nájsť nastavenia pre sekciu.")
                return;
            case "other":
                appendMessage("danger", "Chyba servera.")
                return;
            default:
                appendOffile()
        }

    });
}