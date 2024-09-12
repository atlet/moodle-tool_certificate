<?php
// This file is part of the tool_certificate plugin for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains the class that handles uploading files.
 *
 * @package    tool_certificate
 * @copyright  2013 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_certificate;

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->libdir.'/formslib.php');

/**
 * Handles uploading files.
 *
 * @package    tool_certificate
 * @copyright  2013 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class upload_image_form extends \moodleform {

    /** @var array the filemanager options */
    protected $filemanageroptions = [];

    /**
     * Form definition.
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;
        $this->filemanageroptions = [
            'maxbytes' => $CFG->maxbytes,
            'subdirs' => 1,
            'accepted_types' => 'web_image', ];
        $mform->addElement('filemanager', 'certificateimage', get_string('uploadimage', 'tool_certificate'), '',
            $this->filemanageroptions);

        $this->add_action_buttons();
    }

    /**
     * Fill in the current page data for this certificate.
     */
    public function definition_after_data() {
        $mform = $this->_form;

        // Editing existing instance - copy existing files into draft area.
        $draftitemid = file_get_submitted_draft_itemid('certificateimage');
        file_prepare_draft_area($draftitemid, \context_system::instance()->id, 'tool_certificate', 'image', 0,
            $this->filemanageroptions);
        $element = $mform->getElement('certificateimage');
        $element->setValue($draftitemid);
    }
}
