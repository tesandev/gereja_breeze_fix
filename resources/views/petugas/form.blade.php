<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($petugas) ? 'Edit' : 'Create' }}
        </h2>
        
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">          
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            @if (Session::has('notif.error'))
            <div role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                    {{'Error, '}}{{ Session::get('notif.error') }}
                </div>
            </div>
            @endif 
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($petugas) ? route('petugas.update', $petugas->id) : route('petugas.store') }}" class="mt-6 space-y-6">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($petugas)
                            @method('put')
                        @endisset
                
                        <div>
                            <x-input-label for="title" value="Jadwal Kegiatan" />
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Jadwal Kegiatan</label>
                            <select id="title" name="jadwal_id" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach ($listjadwal as $key)
                                @empty($petugas)
                                    <option>Choose a country</option>
                                @endempty
                                    <option value="{{ $key->id }} {{ ( $key->id == $selectedID) ? 'selected' : '' }}"> 
                                    {{ ' Tanggal =' }}{{ $key->tanggalkegiatan }}{{ ' Jam =' }}{{ $key->jamkegiatan }} 
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="body" value="Body" />
                            {{-- use textarea-input component that we will create after this --}}
                            <x-textarea-input id="body" name="body" class="mt-1 block w-full" required autofocus>{{ $petugas->body ?? old('body') }}</x-textarea-input>
                            <x-input-error class="mt-2" :messages="$errors->get('body')" />
                        </div>
                
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('petugas.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">BACK</a>
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