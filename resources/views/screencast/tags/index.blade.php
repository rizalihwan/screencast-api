<x-app-layout>
    <x-slot name="title">Tags</x-slot>
    <div class="grid grid-rows-12 mb-10">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <span class="font-bold">
                    {{ $tagPage }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-rows-12 grid-flow-col gap-12">
        <div>
            <div class="w-full max-w-xs">
                <form method="POST" action="{{ route('screencast.tags.store') }}"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->tag_store->has('name')) border-red-500 @endif @error('errorNameExists') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" value="{{ old('name') }}" type="text">
                        @error('errorNameExists')
                            <p class="text-red-500 text-xs italic">{{ session('errors')->first('errorNameExists') }}
                            </p>
                        @enderror
                        @if ($errors->tag_store->has('name'))
                            <p class="text-red-500 text-xs italic">{{ $errors->tag_store->first('name') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <section class="container mx-auto font-mono">
                <div class="w-full overflow-hidden rounded-lg shadow-lg">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr
                                    class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Total Playlist</th>
                                    @can('delete-tags')
                                        <th class="px-4 py-3">Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse ($tags as $key)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 text-sm border">
                                            {{ $loop->iteration + $tags->firstItem() - 1 . '.' }}</td>
                                        <td class="px-4 py-3 text-sm border">{{ \Str::ucfirst($key->name) }}</td>
                                        <td class="px-4 py-3 text-xs border">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                {{ $key->countPlaylists }} </span>
                                        </td>
                                        @can('delete-tags')
                                            <td class="px-4 py-5 text-ms font-semibold border">
                                                <a href="{{ route('screencast.tags.edit', $key->slug) }}"
                                                    class="p-3 bg-transparent border-2 border-green-500 text-green-500 text-lg rounded-lg hover:bg-green-500 hover:text-gray-100 focus:border-4 focus:border-green-300"><i
                                                        class="fa fa-pencil"></i></a>
                                                <button type="submit" onclick="deleteItem('{{ $key->slug }}')"
                                                    class="p-3 bg-transparent border-2 border-red-500 text-red-500 text-lg rounded-lg hover:bg-red-500 hover:text-gray-100 focus:border-4 focus:border-red-300"><i
                                                        class="fa fa-trash"></i></button>
                                                <form action="{{ route('screencast.tags.destroy', $key->slug) }}"
                                                    method="post" class="mt-5" id="DeleteItem{{ $key->slug }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr class="text-gray-700">
                                        <td colspan="4"
                                            class="px-4 py-3 text-ms font-semibold border text-center bg-red-500">Data
                                            Empty.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="my-2 p-4">
                            {{ $tags->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @push('script')
        <script>
            function deleteItem(id) {
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#009DA9',
                    cancelButtonColor: '#d33',
                    customClass: 'swal-wide',
                    confirmButtonText: 'Yakin, hapus Tag',
                    cancelButtonText: 'Batalkan',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Sedang menghapus Tag",
                            showConfirmButton: false,
                            timer: 2300,
                            timerProgressBar: true,
                            onOpen: () => {
                                document.getElementById(`DeleteItem${id}`).submit();
                                Swal.showLoading();
                            }
                        });
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
