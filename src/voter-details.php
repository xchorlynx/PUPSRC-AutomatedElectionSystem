<?php
require_once 'includes/classes/db-connector.php';
require_once 'includes/session-handler.php';
require_once 'includes/classes/session-manager.php';

if (isset($_SESSION['voter_id'])) {

    $voter_id = $_GET['voter_id'];

    // ------ SESSION EXCHANGE
    include 'includes/session-exchange.php';
    // ------ END OF SESSION EXCHANGE

    $conn = DatabaseConnection::connect();
    $voter_query = "SELECT * FROM voter WHERE voter_id = $voter_id";
    $result = $conn->query($voter_query);
    $row = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" type="image/x-icon" href="images/resc/ivote-favicon.png">
        <title>Manage Account</title>

        <!-- Icons -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo 'styles/orgs/' . $org_name . '.css'; ?>" id="org-style">
        <link rel="stylesheet" href="styles/style.css" />
        <link rel="stylesheet" href="styles/core.css" />
        <link rel="stylesheet" href="styles/manage-voters.css" />
        <link rel="stylesheet" href="styles/voter-details.css" />
        <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css" />

    </head>

    <body>

        <?php include_once __DIR__ . '/includes/components/sidebar.php'; ?>

        <div class="main">
            <!-- Breadcrumbs -->
            <div class="container mb-5 ml-10">
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <div class="breadcrumbs d-flex">
                            <button type="button" class=" btn-white d-flex align-items-center spacing-8 fs-8">
                                <i data-feather="users" class="white im-cust feather-2xl"></i> MANAGE USERS
                            </button>
                            <button type="button" class="btn-back spacing-8 fs-8"
                                onclick="redirectToPage('manage-voters.php')">VOTERS' ACCOUNTS</button>
                            <button type="button" class="btn btn-current rounded-pill spacing-8 fs-8">VOTER PROFILE</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-wrapper">
                <div class="container mt-xl-3">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-11">
                                <div class="card-box manage-voters">
                                    <div class="row information">
                                        <!-- FIRST COLUMN -->
                                        <div class="col-md-7 p-sm-5">
                                            <!-- Header of Left Column -->
                                            <div class="row">
                                                <!-- COR Name -->
                                                <div class="col-md-6 d-flex flex-row">
                                                    <p class="fw-bold fs-7">
                                                        <i class="fas fa-paperclip fa-sm"></i>
                                                        <span class="ps-sm-1 spacing-5"><?php echo $row["cor"] ?></span>
                                                    </p>
                                                </div>
                                                <!-- Download + Full Screen Name -->
                                                <div class="col-md-6 d-flex flex-row-reverse">
                                                    <div class="row funcs">
                                                        <div class="col-md-10">
                                                            <!-- Download -->
                                                            <a href="<?php echo "user_data/$org_name/cor/" . $row['cor']; ?>"
                                                                download>
                                                                <p class="fs-7 d-flex align-items-center">
                                                                    <i data-feather="download" class="feather-sm"></i>
                                                                    <span
                                                                        class="ps-sm-2 spacing-5 fw-medium">Download</span>
                                                                </p>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <!-- Full Screen -->
                                                            <div class="fullscreen-icon">
                                                                <i class="fa-solid fa-expand fa-sm"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- PDF Container -->
                                            <div class="d-flex justify-content-center" style="height: 50vh;">
                                                <iframe id="pdfViewer"
                                                    src="<?php echo "user_data/$org_name/cor/" . $row['cor']; ?>"
                                                    width="100%" height="100%" frameborder="0" class="cor"></iframe>
                                            </div>
                                        </div>
                                        <!-- SECOND COLUMN -->
                                        <div class="col-md-5 p-sm-5">
                                            <!-- Header -->
                                            <section>
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <!-- Title -->
                                                        <p class="fw-bold fs-3 main-color spacing-4">Voter Details
                                                        </p>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-center">
                                                        <!-- Divider -->
                                                        <div class="text-center horizontal-line"></div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 pt-sm-4">
                                                        <!-- Description -->
                                                        <p class="fw-medium fs-7 spacing-6">The following are the voter's provided information.</p>
                                                    </div>
                                                </div>
                                            </section>

                                            <!-- Student Information -->
                                            <section>
                                                <div class="row pt-sm-4">
                                                    <div class="col-md-12">
                                                        <!-- Email -->
                                                        <p class="fw-bold fs-6 main-color spacing-4">Email Address</p>
                                                        <p class="fw-medium fs-6 pt-sm-2"><?php echo $row["email"] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row pt-sm-4">
                                                    <div class="col-md-12">
                                                        <!-- Status -->
                                                        <p class="fw-bold fs-6 main-color spacing-4">Date Registered</p>
                                                        <p class="fw-medium fs-6 pt-sm-2"><?php echo $row["acc_created"] ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 pt-sm-4">
                                                        <!-- Date -->
                                                        <p class="fw-bold fs-6 main-color spacing-4">Date Verified</p>
                                                        <p class="fw-medium fs-6 pt-sm-2">
                                                            <?php echo date("F j, Y", strtotime($row["status_updated"])); ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row pt-sm-4">
                                                    <div class="col-md-12">
                                                        <!-- Status -->
                                                        <p class="fw-bold fs-6 main-color spacing-4">Account Status</p>
                                                        <div class="row pt-sm-4">
                                                            <div class="col-md-5">

                                                                <form id="status-form" action="update-status.php"
                                                                    method="post">
                                                                    <input type="hidden" id="voter_id" name="voter_id"
                                                                        value="<?php echo $voter_id; ?>">

                                                                    <?php
                                                                    $status = $row["status"];
                                                                    $statusClass = '';

                                                                    switch ($status) {
                                                                        case 'Active':
                                                                            $statusClass = 'active-status';
                                                                            break;
                                                                        case 'Inactive':
                                                                            $statusClass = 'inactive-status';
                                                                            break;
                                                                        case 'Rejected':
                                                                            $statusClass = 'rejected-status';
                                                                            break;
                                                                        default:
                                                                            $statusClass = '';
                                                                            break;
                                                                    }
                                                                    ?>

                                                                    <select name="dropdown" id="dropdown"
                                                                        class="status-background <?php echo $statusClass; ?>">
                                                                        <option value="Active" <?php if ($row["status"] == 'Active')
                                                                            echo 'selected="selected"'; ?>>Active</option>
                                                                        <option value="Disabled" <?php if ($row["status"] == 'Inactive')
                                                                            echo 'selected="selected"'; ?>>Disable</option>
                                                                        <option value="Reject" <?php if ($row["status"] == 'Rejected')
                                                                            echo 'selected="selected"'; ?>>Reject
                                                                        </option>
                                                                    </select>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <!-- Status -->
                                                                <p class="fw-bold fs-8 spacing-4">Last update on:</p>
                                                                <p class="fw-medium fs-8 ">
                                                                    <?php echo date("F j, Y", strtotime($row["status_updated"])); ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </section>
                                            <!-- Buttons -->
                                            <section>
                                                <div class="row pt-sm-5">
                                                    <div class="col-md-12 text-end">
                                                        <button
                                                            class="del-no-border px-sm-5 py-sm-1-5 btn-sm fw-bold fs-6 spacing-6"
                                                            id="reject-btn" data-toggle="modal"
                                                            data-target="#rejectModal">Delete Account</button>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <?php include_once __DIR__ . '/includes/components/footer.php'; ?>

        <!-- Confirm Reject Modal -->
        <div class="modal" id="rejectModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="row p-4">
                            <div class="col-md-12 pb-3">
                                <div class="text-center">
                                    <div class="col-md-12 p-3">
                                        <img src="images/resc/warning.png" class="warning-perc" alt="iVote Logo">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 pb-3 confirm-delete">
                                            <p class="fw-bold fs-3 danger spacing-4">Confirm Delete?</p>
                                            <p class="pt-2 fw-medium spacing-5">A heads up: this action <span
                                                    class="fw-bold">cannot be undone!</span></p>
                                            <p class="fw-medium spacing-5 pt-1">Type '<span class="fw-bold">Confirm
                                                    Delete</span>' to proceed.</p>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center"> <!-- Add justify-content-center class -->
                                        <div class="col-md-11 pb-3 pt-3 confirm-delete text-center mx-auto">
                                            <!-- Add mx-auto class -->
                                            <form action="#" method="post">
                                                <div class="form-group">
                                                    <input type="text" class="form-control pt-2 bg-primary text-black"
                                                        id="confirm-deletion" placeholder="Type here..."
                                                        oninput="validateConfirmation()">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 pt-3 text-center">
                                <div class="d-inline-block">
                                    <button class="btn btn-light px-sm-5 py-sm-1-5 btn-sm fw-bold fs-6 spacing-6"
                                        onClick="closeModal()" aria-label="Close">Cancel</button>
                                </div>
                                <div class="d-inline-block">
                                    <form class="d-inline-block">
                                        <input type="hidden" id="voter_id" name="voter_id" value="<?php echo $voter_id; ?>">
                                        <button class="btn btn-danger px-sm-5 py-sm-1-5 btn-sm fw-bold fs-6 spacing-6"
                                            type="submit" id="confirm-delete" value="delete" disabled>Delete</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejected Successfully Modal -->
        <div class="modal" id="deleteDone" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-end">
                            <i class="fa fa-solid fa-circle-xmark fa-xl close-mark light-gray"
                                onclick="redirectToPage('manage-voters.php')">
                            </i>
                        </div>
                        <div class="text-center p-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="fw-bold fs-3 danger spacing-4">Account Deleted</p>
                                    <p class="fw-medium spacing-5">The account has been successfully deleted.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="scripts/script.js"></script>
        <script src="scripts/manage-voters.js"></script>
        <script src="scripts/feather.js"></script>


    </body>


    </html>

    <?php
} else {
    header("Location: landing-page.php");
}
?>