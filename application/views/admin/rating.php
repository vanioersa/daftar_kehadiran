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

    .rating-container h3 {
        color: #333;
        margin-bottom: 5px;
    }

    .star-icon {
        color: #fbbf24;
        font-size: 1.5em;
    }
</style>

<body>
    <?php $this->load->view('sidebar_admin'); ?>
    <section class="container mx-auto px-6 py-10">
        <h2 class="text-4xl font-bold text-center mb-8">Rating</h2>
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
                <div class="rating-container mb-20">
                    <h3 class="text-2xl font-semibold mb-4">Rating <?= $rating ?> Bintang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                        <?php foreach ($rows as $row) : ?>
                            <div class="rating-card">
                                <div class="bg-blue-600 text-white rounded shadow p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <?php if (!empty($row->id_user)) : ?>
                                                <img src="<?= base_url('./image/' . tampil_image_byid($row->id_user)) ?>" class="object-cover w-10 h-10 rounded-full" alt="Profile Picture" loading="lazy">
                                            <?php else : ?>
                                                <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="object-cover w-10 h-10 rounded-full" alt="Default Profile Picture" loading="lazy" />
                                            <?php endif; ?>
                                            <span class="ml-2"><?= tampil_nama_byid($row->id_user) ?></span>
                                        </div>
                                        <div class="flex items-center">
                                            <?php for ($i = 1; $i <= $row->rating; $i++) : ?>
                                                <span class="star-icon">&#9733;</span>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <p class="text-base rating-content"><?= $row->comment; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-gray-800 text-base px-6 mb-5 text-center">Tidak ada data yang tersedia.</p>
        <?php endif; ?>
    </section>
</body>

</html>
