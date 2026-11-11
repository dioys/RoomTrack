<!DOCTYPE html>
<html lang="en">
<head>
    <title>Room Map</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f0f0f0, #d4d4d4); /* Soft gradient */
            padding: 40px;
            text-align: center;
            color: #333;
        }

        h2 {
            color: #2e4156; /* Darker shade for better contrast */
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .placeholder {
            border: 2px dashed #ccc;
            background: #fff;
            padding: 100px;
            color: #aaa;
            font-size: 20px;
            margin-top: 50px;
            transition: background-color 0.3s ease;
        }

        .placeholder:hover {
            background-color: #f7f7f7; /* Subtle hover effect */
        }

        .back-button {
            margin-top: 40px;
            display: inline-block;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .back-button:hover {
            background-color: #45a049;
            transform: translateY(-3px); /* Subtle lift effect */
        }

        .back-button:active {
            transform: translateY(1px); /* Push down effect */
        }
    </style>
</head>
<body>

    <h2>Campus Room Map</h2>

    <div class="placeholder">
        [Map Placeholder – This space can be used to add a floor layout or interactive map.]
    </div>

    <a href="rooms.php" class="back-button">← Back to Search Rooms</a>

</body>
</html>
