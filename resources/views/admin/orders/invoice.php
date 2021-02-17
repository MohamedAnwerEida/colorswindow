<html>
    <head>
        <style>
            @page {margin-top: 3.0cm;margin-footer:1.0cm;odd-header-name:html_myHeader;odd-footer-name: html_myFooter;}
            body{ margin: 0;padding: 0;}
            .table td{ text-align: right}
            .table th{ text-align: center}

            .banner img{ width: 100%;}
            table,h1,p,h2{ direction: rtl;}
            table{ width: 100%;border-collapse: collapse;}
            th,td {
                text-align: center;
                padding: 5px;
            }
            div,span,h4,p{
                font-size: 11px;
                color:#555555;
            }
            table th, table td {
                font-size: 11px;
                color:#555555;
                padding: 5px;
                background: #fff;
                text-align: center;
            }
            table th {
                border-bottom: 1px solid #93014a;
                background-color:#f1f2f2;
            }
            table th.no {
                border-bottom: none;
                background-color:transparent;
            }
            table th.yes {
                border-bottom: 1px solid #e8e9e9;
                background-color:transparent;
                color: #93014a;
            }
            table td {
                border-bottom: 1px solid #e8e9e9;
            }
            table.no-border tr td{
                border-bottom: none;
                text-align: right;
            }
        </style>
    </style>
</head>
<body>
<htmlpageheader name="myHeader" >
    <table width="100%" style="border:none">
        <tr style="border:none">
            <td width="33%"  align="right" style="border:none">
                <img src="<?= url("assets/site/img/right-logo.png") ?>" height="70">
                <p>الرقم الضريبي :<span>30115475840003</span></p>
            </td>
            <td  align="center" style="border:none">&nbsp;</td>
            <td width="33%" align="left" style="border:none">
                <img  src="<?= url("assets/site/img/logo.png") ?>" height="70">
            </td>
        </tr>
    </table>
</htmlpageheader>
<htmlpagefooter name="myFooter" >
    <table width="100%" style="border:none">
        <tr>
            <td width="33%" align="right" style="border:none">
                <br/>
                <br/>
                <a style="color: #93014a;text-decoration: none;" href="">wwww.colorswindow.com</a>
            </td>
            <td width="33%" align="center" style="border:none">{PAGENO}&nbsp; من &nbsp;{nbpg}</td>
            <td width="33%" align="left" style="border:none">
                <p>
                    kingdom of saudi arabia
                    <br>
                    P.O.BOX 3048 Riyadh 12434
                    <br>
                    Tel. <?= $settings->contact_no ?>
                    <br>
                    CR 1010417723 CC 76446
                </p>
            </td>
        </tr>
    </table>
</htmlpagefooter>
<table width="100%" border="0" cellspacing="0" cellpadding="0" dir="rtl">
    <tr>
        <td width="40%" align="right" style="border-bottom:none">
            <table border="0" cellspacing="0" cellpadding="0" dir="rtl">
                <tbody>
                    <tr><th colspan="2" class="no">&nbsp;</th></tr>
                    <tr><th colspan="2">تفاصيل الطلب</th></tr>
                    <tr><td>رقم الطلب</td><td><?= $order->id ?></td></tr>
                    <tr><td>الاسم</td><td><?= $order->name ?></td></tr>
                    <tr><td>تاريخ وقت الطلب</td><td dir="ltr"><?= $order->created_at ?></td></tr>
                    <tr><td>البريد الالكتروني</td><td><?= $order->email ?></td></tr>
                    <tr><td>الهاتف</td><td><?= $order->telephone ?></td></tr>
                    <tr><td>المبلغ الكلي</td><td><?= $order->total ?> ريال</td></tr>
                    <?php if ($order->notes != '') { ?>
                        <tr><td>ملاحظات</td><td><?= $order->notes ?></td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </td>
        <td style="border-bottom:none">&nbsp;</td>
        <td width="40%" align="right" style="border-bottom:none">
            <table border="0" cellspacing="0" cellpadding="0" dir="rtl">
                <tbody>
                    <tr>
                        <th colspan="2" class="no">
                            <h1>
                                <span style="color:#93014a;font-size: 32px;">
                                    فاتورة
                                </span>
                                <br>
                                <span style="font-size:22px; color: #555555;">
                                    طلب (<?= $order->id ?>)
                                </span>
                            </h1>
                            <br>
                            <br>
                        </th>
                    </tr>
                    <tr><th colspan="2">بيانات الشحن</th></tr>
                    <tr><td>الحي</td><td><?= $order->neighborhood ?></td></tr>
                    <tr><td>الشارع</td><td><?= $order->street ?></td></tr>
                    <tr><td>المنزل</td><td><?= $order->building ?></td></tr>
                </tbody>
            </table>
        </td>

    </tr>
</table>

<h1></h1>
<table class="col-md-12" dir="rtl">
    <thead>
        <tr>
            <th colspan="6">منتجات الطلب</th>
        </tr>
        <tr>
            <th class="yes">#</th>
            <th class="yes">المنتج</th>
            <th class="yes">التفاصيل</th>
            <th class="yes">السعر</th>
            <th class="yes">الكمية</th>
            <th class="yes">المجموع</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $sub_total = 0; ?>
        <?php foreach ($order->items as $item): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td  width="30%">
                    <b>
                        <?php
                        $product = get_product($item->name);
                        if ($product)
                            echo $product->name_ar;
                        else
                            echo 'تم حذف المنتج';
                        ?>
                    </b>
                </td>
                <td width="30%" style="text-align: right">
                    <?php $item_specs = json_decode($item->spec) ?>
                    <?php if ($item_specs): ?>
                        <?php foreach ($item_specs as $key => $value): ?>
                            <?php $specs = get_specs($key, $value); ?>
                            <?php if ($specs) { ?>
                                <b><?= $specs->catspectype->name ?></b>:<?= $specs->name ?><br>
                            <?php } ?>
                        <?php endforeach ?>
                    <?php endif ?>
                    <b>تفاصيل التصميم</b>:<?= $item->design_data ?>
                </td>
                <td><?= round($item->price / $item->quantity, 1) ?> ريال</td>
                <td><?= $item->quantity ?></td>
                <td><?= $item->price ?> ريال</td>
            </tr>
            <?php $sub_total += $item->price ?>
        <?php endforeach ?>
        <tr >
            <td colspan="6" style=" border-bottom: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6" style=" border-bottom: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6" style=" border-bottom: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style=" border-bottom: none;"></td>
            <td colspan="3" style=" border-bottom: none;">
                <table>
                    <tr>
                            <td> المجموع: </td>
                            <td><?= number_format($sub_total , 2)  ?> ريال</td>
                        </tr>
                    <?php $urgent = 0; if ($order->urgent != 0) { ?>
                        <tr>
                            <td>طلب مستعجل</td>
                            <td><?= number_format($sub_total * 0.5 , 2) ?> ريال</td>
                        </tr>
                    <?php  $urgent = number_format($sub_total * 0.5 , 2);} ?>
                    <?php $pay_value = 0; if ($order->pay_value != 0) { ?>
                        <tr>
                            <td>رسوم الدفع عند الاستلام</td>
                            <td><?= number_format($order->pay_value, 2) ?> ريال</td>
                        </tr>
                    <?php $pay_value = number_format($order->pay_value, 2)  ;} ?>
                    <?php $discount = 0; if ($order->discount != 0) { ?>
                        <tr>
                            <td>خصم</td>
                            <td><?= number_format($order->discount, 2) ?> ريال</td>
                        </tr>
                    <?php $discount = number_format($order->discount, 2) ;} ?>
                    <?php $tax = 0; if ($order->tax != 0) { ?>
                        <tr>
                            <td>الضريبة</td>
                            <?php
                                                $tax_persent = App\Models\Settings::first()->tax/100;
                                                $total_befor_tax = intval($sub_total) + intval($pay_value) + intval($urgent)   ;

                                                $tax = number_format($total_befor_tax * $tax_persent, 2);
                                                ?>
                            <td><?= $tax ?> ريال</td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="background-color: #f1f2f2; border-bottom: 1px solid #cc3399;">المجموع الكلي</td>
                         <?php
                                                $total = number_format($tax + $sub_total + $pay_value + $urgent - $discount , 2) ;
                                                ?>
                        <td style=" text-align: center;color:#cc3399;background-color: #f1f2f2; border-bottom: 1px solid #cc3399;"><?= $total ?> ريال</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
