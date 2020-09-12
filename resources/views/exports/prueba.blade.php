<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
    <thead>
	<tr>
	    @foreach($data[0] as $key => $value)
		<th>{{ ucfirst($key) }}</th>
	    @endforeach
    	</tr>
    </thead>
    <tbody>
    @foreach($data as $row)
    	<tr>
        @foreach ($row as $value)
    	    <td>{ $value }}</td>
        @endforeach
	</tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
