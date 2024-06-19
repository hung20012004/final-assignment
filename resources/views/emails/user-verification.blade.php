<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>Your account has been created successfully. Here is your new password:
        **Password: {{ $pass }}
        <br>Do not display passwords in emails for security reasons**
        <br>You can log in to your account using this password.</p>

    <p>Thanks, <br>Laravel</p>
</body>
</html>
