<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($jadwalkegiatan) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($jadwalkegiatan) ? route('jadwalkegiatan.update', $jadwalkegiatan->id) : route('jadwalkegiatan.store') }}" class="mt-6 space-y-6">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($jadwalkegiatan)
                            @method('put')
                        @endisset
                
                        <div>
                            <x-input-label for="namakegiatan" value="Nama Kegiatan" />
                            <x-text-input id="namakegiatan" name="namakegiatan" type="text" class="mt-1 block w-full" :value="$jadwalkegiatan->namakegiatan ?? old('namakegiatan')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('namakegiatan')" />
                        </div>

                        <div>
                            <x-input-label for="lokasi" value="Lokasi" />
                            <x-text-input id="lokasi" name="lokasi" type="text" class="mt-1 block w-full" :value="$jadwalkegiatan->lokasi ?? old('lokasi')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('lokasi')" />
                        </div>

                        <div>
                            <x-input-label for="tanggalkegiatan" value="Tanggal Kegiatan" />
                            <x-text-input id="tanggalkegiatan" name="tanggalkegiatan" type="date" class="mt-1 block w-full" :value="$jadwalkegiatan->tanggalkegiatan ?? old('tanggalkegiatan')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggalkegiatan')" />
                        </div>

                        <div>
                            <x-input-label for="jamkegiatan" value="Jam Kegiatan" />
                            <x-text-input id="jamkegiatan" name="jamkegiatan" type="time" class="mt-1 block w-full" :value="$jadwalkegiatan->jamkegiatan ?? old('jamkegiatan')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('jamkegiatan')" />
                        </div>
                
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('jadwalkegiatan.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">BACK</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>