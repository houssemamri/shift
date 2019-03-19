<section>
    <div class="container-fluid migrationnew">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details" style="text-align:center;">
                                <h1>Product Migration Status</h1>
                            </div>
                        </div>  
						  <?php
						  if(!empty($data['error']))
						  { ?>
							  <div class="customerror"><?php echo $data['error']; ?></div>
						  <?php }
						  //print_r($data);
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
						  

