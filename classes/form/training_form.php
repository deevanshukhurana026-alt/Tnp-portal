<?php
namespace local_training_letter\form;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

class training_form extends \moodleform {
    public function definition() {
        global $USER;
        $mform = $this->_form;

        // Student Particulars
        $mform->addElement('header', 'studentinfo', 'Student Particulars');
        
        $mform->addElement('text', 'fullname', 'Full Name');
        $mform->setType('fullname', PARAM_TEXT);
        $mform->setDefault('fullname', fullname($USER));
        $mform->addRule('fullname', null, 'required', null, 'client');

        $mform->addElement('text', 'rollno', 'University Roll No / URN');
        $mform->setType('rollno', PARAM_ALPHANUMEXT);
        $mform->setDefault('rollno', '2513996');
        $mform->addRule('rollno', null, 'required', null, 'client');

        $mform->addElement('text', 'branch', 'Branch & Section');
        $mform->setType('branch', PARAM_TEXT);
        $mform->setDefault('branch', 'Computer Science & Engineering (d2cseb1)');
        $mform->addRule('branch', null, 'required', null, 'client');

        $mform->addElement('text', 'semester', 'Current Semester');
        $mform->setType('semester', PARAM_INT);
        $mform->setDefault('semester', '3');

        // Company Details
        $mform->addElement('header', 'companyinfo', 'Company Details');
        
        $mform->addElement('text', 'orgname', 'Organization Name');
        $mform->setType('orgname', PARAM_TEXT);
        $mform->addRule('orgname', null, 'required', null, 'client');

        $mform->addElement('textarea', 'orgaddress', 'Postal Address', 'wrap="virtual" rows="3" cols="50"');
        $mform->setType('orgaddress', PARAM_TEXT);
        $mform->addRule('orgaddress', null, 'required', null, 'client');

        // Training Particulars
        $mform->addElement('header', 'trainingparticulars', 'Training Particulars');
        
        $types = ['Software' => 'Software Training', 'Industrial' => 'Industrial Training'];
        $mform->addElement('select', 'trainingtype', 'Training Type', $types);

        $durations = ['6 Weeks' => '6 Weeks', '6 Months' => '6 Months'];
        $mform->addElement('select', 'duration', 'Duration', $durations);

        $mform->addElement('date_selector', 'joiningdate', 'Expected Joining Date');

        $this->add_action_buttons(true, 'Submit Training Request');
    }
}