<?php
require_once 'includes/classes/db-connector.php';
require_once 'includes/session-handler.php';
require_once 'includes/classes/session-manager.php';
require_once 'includes/classes/query-handler.php';

if (isset($_SESSION['voter_id'])) {

	include 'includes/session-exchange.php';
	include 'submission_handlers/manage-acc.php';
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
		<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

		<!-- Styles -->
		<link rel="stylesheet" href="<?php echo 'styles/orgs/' . $org_name . '.css'; ?>" id="org-style">
		<link rel="stylesheet" href="styles/style.css" />
		<link rel="stylesheet" href="styles/core.css" />
		<link rel="stylesheet" href="styles/tables.css" />
		<link rel="stylesheet" href="styles/manage-voters.css" />
		<link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	</head>

	<body>

		<?php include_once __DIR__ . '/includes/components/sidebar.php'; ?>

		<div class="main">

			<div class="container mb-5 pl-5">
				<div class="row justify-content-center">
					<div class="col-md-11">
						<div class="breadcrumbs d-flex">
							<button type="button" class="btn btn-lvl-white d-flex align-items-center spacing-8 fs-8">
								<i data-feather="users" class="white im-cust feather-2xl"></i> MANAGE USERS
							</button>
							<button type="button" class="btn btn-lvl-current rounded-pill spacing-8 fs-8">VOTERS' ACCOUNTS</button>
						</div>
					</div>
				</div>
			</div>


			<div class="container">
				<div class="row justify-content-center">
					<!-- FOR VERIFICATION TABLE -->
					<div class="col-md-10 card-box">
						<div class="container-fluid">
							<div class="card-box">
								<div class="row">
									<div class="content">
										<div class="table-wrapper">

											<!-- For empty state: see first if the table has value -->
											<?php if ($to_verify_tbl->num_rows > 0) { ?>

												<div class="table-title">
													<div class="row">
														<!-- HEADER -->
														<div class="col-sm-6">
															<p class="fs-3 main-color fw-bold ls-10 spacing-6">Pending
																Registrations</p>
														</div>

														<div class="col-sm-6">
															<div class="row">
																<div class="col-md-12 text-end">
																	<div class="d-inline-block">
																		<button class="delete-btn fs-7 spacing-6 fw-medium"
																			type="button" id="dropdownMenuButton"
																			data-bs-toggle="dropdown" aria-haspopup="true"
																			aria-expanded="false"><i
																				class="fa-solid fa-trash-can fa-sm"></i>
																			Delete
																		</button>

																		<span class="light-gray-accent fw-bold ps-3">|</span>
																	</div>
																	<div class="d-inline-block ps-3">
																		<form class="d-inline-block">
																			<div class="dropdown sort-by">
																				<button
																					class="sortby-tbn fs-7 spacing-6 fw-medium"
																					type="button" id="dropdownMenuButton"
																					data-bs-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa-solid fa-arrow-down-wide-short fa-sm"></i>
																					Sort by
																				</button>
																				<div class="dropdown-menu dropdown-menu-end"
																					aria-labelledby="dropdownMenuButton"
																					style="padding:0.5rem"">
																				<!-- Dropdown items -->
																				<li class=" dropdown-item ps-3 fs-7 fw-medium">Newest to
																					Oldest</li>
																					<li
																						class="dropdown-item ps-3 fs-7 fw-medium">
																						Oldest to
																						Newest</li>
																					<li
																						class="dropdown-item ps-3 fs-7 fw-medium">
																						A to Z
																						(Ascending)</li>
																					<li
																						class="dropdown-item ps-3 fs-7 fw-medium">
																						Z to A
																						(Descending)</li>
																				</div>
																			</div>
																		</form>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<table class=table table-striped table-hover">
														<thead class="tl-header">
															<tr>
																<th class="col-md-6 tl-left text-center fs-7 fw-bold spacing-5">
																	<i data-feather="mail" class="feather-xs im-cust"></i>Email
																	Address
																</th>
																<th
																	class="col-md-6 tl-right text-center fs-7 fw-bold spacing-5">
																	<i data-feather="calendar"
																		class="feather-xs im-cust"></i>Date Registered
																</th>
															</tr>
														</thead>
														<tbody>
															<?php while ($row = $to_verify_tbl->fetch_assoc()) { ?>
																<tr>
																	</td>
																	<td class="col-md-6 text-center"><a
																			href="validate-voter.php?voter_id=<?php echo $row["voter_id"]; ?>"><?php echo $row["email"]; ?></a>
																	</td>
																	<td class="col-md-6 text-center">
																		<?php echo date("F j, Y", strtotime($row["acc_created"])); ?>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
													<div class="clearfix col-xs-12">
														<ul class="pagination">
															<li class="fas fa-chevron-left black"><a href="#"></a></li>
															<li class="page-item"><a href="#" class="page-link">1</a></li>
															<li class="page-item"><a href="#" class="page-link">2</a></li>
															<li class="page-item active"><a href="#" class="page-link">3</a>
															</li>
															<li class="page-item"><a href="#" class="page-link">4</a></li>
															<li class="page-item"><a href="#" class="page-link">5</a></li>
															<li class="fas fa-chevron-right ps-xl-3 black"><a href="#"></a></li>
														</ul>
													</div>

													<!-- If empty, show empty state -->
												<?php } else { ?>

													<div class="table-title">
														<div class="row">
															<!-- HEADER -->
															<div class="col-sm-12">
																<p class="fs-3 main-color fw-bold ls-10 spacing-6">Pending
																	Registrations</p>
															</div>
														</div>
														<div class="col-md-12 no-registration text-center">
															<img src="images/resc/folder-empty.png" class="illus">
															<p class="fw-bold spacing-6 black">No registrations yet</p>
															<p class="spacing-3 pt-1 black">You’ll find account registrations
																right
																here!
															</p>
														</div>
													<?php } ?>

												</div>

											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- VERIFIED TABLE -->
					<div class="row justify-content-center">
						<div class="col-md-10 card-box  mt-md-5">
							<div class="container-fluid">
								<div class="card-box">
									<div class="row">
										<div class="content">
											<div class="table-wrapper">
												<?php if ($verified_tbl->num_rows > 0) { ?>
													<div class="table-title">
														<div class="row">
															<!-- Table Header -->
															<div class="col-sm-6">
																<p class="fs-3 main-color fw-bold ls-10 spacing-6">Pending
																	Registrations</p>
															</div>
															<div class="col-sm-6">
																<div class="row">


																	<div class="col-md-12 text-end flex-end">
																		<!-- Delete -->
																		<div class="d-inline-block">
																			<button class="delete-btn fs-7 spacing-6 fw-medium"
																				type="button" id="dropdownMenuButton"
																				data-bs-toggle="dropdown" aria-haspopup="true"
																				aria-expanded="false">
																				<i class="fa-solid fa-trash-can fa-sm"></i>
																				Delete
																			</button>
																			<span
																				class="light-gray-accent fw-bold ps-3">|</span>
																		</div>
																		<!-- Filters -->
																		<div class="d-inline-block ps-3">
																			<form class="d-inline-block">
																				<div class="dropdown sort-by">
																					<button
																						class="sortby-tbn fs-7 spacing-6 fw-medium"
																						type="button" id="dropdownMenuButton"
																						data-bs-toggle="dropdown"
																						aria-haspopup="true"
																						aria-expanded="false">
																						<i data-feather="filter"
																							class="feather-xs im-cust-2"></i>
																						Filters
																					</button>
																					<div class="dropdown-menu dropdown-menu-end"
																						aria-labelledby="dropdownMenuButton"
																						style="padding: 0.5rem">
																						<!-- Checklist Items -->
																						<li
																							class="dropdown-item ps-3 fs-7 fw-medium">
																							Active</li>
																						<li
																							class="dropdown-item ps-3 fs-7 fw-medium">
																							Rejected</li>
																						<li
																							class="dropdown-item ps-3 fs-7 fw-medium">
																							For Verification</li>
																					</div>
																				</div>
																			</form>
																		</div>

																		<!-- Sort By -->
																		<div class="d-inline-block ps-3">
																			<form class="d-inline-block">
																				<div class="dropdown sort-by">
																					<button
																						class="sortby-tbn fs-7 spacing-6 fw-medium"
																						type="button" id="dropdownMenuButton"
																						data-bs-toggle="dropdown"
																						aria-haspopup="true"
																						aria-expanded="false">
																						<i
																							class="fa-solid fa-arrow-down-wide-short fa-sm"></i>
																						Sort by
																					</button>
																					<div class="dropdown-menu dropdown-menu-end"
																						aria-labelledby="dropdownMenuButton"
																						style="padding: 0.5rem">
																						<!-- Dropdown items -->
																						<li
																							class="dropdown-item ps-3 fs-7 fw-medium">
																							Newest to Oldest</li>
																						<li
																							class="dropdown-item ps-3 fs-7 fw-medium">
																							Oldest to Newest</li>
																						<li
																							class="dropdown-item ps-3 fs-7 fw-medium">
																							A to Z (Ascending)</li>
																						<li
																							class="dropdown-item ps-3 fs-7 fw-medium">
																							Z to A (Descending)</li>
																					</div>
																				</div>
																			</form>
																		</div>

																		<!-- Search -->
																		<div class="ps-3">
																			<i data-feather="search"
																				class="feather-xs im-cust-2"
																				style="color: black"></i>
																			<input class="search-input fs-7 spacing-6 fw-medium"
																				type="text" placeholder=" Search..."
																				id="searchInput" style="width: 100px">
																		</div>
																	</div>

																</div>
															</div>
														</div>

														<!-- Table Contents -->
														<table class=table table-striped table-hover">
															<thead class="tl-header">
																<tr>
																	<th
																		class="col-md-3 tl-left text-center fs-7 fw-bold spacing-5">
																		<i data-feather="mail"
																			class="feather-xs im-cust"></i>Email
																		Address
																	</th>

																	<th class="col-md-3 text-center fs-7 fw-bold spacing-5">
																		<i data-feather="check-circle"
																			class="feather-xs im-cust"></i>Status
																	</th>
																	<th
																		class="col-md-3 tl-right text-center fs-7 fw-bold spacing-5">
																		<i data-feather="calendar"
																			class="feather-xs im-cust"></i>Date Verified
																	</th>
																</tr>
															</thead>
															<tbody>
																<?php while ($row = $verified_tbl->fetch_assoc()) { ?>
																	<tr>
																		</td>
																		<td class="col-md-3 text-center"><a
																				href="voter-details.php?voter_id=<?php echo $row["voter_id"]; ?>"><?php echo $row["email"]; ?></a>
																		</td>
																		<td class="col-md-3 text-center">
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
																			<span
																				class="status-background <?php echo $statusClass; ?>"><?php echo $status; ?></span>
																		</td>

																		<td class="col-md-3 text-center">
																			<span
																				class=""><?php echo date("F j, Y", strtotime($row["status_updated"])); ?>
																		</td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>

														<!-- Pagination -->
														<div class="clearfix col-xs-12">
															<ul class="pagination">
																<li class="fas fa-chevron-left black"><a href="#"></a></li>
																<li class="page-item"><a href="#" class="page-link">1</a></li>
																<li class="page-item"><a href="#" class="page-link">2</a></li>
																<li class="page-item active"><a href="#" class="page-link">3</a>
																</li>
																<li class="page-item"><a href="#" class="page-link">4</a></li>
																<li class="page-item"><a href="#" class="page-link">5</a></li>
																<li class="fas fa-chevron-right ps-xl-3 black"><a href="#"></a>
																</li>
															</ul>
														</div>


														<!-- If verified table is empty, show empty state -->
													<?php } else { ?>

														<div class="table-title">
															<div class="row">
																<!-- HEADER -->
																<div class="col-sm-12">
																	<p class="fs-3 main-color fw-bold ls-10 spacing-6">Voters'
																		Account</p>
																</div>
															</div>
															<div class="col-md-12 no-registration text-center">
																<img src="images/resc/folder-empty.png" class="illus">
																<p class="fw-bold spacing-6 black">No accounts yet</p>
																<p class="spacing-3 pt-1 black fw-medium">Why not verify the
																	pending
																	registrations above?
																</p>
															</div>
														<?php } ?>
													</div>

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

				<script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
				<script src="scripts/script.js"></script>
				<script src="scripts/feather.js"></script>


	</body>


	</html>

	<?php
} else {
	header("Location: landing-page.php");
}
?>