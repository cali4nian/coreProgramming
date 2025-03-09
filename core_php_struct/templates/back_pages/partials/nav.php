<?php
// Ensure session is started before checking user role
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<nav>
    <a href="/dashboard">Dashboard</a> |
    <a href="/profile">Profile</a> |
    
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="/users">Users</a> |
    <?php endif; ?>
    
    <a href="/logout">Logout</a>
</nav>
