<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mail</title>
</head>

<body style="margin: 0;padding: 0;background-color: #EFF4FE;">
    <table width="100%" bgcolor="EFF4FE" border="0" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0;">
        <tr>
            <td align="center" style="background-color: #EFF4FE;padding-top: 25px;">
                <table cellpadding="0" cellspacing="0" style="width: 594px;border-radius: 30px;background-color: #fff;">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td
                                        style="padding-left: 24px;padding-top: 60px;width: 100%;">
                                        <a href="https://osnova.capital/"><img width="168" src="https://osnova.capital/mail/logo.png" alt="АГК Капитал"></a>
                                    </td>

                                    <td 
                                        style="font-family: Arial, Helvetica, sans-serif;font-size: 12px;padding-right: 24px;padding-top: 55px;">
                                        Аудиторско-<br>консалтинговая<br>группа
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>
                    <tr>
                        <td>
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td align="center" style="padding-top: 32px;padding-left: 24px;padding-right: 24px;">
                                        <img width="552" src="https://osnova.capital/mail/img.png" alt="АГК Капитал">
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>

                    <tr>
                        <td>
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td style="font-family: Arial, Helvetica, sans-serif;font-size: 20px;font-weight: bold; color: #292E42;padding-right: 24px;padding-left: 24px;padding-top: 32px;">
                                        Заявка на мероприятие принята
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>

                    <tr>
                        <td>
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;line-height: 150%; color: #292E42;padding-right: 24px;padding-left: 24px;padding-top: 24px;">
                                        Добрый день, <?php echo htmlspecialchars($name); ?>!
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>

                    <tr>
                        <td>
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;line-height: 150%; color: #292E42;padding-right: 24px;padding-left: 24px;padding-top: 12px;">
                                        Вы успешно зарегистрированы в качестве участника на мероприятие <br>
                                        <a href="<?php echo htmlspecialchars($event_link_page); ?>" style="color: #4235B8;"><?php echo htmlspecialchars($event_name); ?></a>.
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>

                    <tr>
                        <td>
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td style="font-family: Arial, Helvetica, sans-serif;font-size: 18px;font-weight: bold; color: #292E42;padding-right: 24px;padding-left: 24px;padding-top: 32px;padding-bottom: 16px;">
                                        Ждем вас:
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>

                    <tr>
                        <td>
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td style="padding-right: 24px;padding-left: 24px;padding-bottom: 16px;">
                                        <table cellspacing="0" style="width: 100%;">
                                            <tr>
                                                <td align="left" style="padding: 16px;background-color: #EFF4FE;border-radius: 12px;">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-right: 12px;padding-top: 8px;"><img src="https://osnova.capital/mail/time.png" alt=""></td>
                                                            <td>
                                                                <span style="font-family: Arial, Helvetica, sans-serif;color: #8C91A0;font-size: 14px;padding-bottom: 8px;">Дата и время</span><br>
                                                                <span style="font-family: Arial, Helvetica, sans-serif;color: #292E42;font-size: 16px;"><?php echo htmlspecialchars($event_time); ?></span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 24px;padding-left: 24px;">
                                        <table cellspacing="0" style="width: 100%;">
                                            <tr>
                                                <td align="left" style="padding: 16px;background-color: #EFF4FE;border-radius: 12px;">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-right: 12px;padding-top: 8px;"><img src="https://osnova.capital/mail/location.png" alt=""></td>
                                                            <td>
                                                                <span style="font-family: Arial, Helvetica, sans-serif;color: #8C91A0;font-size: 14px;padding-bottom: 8px;">Место проведения</span><br>
                                                                <span style="font-family: Arial, Helvetica, sans-serif;color: #292E42;font-size: 16px;"><?php echo htmlspecialchars($event_place); ?></span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>
                    <?php if(isset($event_link) && $event_link != '') { ?>
                    <tr>
                        <td>
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td style="padding: 32px 24px 24px;">
                                        <a href="<?php echo htmlspecialchars($event_link); ?>"><img width="552" src="https://osnova.capital/mail/btn.png" alt=""></a>
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <td>
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td style="padding: 32px 24px 24px; font-family: Arial, Helvetica, sans-serif;color: #292E42;font-size: 16px;">
                                        Ссылка на мероприятие будет сформирована позже и будеи выслана на данный электронный адрес.
                                    </td>
                                </tr>
                            </table>
                        </td>                        
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
        
        <tr>
            <td align="center" style="padding-top: 24px;">
                <table width="390px" cellpadding="0" style="margin-right: auto;margin-left: auto;">
                    <tr>
                        <td>
                            <a href="https://osnova.capital/o-kompanii/?utm_source=email&utm_medium=email&utm_campaign=menu" style="padding: 0 6px; color: #8C91A0;font-family: Arial, Helvetica, sans-serif;font-size: 14px;">О&nbsp;компании</a>
                        </td>
                        <td>
                            <a href="https://osnova.capital/otraslevye-resheniya/?utm_source=email&utm_medium=email&utm_campaign=menu" style="padding: 0 6px; color: #8C91A0;font-family: Arial, Helvetica, sans-serif;font-size: 14px;">Услуги</a>
                        </td>
                        <td>
                            <a href="https://osnova.capital/blog?utm_source=email&utm_medium=email&utm_campaign=menu" style="padding: 0 6px; color: #8C91A0;font-family: Arial, Helvetica, sans-serif;font-size: 14px;">Блог</a>
                        </td>
                        <td>
                            <a href="https://osnova.capital/meropriyatiya/?utm_source=email&utm_medium=email&utm_campaign=menu" style="padding: 0 6px; color: #8C91A0;font-family: Arial, Helvetica, sans-serif;font-size: 14px;">Мероприятия</a>
                        </td>
                        <td>
                            <a href="https://osnova.capital/kontakty?utm_source=email&utm_medium=email&utm_campaign=menu" style="padding: 0 6px; color: #8C91A0;font-family: Arial, Helvetica, sans-serif;font-size: 14px;">Контакты</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-top: 24px;">
                <table width="374px" cellpadding="0" style="margin-right: auto;margin-left: auto;">
                    <tr>
                        <td align="center" style="font-family: Arial, Helvetica, sans-serif;font-size: 14px;color: #8C91A0;">
                            Следите за новостями в соц сетях:
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-top: 24px;">
                <table width="160px" cellpadding="0" style="margin-right: auto;margin-left: auto;">
                    <tr>
                        <td align="center">
                            <a href="https://vk.com/agcapital"><img src="https://osnova.capital/mail/vk.png" alt=""></a>
                        </td>
                        <td align="center">
                            <a href="https://teleg.run/ekimovskih"><img src="https://osnova.capital/mail/tg.png" alt=""></a>
                        </td>
                        <td align="center">
                            <a href="https://zen.yandex.ru/osnova_capital"><img src="https://osnova.capital/mail/dzen.png" alt=""></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-top: 24px;padding-bottom: 32px;">
                <table width="600px" cellpadding="0" style="margin-right: auto;margin-left: auto;">
                    <tr>
                        <td align="center" style="font-family: Arial, Helvetica, sans-serif;font-size: 14px;color: #8C91A0;">
                            Вы получили данную рассылку, так как ваша почта была указана на сайте АКГ Капитал.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>