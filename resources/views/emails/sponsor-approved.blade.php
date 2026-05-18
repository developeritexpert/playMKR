<!DOCTYPE html>
<html>
<head>
    <title>Sponsor Approved</title>
</head>
<body>

    <h2>Hello {{ $sponsor->name }}</h2>
    <p>Your sponsorship request has been approved!</p>
    <p>You can now log in using the following credentials:</p>

  <ul>
    <li>Email: {{ $sponsor->email }}</li>
    <li>Password: {{ $password }}</li>
  </ul>

    <p>Please change your password after logging in for security.</p>

    <p>Thank you for joining PlayMKR.</p>

</body>
</html>