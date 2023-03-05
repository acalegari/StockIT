window.onload = () =>  {
let calendarElt = document.querySelector('#calendar');
var calendar = new FullCalendar.Calendar(calendarElt, {
            initialView: 'timeGridWeek',
            locale: 'fr',
            timeZone: 'Europe/Paris',
            buttonText: {
                today:    'Aujourd\'hui',
                month:    'Mois',
                week:     'Semaine',
                day:      'Jour',
                list:     'Liste'
            },
            headerToolbar: {
                start: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            editable: true,
            eventResizableFromStart: true,
            displayEventTime: false, // don't show the time column in list view
            googleCalendarApiKey: 'AIzaSyBc97RTnmI53iNiNIltNWcZ-1Y_FxI84Qg',
            events: {
            googleCalendarId: 'e29430e7a68d23a129cf9aedb44af5107519dcf31278809efb690b6841bbc8af@group.calendar.google.com'
            }
        })

        // calendar.on('eventChange', (e) => {
        //     let url = ` https://www.googleapis.com/calendar/v3/calendars/calendarId/events/eventId`
        //     let donnees = {
        //         "title": e.event.title,
        //         "description": e.event.extendedProps.description,
        //         "start": e.event.start,
        //         "end": e.event.end,
        //         "backgroundColor": e.event.backgroundColor,
        //         "borderColor": e.event.borderColor,
        //         "textColor": e.event.textColor,
        //         "allDay": e.event.allDay,
        //         "id": e.event.id
        //     }

        //     console.log(donnees);
            
        //     let xhr = new XMLHttpRequest
        //     xhr.send(JSON.stringify(donnees))
        // })

        calendar.render();

        

};