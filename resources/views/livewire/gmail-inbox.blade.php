<div>
    <h2 class="text-xl font-bold mb-4">Inbox</h2>

    @if(empty($messages))
        <p>No emails found. <a href="{{ route('gmail.connect') }}" class="text-blue-500">Connect Gmail</a></p>
    @else
        <ul>
            @foreach($messages as $mail)
                <li class="mb-3 p-2 border rounded">
                    <strong>{{ $mail['subject'] }}</strong> <br>
                    From: {{ $mail['from'] }} <br>
                    {{ $mail['snippet'] }}
                </li>
            @endforeach
        </ul>
    @endif
    @if($nextPageToken)
        <div class="flex justify-center mt-4">
            <button
                wire:click="loadMessages"
                wire:loading.attr="disabled"
                class="btn-secondary text-sm flex items-center gap-2">

                <svg wire:loading class="w-4 h-4 animate-spin"
                     fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12"
                            r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>

                <span wire:loading.remove>Load More</span>
                <span wire:loading>Loading...</span>
            </button>
        </div>
    @endif
</div>
