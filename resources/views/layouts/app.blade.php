<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('style')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <div class="flex">
            @include('layouts.sidebar')
            <main class="w-4/5 p-5">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    @stack('script')

    <script>
        // success message
        @if (session()->has('success'))
            Swal.fire({
                icon: 'success',
                title: "{{ session()->get('success') }}",
                showConfirmButton: false,
                timer: 2400,
            });
        @endif

        // error message
        @if (session()->has('error'))
            Swal.fire({
                title: "Error!",
                text: "{{ session()->get('error') }}",
                icon: 'error',
                showCancelButton: true,
                cancelButtonText: 'Ok',
                showConfirmButton: false,
                cancelButtonColor: '#d33',
            });
        @endif

        // warning message
        @if (session()->has('warning'))
            Swal.fire({
                title: "Perhatian!",
                text: "{{ session()->get('warning') }}",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Ok',
                showConfirmButton: false,
                cancelButtonColor: 'gray',
            });
        @endif

        // toast welcome
        @if (session()->has('loginSuccess'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: "{{ session()->get('loginSuccess') }}"
            })
        @endif
    </script>

</body>

</html>
