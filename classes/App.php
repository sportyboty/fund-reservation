<?php

namespace MerryPayout;

require_once "TokenGenerator.php";

/**
 * Class App
 * @package KikShare
 * @author Asiegbu Stanley
 * Description: Class that contains static functions that may be reused throughout the application
 *
 */
class App extends Queryable {

    public function sendVerificationToken(string $email, string $userId) {

        // generate token
        $token = TokenGenerator::generateToken();
        $this->dm->saveToken($userId, $token);

        $mail = new \PHPMailer(true);
        $mail->CharSet = 'utf-8';
        ini_set('default_charset', 'UTF-8');
        $to = $email;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "smtp.postmarkapp.com";
        $mail->Port = "587";
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->Username = "8516fe84-0455-4d62-a173-966798d908eb";
        $mail->Password = "8516fe84-0455-4d62-a173-966798d908eb";
        $mail->addReplyTo("support@merrypayout.com", "Merry Payout");
        $mail->setFrom("support@merrypayout.com", "Merry Payout");
        $mail->addAddress($to);
        $mail->Subject = "Welcome To MerryPayout";
        $mail->isHTML(true);
        $body = " <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>
    <title>MerryPayout Welcome Email</title>
    <!-- Designed by https://github.com/kaytcat -->
    <!-- Robot header image designed by Freepik.com -->

    <style type=\"text/css\">
        @import url(http://fonts.googleapis.com/css?family=Droid+Sans);

        /* Take care of image borders and formatting */

        img {
            max-width: 600px;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a {
            text-decoration: none;
            border: 0;
            outline: none;
            color: #bbbbbb;
        }

        a img {
            border: none;
        }

        /* General styling */

        td, h1, h2, h3 {
            font-family: Helvetica, Arial, sans-serif;
            font-weight: 400;
        }

        td {
            text-align: center;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100%;
            height: 100%;
            color: #37302d;
            background: #ffffff;
            font-size: 16px;
        }

        table {
            border-collapse: collapse !important;
        }

        .headline {
            color: #ffffff;
            font-size: 36px;
        }

        .force-full-width {
            width: 100% !important;
        }


    </style>

    <style type=\"text/css\" media=\"screen\">
        @media screen {
            /*Thanks Outlook 2013! http://goo.gl/XLxpyl*/
            td, h1, h2, h3 {
                font-family: 'Droid Sans', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
            }
        }
    </style>

    <style type=\"text/css\" media=\"only screen and (max-width: 480px)\">
        /* Mobile styles */
        @media only screen and (max-width: 480px) {

            table[class=\"w320\"] {
                width: 320px !important;
            }

        }
    </style>
</head>
<body class=\"body\" style=\"padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none\"
      bgcolor=\"#ffffff\">
<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" height=\"100%\">
    <tr>
        <td align=\"center\" valign=\"top\" bgcolor=\"#ffffff\" width=\"100%\">
            <center>
                <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"w320\">
                    <tr>
                        <td align=\"center\" valign=\"top\">

                            <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"
                                   style=\"margin:0 auto;\">
                                <tr>
                                    <td style=\"font-size: 30px; text-align:center;\">
                                        <br>
                                        MerryPayout
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>

                            <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"
                                   bgcolor=\"#4dbfbf\">
                                <tr>
                                    <td>
                                        <br>
                                        <img src=\"https://www.filepicker.io/api/file/Pv8CShvQHeBXdhYu9aQE\" width=\"216\"
                                             height=\"189\" alt=\"robot picture\">
                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"headline\">
                                        Welcome!
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                        <center>
                                            <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" width=\"60%\">
                                                <tr>
                                                    <td style=\"color:#187272;\">
                                                        <br>
                                                        You are highly welcome to MerryPayout, We look forward to a
                                                        long and successful partnership together.
                                                        Please Click activate button to continue.
                                                        <br>
                                                        <br>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div><!--[if mso]>
                                            <v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\"
                                                         xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://\"
                                                         style=\"height:50px;v-text-anchor:middle;width:200px;\"
                                                         arcsize=\"8%\" stroke=\"f\" fillcolor=\"#178f8f\">
                                                <w:anchorlock/>
                                                <center>
                                            <![endif]-->
                                            <a href=\"http://merrypayout.com/verify_email?tk=$token&uid=$userId\"
                                               style=\"background-color:#178f8f;border-radius:4px;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:50px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;\">Activate
                                                Account!</a>
                                            <!--[if mso]>
                                            </center>
                                            </v:roundrect>
                                            <![endif]--></div>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>

                            <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" class=\"force-full-width\"
                                   bgcolor=\"#414141\" style=\"margin: 0 auto\">
                                <tr>
                                    <td style=\"background-color:#414141;\">
                                        <br>
                                        <br>
                                        <img src=\"https://www.filepicker.io/api/file/R4VBTe2UQeGdAlM7KDc4\"
                                             alt=\"google+\">
                                        <img src=\"https://www.filepicker.io/api/file/cvmSPOdlRaWQZnKFnBGt\"
                                             alt=\"facebook\">
                                        <img src=\"https://www.filepicker.io/api/file/Gvu32apSQDqLMb40pvYe\"
                                             alt=\"twitter\">
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"color:#bbbbbb; font-size:12px;\">
                                        <a href=\"#\">View in browser</a> | <a href=\"#\">Unsubscribe</a> | <a href=\"#\">Contact</a>
                                        <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"color:#bbbbbb; font-size:12px;\">
                                        © 2017 All Rights Reserved
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>


                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>
</html>";
        $mail->WordWrap = 78;
        $mail->msgHTML($body, dirname(__FILE__), true);
        $mail->send();


    }

    public function sendReceiverConfirmationToken($email, $receiverUsername, $token, $payerName,
                                                  $payerUsername) {
        $mail = new \PHPMailer(true);
        $mail->CharSet = 'utf-8';
        ini_set('default_charset', 'UTF-8');
        $to = $email;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "smtp.postmarkapp.com";
        $mail->Port = "587";
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->Username = "8516fe84-0455-4d62-a173-966798d908eb";
        $mail->Password = "8516fe84-0455-4d62-a173-966798d908eb";
        $mail->addReplyTo("support@merrypayout.com", "Merry Payout");
        $mail->setFrom("support@merrypayout.com", "Merry Payout");
        $mail->addAddress($to);
        $mail->Subject = "MerryPayout Payment Confirmation Token";
        $mail->isHTML(true);
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />
    <title>Receiver Confirmation Token</title>
    <style type=\"text/css\" media=\"screen\">

        /* Force Hotmail to display emails at full width */
        .ExternalClass {
            display: block !important;
            width: 100%;
        }

        /* Force Hotmail to display normal line spacing */
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        body,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }

        body,
        p,
        td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            color: #333333;
            line-height: 1.5em;
        }

        h1 {
            font-size: 24px;
            font-weight: normal;
            line-height: 24px;
        }

        body,
        p {
            margin-bottom: 0;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }

        img {
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        .background {
            background-color: #333333;
        }

        table.background {
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        .block-img {
            display: block;
            line-height: 0;
        }

        a {
            color: white;
            text-decoration: none;
        }

        a,
        a:link {
            color: #2A5DB0;
            text-decoration: underline;
        }

        table td {
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            text-align: left;
        }

        .wrap {
            width: 600px;
        }

        .wrap-cell {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .header-cell,
        .body-cell,
        .footer-cell {
            padding-left: 20px;
            padding-right: 20px;
        }

        .header-cell {
            background-color: #eeeeee;
            font-size: 24px;
            color: #ffffff;
        }

        .body-cell {
            background-color: #ffffff;
            padding-top: 30px;
            padding-bottom: 34px;
        }

        .footer-cell {
            background-color: #eeeeee;
            text-align: center;
            font-size: 13px;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .card {
            width: 400px;
            margin: 0 auto;
        }

        .data-heading {
            text-align: right;
            padding: 10px;
            background-color: #ffffff;
            font-weight: bold;
        }

        .data-value {
            text-align: left;
            padding: 10px;
            background-color: #ffffff;
        }

        .force-full-width {
            width: 100% !important;
        }

    </style>
    <style type=\"text/css\" media=\"only screen and (max-width: 600px)\">
        @media only screen and (max-width: 600px) {
            body[class*=\"background\"],
            table[class*=\"background\"],
            td[class*=\"background\"] {
                background: #eeeeee !important;
            }

            table[class=\"card\"] {
                width: auto !important;
            }

            td[class=\"data-heading\"],
            td[class=\"data-value\"] {
                display: block !important;
            }

            td[class=\"data-heading\"] {
                text-align: left !important;
                padding: 10px 10px 0;
            }

            table[class=\"wrap\"] {
                width: 100% !important;
            }

            td[class=\"wrap-cell\"] {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
        }
    </style>
</head>

<body leftmargin=\"0\" marginwidth=\"0\" topmargin=\"0\" marginheight=\"0\" offset=\"0\" bgcolor=\"\" class=\"background\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\" class=\"background\">
    <tr>
        <td align=\"center\" valign=\"top\" width=\"100%\" class=\"background\">
            <center>
                <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"wrap\">
                    <tr>
                        <td valign=\"top\" class=\"wrap-cell\" style=\"padding-top:30px; padding-bottom:30px;\">
                            <table cellpadding=\"0\" cellspacing=\"0\" class=\"force-full-width\">
                                <tr>
                                    <td height=\"60\" valign=\"top\" style=\"color: green\">
                                    <span style=\"font-size: 18px; font-weight: bolder;\"> <span style=\"color:green\">MERRY</span><span
                                            style=\"color:whitesmoke\">PAYOUT</span></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign=\"top\" class=\"body-cell\">
                                        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#ffffff\">
                                            <tr>
                                                <td valign=\"top\" style=\"padding-bottom:20px; background-color:#ffffff;\">
                                                    Hi {$receiverUsername},<br><br>
                                                    Here is your confirmation token for your transaction.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#ffffff\">
                                                        <tr>
                                                            <td align=\"center\" style=\"padding:20px 0;\">
                                                                <center>
                                                                    <table cellspacing=\"0\" cellpadding=\"0\" class=\"card\">
                                                                        <tr>
                                                                            <td style=\"background-color:green; text-align:center; padding:10px; color:white; \">
                                                                                Transaction Details
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style=\"border:1px solid green;\">
                                                                                <table cellspacing=\"0\" cellpadding=\"20\" width=\"100%\">
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" bgcolor=\"#ffffff\">
                                                                                                <tr>
                                                                                                    <td width=\"150\" class=\"data-heading\">
                                                                                                        Payer Name:
                                                                                                    </td>
                                                                                                    <td class=\"data-value\">
                                                                                                        {$payerName}
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width=\"150\" class=\"data-heading\">
                                                                                                        Payer Username:
                                                                                                    </td>
                                                                                                    <td class=\"data-value\">
                                                                                                        {$payerUsername}
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width=\"150\" class=\"data-heading\">
                                                                                                        Confirmation
                                                                                                        Token:
                                                                                                    </td>
                                                                                                    <td class=\"data-value\">
                                                                                                        {$token}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=\"padding-top:20px;background-color:#ffffff;\">
                                                    Thank you!<br>
                                                    MerryPayout Team
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign=\"top\" class=\"footer-cell\">
                                        Merry Payout<br>
                                        All rights reserved.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>

</body>
</html>
";
        $mail->WordWrap = 78;
        $mail->msgHTML($body, dirname(__FILE__), true);
        $mail->send();
    }

    public function sendPasswordResetToken(string $email, string $userId) {
        $token = TokenGenerator::generateToken();
        $this->dm->savePasswordResetToken($userId, $token);

        $mail = new \PHPMailer(true);
        $mail->CharSet = 'utf-8';
        ini_set('default_charset', 'UTF-8');
        $to = $email;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "smtp.postmarkapp.com";
        $mail->Port = "587";
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->Username = "8516fe84-0455-4d62-a173-966798d908eb";
        $mail->Password = "8516fe84-0455-4d62-a173-966798d908eb";
        $mail->addReplyTo("support@merrypayout.com", "Merry Payout");
        $mail->setFrom("support@merrypayout.com", "Merry Payout");
        $mail->addAddress($to);
        $mail->Subject = "Merry Payout Reset Password";
        $mail->isHTML(true);
        $body = " <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>
    <title>MerryPayout Password Reset</title>
    <!-- Designed by https://github.com/kaytcat -->
    <!-- Robot header image designed by Freepik.com -->

    <style type=\"text/css\">
        @import url(http://fonts.googleapis.com/css?family=Droid+Sans);

        /* Take care of image borders and formatting */

        img {
            max-width: 600px;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a {
            text-decoration: none;
            border: 0;
            outline: none;
            color: #bbbbbb;
        }

        a img {
            border: none;
        }

        /* General styling */

        td, h1, h2, h3 {
            font-family: Helvetica, Arial, sans-serif;
            font-weight: 400;
        }

        td {
            text-align: center;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100%;
            height: 100%;
            color: #37302d;
            background: #ffffff;
            font-size: 16px;
        }

        table {
            border-collapse: collapse !important;
        }

        .headline {
            color: #ffffff;
            font-size: 36px;
        }

        .force-full-width {
            width: 100% !important;
        }


    </style>

    <style type=\"text/css\" media=\"screen\">
        @media screen {
            /*Thanks Outlook 2013! http://goo.gl/XLxpyl*/
            td, h1, h2, h3 {
                font-family: 'Droid Sans', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
            }
        }
    </style>

    <style type=\"text/css\" media=\"only screen and (max-width: 480px)\">
        /* Mobile styles */
        @media only screen and (max-width: 480px) {

            table[class=\"w320\"] {
                width: 320px !important;
            }

        }
    </style>
</head>
<body class=\"body\" style=\"padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none\"
      bgcolor=\"#ffffff\">
<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" height=\"100%\">
    <tr>
        <td align=\"center\" valign=\"top\" bgcolor=\"#ffffff\" width=\"100%\">
            <center>
                <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"w320\">
                    <tr>
                        <td align=\"center\" valign=\"top\">

                            <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"
                                   style=\"margin:0 auto;\">
                                <tr>
                                    <td style=\"font-size: 30px; text-align:center;\">
                                        <br>
                                        MerryPayout
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>

                            <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"
                                   bgcolor=\"#4dbfbf\">
                                <tr>
                                    <td>
                                        <br>
                                        <img src=\"https://www.filepicker.io/api/file/Pv8CShvQHeBXdhYu9aQE\" width=\"216\"
                                             height=\"189\" alt=\"robot picture\">
                                    </td>
                                </tr>
                                <tr>
                                    <td class=\"headline\">
                                        Forgot Password
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                        <center>
                                            <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" width=\"60%\">
                                                <tr>
                                                    <td style=\"color:#187272;\">
                                                        <br>
                                                        You have requested to reset your password. 
                                                        Please click on the button to continue.
                                                        <br>
                                                        <br>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div><!--[if mso]>
                                            <v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\"
                                                         xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://\"
                                                         style=\"height:50px;v-text-anchor:middle;width:200px;\"
                                                         arcsize=\"8%\" stroke=\"f\" fillcolor=\"#178f8f\">
                                                <w:anchorlock/>
                                                <center>
                                            <![endif]-->
                                            <a href=\"https://merrypayout.com/reset_password?tk=$token&uid=$userId\"
                                               style=\"background-color:#178f8f;border-radius:4px;color:#ffffff;
                                               display:inline-block;font-family:Helvetica, Arial, sans-serif;
                                               font-size:16px;font-weight:bold;line-height:50px;text-align:center;
                                               text-decoration:none;width:200px;-webkit-text-size-adjust:none;\">Reset
                                                Password</a>
                                            <!--[if mso]>
                                            </center>
                                            </v:roundrect>
                                            <![endif]--></div>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>

                            <table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" class=\"force-full-width\"
                                   bgcolor=\"#414141\" style=\"margin: 0 auto\">
                                <tr>
                                    <td style=\"background-color:#414141;\">
                                        <br>
                                        <br>
                                        <img src=\"https://www.filepicker.io/api/file/R4VBTe2UQeGdAlM7KDc4\"
                                             alt=\"google+\">
                                        <img src=\"https://www.filepicker.io/api/file/cvmSPOdlRaWQZnKFnBGt\"
                                             alt=\"facebook\">
                                        <img src=\"https://www.filepicker.io/api/file/Gvu32apSQDqLMb40pvYe\"
                                             alt=\"twitter\">
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"color:#bbbbbb; font-size:12px;\">
                                        <a href=\"#\">View in browser</a> | <a href=\"#\">Unsubscribe</a> | <a href=\"#\">Contact</a>
                                        <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"color:#bbbbbb; font-size:12px;\">
                                        © 2017 All Rights Reserved
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>


                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>
</html>";
        $mail->WordWrap = 78;
        $mail->msgHTML($body, dirname(__FILE__), true);
        $mail->send();
    }

    public function deleteAllExpiredTransactions() {

        foreach ($this->dm->getAllReceivers() as $receiverId)
        {
            $receiver = new Receiver($receiverId);
            $allExpiredPayers = $receiver->getAllExpiredPayers();
            foreach ($allExpiredPayers as $expiredPayer) {
                $payer = new Payer($expiredPayer);
                $payer->endTransaction();
                $payer->deactivate();
            }
        }
    }

    public function deactivateAllExpiredPayers() {
        $this->dm->deactivateAllExpiredPayers();
    }

    public function isRegisteredUser($userId) {
        return $this->dm->isRegisteredUser($userId);
    }

    public function verifyToken($userId, $token) {
        return $this->dm->verifyToken($userId, $token);
    }

    public function activateUser($userId) {
        $this->dm->activateUser($userId);
    }

    public function deleteToken($userId) {
        $this->dm->deleteToken($userId);
    }

    public function deactivateUser($userId) {
        $this->dm->deactivateUser($userId);
    }


}