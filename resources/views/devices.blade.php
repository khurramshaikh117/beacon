<!DOCTYPE html>
<html>
<head>
    <title>Zavi - Device Status</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #333;
            color: #fff;
        }
        .in {
            color: green;
            font-weight: bold;
        }
        .out {
            color: red;
            font-weight: bold;
        }
        .refresh {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<h2>📡 Zavi - Device Presence</h2>

<button class="refresh" onclick="location.reload()">🔄 Refresh</button>

<table>
    <thead>
        <tr>
            <th>UUID</th>
            <th>Status</th>
            <th>Last Seen</th>
        </tr>
    </thead>
    <tbody>
        @foreach($devices as $device)
            <tr>
                <td>{{ $device->uuid }}</td>
                <td class="{{ strtolower($device->status) }}">
                    {{ $device->status }}
                </td>
                <td>{{ $device->last_seen_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>