<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@next/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <title>Peduli Lindungi alam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    nav {
        background-color: #667eea;
    }

    .menu-item {
        border-bottom: 1px solid #fff;
        /* Add border below each menu item */
    }

    @media (min-width: 768px) {
        .menu-item {
            border-bottom: none;
            border-width: screen;
        }
    }
</style>

<body class="text-gray-700 bg-white" style="font-family: 'Source Sans Pro', sans-serif">
    <nav class="text-black">
        <div class="container mx-auto px-6 py-2 flex flex-col lg:flex-row justify-between items-center">
            <div class="flex items-center font-bold text-2xl lg:text-2xl">
                <img src="https://png.pngtree.com/png-clipart/20230623/original/pngtree-environmental-protection-natural-environment-logo-vector-png-image_9204796.png" style="height: 60px;" alt="">
                <p class="ml-2">Peduli Lindungi alam</p>
            </div>
            <div class="bg-gray-300 lg:hidden">
                <button id="menuBtn" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-800 hover:border-teal-500 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </div>
            <div id="menu" class="hidden lg:flex lg:items-center">
                <ul class="flex flex-col lg:flex-row lg:ml-auto">
                    <li>
                        <button class="px-4 py-2 hover:text-gray-800" onclick="navigateTo('<?php echo base_url('admin') ?>')">Dashboard</button>
                    </li>
                    <li class="menu-item">
                        <button class="px-4 py-2 hover:text-gray-800" onclick="navigateTo('<?php echo base_url('admin/public') ?>')">Public</button>
                    </li>
                    <li>
                        <button onclick="confirmLogout()" class="px-4 py-2 hover:text-gray-800">Keluar</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        function navigateTo(url) {
            window.location.href = url;
        }

        document.getElementById('menuBtn').addEventListener('click', function() {
            var menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });

        function confirmLogout() {
            Swal.fire({
                // title: 'Are you sure?',
                text: 'Apakah anda yakin ingin keluar!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the logout URL
                    window.location.href = "<?php echo base_url('auth/logout') ?>";
                }
            });
        }
    </script>
</body>

</html>