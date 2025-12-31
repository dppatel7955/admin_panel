<div class="p-4 space-y-4">

    <div wire:ignore>
        <div id="calendar"></div>
    </div>

    @livewire('event-form')

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('livewire:init', () => {

    const calendar = new FullCalendar.Calendar(
        document.getElementById('calendar'),
        {
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            eventResizableFromStart: true,

            events: @json($events),

            /* CREATE */
            dateClick(info) {
                Livewire.dispatch('openCreateModal', {
                    date: info.dateStr
                });
            },

            /* EDIT */
            eventClick(info) {
                Livewire.dispatch('openEditModal', {
                    id: info.event.id
                });
            },

            /* DRAG */
            eventDrop(info) {
                Livewire.dispatch('updateEventDate', {
                    id: info.event.id,
                    start: info.event.start.toISOString(),
                    end: info.event.end ? info.event.end.toISOString() : null
                });
            },

            /* RESIZE */
            eventResize(info) {
                Livewire.dispatch('updateEventDate', {
                    id: info.event.id,
                    start: info.event.start.toISOString(),
                    end: info.event.end.toISOString()
                });
            }
        }
    );

    calendar.render();

    Livewire.on('eventAdded', () => {
        calendar.removeAllEvents();
        calendar.addEventSource(@json($events));
    });
});
</script>
