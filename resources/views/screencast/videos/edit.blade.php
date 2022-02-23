<x-app-layout>
    <x-slot name="title">Video</x-slot>
    <div class="grid grid-rows-12 mb-10">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <span class="font-bold">
                    Edit Video
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-rows-12 grid-flow-col gap-12">
        <div>
            <div class="w-full max-w-xs">
                <form method="POST" action="{{ route('screencast.videos.update', [$video, $playlist]) }}"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    @method('patch')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            Title
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_update->has('title')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="title" name="title" value="{{ $video->title ?? old('title') }}" type="text">
                        @if ($errors->video_update->has('title'))
                            <p class="text-red-500 text-xs italic">{{ $errors->video_update->first('title') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Deskripsi
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_update->has('description')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="description" name="description"
                            value="{{ $video->description ?? old('description') }}" type="text">
                        @if ($errors->video_update->has('description'))
                            <p class="text-red-500 text-xs italic">
                                {{ $errors->video_update->first('description') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="video_path_url">
                            Video Path URL
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_update->has('video_path_url')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="video_path_url" name="video_path_url"
                            value="{{ $video->video_path_url ?? old('video_path_url') }}" type="text">
                        @if ($errors->video_update->has('video_path_url'))
                            <p class="text-red-500 text-xs italic">
                                {{ $errors->video_update->first('video_path_url') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="episode">
                            Episode
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_update->has('episode')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="episode" name="episode" value="{{ $video->episode ?? old('episode') }}" type="number">
                        @if ($errors->video_update->has('episode'))
                            <p class="text-red-500 text-xs italic">{{ $errors->video_update->first('episode') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="runtime">
                            Runtime
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->video_update->has('runtime')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="runtime" name="runtime" value="{{ $video->runtime ?? old('runtime') }}" type="time">
                        @if ($errors->video_update->has('runtime'))
                            <p class="text-red-500 text-xs italic">{{ $errors->video_update->first('runtime') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex">
                        <div class="mb-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                    type="checkbox" name="is_intro" id="is_intro"
                                    @if ($video->is_intro == 1) checked @else {!! $htmlCheckedIntro['attribute'] !!} @endif>
                                <label class="form-check-label inline-block text-gray-800" for="is_intro">
                                    @if ($video->is_intro == 1) Make Intro @else {!! $htmlCheckedIntro['label'] !!} @endif
                                </label>
                            </div>
                        </div>
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
