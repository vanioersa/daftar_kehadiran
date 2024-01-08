<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@next/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php $this->load->view('sidebar_admin'); ?>
    <!-- <p style="color:red;">* hanya dapat menambahkan 3</p> -->
    <a href="<?php echo base_url('admin/tambah_card') ?>" class="ml-2 inline-block px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-semibold text-base rounded">
        <i class="fas fa-plus"></i> Tambah
    </a>

    <h1 style="text-align: center; font-size: xx-large; font-weight: bold;">Publick</h1>
    <section class="container mx-auto px-6 p-10">
        <div class="flex items-center flex-wrap mb-20">
            <?php if (!empty($public)) : ?>
                <?php foreach ($public as $item) : ?>
                    <a href="#">
                        <div class="w-full md:w-1/2">
                            <h4 class="text-3xl text-gray-800 font-bold mb-3">
                                <?php echo $item->tempat; ?>
                            </h4>
                            <p class="text-gray-600 mb-8">
                                <?php echo $item->deskripsi; ?>
                            </p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="w-full md:w-1/2">
                            <img src="<?php echo (!empty($item->image) && file_exists('./image/' . $item->image)) ? base_url('./image/' . $item->image) : base_url('./image/foto.png'); ?>" alt="Gambar kosong" />
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Tidak ada data yang tersedia</p>
            <?php endif; ?>

        </div>
    </section>
</body>

</html>