<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oops! Something went wrong.</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .error-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .error-page h1 {
            font-size: 6rem;
        }

        .error-page p {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>

    <!-- <div>
            <h1>Oops!</h1>
            <p>Something went wrong. Please try again later.</p>
  </div> -->
    <main class="d-flex justify-content-center align-items-center">
        <div class="error-page">
            <!-- Error 404 Template 1 - Bootstrap Brain Component -->
            <section class="py-3 py-md-5 w-100">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6 mt-5">
                            <div class="text-center">
                                <h2 class="display-2 fw-bold">
                                    #404
                                </h2>
                                <h3 class="h2 mb-4">Oops! We could not find the page!</h3>
                                <!-- <p class="mb-5">The page you are looking for was not found.</p> -->
                                <a class="btn bsb-btn-5xl btn-warning rounded-pill px-5 fs-6 m-2"
                                    href="javascript:void(0);" onclick="location.reload();">Refresh</a>

                                <a class="btn bsb-btn-5xl btn-warning rounded-pill px-5 fs-6 m-2"
                                    href="tel:+918220017619">
                                    <i class="fas fa-phone"></i> Vivin - +9182200 17619
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <img class="img-fluid float-end" height="50%" width="70%" src="assets/img/404.jpg"
                                alt="404 Error Page" />
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

</body>

</html>
