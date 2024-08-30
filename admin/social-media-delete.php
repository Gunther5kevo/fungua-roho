<?php
require_once('functions.php');

$paramId = checkParamId('id');

if (is_numeric($paramId)) {
    $socialMediaId = validate($paramId);

    $socialMedia = getById('social_media', $socialMediaId);

    if ($socialMedia['status'] == 200) {
        $socialMediaDeleteRes = deleteQuery($conn, 'social_media', $socialMediaId);
        if ($socialMediaDeleteRes) {
            redirect('social-media.php', 'Social Media deleted successfully');
        } else {
            redirect('social-media.php', 'Failed to delete social media');
        }
    } else {
        redirect('social-media.php', $socialMedia['message']);
    }
} else {
    redirect('social-media.php', $paramId);
}

