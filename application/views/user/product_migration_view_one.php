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
      }

      #heading {
        border-radius: 5px;
      }

      .container .btn {
        width: 100%;
      }
    </style>
  </head>
  <body>

    <div class="container">
      <?php echo form_open('user/Product_migration_controller/get_user_website_selection'); ?>

      <div class="p-3 mb-2 bg-info text-white" id="heading">Please select any one of the following Magento url: </div>
      <select class="form-control" name="magento_website_url">
        <?php
          foreach ($all_user_magento_websites as $key => $value) {
            echo '<option>'.$value.'</option>';
          }
        ?>
      </select>

      <br>
      <br>
      <br>
      <br>

      <div class="p-3 mb-2 bg-info text-white" id="heading">Please select any one of the following OpenCart url: </div>
      <select class="form-control" name="opencart_website_url">
        <?php
          foreach ($all_user_opencart_websites as $key => $value) {
            echo '<option>'.$value.'</option>';
          }
        ?>
      </select>

      <br>
      <br>
      <br>
      <br>

      <?php
        $data = array(
          'name'  => 'submit',
          'class' => 'btn btn-primary',
          'value' => 'Select'
        );
        echo form_submit($data);
      ?>

      <?php echo form_close(); ?>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
