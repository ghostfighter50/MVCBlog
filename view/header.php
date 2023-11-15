<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC Blog</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/styles.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@600&display=swap" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php
    // Define a list of valid messages and errors
    $validMessages = json_decode(file_get_contents("config/messages.json"), true);
    $validErrors = json_decode(file_get_contents("config/errors.json"), true);

    // Retrieve messages and errors from URL parameters
    $message = filter_input(INPUT_GET, 'message', FILTER_SANITIZE_STRING);
    $error = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_STRING);

    // Check if the provided keys are valid, otherwise set default values
    //$message = isset($validMessages[$messageKey]) ? $validMessages[$messageKey] : null;
    //$error = isset($validErrors[$errorKey]) ? $validErrors[$errorKey] : null;

  
    ?>

    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">MVC Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Success Message -->
    <?php if (!empty($message)) { ?>

            <div class="container alert alert-info alert-dismissible fade show" role="alert" id="successAlert">
                <h4><?= $message ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- JavaScript to hide success message after 3 seconds -->
            <script>
                setTimeout(function () {
                    document.getElementById('successAlert').style.display = 'none';
                }, 3000);
            </script>
    <?php }
    ; ?>

    <!-- Error Message -->
    <?php if (!empty($error)) { ?>

            <div class="container alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                <h4><?= $error ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- JavaScript to hide error message after 3 seconds -->
            <script>
                setTimeout(function () {
                    document.getElementById('errorAlert').style.display = 'none';
                }, 3000);
            </script>
    <?php }    ; ?>

