const start = document.getElementById("date-start")
const end = document.getElementById("date-end")
const today = document.getElementById("set-history-today")
const day = document.getElementById("set-history-24")
const week = document.getElementById("set-history-week")
const month = document.getElementById("set-history-month")

const todayDate = new Date().toLocaleDateString('en-US', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
})
const yesterday = new Date(Date.now() - 86400000).toLocaleDateString('en-US', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
});
const weekDate = new Date(Date.now() - 86400000*7).toLocaleDateString('en-US', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
});
const monthDate = new Date(Date.now() - 86400000*30).toLocaleDateString('en-US', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
});

today.addEventListener("click", ()=>{
    start.value = todayDate;
    end.value = todayDate;
})
day.addEventListener("click", ()=>{
    start.value = yesterday;
    end.value = todayDate;
})
week.addEventListener("click", ()=>{
    start.value = weekDate;
    end.value = todayDate;
})
month.addEventListener("click", ()=>{
    start.value = monthDate;
    end.value = todayDate;
})
