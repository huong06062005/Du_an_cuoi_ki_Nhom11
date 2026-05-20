<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | VietTravel</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
            margin: 0;
            padding: 0;
        }
        /* Xóa padding-top ở đây để Banner sát Header */
        main { 
            flex: 1; 
            width: 100%;
        } 
        .animate-fade-in { 
            animation: fadeIn 0.8s ease-out forwards; 
        }
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
    </style>
</head>
<body class="bg-white text-slate-800">

    @include('client.layouts.header')

    <main class="animate-fade-in">
        @yield('content')
    </main>

    @include('client.layouts.footer')

</body>
</html>