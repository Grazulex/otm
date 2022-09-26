<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td><b>Show Name</b></td>
                <td><b>Series</b></td>
                <td><b>Lead Actor</b></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($plates as $plate)
                <tr>
                    <td>
                        {{ $plate->reference }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
