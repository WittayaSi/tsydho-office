let onClickEvent = (event, from) => {
    console.log(from)
    console.log(event)
    let start_date = (from === 'controller') ? new Date(event.start) : new Date(event.start_date);
    let new_start_date = [start_date.getFullYear(), ("0" + (start_date.getMonth()+1)).slice(-2), ("0" + (start_date.getDate())).slice(-2)].join("-");
	let end_date = (from === 'controller') ? new Date(event.end) : new Date(event.end_date);
    let end_date_2 = (from === 'controller') ? new Date(end_date.setDate(end_date.getDate()-1)) : end_date; 
    console.log(end_date_2);
    let new_end_date = [end_date_2.getFullYear(), ("0" + (end_date_2.getMonth() + 1)).slice(-2), 
    (from === 'controller') ? ("0" + (end_date_2.getDate())).slice(-2) : ("0" + (end_date_2.getDate())).slice(-2)].join("-");
    
    document.querySelector("#form-detail").action = "/frontend/tasks/" + event.id
    document.querySelector("#delete-form").action = "/frontend/tasks/" + event.id
    document.querySelector("#user_id").value = event.user_id
    document.querySelector("#task-s").value = (from === 'controller') ? event.title : event.task;
    document.querySelector("#description-s").value = event.description
    document.querySelector("#start_date_s").value = new_start_date
    document.querySelector("#end_date_s").value =  new_end_date
    document.querySelector("#end_date_s").min = new_start_date
    $("#detailTask").modal();
}

let onRenderEvent = (event, jsEvent) => {
	$(jsEvent).popover({
        title: event.title, 
        //content: event.description,
        trigger: "hover",
        placement: "top",
        container: "body"
    });
}
// $(document).ready(function() {
//     var initialLocaleCode = 'th';

//     $('#calendar').fullCalendar({
//         header: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'month,agendaWeek,agendaDay,listMonth'
//         },
//         events: [{
//                 title: 'event1',
//                 start: '2018-11-01',
//                 description: 'sldfkjsdlkfjsdlfkjsdlfkjsdflllllllllllllll'
//             },
//             {
//                 title: 'event2',
//                 start: '2018-11-02',
//                 end: '2018-11-04'
//             },
//             {
//                 title: 'event3',
//                 start: '2018-11-05T12:30:00',
//                 end: '2018-11-05T14:30:00',
//                 allDay: false // will make the time show
//             }
//         ],
//         locale: initialLocaleCode,
//         height: 650,
//         buttonIcons: false, // show the prev/next text
//         weekNumbers: true,
//         navLinks: true, // can click day/week names to navigate views
//         editable: true,
//         eventLimit: true, // allow "more" link when too many events
//         eventClick: function(calEvent, jsEvent, view) {

//             //alert('Event: ' + calEvent);
//             //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
//             //alert('View: ' + view.name);
//             document.getElementById("task-s").value=calEvent.title;
//             document.getElementById("description-s").value = calEvent.description;
//             document.getElementById("start_date-s").value = '2018-11-14';
//             // document.getElementById("end_date-s").value = calEvent.end;
//             //$('#eventUrl').attr('href',calEvent.url);
//             $('#detailTask').modal();

//             // change the border color just for fun
//             //$(this).css('border-color', 'red');

//           }
//     });
// });