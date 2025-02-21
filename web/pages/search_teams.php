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
    <link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Teams - Privet & Public Groups | ProTeamHub</title>
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
                    echo '<li class="active"><a href="index.php"><i class="fas fa-tachometer-alt"></i>  <span>Dashboard</span></a></li>';
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
                    echo '<li class="active"><a href="index.php"><i class="fas fa-tachometer-alt"></i>  <span>Dashboard</span></a></li>';
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
                    echo '<li class="active"><a href="index.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>';
                    echo '<li><a href="manage_teams.php"><i class="fas fa-users"></i> <span>Manage Teams</span></a></li>';
                    echo '<li><a href="join_requests.php"><i class="fas fa-users-cog"></i> <span>Join Requests</span></a></li>';
                    echo '<li><a href="reports.php"><i class="fas fa-chart-line"></i> <span>Reports & Analytics</span></a></li>';

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
                    echo '<li class="active"><a href="index.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>';
                    echo '<li><a href="offers_opportunities.php"><i class="fas fa-gift"></i> <span>Offers & Opportunities</span></a></li>';

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
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Rooms List</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <style>
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



                body {
                    background-color: var(--bg-clr);
                }

                .card {
                    background: rgba(255, 255, 255, 0.2);
                    /* Transparent background */
                    backdrop-filter: blur(10px);
                    /* Blur effect */
                    -webkit-backdrop-filter: blur(10px);
                    border-radius: 15px;
                    border: 1px solid rgba(255, 255, 255, 0.3);
                    /* Light border */
                    transition: 0.3s ease-in-out;
                }

                .card:hover {
                    transform: scale(1.05);
                    box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.2);
                }

                .join-btn {
                    background-color: rgba(0, 123, 255, 0.8);
                    color: white;
                    border-radius: 10px;
                }

                .join-btn:hover {
                    background-color: rgba(0, 86, 179, 0.9);
                }
            </style>
        </head>

        <body>
            <div class="container my-4" style="border: none;">
                <h1 class="text-center text-light mb-4">🏠 Public Teams</h1>
                <div class="search-box position-relative">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text" id="roomSearch" class="form-control" placeholder="Search rooms...">
                    <label for="roomSearch" class="search-label">🔍 Search Teams</label>
                </div>
            </div>

            <style>
                .search-box {
                    position: relative;
                    max-width: 400px;
                    margin: 0 auto 20px;
                }

                .search-icon {
                    position: absolute;
                    left: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: var(--secondary-text-clr);
                }

                .form-control {
                    padding-left: 35px;
                    border-radius: 20px;
                    border: 1px solid var(--line-clr);
                    background: var(--bg-clr);
                    color: var(--text-clr);
                    transition: 0.3s;
                }

                .form-control:focus {
                    border-color: var(--accent-clr);
                    box-shadow: 0 0 10px rgba(94, 99, 255, 0.3);
                }

                .search-label {
                    position: absolute;
                    left: 40px;
                    top: 50%;
                    transform: translateY(-50%);
                    font-size: 14px;
                    color: var(--secondary-text-clr);
                    transition: 0.3s;
                    pointer-events: none;
                }

                .form-control:focus+.search-label,
                .form-control:not(:placeholder-shown)+.search-label {
                    top: 10px;
                    font-size: 12px;
                    color: var(--accent-clr);
                }
            </style>

            <script>
                document.getElementById("roomSearch").addEventListener("input", function() {
                    let filter = this.value.toLowerCase();
                    let rooms = document.querySelectorAll(".card");

                    rooms.forEach(room => {
                        let roomName = room.querySelector(".card-title").innerText.toLowerCase();
                        if (roomName.includes(filter)) {
                            room.parentElement.style.display = "block";
                        } else {
                            room.parentElement.style.display = "none";
                        }
                    });
                });
            </script>

            <div class="container my-5" style="border: none; max-width: none;">
                <h2 class="text-center text-light mb-4">✅ Available Teams</h2>
                <div class="row">
                    <?php
                    // Server credentials
                    $server_url = "http://localhost:9000";
                    $client_url = "http://localhost:8080";
                    $access_token = "syt_bW9oYW1lZA_lbeDVZwOVYUExuBIPcwm_2zNKbv";

                    // Fetch rooms
                    $url = "$server_url/_synapse/admin/v1/rooms";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Authorization: Bearer $access_token"
                    ]);
                    $response = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    $data = json_decode($response, true);

                    if ($http_code == 200 && isset($data['rooms'])) {
                        foreach ($data['rooms'] as $room) {
                            $room_id = htmlspecialchars($room['room_id']);
                            $room_name = htmlspecialchars($room['name'] ?? "No Name");
                            $room_alias = htmlspecialchars($room['canonical_alias'] ?? "#$room_id:localhost");
                            $creator = htmlspecialchars($room['creator'] ?? "Unknown");

                            // Fetch members count
                            $room_details_url = "$server_url/_matrix/client/v3/rooms/$room_id/state/m.room.member";
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $room_details_url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                "Authorization: Bearer $access_token"
                            ]);
                            $room_details_response = curl_exec($ch);
                            curl_close($ch);
                            $room_details = json_decode($room_details_response, true);
                            $member_count = is_array($room_details) ? count($room_details) : "❌ Not Available";

                            // Join link
                            $join_link = "$client_url/#/room/$room_alias";
                    ?>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm p-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">🔹 <?php echo $room_name; ?></h5>
                                        <p class="card-text">
                                            <strong>🆔 ID:</strong> <?php echo $room_alias; ?><br>
                                            <strong>👤 Created by:</strong> <?php echo $creator; ?><br>
                                            <strong>👥 Members:</strong> <?php echo $member_count; ?>
                                        </p>
                                        <a href="<?php echo $join_link; ?>" class="btn join-btn w-100" target="_blank">
                                            🚀 Join Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<h2 class='text-danger text-center'>❌ Failed to fetch data! </h2>";
                        echo "<p class='text-center'><strong>Response Code:</strong> $http_code</p>";
                    }
                    ?>
                </div>
            </div>
        </body>

        </html>



        <script>
            (function() {
                if (!window.chatbase || window.chatbase("getState") !== "initialized") {
                    window.chatbase = (...arguments) => {
                        if (!window.chatbase.q) {
                            window.chatbase.q = []
                        }
                        window.chatbase.q.push(arguments)
                    };
                    window.chatbase = new Proxy(window.chatbase, {
                        get(target, prop) {
                            if (prop === "q") {
                                return target.q
                            }
                            return (...args) => target(prop, ...args)
                        }
                    })
                }
                const onLoad = function() {
                    const script = document.createElement("script");
                    script.src = "https://www.chatbase.co/embed.min.js";
                    script.id = "MgsacowUVEfErnjwaOmBS";
                    script.domain = "www.chatbase.co";
                    document.body.appendChild(script)
                };
                if (document.readyState === "complete") {
                    onLoad()
                } else {
                    window.addEventListener("load", onLoad)
                }
            })();
        </script>





    </main>
</body>

</html>