<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password - Windmill Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #f7fafc;
            font-family: 'Inter', sans-serif;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 6px;
        }

        .card {
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-content {
            padding: 24px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333333;
            margin-bottom: 16px;
        }

        .form-label {
            font-size: 0.875rem;
            color: #4a5568;
            margin-bottom: 4px;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            margin-top: 4px;
        }

        .form-input:focus {
            outline: none;
            border-color: #805ad5;
            box-shadow: 0 0 0 3px rgba(128, 90, 213, 0.2);
        }

        .form-button {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: #ffffff;
            background-color: #805ad5;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 16px;
        }

        .form-button:hover {
            background-color: #6d48e5;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="card">
                <div class="card-content">
                <h1 class="card-title">Reset password</h1>
                <form id="reset-password-form">
                    <input type="hidden" id="token" name="token" value="">
                    <input type="hidden" id="email" name="email" value="">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-input" required>
                    <button type="submit" class="form-button">Change password</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        document.getElementById('token').value = urlParams.get('token');
        document.getElementById('email').value = urlParams.get('email');

        document.getElementById('reset-password-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('http://127.0.0.1:8000/api/reset-password', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert('Password has been reset');
                    } else {
                        alert('Error: ' + data.email);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>
