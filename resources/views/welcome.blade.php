<!DOCTYPE html>
<html>
<head>
    <title>Datatables with Livewire in Laravel 8</title>
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.2/tailwind.min.css"
          integrity="sha512-l7qZAq1JcXdHei6h2z8h8sMe3NbMrmowhOl+QkP3UhifPpCW2MC4M0i26Y8wYpbz1xD9t61MLT9L1N773dzlOA=="
          crossorigin="anonymous"/>
</head>
<body>
<style>
    .rounded-lg, .rounded-b-none
    {
        width: 1140px;
    }

    .form-input
    {
        width: 450px;
        height: 30px;
    }

</style>
<div class="container mx-auto">
    <br/>
    <div class="flex items-center markdown">
        <h1 style="font-size: 2em;"><b>Datatables with Livewire in Laravel 8</b></h1>
    </div>
    <br/>
    <div class="flex mb-4">
        <livewire:livewire-datatables searchable="name, email, gender" exportable/>
    </div>

</div>

</body>
@livewireScripts
</html>
