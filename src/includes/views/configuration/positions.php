<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.0/air-datepicker.min.css">

<main class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 pt-4">
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
                        <table id="example" class="table table-striped table-hover" style="width:100%; display: none;">
                            <thead>
                                <tr class="d-none">
                                    <th>Seq</th>
                                    <th>Name</th>
                                    <th>Duties and Responsibilities</th>
                                </tr>
                            </thead>
                            <tbody>



                            </tbody>

                        </table>


                    </div>




                    <div class="toolbar" style="display : none;">
                        <div class="tools">
                            <button type="button" class="btn btn-primary del me-2 me-md-3" data-selected="" data-bs-toggle="tooltip" data-bs-title="Default tooltip" data-bs-placement="right">
                                <span class="icon trash ">
                                    <i data-feather="trash" width="calc(1rem + 0.5vw)" height="calc(1rem + 0.5vw)"></i>
                                </span>
                                <span class="d-none d-sm-inline">Delete</span>
                            </button>
                            <button type="button" class="btn btn-primary del me-2 me-md-3 d-none" data-selected="">
                                <span class="icon trash ">
                                    <i data-feather="trash" width="calc(1rem + 0.5vw)" height="calc(1rem + 0.5vw)"></i>
                                </span>
                                <span class="d-none d-sm-inline">Edit</span>
                            </button>
                            <b class="item-count"><span class="count"></span> items selected</b>

                        </div>
                        <span class="save-status">
                            <span class="text-uppercase weight-700 save-icon">Note: </span>
                            <span class="save-msg text-truncate">Your changes are saved automatically.</span>
                        </span>
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
