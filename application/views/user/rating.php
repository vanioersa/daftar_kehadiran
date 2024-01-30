<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .card {
            max-width: 400px;
            margin: 0 auto;
            background-color: #f3f3f3;
        }

        .star-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .star-icon {
            font-size: 2.5em;
            cursor: pointer;
            color: #ccc;
            transition: color 0.3s;
        }

        .star-icon.clicked {
            color: #fbbf24;
        }

        @media only screen and (max-width: 767px) {
            .card {
                max-width: 300px;
            }

            .star-icon {
                font-size: 2em;
            }
        }

        .comment-box {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 8px;
            margin-top: 10px;
        }

        .submit-button {
            background-color: #34d399;
        }

        .rating-results {
            margin-top: 20px;
        }

        .rating-results .card {
            margin-top: 10px;
        }

        .rating-results .card .bg-blue-300 {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <?php $this->load->view('sidebar_user'); ?>

    <div class="mx-auto md:my-10 my-14">
        <div class="max-w-md shadow-md rounded-md overflow-hidden card">
            <div class="p-6">
                <form id="myForm" action="<?= base_url('user/aksi_ratting'); ?>" method="post">
                    <?php if (empty($ratingResults)) : ?>
                        <div class="mb-6 text-center rating-container">
                            <label for="rating" class="block text-2xl font-bold text-gray-600 mb-2">Beri Rating:</label>
                            <div class="star-container">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="star-icon" onclick="setRating(<?= $i ?>)">&#9733;</span>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" id="rating" name="rating" value="0">
                            <output for="rating" class="rating-output text-3xl font-bold">0</output>
                        </div>
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-600">Komentar:</label>
                            <textarea id="comment" name="comment" rows="3" class="w-full p-2 mt-1 bg-gray-100 rounded-md comment-box"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800 submit-button">
                            Kirim
                        </button>
                    <?php else : ?>
                        <p>Anda telah memberikan rating sebelumnya. Terima kasih!</p>
                    <?php endif; ?>
                </form>

                <?php function get_star_icons_fa($rating)
                {
                    $stars = '';
                    $fullStars = floor($rating);
                    $halfStar = ceil($rating - $fullStars);

                    for ($i = 0; $i < $fullStars; $i++) {
                        $stars .= '<i class="fas fa-star"></i>';
                    }

                    if ($halfStar) {
                        $stars .= '<i class="fas fa-star-half-alt"></i>';
                    }

                    return $stars;
                } ?>
                <div onclick="window.location='<?= base_url('user/rating_pengguna') ?>'" class="mt-8 rating-results">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Rating Dari (<?php foreach ($user as $row) : ?><?php echo $row->nama; ?><?php endforeach; ?>):</h2>
                    <?php foreach ($ratingResults as $result) : ?>
                        <div class="card">
                            <div class="bg-blue-500 p-4 rounded-md shadow-md">
                                <p class="text-lg font-semibold text-white mb-2"><?= tampil_nama_byid($result->id_user) ?></p>
                                <p class="text-white mb-2"><?= $result->comment ?></p>

                                <p class="font-semibold text-white"><span class="star-icons" style="color: #fbbf24;"><?= get_star_icons_fa($result->rating) ?></span></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setRating(rating) {
            const ratingIcons = document.querySelectorAll('.star-icon');
            const output = document.querySelector('output[for="rating"]');

            ratingIcons.forEach((icon, index) => {
                icon.classList.toggle('clicked', index < rating);
            });

            output.textContent = rating;
            document.getElementById('rating').value = rating;
        }
    </script>
</body>

</html>