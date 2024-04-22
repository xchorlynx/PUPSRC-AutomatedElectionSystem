<main class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 pt-4 ">
                <div class="container-fluid">
                    <div class="d-flex">
                        <h4 class="page-title text-truncate mx-auto">Configuration</h2>
                    </div>
                    <div class="">

                        <?php

                        global $configuration_pages;
                        global $link_name;
                        $secondary_nav = new SecondaryNav($configuration_pages, $link_name, true);
                        $secondary_nav->getNavLink();
                        ?>
                    </div>

                    <div class="card-box">


                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
</main>
<?php
global $page_scripts;
$page_scripts = '

    ';
