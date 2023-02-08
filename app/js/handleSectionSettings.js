if (document.querySelector('input[name="mode"]')) {
    document.querySelectorAll('input[name="mode"]').forEach((elem) => {
        elem.addEventListener("change", function(event) {
            errorSpanDiv.classList.add('hidden')
            const humiditySection = document.getElementById('humidity-section')
            const timeSection = document.getElementById('time-section')
            switch (event.target.value) {
                case 'manual':
                    humiditySection.classList.add('hidden')
                    timeSection.classList.add('hidden')
                    break
                case 'auto':
                    timeSection.classList.add('hidden')
                    humiditySection.classList.remove('hidden')
                    break
                case 'timed':
                    timeSection.classList.remove('hidden')
                    humiditySection.classList.add('hidden')
                    break
            }
        });
    });
}

const errorSpan = document.getElementById('err-msg')
const errorSpanDiv = document.getElementById('err-msg-div')

function displayErrorMessage(msg) {
    errorSpanDiv.classList.remove('hidden')
    errorSpan.innerHTML = msg
}

function settingsValidator () {
    if(wateringTime.value <= 0) {
        displayErrorMessage("neplatná doba zavlažovania", wateringTime)
        return
    }
    if(document.getElementById('radio-timed').checked) {
        let inputDate1 = document.getElementById('date-time-1');
        let inputDate2 = document.getElementById('date-time-2');
        if(!inputDate1.value || !inputDate2.value) {
            displayErrorMessage("neplatný čas závlahy")
            return
        }
    } else if(document.getElementById('radio-auto').checked) {
        const humInput = document.getElementById('input-range')
        if (humInput.value < 1 || humInput.value > 100) {
            displayErrorMessage("neplatná hranica vlhkosti")
            return
        }
    }
    errorSpanDiv.classList.add('hidden')
    let sectionIdField = document.createElement("input");
    sectionIdField.setAttribute("type", "hidden");
    sectionIdField.setAttribute("name", "section-id");
    sectionIdField.value = openedSectionId
    document.getElementById('settings-form').appendChild(sectionIdField);
    formSubmit()
}

function formSubmit() {
    let request = new XMLHttpRequest()
    request.onreadystatechange=function() {
        if (request.readyState === 4 && request.status !== 200) {
            displayErrorMessage(request.responseText)
        } else if (request.readyState === 4) {
            if (!errorSpanDiv.classList.contains('hidden')) errorSpanDiv.classList.add('hidden')
            document.getElementById("setting-modal-close").click();
            console.log(request.responseText)
        }
    }
    request.open('POST', "../../api/sections/settings.php", true);
    request.send(new FormData(document.getElementById('settings-form')));
}
