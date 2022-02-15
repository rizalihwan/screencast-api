<x-app-layout>
    <x-slot name="title">Playlist</x-slot>
    <div class="grid grid-rows-12 mb-10">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <span class="font-bold">
                    Edit Playlist
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-rows-12 grid-flow-col gap-12">
        <div>
            <div class="w-full max-w-xs">
                <form method="POST" action="{{ route('screencast.playlists.update', $playlist) }}"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="thumbnail">
                            Gambar
                        </label>
                        @if ($playlist->thumbnail)
                            <img src="{{ $playlist->ShowThumbnail() }}"
                                style="width: 100px; height: 100px; object-fit: cover; object-position: center;"
                                alt="PlaylistThumbnail" class="my-3">
                        @endif
                        <input
                            class="shadow appearance-none border  @if ($errors->playlist_update->has('thumbnail')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="thumbnail" name="thumbnail" type="file">
                        @if ($errors->playlist_update->has('thumbnail'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_update->first('thumbnail') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->playlist_update->has('name')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" value="{{ $playlist->name ?? old('name') }}" type="text">
                        @if ($errors->playlist_update->has('name'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_update->first('name') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Deskripsi
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->playlist_update->has('description')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="description" name="description"
                            value="{{ $playlist->description ?? old('description') }}" type="text">
                        @if ($errors->playlist_update->has('description'))
                            <p class="text-red-500 text-xs italic">
                                {{ $errors->playlist_update->first('description') }}
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
                            class="shadow appearance-none border @if ($errors->playlist_update->has('price')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="price" name="price"
                            value="{{ 'Rp. ' . number_format($playlist->price, 0, ',', '.') ?? old('price') }}"
                            type="text">
                        @if ($errors->playlist_update->has('price'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_update->first('price') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            // jQuery price formating code
            $(document).ready(function() {
                $.fn.priceFormat = function(number, prefix) {
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

                $('#price').on("keyup", function(e) {
                    $('#price').val($.fn.priceFormat($(this).val(), 'Rp. '));
                });
            });
        </script>
    @endpush
</x-app-layout>
