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

    .rating-container {
        margin-bottom: 20px;
    }

    .rating-container h3 {
        color: #333;
        margin-bottom: 10px;
    }

    .star-icon {
        margin-top: 10px;
        color: gold;
        font-size: 1.5em;
    }
    .babuh {
        margin-left: 45%;
    }

    @media (min-width: 768px) {
        .babuh {
            margin-left: 55%;
        }
    }
</style>

<body class="nav-day md:pt-20 pt-28">
    <nav class="text-black">
        <div class="container mx-auto my-3 py-2 flex flex-col lg:flex-row justify-between items-center">
            <div class="flex items-center font-bold text-2xl lg:text-2xl">
                <a href="" class="flex items-center text-white" style="cursor: default;">
                    <img id="logoImage" src="<?= base_url('image/logo1.png') ?>" style="height: 40px;" alt="">
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

    <section>
        <div class="container mx-auto px-6 py-20">
            <h2 class="text-4xl font-bold text-center mb-8">
                Rating
            </h2>
            <?php if (!empty($reting)) : ?>
                <?php $groupedRatings = [];
                foreach ($reting as $row) {
                    $rating = $row->rating;
                    if (!isset($groupedRatings[$rating])) {
                        $groupedRatings[$rating] = [];
                    }
                    $groupedRatings[$rating][] = $row;
                }
                krsort($groupedRatings);
                foreach ($groupedRatings as $rating => $rows) : ?>
                    <div class="rating-container mb-8">
                        <h3 class="text-2xl font-semibold mb-4">Rating <?= $rating ?> Bintang</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach ($rows as $row) : ?>
                                <div class="rating-card mb-4">
                                    <div class="bg-white rounded shadow p-6">
                                        <p class="text-gray-800 text-base rating-content">
                                            <?= $row->comment; ?>
                                        </p>
                                        <p class="text-gray-500 text-xs md:text-sm rating-content mt-4">
                                            <span><?= tampil_nama_byid($row->id_user) ?></span>
                                            <span class="babuh ml-auto text-gray-800">
                                                <?php for ($i = 1; $i <= $row->rating; $i++) : ?>
                                                    <span class="star-icon">&#9733;</span>
                                                <?php endfor; ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-gray-800 text-base px-6 mb-5 text-center">
                    Tidak ada data yang tersedia.
                </p>
            <?php endif; ?>
        </div>
    </section>

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
                logo.src = '<?= base_url('image/logo1.png') ?>';
            } else {
                logo.src = '<?= base_url('image/logo2.png') ?>';
            }
        }
    </script>
</body>

</html>