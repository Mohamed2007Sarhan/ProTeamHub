<?php
// Include encryption header
// Include encryption header
include('../../encryption.php');
// Check if the decryption function exists (assuming you have an external shell or encryption method)
if (!function_exists('decryptData')) {
    die("Decryption function not found.");
}

// Check cookies before decryption



/**
 * Mask email for privacy
 *
 * @param string $email
 * @return string
 */

// Include the database configuration
include('../../login/config.php');

// Verify database connection
if ($conx->connect_error) {
    die("Database connection failed: " . $conx->connect_error);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Post | ProTeamHub</title>
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




        </ul>


    </nav>

    <main>
        <button id="theme-toggle" class="theme-btn">
            <i id="theme-icon" class="fa fa-sun"></i>
            <span id="theme-text">Light Mode</span>
        </button>
        <style>
            #theme-login {
                padding: 10px 20px;
                background-color: #333;
                /* الخلفية الداكنة */
                color: #fff;
                border: none;
                border-radius: 30px;
                /* حواف مستديرة */
                cursor: pointer;
                font-size: 16px;
                transition: background-color 0.3s ease, color 0.3s ease;
                gap: 10px;
                position: fixed;
                /* يجعل الزر ثابت في الصفحة */
                top: 20px;
                /* مسافة من أعلى الصفحة */
                right: 200px;
                /* مسافة من اليمين */
                z-index: 1000;
                /* تأكد من أنه يظهر فوق العناصر الأخرى */
            }

            #theme-login:hover {
                background-color: #555;
                /* تغيير اللون عند المرور بالفأرة */
            }

            #theme-login i {
                font-size: 20px;
            }

            #theme-login span {
                font-size: 14px;
                font-weight: 600;
            }
            #login-link {
                color: #fff;
                text-decoration: none;
            }
        </style>
        <?php
        if (isset($_COOKIE['user_id'])) {
            echo '<button id="theme-login" onclick="window.location.href = \'../../login/logout.php\'">';
            echo '  <i class="fas fa-sign-out-alt"></i>';
            echo '  <span>Logout</span>';
            echo '</button>';
        } else {
            echo '<button id="theme-login" onclick="window.location.href = \'../../login/index.php\'">';
            echo '  <i class="fas fa-sign-in-alt"></i>';
            echo '  <span>Login</span>';
            echo '</button>';
        }
        ?>
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




        <center>

            <?php
            $id_share = $_GET['post_id'] ?? null;
            include('../../login/config.php');

            if ($id_share) {
                // Prepare and execute the SQL statement to fetch the post
                $stmt = $conx->prepare("SELECT * FROM news WHERE id = ?");
                $stmt->bind_param("i", $id_share);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $userId = $row['user_id'];
                        $idnews = $row['id'];

                        // Prepare and execute the SQL statement to fetch the like count
                        $likeCountStmt = $conx->prepare("SELECT COUNT(*) AS likeCount FROM likes WHERE idpost = ?");
                        $likeCountStmt->bind_param("i", $idnews);
                        $likeCountStmt->execute();
                        $likeCountResult = $likeCountStmt->get_result();
                        $likeCountRow = $likeCountResult->fetch_assoc();
                        $likeCount = $likeCountRow['likeCount'];

                        // Prepare and execute the SQL statement to fetch the user's profile picture
                        $profileStmt = $conx->prepare("SELECT profile_picture FROM register WHERE ID = ?");
                        $profileStmt->bind_param("i", $userId);
                        $profileStmt->execute();
                        $result1 = $profileStmt->get_result();

                        $userimg = '';
                        if ($result1->num_rows > 0) {
                            $row1 = $result1->fetch_assoc();
                            $userimg = $row1['profile_picture'];
                        }

                        // Display the post
                        echo '<div class="post">';
                        echo '  <div class="post-header">';
                        echo '    <img src="' . htmlspecialchars($userimg) . '" alt="Profile Picture" class="profile-pic">';
                        echo '    <div class="user-info">';
                        echo '      <h4>' . htmlspecialchars($row['username']) . '</h4>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '  <div class="post-content">';
                        echo '    <p id="text-content">' . htmlspecialchars($row['new']) . '</p>';
                        echo '  </div>';
                        if (!empty($row['img'])) {
                            echo '  <div class="post-image">';
                            echo '    <img src="' . htmlspecialchars($row['img']) . '" alt="Post Image">';
                            echo '  </div>';
                        }
                        echo '  <div class="post-footer">';
                        echo '    <span id="likeCount_' . $idnews . '">' . $likeCount . ' Likes</span>';
                        echo '    <div style="margin: 10px 0; border-top: 1px solid #ccc;"></div>';
                        echo '    <button onclick="copyToClipboard(\'http://localhost/website/proteamhub/web/pages/show-post.php?post_id=' . $idnews . '\')">';
                        echo '      <i class="fas fa-share"></i> Share';
                        echo '    </button>';
                        echo '    <script>';
                        echo '      function copyToClipboard(text) {';
                        echo '        navigator.clipboard.writeText(text).then(function() {';
                        echo '          console.log("Text copied to clipboard");';
                        echo '        }, function(err) {';
                        echo '          console.error("Could not copy text: ", err);';
                        echo '        });';
                        echo '      }';
                        echo '    </script>';
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo "No posts available.";
                }
            } else {
                echo "Invalid post ID.";
            }

            // Close the database connection
            $conx->close();

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