<?php

use Livewire\Volt\Component;
use App\Mail\NoteEmail;
use App\Models\User;

new class extends Component {
    public $noteTitle;
    public $noteRecipient;
    public $noteSendDate;
    public $noteBody;

    public function submit()
    {   
        $validated = $this->validate([
            'noteTitle' => ['required', 'string', 'min:5'],
            'noteBody' => ['required', 'string', 'min:20'],
            'noteRecipient' => ['required', 'email'],
            'noteSendDate' => ['required', 'date'],
        ]);
        
        auth()
        ->user()
        ->notes()
        ->create([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => true,
        ]);

        $user = auth()->user();
        
        Mail::to($this->noteRecipient)->send(new NoteEmail($this->noteBody, $this->noteTitle, $user->name));
        redirect(route('notes.index'));
    }
}; ?>

<div>
    <form wire:submit='submit' class="space-y-4">
    <x-input wire:model="noteTitle" label="Título da nota" placeholder="Tem sido um bom dia. "/>
    <x-textarea wire:model="noteBody" label="Sua nota" placeholder="Compartilhe seus pensamentos..."/>
    <x-input icon="users" wire:model="noteRecipient" label="Recipient" placeholder="seuamigo@gmail.com" type='email'/>
    <x-input icon="calendar" wire:model="noteSendDate" type="date" label="Data"/>
    <div class="pt-4">
    <x-button primary type="submit" primary right-icon="calendar" spinner> Escrever nota </x-button>
    </div>
    
    <x-errors/>
    </form>
</div>
