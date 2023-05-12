<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($tataibadah) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($tataibadah) ? route('tataibadah.update', $tataibadah->id) : route('tataibadah.store') }}" class="mt-6 space-y-6">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($tataibadah)
                            @method('put')
                        @endisset
                
                        <div>
                            <x-input-label for="namaibadah" value="Title" />
                            <x-text-input id="namaibadah" name="namaibadah" type="text" class="mt-1 block w-full" :value="$tataibadah->namaibadah ?? old('title')" required autofocus />
                            <x-input-error class="mt-2 text-red" :messages="$errors->get('namaibadah')" />
                        </div>

                        <div>
                            <x-input-label for="contentbody" value="Content" />
                            {{-- use textarea-input component that we will create after this --}}
                            <x-textarea-input id="contentbody" name="contentbody" class="mt-1 block w-full" required autofocus>{{ $tataibadah->contentbody ?? old('contentbody') }}</x-textarea-input>
                            <x-input-error class="mt-2 text-red" :messages="$errors->get('contentbody')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'contentbody' );
    </script>
</x-app-layout>