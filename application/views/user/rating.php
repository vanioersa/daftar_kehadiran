<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .card {
            max-width: 400px;
            margin: 0 auto;
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

        .rating-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .rating-stars {
            display: flex;
            margin-top: 10px;
        }

        .star-label {
            font-size: 1.5em;
            margin: 0 5px;
        }

        .rating-output {
            font-size: 2em;
            font-weight: bold;
            color: #fbbf24;
            margin-top: 10px;
        }

        .rating-results {
            margin-top: 20px;
        }

        .user-rating {
            margin-top: 10px;
            font-size: 1.2em;
        }
    </style>
</head>

<body>
    <?php $this->load->view('sidebar_user'); ?>

    <div class="container my-8">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-md overflow-hidden card">
            <div class="p-6">
                <form id="myForm" action="<?= base_url('user/aksi_ratting'); ?>" method="post">
                    <div class="mb-6 text-center rating-container">
                        <label for="rating" class="block text-sm font-medium text-gray-600">Berikan Rating:</label>
                        <div class="rating-stars">
                            <?php for ($i = 5; $i >= 1; $i--) : ?>
                                <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" class="hidden">
                                <label for="star<?= $i ?>" class="star-icon" onclick="toggleStar(this)">&#9733;</label>
                            <?php endfor; ?>
                        </div>
                        <output for="rating" class="rating-output">0</output>
                    </div>
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-gray-600">Komentar:</label>
                        <textarea id="comment" name="comment" rows="3" class="w-full p-2 mt-1 bg-gray-100 rounded-md comment-box"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800 submit-button">
                        Kirim
                    </button>
                </form>

                <div class="mt-8 rating-results">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Rating:</h2>
                    <?php foreach ($ratingResults as $result) : ?>
                        <div class="mb-4 user-rating">
                            <p>Rating: <span style="color: #fbbf24;"><?= get_star_icons($result->rating) ?></span></p>
                            <p class="text-gray-600"><?= $result->comment ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleStar(star) {
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            const output = document.querySelector('output[for="rating"]');

            star.classList.toggle('clicked');

            const clickedStars = document.querySelectorAll('.star-icon.clicked');
            const rating = clickedStars.length;

            output.textContent = rating;
        }

        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        const output = document.querySelector('output[for="rating"]');

        ratingInputs.forEach(ratingInput => {
            ratingInput.addEventListener('change', function () {
                output.textContent = this.value;
            });
        });
    </script>
</body>

</html>
