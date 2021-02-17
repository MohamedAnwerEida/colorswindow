<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>[لقد تم شحن السلعة]</title>
    </head>
    <body 
        <div style="margin: 0;direction: rtl;">
            <p>
                <a href="{{ url('/')}}"><img  src="{{url('assets/site/images/mail/logo.png')}}" alt="logo"></a>
            </p>
            <h1 style="line-height: 90px;text-align: right;border-bottom: 1px solid #cc3399;">طلب خاص </h1>
            <p><?= $name ?></p>
            <p><?= $email ?></p>
            <p><?= $request ?></p>

            <h3 style="color: #a6a6a6;">
                بحاجة مساعدة؟ 
            </h3>
            <p>
                رضاك محط اهتمامنا، لا تتردد في التواصل معنا على الايميل <a href="mail:info@colorswindow.com" class="mail">info@colorswindow.com</a> او الرقم <span class="tel" style=" direction: ltr;display: inline-block;color: #cc3399;font-weight: bold;margin: 0 6px;">+966540262105</span> إذا كان لديك أية استفسار حول طلبك. 
            </p>
            <p>
                من دواعي سرور قسم خدمة العملاء تقديم المساعدة لك.
            </p>
            <div class="divder" style=" border-bottom: 1px solid #cc3399;margin: 20px 0;"></div>
            <div class="footer">
                <div class="socail-link" style=" text-align: center;">
                    <a href="https://www.facebook.com/colorswindow1"><img  style="Border: 1px solid #ddd;Border-radius: 50%;Padding: 10px;"  src="{{url('assets/site/images/mail/f.png')}}" alt="logo"></a>
                    <a href="https://twitter.com/colors_window"><img  style="border: 1px solid #ddd;border-radius: 50%;padding: 10px;"  src="{{url('assets/site/images/mail/t.png')}}" alt="logo"></a>
                    <a href="https://www.instagram.com/colors_window/"><img  style="border: 1px solid #ddd;border-radius: 50%;padding: 10px;"  src="{{url('assets/site/images/mail/i.png')}}" alt="logo"></a>
                </div>
                <p style="color: #939393; text-align: center;">
                    All rights reserved. Copyright © 2018 IdeasWindow.
                </p>
                <p style="text-align: center;">
                    <a style="color: #0000ff;" href="{{ url('privacy-policy')}}">Privacy Policy</a>  <span>|</span>  <a style="color: #0000ff;" href="{{ url('term-condtion')}}">Terms & Conditions</a> 
                </p>
            </div>
        </div>
    </body>
</html>
