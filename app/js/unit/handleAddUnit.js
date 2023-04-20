const unitErrorSpan = document.getElementById('create-unit-err-msg')
const unitErrorSpanDiv = document.getElementById('create-unit-err-msg-div')

function displayErrorMessage(msg) {
    unitErrorSpanDiv.classList.remove('hidden')
    unitErrorSpan.innerText = msg
    document.getElementById("validate-form-unit-button").disabled = false;
}

function displaySuccessMessage(msg) {
    errorSpanDiv.classList.remove('hidden')
    errorSpan.innerHTML = msg
    document.getElementById("validate-form-button").disabled = false;
}


document.getElementById("validate-form-unit-button").addEventListener('click', addUnitFormSubmit)

function addUnitFormSubmit() {
    let request = new XMLHttpRequest()
    request.onreadystatechange=function() {
        if (request.readyState === 4 && request.status !== 201) {
            displayErrorMessage(request.responseText)
        } else if (request.readyState === 4) {
            if (!errorSpanDiv.classList.contains('hidden')) errorSpanDiv.classList.add('hidden')
            document.getElementById("create-unit-modal-close").click();
            document.getElementById("validate-form-unit-button").disabled = false;
            console.log(request.responseText)
            openUnits()
            appendMessage("success", "Jednotka úspešne vytvorená")
        }
    }
    request.open('POST', "/api/units/create.php", true);
    request.send(new FormData(document.getElementById('create-unit-form')));
}
