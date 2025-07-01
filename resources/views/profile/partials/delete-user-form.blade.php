<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Hapus Akun
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
    </header>

    <button 
        x-data="" 
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
        Hapus Akun
    </button>

    <div x-data="{ show: false }" x-show="show" x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null" x-on:close.stop="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div @click.away="show = false" class="bg-white rounded-lg p-6 w-full max-w-lg mx-4">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    Apakah Anda yakin ingin menghapus akun Anda?
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
                </p>

                <div class="mt-6">
                    <label for="password_delete" class="sr-only">Password</label>
                    <input id="password_delete" name="password" type="password" class="mt-1 block w-3/4 border-gray-300 rounded-md shadow-sm" placeholder="Password"/>
                    @if ($errors->userDeletion->get('password'))
                        <p class="text-sm text-red-600 mt-2">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="show = false" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md mr-3">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>