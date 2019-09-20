<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <style type="text/css">
        /* FONTS */

        html, body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            color: #c55a9059 !important;
        }

        #a_link span:hover {
            color: #c55a9059 !important;
            text-decoration: none;
        }

        #a_button:hover {
            background-color: #c55a9059;
        }

        table tr td {
            padding-right: 30px;
            padding-left: 30px;
        }

        p {
            font-size: 16px;
        }

        p, h1, h2, h3, h4, h5, h6, span {
            padding: 0;
            margin: 0;
        }

        /* MOBILE STYLES */
        @media screen and (max-width: 726px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }

            h2 {
                font-size: 24px;
            }

            h3 {
                font-size: 18px;
            }

            h4 {
                font-size: 16px;
            }

            p {
                font-size: 15px;
            }
        }

        @media screen and (max-width: 440px) {
            table tr td {
                padding: 0;
            }

            .email-header {
                padding-left: 30px !important;
            }
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: sans-serif, 'Times New Roman', Times, serif;
        }

        @media screen and (max-width: 726px) {
            .wrapper {
                width: 100% !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>
<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;  mso-line-height-rule: exactly;" width="100%">
<center style="width: 100%; ">
    <div style="margin: 0 auto;" class="email-container">
        <table border="0" bordercolor="" cellpadding="0" cellspacing="0" width="100%" style="margin: auto">
            <tbody>
            <tr>
                <td align="center" style="background-color: {{$company->primary_color_lighter ?? '#c55a9059'}} ">
                    <div style="max-width: 650px; margin: 0 auto;" class="email-container">
                        <!--[if mso]>
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="650" align="center">
                            <tr>
                                <td>
                                    <![endif]-->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper">
                                        <tbody>
                                        <tr>
                                            <td bgcolor="transparent" height="60"></td>
                                        </tr>
                                        <tr>
                                            <td bgcolor="transparent">
                                                <img src="{{ $company->logo ? asset($company->logo) : asset('images/logo3.png') }}" width="200" alt="Propify" class="email-header">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor="transparent" height="23"></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: transparent; font-size: 18px;color: white;">
                                                <h3 style="padding: 0; margin: 0" class="email-header">@lang('template.tenant_portal', [], $lang)</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor="transparent" height="23"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]>
                               </td>
                            </tr>
                        </table>
                        <![endif]-->
                    </div>
                </td>
            </tr>
            <tr>
                <td style="background-color: {{$company->primary_color_lighter ?? '#c55a9059'}} " align="center">
                    <div style="max-width: 650px; margin: 0 auto;" class="email-container">
                        <!--[if mso]>
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="650" align="center">
                            <tr>
                                <td>
                                    <![endif]-->

                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper">
                                        <tbody>
                                            <tr>
                                                <td height="40" width="100%" bgcolor="#ffffff" style="border-radius: 4px 4px 0 0;"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]>
                                </td>
                            </tr>
                        </table>
                        <![endif]-->
                    </div>
                </td>
            </tr>
            <tr>
                <td bgcolor="#f4f4f4" align="center">
                    <div style="max-width: 650px; margin: 0 auto;" class="email-container">
                        <!--[if mso]>
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="650"
                               align="center">
                            <tr>
                                <td>
                                    <![endif]-->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper">
                                        <tbody>
                                            @yield('body')
                                        </tbody>
                                    </table>
                                    <!--[if mso]>
                                </td>
                            </tr>
                        </table>
                        <![endif]-->
                    </div>
                </td>
            </tr>
            <tr>
                <td bgcolor="#f4f4f4" align="center" cellpadding="0" cellspacing="0">
                    <div style="max-width: 650px; margin: 0 auto;" class="email-container">
                        <!--[if mso]>
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="650" align="center">
                            <tr>
                                <td>
                                    <![endif]-->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper">
                                        <tbody>
                                            <tr>
                                                <td height="40" width="100%" bgcolor="#ffffff" style="border-radius: 0 0 4px 4px;"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]>
                                </td>
                            </tr>
                        </table>
                        <![endif]-->
                    </div>
                </td>
            </tr>
            <tr>
                <td style="background-color: #f4f4f4 " align="center">
                    <div style="max-width: 650px; margin: 0 auto;" class="email-container">
                        <!--[if mso]>
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="650"
                               align="center">
                            <tr>
                                <td>
                        <![endif]-->
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" class="wrapper">
                            <tbody>
                            <tr>
                                <td height="20" bgcolor="transparent"></td>
                            </tr>
                            <tr>
                                <td bgcolor="transparent" align="center" style="color: grey; font-size: 12px; font-weight: 400; line-height: 25px;">
                                    @lang('template.generated_email_for_user', ['userName' =>  $userName], $lang)
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="transparent" height="15"></td>
                            </tr>
                            <tr>
                                <td bgcolor="transparent" align="center" style="color: #000000; font-size: 14px; font-weight: 400; line-height: 1.3;padding: 0 10px">
                                    <span>
                                        @lang('template.generated_email_for_company', ['companyName' =>  $companyName], $lang)
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="transparent" height="30"></td>
                            </tr>
                            <tr>
                                <td bgcolor="transparent" align="center" style="color: #000000; font-size: 18px; font-weight: 400; line-height: 25px;">
                                    <img src="http://dev.propify.ch/images/logo3.png?457809be3146f072c0b6f87bfea7cbf6" width="100" height="30" alt="Creating Email Magic" style="display: block;">
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="transparent" height="10"></td>
                            </tr>
                            <tr>
                                <td bgcolor="transparent" align="center"
                                    style="color: #000000; font-size: 14px; font-weight: 400; line-height: 1;">
                                    Lange Gasse 8, 4052 Basel, Schweiz
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                            <tr>
                                <td bgcolor="transparent" align="center" style="color: #000000; font-size: 14px; font-weight: 400; line-height: 25px;">
                                    {!! __('template.links', [], $lang) !!}
                                </td>
                            </tr>
                            <tr>
                                <td height="30"></td>
                            </tr>
                            </tbody>
                        </table>
                        <!--[if mso]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</center>


</body>

</body>
</html>

