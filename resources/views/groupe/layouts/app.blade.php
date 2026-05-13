<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Groupe ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_onpc.png') }}" type="image/x-icon">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'onpc-blue': '#0000cc',
                        'onpc-orange': '#ff8300',
                        'groupe-dark': '#0000cc',
                        'groupe-accent': '#ff8300',
                    },
                    fontFamily: {
                        'sans': ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #0000cc20;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0000cc40;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-800" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">

        @include('groupe.layouts.sidebar')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            @include('groupe.layouts.navbar')

            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succes',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#0000cc',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#b91c1c',
                });
            @endif
        });
    </script>
</body>

</html>
