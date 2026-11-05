
<h2>Register</h2>

<?php if (!empty($data['error'])): ?>
    <p style="color:red;"><?= $data['error'] ?></p>
<?php endif; ?>

<form action="/auth/register" method="POST">
    <label>Full Name:</label><br>
    <input type="text" name="full_name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="tenant">Tenant</option>
        <option value="owner">Property Owner</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <input type="submit" value="Register"><br><br>

    <p>Already have an account? <a href="/auth/login">Login here</a>.</p>
</form>

