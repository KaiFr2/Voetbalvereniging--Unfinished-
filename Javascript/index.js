function setDate(date) {
    window.location.href = window.location.pathname + "?date=" + date;
}

function showModal(title, location, description) {
    document.getElementById('modalHeader').innerText = title;
    document.getElementById('modalBodyOne').innerText = description;
    document.getElementById('modalBodyTwo').innerText = "Locatie: " + location;

    console.log(title, location, description);
}