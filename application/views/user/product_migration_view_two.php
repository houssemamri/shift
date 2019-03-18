<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>CodeIgniter | Product Migration</title>

    <style media="screen">
      .container {
        height: 470px;
        width: 50%;
        margin-top: 5%;
        padding-top: 20px;
        border-radius: 5px;
        background-color: #eeeeee;
        overflow: scroll;
      }

      .container div {
        border-radius: 5px;
      }

      .container button {
        width: 100%;
      }
    </style>
  </head>
  <body>

    <div class="container">
      <?php
        /*
        if ($magento_api_connection_status) {
          echo "<br><div class='p-3 mb-2 bg-success text-white'>Magento API connection successful.</div>";
        } else {
          echo "<br><div class='p-3 mb-2 bg-danger text-white'>Magento API connection unsuccessful.</div>";
        }

        if ($response_status) {
          echo "<br><div class='p-3 mb-2 bg-success text-white'>Category migration successful.</div>";
        } else {
          echo "<br><div class='p-3 mb-2 bg-danger text-white'>Category migration unsuccessful.</div>";
        }
        */
      ?>
      <button type="button" class="btn btn-primary" onclick="window.location='<?php echo site_url("user/Product_migration_controller/start_product_migration");?>'">Start product migration</button>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
