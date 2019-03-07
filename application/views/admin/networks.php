<section>
    <div class="container-fluid networks">
        <div class="row">
            <div class="col-lg-12"> 
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-share-square-o" aria-hidden="true"></i> <?= $this->lang->line('ma125'); ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul>
                                <?php
                                if ($data)
                                {
                                    foreach($data as $social)
                                    {
                                        echo $social;
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
