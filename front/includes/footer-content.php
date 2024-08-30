<div class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4 class="footer-heading"><?= webSetting('title') ?? "Fungua Roho";?></h4>
                <hr>
                <p><?= webSetting('small_description') ?? "";?></p>
            </div>

            <div class="col-md-4">
                <h4 class="footer-heading"> Contact Information</h4>
                <hr>
                <ul>
                    <?php
                        $socialMedia = getAll($conn, 'social_media');
                        if (!empty($socialMedia)) {
                            foreach ($socialMedia as $socialItem) {
                                ?>
                                <li>
                                    <a href="<?= htmlspecialchars($socialItem['url']); ?>"><?= htmlspecialchars($socialItem['name']); ?></a>
                                </li>
                                <?php
                            }
                        } else {
                            echo "<li>No Social Media added </li>";
                        }
                    ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h4 class="footer-heading"> Contact Information</h4>
                <hr>
                <p>Address: <?= webSetting('address') ?? "";?></p>
                <p>Email: <?= webSetting('email1') ?? "";?>, <?= webSetting('email2') ?? "";?></p>
                <p>Phone No.: <?= webSetting('phone1') ?? "";?>, <?= webSetting('phone2') ?? "";?></p>
            </div>
        </div>
    </div>
</div>
