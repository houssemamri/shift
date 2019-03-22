<section>
    <div class="container-fluid migrationnew">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details" style="text-align:center;">
                                <h1>Product Category Migration Status</h1>
                            </div>
                        </div>
						  <?php
						  if(!empty($data['error']))
						  { ?>
							  <div class="customerror"><?php echo $data['error']; ?></div>
						  <?php }
						  if(!empty($data['success']))
						  { ?>
							  <div class="customsuccess"><?php echo $data['success']; ?></div>
						  <?php }

						  ?>

              <br>
              <br>

              <div class="col-lg-8 col-lg-offset-2">
                  <div class="col-lg-12">
                      <div class="row">
                          <div class="panel-heading details" style="text-align:center;">
                              <h1>Product Migration Status</h1>
                          </div>
                      </div>
                      <?php

                      ?>
