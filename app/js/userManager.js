const USER_API_URL = "/api/users";
const user_table = document.getElementById("users");
let user_from
let user_to = 0;
let user_total
let user_max = 0;
let user_email = null;

async function fetchItems(email, page = 1, itemsPerPage = 10) {
    const response = await fetch(
        `${USER_API_URL}?page=${page}&per_page=${itemsPerPage}&email=${email}`
    );
    console.log(response.url)
    user_from = (page-1)*itemsPerPage+1;
    user_to = page*itemsPerPage;
    return response.json();
}

async function displayPage(page) {

    const data = await fetchItems(user_email, page);
    // Clear existing items from the page
    while (user_table.rows.length > 1) {
        user_table.deleteRow(1);
    }

    // Add new data to the table
    data.users.forEach((rowData) => {
        const row = user_table.insertRow();
        row.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700";
        const cellId = row.insertCell(0);
        cellId.innerHTML = rowData.id;
        cellId.className = "px-6 py-4";
        const cellEmail = row.insertCell(1);
        cellEmail.innerHTML = rowData.email;
        cellEmail.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white";
        const cellVerified = row.insertCell(2);
        cellVerified.className = 'text-center'
        const verifiedLabel = document.createElement("label")
        verifiedLabel.className = "relative inline-flex items-center cursor-pointer"
        let verifiedInput = document.createElement('input')
        verifiedInput.setAttribute('type', 'checkbox')
        verifiedInput.className = "sr-only peer"
        if (rowData.verified === 1) {
            verifiedInput.checked = true
        }
        verifiedLabel.appendChild(verifiedInput)
        const verifiedDiv = document.createElement('div')
        verifiedDiv.className = "w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
        verifiedLabel.appendChild(verifiedDiv)
        cellVerified.appendChild(verifiedLabel)
        const cellSuperuser = row.insertCell(3);
        cellSuperuser.className = 'text-center'
        const superUserLabel = document.createElement("label")
        superUserLabel.className = "relative inline-flex items-center cursor-pointer"
        let superUserInput = document.createElement('input')
        superUserInput.setAttribute('type', 'checkbox')
        superUserInput.className = "sr-only peer"
        if (rowData.superuser === 1) {
            superUserInput.checked = true
        }
        superUserLabel.appendChild(superUserInput)
        const superUserDiv = document.createElement('div')
        superUserDiv.className = "w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
        superUserLabel.appendChild(superUserDiv)
        cellSuperuser.appendChild(superUserLabel)
        const cellAction = row.insertCell(4);
        cellAction.className = 'text-center'
        const actionButton = document.createElement('button')
        actionButton.type = 'button'
        actionButton.className = 'text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3.5 py-1.5 text-center mr-2 my-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800'
        actionButton.innerText = 'Nastav'
        actionButton.addEventListener('click',  () => {
            changeUserPrivilages(rowData.id, verifiedInput.checked, superUserInput.checked)
        });
        cellAction.appendChild(actionButton)
    });
    // Update the current page number
    user_max = data.count;
    document.querySelector("#current-page-users").innerText = page;
    document.querySelector("#from-entry-users").innerText = user_from;
    document.querySelector("#to-entry-users").innerText = Math.min(user_max, user_to);
    document.querySelector("#total-entry-users").innerText = user_max;
}

// Display the first page when the page loads
displayPage(1);

// Add event listeners for the "Next" and "Previous" buttons
document.querySelector("#next-page-users").addEventListener("click", () => {
    let currentPage = parseInt(document.querySelector("#current-page-users").innerText);
    if(user_to < user_max){
        displayPage(currentPage + 1);
    }
});
document.querySelector("#previous-page-users").addEventListener("click", () => {
    let currentPage = parseInt(document.querySelector("#current-page-users").innerText);
    if(currentPage > 1){
        displayPage(currentPage - 1);
    }
});

document.querySelector("#user-email-filter").addEventListener("click", () => {
    user_email = document.querySelector("#search-user-dropdown").value
    if (user_email === "") user_email = null;
    displayPage(1);
});

function changeUserPrivilages(user_id, verified, superuser) {
    let xh_request = new XMLHttpRequest();

    xh_request.onreadystatechange=function() {
        if (xh_request.readyState === 4 && xh_request.status === 200) {
            console.log(xh_request.responseText)
        }
    }

    xh_request.open("POST", USER_API_URL+'/index.php', true);
    xh_request.setRequestHeader('Content-Type', 'application/json');
    xh_request.send(JSON.stringify({
        userId: user_id,
        verified: verified,
        superUser: superuser
    }));
}
