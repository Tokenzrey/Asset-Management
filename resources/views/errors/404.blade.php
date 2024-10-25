<!DOCTYPE html>
<html lang="en">

<head>
    <title>404 not found</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('simas/login/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('simas/login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('simas/login/css/main.css') }}">
    <!--===============================================================================================-->
    <style>
        /* Container styling */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            text-align: center;
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            font-size: 5em;
            margin: 0;
            color: #ff6b6b;
        }

        p {
            font-size: 1.2em;
            margin: 15px 0;
            color: #666;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #45a049;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            h1 {
                font-size: 3em;
            }

            p {
                font-size: 1em;
            }

            a {
                padding: 8px 16px;
                font-size: 0.9em;
            }
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')
    <div class="container">
        <h1>404 - Page Not Found</h1>
        <p>Sorry, the page you are looking for could not be found.</p>
        <a href="{{ route('dashboard.user') }}">Return to Home</a>
    </div>
</body>

</html>
