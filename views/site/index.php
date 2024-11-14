<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $courses array List of popular courses */
/* @var $testimonials array List of testimonials */

$this->title = 'E-Learning Platform';
?>

<div class="site-index">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <!-- Hero Heading -->
            <div class="text-center" style="margin-top: 10px;">
                <h1 style="font-size: 45px; color:black; font-weight: bold;">Learn Anytime, Anywhere</h1>
            </div>
            <p>Access a variety of courses and enhance your skills from the comfort of your home.</p>
            <!-- Hero Buttons -->
            <a href="<?= Url::to(['/courses/index']) ?>" class="btn btn-primary">Explore Courses</a>
            <?php if (Yii::$app->user->isGuest) : ?>
            <a href="<?= Url::to(['/site/signup']) ?>" class="btn btn-secondary">Get Started</a>
            <?php endif ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <!-- Feature Icons with Descriptions -->
        <div class="feature">
            <i class="bi bi-play-circle"></i>
            <h3>Interactive Lessons</h3>
            <p>Engage with interactive videos and quizzes.</p>
        </div>
        <div class="feature">
            <i class="bi bi-person-badge"></i>
            <h3>Expert Instructors</h3>
            <p>Learn from industry professionals.</p>
        </div>
        <div class="feature">
            <i class="bi bi-pie-chart"></i>
            <h3>Personalized Learning</h3>
            <p>Get course recommendations based on your progress.</p>
        </div>
        <div class="feature">
            <i class="bi bi-award"></i>
            <h3>Certificates</h3>
            <p>Receive certificates upon course completion.</p>
        </div>
    </section>

    <!-- Popular Courses Section -->
    <section class="popular-courses">
        <h2 style="color:brown; font-weight: bold;">Popular Courses</h2>
        <div class=" course-grid">
            <!-- Loop through each course and display it as a card -->
            <?php foreach ($courses as $course): ?>
            <div class="course-item">
                <!-- Course Image -->
                <img src="<?= Url::to('@web/uploads/courses/' . Html::encode($course->IMAGE)) ?>"
                    alt="<?= Html::encode($course->COURSE_NAME) ?>"
                    style="width: 100%; height: 200px; object-fit: cover;">
                <!-- Course Title -->
                <h3 style="color: green; font-size: 20px; font-weight: bold;"><?= Html::encode($course->COURSE_NAME) ?>
                </h3>
                <!-- Course Description -->
                <p><?= Html::encode($course->DESCRIPTION) ?></p>
                <!-- View Course Button -->
                <a href="<?= Url::to(['/courses/view', 'id' => $course->COURSE_ID]) ?>" class="btn btn-primary">View
                    Course</a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <h2 style="color: brown; font-weight: bold;">What Our Students Say</h2>
        <div class="testimonial-carousel">
            <!-- Loop through testimonials and display each one -->
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial">
                <p>"<?= Html::encode($testimonial->MESSAGE) ?>"</p>
                <h4>- <?= Html::encode($testimonial->NAME) ?></h4>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Call-to-Action (CTA) Banner -->
    <section class="cta-banner">
        <h2>Ready to Start Learning?</h2>
        <p>Join thousands of students improving their skills.</p>
        <!-- Join Now Button -->
        <a href="<?= Url::to(['/site/signup']) ?>" class="btn btn-primary">Join Now</a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <!-- Quick Links -->
            <ul class="quick-links">
                <li><a href="<?= Url::to(['/site/about']) ?>">About Us</a></li>
                <li><a href="<?= Url::to(['/site/contact']) ?>">Contact</a></li>
                <li><a href="<?= Url::to(['/site/help']) ?>">Help Center</a></li>
            </ul>
            <!-- Social Media Icons -->
            <div class="social-icons">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
        <!-- Footer Text -->
        <p>&copy; <?= date('Y') ?> Your E-Learning Platform. All rights reserved.</p>
    </footer>
</div>