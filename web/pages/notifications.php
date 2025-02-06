<?php
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
    <title>Notifications</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="app.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
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
            @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap");

            /* :root {
                --bg-clr: #ef4d61;
                --white: #fff;
                --text-primary-clr: #282c36;
                --text-secondary-clr: #a9abaf;
                --first-clr: #007bc2;
                --second-clr: #f0a92e;
                --third-clr: #21a67a;
            } */
            :root {
                --bg-clr: #f4f4f9;
                --line-clr: #d1d6e0;
                --hover-clr: #e0e4f1;
                --text-clr: #11121a;
                --accent-clr: #5e63ff;
                --secondary-text-clr: #7a7f90;
            }

            /* وضع المظلم */
            :root[data-theme='dark'] {
                --bg-clr: #11121a;
                --line-clr: #42434a;
                --hover-clr: #222533;
                --text-clr: #e6e6ef;
                --accent-clr: #5e63ff;
                --secondary-text-clr: #b0b3c1;
            }

            /* وضع الإضاءة (Light Mode) عند التبديل يدوياً */
            body[data-theme='light'] {
                --bg-clr: #f4f4f9;
                --line-clr: #d1d6e0;
                --hover-clr: #e0e4f1;
                --text-clr: #11121a;
                --accent-clr: #5e63ff;
                --secondary-text-clr: #7a7f90;
            }

            /* وضع المظلم (Dark Mode) عند التبديل يدوياً */
            body[data-theme='dark'] {
                --bg-clr: #11121a;
                --line-clr: #42434a;
                --hover-clr: #222533;
                --text-clr: #e6e6ef;
                --accent-clr: #5e63ff;
                --secondary-text-clr: #b0b3c1;
            }


            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: "Open Sans", sans-serif;
            }

            body {
                font-size: 12px;
            }

            .wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 0 10px;
                color: var(--text-clr);
            }

            .alert_wrapper .alert_item {
                background: var(--white);
                margin-bottom: 25px;
                padding: 20px 25px;
                border-radius: 3px;
                display: flex;
                align-items: center;
                box-shadow: 0 0 2px rgba(0, 0, 0, 0.15);
            }

            .alert_wrapper .alert_item .text {
                padding: 0 20px;
                width: calc(100% - 80px);
            }

            .alert_wrapper .alert_item .text h3 {
                font-size: 16px;
                margin-bottom: 5px;
                color: var(--text-primary-clr);
            }

            .alert_wrapper .alert_item .text p {
                color: var(--text-secondary-clr);
            }

            .alert_wrapper .alert_item .icon,
            .alert_wrapper .alert_item .close {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 50px;
                height: 40px;
                border-radius: 50%;
            }

            .alert_wrapper .alert_item .icon ion-icon {
                color: var(--white);
                font-size: 20px;
            }

            .alert_wrapper .alert_item.first_item .icon {
                background: var(--first-clr);
            }

            .alert_wrapper .alert_item.second_item .icon {
                background: var(--second-clr);
            }

            .alert_wrapper .alert_item.third_item .icon {
                background: var(--third-clr);
            }

            .alert_wrapper .alert_item .close {
                font-size: 25px;
                color: var(--text-secondary-clr);
            }

            .alert_wrapper .alert_item .close ion-icon {
                cursor: pointer;
                transition: all 0.5s ease;
            }

            .alert_wrapper .alert_item.first_item .close ion-icon:hover {
                color: var(--first-clr);
            }

            .alert_wrapper .alert_item.second_item .close ion-icon:hover {
                color: var(--second-clr);
            }

            .alert_wrapper .alert_item.third_item .close ion-icon:hover {
                color: var(--third-clr);
            }

            /* CSS الأساسي للتنسيق */
            .wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                width: 100%;
                min-height: 100vh;
                /* يجعل الغلاف يغطي الارتفاع الكامل */
                padding: 10px;
            }

            .alert_wrapper {
                height: 170px;
                /* يجعل التنبيه يغطي العرض الكامل */
                max-width: 600px;
                /* يمكنك ضبط الحجم الأقصى إذا كنت ترغب في تحديد عرض معين */
                margin-bottom: 20px;
                /* مسافة بين التنبيهات */
                /* لون خلفية التنبيه */
                border-radius: 5px;
                padding: 15px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .alert_item {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .icon,
            .text,
            .close {
                flex: 1;
                padding: 10px;
            }

            .text {
                flex: 3;
                text-align: left;
            }

            @media (max-width: 768px) {
                .alert_wrapper {
                    width: 100vw;
                    /* يأخذ العرض الكامل للشاشة في الأجهزة الصغيرة */
                    padding: 20px;
                }
            }
        </style>
        <?php
        // جلب الحالة من قاعدة البيانات
        $sql001 = "SELECT * FROM notviation WHERE user_id = ?";
        $stmt001 = $conx->prepare($sql001);
        $stmt001->bind_param("i", $userId);
        $stmt001->execute();
        $result001 = $stmt001->get_result();

        // التحقق من وجود البيانات
        if ($result001->num_rows > 0) {
            echo '<div class="wrapper">'; // فتح عنصر الغلاف مرة واحدة فقط
            while ($row = $result001->fetch_assoc()) { // التكرار على جميع النتائج
                $id = $row['id'];
                $active = $row['active'];
                $text = $row['text']; // قد يحتوي على روابط HTML
                $Description = $row['Description']; // قد يحتوي على روابط HTML
                $img = $row['img']; // يحتوي على كود HTML
                $img_nov = $row['img_not']; // يحتوي على كود HTML
                // تحقق إذا كانت الحالة "active" تساوي 1
                if ($active == 1) {
                    echo '<div class="alert_wrapper" data-id="' . $id . '">'; // غلاف لكل عنصر تنبيه
                    echo '    <div class="alert_item third_item">';
                    echo '        ' . $img; // إدراج كود HTML المخزن كما هو
                    echo '        <div class="text">';
                    echo '            <h3>' . $text . '</h3>'; // عرض النص مع روابط HTML
                    echo '            <p>' . $Description . '</p>'; // عرض الوصف مع روابط HTML
                    echo '        </div>';
                    echo '        <div class="close">';
                    echo '            <ion-icon name="close" onclick="closeNotification(' . $id . ')"></ion-icon>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
            }
            echo '</div>'; // غلق عنصر الغلاف
        } else {
            echo "No notifications found.";
        }
        ?>


        <script>
            function closeNotification(id) {
                // إنشاء طلب AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_notification.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // إزالة التنبيه من الصفحة بعد تحديثه بنجاح
                        var element = document.querySelector('.alert_wrapper[data-id="' + id + '"]');
                        if (element) {
                            element.style.display = 'none';
                        }
                    }
                };
                xhr.send("id=" + id);
            }
        </script>





        <!-- <div class="wrapper">
            <div class="alert_wrapper"> -->
        <!-- <div class="alert_item first_item">
                    <div class="icon">
                        <ion-icon name="information"></ion-icon>
                    </div>
                    <div class="text">
                        <h3>Check your input.</h3>
                        <p>Please keep in mind to check your information before sending your request out.</p>
                    </div>
                    <div class="close">
                        <ion-icon name="close"></ion-icon>
                    </div>
                </div> -->
        <!-- <div class="alert_item second_item">
                    <div class="icon">
                        <ion-icon name="alert"></ion-icon>
                    </div>
                    <div class="text">
                        <h3>Yikes. Something went wrong.</h3>
                        <p>We're sorry that you have to experience some problems! Please try again later.</p>
                    </div>
                    <div class="close">
                        <ion-icon name="close"></ion-icon>
                    </div>
                </div> -->
        <!-- <div class="alert_item third_item">
                    <div class="icon">
                        <ion-icon name="checkmark"></ion-icon>
                    </div>
                    <div class="text">
                        <h3>Great success!</h3>
                        <p>Your settings have been updated.</p>
                    </div>
                    <div class="close">
                        <ion-icon name="close"></ion-icon>
                    </div>
                </div> -->
        <!-- </div>
        </div> -->

    </main>
    </main>
</body>

</html>