<?php
require './includes/db.php';

// Fetch contact details
$stmt = $pdo->query("SELECT * FROM contact_page WHERE id = 1");
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if data exists
if (!$contact) {
    $contact = [
        'title' => 'Default Title',
        'description' => 'Default description.',
        'address_1' => 'No address available.',
        'phone_1' => 'No phone available.',
        'address_2' => 'No address available.',
        'phone_2' => 'No phone available.'
    ];
}


?>

<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d111551.9926412813!2d-90.27317134641879!3d38.606612219170856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sbd!4v1597926938024!5m2!1sen!2sbd" height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>

<!-- Contact Section -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <!-- Contact Information -->
            <div class="col-lg-6 col-md-6">
                <div class="contact__text">
                    <div class="section-title">
                        <span>Information</span>
                        <h2><?= htmlspecialchars($contact['title']) ?></h2>
                        <p><?= htmlspecialchars($contact['description']) ?></p>
                    </div>
                    <ul>
                        <li>
                            <h4>Location 1</h4>
                            <p><?= htmlspecialchars($contact['address_1']) ?><br /><?= htmlspecialchars($contact['phone_1']) ?></p>
                        </li>
                        <li>
                            <h4>Location 2</h4>
                            <p><?= htmlspecialchars($contact['address_2']) ?><br /><?= htmlspecialchars($contact['phone_2']) ?></p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-6 col-md-6">
                <div class="contact__form">
                    <form action="./admin/contact_process.php" method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name" placeholder="Name" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="col-lg-12">
                                <textarea name="message" placeholder="Message" required></textarea>
                                <button type="submit" class="site-btn">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
