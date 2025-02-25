<?php
require_once 'includes/classes/db-connector.php';
require_once 'includes/session-handler.php';
require_once 'includes/classes/session-manager.php';
class Application {
    private $db;

    public function __construct(DatabaseConnection $db) {
        $this->db = $db;
    }
    public function getCandidateCount() {
        $connection = $this->db->connect();

        // Fetch count of candidates from the candidate table
        $candidateCountQuery = "SELECT COUNT(*) AS candidate_count FROM candidate";
        $result = $connection->query($candidateCountQuery);
        $candidateCount = $result->fetch_assoc()['candidate_count'];

        return $candidateCount;
    }
    public function getPositions() {
        $connection = $this->db->connect();

        $positionsQuery = "SELECT DISTINCT title FROM position";
        $result = $connection->query($positionsQuery);
        $positions = array();

        // Process the fetched rows into an array of positions
        while ($row = $result->fetch_assoc()) {
            $positions[] = $row['title'];
        }

        return $positions;
    }

    public function getFirstPosition() {
        $connection = $this->db->connect();

        $firstPositionQuery = "SELECT DISTINCT title FROM position LIMIT 1";
        $result = $connection->query($firstPositionQuery);
        $firstPosition = $result->num_rows > 0 ? $result->fetch_assoc()['title'] : "No positions available";
        return $firstPosition;
    }
    public function getVoterCounts() {
        $connection = $this->db->connect();
    
        // Fetch total count of voters
        $totalVotersQuery = "SELECT COUNT(*) AS total_count FROM voter";
        $totalVotersResult = $connection->query($totalVotersQuery);
        $totalVotersCount = $totalVotersResult->fetch_assoc()['total_count'];
    
        // Fetch count of voters with voteStatus as 'voted'
        $votedVotersQuery = "SELECT COUNT(*) AS voted_count FROM voter WHERE vote_status = 'Voted'";
        $votedVotersResult = $connection->query($votedVotersQuery);
        $votedVotersCount = $votedVotersResult->fetch_assoc()['voted_count'];
        
        $abstainedVotersQuery = "SELECT COUNT(*) AS abstained_count FROM voter WHERE vote_status = 'Abstained'";
        $abstainedVotersResult = $connection->query($abstainedVotersQuery);
        $abstainedVotersCount = $abstainedVotersResult->fetch_assoc()['abstained_count'];
    
        // Calculate percentages
        $totalPercentage = ($totalVotersCount > 0) ? (($votedVotersCount / $totalVotersCount) * 100) : 0;
        $votedPercentage = 100 - $totalPercentage;
    
        // Return the counts and percentages as an array
        return [
            'totalVotersCount' => $totalVotersCount,
            'votedVotersCount' => $votedVotersCount,
            'abstainedVotersCount' => $abstainedVotersCount,
            'totalPercentage' => $totalPercentage,
            'votedPercentage' => $votedPercentage,
        ];
    }
    public function getYearLevelCounts() {
        $connection = $this->db->connect();

        $yearLevelQuery = "SELECT year_level, COUNT(*) AS count FROM voter GROUP BY year_level";
        $result = $connection->query($yearLevelQuery);
        $yearLevelCounts = array();

        // Process the fetched rows and assign counts to corresponding variables
        while ($row = $result->fetch_assoc()) {
            $yearLevel = intval($row['year_level']); // Convert year level to integer
            switch ($yearLevel) {
                case 1:
                    $yearLevelCounts['firstYearCount'] = $row['count'];
                    break;
                case 2:
                    $yearLevelCounts['secondYearCount'] = $row['count'];
                    break;
                case 3:
                    $yearLevelCounts['thirdYearCount'] = $row['count'];
                    break;
                case 4:
                    $yearLevelCounts['fourthYearCount'] = $row['count'];
                    break;
                default:
                    // Handle any other cases if needed
                    break;
            }
            
        }

        return $yearLevelCounts;
    }
}

// Create an instance of DatabaseConnection
$dbConnection = new DatabaseConnection();

// Create an instance of Application
$app = new Application($dbConnection);

if (isset($_SESSION['voter_id']) && $_SESSION['role'] == 'Committee Member') {
    $org_name = $_SESSION['organization'] ?? '';

    include 'includes/organization-list.php';
    include 'includes/session-exchange.php';
    $org_full_name = $org_full_names[$org_name];

    // Fetch positions and year level counts using Application methods
    $positions = $app->getPositions();
    $firstPosition = $app->getFirstPosition();
    $yearLevelCounts = $app->getYearLevelCounts();
    $voterCounts = $app->getVoterCounts();
    $totalVotersCount = $voterCounts['totalVotersCount'];
    $votedVotersCount = $voterCounts['votedVotersCount'];
    $abstainedVotersCount = $voterCounts['abstainedVotersCount'];
    $totalPercentage = number_format($voterCounts['totalPercentage'], 2);
    $votedPercentage = number_format($voterCounts['votedPercentage'], 2);
    $candidateCount = $app->getCandidateCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/admin_dashboard.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/core.css">
    <link rel="stylesheet" href="styles/manage-acc.css" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/screenfull.js/5.1.0/screenfull.min.js"></script>

    
    <link rel="stylesheet" href="<?php echo 'styles/orgs/' . $org_name . '.css'; ?>" id="org-style">
    <style>
        <?php
    

        // Output the CSS with the organization color variable for background-color
        echo ".main-bg-color { background-color: var(--$org_name); }";

        // Output the CSS for the line with the dynamic color
        echo ".line { border-bottom: 2px solid var(--$org_name); width: 100%; }";
        ?>
    .full-screen{
        background-color: #f5f5f5;
    }
    .full-screen-content.centered{
     
        margin-top: 20vh !important;
   
   
    }

  
    </style>
</head>

<body>
<?php  include_once __DIR__ . '/includes/components/sidebar.php'; ?>

    <main class="main">

        <div class="container px-md-3 px-lg-5 px-sm-2 p-4 ">

            <div id="button-container">
        <!-- Button will be appended here -->
    </div>

            <div class="full-screen justify-content-center align-items-center d-block">
            <button id="reset-button" class="d-none">Hide Candidates</button>
                <div class="full-screen-content">
            <div class="live-results-container">
            <div class="row justify-content-center">
                
                        <div class="col-sm-12 col-md-6">
                    <h4 class="main-color main-text ms-3">LIVE RESULTS</h4>
                    </div>
                    
                    <div class="col-sm-12 col-md-6 text-end ">
                    <select id="positions" class="positions-dropdown main-bg-color mb-2 mt-2">
    <?php
    // Loop through positions array to generate options
    foreach ($positions as $position) {
        echo "<option value=\"$position\">$position</option>";
    }
    ?>
</select>
                    </div>
                    </div>
              
            </div>
         
         
                
                <div class="card">
                <div class="icon-container pt-2 pe-2 text-end">
                    <a id="fullscreen-button">
                                <i data-feather="maximize" class="main-color"></i>
                            </a>
</div>
    <div class="chart-container pb-3">
        <canvas id="myChart"></canvas>
    </div>
</div>
</div>

           
            </div>
            <div class="row ">
                <h4 class="main-text main-color mt-3 ms-3">METRICS</h4>
                    </div>
                <div class="row m-0 p-0 justify-content-between">
               <div class= "col-md-7 m-0  ps-0 pe-md-5 pe-md-0 pe-sm-0 pe-0">
                <div class="card p-3 ">
                    <div class="card-body pr-5">
                <div class="row justify-content-center">
                <div class="col-md-12 col-lg-6">
                <canvas id="chartProgress" width="300" height="200"></canvas>

                </div>
                
                
                <div class="col-md-12 col-lg-6 justify-content-center align-self-center">
                    
                  
                 
                        <div class="col-md-12 metrics-header justify-content-center align-items-center d-flex d-sm-flex d-md-block mt-3 ">
                       <span class="text-center ps-4"> Total Count of Voters </span>
                        </div>
                        <div class="col-md-12 metrics-content justify-content-center  align-items-center  main-color d-flex d-sm-flex d-md-block mb-3">
                        <span class="text-center ps-4"> <b><?php echo $votedVotersCount; ?> out of <?php echo $totalVotersCount; ?></b>
    </span></span>
                        </div>
                        
                       
                  
                    
               
                     
                        <div class="col-md-12 metrics-header justify-content-center  align-items-center  d-flex d-sm-flex d-md-block ">
                        <span class="text-center ps-4"> Abstained</span>
                        </div>
                        <div class="col-md-12 metrics-content justify-content-center  align-items-center  main-color d-flex d-sm-flex d-md-block">
                        <span class="text-center ps-4"> <b>  <?php echo $abstainedVotersCount; ?> students</b></span>
                        </div>
                        </div>
                   
                </div>
                </div>
                </div>
                </div>
                
                 <div class="col-md-5 col-lg-5 justify-content-between d-flex flex-direct px-0">
                  
                 <div class="card p-3 mt-3 mt-md-0">
                 <div class="card-body d-flex d-md-block align-items-center justify-content-center p-3">

            
                <div class="row ">
                    <div class="col-md-9">
                    <div class="col-md-12 d-flex d-md-block justify-content-center">
                         <span class="secondary-metrics-header main-color">   Total count of </span>
                        </div>
                        <div class="col-md-12 d-flex d-md-block justify-content-center">
                        <span class="secondary-metrics-content ">   VOTER ACCOUNTS </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="col-md-12 d-flex d-md-block justify-content-center">
                    <div class="circle main-bg-color">
                    <span class="secondary-metrics-number"><?php echo $totalVotersCount; ?></span>
</div> </div>
                    </div>
                </div>     
            </div>
            </div>
            <div class="card p-3 mt-3 mt-md-0">
                <div class="card-body d-flex d-md-block align-items-center justify-content-center p-3">

            
                <div class="row">
                    <div class="col-md-9 justify-content-center d-flex d-md-block flex-direct">
                        <div class="col-md-12 d-flex d-md-block justify-content-center">
                        <span class="secondary-metrics-header main-color">   Total count of </span>
                        </div>
                        <div class="col-md-12 d-flex d-md-block justify-content-center">
                        <span class="secondary-metrics-content py-1">   CANDIDATES </span>
                        </div>
                    </div>
                    <div class="col-md-3 justify-content-center d-flex d-md-block flex-direct">
                    <div class="col-md-12 d-flex d-md-block justify-content-center">
                    <div class="circle main-bg-color">
                    <span class="secondary-metrics-number"><?php echo $candidateCount; ?></span>
</div>                  
</div>      
  </div>
                </div>     
            </div>
            </div>
            </div>    
            </div>   
            <div class="row ">
                <h4 class="main-text main-color mt-3 ms-3">NAVIGATE</h4>
                    </div>
            <div class="row justify-content-start d-flex m-0 p-0">
    <div class="col-lg-4 ml-5 py-4 ps-0 pe-1 ">
        <div class="col-lg-11">
            <a href="result-generation.php" class="card admin-card admin-link px-5 pt-4 pb-5">
                <div class="card-body d-flex align-items-center justify-content-center p-2">
                    <div class="icon-container">
                        <img src="images/resc/Dashboard/Reports/<?php echo $org_name . '-reports.png'; ?>" alt="Reports Image" class="navigate-images">
                    </div>
                </div>
                <div class="row">
                    <span class="vw-1 m-0 fw-bold mt-1 text-center">Reports</span>
                </div>
                <div class="row p">
                    <span class="vw-1 m-0 mt-1 text-center navigate-text">Generate reports for year’s election results</span>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4 ml-5 py-4 ps-0 pe-1 d-lg-flex d-md-block justify-content-center ">
        <div class="col-lg-11">
            <a href="manage-acc.php" class="card admin-card admin-link px-5 pt-4 pb-5">
                <div class="card-body d-flex align-items-center justify-content-center p-2">
                    <div class="icon-container">
                        <img src="images/resc/Dashboard/Manage Acc/<?php echo $org_name . '-manage-accs.png'; ?>" alt="Reports Image" class="navigate-images">
                    </div>
                </div>
                <div class="row">
                    <span class="vw-1 m-0 fw-bold mt-1 text-center">Manage Accounts</span>
                </div>
                <div class="row">
                    <span class="vw-1 m-0 mt-1 text-center navigate-text">Create, modify, or delete user accounts</span>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4 ml-5 py-4 ps-0 pe-0 d-lg-flex d-md-block justify-content-end ">
        <div class="col-lg-11">
            <a href="configuration.php" class="card admin-card admin-link px-5 pt-4 pb-5">
                <div class="card-body d-flex align-items-center justify-content-center p-2">
                    <div class="icon-container">
                        <img src="images/resc/Dashboard/Configuration/<?php echo $org_name . '-config.png'; ?>" alt="Reports Image" class="navigate-images">
                    </div>
                </div>
                <div class="row">
                    <span class="vw-1 m-0 fw-bold mt-1 text-center">Configuration</span>
                </div>
                <div class="row">
                    <span class="vw-1 m-0 mt-1 text-center navigate-text">Set your organization’s voting preferences</span>
                </div>
            </a>
        </div>
    </div>
</div>


    </main>
  
    <?php include_once __DIR__ . '/includes/components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/script.js"></script>
    <script src="scripts/admin_dashboard.js"></script>
    <script>
        feather.replace();
    </script>

<script>
    fetchCandidates('<?php echo $firstPosition; ?>');

   
    </script>

<script>// Function to create gradient
// Function to create gradient
const COMPUTED_STYLE = getComputedStyle(document.querySelector('.main-bg-color'));
const COMPUTED_COLORS = COMPUTED_STYLE.backgroundColor;

// Function to create gradient
function createGradient(ctx, chartArea, color) {
    const GRADIENT = ctx.createLinearGradient(0, 0, chartArea.width, 0);
    GRADIENT.addColorStop(0,'#FFFFFF');
    GRADIENT.addColorStop(1, color);
    return GRADIENT;
}

var myChartCircle = new Chart('chartProgress', {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [<?php echo $totalPercentage; ?>, <?php echo $votedPercentage; ?>],
            backgroundColor: function(context) {
                const CHART = context.chart;
                const { ctx, chartArea } = CHART;
                if (!chartArea) {
                    // This can happen if the chart is not yet initialized
                    return null;
                }
                return [
                    createGradient(ctx, chartArea, COMPUTED_COLORS),
                    '#E5E5E5' // Default color for remaining percentage
                ];
            },
            borderWidth: 0
        }]
    },
    options: {
        maintainAspectRatio: false,
        cutout: 75,
        cutoutPercentage: 75, // Adjust the size of the circle
        rotation: Math.PI / 2,
        legend: {
            display: false
        },
        tooltips: {
            enabled: false
        }
    },
    plugins: [{
        beforeInit: (CHART) => {
            const DATASET = CHART.data.datasets[0];
            DATASET.data = [DATASET.data[0], 100 - DATASET.data[0]]; // Calculate remaining percentage
        }
    },
    {
        beforeDraw: (CHART) => {
            var width = CHART.width,
                height = CHART.height,
                ctx = CHART.ctx;
            ctx.restore();
            var fontSize = (height / 150).toFixed(2);
            ctx.font = "bold " + fontSize + "em Montserrat, sans-serif"; // Bold and Montserrat
            ctx.fillStyle = "black";
            ctx.textBaseline = "middle";
            var text = CHART.data.datasets[0].data[0] + "%",
                textX = Math.round((width - ctx.measureText(text).width) / 2),
                textY = height / 1.75;
            ctx.fillText(text, textX, textY);

            // Adding 'Completed' text
            var completedFontSize = (height / 300).toFixed(2); // Smaller font size
            ctx.font = "bold " + completedFontSize + "em Montserrat";
            var completedText = "Completed",
                completedTextX = Math.round((width - ctx.measureText(completedText).width) / 2),
                completedTextY = textY - 30; // Position above the percentage text
            ctx.fillText(completedText, completedTextX, completedTextY);
            ctx.save();
        }
    }]
});



    </script>

</body>

</html>
<?php
} else {
  header("Location: voter-login.php");
}
?>
