<link rel="stylesheet" href="vendor/plugin/scripts/air-datepicker/dist/css/datepicker.min.css">

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
                        <input type="text" id="year-picker">

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
<script src="vendor/plugin/scripts/air-datepicker/dist/js/datepicker.min.js"></script>
<script src="vendor/plugin/scripts/air-datepicker/dist/js/i18n/datepicker.en.js"></script>
<script src="src/scripts/election-year.js"></script>
    ';
