<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الطلبية</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">الطلبية </h2>

<table>
    <tr>
        <th>{{$order->id}}</th>
        <th>الاسم</th>
        <th>العمر</th>
    </tr>
    <tr>
        <td>1</td>
        <td>أحمد</td>
        <td>25</td>
    </tr>
    <tr>
        <td>2</td>
        <td>محمد</td>
        <td>30</td>
    </tr>
    <tr>
        <td>3</td>
        <td>علي</td>
        <td>28</td>
    </tr>
</table>

</body>
</html>
