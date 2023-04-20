const sensorErrorSpan = document.getElementById('create-sensor-err-msg')
const sensorErrorSpanDiv = document.getElementById('create-sensor-err-msg-div')

function displayErrorMessage(msg) {
    sensorErrorSpanDiv.classList.remove('hidden')
    sensorErrorSpan.innerText = msg
    document.getElementById("validate-form-sensor-button").disabled = false;
}

document.getElementById("validate-form-sensor-button").addEventListener('click', addSensorFormSubmit)

function addSensorFormSubmit() {
    const sensorForm = document.getElementById('create-sensor-form')
    if (document.getElementById('sensor-name').value === '') {
        displayErrorMessage("Neplatné meno senzoru")
        return
    } else if (document.getElementById('sensor-id').value === '') {
        displayErrorMessage("Neplatné ID senzoru (hw)")
        return
    } else if (document.getElementById('sensor-type').options[document.getElementById('sensor-type').selectedIndex].value
        === 'humidity' && document.getElementById('sensor-section-id').value === '') {
        displayErrorMessage("Neplatné ID sekcie pre senzor")
        return
    }
    let unitIdField = document.createElement("input");
    unitIdField.setAttribute("type", "hidden");
    unitIdField.setAttribute("name", "unit");
    unitIdField.value = lastUnitId
    sensorForm.appendChild(unitIdField);
    let request = new XMLHttpRequest()
    request.onreadystatechange=function() {
        if (request.readyState === 4 && request.status !== 201) {
            displayErrorMessage(request.responseText)
        } else if (request.readyState === 4) {
            if (!errorSpanDiv.classList.contains('hidden')) errorSpanDiv.classList.add('hidden')
            document.getElementById("create-sensor-modal-close").click();
            document.getElementById("validate-form-sensor-button").disabled = false;
            console.log(request.responseText)
            // openUnit(lastUnitId)
            appendMessage("success", "Senzor úspešne vytvorená")
        }
    }
    request.open('POST', "/api/sensors/create.php", true);
    request.send(new FormData(document.getElementById('create-sensor-form')));
}
