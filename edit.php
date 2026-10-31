<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Edits the custom field values of a course category.
 *
 * @package    tool_categorycustomfields
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

$id = required_param('id', PARAM_INT);

require_login();

$coursecat = core_course_category::get($id, MUST_EXIST, true);
$context = context_coursecat::instance($coursecat->id);
require_capability('tool/categorycustomfields:edit', $context);

$url = new moodle_url('/admin/tool/categorycustomfields/edit.php', ['id' => $coursecat->id]);
$categoryurl = new moodle_url('/course/index.php', ['categoryid' => $coursecat->id]);

$PAGE->set_category_by_id($coursecat->id);
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->add_body_class('limitedwidth');
$PAGE->set_primary_active_tab('home');
$PAGE->set_secondary_active_tab('tool_categorycustomfields');
navigation_node::override_active_url($categoryurl);
$title = get_string('editvaluesof', 'tool_categorycustomfields', $coursecat->get_formatted_name());
$PAGE->set_title($title);
$PAGE->set_heading($coursecat->get_formatted_name());
$PAGE->navbar->add(get_string('editvalues', 'tool_categorycustomfields'), $url);

$handler = \tool_categorycustomfields\customfield\category_handler::create();
$form = new \tool_categorycustomfields\form\edit_form($url, ['handler' => $handler, 'categoryid' => $coursecat->id]);

$instance = (object)['id' => $coursecat->id];
$handler->instance_form_before_set_data($instance);
$form->set_data($instance);

if ($form->is_cancelled()) {
    redirect($categoryurl);
} else if ($data = $form->get_data()) {
    $handler->instance_form_save($data);
    redirect(
        $categoryurl,
        get_string('valuessaved', 'tool_categorycustomfields'),
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('editvalues', 'tool_categorycustomfields'));
if (!$handler->get_editable_fields($coursecat->id)) {
    if ($handler->can_configure()) {
        $link = html_writer::link(
            $handler->get_configuration_url(),
            get_string('categorycustomfields', 'tool_categorycustomfields')
        );
        echo $OUTPUT->notification(get_string('nofieldsmanage', 'tool_categorycustomfields', $link), 'info');
    } else {
        echo $OUTPUT->notification(get_string('nofields', 'tool_categorycustomfields'), 'info');
    }
} else {
    $form->display();
}
echo $OUTPUT->footer();
