<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="npm" :value="__('NPM')" />
            <x-text-input id="npm" class="block mt-1 w-full" type="text" name="npm" :value="old('npm')"
                required autofocus autocomplete="npm" />
            <x-input-error :messages="$errors->get('npm')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="wa" :value="__('WA')" />
            <x-text-input id="wa" class="block mt-1 w-full" type="text" name="wa" :value="old('wa')"
                required autofocus autocomplete="wa" />
            <x-input-error :messages="$errors->get('wa')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="filterAngkatan" :value="__('Angkatan')" />
            {{-- <x-text-input id="angkatan" class="block mt-1 w-full" type="text" name="angkatan" :value="old('angkatan')" required autofocus autocomplete="angkatan" /> --}}
            <select name="angkatan" id="filterAngkatan"
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Pilih Angkatan</option>
                @foreach ($angkatan as $a)
                    <option value="{{ $a->id }}">{{ $a->nama }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('angkatan')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="filterKelas" :value="__('Kelas')" />
            {{-- <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas" :value="old('kelas')" required autofocus autocomplete="kelas" /> --}}
            <select name="kelas" id="filterKelas"
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Pilih Kelas</option>
            </select>
            <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var filterAngkatan = $('#filterAngkatan');
        var filterKelas = $('#filterKelas');

        filterAngkatan.on('change', function() {
            $.ajax({
                url: "{{ route('admin.filter.kelas') }}",
                type: "POST",
                data: {
                    angkatan: $(this).val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    let filterKelas = $('#filterKelas');
                    filterKelas.empty();

                    filterKelas.append('<option value="">pilih</option>');
                    $.each(data, function(key, value) {
                        filterKelas.append('<option value="' + value.id + '">' +
                            value.nama +
                            '</option>');
                    });
                }
            })
        })
    });
</script>
