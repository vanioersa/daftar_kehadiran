<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peduli Lindungi alam</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@next/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="text-gray-700 bg-white" style="font-family: 'Source Sans Pro', sans-serif">
    <nav style="background-color: #667eea" class="text-black fixed w-full top-0 z-10">
        <div class="container mx-auto px-6 py-2 flex justify-between items-center">
            <a class="flex items-center font-bold text-2xl lg:text-2xl" href="">
                <img src="https://png.pngtree.com/png-clipart/20230623/original/pngtree-environmental-protection-natural-environment-logo-vector-png-image_9204796.png" style="height: 60px;" alt="">
                <p class="ml-2">Peduli Lindungi alam</p>
            </a>
            <div class="bg-gray-300 lg:hidden">
                <button id="menuBtn" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-800 hover:border-teal-500 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </div>
            <div id="menu" class="hidden lg:block">
                <ul class="inline-flex">
                    <li>
                        <a class="px-4 py-2 hover:text-gray-800" href="<?php echo base_url('auth') ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="container mx-auto px-6 p-10 p-28">
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
        document.getElementById('menuBtn').addEventListener('click', function() {
            var menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>