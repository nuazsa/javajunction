<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Hold</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        p {
            color: #777;
            margin-top: 20px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>There are no active Administrator</h1>
        <table>
            <tr>
                <th colspan="2">Opening Hours Information</th>
            </tr>
            <tr>
                <th>Monday-Friday</th>
                <th>Saturday-Sunday</th>
            </tr>
            <tr>
                <td>12.00 - 21.00</td>
                <td>12.00 - 23.00</td>
            </tr>
        </table>
        <p>Please contact the system administrator for further information.</p>
        <p><a href="menus.php">Back to Homepage</a></p>
    </div>
</body>
</html>
