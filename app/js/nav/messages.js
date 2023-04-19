const msgs = document.getElementById("notifications")
function appendMessage(type, message){
    const info = document.createElement("p");
    info.innerText = message
    info.classList.toggle(type)
    msgs.append(info);
}

function cleanMessages(){
    msgs.innerHTML='<p id="offline" class="danger" style="display: none"></p>';
}
