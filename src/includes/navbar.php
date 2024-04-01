<?php session_start(); ?>
<div class="nav-div">
    <div class="nav-div-a">
        <a href="/src/profile.php">Профиль</a>
        <a href="/src/posts/all_posts.php">Лента постов</a>
        <a href="/src/posts/create_post.php">Создать новый пост</a>
        <a href="/src/follow/файл.php">Подписки</a>
        <a href="/src/auth/logout.php">Выйти</a>
    </div>

    <div>
        <p><?php echo $_SESSION['login']; ?></p>
    </div>
</div>
<hr>
