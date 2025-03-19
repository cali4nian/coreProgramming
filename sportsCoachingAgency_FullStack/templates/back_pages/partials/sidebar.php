<?php
// Ensure session is started before checking user role
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<!-- Hamburger Button -->
<button class="hamburger" aria-label="Toggle Menu">
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
</button>

<aside class="sidebar">
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/profile">Profile</a></li>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <li><a href="/admin/settings">Settings</a></li>
            <li><a href="/admin/users">Manage Users</a></li>
            <li><a href="/admin/subscribers">Subscribers</a></li>
            <!-- <li><a href="/admin/reports">Reports</a></li> -->
        <?php endif; ?>
        <li><a href="/athletes">Athletes</a></li>
        <li><a href="/coaches">Coaches</a></li>
        <li><a href="/logout">Logout</a></li>
    </ul>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hamburgerButton = document.querySelector('.hamburger');
        const sidebar = document.querySelector('.sidebar');

        hamburgerButton.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });
    });
</script>