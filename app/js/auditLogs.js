const API_URL = "/api/logs";
const table = document.getElementById("logs");
let from
let to = 0;
let total
let max = 0;
async function fetchItems(page = 1, itemsPerPage = 10) {
    const response = await fetch(
        `${API_URL}?page=${page}&per_page=${itemsPerPage}`
    );
    from = (page-1)*itemsPerPage+1;
    to = page*itemsPerPage;
    return response.json();
}

async function displayPage(page) {

    const data = await fetchItems(page);
    // Clear existing items from the page
    while (table.rows.length > 1) {
        table.deleteRow(1);
    }

    // Add new data to the table
    data.logs.forEach((rowData) => {
        const row = table.insertRow();
        row.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600";
        const cellTime = row.insertCell(0);
        cellTime.innerHTML = rowData.time;
        cellTime.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white";
        const cellEmail = row.insertCell(1);
        cellEmail.innerHTML = rowData.email;
        cellEmail.className = "px-6 py-4";
        const cellType = row.insertCell(2);
        cellType.innerHTML = rowData.type;
        cellType.className = "px-6 py-4";
        const cellInfo = row.insertCell(3);
        cellInfo.innerHTML = rowData.info;
        cellInfo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white";
    });
    // Update the current page number
    max = data.count;
    document.querySelector("#current-page").innerText = page;
    document.querySelector("#from-entry").innerText = from;
    document.querySelector("#to-entry").innerText = Math.min(max, to);
    document.querySelector("#total-entry").innerText = max;

    //document.querySelector("#total-entry").innerText = total;

}

// Display the first page when the page loads
displayPage(1);

// Add event listeners for the "Next" and "Previous" buttons
document.querySelector("#next-page").addEventListener("click", () => {
    let currentPage = parseInt(document.querySelector("#current-page").innerText);
    if(to < max){
        displayPage(currentPage + 1);
    }
});
document.querySelector("#previous-page").addEventListener("click", () => {
    let currentPage = parseInt(document.querySelector("#current-page").innerText);
    if(currentPage > 1){
        displayPage(currentPage - 1);
    }
});
