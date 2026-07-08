<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="nama_lengkap" value="Nama Lengkap" />

            <x-text-input
                id="nama_lengkap"
                class="block mt-1 w-full"
                type="text"
                name="nama_lengkap"
                :value="old('nama_lengkap')"
                required
                autofocus />

            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
        </div>

        <!-- NIK -->
        <div class="mt-4">
            <x-input-label for="nik" value="NIK" />

            <x-text-input
                id="nik"
                class="block mt-1 w-full"
                type="text"
                name="nik"
                :value="old('nik')"
                maxlength="16"
                required />

            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}"
               class="underline text-sm text-gray-600 hover:text-gray-900">
                Sudah punya akun?
            </a>

            <x-primary-button class="ms-4">
                Daftar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>