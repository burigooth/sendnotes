<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Crie uma nota!') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-2xl mx-auto space-y-4 sm:px-6 lg:px-8">
        <x-button primary icon="arrow-left" class="mb-8" href="{{route('notes.index')}}" wire:navigate>Todas as notas</x-button>
                    <livewire:notes.create-note />
        </div>
    </div>
</x-app-layout>
