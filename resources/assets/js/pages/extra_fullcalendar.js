/* ------------------------------------------------------------------------------
*
*  # Fullcalendar basic options
*
*  Specific JS code additions for extra_fullcalendar_views.html and 
*  extra_fullcalendar_styling.html pages
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Add events
    // ------------------------------

    // Default events
    var events = [
        {
            title: 'All Day Event',
            start: '2016-08-01'
        },
        {
            title: 'Long Event',
            start: '2016-08-07',
            end: '2016-08-10'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2016-08-09T16:00:00'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2016-08-16T16:00:00'
        },
        {
            title: 'Conference',
            start: '2016-08-11',
            end: '2016-08-13'
        },
        {
            title: 'Meeting',
            start: '2016-08-12T10:30:00',
            end: '2016-08-12T12:30:00'
        },
        {
            title: 'Lunch',
            start: '2016-08-12T12:00:00'
        },
        {
            title: 'Meeting',
            start: '2016-08-12T14:30:00'
        },
        {
            title: 'Happy Hour',
            start: '2016-08-12T17:30:00'
        },
        {
            title: 'Dinner',
            start: '2016-08-12T20:00:00'
        },
        {
            title: 'Birthday Party',
            start: '2016-08-13T07:00:00'
        },
        {
            title: 'Click for Google',
            url: 'http://google.com/',
            start: '2016-08-28'
        }
    ];


    // Event colors
    var eventColors = [
        {
            title: 'All Day Event',
            start: '2016-08-01',
            color: '#EF5350'
        },
        {
            title: 'Long Event',
            start: '2016-08-07',
            end: '2016-08-10',
            color: '#26A69A'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2016-08-09T16:00:00',
            color: '#26A69A'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2016-08-16T16:00:00',
            color: '#5C6BC0'
        },
        {
            title: 'Conference',
            start: '2016-08-11',
            end: '2016-08-13',
            color: '#546E7A'
        },
        {
            title: 'Meeting',
            start: '2016-08-12T10:30:00',
            end: '2016-08-12T12:30:00',
            color: '#546E7A'
        },
        {
            title: 'Lunch',
            start: '2016-08-12T12:00:00',
            color: '#546E7A'
        },
        {
            title: 'Meeting',
            start: '2016-08-12T14:30:00',
            color: '#546E7A'
        },
        {
            title: 'Happy Hour',
            start: '2016-08-12T17:30:00',
            color: '#546E7A'
        },
        {
            title: 'Dinner',
            start: '2016-08-12T20:00:00',
            color: '#546E7A'
        },
        {
            title: 'Birthday Party',
            start: '2016-08-13T07:00:00',
            color: '#546E7A'
        },
        {
            title: 'Click for Google',
            url: 'http://google.com/',
            start: '2016-08-28',
            color: '#FF7043'
        }
    ];


    // Event background colors
    var eventBackgroundColors = [
        {
            title: 'All Day Event',
            start: '2016-08-01'
        },
        {
            title: 'Long Event',
            start: '2016-08-07',
            end: '2016-08-10',
            color: '#DCEDC8',
            rendering: 'background'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2016-08-06T16:00:00'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2016-08-16T16:00:00'
        },
        {
            title: 'Conference',
            start: '2016-08-11',
            end: '2016-08-13'
        },
        {
            title: 'Meeting',
            start: '2016-08-12T10:30:00',
            end: '2016-08-12T12:30:00'
        },
        {
            title: 'Lunch',
            start: '2016-08-12T12:00:00'
        },
        {
            title: 'Happy Hour',
            start: '2016-08-12T17:30:00'
        },
        {
            title: 'Dinner',
            start: '2016-08-24T20:00:00'
        },
        {
            title: 'Meeting',
            start: '2016-08-03T10:00:00'
        },
        {
            title: 'Birthday Party',
            start: '2016-08-13T07:00:00'
        },
        {
            title: 'Vacation',
            start: '2016-08-27',
            end: '2016-08-30',
            color: '#FFCCBC',
            rendering: 'background'
        }
    ];



    // Initialization
    // ------------------------------

    // Basic view
    $('.fullcalendar-basic').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultDate: '2016-08-12',
        editable: true,
        events: events
    });


    // Agenda view
    $('.fullcalendar-agenda').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2016-08-12',
        defaultView: 'agendaWeek',
        editable: true,
        events: events
    });


    // Event colors
    $('.fullcalendar-event-colors').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2016-08-12',
        editable: true,
        events: eventColors
    });


    // Event background colors
    $('.fullcalendar-background-colors').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2016-08-12',
        editable: true,
        events: eventBackgroundColors
    });

});
