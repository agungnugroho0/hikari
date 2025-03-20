<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="public/image/asset/logo.png">

    <style>
        @layer utilities {
            .writing-vertical-rl {
                writing-mode: vertical-rl;
            }
            .text-upright {
                text-orientation: upright;
            }
        }
        @font-face {
            font-family: 'DFMincho-UB';
            src: url('public/font/DFMincho-UB.otf') format('otf'),
                url('public/font/DFMincho-UB.woff') format('woff'),
                url('public/font/DFMincho-UB.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        .font-DF {
            font-family: 'DFMincho-UB', serif, 'Noto Serif JP', 'Yu Gothic', 'Meiryo';
        }
    </style>
</head>
<body >
    <div class="relative w-full min-h-screen md:flex items-center justify-center dark:bg-black">
        <!-- <div class="bg-white"></div> -->
        <div class="md:container mx-auto md:grid bg-white md:max-w-screen-md md:grid-cols-[16rem_auto] md:rounded-xl overflow-hidden">
            <div class="relative">
                <div class="h-[27rem] md:h-[27rem] md:w-64 bg-cover bg-left-top md:bg-center bg-no-repeat" style="background-image:url(public/image/asset/cover.avif);">
                </div>
                <p class="absolute top-5 right-4 writing-vertical-rl text-upright text-4xl font-DF">光学校</p>
            </div>
            <div class="relative flex">
                <div class="flex-grow flex flex-col bg-white justify-center items-center dark:bg-gray-200">
                    <img src="public/image/asset/logo.png" alt="hikari logo" class="hidden md:block w-28 drop-shadow mb-3">
                    <p class="hidden md:block text-3xl font-semibold">LOGIN</p>
                    <form action="app/config/login.php" method="post" class="mt-7 flex flex-col space-y-4 w-full">
                        <input type="text" name="username" id="pengguna" class="h-10 mx-8 p-2 border-b-2 focus:outline-none" placeholder="username" required>
                        <input type="password" name="password" id="password" class="mx-8 h-10 p-2 border-b-2 focus:outline-none" placeholder="password" required>
                        <?php
                        if (isset($_GET['pesan']) && htmlspecialchars($_GET['pesan']) == "gagal") {
                            echo "<div class='mx-8 text-red-500 font-bold text-sm'>Username atau password salah</div>";
                        }
                        ?>
                        <button type="submit" class="mx-8 rounded-lg h-10 font-bold bg-red-800 text-white hover:bg-red-500 active:scale-95 transition duration-200">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>