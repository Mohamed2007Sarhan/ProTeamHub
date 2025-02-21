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
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>News | ProTeamHub</title>
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


<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="MgsacowUVEfErnjwaOmBS";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
    <style src="style.css">
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
      }

      :root {
        --base-clr: #f4f4f9;
        --line-clr: #d1d6e0;
        --hover-clr: #e0e4f1;
        --text-clr: #11121a;
        --accent-clr: #5e63ff;
        --secondary-text-clr: #7a7f90;
      }

      /* وضع المظلم */
      :root[data-theme='dark'] {
        --base-clr: #11121a;
        --line-clr: #42434a;
        --hover-clr: #222533;
        --text-clr: #e6e6ef;
        --accent-clr: #5e63ff;
        --secondary-text-clr: #b0b3c1;

      }

      /* وضع الإضاءة (Light Mode) عند التبديل يدوياً */
      body[data-theme='light'] {
        --base-clr: #f4f4f9;
        --line-clr: #d1d6e0;
        --hover-clr: #e0e4f1;
        --text-clr: #11121a;
        --accent-clr: #5e63ff;
        --secondary-text-clr: #7a7f90;
        --x-clr: #000;

      }

      /* وضع المظلم (Dark Mode) عند التبديل يدوياً */
      body[data-theme='dark'] {
        --base-clr: #11121a;
        --line-clr: #42434a;
        --hover-clr: #222533;
        --text-clr: #e6e6ef;
        --accent-clr: #5e63ff;
        --secondary-text-clr: #b0b3c1;
        --x-clr: #fff;
      }

      .form-container {
        max-width: 800px;
        margin: 20px auto;
        background: white;
        padding: 15px;
        border-radius: 8px;
        background: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }

      .user-info {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
      }

      .user-info img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
      }

      .user-info p {
        font-size: 16px;
        font-weight: bold;
        margin: 0;
      }

      .form-container textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: none;
      }

      .custom-file-upload {
        display: inline-flex;
        align-items: center;
        padding: 10px;
        color: #000;
        text-align: center;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      .custom-file-upload:hover {
        background-color: #000;
        color: #fff;
      }

      .custom-file-upload i {
        margin-right: 8px;
      }

      .form-container input[type="file"] {
        display: none;
      }

      .form-container input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #1877f2;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      .form-container input[type="submit"]:hover {
        background-color: #155bc1;
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



















      .post {
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);


        max-width: 800px;
        overflow: hidden;
      }

      .post-header {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #e4e6eb;
      }

      .profile-pic {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
      }

      .user-info h4 {
        margin: 0;
        font-size: 16px;
        font-weight: bold;

      }

      .user-info p {
        margin: 0;
        color: gray;
        font-size: 12px;
        display: flex;
        align-items: center;
      }

      .user-info p .privacy-icon {
        width: 12px;
        height: 12px;
        background: url('privacy-icon.png') no-repeat center;
        background-size: cover;
        margin-left: 5px;
      }

      .post-content {
        padding: 15px;

      }

      .post-image img {
        width: 100%;
        display: block;
      }

      .post-footer {
        display: flex;
        justify-content: space-around;
        padding: 10px;
        border-top: 1px solid #e4e6eb;
      }



      .post-footer button {
        background: var(--base-clr);
        color: var(--x-clr);
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
      }

      .post-footer button:hover {
        background-color: var(--hover-clr);
        /* استبدل 'yourcolor#' بلون الخلفية المطلوب */
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
        /* هذا يضيف اللاغوشة الخفيفة */
      }
















      /* نمط 1: نص داخل اقتباس */
      .quote-style {
        font-style: italic;
        color: #34a853;
        background: rgba(52, 168, 83, 0.1);
        padding: 0 5px;
        border-left: 4px solid #34a853;
      }

      /* نمط 2: كود مع تأثير مميز */
      .code-style {
        font-family: 'Fira Code', monospace;
        background-color: #e0f7fa;
        color: #00796b;
        padding: 4px 6px;
        border-radius: 5px;
        border: 1px dashed #00796b;
        box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
      }

      /* نمط 3: نص مع توهج داخلي */
      .glow-style {
        color: #ff5722;
        background: rgba(255, 87, 34, 0.1);
        padding: 2px 4px;
        border-radius: 3px;
        text-shadow: 0 0 8px rgba(255, 87, 34, 0.8);
      }

      /* نمط 4: نص ثلاثي الأبعاد متدرج */
      .three-d-style {
        color: #1e88e5;
        text-shadow: 2px 2px 5px #90caf9, -2px -2px 5px #0d47a1;
        font-weight: bold;
      }

      /* نمط 5: نص مع خط فوقه وألوان خفيفة */
      .overline-style {
        text-decoration: overline;
        color: #d81b60;
        font-weight: bold;
      }

      /* نمط 6: نص بحروف متباعدة وظلال ناعمة */
      .spaced-style {
        letter-spacing: 3px;
        color: #8e24aa;
        text-shadow: 1px 1px 3px rgba(142, 36, 170, 0.5);
      }

      /* نمط 7: نص يتحرك برفق */
      .wiggle-style {
        display: inline-block;
        animation: wiggle 1s infinite;
      }

      @keyframes wiggle {

        0%,
        100% {
          transform: rotate(-1deg);
        }

        50% {
          transform: rotate(1deg);
        }
      }

      /* نمط 8: نص بظل مزدوج مع ألوان داكنة */
      .double-shadow-style {
        color: #ff9800;
        text-shadow: 3px 3px 0 #ff5722, -3px -3px 0 #ffccbc;
      }

      /* نمط 9: نص بخط اليد مع تأثير ورقي */
      .handwriting-style {
        font-family: 'Dancing Script', cursive;
        padding: 4px;
        border-radius: 8px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
      }

      /* نمط 10: نص متدرج متحرك */
      /* ...existing code... */
      .gradient-style {
        background: linear-gradient(90deg, #ff6f00, #d32f2f, #7b1fa2);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradientMove 3s ease infinite;
      }

      /* ...existing code... */
      @keyframes gradientMove {
        0% {
          background-position: 0% 50%;
        }

        100% {
          background-position: 100% 50%;
        }
      }













      #text-content {
        color: var(--x-clr);
        text-align: left;
      }
    </style>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('postImage');
        const fileLabel = document.querySelector('.custom-file-upload');

        fileInput.addEventListener('change', () => {
          const fileName = fileInput.files[0]?.name || 'Choose an Image';
          fileLabel.innerHTML = `<i class='fas fa-image'></i> ${fileName}`;
        });
      });
    </script>
    <?php
    $support_value = isset($_GET["news"]) ? $_GET["news"] : "";
    $values_alert = "";
    $alert_class = "";

    if ($support_value == "good") {
      $values_alert = "😊 Thanks for Add News 😲!";
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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <div class="form-container">
      <form action="config/news.php" method="POST" enctype="multipart/form-data">
        <div class="user-info">
          <img src="<?= htmlspecialchars($userImageUrl); ?>" alt="User Image">
          <p><?= htmlspecialchars($username); ?></p>
        </div>
        <textarea name="postContent" rows="4" placeholder="What's on your mind?"></textarea>
        <label for="postImage" class="custom-file-upload"><i class="fas fa-image"></i> Choose an Image</label>
        <input type="file" id="postImage" name="postImage" accept="image/*">
        <input type="submit" value="Post">
      </form>
    </div>



    <center>

      <?php
      include('../../login/config.php');
      $sql = "SELECT * FROM news"; // يمكن تعديل هذا حسب حاجتك
      $result = $conx->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $userId = $row['user_id'];
          $idnews = $row['id'];

          // جلب عدد الإعجابات
          $likeCountSql = "SELECT COUNT(*) AS likeCount FROM likes WHERE idpost = $idnews";
          $likeCountResult = $conx->query($likeCountSql);
          $likeCountRow = $likeCountResult->fetch_assoc();
          $likeCount = $likeCountRow['likeCount'];

          $sql1 = "SELECT profile_picture FROM register WHERE ID = $userId";
          $result1 = $conx->query($sql1);

          $userimg = '';
          if ($result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();
            $userimg = $row1['profile_picture'];
          }

          echo '<div class="post">';
          echo '  <div class="post-header">';
          echo '    <img src="' . $userimg . '" alt="Profile Picture" class="profile-pic">';
          echo '    <div class="user-info">';
          echo '      <h4>' . $row['username'] . '</h4>';
          echo '    </div>';
          echo '  </div>';
          echo '  <div class="post-content">';
          echo '    <p id="text-content">' . $row['new'] . '</p>';
          echo '  </div>';
          if ($row['img'] != '') {
            echo '  <div class="post-image">';
            echo '    <img src="' . $row['img'] . '" alt="Post Image">';
            echo '  </div>';
          }
          echo '  <div class="post-footer">';
          echo '    <span id="likeCount_' . $idnews . '">' . $likeCount . ' Likes</span>';
          echo '    <div style="margin: 10px 0; border-top: 1px solid #ccc;"></div>'; // فاصل بين عدد الإعجابات وزر الإعجاب
          echo '    <button onclick="likePost(' . $idnews . ')" id="likeButton_' . $idnews . '"><i class="fas fa-thumbs-up"></i> Like</button>';

          // echo '    <button><i class="fas fa-comment"></i> Comment</button>';

          echo '
    <button onclick="copyToClipboard(\'' . 'http://localhost/website/proteamhub/web/pages/show-post.php?post_id=' . $idnews . '\')">
        <i class="fas fa-share"></i> Share
    </button>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
            }, function(err) {
                console.error("Could not copy text: ", err);
            });
        }
    </script>
';


          echo '  </div>';
          echo '</div>';
        }
      } else {
        echo "No posts available.";
      }
      ?>

      <script>
        function styleText() {
          let paragraph = document.getElementById('text-content');
          let text = paragraph.innerHTML;

          text = text.replace(/"(.*?)"/g, '<span class="quote-style">"$1"</span>');
          text = text.replace(/<(.+?)>/g, '<span class="code-style">$1');
          text = text.replace(/\[(.*?)\]/g, '<span class="glow-style">$1</span>');
          text = text.replace(/\{(.*?)\}/g, '<span class="three-d-style">$1</span>');
          text = text.replace(/\/(.*?)\//g, '<span class="overline-style">$1</span>');
          text = text.replace(/~(.*?)~/g, '<span class="spaced-style">$1</span>');
          text = text.replace(/\^(.*?)\^/g, '<span class="wiggle-style">$1</span>');
          text = text.replace(/#(.*?)#/g, '<span class="double-shadow-style">$1</span>');
          text = text.replace(/%(.*?)%/g, '<span class="handwriting-style">$1</span>');
          text = text.replace(/@(.*?)@/g, '<span class="gradient-style">$1</span>');

          paragraph.innerHTML = text;
        }

        window.onload = styleText;
      </script>
      <script>
        function likePost(postId) {
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "config/effects/like.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
              var response = xhr.responseText.trim();
              var likeButton = document.getElementById('likeButton_' + postId);
              var likeCountSpan = document.getElementById('likeCount_' + postId);

              if (response === 'liked') {
                likeButton.innerHTML = '<i class="fas fa-thumbs-down"></i> Dislike';
                localStorage.setItem('likeStatus_' + postId, 'liked');
                updateLikeCount(likeCountSpan, 1);
              } else if (response === 'disliked') {
                likeButton.innerHTML = '<i class="fas fa-thumbs-up"></i> Like';
                localStorage.setItem('likeStatus_' + postId, 'disliked');
                updateLikeCount(likeCountSpan, -1);
              }
            }
          };
          xhr.send("post_id=" + postId); // يمكنك تعديل القيمة حسب الحاجة
        }

        function updateLikeCount(element, change) {
          var currentCount = parseInt(element.textContent);
          element.textContent = (currentCount + change) + ' Likes';
        }

        // تحميل الحالة الحالية عند تحميل الصفحة
        window.onload = function() {
          var posts = document.querySelectorAll('.post-footer button[id^="likeButton_"]');
          posts.forEach(function(likeButton) {
            var postId = likeButton.id.split('_')[1];
            var likeStatus = localStorage.getItem('likeStatus_' + postId);
            if (likeStatus === 'liked') {
              likeButton.innerHTML = '<i class="fas fa-thumbs-down"></i> Dislike';
            } else if (likeStatus === 'disliked') {
              likeButton.innerHTML = '<i class="fas fa-thumbs-up"></i> Like';
            }
          });
        };
      </script>


    </center>













  </main>
</body>

</html>