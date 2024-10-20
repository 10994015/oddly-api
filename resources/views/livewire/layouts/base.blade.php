<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ config('app.name', '博盈助手') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/css/game.scss'])
</head>
<body style="background-color: black;">
    <div class="bg-black text-[white] p-4" style="background-color: black;">
        <header class="bg-black text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold" style="color:#D1C287">博盈助手</h1>
                <i class="fa-solid fa-right-from-bracket " style="font-size: 24px;"></i>
            </div>
        </header>
        <main>
            {{$slot}}
        </main>
    </div>
    @vite(['resources/js/app.js', 'resources/js/script.js'])
</body>
</html>
