<button class="hamburger" aria-label="Toggle Menu">
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
</button>

<aside class="sidebar">
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/profile">Profile</a></li>
        <?php if (isset($_SESSION['current_role']) && $_SESSION['current_role'] === 'admin' || $_SESSION['current_role'] === 'super user'): ?>
            <li><a href="/admin/messages">Messages</a></li>
            <li><a href="/admin/settings">Settings</a></li>
            <li><a href="/admin/subscribers">Subscribers</a></li>
            <li><a href="/admin/top-players">Top Players</a></li>
            <li><a href="/admin/users">Users</a></li>
        <?php endif; ?>  
        <li><a href="/logout">Logout</a></li>
    </ul>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hamburgerButton = document.querySelector('.hamburger');
        const sidebar = document.querySelector('.sidebar');
        hamburgerButton.addEventListener('click', () => sidebar.classList.toggle('open'));
    });
</script>