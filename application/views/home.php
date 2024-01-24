<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Pengaduan Bencana</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700" rel="stylesheet" />
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            margin: 0;
            padding: 0;
        }

        .nav-day nav,
        .nav-night nav {
            transition: all 0.3s ease;
            position: fixed;
            width: 100%;
            z-index: 1000;
            top: 0;
        }

        .en .nav-day nav,
        .id .nav-day nav {
            background-color: #667eea;
            color: #fff;
        }

        .en .nav-night nav,
        .id .nav-night nav {
            background-color: #1a202c;
            color: #cbd5e0;
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

        .main-content {
            text-align: center;
            padding: 5rem 1rem;
        }

        .main-content h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .main-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .main-content button {
            padding: 1rem 2rem;
            border-radius: 999px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .night-mode .additional-content,
        .additional-content {
            padding: 2rem;
            background-color: black;
            border-radius: 10px;
            margin-top: 2rem;
            color: white;
        }

        #currentDateTime {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 1rem;
        }

        #reportText {
            margin-bottom: 50px;
        }

        .roundued{
            border-radius: 50px;
        }
    </style>
</head>

<body class="nav-day md:pt-20 pt-28">
    <nav class="text-black">
        <div class="container mx-auto my-3 py-2 flex flex-col lg:flex-row justify-between items-center">
            <div class="flex items-center font-bold text-2xl lg:text-2xl">
                <a href="<?= base_url('admin/profile') ?>" class="flex items-center text-white" style="cursor: default;">
                    <img src="<?= base_url('image/logo1.png') ?>" style="height: 40px;" alt="">
                    <p class="ml-2">Layanan Pengaduan Bencana</p>
                </a>
            </div>
            <div class="lg:hidden">
                <button id="menuBtnMobile" class="px-3 py-2 rounded text-white hover:text-white hover:border-teal-500 appearance-none focus:outline-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <div id="menu" class="hidden lg:flex lg:items-center">
                <ul class="flex flex-col lg:flex-row lg:ml-auto">
                    <li>
                        <button class="px-4 py-2 text-white hover:text-green-500 toggle-button" onclick="toggleLanguage()">
                            <span id="languageIcon"><img src="image/icon-indonesia.png" alt="Indonesia Flag" width="30" height="15"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <button id="menuBtnMobile" class="lg:hidden px-3 py-2 rounded text-white hover:text-white hover:border-teal-500 appearance-none focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>

        <h1 id="welcomeText">Selamat Datang di Layanan Pelaporan Bencana</h1>
        <p id="reportText">Laporkan bencana dan dapatkan bantuan dengan cepat. Keselamatan Anda adalah prioritas kami.</p>
        <a id="buttonContent" class="px-8 py-4 roundued text-xl bg-blue-600 hover:bg-blue-500 text-white hover:text-black" href="<?php echo base_url('auth') ?>">Masuk</a>
    </div>

    <div class="additional-content">
        <h2 class="text-2xl font-semibold mb-4" id="infoTitle">Informasi Tambahan</h2>
        <p id="infoContent">Di sini Anda dapat menemukan informasi tambahan mengenai layanan pengaduan bencana. Kami siap membantu Anda dengan segala informasi yang Anda butuhkan.</p>
    </div>

    <div class="text-center">
        <p id="currentDateTime"></p>
    </div>

    <script>
        var language = 'id';

        function toggleLanguage() {
            language = (language === 'id') ? 'en' : 'id';
            updateContent();
            updateDateTime();
            updateLanguageIcon();
            updateNavigationColor();
        }

        function updateLanguageIcon() {
            var languageIcon = document.getElementById('languageIcon');
            languageIcon.innerHTML = (language === 'en') ? '<img src="image/icon-inggris.png" alt="English Flag" width="30" height="15">' : '<img src="image/icon-indonesia.png" alt="Indonesia Flag" width="30" height="15">';
        }

        function updateNavigationColor() {
            var body = document.body;
            var nav = document.querySelector('nav');

            body.classList.remove('nav-day', 'nav-night');
            nav.classList.remove('nav-day', 'nav-night');

            if (language === 'en') {
                body.classList.add('nav-night');
                nav.classList.add('nav-day');
            } else {
                body.classList.add('nav-day');
                nav.classList.add('nav-night');
            }
        }

        function updateContent() {
            document.body.className = language;reportText

            var welcomeText = document.getElementById('welcomeText');
            var reportText = document.getElementById('reportText');
            var infoTitle = document.getElementById('infoTitle');
            var infoContent = document.getElementById('infoContent');
            var buttonContent = document.getElementById('buttonContent');
            var serviceText = document.getElementById('serviceText');

            if (language === 'en') {
                welcomeText.textContent = "Welcome to Disaster Reporting Service";
                reportText.textContent = "Report disasters and get help quickly. Your safety is our priority.";
                infoTitle.textContent = "Additional Information";
                infoContent.textContent = "Here you can find additional information about the disaster reporting service. We are ready to assist you with any information you need.";
                buttonContent.textContent = "Login";
            } else {
                welcomeText.textContent = "Selamat Datang di Layanan Pelaporan Bencana";
                reportText.textContent = "Laporkan bencana dan dapatkan bantuan dengan cepat. Keselamatan Anda adalah prioritas kami.";
                infoTitle.textContent = "Informasi Tambahan";
                infoContent.textContent = "Di sini Anda dapat menemukan informasi tambahan mengenai layanan pengaduan bencana. Kami siap membantu Anda dengan segala informasi yang Anda butuhkan.";
                buttonContent.textContent = "Masuk";
            }

            welcomeText.style.paddingTop = "75px";
        }

        function navigateTo(url) {
            window.location.href = url;
        }

        document.getElementById('menuBtnMobile').addEventListener('click', function() {
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
                    window.location.href = "<?= base_url('auth/logout') ?>";
                }
            });
        }

        function updateDateTime() {
            const currentDateTimeElement = document.getElementById('currentDateTime');
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                timeZone: 'Asia/Jakarta'
            };

            const currentDateTime = new Date().toLocaleString(language === 'en' ? 'en-US' : 'id-ID', options);
            const languageText = (language === 'en') ? 'Current Time' : 'Waktu saat ini';

            currentDateTimeElement.textContent = `${languageText}: ${currentDateTime}`;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>

</html>