<?php

require '/usr/local/etc/hungre-people.csasq.ru/config.php';

$connection = new PDO(
    $config['db:coninfo'],
    $config['db:username'],
    $config['db:password'],
);
$cursor = $connection->prepare(<<< EOF
select
    users.email_address
from
    sessions
        inner join users on
            sessions.user_id = users.id
where
    sessions.access_token = :access_token;
EOF);
$cursor->bindValue(':access_token', hex2bin($_COOKIE['access_token']));
$cursor->execute();
$email_address = $cursor->fetch()['email_address'];
$cursor = $connection->prepare('select attributes from static where id = 1;');
$cursor->execute();
$about_us = json_decode($cursor->fetch()['attributes'], true);
$cursor = $connection->prepare('select attributes from static where id = 2;');
$cursor->execute();
$our_team = json_decode($cursor->fetch()['attributes'], true);
$cursor = $connection->prepare('select attributes from static where id = 3;');
$cursor->execute();
$specialties = json_decode($cursor->fetch()['attributes'], true);
$cursor = $connection->prepare('select attributes from static where id = 4;');
$cursor->execute();
$event_1 = json_decode($cursor->fetch()['attributes'], true);
$cursor = $connection->prepare('select attributes from static where id = 5;');
$cursor->execute();
$event_2 = json_decode($cursor->fetch()['attributes'], true);

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./pages/index.css">
    <title>Hungry people</title>
    <script src="https://api-maps.yandex.ru/v3/?apikey=668b9f05-8aa6-470b-aa38-04c48f7f2016&lang=en_US"></script>
</head>
<body class="page">
    <div class="container">
        <header class="header" id="header">
            <nav class="header__menu">
                <ul class="header__list list">
                    <li class="header__item"><a class="header__link link" href="#">Home</a></li>
                    <li class="header__item"><a class="header__link link" href="#about">About</a></li>
                    <li class="header__item"><a class="header__link link" href="#team">Team</a></li>
                    <li class="header__item"><a class="header__link link" href="#booking">Booking</a></li>
                </ul>
            </nav>
            <img id="wheel" alt="wheel" class="header__image" src="images/wheel.svg">
            <nav class="header__menu">
                <ul class="header__list list">
                    <li class="header__item"><a class="header__link link" href="#menu">Menu</a></li>
                    <li class="header__item"><a class="header__link link" href="#events">Events</a></li>
                    <li class="header__item"><a class="header__link link" href="#contact">Contact</a></li>
                    <li class="header__item" style="<?= $email_address ? 'display: none;' : '' ?>"><a class="header__link link" href="#sign-in">Sign In</a></li>
                    <li class="header__item" style="<?= $email_address ? '' : 'display: none;' ?>"><a class="header__link link" href="#account">Account</a></li>
                </ul>
            </nav>
            <div class="burger-icon">
                <div id="first-line" class="burger-icon__line"></div>
                <div id="second-line" class="burger-icon__line"></div>
                <div id="third-line" class="burger-icon__line"></div>
                <nav class="burger">
                    <ul class="burger__list list">
                        <li class="burger__item"><a class="burger__link link" href="#">Home</a></li>
                        <li class="burger__item"><a class="burger__link link" href="#about">About</a></li>
                        <li class="burger__item"><a class="burger__link link" href="#team">Team</a></li>
                        <li class="burger__item"><a class="burger__link link" href="#booking">Booking</a></li>
                        <li class="burger__item"><a class="burger__link link" href="#menu">Menu</a></li>
                        <li class="burger__item"><a class="burger__link link" href="#events">Events</a></li>
                        <li class="burger__item"><a class="burger__link link" href="#contact">Contact</a></li>
                        <li class="header__item" style="<?= $email_address ? 'display: none;' : '' ?>"><a class="header__link link" href="#sign-in-mobile">Sign In</a></li>
                        <li class="header__item" style="<?= $email_address ? '' : 'display: none;' ?>"><a class="header__link link" href="#account-mobile">Account</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <section class="hungry-people">
                <p class="work-hours__text">Mon - Fri: 8PM - 10PM, Sat - Sun: 8PM - 3AM</p>
            <div class="title-container">
                <h2 class="title-container__text title">restaurant</h2>
                <h1 class="title-container__title">hungry people</h1>
                <div class="title-container__line line"></div>
                <div class="title-container__wrapper">
                    <a  href="#booking" class="title-container__button button_active button link">book table</a>
                    <a href="#menu" class="title-container__button button link">explore</a>
                </div>
            </div>
            <ul class="social-icons list">
                <li class="social-icons__item">
                    <a href="#" target="_blank"
                       class="social-icons__link social-icons__link_t link"></a>
                </li>
                <li class="social-icons__item">
                    <a href="https://twitter.com/?lang=ru" target="_blank"
                       class="social-icons__link social-icons__link_twitter link"></a>
                </li>
                <li class="social-icons__item">
                    <a href="#" target="_blank"
                       class="social-icons__link social-icons__link_vk link"></a>
                </li>
            </ul>
        </section>
    </div>
    <section id="about" class="about-us section">
        <div class="about-us__content section__content">
            <div class="text-container">
                <h2 class="text-container__title subtitle subtitle_color_black"><?= $about_us['title'] ?></h2>
                <div class="text-container__line line"></div>
                <p class="text-container__subtitle text-container__subtitle_color_black"><?= $about_us['caption'] ?></p>
                <p class="text-container__text text-container__text_color_black"><?= $about_us['description'] ?></p>
            </div>
            <img class="about-us__image section__image" src="<?= $about_us['image'] ?>">
        </div>
    </section>
    <section id="team" class="team section">
        <h2 class="section__title title">our team</h2>
        <div class="team__content section__content">
            <img alt="Cook at work" src="<?= $our_team['image'] ?>" class="section__image">
            <div class="text-container">
                <h3 class="text-container__title subtitle subtitle_color_white"><?= $our_team['title'] ?></h3>
                <div class="text-container__line line"></div>
                <p class="text-container__subtitle text-container__subtitle_color_white"><?= $our_team['caption'] ?></p>
                <p class="text-container__text text-container__text_color_white"><?= $our_team['description'] ?></p>
            </div>
        </div>
    </section>
    <section id="booking" class="booking">
        <div class="booking__content">
            <div class="booking__form-container">
                <h2 class="booking__title subtitle subtitle_color_black">book a table</h2>
                <div class="line"></div>
                <form class="booking__form" id="booking__form">
                    <div class="booking__inputs">
                        <input class="booking__input input" required placeholder="Name" id="booking__name" minlength="2" maxlength="32">
                        <input class="booking__input input" required <?= $email_address ? 'disabled' : '' ?> type="email" placeholder="Email" value="<?= $email_address ? $email_address : '' ?>" id="booking__email_address" maxlength="320">
                        <input class="booking__input input" required type="tel" placeholder="Phone" id="booking__phone_number" minlength="8" maxlength="32">
                        <select class="booking__input input" form="booking__form" required id="booking__people_number">
                            <option selected disabled hidden value="">People</option>
                            <option class="booking__option">1</option>
                            <option class="booking__option">2</option>
                            <option class="booking__option">3</option>
                            <option class="booking__option">4</option>
                            <option class="booking__option">5</option>
                            <option class="booking__option">6</option>
                        </select>
                        <input class="booking__input input" required type="date" placeholder="Date (mm/dd)" id="booking__date">
                        <select class="booking__input input" required id="booking__time">
                            <option selected disabled hidden value="">Time</option>
                            <option class="booking__option" value="14:00:00">14.00</option>
                            <option class="booking__option" value="15:00:00">15.00</option>
                            <option class="booking__option" value="16:00:00">16.00</option>
                            <option class="booking__option" value="17:00:00">17.00</option>
                            <option class="booking__option" value="18:00:00">18.00</option>
                            <option class="booking__option" value="19:00:00">19.00</option>
                            <option class="booking__option" value="20:00:00">20.00</option>
                            <option class="booking__option" value="21:00:00">21.00</option>
                            <option class="booking__option" value="22:00:00">22.00</option>
                        </select>
                    </div>
                    <button type="submit" class="booking__button button button_active" id="booking__submit">book now</button>
                </form>
            </div>
            <img class="booking__image" src="images/booking-img.png" alt="Clocks">
        </div>
        <p class="booking__text">Mon - Fri: <span class="booking__bold-text"> 8PM - 10PM</span>, Sat - Sun:
            <span class="booking__bold-text">8PM - 3AM</span>,
            Phone: <span class="booking__bold-text"> +40 729 131 637/+40 726 458 782</span></p>
    </section>
    <section class="pancakes section">
        <h2 class="pancakes__title section__title title">specialties</h2>
        <div class="pancakes__content section__content">
            <img alt="Ice cream" src="<?= $specialties['image'] ?>" class="section__image">
            <div class="text-container">
                <h2 class="text-container__title subtitle subtitle_color_white"><?= $specialties['title'] ?></h2>
                <div class="text-container__line line"></div>
                <p class="text-container__subtitle text-container__subtitle_color_white"><?= $specialties['caption'] ?></p>
                <p class="text-container__text text-container__text_color_white"><?= $specialties['description'] ?></p>
            </div>
        </div>
    </section>
    <section id="menu" class="menu">
        <h2 class="menu__title subtitle subtitle_color_black">delicious menu</h2>
        <div class="line"></div>
        <p class="menu__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Duis at velit maximus, molestie est a, tempor magna.</p>
        <div class="menu__buttons">
            <button class="menu__button">soupe</button>
            <button class="menu__button">pizza</button>
            <button class="menu__button">pasta</button>
            <button class="menu__button">desert</button>
            <button class="menu__button">wine</button>
            <button class="menu__button">beer</button>
            <button class="menu__button">drinks</button>
        </div>
        <div class="menu__lists" id="menu__lists">
            <ul class="menu__list list"></ul>
            <ul class="menu__list list"></ul>
            <ul class="menu__list list"></ul>
        </div>
    </section>
    <section id="events" class="events section">
        <h2 class="section__title title">PRIVATE EVENTS</h2>
        <div class="events__content">
            <div class="events__wrapper">
                <img src="<?= $event_1['image'] ?>" alt="rings" class="events__image">
                <div class="events__container">
                    <h3 class="events__caption"><?= $event_1['title'] ?></h3>
                </div>
            </div>
            <div class="events__wrapper">
                <div class="events__container">
                    <h3 class="events__caption events__caption_type_reverse"><?= $event_2['title'] ?></h3>
                </div>
                <img src="<?= $event_2['image'] ?>" alt="party" class="events__image">
            </div>
        </div>
    </section>
    <section class="section" style="display: flex; margin: auto; padding: 0;">
        <img src="images/restaurant-00.jpg" style="width: 25%; background-size: cover;" />
        <img src="images/restaurant-01.jpg" style="width: 25%; background-size: cover;" />
        <img src="images/restaurant-02.jpg" style="width: 25%; background-size: cover;" />
        <img src="images/restaurant-03.jpg" style="width: 25%; background-size: cover;" />
    </section>
    <section id="contact" class="contact">
        <h2 class="subtitle contact__title">contact</h2>
        <div class="line"></div>
        <p class="contact__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Duis at velit maximus, molestie est a, tempor magna.</p>
        <form class="contact__form">
            <div class="contact__inputs">
                <input required placeholder="Name" class="contact__input input" id="contact__name" minlength="2" maxlength="32">
                <input required placeholder="Email" type="email" <?= $email_address ? 'disabled' : '' ?> class="contact__input input" value="<?= $email_address ? $email_address : '' ?>" id="contact__email_address" maxlength="320">
                <input required placeholder="Phone" type="tel" class="contact__input input" id="contact__phone_number" minlength="8" maxlength="16">
            </div>
            <input required placeholder="Message" class="input input_size_big" id="contact__message" minlength="2" maxlength="256">
            <div class="contact__container">
                <div class="contact__item">
                    <img src="images/adress.svg" alt="adress icon" class="contact__icon">
                    <p class="contact__text">5th London Boulevard, U.K.</p>
                </div>
                <div class="contact__item">
                    <img src="images/tel.svg" alt="phone icon" class="contact__icon">
                    <p class="contact__text">+40 729 131 637 / +40 726 458 782</p>
                </div>
                <div class="contact__item">
                    <img src="images/mail.svg" alt="mail icon" class="contact__icon">
                    <p class="contact__text">office@mindblister.com</p>
                </div>
                <button type="submit" class="contact__button button button_active" id="contact__submit">send message</button>
            </div>
        </form>
    </section>
    <section id="map" class="section" style="padding-bottom: 0; width: 100%; height: 500px;"></section>
    <footer class="footer">
        <p class="footer__text">&copy; Made by Gleb O. Ivaniczkij, 2024</p>
    </footer>

    <div class="popup popup_type_sign_in">
        <div class="popup__content">
            <button
                    type="button"
                    class="popup__close-button"
            ></button>
            <div class="sign_in__content">
                <div class="sign_in__form-container">
                    <h2 class="sign_in__title subtitle subtitle_color_black">sign in</h2>
                    <div class="line" style="margin: 1rem auto 0 auto;"></div>
                    <form class="sign_in__form" id="sign_in__form" style="margin-top: .5rem;">
                        <p id="sign_in__exception" style="display: none; color: red; text-align: center;">Something went wrong...</p>
                        <div class="sign_in__inputs">
                            <input class="sign_in__input input" required type="email" placeholder="Email" style="margin-top: .5rem; width: 100%;">
                            <input class="sign_in__input input" required type="password" placeholder="Password" minlength="8" maxlength="32" style="margin-top: .5rem; width: 100%;">
                        </div>
                        <button type="submit" class="sign_in__button button button_active" style="margin-top: .5rem; width: 100%;">sign in</button>
                        <p style="margin-top: 1rem; margin-bottom: 0; text-align: center;">New user? <a class="link" href="#sign-up" style="color: black; text-decoration: underline;">Sign Up</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup_type_sign_up">
        <div class="popup__content">
            <button
                    type="button"
                    class="popup__close-button"
            ></button>
            <div class="sign_up__content">
                <div class="sign_up__form-container">
                    <h2 class="sign_up__title subtitle subtitle_color_black">sign up</h2>
                    <div class="line" style="margin: 1rem auto 0 auto;"></div>
                    <form class="sign_up__form" id="sign_up__form" style="margin-top: .5rem;">
                        <p id="sign_up__exception" style="display: none; color: red; text-align: center;">Something went wrong...</p>
                        <div class="sign_up__inputs">
                            <input class="sign_up__input input" required type="email" placeholder="Email" style="margin-top: .5rem; width: 100%;">
                            <input class="sign_up__input input" required type="password" placeholder="Password" minlength="8" maxlength="32" style="margin-top: .5rem; width: 100%;">
                        </div>
                        <button type="submit" class="sign_up__button button button_active" style="margin-top: .5rem; width: 100%;">sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup_type_account">
        <div class="popup__content">
            <button
                    type="button"
                    class="popup__close-button"
            ></button>
            <div class="account__content">
                <div class="account__form-container">
                    <h2 class="account__title subtitle subtitle_color_black">Account</h2>
                    <div class="line" style="margin: 1rem auto 0 auto;"></div>
                    <form class="account__form" id="account__form" style="margin-top: .5rem;">
                        <p id="account__exception" style="display: none; color: red; text-align: center;">Something went wrong...</p>
                        <p id="email-address" class="contact__subtitle" style="margin: 1rem auto;"><?= $email_address ?></p>
                        <button type="submit" class="account__button button button_active" style="margin-top: .5rem; width: 100%;">sign out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup_type_booking">
        <div class="popup__content">
            <button
                    type="button"
                    class="popup__close-button"
            ></button>
            <p class="popup__text">Your application has been accepted, please wait for the confirmation from the manager</p>
        </div>
    </div>

    <div class="popup popup_type_contact">
        <div class="popup__content">
            <button
                    type="button"
                    class="popup__close-button"
            ></button>
            <p class="popup__text">Thank you for your message. We will contact you soon</p>
        </div>
    </div>
    <script src="pages/index.js"></script>
</body>
</html>
