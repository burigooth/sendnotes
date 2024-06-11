<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Note;

new #[Layout('layouts.app')] class extends Component {
    //
    public Note $note;
    public $noteRecipient;
    public $noteSendDate;
    public $noteBody;
    public $noteIsPublished;
    public $noteTitle;

    public function mount(Note $note)
    {
        $this->authorize('update', $note);
        $this->fill($note);
        $this->noteTitle = $note->title;
        $this->noteBody = $note->body;
        $this->noteRecipient = $note->recipient;
        $this->noteSendDate = $note->send_date;
        $this->noteIsPublished = $note->is_published;
    }

    public function saveNote()
    {
        $validated = $this->validate([
            'noteTitle' => ['required', 'string', 'min:5'],
            'noteBody' => ['required', 'string', 'min:20'],
            'noteRecipient' => ['required', 'email'],
            'noteSendDate' => ['required', 'date'],
        ]);

        $this->note->update([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => $this->noteIsPublished,
        ]);

        $this->dispatch('note-saved');
    }
}; ?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Edit Note') }}
    </h2>
</x-slot>


<div class="py-12">
    <div class="max-w-2xl mx-auto space-y-4 sm:px-6 lg:px-8">
        <form wire:submit='saveNote' class="space-y-4">
        <x-input wire:model="noteTitle" label="Título da nota" placeholder="Tem sido um bom dia. "/>
    <x-textarea wire:model="noteBody" label="Sua nota" placeholder="Compartilhe seus pensamentos..."/>
    <x-input icon="users" wire:model="noteRecipient" label="Recipient" placeholder="seuamigo@gmail.com" type='email'/>
    <x-input icon="calendar" wire:model="noteSendDate" type="date" label="Data"/>
            <x-checkbox label="Note Enviada" wire:model='noteIsPublished'/>
            <div class="flex justify-between pt-4">
                <x-button type="submit" secondary> Salvar nota </x-button>
                <x-button href="{{ route('notes.index') }}" flat negative> Voltar para Notas </x-button>
            </div>
            <x-action-message on="note-saved" class="text-green-500"/>
            <x-errors />
        </form>
    </div>
</div>
