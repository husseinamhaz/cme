<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
        <div id="app" style="width: 100%; height: 100vh">
            <example-component></example-component>
        </div>
</div>
</body>
</html>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    let xhr = new XMLHttpRequest();
    xhr.open('GET', "http://127.0.0.1:8000/pharmacy", true);
    xhr.send();

    xhr.onreadystatechange = processRequest;

    function processRequest(e) {
        console.log(e);
    }

    const url = 'http://127.0.0.1:8000/pharmacy';
    const data = {
        name: "said",
        phone_number: "said",
        "_token": "{{ csrf_token() }}",
    };
    $('.btn').click(function () {
        $.post(url, data, function (data, status) {
            console.log(data);
        })
    })
</script>
