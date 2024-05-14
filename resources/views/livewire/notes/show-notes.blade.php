<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'notes' => Auth::user()->notes()->orderBy('send_date', 'asc')->get(),
        ];
    }
};
?>

<div>
    <div class="space-y-2">
    @if($notes->isEmpty())
        <div class="text-center text-gray-500">
            <p class="text-xl font-bold">No notes yet</p>
            <p class="text-sm">Let's create your first note to send.</p>
        <x-button primary icon-right="plus" class="mt-6" href="{{route('notes.create')}}" wire:navigate>Create note</x-button>
        </div>
    @else       
        {{-- @foreach ($notes as $note) 
    no x card abaixo
    wire:key='{{ $note->id }}
    --}}
        <div class="grid grid-cols-2 gap-4 mt-12">
            <x-card>
                <div class="flex justify-between">
                    <a href="#" class="text-xl font-bold hover:underline hover:text-blue-500">
                        {{-- {{ $note->title }} --}}
                        Aq ta as notas(lembrar de descomentar)
                    </a>
                    <div class="text-xs text-gray-500">
                        {{-- /Carbon/Carbon::parse($note->send_date)->format('M-d-Y') --}}
                        May-14-2024
                    </div>
                </div>
                <div class="flex items-end justify-between mt-4 space-x-1">
                    <p class="text-xs">Recipient:<span class="font-semibold">{{-- $note->recipient --}}Fulano</span></p>
                    <div>
                        <x-button.circle icon="eye"></x-button.circle>
                        <x-button.circle icon="trash"></x-button.circle>
                </div>
            </div>
            </x-card>
            {{-- @endforeach --}}
        </div>
        @endif
    </div>
</div>
