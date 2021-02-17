
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>تسجيل الدخول</title>
        <base href="{{ asset('/') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Color Windows" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/admin/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/admin/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/admin/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/admin/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="assets/admin/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/admin/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/admin/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/admin/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/admin/pages/css/login-2.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="assets/admin/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END HEAD -->
        <style>
            img.bg {
                min-height: 100%;
                width: 100%;
                height: auto;
                position: fixed;
                top: 0;
                left: 0;
            }
            .login .content {
                position: relative;
            }
            .social-icons li a.custom-soical-link {
                width: auto;
                height: auto;
                color: #000 !important;
                text-indent: 0;
                line-height: 28px;
            }
            .login .content .form-control {
                background-color: #961f8a;
                border: 1px solid #961f8a;
                color: #fff;
            }
        </style>
    </head>
    <body class="login">
        <img src="{{ url('assets/admin/pages/img/login/Login.png?v=3') }}" class="bg">
        <div class="logo">
            <img src="assets/admin/pages/img/login/logo.png" style="height: 17px;" alt="" />
        </div>
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="" method="post">
                <div class="form-title">
                    <span class="form-title"></span>
                    <span class="form-subtitle"></span>
                </div>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                    @error('username')
                                <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                            @enderror
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                    @error('password')
                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                            @enderror
                <div class="form-actions">
                    <button type="submit" class="btn red btn-block uppercase">Login</button>
                    {{ csrf_field() }}
                </div>
            </form>

            <!-- END LOGIN FORM -->


        </div>
        <div class="container-fluid">
            <div class="navbar-fixed-bottom">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-3">
                            <img src="{{ url('assets/admin/pages/img/login/ilogo.jpg?v=6') }}" alt=""  />
                        </div>
                        <div class="col-md-6" style="color: #8f8f91;">
                            <div class="row contact">
                                <div class="col-md-6">Kingdom of Saudi Arabia</div>
                                <div class="col-md-5">MOB +966 54 026 2105</div>
                                <div class="col-md-6"> Tel +966114752220</div>
                                <div class="col-md-6">MOB +966 54 026 2596</div>
                            </div>
                            <div style="text-align: center;font-size: 18px;font-weight: bold;">إحدى علامات نافذة الافكار للدعاية والاعلان</div>
                        </div>
                        <div class="col-md-3">
                            <ul class="social-icons">
                                <li>
                                    <a class="social-icon-color facebook" data-original-title="facebook" href="https://www.facebook.com/ideaswindow" target="_blank"></a>
                                </li>
                                <li>
                                    <a class="social-icon-color twitter" data-original-title="Twitter" href="https://twitter.com/Ideaswindow"  target="_blank"></a>
                                </li>
                                <li>
                                    <a class="social-icon-color instagram" data-original-title="instagram" href="https://instagram.com/ideaswindow/" target="_blank"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--[if lt IE 9]>
        <script src="assets/admin/global/plugins/respond.min.js"></script>
        <script src="assets/admin/global/plugins/excanvas.min.js"></script>
        <script src="assets/admin/global/plugins/ie8.fix.min.js"></script>
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="assets/admin/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/admin/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/admin/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/admin/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/admin/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/admin/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/admin/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/admin/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/admin/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="assets/admin/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/admin/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/admin/pages/scripts/login-5.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
$(document).ready(function ()
{
    $('#clickmewow').click(function ()
    {
        $('#radio1003').attr('checked', 'checked');
    });
})
        </script>
    </body>

</html>
