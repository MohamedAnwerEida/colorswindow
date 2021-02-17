<div style="margin: 0;direction: rtl;">
    <p>
        <a href="{{ url('/')}}"><img  src="{{url('assets/site/images/mail/logo.png')}}" alt="logo"></a>
    </p>
    <h1 style="line-height: 90px;text-align: right;border-bottom: 1px solid #cc3399;">شكرا لتسوقك من نافذة الألوان! </h1>
    <p>مرحبا <b>{{ $order->name }}</b></p>
    <p>لقد تمت عملية شرائك بنجاح!</p>
    <div style="background-color: #f1f1f1; padding: 8px;">
        <h2 style="color:#515151">تفاصيل الطلب ({{ $order->id}})</h2>
        <table style="border-collapse: collapse; width: 65%">
            <?php $tto = 0; ?>
            @foreach($order->items as $item)
            <?php $product = get_product($item->name); ?>
            <tr style=" border-bottom: 1px solid #ddd;">
                <td style="background-color: #fff;padding:6px 0px; width: 220px"><img src="<?= url($product->image); ?>" width="150" /></td>
                <td style="background-color: #fff;color:#cc3399; text-align: right"><?= $product->name_ar; ?></td>
                <td style=" text-align: center">{{$item->price}} ريال</td>
            </tr>
            <?php $tto += $item->price ?>
            @endforeach
            @if($order->urgent!=0)
            <tr style=" border-bottom: 1px solid #ddd;">
                <td colspan="2" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">طلب مستعجل</td>
                <td style=" text-align: center;color:#cc3399;">{{$tto*0.5}} ريال</td>
            </tr>
            @endif
            @if($order->pay_value!=0)
            <tr style=" border-bottom: 1px solid #ddd;">
                <td colspan="2" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">رسوم الدفع عند الاستلام</td>
                <td style=" text-align: center;color:#cc3399;">{{$order->pay_value}} ريال</td>
            </tr>
            @endif
            @if($order->discount!=0)
            <tr style=" border-bottom: 1px solid #ddd;">
                <td colspan="2" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">خصم</td>
                <td style=" text-align: center;color:#cc3399;">{{$order->discount}} ريال</td>
            </tr>
            @endif
            @if($order->tax!=0)
            <tr style=" border-bottom: 1px solid #ddd;">
                <td colspan="2" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">الضريبة</td>
                <td style=" text-align: center;color:#cc3399;">{{$order->tax}} ريال</td>
            </tr>
            @endif
            <tr style=" border-bottom: 1px solid #ddd;">
                <td colspan="2" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">المجموع</td>
                <td style=" text-align: center;color:#cc3399;">{{$order->total }} ريال</td>
            </tr>
        </table>
        <br>
        <h2 style="background-color: #f1f1f1;line-height: 20px;text-align: right;color: #cc3399;margin: 5px 0px;">سيتم شحن طلبك الى:</h2>
    </div>
    <table style="border-collapse: collapse; width: 65%">
        <tr>
            <th style="padding: 5px;width: 150px;">الاسم:</th>
            <td style="padding: 5px;">{{$order->name}}</td>
        </tr>
        <tr>
            <th style="padding: 5px;">الهاتف:</th>
            <td style="padding: 5px;">{{$order->telephone}}</td>
        </tr>
        <tr>
            <th style="padding: 5px;">العنوان:</th>
            <td style="padding: 5px;">{{$order->neighborhood.' '.$order->street.' '.$order->building}}</td>
        </tr>
        <tr>
            <th style="padding: 5px;">الملاحظات:</th>
            <td style="padding: 5px;">{{$order->notes}}</td>
        </tr>
    </table>
    <h2 style="background-color: #f1f1f1;line-height:30px;text-align: right;color: #515151;">معلومات إضافية:</h2>
    <ul>
        <li>من المحتمل ان يتصل بك موظف الشحن هاتفياً للتأكد من العنوان أو وقت التسليم.</li>
        <li>تأكد من تواجدك في العنوان المشار له سابقاً لاستلام طلبك</li>
    </ul>

    <h3 style="color: #a6a6a6;">
        بحاجة مساعدة؟ 
    </h3>
    <p>
        رضاك محط اهتمامنا، لا تتردد في التواصل معنا على الايميل <a href="mail:info@colorswindow.com" class="mail">info@colorswindow.com</a> او الرقم <span class="tel" style=" direction: ltr;display: inline-block;color: #cc3399;font-weight: bold;margin: 0 6px;">+966 114067949</span> إذا كان لديك أية استفسار حول طلبك. 
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
