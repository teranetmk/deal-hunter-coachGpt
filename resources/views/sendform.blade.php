<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form method="post" enctype="multipart/form-data" action="{{url('send-voicemail')}}">
        @csrf
        <input type="text" name="caller_id" placeholder="caller_id">
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>
