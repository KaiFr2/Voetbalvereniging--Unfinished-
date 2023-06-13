function setDate(date) {
    window.location.href = window.location.pathname + "?date=" + date;
}

function showModal(title, location, description) {
    document.getElementById('modalHeader').innerText = title;
    document.getElementById('modalBodyOne').innerText = description;
    document.getElementById('modalBodyTwo').innerText = "Locatie: " + location;

<<<<<<< HEAD
    console.log(title, location, description);
=======
    console.log(title,description,location);
>>>>>>> 0c9260b69b1b73413371bf32113bf31bd31fc2f6
}