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

namespace tool_categorycustomfields;

use core\hook\output\after_standard_main_region_html_generation;
use tool_categorycustomfields\customfield\category_handler;

/**
 * Hook callbacks of tool_categorycustomfields.
 *
 * @package    tool_categorycustomfields
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {
    /**
     * Shows the visible custom field values on the category page.
     *
     * @param after_standard_main_region_html_generation $hook
     */
    public static function after_standard_main_region_html_generation(after_standard_main_region_html_generation $hook): void {
        global $PAGE;
        if ($PAGE->pagetype !== 'course-index-category' || !($PAGE->context instanceof \context_coursecat)) {
            return;
        }
        $html = self::render_category_values((int)$PAGE->context->instanceid);
        if ($html === '') {
            return;
        }
        $hook->add_html($html);
        $PAGE->requires->js_call_amd('tool_categorycustomfields/placement', 'init');
    }

    /**
     * HTML with the values of a category that the current user can see.
     *
     * @param int $categoryid
     * @return string Empty when there is nothing to show.
     */
    public static function render_category_values(int $categoryid): string {
        global $OUTPUT;
        $handler = category_handler::create();
        $fields = [];
        foreach ($handler->get_instance_data($categoryid) as $data) {
            $value = $data->export_value();
            if ($value === null || $value === '') {
                continue;
            }
            $fields[] = [
                'name' => $data->get_field()->get_formatted_name(),
                'shortname' => $data->get_field()->get('shortname'),
                'type' => $data->get_field()->get('type'),
                'value' => $value,
            ];
        }
        if (!$fields) {
            return '';
        }
        return $OUTPUT->render_from_template('tool_categorycustomfields/values', ['fields' => $fields]);
    }
}
