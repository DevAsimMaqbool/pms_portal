<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>@yield('title')</title>

    <style>
        @page {
            margin: 8px 12px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9.5px;
            color: #2c3e50;
            line-height: 1.15;
        }

        /* REMOVE ALL EXTRA SPACE */
        div,
        table,
        tr,
        td,
        th {
            margin: 0;
            padding: 0;
        }

        /* SECTION TITLE (COMPACT BAR) */
        .section-title {
            background: #1f4e78;
            color: #fff;
            padding: 4px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: 4px 0;
        }

        /* TABLE CORE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* HEADER */
        th {
            background: #1f4e78;
            color: #fff;
            border: 1px solid #d0d7de;
            padding: 3px;
            font-size: 9px;
        }

        /* CELLS */
        td {
            border: 1px solid #d0d7de;
            padding: 3px;
            vertical-align: top;
            font-size: 9px;
        }

        /* INFO TABLE (LESS SPACE) */
        .info-table th {
            width: 18%;
            background: #f3f3f3;
            color: #000;
        }

        /* ROW GROUPING (SUBTLE ONLY) */
        .group-row {
            background: #f6f8fa;
            font-weight: bold;
        }

        /* BADGE SMALL */
        .badge {
            font-size: 8px;
            padding: 1px 3px;
            border: 1px solid #1f4e78;
            margin-right: 2px;
            display: inline-block;
        }

        /* PAGE BREAK */
        .page-break {
            page-break-after: always;
        }

        /* SIGNATURE COMPACT */
        .signature-line {
            margin: 25px auto 3px;
            width: 60%;
            border-top: 1px solid #000;
        }

        /* REMOVE DEFAULT HTML SPACING */
        p,
        h1,
        h2,
        h3 {
            margin: 0;
            padding: 0;
        }
    </style>

    @stack('style')
</head>

<body>

    @yield('content')

</body>

</html>