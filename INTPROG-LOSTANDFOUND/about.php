<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items</title>
    <script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    /* Global styles */
   * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        /* Full page height and background */
        html, body {
            height: 100%;
            width: 100%;
            background: rgb(244, 244, 203);
        }

        /* Navbar styling */
        nav {
            padding: 10px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, rgba(255,204,0,1) 0%, rgba(6,59,58,1) 0%, rgba(11,142,88,1) 100%, rgba(255,204,0,1) 100%);
            position: relative;
            height: 70px;
        }

        nav .logo {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        nav ul li {
            list-style-type: none;
        }

        button {
            padding: 10px 30px;
            background-color: rgba(11,142,88,1);
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: rgba(6,59,58,1);
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
        }

        nav ul li a:hover {
            color: #9df385;
        }
    /* Menu icon (hamburger) for mobile view */ 
    .menu-icon { 
        display: none; 
    } 
    .menu-icon i { 
        color: #fff; 
        font-size: 30px;
    } 
    /* Admin dashboard content */ 
    .admin-dashboard { 
        padding: 40px; 
        background-color: #fff; 
        margin-top: 20px; 
        border-radius: 10px; 
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        min-height: calc(100vh - 70px); 
    } 
    /* Table styles */ table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-bottom: 20px; 
    } 
    table th, table td { 
        padding: 12px 15px; 
        text-align: left; 
        border-bottom: 1px solid #ddd; 
    } 
    table th { 
        background-color: #f4f4f4; 
        color: #333; 
        font-weight: bold; 
    } 
    table tr:nth-child(even) { 
        background-color: #f9f9f9;
    } 
    table tr:hover { 
        background-color: #f1f1f1; 
    } 
    table tr:last-child td { 
        border-bottom: none;
    } 
    /* Modal styles */ 
    .modal { 
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px; 
    } 
    .modal-content { 
        background-color: #fefefe; 
        margin: 5% auto; 
        padding: 20px; 
        border: 1px solid #888; 
        width: 80%; 
        border-radius: 10px; 
    } 
    .close { 
        color: #aaa; 
        float: right; 
        font-size: 28px; 
        font-weight: bold; 
    } 
    .close:hover, .close:focus { 
        color: black; 
        text-decoration: none; 
        cursor: pointer; 
    } 
    /* Buttons */ 
    .btn-view, .btn-edit, .btn-delete { 
        padding: 10px 20px; 
        margin: 5px; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
        font-size: 16px; 
        color: #fff; 
    } 
    .btn-view { 
        background-color: #0b8e58; 
    } 
    .btn-view:hover { 
        background-color: #065b3a; 
    } 
    .btn-edit { 
        background-color: #ffaa00; 
    } 
    .btn-edit:hover { 
        background-color: #cc8400; 
    } 
    .btn-delete { 
        background-color: #ff4444; 
    } 
    .btn-delete:hover { 
        background-color: #cc0000; 
    } 
    /* Responsive design for smaller screens */ 
    @media (max-width: 600px) { 
    nav ul { 
        position: absolute; 
        top: 70px; 
        left: 0; 
        right: 0; 
        flex-direction: column; 
        text-align: center; 
        background: green; 
        gap: 0; 
        overflow: hidden; 
    } 
    nav ul li { 
        padding: 20px; 
        padding-top: 10; 
    } 
    .menu-icon { 
        display: block; 
    } 
    #menuList { 
        transition: all 0.5s; 
    } 
    /* Make menu visible when clicked */ 
    #menuList.open { 
        max-height: 300px; 
    } 
    .admin-dashboard { 
        padding: 20px; 
        } 
    } 
    </style>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */


/* Team Section */
.team-section {
    display: flex;
    justify-content: flex-start; 
    align-items: center;
    height: 60%;
    margin-top: 10px;
    padding: 10px 100px; 
    gap: 20px;
    overflow-x: auto;
    scroll-behavior: smooth;
}

.team-member {
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    width: 230px;
    transition: filter 0.3s ease-in-out, transform 0.3s ease-in-out;
    cursor: pointer;
    margin-right: 20px;
}

.team-member img {
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin-bottom: 15px;
}

.team-member h2 {
    font-size: 1em;
    color: #333;
}

.team-member.active {
    transform: scale(1.2);
    filter: none;
}

.team-member.inactive {
    filter: blur(4px);
}

/* Profile Section */
.profile-section {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 30%;
    background-color: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
}

.profile-section.visible {
    opacity: 1;
}

.profile-content {
    display: flex;
    align-items: center;
}

#profile-image {
    border-radius: 50%;
    width: 200px;
    height: 200px;
    object-fit: cover;
    margin-right: 20px;
}

#profile-description {
    max-width: 600px;
}

#profile-name {
    font-size: 2em;
    margin-bottom: 10px;
}

#profile-text {
    font-size: 1.2em;
    color: #ddd;
}

#social-links {
    margin-top: 20px;
}

#social-links a {
    margin-right: 15px;
    color: black;
    font-size: 20px;
    text-decoration: none;
    transition: opacity 0.3s ease-in-out;
}

#social-links a:hover {
    opacity: 0.7;
}

/* Responsive Design */
@media (max-width: 768px) {
    .team-section {
        padding: 10px;
    }

    .team-member {
        width: 200px;
        margin-right: 15px;
    }

    .team-member img {
        width: 120px;
        height: 120px;
    }

    .team-member h2 {
        font-size: .75rem;
    }

    .profile-section {
        flex-direction: column;
        text-align: center;
        margin-top: 20px; 
    }

    #profile-image {
        width: 150px;
        height: 150px;
    }

    #profile-name {
        font-size: 1.5rem;
    }

    #profile-text {
        font-size: 1rem;
    }

    #social-links a {
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    header h1 {
        font-size: 1.5rem;
    }

    .team-section {
        padding: 10px;
    }

    .team-member img {
        width: 100px;
        height: 100px;
    }

    .team-member h2 {
        font-size: 0.9rem;
    }

    #profile-image {
        width: 120px;
        height: 120px;
    }

    #profile-name {
        font-size: 1.2rem;
    }

    #profile-text {
        font-size: 0.9rem;
    }
}

    </style>
    </head>
<nav>
        <div class="logo">
            <h1>Welcome, Admin!</h1>
        </div>
        <ul id="menuList">
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="amlost.php">Lost</a></li>
            <li><a href="amfound.php">Found</a></li>
            <li><a href="amretrieved.php">Retrieved</a></li>
            <li><a href="about.php">About</a></li>
            <form method="POST" action="admin_dashboard.php">
            <button type="submit" name="logout">Logout</button>
            </form>
        </ul>
        <div class="menu-icon">
            <i class="fa-solid fa-bars" onclick="toggleMenu()"></i>
        </div>
    </nav>
    <body>
    <!-- Hindi ko na ipapaliwanag to guys, same lang to dun sa version 3. Naiiba lang dito is PHP yung gamit at
         ginamit ko yung $profiles para dun ilagay yung details about satin. -->
    <?php
    $profiles = [
        "member1" => [
            "name" => "Ronnie Aviles",
            "image" => "Ronnie.JPG",
            "description" => "Ronnie is an integral member of our team with expertise in Robotics. He has contributed to this website project as our Leader. Outside of work, Ronnie enjoys online games and sports.",
            "github" => "https://github.com/ronssaaviles",
            "linkedin" => "https://www.linkedin.com/in/ronnie-aviles-55a696322/",
            "facebook" => "https://www.facebook.com/ronss.2003"
        ],
        "member2" => [
            "name" => "Covie Marfil",
            "image" => "Covie.JPG",
            "description" => "Covie specializes in Web Development. His contributions to this website project are noteworthy. Outside of work, Covie enjoys Photography and App development.",
            "github" => "https://github.com/Marfil-Covie",
            "linkedin" => "https://www.linkedin.com/in/covie-marfil-367484322/",
            "facebook" => "https://www.facebook.com/Covie-Marfil/"
        ],
        "member3" => [
            "name" => "Jayve Arenas",
            "image" => "Arenas.JPG",
            "description" => "Jayve is known for App Development. He has a strong background in Programming. In his free time, Jayve likes to play sports and online games.",
            "github" => "https://github.com/Jayve23",
            "linkedin" => "www.linkedin.com/in/jayve-arenas-5013332b6",
            "facebook" => "https://www.facebook.com/jabu.arenas.7"
        ],
        "member4" => [
            "name" => "Christian Casera",
            "image" => "Casera.JPG",
            "description" => "Christian is a key player in our team with skills in Database Management. His involvement in the website project has been invaluable. Christian’s hobbies include App and System Development.",
            "github" => "https://github.com/Christian-Casera",
            "linkedin" => "https://www.linkedin.com/in/john-casera-072486322/",
            "facebook" => "https://www.facebook.com/johnchristian.casera"
        ],
        "member5" => [
            "name" => "Yuan Erguiza",
            "image" => "Yuan.JPG",
            "description" => "Yuan brings a wealth of experience in Programming. His work on this website project has been impressive. Yuan enjoys Robotics and Data Management in his spare time.",
            "github" => "https://github.com/Yuan-Erguiza",
            "linkedin" => "https://www.linkedin.com/in/yuan-erguiza-722ab6322/",
            "facebook" => "https://www.facebook.com/yuan.arguiza"
        ]
    ];
    ?>

    <!-- Eto naman para lumabas yung members dun sa page, same lang din sa version 3 -->
    <section class="team-section">
        <?php foreach ($profiles as $id => $profile) : ?>
            <div class="team-member" id="<?php echo $id; ?>" onclick="showProfile('<?php echo $id; ?>')">
                <img src="<?php echo $profile['image']; ?>" alt="<?php echo $profile['name']; ?>">
                <h2><?php echo $profile['name']; ?></h2>
            </div>
        <?php endforeach; ?>
    </section>


    <!-- Eto naman ay para lumabas yung details ng member na clinick ni user, basta iproprovide nya yung mga dapat nakalagay sa ID. -->
    <section class="profile-section" id="profile-section">
        <div class="profile-content" id="profile-content">
            <img id="profile-image" src="" alt="">
            <div id="profile-description">
                <h2 id="profile-name"></h2>
                <p id="profile-text"></p>
                <div id="social-links">
                    <a id="github-link" href="#" target="_blank">
                        <i class="fab fa-github"></i>
                    </a>
                    <a id="linkedin-link" href="#" target="_blank">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a id="facebook-link" href="#" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
         
    
    <!-- javarice -->
    <script>
        const profiles = {  // detailed description
    member1: {
        name: 'Ronnie Aviles',
        image: 'Ronnie.JPG',
        description: 'Ronnie is an integral member of our team with expertise in Robotics. He has contributed to this website project as our Leader. Outside of work, Ronnie enjoys online games and sports.',
        github: 'https://github.com/ronssaaviles',
        linkedin: 'https://www.linkedin.com/in/ronnie-aviles-55a696322/',
        facebook: 'https://www.facebook.com/ronss.2003'
    },
    member2: {
        name: 'Covie Marfil',
        image: 'Covie.JPG',
        description: 'Covie specializes in Web Development. His contributions to this website project are noteworthy. Outside of work, Covie enjoys Photography and App development.',
        github: 'https://github.com/Marfil-Covie',
        linkedin: 'https://www.linkedin.com/in/covie-marfil-367484322/',
        facebook: 'https://www.facebook.com/Covie-Marfil/'
    },
    member3: {
        name: 'Jayve Arenas',
        image: 'Arenas.JPG',
        description: 'Jayve is known for App Development. He has a strong background in Programming. In his free time, Jayve likes to play sports and online games.',
        github: 'https://github.com/Jayve23',
        linkedin: 'www.linkedin.com/in/jayve-arenas-5013332b6',
        facebook: 'https://www.facebook.com/jabu.arenas.7'
    },
    member4: {
        name: 'Christian Casera',
        image: 'Casera.JPG',
        description: 'Christian is a key player in our team with skills in Database Management. His involvement in website project has been invaluable. Christian’s hobbies include App and System Development.',
        github: 'https://github.com/Christian-Casera',
        linkedin: 'https://www.linkedin.com/in/john-casera-072486322/',
        facebook: 'https://www.facebook.com/johnchristian.casera'
    },
    member5: {
        name: 'Yuan Erguiza',
        image: 'Yuan.JPG',
        description: 'Yuan brings a wealth of experience in Programming. His work on this website project has been impressive. Yuan enjoys Robotics and Data Mangement in his spare time.',
        github: 'https://github.com/Yuan-Erguiza',
        linkedin: 'https://www.linkedin.com/in/yuan-erguiza-722ab6322/',
        facebook: 'https://www.facebook.com/yuan.arguiza'
    }
};

let currentFocus = null;

function showProfile(memberId) {
    const member = document.getElementById(memberId);
    
    // pang reset ng focus at blur sa mg picture
    if (currentFocus === memberId) {
        document.querySelectorAll('.team-member').forEach(member => {
            member.classList.remove('active', 'inactive');
        });
        document.getElementById('profile-section').classList.remove('visible');
        currentFocus = null;
        return;
    }

    // eto para lumabas yung desription dipende kung sino yung clinick
    const profile = profiles[memberId];
    document.getElementById('profile-image').src = profile.image;
    document.getElementById('profile-name').textContent = profile.name;
    document.getElementById('profile-text').textContent = profile.description;
    document.getElementById('github-link').href = profile.github;
    document.getElementById('linkedin-link').href = profile.linkedin;
    document.getElementById('facebook-link').href = profile.facebook;

    // sa madaling salita on and off HAHAHAHAHHA hindi ko mapaliwanag
    document.querySelectorAll('.team-member').forEach(member => {
        member.classList.add('inactive');
    });
    member.classList.remove('inactive');
    member.classList.add('active');

    // pampalabas ng profile section
    document.getElementById('profile-section').classList.add('visible');
    currentFocus = memberId;
}



    </script>
</body>
</html>
