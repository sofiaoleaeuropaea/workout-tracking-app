document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'title',
      right: 'prev,next today',
      center: 'dayGridMonth,timeGridWeek',
    },
    displayEventTime: false,
    eventSources: [
      {
        url: '/gymtracker/completed-workouts/',
        color: '#256f5d',
      },
      {
        url: '/gymtracker/scheduled-workouts/',
        color: '#FFC107',
      },
    ],
  });
  calendar.render();
});
