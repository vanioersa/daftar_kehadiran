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
        background-color: #f5f5f5;
        color: #333;
        width: screen;
    }

    .rating-container {
        margin-bottom: 20px;
        width: screen;
    }

    .rating-container h3 {
        color: #333;
        font-size: 1.8rem;
        margin-bottom: 10px;
    }

    .rating-card {
        border-radius: 0.75rem;
        overflow: hidden;
        transition: transform 0.2s ease-in-out;
    }

    .rating-card:hover {
        transform: scale(1.02);
    }

    .rating-card .bg-blue-500 {
        background-color: #4a90e2;
    }

    .rating-content {
        color: #fff;
        font-size: 1.1rem;
    }

    .profile-picture {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.5rem;
    }

    .star-icon {
        color: gold;
        font-size: 1.8rem;
    }
</style>

<body>
    <?php $this->load->view('sidebar_user'); ?>
    <section class="container mx-auto px-6 py-10 w-screen">
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
                <div class="rating-container mb-8">
                    <h3 class="text-2xl font-semibold mb-4">Rating <?= $rating ?> Bintang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($rows as $row) : ?>
                            <div class="rating-card mb-4">
                                <div class="bg-blue-500 text-white rounded shadow p-6 flex flex-col">
                                    <div class="flex items-center mb-4">
                                        <?php if (!empty($row->id_user)) : ?>
                                            <img src="<?= base_url('./image/' . tampil_image_byid($row->id_user)) ?>" class="profile-picture" alt="Profile Picture" loading="lazy">
                                        <?php else : ?>
                                            <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="profile-picture" alt="Default Profile Picture" loading="lazy" />
                                        <?php endif; ?>
                                        <span class="text-lg"><?= tampil_nama_byid($row->id_user) ?></span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-base rating-content flex-grow"><?= $row->comment; ?></p>
                                        <div class="flex items-center">
                                            <?php for ($i = 1; $i <= $row->rating; $i++) : ?>
                                                <span class="star-icon">&#9733;</span>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
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