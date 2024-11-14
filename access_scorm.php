<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/externallib.php');
require_once($CFG->dirroot . '/webservice/lib.php');

// Get the token from the URL
$token = optional_param('token', '', PARAM_ALPHANUMEXT);
$scoid = optional_param('scoid', 66, PARAM_INT);  // Example SCORM ID
$cm = optional_param('cm', 20, PARAM_INT);        // Example Course Module ID

if (empty($token)) {
    print_error(get_string('missingtoken', 'local_access_scorm'));
}

// Validate the token
try {
    $token_record = $DB->get_record('external_tokens', array('token' => $token));

    if ($token_record && (!$token_record->validuntil || $token_record->validuntil > time())) {
        $user = $DB->get_record('user', array('id' => $token_record->userid));

        if ($user) {
            complete_user_login($user);

            redirect(new moodle_url('/mod/scorm/player.php', array(
                'scoid' => $scoid,
                'cm' => $cm,
                'currentorg' => 'easygenerator',
                'display' => 'popup'
            )));
        } else {
            print_error(get_string('usernotfound', 'local_access_scorm'));
        }
    } else {
        print_error(get_string('invalidtoken', 'local_access_scorm'));
    }
} catch (Exception $e) {
    print_error('Token validation failed: ' . $e->getMessage());
}
