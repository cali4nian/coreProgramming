<?php include 'header.php'; ?>

<section class="container">

    <!-- Admin-Specific Section -->
    <?php if (isset($currentRole) && $currentRole === 'admin') require_once 'partials/dashboard/admin.php'; ?>

    <!-- Coach-Specific Section -->
    <?php if (isset($currentRole) && $currentRole === 'coach') require_once 'partials/dashboard/coach.php' ?>

    <!-- Athlete-Specific Section -->
    <?php if (isset($currentRole) && $currentRole === 'athlete') require_once 'partials/dashboard/athlete.php' ?>

    <!-- Error Handling -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

</section>

<?php include 'footer.php'; ?>