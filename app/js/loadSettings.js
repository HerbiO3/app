const wateringTime = document.getElementById('watering-time')

let url = "/api/users/super_check.php?"
const ms = Date.now();
fetch(url+"&time="+ms, {cache: 'no-store'}).then(function(response) {
    switch (response.status) {
        case 202:
            break;
        case 206:
            document.getElementById('settings-button').classList.add('hidden')
            break;
        default:
            document.getElementById('settings-button').classList.add('hidden')
    }
})

function openSettings() {

    // let myPicker = new SimplePicker({
    //     zIndex: 51
    // });
    // let myPicker2 = new SimplePicker({
    //     zIndex: 51
    // });
    // const openDateTime1 = document.getElementById('simplepicker-btn');
    // const openDateTime2 = document.getElementById('simplepicker-btn-2');
    // openDateTime1.addEventListener('click', (e) => {
    //     myPicker.open();
    // });
    // openDateTime2.addEventListener('click', (e) => {
    //     myPicker2.open();
    // });
    //
    // myPicker.on('submit', function(date, readableDate){
    //     convertDate(date)
    //     pickedTimestamp = date
    // })
    // myPicker2.on('submit', function(date, readableDate){
    //     convertDate(date)
    //     nextPickedTimestamp = date
    // })

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
        // if (data.waterStart === null) {
        //     openDateTime1.innerHTML = '🕒 ' + 'Nenastavený'
        // } else {
        //     openDateTime1.innerHTML = '🕒 ' + data.waterStart
        // }
        // if (data.waterNext === null) {
        //     openDateTime2.innerHTML = '🕒 ' + 'Nenastavený'
        // } else {
        //     openDateTime2.innerHTML = '🕒 ' + data.waterNext
        // }
        if (data.waterStart != null) {
            dateTime1.value = data.waterStart.replace(/\s/g, "T");
        }
        if (data.waterNext != null) {
            dateTime2.value = data.waterNext.replace(/\s/g, "T");
        }
        // pickedTimestamp = data.waterStart
        // nextPickedTimestamp = data.waterNext
        switch (data.mode) {
            case 'auto':
                autoRadio.checked = true;
                humiditySection.classList.remove('hidden')
                timeSection.classList.add('hidden')
                // humiditySlider.classList.remove('hidden')
                // const rangeBar = document.getElementById('range-bar')
                // const leftThumb = document.getElementById('thumb-left')
                // const rightThumb = document.getElementById('thumb-right')
                // const leftSign = document.getElementById('sign-left')
                // const rightSign = document.getElementById('sign-right')
                // const leftSignValue = document.getElementById('sign-left-value')
                // const rightSignValue = document.getElementById('sign-right-value')
                // const minHumidityInput = document.getElementById('min-humidity-input')
                // const maxHumidityInput = document.getElementById('max-humidity-input')
                // rangeBar.style.left = data.minHumidity+"%"
                // leftThumb.style.left = data.minHumidity+"%"
                // leftSign.style.left = data.minHumidity+"%"
                // leftSignValue.innerHTML = data.minHumidity
                // minHumidityInput.value = data.minHumidity
                break
            case 'timed':
                timedRadio.checked = true;
                timeSection.classList.remove('hidden')
                humiditySection.classList.add('hidden')
                // humiditySlider.classList.add('hidden')
                break
            case 'manual':
                manualRadio.checked = true;
                humiditySection.classList.add('hidden')
                timeSection.classList.add('hidden')
                // humiditySlider.classList.add('hidden')
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