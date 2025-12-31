<div>
    <div id="eventModal"
         class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">
                {{ $eventId ? 'Edit Event' : 'Create Event' }}
            </h2>

            <input wire:model.defer="title"
                   class="border p-2 w-full mb-2"
                   placeholder="Title">

            <textarea wire:model.defer="description"
                      class="border p-2 w-full mb-2"
                      placeholder="Description"></textarea>

            <input type="datetime-local"
                   wire:model.defer="start"
                   class="border p-2 w-full mb-2">

            <input type="datetime-local"
                   wire:model.defer="end"
                   class="border p-2 w-full mb-4">

            <div class="flex justify-end gap-2">
                <button onclick="hideModal()"
                        class="px-4 py-2 bg-gray-300 rounded">
                    Cancel
                </button>

                <button wire:click="save"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                    Save
                </button>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('show-event-modal', () => {
            document.getElementById('eventModal').classList.remove('hidden');
        });

        window.addEventListener('hide-event-modal', () => {
            document.getElementById('eventModal').classList.add('hidden');
        });

        function hideModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }
    </script>
</div>
