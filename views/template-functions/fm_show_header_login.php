<?php
/**
 * Show page header in Login Form
 */
function fm_show_header_login()
{
    $sprites_ver = '20160315';
    header("Content-Type: text/html; charset=utf-8");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");

    global $lang, $root_url, $favicon_path;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Web based File Manager in PHP, Manage your files efficiently and easily with Tiny File Manager">
        <meta name="author" content="CCP Programmers">
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex">
        <link rel="icon" href="<?php echo fm_enc($favicon_path) ?>" type="image/png">
        <title><?php echo fm_enc(APP_TITLE) ?></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <style>
            body.fm-login-page{background-color:#f7f9fb;font-size:14px}
            .fm-login-page .brand{width:121px;overflow:hidden;margin:0 auto;margin:40px auto;margin-bottom:0;position:relative;z-index:1}
            .fm-login-page .brand img{width:100%}
            .fm-login-page .card-wrapper{width:360px}
            .fm-login-page .card{border-color:transparent;box-shadow:0 4px 8px rgba(0,0,0,.05)}
            .fm-login-page .card-title{margin-bottom:1.5rem;font-size:24px;font-weight:300;letter-spacing:-.5px}
            .fm-login-page .form-control{border-width:2.3px}
            .fm-login-page .form-group label{width:100%}
            .fm-login-page .btn.btn-block{padding:12px 10px}
            .fm-login-page .footer{margin:40px 0;color:#888;text-align:center}
            @media screen and (max-width: 425px) {
                .fm-login-page .card-wrapper{width:90%;margin:0 auto}
            }
            @media screen and (max-width: 320px) {
                .fm-login-page .card.fat{padding:0}
                .fm-login-page .card.fat .card-body{padding:15px}
            }
            .message{padding:4px 7px;border:1px solid #ddd;background-color:#fff}
            .message.ok{border-color:green;color:green}
            .message.error{border-color:red;color:red}
            .message.alert{border-color:orange;color:orange}
        </style>
    </head>
    <body class="fm-login-page">
    <div id="wrapper" class="container-fluid">

    <?php
}
