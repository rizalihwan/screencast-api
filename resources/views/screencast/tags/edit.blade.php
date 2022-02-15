<x-app-layout>
    <x-slot name="title">Tag</x-slot>
    <div class="grid grid-rows-12 mb-10">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <span class="font-bold">
                    Edit Tag
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-rows-12 grid-flow-col gap-12">
        <div>
            <div class="w-full max-w-xs">
                <form method="POST" action="{{ route('screencast.tags.update', $tag) }}"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    @method('patch')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->tag_update->has('name')) border-red-500 @endif @error('errorNameExists') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" value="{{ $tag->name ?? old('name') }}" type="text">
                        @error('errorNameExists')
                            <p class="text-red-500 text-xs italic">{{ session('errors')->first('errorNameExists') }}
                            </p>
                        @enderror
                        @if ($errors->tag_update->has('name'))
                            <p class="text-red-500 text-xs italic">{{ $errors->tag_update->first('name') }}
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
</x-app-layout>
