<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>
    @yield('content')

    @if ($preview)
        @php
            $page = $page();
            $dpi = 1 / 25.4 * 96;

            $width = ($page->getWidth() * $dpi) . 'px';
            $height = ($page->getHeight() * $dpi) . 'px';
            $margins = array_map(fn ($value) => $value * $dpi  . 'px', $page->getMargins());
        @endphp

        <style>
            html {
                background-color: rgb(40 40 40);
                overflow-x: scroll;
                padding: 1em;
                width: 100vw;
                height: 100vh;
                box-sizing: border-box;
            }

            body {
                width: {{ $width }};
                min-height: {{ $height }};
                padding: {{ join(' ', $margins) }};
                overflow-x: hidden;
                margin: auto;

                background-color: #fff;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }
        </style>
   @endif
</body>
</html>
