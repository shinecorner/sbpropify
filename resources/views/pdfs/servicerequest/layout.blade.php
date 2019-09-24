<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>@yield('title')</title>
<style type="text/css" media="all">

    * {
        font-size: 14px;
        font-family: {{$re->pdf_font_family ?? 'arial'}};
    }
    body {
        padding-left: 42px;
        padding-right: 42px;
        padding-top: 25px;
    }
    img.logo {
        width: 181px;
        height:auto;
        margin-top:-15px;
    }

.data_table{width:100%;}
table.data_table th, table.data_table td {
    text-align: left;
    font-size:13px;
    font-family:{{$re->pdf_font_family ?? 'arial'}}
}
    table.data_table strong{font-size:13px;font-family:{{$re->pdf_font_family ?? 'arial'}}}
    .inner_table{width:100%;}
.inner_table td{padding:7px 0;}
    table.data_table td{border-top:1px solid #eee;}
    table{border:none;border-spacing:0;}

    table.data_table .table_header{border:none;padding:10px 0;}
    .info_table td, .info_table th{padding:7px 0;}
    .no_border{border-top:none!important}
    .border_btm{border-bottom:1px solid #eee;}
    .data_table h4{padding:0;margin-bottom:-10px;}
</style>
</head>

<body>
@yield('body')
</body>

</html>
