<?php
$CI =& get_instance();
?>
<main id="main" class="site-main main">
    <header>
        <div class="container-fluid">
            <?php
            echo form_open('#', array('class' => 'search-pixabay-photos'));
            ?>            
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-magnifier"></i>
                    </span>
                </div>
                <input type="text" class="form-control search-input" placeholder="Search photos by keywords ... " required>
                <div class="input-group-append">
                    <button type="submit">Search on Pixabay</button>
                </div>
            </div>
            <?php
            echo form_close();
            ?>
        </div>
    </header>
    <section class="pixabay-page">
        
        <div class="row">

            <div class="col-xl-12">
                <p class="no-results-found">No results found.</p>
            </div>
            
        </div>

    </section>