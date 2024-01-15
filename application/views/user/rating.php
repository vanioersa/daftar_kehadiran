<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating and Text Input with Tailwind CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php $this->load->view('sidebar_user'); ?>

    <div class="container mx-auto mt-8">
        <div class="max-w-sm mx-auto bg-blue-500 shadow-md rounded-md overflow-hidden">
            <div class="p-6">
                <form id="myForm" action="submit_form.php" method="post">
                    <div class="mb-6">
                        <label for="rating" class="block text-sm font-medium text-gray-600">Rating:</label>
                        <div class="flex items-center mt-1">
                            <input type="range" id="rating" name="rating" min="1" max="5" class="w-full appearance-none bg-gray-300 rounded-md h-2">
                            <output for="rating" class="ml-2 text-gray-900">3</output>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-gray-600">Comment:</label>
                        <textarea id="comment" name="comment" rows="3" class="w-full p-2 mt-1 bg-gray-100 rounded-md"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const ratingInput = document.getElementById('rating');
        const output = document.querySelector('output[for="rating"]');
        const commentInput = document.getElementById('comment');

        ratingInput.addEventListener('input', function() {
            output.textContent = this.value;
        });
    </script>
</body>

</html>