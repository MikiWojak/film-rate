<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin - Create User</title>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
            rel="stylesheet"
        />

        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        />

        <link rel="stylesheet" type="text/css" href="public/css/main.css" />
        <link rel="stylesheet" type="text/css" href="public/css/common.css" />
        <link rel="stylesheet" type="text/css" href="public/css/admin.css" />
    </head>
    <body>
        <header class="header">
            <div class="flex-row-center-center header_left">
                <button class="material-symbols-outlined btn--reset header_menu">
                    menu
                </button>

                <a href="/dashboard" class="flex-row-center-center header__logo">
                    <span class="material-symbols-outlined header__logo__image">
                        movie
                    </span>
                    <h1 class="header__logo__text">Film Rate</h1>
                </a>
            </div>

            <a href="/profile" class="flex-row-center-center header__login">
                <span class="material-symbols-outlined header__login__icon">
                    account_circle
                </span>
            </a>
        </header>

        <div class="admin-container">
            <!-- <nav class="navbar"> -->
            <nav class="navbar navbar--enabled">
                <ul>
                    <li>
                        <a href="/admin-users">
                            <span class="material-symbols-outlined">
                                account_circle
                            </span>
                            <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="material-symbols-outlined">
                                movie
                            </span>
                            <span>Films</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="material-symbols-outlined">
                                label
                            </span>
                            <span>Tags</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="material-symbols-outlined">
                                person
                            </span>
                            <span>Directors</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- <main class="content"> -->
            <div class="content navbar--enabled">
                <div class="content__inner--shrink">
                    <a href="/admin-users" class="flex-row-start-center back">
                        <span class="material-symbols-outlined">
                            arrow_left_alt
                        </span>
                        <span>
                            Back
                        </span>
                    </a>

                    <main>
                        <h2 class="createedit__header">
                            Create Film
                        </h2>

                        <form
                                action="addFilm"
                                method="POST"
                                ENCTYPE="multipart/form-data"
                                class="flex-column-center-center form createedit__form"
                        >
                            <div class="messages">
                                <?php
                                if(isset($messages)){
                                    foreach($messages as $message) {
                                        echo $message;
                                    }
                                }
                                ?>
                            </div>

                            <div class="form__input">
                                <label for="title">Title</label>
                                <input
                                    id="title"
                                    name="title"
                                    placeholder="Title"
                                    class="input__text"
                                />
                            </div>

                            <div class="form__input">
                                <label for="description">Description</label>
                                <textarea name="description" rows=5 placeholder="description" class="input__text"></textarea>
                            </div>

                            <div class="form__input">
                                <input type="file" name="file"/>
                            </div>

                            <div class="createedit__form__bottom">
                                <button type="submit" class="btn--reset btn btn--green">
                                    <span class="material-symbols-outlined">
                                        save
                                    </span>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </main>
                </div>  
            </div>
        </div>

        <div class="tab-bar">
            <a href="/dashboard" class="tab-bar__option">
                <span class="material-symbols-outlined">
                    home
                </span>
            </a>
            <button class="tab-bar__option">
                <span class="material-symbols-outlined">
                    search
                </span>
            </button>
            <button class="tab-bar__option">
                <span class="material-symbols-outlined">
                    star
                </span>
            </button>
            <a href="/profile" class="tab-bar__option">
                <span class="material-symbols-outlined">
                    account_circle
                </span>
            </a>
        </div>
    </body>
</html>