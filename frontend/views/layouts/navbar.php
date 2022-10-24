<?php

use yii\helpers\Url;
?>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="<?= Url::home() ?>"><span>Kelajak </span>Academy</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu   
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a href="<?= Url::home() ?>" class="nav-link">Asosiy</a>
                </li>
                <li class="nav-item">
                    <a href="about.html" class="nav-link">Biz haqimizda</a>
                </li>
                <li class="nav-item">
                    <a href="course.html" class="nav-link">Kurslar</a>
                </li>
                <li class="nav-item">
                    <a href="instructor.html" class="nav-link">O'qituvchilar</a>
                </li>
                <li class="nav-item">
                    <a href="contact.html" class="nav-link">Bo'g'lanish</a>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/site/login']) ?>" class="nav-link">Profilim</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>