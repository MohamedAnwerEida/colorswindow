<!-- Footer Area -->
<div class="footer-area home-2">
    <div class="footer-static">
        <div class="container">
            <!-- Single Footer Static -->
            <div class="single-footer-static">
                <div class="block-subscribe">
                    <div class="footer-static-title">
                        <h3>القائمه البريدية</h3>
                    </div>
                    <div class="subscribe-form">
                        <form action="https://colorswindow.us7.list-manage.com/subscribe/post-json?u=7856f658e9e638a51bce1fea6&amp;id=0365c9187f&c=?" method="get" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"  novalidate>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="subscribe-input-box">
                                        <input type="email" value="" title="Sign up for our newsletter" name="EMAIL" class="required email" id="mce-EMAIL">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="subscribe-action" >
                                        <button title="Subscribe" name="subscribe" class="subscribe" type="submit">الاشتراك</button>
                                    </div>
                                </div>
                            </div>
                            <?php /*
                              <div class="col-md-12" style=" overflow: hidden">
                              <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_7856f658e9e638a51bce1fea6_0365c9187f" tabindex="-1" value=""></div>
                              </div>
                             *
                             */ ?>
                        </form>
                        <div id="subscribe-result"></div>
                    </div>
                </div>
                <div class="social-footer">
                    <ul class="link-follow">
                        @foreach($social as $item)
                        <li class="first">
                            <a target="_blank" href="<?= $item->link ?>" class="<?= $item->icon ?>"></a>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="single-footer-static">
                <div class="footer-static-title">
                    <h3>خدمة العملاء</h3>
                </div>
                <div class="footer-static-content">
                    <ul>
                        <li><a href="{{ url('return')}}">سياسة الإرجاع</a></li>
                        <li><a href="{{ url('profile')}}">اعدادت الحساب</a></li>
                        <li><a href="{{ url('cart')}}">عربة التسوق</a></li>
                    </ul>
                </div>
            </div><!-- End Single Footer Static -->
            <!-- Single Footer Static -->
            <div class="single-footer-static static-shipping">
                <div class="footer-static-title">
                    <h3>عن نافذة الألوان</h3>
                </div>
                <div class="footer-static-content">
                    <ul>
                        <li><a href="{{ url('about')}}">من نحن</a></li>
                        <li><a href="{{ url('term-condtion')}}">الشروط والقوانين</a></li>
                        <li><a href="{{ url('privacy-policy')}}">سياسة الخصوصية</a></li>
                        <li><a href="{{ url('contact')}}">اتصل بنا</a></li>
                    </ul>
                </div>
            </div><!-- End Single Footer Static -->
            <!-- Single Footer Static -->
            <div class="single-footer-static static-contact">
                <div class="footer-static-title">
                    <h3>اتصل بنا</h3>
                </div>
                <div class="footer-static-content">
                    <div class="contact-info">
                        <p class="phone"><span style="direction: ltr;display: inline-block;">{{ $settings->contact_no}}</span></p>
                        <p class="email"><a href="mailto:{{ $settings->contact_email}}">{{ $settings->contact_email}}</a></p>
                        <p class="adress">{{ $settings->contact_address}}</p>
                    </div>
                </div>
            </div><!-- End Single Footer Static -->
            <div>
                <img src="{{ url('assets/site/images/footer-logo.png') }}" style="width: 100px;display: block;margin: auto;" alt=""/>
            </div>
        </div>
    </div><!-- End Footer Static -->
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="copyright">
                    <p>Copyright &copy; <a target="_blank" href="https://ideaswindow.com/">ideaswindow.com</a> All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div><!-- End Footer Bottom -->
</div><!-- End Footer Area -->
<!-- jquery
============================================ -->
<script src="{{url('assets/site/js/vendor/jquery-1.11.3.min.js')}}"></script>
<script src="{{url('assets/site/vendor/jqueryui/jquery-ui.js')}}"></script>

<!-- bootstrap JS
============================================ -->
<script src="{{url('assets/site/js/bootstrap.min.js')}}"></script>
<!-- nivo slider js
============================================ -->
<script src="{{url('assets/site/js/jquery.nivo.slider.pack.js')}}"></script>
<!-- Mean Menu js
============================================ -->
<script src="{{url('assets/site/js/jquery.meanmenu.min.js')}}"></script>
<!-- price-slider JS
============================================ -->
<script src="{{url('assets/site/js/jquery-price-slider.js')}}"></script>
<!-- Simple Lence JS
============================================ -->
<script type="text/javascript" src="{{url('assets/site/js/jquery.simpleGallery.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/site/js/jquery.simpleLens.min.js')}}"></script>
<!-- owl.carousel JS
============================================ -->
<script src="{{url('assets/site/js/owl.carousel.min.js')}}"></script>
<!-- scrollUp JS
============================================ -->
<script src="{{url('assets/site/js/jquery.scrollUp.min.js')}}"></script>
<!-- DB Click JS
============================================ -->
<script src="{{url('assets/site/js/dbclick.min.js')}}"></script>
<!-- Countdown JS
============================================ -->
<script src="{{url('assets/site/js/jquery.countdown.min.js')}}"></script>
<!-- plugins JS
============================================ -->
<script src="{{url('assets/site/js/plugins.js')}}"></script>
<!-- main JS
============================================ -->
<script src="{{url('assets/site/js/main.js')}}"></script>
@yield('javascript')
<script>

$(document).ready(function () {
    var $form = $('#mc-embedded-subscribe-form')
    if ($form.length > 0) {
        $('form .subscribe').bind('click', function (event) {
            if (event)
                event.preventDefault()
            register($form)
        })
    }
})

function register($form) {
    $('.subscribe').val('Sending...');
    $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize(),
        cache: false,
        dataType: 'json',
        contentType: 'application/json; charset=utf-8',
        error: function (err) {
            alert('Could not connect to the registration server. Please try again later.')
        },
        success: function (data) {
            $('.subscribe').val('subscribe')
            if (data.result === 'success') {
                // Yeahhhh Success
                console.log(data.msg)
                $('#mce-EMAIL').css('borderColor', '#ffffff')
                $('#subscribe-result').css('color', 'rgb(53, 114, 210)')
                $('#subscribe-result').html('<p>Thank you for subscribing. We have sent you a confirmation email.</p>')
                $('#mce-EMAIL').val('')
            } else {
                // Something went wrong, do something to notify the user.
                console.log(data.msg)
                $('#mce-EMAIL').css('borderColor', '#ff8282')
                $('#subscribe-result').css('color', '#ff8282')
                $('#subscribe-result').html('<p>' + data.msg.substring(4) + '</p>')
            }
        }
    })
}
;
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133192569-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag() {
    dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', 'UA-133192569-1');
</script>

<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/5d6535fa77aa790be330fce4/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
