<!DOCTYPE html>
<html>
<head>
    <title>Backup and Restore Database</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            box-sizing: border-box;
            margin-left: 300px;
        }
        .form-container {
            text-align: center;
        }
        button {
            margin-top: 10px;
            padding: 8px 16px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        input[type="file"] {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="backup.php" method="POST">
            <button type="submit" name="backup">Backup Data</button>
        </form>
        <form action="restore.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file_to_restore" accept=".sql">
            <button type="submit" name="restore">Restore Data</button>
        </form>
    </div>
</body>
</html>


    <script>
        function centerFileInput() {
            var fileInput = document.getElementById('file_to_restore');
            var label = fileInput.nextElementSibling;
            var rect = label.getBoundingClientRect();
            fileInput.style.top = rect.top + 'px';
            fileInput.style.left = rect.left + 'px';
            fileInput.style.width = rect.width + 'px';
            fileInput.style.height = rect.height + 'px';
            fileInput.style.visibility = 'visible';
            fileInput.style.position = 'absolute';
        }
    </script>
</body>
</html>
