<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            .bd-placeholder-img {
              font-size: 1.125rem;
              text-anchor: middle;
              -webkit-user-select: none;
              -moz-user-select: none;
              user-select: none;
            }

            @media (min-width: 768px) {
              .bd-placeholder-img-lg {
                font-size: 3.5rem;
              }
            }

            .b-example-divider {
              height: 3rem;
              background-color: rgba(0, 0, 0, .1);
              border: solid rgba(0, 0, 0, .15);
              border-width: 1px 0;
              box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
            }

            .b-example-vr {
              flex-shrink: 0;
              width: 1.5rem;
              height: 100vh;
            }

            .bi {
              vertical-align: -.125em;
              fill: currentColor;
            }

            .nav-scroller {
              position: relative;
              z-index: 2;
              height: 2.75rem;
              overflow-y: hidden;
            }

            .nav-scroller .nav {
              display: flex;
              flex-wrap: nowrap;
              padding-bottom: 1rem;
              margin-top: -1px;
              overflow-x: auto;
              text-align: center;
              white-space: nowrap;
              -webkit-overflow-scrolling: touch;
            }
          </style>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
        <?php
            if (isset($responseStruct))
            {
        ?>
                <div class="alert alert-<?php echo $responseStruct->typeMessage?> alert-dismissible fade show" role="alert">
                    <?php
                        if (count($responseStruct->messages)) {
                            echo '<ul>';
                            foreach ($responseStruct->messages as $value)
                            {
                                echo '<li> '.$value.' </li>';
                            }
                            echo '</ul>';
                        } else {
                            echo $responseStruct->status;
                        }
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php
            }
        ?>

        <main>
            <div class="container py-4">
              <header class="pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
                  <span class="fs-4">File CSV|XLS|XLSX</span>
                </a>
              </header>

              <div class="p-5 mb-4 bg-light rounded-3">
                <div class="container-fluid py-2">
                  <h1 class="display-5 fw-bold">Import Objects</h1>
                  <p class="col-md-8 fs-4">Functionality for registering objects.
                    Only new objects are registered, objects that already exist in the system are not registered.
                    The system is smart enough to automatically feed, manufacturer, models, sectors and voltages, without registering redundancies in these categories.</p>

                  <br />
                  <div class="row align-items-md-stretch">
                    <form action="/" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                          <div>
                            <label for="formFileLg" class="form-label">Accepted Files, xls, xlsx, csv.</label>
                            <input class="form-control form-control-lg" name="document_file" id="formFileLg" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                  </div>

                </div>
              </div>
              <footer class="pt-3 mt-4 text-muted border-top">
                RonaldoQJ&copy; 2023
              </footer>
            </div>
          </main>
    </body>
</html>
