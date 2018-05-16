[![Latest Stable Version](https://poser.pugx.org/chaiminchun/google-analytic-report-application/v/stable)](https://packagist.org/packages/chaiminchun/google-analytic-report-application)
[![License](https://poser.pugx.org/chaiminchun/google-analytic-report-application/license)](https://packagist.org/packages/chaiminchun/google-analytic-report-application)
# Google analytic reporting  v4 API email application

A custom email reporting service based on Google analytic v4 API

## Install
<code> composer require chaiminchun/google-analytic-report-application </code>

## Feature
1. Monthly performance comparision work like google email report

    ![image](./img/googleanalyticemail.png?raw=true "Title")
## Get started
1. Composer install.
2. Move views and cache folder, config.php, and Analyic.php to root folder
2. Setup the email and google analytic account.
3. Fill in necessary setting in config.php 
4. Run <code> php Analytic.php </code>

## External library
1. <a href="https://github.com/txthinking/Mailer"> Mailer </a>by  txthinking
2. <a href="https://github.com/jenssegers/blade"> Blade </a>by jenssegers
