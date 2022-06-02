document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        locale:'es',
        headerToolbar:{
            right: 'prev,next,today',
            center: 'title',
        },

        dateClick:function(info){
            $("#editarAsistencia").modal("show");
        }
    });
    calendar.render();
});
