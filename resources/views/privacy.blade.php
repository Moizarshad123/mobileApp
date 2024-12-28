<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @php $policy = App\Models\Setting::find(1);@endphp
    <p>{!! $policy->privacy_policy !!}</p>
</body>
</html>