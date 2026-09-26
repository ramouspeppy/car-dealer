<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->meta_title ?: $landingPage->headline }}</title>
    <!-- FULL BLADE: please copy from artifacts/landing-v3/views/show-v3.blade.php -->
    <meta name="x-note" content="placeholder-pending-full-upload">
</head>
<body>
<p>Landing Page V3 — full template is in the repo artifacts. Controller and route are ready.</p>
<p><a href="{{ route('landing.showV2') }}">V2</a></p>
</body>
</html>
