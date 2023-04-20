const sectionErrorSpan = document.getElementById('create-section-err-msg')
const sectionErrorSpanDiv = document.getElementById('create-section-err-msg-div')

function displayErrorMessage(msg) {
    sectionErrorSpanDiv.classList.remove('hidden')
    sectionErrorSpan.innerText = msg
    document.getElementById("validate-form-section-button").disabled = false;
}

document.getElementById("validate-form-section-button").addEventListener('click', addSectionFormSubmit)

function addSectionFormSubmit() {
    const sectionForm = document.getElementById('create-section-form')
    if (document.getElementById('section-name').value === '') {
        displayErrorMessage("Neplatné meno sekcie")
        return
    } else if (document.getElementById('section-valve').value === '') {
        displayErrorMessage("Neplatné ID ventilu")
        return
    }
    let unitIdField = document.createElement("input");
    unitIdField.setAttribute("type", "hidden");
    unitIdField.setAttribute("name", "unit");
    unitIdField.value = lastUnitId
    sectionForm.appendChild(unitIdField);
    let request = new XMLHttpRequest()
    request.onreadystatechange=function() {
        if (request.readyState === 4 && request.status !== 201) {
            displayErrorMessage(request.responseText)
        } else if (request.readyState === 4) {
            if (!errorSpanDiv.classList.contains('hidden')) errorSpanDiv.classList.add('hidden')
            document.getElementById("create-section-modal-close").click();
            document.getElementById("validate-form-section-button").disabled = false;
            console.log(request.responseText)
            openUnit(lastUnitId)
            appendMessage("success", "Sekcia úspešne vytvorená")
        }
    }
    request.open('POST', "/api/sections/create.php", true);
    request.send(new FormData(document.getElementById('create-section-form')));
}
