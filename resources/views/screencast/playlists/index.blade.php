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
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="tag">
                            Tag
                        </label>
                        <select multiple
                            class="shadow appearance-none border @if ($errors->playlist_store->has('tag')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            name="tags[]" id="tag">
                            @foreach ($tags as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->playlist_store->has('tags'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_store->first('tags') }}
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
                                                    <p class="font-semibold text-black">
                                                    <div>
                                                        {{ $key->name }}
                                                    </div>
                                                    @foreach ($key->tags as $item)
                                                        <span class="text-gray-600 mr-1">
                                                            {{ $item->name }}
                                                        </span>
                                                    @endforeach
                                                    </p>
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
                                            @if ($key->user_id == \Auth::id() || auth()->user()->hasRole('admin'))
                                                <div @click.away="open = false" class="relative"
                                                    x-data="{ open: false }">
                                                    <button @click="open = !open"
                                                        class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                        <span>OPSI</span>
                                                        <svg fill="currentColor" viewBox="0 0 20 20"
                                                            :class="{'rotate-180': open, 'rotate-0': !open}"
                                                            class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                    <div x-show="open"
                                                        x-transition:enter="transition ease-out duration-100"
                                                        x-transition:enter-start="transform opacity-0 scale-95"
                                                        x-transition:enter-end="transform opacity-100 scale-100"
                                                        x-transition:leave="transition ease-in duration-75"
                                                        x-transition:leave-start="transform opacity-100 scale-100"
                                                        x-transition:leave-end="transform opacity-0 scale-95"
                                                        class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                                                        <div
                                                            class="absolute px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                                                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="{{ route('screencast.videos.create', $key->slug) }}"><i
                                                                    class="fa fa-play"></i> Video</a>
                                                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="{{ route('screencast.playlists.edit', $key->slug) }}"><i
                                                                    class="fa fa-edit"></i> Edit</a>
                                                            <hr>
                                                            <button type="submit"
                                                                onclick="deleteItem('{{ $key->slug }}')"
                                                                class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"><i
                                                                    class="fa fa-trash"></i> Hapus</button>
                                                            <form
                                                                action="{{ route('screencast.playlists.destroy', $key->slug) }}"
                                                                method="post" id="DeleteItem{{ $key->slug }}">
                                                                @csrf
                                                                @method('delete')
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-center"> - </span>
                                            @endif
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
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script>
        // vanilla js price formating code
        let price = document.getElementById("price");
        price.addEventListener("keyup", function() {
            price.value = priceFormat(this.value, 'Rp. ');
        })

        const priceFormat = (number, prefix) => {
            let string_number = number.replace(/[^,\d]/g, '').toString(),
                split_number = string_number.split(','),
                remainder = split_number[0].length % 3,
                result = split_number[0].substr(0, remainder),
                thousand = split_number[0].substr(remainder).match(/\d{3}/gi);

            if (thousand) {
                separator = remainder ? '.' : '';
                result += separator + thousand.join('.');
            }

            result = split_number[1] != undefined ? result + ',' + split_number[1] : result;
            return prefix == undefined ? result : (result ? 'Rp ' + result : '');
        }

        function deleteItem(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#009DA9',
                cancelButtonColor: '#d33',
                customClass: 'swal-wide',
                confirmButtonText: 'Yakin, hapus Playlist',
                cancelButtonText: 'Batalkan',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Sedang menghapus Playlist",
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
