<h2>Login</h2>

<?php if (!empty($data['error'])): ?>
    <p style="color:red;"><?= $data['error'] ?></p>
<?php endif; ?>

<form action="/auth/login" method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Login"><br><br>

    <p>Don't have an account? <a href="/auth/register">Register here</a>.</p>
</form>

