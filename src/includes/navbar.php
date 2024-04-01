<?php session_start(); ?>
<div class="nav-div">
    <div class="nav-div-a">
        <a href="/src/profile.php">Профиль</a>
        <a href="/src/posts/all_posts.php">Лента постов</a>
        <a href="/src/posts/create_post.php">Создать новый пост</a>
        <a href="/src/follow/follow_feed.php">Подписки</a>
        <a href="/src/auth/logout.php">Выйти</a>
    </div>

    <div>
        <p><?php echo htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</div>
<hr>
