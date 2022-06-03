
document.addEventListener("DOMContentLoaded", function () {
    let form = document.querySelector("#formAsistencia");

    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        locale: "es",
        headerToolbar: {
            right: "prev,next,today",
            center: "title",
        },

        events: document.URL+"/calendar",

        dateClick: function (info) {
            $("#editarAsistencia").modal("show");
            document.getElementById('date_a').setAttribute('value',info.dateStr);
        },
    });
    calendar.render();

    document
        .getElementById("guardarAsistencia")
        .addEventListener("click", function () {
            const data = new FormData(form);
            console.log(calendar.getDate());
            console.log(data);
            console.log(document.URL);
        });
});
