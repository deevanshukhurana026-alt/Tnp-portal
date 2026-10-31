<?php
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/form/training_form.php');

require_login();
$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/training_letter/index.php'));
$PAGE->set_context($context);
$PAGE->set_title('GNDEC Training Request');
$PAGE->set_heading('Training & Placement Cell - Request Generator');

$mform = new \local_training_letter\form\training_form();

if ($data = $mform->get_data()) {
    $record = new stdClass();
    $record->userid = $USER->id;
    $record->fullname = $data->fullname;
    $record->rollno = $data->rollno;
    $record->branch = $data->branch;
    $record->semester = $data->semester;
    $record->orgname = $data->orgname;
    $record->orgaddress = $data->orgaddress;
    $record->trainingtype = $data->trainingtype;
    $record->duration = $data->duration;
    $record->joiningdate = $data->joiningdate;
    $record->status = 'approved'; // Auto-approved for testing
    $record->timecreated = time();

    $DB->insert_record('local_training_letter', $record);
    redirect(new moodle_url('/local/training_letter/index.php'), 'Training request submitted successfully!', null, \core\output\notification::NOTIFY_SUCCESS);
}

echo $OUTPUT->header();
$mform->display();

$existing = $DB->get_record('local_training_letter', ['userid' => $USER->id]);
if ($existing) {
    echo html_writer::div('Current Status: <strong>' . ucfirst($existing->status) . '</strong>', 'alert alert-info mt-4');
    $pdfurl = new moodle_url('/local/training_letter/pdf/generate_letter.php', ['id' => $existing->id]);
    echo html_writer::link($pdfurl, 'Download Official GNDEC Training Request Letter (PDF)', ['class' => 'btn btn-success mt-2', 'target' => '_blank']);
}

echo $OUTPUT->footer();