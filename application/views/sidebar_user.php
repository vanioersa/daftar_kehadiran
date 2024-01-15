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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    body {
        font-family: 'Source Sans Pro', sans-serif;
        margin: 0;
        padding: 0;
    }

    .nav-day nav,
    .nav-night nav {
        transition: all 0.3s ease;
    }

    .nav-day nav {
        background-color: #667eea;
        color: #fff;
    }

    .nav-day button:hover {
        color: #1a202c;
    }

    .nav-night button:hover {
        color: #667eea;
    }

    .nav-night nav {
        background-color: #1a202c;
        color: #cbd5e0;
    }

    .menu-item {
        border-bottom: 1px solid #fff;
        width: 100%;
    }

    .chat-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .chat-header {
        background-color: #667eea;
        color: #fff;
        padding: 1rem;
        text-align: center;
    }

    .toggle-button {
        cursor: pointer;
        color: #fff;
    }

    .toggle-button i {
        font-size: 1.5rem;
    }

    @media (min-width: 768px) {
        .menu-item {
            border-bottom: none;
            width: 100%;
        }
    }
</style>

<body class="nav-day">
    <nav class="text-black">
        <div class="container mx-auto px-6 py-2 flex flex-col lg:flex-row justify-between items-center">
            <div class="flex items-center font-bold text-2xl lg:text-2xl">
                <a href="<?php echo base_url('user/profile') ?>" class="flex items-center text-white" style="cursor: default;">
                    <img src="https://png.pngtree.com/png-clipart/20230623/original/pngtree-environmental-protection-natural-environment-logo-vector-png-image_9204796.png" style="height: 60px;" alt="">
                    <p class="ml-2">Peduli Lindungi Alam</p>
                </a>
            </div>
            <div class="lg:hidden">
                <button id="menuBtn" class="flex items-center px-3 py-2 rounded text-white hover:text-white hover:border-teal-500 appearance-none focus:outline-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <div id="menu" class="hidden lg:flex lg:items-center">
                <ul class="flex flex-col lg:flex-row lg:ml-auto">
                    <li>
                        <button class="px-4 py-2" onclick="navigateTo('<?php echo base_url('user') ?>')">Dashboard</button>
                    </li>
                    <li>
                        <button onclick="navigateTo('<?php echo base_url('user/pesan') ?>')" class="px-4 py-2">Pesan</button>
                    </li>
                    <li>
                        <button onclick="navigateTo('<?php echo base_url('user/retting') ?>')" class="px-4 py-2">Retting</button>
                    </li>
                    <li>
                        <button onclick="confirmLogout()" class="px-4 py-2">Keluar</button>
                    </li>
                    <li>
                        <button class="px-4 py-2 toggle-button" onclick="toggleDayNightMode()">
                            <i class="fas fa-cloud-moon"></i>
                        </button>
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

        function toggleDayNightMode() {
            var body = document.body;
            var nav = document.querySelector('nav');

            body.classList.toggle('nav-day');
            body.classList.toggle('nav-night');
            nav.classList.toggle('nav-day');
            nav.classList.toggle('nav-night');
        }
    </script>
</body>

</html>