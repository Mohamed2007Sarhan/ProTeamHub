<?php
// Include encryption header
// Include encryption header
include('header.php');

// Check if the decryption function exists (assuming you have an external shell or encryption method)
if (!function_exists('decryptData')) {
  die("Decryption function not found.");
}

// Check cookies before decryption
if (isset($_COOKIE['user_email'], $_COOKIE['user_name'], $_COOKIE['user_id'])) {
  $encryptedEmail = $_COOKIE['user_email'];
  $encryptedUsername = $_COOKIE['user_name'];
  $encryptedUserId = $_COOKIE['user_id'];

  // Decrypt user data using the external shell's decrypt function
  $userEmail = decryptData($encryptedEmail);
  $username = decryptData($encryptedUsername);
  $userId = decryptData($encryptedUserId);

  // Validate decryption result
  if (!$userEmail || !$username || !$userId) {
    die("Invalid session. Please login again.");
  }
} else {
  header("Refresh:0");  // Redirect to login if cookies are missing
  exit();
}

/**
 * Mask email for privacy
 *
 * @param string $email
 * @return string
 */
function maskEmail($email)
{
  $parts = explode('@', $email);
  $username = substr($parts[0], 0, 3) . '...';
  return $username . '@' . $parts[1];
}

// Include the database configuration
include('../../login/config.php');

// Verify database connection
if ($conx->connect_error) {
  die("Database connection failed: " . $conx->connect_error);
}

// Fetch user data
$sql = "SELECT * FROM register WHERE ID = ?";
$stmt = $conx->prepare($sql);

if (!$stmt) {
  die("Statement preparation failed: " . $conx->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $user_data = $result->fetch_assoc();
  $userImageUrl = !empty($user_data['profile_picture']) ? $user_data['profile_picture'] : 'img/default.png';
  $user_type = $user_data['user_type'];

  // Check if the image is the default and fetch the user's specific image if necessary
  if ($userImageUrl === 'img/default.png') {
    $userImageUrl = getUserImage($conx, $userId, $user_type);
  }

  // Mask the email for privacy
  $maskedEmail = maskEmail($userEmail);
} else {
  exit("User not found.");
}

$stmt->close();
$conx->close();

/**
 * Get the user image URL based on their user type
 *
 * @param mysqli $conx
 * @param int $userId
 * @param string $userType
 * @return string
 */
function getUserImage($conx, $userId, $userType)
{
  $defaultImage = 'img/default.png';
  $imagePath = '../../login/uploads/';

  // Define the tables for each user type
  $tables = [
    'organizer' => 'team_founders',
    'expert' => 'experts',
    'company' => 'companies',
    'member' => 'members'
  ];

  // Check if user type is valid
  if (!isset($tables[$userType])) {
    return $defaultImage;  // Return default image if user type is invalid
  }

  // Query the respective table for the user's image
  $sql = "SELECT img FROM {$tables[$userType]} WHERE user_id = ?";
  $stmt = $conx->prepare($sql);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    // Return the image if it exists
    return !empty($data['img']) ? $imagePath . $data['img'] : $defaultImage;
  }

  // Fallback if no image is found in the specific table
  return $defaultImage;  // Return default image if no image is found
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="app.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

  <nav id="sidebar">
    <ul>
      <li>
        <div style="display: flex; align-items: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin: 0; padding: 0;">
          <img src="<?= htmlspecialchars($userImageUrl); ?>" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px; border: 0;">
          <div style="margin: 0; padding: 0;">
            <p style="margin: 0; font-weight: bold;"><?= htmlspecialchars($username); ?></p>
            <p style="margin: 0; font-size: 0.9em; color: gray; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
              <?= htmlspecialchars(maskEmail($userEmail)); ?>
            </p>
          </div>
        </div>


      </li>


      <!-- <button onclick=toggleSidebar() id="toggle-btn">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z" />
        </svg>
      </button> -->

      </li>


      <!-- <button onclick=toggleSubMenu(this) class="dropdown-btn">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z" />
        </svg>
        <span>Todo-Lists</span>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
        </svg>
      </button>
      <ul class="sub-menu">
        <div>
          <li><a href="#">Work</a></li>
          <li><a href="#">Private</a></li>
          <li><a href="#">Coding</a></li>
          <li><a href="#">Gardening</a></li>
          <li><a href="#">School</a></li>
        </div>
      </ul>
      </li> -->



      <?php
      // نفترض أن المتغير $user_type يحتوي على نوع المستخدم الحالي
      // أمثلة على القيم المحتملة: 'member', 'organizer', 'company', 'expert'

      switch ($user_type) {
        case 'member': // للمستخدم العادي
          echo '<li>';
          echo '<li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i>  <span>Dashboard</span></a></li>';
          echo '<li><a href="search_teams.php"><i class="fas fa-search"></i>  <span>Search Teams</span></a></li>';
          echo '<li><a href="opportunities.php"><i class="fas fa-briefcase"></i> <span>Opportunities (Gigs)</span></a></li>';
          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-cogs"></i>
          <span>Chats</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Teams Chat</a></li>
            <li><a href="#">Privet Chats</a></li>
            
          </div>
        </ul>
          ';
          echo '<li><a href="notifications.php"><i class="fas fa-bell"></i> <span>Notifications</span></a></li>';
          echo '<li><a href="news.php"><i class="fas fa-newspaper"></i> <span>News</span></a></li>';
          echo '<li><a href="ai_tools.php"><i class="fas fa-robot"></i> <span>AI Tools</span></a></li>';
          echo '<li><a href="ask_expert.php"><i class="fas fa-question-circle"></i> <span>Ask an Expert</span></a></li>';
          echo '<li><a href="profile.php"><i class="fas fa-user"></i> <span>Profile</span></a></li>';
          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-cogs"></i>
          <span>Settings & Support</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Settings</a></li>
            <li><a href="support.php">Support</a></li>
            
          </div>
        </ul>
          ';
          echo '</li>';
          break;

        case 'organizer': // للمنظمين
          echo '<li>';
          echo '<li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i>  <span>Dashboard</span></a></li>';
          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-users-cog"></i>
          <span>Teams</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Manage Teams</a></li>
            <li><a href="#">Join Requests</a></li>
          </div>
        </ul>
          ';
          // echo '<li><a href="manage_teams.php"><i class="fas fa-users"></i>  <span>Manage Teams</span></a></li>';
          // echo '<li><a href="join_requests.php"><i class="fas fa-users-cog"></i>  <span>Join Requests</span></a></li>';
          echo '<li><a href="reports.php"><i class="fas fa-chart-line"></i> <span>Reports & Analytics</span></a></li>';
          echo '<li><a href="ai_task_automation.php"><i class="fas fa-cogs"></i> <span>AI Task Automation</span></a></li>';
          echo '<li><a href="opportunities.php"><i class="fas fa-briefcase"></i> <span>Opportunities (Gigs)</span></a></li>';
          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-cogs"></i>
          <span>Chats</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Teams Chat</a></li>
            <li><a href="#">Privet Chats</a></li>
            
          </div>
        </ul>
          ';
          echo '<li><a href="notifications.php"><i class="fas fa-bell"></i> <span>Notifications</span></a></li>';
          echo '<li><a href="news.php"><i class="fas fa-newspaper"></i> <span>News</span></a></li>';
          echo '<li><a href="ask_expert.php"><i class="fas fa-question-circle"></i> <span>Ask an Expert</span></a></li>';
          echo '<li><a href="profile.php"><i class="fas fa-user"></i> <span>Profile</span></a></li>';

          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-cogs"></i>
          <span>Settings & Support</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Settings</a></li>
            <li><a href="support.php">Support</a></li>
            
          </div>
        </ul>
          ';

          echo '</li>';
          break;

        case 'company': // للشركات
          echo '<li>';
          echo '<li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>';
          echo '<li><a href="manage_teams.php"><i class="fas fa-users"></i> <span>Manage Teams</span></a></li>';
          echo '<li><a href="join_requests.php"><i class="fas fa-users-cog"></i> <span>Join Requests</span></a></li>';
          echo '<li><a href="reports.php"><i class="fas fa-chart-line"></i> <span>Reports & Analytics</span></a></li>';
          echo '<li><a href="ai_insights.php"><i class="fas fa-brain"></i> <span>AI Insights</span></a></li>';
          echo '<li><a href="opportunities.php"><i class="fas fa-briefcase"></i> <span>Opportunities (Gigs)</span></a></li>';
          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-cogs"></i>
          <span>Chats</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Teams Chat</a></li>
            <li><a href="#">Privet Chats</a></li>
            
          </div>
        </ul>
          ';
          echo '<li><a href="notifications.php"><i class="fas fa-bell"></i> <span>Notifications</span></a></li>';
          echo '<li><a href="news.php"><i class="fas fa-newspaper"></i> <span>News</span></a></li>';
          echo '<li><a href="ask_expert.php"><i class="fas fa-question-circle"></i> <span>Ask an Expert</span></a></li>';
          echo '<li><a href="profile.php"><i class="fas fa-user"></i> <span>Profile</span></a></li>';
          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-cogs"></i>
          <span>Settings & Support</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Settings</a></li>
            <li><a href="support.php">Support</a></li>
            
          </div>
        </ul>
          ';
          echo '</li>';
          break;

        case 'expert': // للخبراء
          echo '<li>';
          echo '<li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>';
          echo '<li><a href="offers_opportunities.php"><i class="fas fa-gift"></i> <span>Offers & Opportunities</span></a></li>';
          echo '<li><a href="ai_tools.php"><i class="fas fa-robot"></i> <span>AI Tools</span></a></li>';
          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-cogs"></i>
          <span>Chats</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Teams Chat</a></li>
            <li><a href="#">Privet Chats</a></li>
            
          </div>
        </ul>
          ';
          echo '<li><a href="notifications.php"><i class="fas fa-bell"></i> <span>Notifications</span></a></li>';
          echo '<li><a href="news.php"><i class="fas fa-newspaper"></i> <span>News</span></a></li>';
          echo '<li><a href="ask_expert.php"><i class="fas fa-question-circle"></i> <span>Ask an Expert</span></a></li>';
          echo '<li><a href="profile.php"><i class="fas fa-user"></i> <span>Profile</span></a></li>';
          echo '
          <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <i class="fas fa-cogs"></i>
          <span>Settings & Support</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Settings</a></li>
            <li><a href="support.php">Support</a></li>
            
          </div>
        </ul>
          ';
          echo '</li>';
          break;

        default:
          echo '<p>Invalid user type.</p>';
          break;
      }
      ?>
    </ul>


  </nav>

  <main>
    <button id="theme-toggle" class="theme-btn">
      <i id="theme-icon" class="fa fa-sun"></i>
      <span id="theme-text">Light Mode</span>
    </button>
    <style>
  form {
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 350px;
    background-color: #ffffff;
    margin: auto;
  }

  form input[type="text"], 
  form input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
  }

  form input[type="text"] {
    background-color: #f9f9f9;
  }

  form input[type="submit"] {
    background-color: #007BFF;
    color: #ffffff;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  form input[type="submit"]:hover {
    background-color: #0056b3;
  }

  form h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-size: 18px;
  }

  .alert {
    text-align: center;
    font-weight: bold;
    padding: 10px;
    margin: 15px auto;
    border-radius: 5px;
    width: 350px;
  }

  .alert.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }

  .alert.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }
</style>

<center>
  <?php
  $support_value = isset($_GET["support"]) ? $_GET["support"] : "";
  $values_alert = "";
  $alert_class = "";

  if ($support_value == "good") {
    $values_alert = "😊 Thanks for your feedback!";
    $alert_class = "success";
  } elseif ($support_value == "bad") {
    $values_alert = "😞 Sorry to hear that!";
    $alert_class = "error";
  }
  ?>
  
  <?php if (!empty($values_alert)): ?>
  <div class="alert <?php echo $alert_class; ?>">
    <?php echo $values_alert; ?>
  </div>
  <?php endif; ?>

  <form action="config/support.php" method="post">
    <h2>Contact Support</h2>
    <input type="text" value="<?php echo isset($username) ? $username : ''; ?>" name="usernme" placeholder="Enter your username">
    <input type="text" value="<?php echo isset($userEmail) ? $userEmail : ''; ?>" name="useremail" placeholder="Enter your email">
    <input type="text" value="" name="massage" placeholder="Your Message">
    <input type="submit" value="Submit">
  </form>
</center>
  </main>
</body>

</html>