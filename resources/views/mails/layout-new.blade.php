<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        /* FONTS */

        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }

        /* RESET STYLES */
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
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
            color: black;
            text-decoration: none;
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
        @media screen and (max-width:650px){
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: sans-serif, 'Times New Roman', Times, serif;
        }

        @media screen and (max-width:650px) {
            .wrapper {
                width: 100% !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] { margin: 0 !important; }
    </style>
</head>
<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td bgcolor="#ffffff" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="650" class="wrapper">
                <tr>
                    <td bgcolor="#ffffff" height="60"></td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff">
                        <img src="{{ $company->logo ? asset($company->logo) : asset('images/logo3.png') }}" width="200" alt="Propify"/>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" height="23"></td>
                </tr>
                <tr>
                    <td style="background-color: #ffffff; font-size: 18px;color: #878991;">
                        <h3 style="padding: 0; margin: 0">@lang('template.tenant_portal', [], $lang)</h3>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" height="23"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" >
            <table width="650" border="0" cellpadding="0" cellspacing="0" class="wrapper">
                <tr>
                    <td bgcolor="#ffffff"
                        align="center"
                        height="40"
                        valign="top"
                        style="
                          border-radius: 4px 4px 0px 0px;
                          color: #111111;
                          font-size: 48px; font-weight: 400;
                          letter-spacing: 4px;
                          line-height: 48px;
                          border-top: 1px solid rgba(0,0,0,0.05);
                          border-left: 1px solid rgba(0,0,0,0.05);
                          border-right: 1px solid rgba(0,0,0,0.05);
                          box-shadow: 5px 0 20px rgba(0,0,0,0.05), -5px 0 20px rgba(0,0,0,0.05), 0 -5px 20px rgba(0,0,0,0.05);
                          -moz-box-shadow: 5px 0 20px rgba(0,0,0,0.05), -5px 0 20px rgba(0,0,0,0.05), 0 -5px 20px rgba(0,0,0,0.05);
                          -webkit-box-shadow: 5px 0 20px rgba(0,0,0,0.05), -5px 0 20px rgba(0,0,0,0.05), 0 -5px 20px rgba(0,0,0,0.05);"
                    >
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#f4f4f4" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="650" class="wrapper" style="border-left: 1px solid rgba(0,0,0,0.05);border-right: 1px solid rgba(0,0,0,0.05);">
                <tbody><tr>
<td bgcolor="#ffffff">
            @yield('body')
                </td></tr>
                </tbody></table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0"  style="padding-bottom: 20px">
            <table border="0" width="650" class="wrapper">
                <tr>
                    <td bgcolor="#ffffff"
                        align="center"
                        valign="top"
                        height="40"
                        style="border-radius:  0px 0px 4px 4px;
                                border-bottom: 1px solid rgba(0,0,0,0.05);
                                border-left: 1px solid rgba(0,0,0,0.05);
                                border-right: 1px solid rgba(0,0,0,0.05);
                               box-shadow: 5px 0 20px rgba(0,0,0,0.05), -5px 0 20px rgba(0,0,0,0.05), 0 5px 20px rgba(0,0,0,0.05)"
                    >

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center">
            <table border="0" width="650"  cellpadding="0" cellspacing="0" class="wrapper">
                <tr>
                    <td bgcolor="#ffffff" align="center" style="color: grey; font-size: 12px; font-weight: 400; line-height: 25px;">
                        @lang('template.generated_email_for_user', ['userName' =>  $userName], $lang)
                    </td>
                </tr>
                <tr>
                    <td height="15"></td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="center" style="color: #000000; font-size: 14px; font-weight: 400; line-height: 1.3;padding: 0" >
                        <span style="padding: 0 10px">
                            @lang('template.generated_email_for_company', ['companyName' =>  $companyName], $lang)
                        </span>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" height="30"></td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="center" style="color: #000000; font-size: 18px; font-weight: 400; line-height: 25px;" >
                        <img src="http://dev.propify.ch/images/logo3.png?457809be3146f072c0b6f87bfea7cbf6" width="100" height="30" alt="Creating Email Magic" style="display: block;" />
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" height="10"></td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="center" style="color: #000000; font-size: 14px; font-weight: 400; line-height: 1;" >
                        Lange Gasse 8, 4052 Basel, Schweiz
                    </td>
                </tr>
                <tr>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="center" style="color: #000000; font-size: 14px; font-weight: 400; line-height: 25px;" >
                        @lang('template.links', [], $lang)
                    </td>
                </tr>
                <tr>
                    <td height="30"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
