<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with()
    {
        return [
            'notesSentCount' => Auth::user()->notes()->where('send_date', '<', now())->where('is_published', true)->count(),

            'notesLovedCount' => Auth::user()->notes->sum('heart_count'),
        ];
    }
}; ?>

<div>
    <div class="flex justify-center space-x-20">
        <div>
            <div class="flex items-center text-2xl text-left text-gray-500">
                <label>Sent.</label>
            </div>
            <div class="flex items-center justify-center bg-white border rounded shadow-lg h-52 w-96">
                <div class="text-4xl font-bold text-center text-gray-800">
                <div class="flex items-center">
                    {{ $notesSentCount }}
                <x-icon name="paper-airplane" class="w-5 h-5 ml-3 rotate-45" />
                </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center text-2xl text-left text-gray-500">
                <label>Liked.</label>
            </div>
            <div class="flex items-center justify-center bg-white border rounded shadow-lg h-52 w-96">
                <div class="text-4xl font-bold text-center text-gray-800">
                 <div class="flex items-center">
                    {{ $notesLovedCount }}
                <x-icon name="heart" class="w-5 h-5 ml-3" />
                </div>
            </div>
        </div>
    </div>
</div>
