<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($renungan) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($renungan) ? route('renungan.update', $renungan->id) : route('renungan.store') }}" class="mt-6 space-y-6">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($renungan)
                            @method('put')
                        @endisset
                
                        <div>
                            <x-input-label for="title" value="Title" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="$renungan->title ?? old('title')" required autofocus />
                            <x-input-error class="mt-2 text-red" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="body" value="Content" />
                            {{-- use textarea-input component that we will create after this --}}
                            <x-textarea-input id="body" name="body" class="mt-1 block w-full" required autofocus>{{ $renungan->body ?? old('body') }}</x-textarea-input>
                            <x-input-error class="mt-2 text-red" :messages="$errors->get('body')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('renungan.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">BACK</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.21.0/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('body',{
            height: 150,
            removeButtons: 'PasteFromWord'
        });
    </script>
</x-app-layout>