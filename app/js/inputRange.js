const input_range = document.getElementById('input-range')
input_range.addEventListener('input', () => {
    var getValRange = input_range.value
    document.getElementById('span-range').innerText = getValRange + '%'
})