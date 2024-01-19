<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Pengaduan Bencana</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700" rel="stylesheet" />
</head>
<style>
    body {
        font-family: 'Source Sans Pro', sans-serif;
        margin: 0;
        padding: 0;
        transition: background-color 0.3s ease;
    }

    .nav-day nav,
    .nav-night nav {
        position: fixed;
        width: 100%;
        z-index: 1000;
        top: 0;
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
        min-height: 100vh;
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
            width: auto;
        }
    }

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

<body class="nav-day md:pt-20 pt-28">
    <nav class="text-black">
        <div class="container mx-auto my-3 py-2 flex flex-col lg:flex-row justify-between items-center">
            <div class="flex items-center font-bold text-2xl lg:text-2xl">
                <a href="" class="flex items-center text-white" style="cursor: default;">
                    <img id="logoImage" src="image/logo1.png" style="height: 40px;" alt="">
                    <p class="ml-2">Layanan Pengaduan Bencana</p>
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
                        <button class="px-4 py-2 text-white hover:text-green-500" onclick="navigateTo('<?php echo base_url('auth') ?>')">LOGIN</button>
                    </li>
                    <li>
                        <button class="px-4 py-2 text-white hover:text-green-500 toggle-button" onclick="toggleDayNightMode()">
                            <i class="fas fa-cloud-moon"></i>
                        </button>
                    </li>
                </ul>
            </div>
            <div id="date-time" class="text-white">
            </div>
        </div>
    </nav>

    <section class="container mx-auto px-6 p-10">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">
            Deskripsi Public
        </h2>
        <div class="container mt-20">
            <?php
            $maxItemsToShow = 3;
            $itemCount = 0;
            if (!empty($public)) :
                foreach ($public as $key => $item) :
                    if ($itemCount >= $maxItemsToShow) {
                        break;
                    } ?>
                    <div class="mb-10">
                        <div class="card flex flex-col md:flex-row <?php echo ($key % 2 == 0) ? 'md:flex-row-reverse text-right' : ''; ?>">
                            <img src="<?php echo (!empty($item->image) && file_exists('./image/' . $item->image)) ? base_url('./image/' . $item->image) : base_url('./image/foto.png'); ?>" style="width: 500px; height: 250px;" alt="Monitoring">
                            <div class="card-body flex-1 mr-10 ml-10">
                                <h5 style="font-weight: bold; font-size: x-large;" class="card-title mb-4 "><?php echo $item->tempat; ?></h5>
                                <p class="card-text"><?php echo $item->deskripsi; ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                    $itemCount++;
                endforeach;
            else :
                ?>
                <div class="col-12">
                    <p>Tidak ada data yang tersedia</p>
                </div>
            <?php endif; ?>
        </div>

    </section>

    <section class="bg-blue-400">
        <div class="container mx-auto px-6 py-20">
            <h2 class="text-4xl font-bold text-center text-white mb-8">
                Rating
            </h2>

            <?php if (empty($reting)) : ?>
                <p class="text-gray-800 text-base px-6 mb-5 text-center">
                    No ratings available.
                </p>
            <?php else : ?>
                <div class="flex flex-wrap">
                    <?php $counter = 0; ?>
                    <?php foreach ($reting as $row) : ?>
                        <?php if ($counter < 6 && ($row->rating == 4 || $row->rating == 5)) : ?>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <div class="bg-white rounded shadow py-2">
                                    <p class="text-gray-800 text-base px-6 mb-5">
                                        <?= $row->comment; ?>
                                    </p>
                                    <p class="text-gray-500 text-xs md:text-sm px-6 flex">
                                        <span><?= tampil_nama_byid($row->id_user) ?></span>
                                        <span class="ml-auto text-gray-800">
                                            <?php for ($i = 1; $i <= $row->rating; $i++) : ?>
                                                <span class="star-icon" style="color: gold; font-size: 1.5em;">&#9733;</span>
                                            <?php endfor; ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <?php $counter++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="bg-green-100">
        <div class="container mx-auto px-6 pt-10 pb-6">
            <div class="flex flex-wrap">
                <div class="w-full text-center">
                    Terdaftar © 2023 <a href="" style="cursor: default;" class="py-2 inline-block hover:underline">Layanan Pengaduan Bencana</a>. Semua hak dilindungi dan kami siap melayani untuk keamanan bersama.
                </div>
            </div>
        </div>
    </footer>

    <script>
        function updateDateTime() {
            var dateTimeContainer = document.getElementById('date-time');
            var now = new Date();

            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                timeZone: 'Asia/Jakarta',
            };

            var formattedDateTime = now.toLocaleDateString('id-ID', options);
            dateTimeContainer.textContent = formattedDateTime;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        function navigateTo(url) {
            window.location.href = url;
        }

        document.getElementById('menuBtn').addEventListener('click', function() {
            var menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });

        function toggleDayNightMode() {
            var body = document.body;
            var nav = document.querySelector('nav');
            var logo = document.getElementById('logoImage');

            body.classList.toggle('nav-day');
            body.classList.toggle('nav-night');
            nav.classList.toggle('nav-day');
            nav.classList.toggle('nav-night');

            if (body.classList.contains('nav-day')) {
                logo.src = 'image/logo1.png';
            } else {
                logo.src = 'image/logo2.png';
            }
        }
    </script>
</body>

</html>