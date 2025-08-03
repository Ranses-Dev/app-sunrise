<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head class="h-full" title="Not Found">
    @include('partials.head')</head>

<body class="h-full bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    {{ $slot }}

</body>

</html>
