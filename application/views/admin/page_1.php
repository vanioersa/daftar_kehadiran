<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Pengaduan Bencana</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700" rel="stylesheet" />
</head>

<body>
    <?php $this->load->view('sidebar_admin'); ?>

    <a href="<?php echo base_url('admin/tambah_card_public') ?>" class="ml-5 md:mb-10 inline-block md:px-10 md:py-3 md:my-5 mt-10 px-3 py-2 bg-blue-500 hover:bg-blue-700 text-white font-semibold text-base rounded">
        <i class="fas fa-plus"></i> Tambah
    </a>

    <h1 class="text-center text-4xl font-bold mb-10">Public</h1>
    <section class="container mx-auto px-10">
        <div class="flex flex-wrap -mx-2 mb-8 justify-center">
            <?php if (!empty($public)) : ?>
                <?php $public = array_reverse($public);
                ?>
                <?php foreach ($public as $item) : ?>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $currentDateTime = new DateTime();
                    $itemDateTime = new DateTime($item->tanggal . ' ' . $item->jam);
                    $timeDifference = $currentDateTime->diff($itemDateTime);
                    $hoursDifference = $timeDifference->d + ($timeDifference->days * 24);
                    ?>

                    <div class="w-screen sm:w-1/2 md:w-1/3 lg:w-1/3 xl:w-1/3 px-2 mb-4">
                        <div class="rounded-lg overflow-hidden shadow-lg bg-white">
                            <?php if ($hoursDifference < 1) : ?>
                                <a href="<?php echo base_url('admin/edit_card_public/' . $item->id); ?>">
                                <?php endif; ?>
                                <div class="relative overflow-hidden pb-60">
                                    <img class="absolute h-full w-full object-cover object-center" src="<?php echo (!empty($item->image) && file_exists('./image/' . $item->image)) ? base_url('./image/' . $item->image) : base_url('./image/foto.png'); ?>" alt="Monitoring">
                                </div>
                                <div class="p-4">
                                    <h4 class="text-xl font-bold mb-2"><?php echo $item->tempat; ?></h4>
                                    <p class="text-gray-600 mb-2"><?php echo $item->deskripsi; ?></p>
                                </div>
                                </a>
                                <?php if ($hoursDifference < 1) : ?>
                                    <div class="flex justify-end items-center p-4">
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="confirmDelete('<?php echo base_url('admin/hapus_data_deskripsi/' . $item->id); ?>')">Hapus</button>
                                    </div>
                                <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="w-full text-center">
                    <p class="text-gray-600">Tidak ada data yang tersedia</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>

</body>

</html>