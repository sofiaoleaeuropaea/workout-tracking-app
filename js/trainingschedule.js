document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'title',
      right: 'prev,next today',
      center: 'dayGridMonth,timeGridWeek',
    },
    eventSources: [
      {
        url: '/gymtracker/completedworkouts/',
        color: '#256f5d',
      },
      {
        url: '/gymtracker/scheduledworkouts/',
        color: '#FFC107',
      },
    ],
  });
  calendar.render();
});
