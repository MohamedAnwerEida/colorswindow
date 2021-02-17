<html>
    <head>
        <style>
            @page {margin-top: 5.0cm;margin-footer:1.0cm;odd-header-name:html_myHeader;odd-footer-name: html_myFooter;}
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
                    P.O.BOX 8531 Riyadh 12245
                    <br>
                    Tel. <?= $settings->contact_no ?>
                    <br>
                    CR 1010417723 CC 76446
                </p>
            </td>
        </tr>
    </table>
</htmlpagefooter>
<p>تحية طيبة وبعد...</p>
<p>يسرنا ان نرسل لكم عرضنا المالي حسب المواصفات التالية:</p>
<?php $total = 0 ?>
<?php if (count($items) > 0) { ?>
    <table class="col-md-12" dir="rtl">
        <thead>
            <tr>
                <th>#</th>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>التصميم</th>
                <th nowrap="">بيانات التصميم</th>
                <th nowrap="">مواصفات المنتج</th>
                <th>السعر</th>
        </thead>
        <tbody>
            <?php $loop = 1; ?>
            <?php foreach ($items as $k => $item) { ?>
                <tr>
                    <td><?= $loop++ ?></td>
                    <td><?= $item->title ?></td>
                    <td><?= $item->qty ?></td>
                    <td><?= property_exists($item, "desgin") ? $item->desgin : '-' ?></td>
                    <td><?= property_exists($item, "desgin_data") ? $item->desgin_data : '-' ?></td>
                    <td>
                        <?php foreach ($item->spec_data as $spec) { ?>
                            <?php if ($spec->spec_title) { ?>
                                <b><?= $spec->cat_title ?></b>:<?= $spec->spec_title ?><br>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td><?= $item->total_price*$item->qty ?> ريال</td>
                    <?php $total += $item->total_price*$item->qty ?>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="6">الضريبة  <?= $settings->tax ?> %</td>
                <td><?= round($settings->tax * $total / 100, 2) ?>  ريال</td>
            </tr>
            <tr>
                <td colspan="6">المجموع الكلي</td>
                <td><?= round($total + ($settings->tax * $total / 100), 2) ?>  ريال</td>
            </tr>
        </tbody>
    </table>
    <p>نأمل ان ينال العرض على رضاكم.</p>
    <p>ولأي استفسار أو معلومات اضافية يرجى عدم التردد بالتواصل معنا على الرقم
        <bdo dir="ltr"><?= $settings->contact_no ?></bdo></p>
<?php } else { ?>
    No Items
<?php } ?>
</body>
</html>
