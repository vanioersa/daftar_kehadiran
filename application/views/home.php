<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peduli Alam sekitar</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@next/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="text-gray-700 bg-white" style="font-family: 'Source Sans Pro', sans-serif">
    <nav style="background-color: #667eea" class="text-black">
        <div class="container mx-auto px-6 py-2 flex justify-between items-center">
            <a class="flex items-center font-bold text-2xl lg:text-4xl" href="#">
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
                        <a class="px-4 py-2 hover:text-gray-800" href="<?php echo base_url('auth/register') ?>">Register</a>
                    </li>
                    <li>
                        <a class="px-4 py-2 hover:text-gray-800" href="<?php echo base_url('auth') ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="container mx-auto px-6 p-10">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">
            Features
        </h2>
        <div class="flex items-center flex-wrap mb-20">
            <div class="w-full md:w-1/2">
                <h4 class="text-3xl text-gray-800 font-bold mb-3">
                    Exercise Metrics
                </h4>
                <p class="text-gray-600 mb-8">
                    Our Smart Health Monitoring Wristwatch is able to capture you vitals
                    while you exercise. You can create different category of exercises
                    and can track your vitals on the go.
                </p>
            </div>
            <div class="w-full md:w-1/2">
                <img src="assets/health.svg" alt="Monitoring" />
            </div>
        </div>
        <div class="flex items-center flex-wrap mb-20">
            <div class="w-full md:w-1/2">
                <img src="assets/report.svg" alt="Reporting" />
            </div>
            <div class="w-full md:w-1/2 pl-10">
                <h4 class="text-3xl text-gray-800 font-bold mb-3">
                    Reporting
                </h4>
                <p class="text-gray-600 mb-8">
                    Our Smart Health Monitoring Wristwatch can generate a comprehensive
                    report on your vitals depending on your settings either daily,
                    weekly, monthly, quarterly or yearly.
                </p>
            </div>
        </div>
        <div class="flex items-center flex-wrap mb-20">
            <div class="w-full md:w-1/2">
                <h4 class="text-3xl text-gray-800 font-bold mb-3">
                    Syncing
                </h4>
                <p class="text-gray-600 mb-8">
                    Our Smart Health Monitoring Wristwatch allows you to sync data
                    across all your mobile devices whether iOS, Android or Windows OS
                    and also to your laptop whether MacOS, GNU/Linux or Windows OS.
                </p>
            </div>
            <div class="w-full md:w-1/2">
                <img src="assets/sync.svg" alt="Syncing" />
            </div>
        </div>
    </section>

    <section class="bg-blue-100">
        <div class="container mx-auto px-6 py-20">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">
                Testimonials
            </h2>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <div class="bg-white rounded shadow py-2">
                        <p class="text-gray-800 text-base px-6 mb-5">
                            Monitoring and tracking my health vitals anywhere I go and on
                            any platform I use has never been easier.
                        </p>
                        <p class="text-gray-500 text-xs md:text-sm px-6">
                            John Doe
                        </p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <div class="bg-white rounded shadow py-2">
                        <p class="text-gray-800 text-base px-6 mb-5">
                            As an Athlete, this is the perfect product for me. I wear my
                            Smart Health Monitoring Wristwatch everywhere I go, even in the
                            bathroom since it's waterproof.
                        </p>
                        <p class="text-gray-500 text-xs md:text-sm px-6">
                            Jane Doe
                        </p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <div class="bg-white rounded shadow py-2">
                        <p class="text-gray-800 text-base px-6 mb-5">
                            I don't regret buying this wearble gadget. One of the best
                            gadgets I own!.
                        </p>
                        <p class="text-gray-500 text-xs md:text-sm px-6">
                            James Doe
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="bg-gray-300">
        <div class="container mx-auto px-6 pt-10 pb-6">
            <div class="flex flex-wrap">
                <div class="w-full text-center">
                    <!-- <a href="" class="text-4xl font-bold text-center text-gray-800 mb-8">Testimonials</a> -->
                    <a href="" class="py-2 px-4 text-center inline-block hover:underline">© 2023 Peduli lingkungan alam. All rights reserved.</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Add JavaScript to handle the toggle of the navigation menu
        document.getElementById('menuBtn').addEventListener('click', function() {
            var menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>