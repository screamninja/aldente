<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/main.css">
    <title><?php echo "PHP-Framework: $title"; ?></title>
</head>
<body>
<!-- Page header -->
<header>
    <div class="page-header-board">
        <a href="/">
            <img src="/images/page-logo.png" alt="Logo" class="header-logo">
        </a>
        <h1 class="page-header-caption">Framework</br>
            <span class="page-header-caption-sub">based on MVC</span>
        </h1>
    </div>
<!-- MENU -->
    <div class="header-links">
        <div class="header-links-wrapper container">
            <nav class="header-nav">
                <ul class="header-menu">
                    <li><a href="/" class="header-link">HOME</a></li>
                    <li><a href="/news" class="header-link">NEWS</a></li>
                    <li class="header-dropdown-link">
                        <a href="#" class="header-link">FEATURES</a>
                        <ul class="header-dropdown-menu">
                            <li><a href="/features/api" class="header-link">News API (JSON-RPC)</a></li>
                            <li><a href="/features/ajax" class="header-link">AJAX (switchable)</a></li>
                            <li><a href="/features/logger" class="header-link">Logger</a></li>
                        </ul>
                    </li>
                    <li><a href="/about" class="header-link">ABOUT</a></li>
                    <li><a href="https://github.com/screamninja/aldente" class="header-download header-link">DOWNLOAD</a></li>
                </ul>
            </nav>
            <div class="header-auth-wrapper">
                <?php if (!isset($_SESSION['logged_user'])) : ?>
                    <ul class="header-auth-menu">
                        <li><a href="/account/login" class="header-login header-link">Login</a></li>
                        <li><a href="/account/register" class="header-register header-link">Register</a></li>
                    </ul>
                <?php else : ?>
                    <div class="header-auth-info">
                        <div class="description-show-link-wrapper">
                            <a href="#" class="description-show-link">
                                <i class="arrow-down"></i>
                            </a>
                            <div class="profile-description">
                                <p>Welcome home, <?php echo $_SESSION['logged_user'] ?>!</p></br><hr></br>
                                <p class="user-profile-email">You are registered with email: <?php echo $_SESSION['logged_email'] ?></p></br>
                                <form action="/account/logout" method="post">
                                    <button type="submit" name="do_log_out">Log Out!</button>
                                </form>
                            </div>
                        </div>
                        <div class="user-profile">
                            <a href="#" class="user-profile-login"><?php echo $_SESSION['logged_user'] ?></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
<!-- Main content -->
<?php echo $content; ?>
<!-- Page footer -->
<footer>
    <div class="copyright-wrapper">
        <p>&copy; <?php echo date('Y') ?> Dmitry Kuleznev
    </div>
</footer>
</body>
</html>