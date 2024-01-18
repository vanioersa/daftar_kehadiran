<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Deskripsi</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@next/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    .bubaba {
        width: 370px;
    }

    @media only screen and (max-width: 767px) {
        .bubaba {
            width: 100%;
        }
    }
</style>

<body>
    <?php $this->load->view('sidebar_admin'); ?>

    <a href="<?php echo base_url('admin/tambah_card_public') ?>" class="ml-2 m-10 inline-block px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-semibold text-base rounded">
        <i class="fas fa-plus"></i> Tambah
    </a>

    <h1 style="text-align: center; font-size: xx-large; font-weight: bold;">Public</h1>
    <section class="container mx-auto px-10 p-10">
        <div class="flex flex-wrap -mx-2 mb-20">
            <?php if (!empty($public)) : ?>
                <?php foreach ($public as $item) : ?>
                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/3 xl:w-1/3 px-2 mb-4">
                        <div class="rounded-lg overflow-hidden shadow-md bg-blue-100">
                            <a href="<?php echo base_url('admin/edit_card_public/' . $item->id); ?>">
                                <div class="relative overflow-hidden pb-60">
                                    <img class="absolute h-full w-full object-cover object-center" src="<?php echo (!empty($item->image) && file_exists('./image/' . $item->image)) ? base_url('./image/' . $item->image) : base_url('./image/foto.png'); ?>" alt="Monitoring">
                                </div>
                                <div class="p-6">   
                                    <h4 class="text-xl font-bold mb-2">
                                        <?php echo $item->tempat; ?>
                                    </h4>
                                    <p class="text-gray-600 mb-4"><?php echo $item->deskripsi; ?></p>
                                </a>
                                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="confirmDelete('<?php echo base_url('admin/hapus_data_deskripsi/' . $item->id); ?>')">Hapus</button>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="w-full text-center">Tidak ada data yang tersedia</p>
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
                    // Redirect to the delete URL
                    window.location.href = url;
                }
            });
        }
    </script>

</body>

</html>