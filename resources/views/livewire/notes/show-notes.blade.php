<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public function delete($noteId)
    {
        $note = Note::where('id', $noteId)->first(); // Aqui estamos buscando a nota onde o id é igual ao id passado, o first serve para pegar o primeiro resultado
        $this->authorize('delete', $note); // Aqui estamos verificando se o usuário tem permissão para deletar a nota
        $note->delete(); // Aqui estamos deletando a nota
    }
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
        @if ($notes->isEmpty())
            <div class="text-center text-gray-500">
                <p class="text-xl font-bold">No notes yet</p>
                <p class="text-sm">Let's create your first note to send.</p>
                <x-button primary icon-right="plus" class="mt-6" href="{{ route('notes.create') }}" wire:navigate>Create
                    note</x-button>
            </div>
        @else
            <x-button primary icon-right="plus" class="mb-12 h-14" href="{{ route('notes.create') }}" wire:navigate>
                Create note </x-button>
            <div class="grid grid-cols-3 gap-4 ">
                @foreach ($notes as $note)
                    <x-card wire:key='{{ $note->id }}'>
                        <div class="flex justify-between">
                            <div>
                                <a href="{{ route('notes.edit', $note->id) }}" wire:navigate
                                    class="text-xl font-bold hover:underline hover:text-blue-500">
                                    {{ $note->title }}
                                </a>
                                <p class="mt-2 text-xs"> {{ Str::limit($note->body, 50) }} </p>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ Carbon\Carbon::parse($note->send_date)->format('M-d-Y') }}
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4 space-x-1">
                            <p class="text-xs">Recipient:<span class="font-semibold">{{ $note->recipient }}</span>
                            </p>
                            <div>
                                <x-button.circle icon="eye" class="hover:text-blue-500"></x-button.circle>
                                <x-button.circle icon="trash" wire:click="delete('{{ $note->id }}')"
                                    class="hover:text-red-500"></x-button.circle>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
</div>
