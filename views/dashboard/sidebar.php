<?php

/**
 * This is the main sidebar
 */

use yii\helpers\Html;

// Example permission names
$manageUsers = 'manageUsers';
$manageUsersPermission = 'manageUsersPermission';


?>
<?php
$currentUrl = Yii::$app->request->url;
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="<?= Yii::$app->urlManager->createUrl(['/dashboard/index']) ?>">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>My system</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item <?= strpos($currentUrl, '/site/info') !== false ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/site/info']) ?>">
                        <i class="bi bi-info-circle" style="font-size: medium;"></i>
                        <span>system Information</span>
                    </a>
                </li>
                <li class="nav-item <?= strpos($currentUrl, '/site/about') !== false ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/site/apply-info']) ?>">
                        <i class="bi bi-check2-circle" style="font-size: medium;"></i>
                        <span>system </span>
                    </a>
                </li>
            </ul>
        </li><!-- End  Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/courses/index']) ?>">
                <i class="bi bi-translate"></i></i>
                <span>Courses</span>
            </a>
        </li><!-- End  Courses Nav -->
        </li><!-- End  Courses Nav -->

        </li><!-- End of Course categories Nav -->
        <?php if (Yii::$app->user->can('student')): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/enrollments/index']) ?>">
                <i class="bi bi-buildings"></i>
                <span>Enrollments</span>
            </a>
        </li><!-- End of enrollments Nav -->
        <?php endif; ?>
        <!-- enrollments per course start -->
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <li class="nav-item">
            <a class="nav-link collapsed"
                href="<?= Yii::$app->urlManager->createUrl(['/enrollments/students-per-course']) ?>">
                <i class="bi bi-buildings"></i>
                <span>Enrollments per Course</span>
            </a>
        </li><!-- End of enrollments per course Nav -->
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/lessons/index']) ?>">
                <i class="bi bi-buildings"></i>
                <span>Lessons</span>
            </a>
        </li><!-- End of lessons Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/assignments/index']) ?>">
                <i class="bi bi-book"></i>
                <span>Assignments</span>
            </a>
        </li><!-- End of assignments Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/submissions/index']) ?>">
                <i class="bi bi-buildings"></i>
                <span>Submissions and Grades</span>
            </a>
        </li><!-- End of submissions Nav -->
        <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('instructor')): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/grades/index']) ?>">
                <i class="bi bi-buildings"></i>
                <span>Grades</span>
            </a>
        </li>
        <?php endif; ?>
        <!-- End of grades Nav -->
        <!-- check if the user has a permission to manage users -->
        <?php if (Yii::$app->user->can('admin')): ?>
        <li class="nav-item <?= strpos($currentUrl, '/applicant-details/create') !== false ? 'active' : '' ?>">
            <a class="nav-link collapsed" href="<?= Yii::$app->urlManager->createUrl(['/user/manage']) ?>">
                <i class="bi bi-person-rolodex"></i>
                <span>Manage Users</span>
            </a>
        </li>
        <?php endif; ?>
        <!-- End  manage users Nav -->
        <li class="nav-item">

            <!-- ASSIGN PERMISSIONS IMPLEMENTATION IN SIDEBAR -->
            <!-- Assign Permissions section -->
            <?php if (Yii::$app->user->can($manageUsersPermission)): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRoles"
                aria-expanded="true" aria-controls="collapseRoles">
                <i class="fas fa-user-shield"></i>
                <span>Manage Roles & Permissions</span>
            </a>
            <div id="collapseRoles" class="collapse" aria-labelledby="headingRoles" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Assign Permissions:</h6>
                    <ul class="list-group">
                        <?php
                        $roles = Yii::$app->authManager->getRoles(); // Fetch all roles
                        foreach ($roles as $role) : ?>
                        <li class="list-group-item">
                            <a
                                href="<?= Yii::$app->urlManager->createUrl(['role/assign-permission', 'roleName' => $role->name]) ?>">
                                <?= Html::encode($role->name) ?> - Assign Permissions
                            </a>
                        </li>

                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
        </li>
        <?php endif; ?>

        <!-- END OF ASSIGN PERMISSION IMPLEMENTATION -->
</aside>
<!-- End Sidebar-->