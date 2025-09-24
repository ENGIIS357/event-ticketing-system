<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار بسيط</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            direction: rtl;
        }
        .form-container {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <h1>اختبار النموذج البسيط</h1>
    
    <button onclick="showForm()">إظهار النموذج</button>
    
    <div id="formContainer" class="form-container">
        <h2>نموذج إضافة فعالية</h2>
        <form onsubmit="submitForm(event)">
            <div>
                <label>اسم الفعالية:</label>
                <input type="text" id="title" required>
            </div>
            <div>
                <label>الوصف:</label>
                <textarea id="description" rows="3" required></textarea>
            </div>
            <div>
                <button type="submit">حفظ</button>
                <button type="button" onclick="hideForm()">إلغاء</button>
            </div>
        </form>
    </div>

    <script>
        function showForm() {
            document.getElementById('formContainer').style.display = 'block';
        }
        
        function hideForm() {
            document.getElementById('formContainer').style.display = 'none';
        }
        
        function submitForm(event) {
            event.preventDefault();
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            
            alert('تم إضافة الفعالية: ' + title + '\nالوصف: ' + description);
            
            // إعادة تعيين النموذج
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            hideForm();
        }
    </script>
</body>
</html>