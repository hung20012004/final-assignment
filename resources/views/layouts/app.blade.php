<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Your custom CSS if any -->
    @vite(['resources/css/sb-admin-2.min.css'])

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">

		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

        <script src="https://cdn.datatables.net/searchpanes/2.0.2/js/dataTables.searchPanes.min.js"></script>
        <script src="https://cdn.datatables.net/searchpanes/2.0.2/js/searchPanes.bootstrap4.min.js"></script>
</head>
<body id="page-top">
    <x-banner />
    <div id="wrapper" >
        <x-sidebar />
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content mx-0">
                <x-navigation-menu/>
                <main class="">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/1b233c9fdd.js" crossorigin="anonymous"></script>
    @vite(['resources/js/sb-admin-2.min.js'])

</body>
</html>
