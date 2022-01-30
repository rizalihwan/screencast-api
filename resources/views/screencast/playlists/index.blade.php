<x-app-layout>
    <x-slot name="title">Playlist</x-slot>
    <div class="grid grid-rows-12 mb-10">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <span class="font-bold">
                    {{ $playlistPage }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-rows-12 grid-flow-col gap-12">
        <div>
            @if (session()->has('success'))
                <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 mb-5"
                    style="width: 500px;" role="alert">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
                    </svg>
                    <p>
                        {{ session()->get('success') }}
                    </p>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3 mb-5"
                    style="width: 500px;" role="alert">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
                    </svg>
                    <p>
                        {{ session()->get('error') }}
                    </p>
                </div>
            @endif
            <div class="w-full max-w-xs">
                <form method="POST" action="{{ route('screencast.playlists.store') }}"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="thumbnail">
                            Gambar
                        </label>
                        <input
                            class="shadow appearance-none border  @if ($errors->playlist_store->has('thumbnail')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="thumbnail" name="thumbnail" type="file">
                        @if ($errors->playlist_store->has('thumbnail'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_store->first('thumbnail') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->playlist_store->has('name')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" value="{{ old('name') }}" type="text">
                        @if ($errors->playlist_store->has('name'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_store->first('name') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Deskripsi
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->playlist_store->has('description')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="description" name="description" value="{{ old('description') }}" type="text">
                        @if ($errors->playlist_store->has('description'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_store->first('description') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                            Price
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->playlist_store->has('price')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="price" name="price" value="{{ old('price') }}" type="text">
                        @if ($errors->playlist_store->has('price'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_store->first('price') }}
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
                                    <th class="px-4 py-3">Playlist</th>
                                    <th class="px-4 py-3">Description</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Published At</th>
                                    <th class="px-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse ($playlists as $key)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                                    @if ($key->thumbnail)
                                                        <img class="object-cover w-full h-full rounded-full"
                                                            src="{{ $key->ShowThumbnail() }}" alt="PlaylistThumbnail"
                                                            loading="lazy" />
                                                    @endif
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-black">{{ $key->name }}</p>
                                                    <p class="text-xs text-gray-600">
                                                        {{ 'Author : ' . $key->user->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-ms font-semibold border">
                                            {{ \Str::limit($key->description, 10) }}</td>
                                        <td class="px-4 py-3 text-xs border">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                {{ 'Rp. ' . number_format($key->price) }} </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm border">{{ $key->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-4 py-5 text-ms font-semibold border">
                                            <a href="{{ route('screencast.playlists.edit', $key->slug) }}"
                                                class="p-3 bg-transparent border-2 border-green-500 text-green-500 text-lg rounded-lg hover:bg-green-500 hover:text-gray-100 focus:border-4 focus:border-green-300"><i
                                                    class="fa fa-pencil"></i></a>
                                            <form action="{{ route('screencast.playlists.destroy', $key->slug) }}"
                                                method="post" class="mt-5">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('Hapus data?');"
                                                    class="p-3 bg-transparent border-2 border-red-500 text-red-500 text-lg rounded-lg hover:bg-red-500 hover:text-gray-100 focus:border-4 focus:border-red-300"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-gray-700">
                                        <td colspan="5"
                                            class="px-4 py-3 text-ms font-semibold border text-center bg-red-500">Data
                                            Empty.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="my-2 p-4">
                            {{ $playlists->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @push('script')
        <script>
            let rupiah = document.getElementById('price');
            rupiah.addEventListener('keyup', function(e) {
                rupiah.value = formatRupiah(this.value, 'Rp. ');
            });

            function formatRupiah(angka, prefix) {
                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
            }
        </script>

    @endpush
</x-app-layout>
