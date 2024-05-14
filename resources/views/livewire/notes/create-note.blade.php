<?php

use Livewire\Volt\Component;

new class extends Component {
    public $noteTitle;
    public $noteRecipient;
    public $noteSendDate;
    public $noteBody;

    public function submit()
    {
        dd($this->noteTitle, $this->noteRecipient, $this->noteSendDate, $this->noteBody);
    }
}; ?>

<div>
    <form wire:submit='submit' class="space-y-4">
    <x-input wire:model="noteTitle" label="Note Title" placeholder="It's been a great day. "/>
    <x-textarea wire:model="noteBody" label="Your note" placeholder="Share all your thoughts with your friend"/>
    <x-input wire:model="noteRecipient" label="Recipient" placeholder="yourfriend@email.com" type='email'/>
    <x-input icon="calendar" wire:model="noteSendDate" type="date" label="Send Date"/>
    <div class="pt-4">
    <x-button primary wire:click="submit" primary right-icon="calendar" spinner> Schedule Note </x-button>
    </div>
    </form>
</div>
