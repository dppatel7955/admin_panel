<div>
    <div class="cursor-pointer bg-blue-100 text-blue-700 px-3 py-1 rounded-full" wire:click='sendmail()'>
        Send Mail
    </div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div>
        <div>
            <input wire:model="template.key" placeholder="Key" class="input">
            <input wire:model="template.name" placeholder="Name" class="input">
            <input wire:model="template.subject" placeholder="Subject" class="input">
            <textarea wire:model="template.body" rows="10"></textarea>
        </div>
        <div>
            <button wire:click="save">Save</button>
        </div>
        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif
    </div>
</div>
