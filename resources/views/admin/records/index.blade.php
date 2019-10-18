<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Records (Admin)</title>
</head>
<body>
        @extends("layouts.template")
        @section('main')
    <h1>Records</h1>

<ul>
    @foreach ($records as $record)
    <li>{{ $record}}</li>
    @endforeach
</ul>
@endsection
</body>
</html>

