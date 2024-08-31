<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Brand | Campaign</title>
</head>
<body>
    <h1>{{ $subject }}</h1>

    @if (!empty($attachment))
        <p>Attachment: {{ $attachment }}</p>
    @endif

    <p>{{$Campmessages}}</p>
</body>
</html>
