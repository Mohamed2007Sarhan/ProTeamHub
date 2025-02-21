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
  <title>Ask Expert | ProTeamHub</title>
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


    <!DOCTYPE html>
    <html lang="en">

    <head>
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Profiles Page | ProTeamHub</title>
      <style>
        /* General page styling */


        /* Parent container for Profile Cards */
        .profiles-wrapper {
          display: flex;
          flex-wrap: wrap;
          gap: 10px;
          /* Small gap between items */
          justify-content: flex-start;
        }

        /* Styling for each Profile Card */
        .profile-container {
          background-color: blured;
          /* Light gray background */
          padding: 15px;
          border-radius: 10px;
          box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
          width: 200px;
          /* Fixed width for each card */
          text-align: center;
          transition: all 0.3s ease-in-out;
          position: relative;
          /* For the star positioning */
        }

        .profile-container:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        /* Container for the profile image */
        .image-container {
          width: 120px;
          height: 120px;
          border-radius: 50%;
          /* Make the container circular */
          overflow: hidden;
          /* Ensure the image stays within the circle */
          margin: 0 auto;
          /* Center the container */
          border: 4px solid #007bff;
          /* Blue border around the image */
          position: relative;
          /* For the star positioning */
        }

        /* Profile image styling */
        .profile-image {
          width: 100%;
          height: 100%;
          object-fit: cover;
          /* Ensure the image fits well */
          transition: all 0.3s ease;
        }

        .profile-image:hover {
          transform: scale(1.1);
        }

        /* Star styling */
        .star {
          position: absolute;
          top: 10px;
          right: 10px;
          background-color: gold;
          color: white;
          width: 30px;
          height: 30px;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 18px;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .profile-container h2 {
          font-size: 1.2em;
          color: #333;
          margin-top: 10px;
        }

        .profile-container p {
          font-size: 0.9em;
          color: #777;
          margin: 8px 0;
        }

        .profile-container a {
          color: #007bff;
          text-decoration: none;
        }

        .profile-container button {
          padding: 10px 20px;
          background-color: #007bff;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          font-size: 0.9em;
          margin-top: 10px;
          transition: all 0.3s ease;
        }

        .profile-container button:hover {
          background-color: #0056b3;
        }

        .cv-button a button {
          background-color: #28a745;
        }

        .cv-button a button:hover {
          background-color: #218838;
        }

        /* Modal styling */
        .modal {
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.5);
          justify-content: center;
          align-items: center;
          z-index: 1;


          background-color: rgba(0, 0, 0, 0.5);
          /* لون خلفية مع شفافية */
          backdrop-filter: blur(5px);
        }

        .modal-content {
          background-color: #fff;
          padding: 20px;
          border-radius: 10px;
          width: 80%;
          max-width: 500px;
          text-align: center;
          animation: fadeIn 0.5s ease-in-out;
        }

        .modal-content h3 {
          font-size: 1.5em;
          color: #333;
          margin-bottom: 10px;
        }

        .modal-content p {
          font-size: 1em;
          color: #555;
        }

        .modal-content button {
          padding: 10px 20px;
          background-color: #dc3545;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          margin-top: 20px;
        }

        .modal-content button:hover {
          background-color: #c82333;
        }

        @keyframes fadeIn {
          0% {
            opacity: 0;
          }

          100% {
            opacity: 1;
          }
        }
      </style>
    </head>

    <body>

      <?php
      $query = "SELECT r.*, e.portfolio_url, e.expertise_area, c.chat_platform 
FROM register r
LEFT JOIN experts e ON r.ID = e.user_id
LEFT JOIN user_chat c ON r.ID = c.user_id
WHERE r.user_type = 'expert'";

      $stmt = $conx->prepare($query);
      $stmt->execute();
      $result = $stmt->get_result();
      $users = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();

      ?>




      <div class="profiles-wrapper">
        <?php foreach ($users as $user): ?>
          <div class="profile-container">
            <div class="star">★</div>
            <div class="image-container">
              <img src="<?= htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-image">
            </div>
            <h2><?= htmlspecialchars($user['Username']); ?></h2>
            <p>Email: <a href="mailto:<?= htmlspecialchars($user['email']); ?>"><?= htmlspecialchars($user['email']); ?></a></p>
            <button onclick="openModal('<?= $user['ID']; ?>')">View Full Profile</button>

            <div class="cv-button">
              <?php if (!empty($user['portfolio_url'])): ?>
                <a href="<?= htmlspecialchars($user['portfolio_url']); ?>" target="_blank">
                  <button>View Portfolio</button>
                </a>
              <?php else: ?>
                <p>No Portfolio Available</p>
              <?php endif; ?>
            </div>

            <div class="cv-button">
              <?php if (!empty($user['portfolio_url'])): ?>
                <a href="<?= htmlspecialchars($user['portfolio_url']); ?>" download>
                  <button>Download CV</button>
                </a>
              <?php else: ?>
                <p>No CV available</p>
              <?php endif; ?>
            </div>

            <p>Expertise Area: <span><?= htmlspecialchars($user['expertise_area']); ?></span></p>
            <p>Chat Platform: <span><?= htmlspecialchars($user['chat_platform']); ?></span></p>
          </div>

          <!-- Modal for Experience -->
          <div id="<?= $user['ID']; ?>" class="modal">
            <div class="modal-content">
              <h3><?= htmlspecialchars($user['Username']); ?></h3>
              <p><strong>Experience:</strong> <?= htmlspecialchars($user['expertise_area']); ?></p>
              <button onclick="closeModal('<?= $user['ID']; ?>')">Close</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>


      <script>
        function openModal(personId) {
          document.getElementById(personId).style.display = 'flex';
        }

        function closeModal(personId) {
          document.getElementById(personId).style.display = 'none';
        }
      </script>


  </main>
</body>

</html>