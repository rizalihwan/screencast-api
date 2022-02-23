<x-app-layout>
    <x-slot name="title">Video</x-slot>
    <div class="grid grid-rows-12 mb-10">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <span class="font-bold">
                    {{ $playlist_name }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-rows-12 grid-flow-col gap-12">
        <div>
            <div class="w-full max-w-xs">
                <form method="POST" action="{{ route('screencast.videos.store', $playlist) }}"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            Title
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_store->has('title')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="title" name="title" value="{{ old('title') }}" type="text">
                        @if ($errors->video_store->has('title'))
                            <p class="text-red-500 text-xs italic">{{ $errors->video_store->first('title') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Deskripsi
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_store->has('description')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="description" name="description" value="{{ old('description') }}" type="text">
                        @if ($errors->video_store->has('description'))
                            <p class="text-red-500 text-xs italic">{{ $errors->video_store->first('description') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="video_path_url">
                            Video Path URL
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_store->has('video_path_url')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="video_path_url" name="video_path_url" value="{{ old('video_path_url') }}" type="text">
                        @if ($errors->video_store->has('video_path_url'))
                            <p class="text-red-500 text-xs italic">{{ $errors->video_store->first('video_path_url') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="episode">
                            Episode
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_store->has('episode')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="episode" name="episode" value="{{ old('episode') }}" type="number">
                        @if ($errors->video_store->has('episode'))
                            <p class="text-red-500 text-xs italic">{{ $errors->video_store->first('episode') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="runtime">
                            Runtime
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_store->has('runtime')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="runtime" name="runtime" value="{{ old('runtime') }}" type="time">
                        @if ($errors->video_store->has('runtime'))
                            <p class="text-red-500 text-xs italic">{{ $errors->video_store->first('runtime') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex">
                        <div class="mb-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                    type="checkbox" name="is_intro" id="is_intro">
                                <label class="form-check-label inline-block text-gray-800" for="is_intro">
                                    Make Intro
                                </label>
                            </div>
                        </div>
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
                                    <th class="px-4 py-3">Episode</th>
                                    <th class="px-4 py-3">Judul</th>
                                    <th class="px-4 py-3">Waktu Berjalan</th>
                                    <th class="px-4 py-3">Deskripsi</th>
                                    <th class="px-4 py-3">Video URL</th>
                                    <th class="px-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse ($videos as $key)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 text-sm border">
                                            @if ($key->is_intro == true)
                                                <span
                                                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm">
                                                    {{ $key->episode }}
                                                </span>
                                            @else
                                                {{ $key->episode }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm border">{{ $key->title }}</td>
                                        <td class="px-4 py-3 text-xs border">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                {{ $key->runtime }} </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm border">{{ $key->description }}</td>
                                        <td class="px-4 py-3 text-sm border">
                                            {{ \Str::limit($key->video_path_url, 10) }}</td>
                                        <td class="px-4 py-5 text-ms font-semibold border">
                                            <a href="{{ route('screencast.videos.edit', [$key->slug, $playlist]) }}"
                                                class="p-3 bg-transparent border-2 border-green-500 text-green-500 text-lg rounded-lg hover:bg-green-500 hover:text-gray-100 focus:border-4 focus:border-green-300"><i
                                                    class="fa fa-pencil"></i></a>
                                            <form
                                                action="{{ route('screencast.videos.destroy', [$key->slug, $playlist]) }}"
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
                                        <td colspan="6"
                                            class="px-4 py-3 text-ms font-semibold border text-center bg-red-500">Data
                                            Empty.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="my-2 p-4">
                            {{ $videos->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @push('script')
        <script>
            $isIntro = $('#is_intro');
            $isIntro.on("click", function() {
                if ($isIntro.is(':checked')) {
                    $isIntro.attr('value', 1);
                } else {
                    $isIntro.removeAttr('value')
                }
            });
        </script>
    @endpush
</x-app-layout>
