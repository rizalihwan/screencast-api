<x-app-layout>
    <x-slot name="title">Playlist</x-slot>
    <div class="grid grid-rows-12 mb-10">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <span class="font-bold">
                    Playlist Management
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
                            id="name" name="name" type="text">
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
                            id="description" name="description" type="text">
                        @if ($errors->playlist_store->has('description'))
                            <p class="text-red-500 text-xs italic">{{ $errors->playlist_store->first('description') }}
                            </p>
                        @endif
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="Price">
                            Price
                        </label>
                        <input
                            class="shadow appearance-none border @if ($errors->playlist_store->has('price')) border-red-500 @endif rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="Price" name="price" type="text">
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
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Age</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-black">Sufyan</p>
                                                <p class="text-xs text-gray-600">Developer</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-ms font-semibold border">22</td>
                                    <td class="px-4 py-3 text-xs border">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                            Acceptable </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm border">6/4/2000</td>
                                </tr>
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-black">Stevens</p>
                                                <p class="text-xs text-gray-600">Programmer</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-md font-semibold border">27</td>
                                    <td class="px-4 py-3 text-xs border">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-gray-100 rounded-sm">
                                            Pending </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm border">6/10/2020</td>
                                </tr>
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Nora</p>
                                                <p class="text-xs text-gray-600">Designer</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-md font-semibold border">17</td>
                                    <td class="px-4 py-3 text-xs border">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm">
                                            Nnacceptable </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm border">6/10/2020</td>
                                </tr>
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Ali</p>
                                                <p class="text-xs text-gray-600">Programmer</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border text-md font-semibold">23</td>
                                    <td class="px-4 py-3 border text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                            Acceptable </span>
                                    </td>
                                    <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                </tr>
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Khalid</p>
                                                <p class="text-xs text-gray-600">Designer</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border text-md font-semibold">20</td>
                                    <td class="px-4 py-3 border text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-sm">
                                            Pending </span>
                                    </td>
                                    <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                </tr>
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Nasser</p>
                                                <p class="text-xs text-gray-600">Pen Tester</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border text-md font-semibold">29</td>
                                    <td class="px-4 py-3 border text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                            Acceptable </span>
                                    </td>
                                    <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                </tr>
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Mohammed</p>
                                                <p class="text-xs text-gray-600">Web Designer</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border text-md font-semibold">38</td>
                                    <td class="px-4 py-3 border text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                            Acceptable </span>
                                    </td>
                                    <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                </tr>
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Saad</p>
                                                <p class="text-xs text-gray-600">Data</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border text-md font-semibold">19</td>
                                    <td class="px-4 py-3 border text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                            Acceptable </span>
                                    </td>
                                    <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                </tr>
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 border">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Sami</p>
                                                <p class="text-xs text-gray-600">Developer</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border text-md font-semibold">21</td>
                                    <td class="px-4 py-3 border text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                            Acceptable </span>
                                    </td>
                                    <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
