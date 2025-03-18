<?php
// Ensure session is started before checking user role
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<aside class="sidebar">
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/profile">Profile</a></li>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <li><a href="/admin/users">Users</a></li>
            <li><a href="/admin/subscribers">Subscribers</a></li>
            <li><a href="/admin/settings">Settings</a></li>
        <?php endif; ?>
        <li><a href="/players">Players</a></li>
        <li><a href="/coaches">Coaches</a></li>
        <li><a href="/logout">Logout</a></li>
    </ul>
</aside>