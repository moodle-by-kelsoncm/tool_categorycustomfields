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
use local_fieldssuite\local\display;
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
     * Shows the visible custom field values on the category page, after the category description.
     *
     * @param after_standard_main_region_html_generation $hook
     */
    public static function after_standard_main_region_html_generation(after_standard_main_region_html_generation $hook): void {
        global $PAGE;
        if ($PAGE->pagetype !== 'course-index-category' || !($PAGE->context instanceof \context_coursecat)) {
            return;
        }
        display::add_to_page($hook, category_handler::create(), (int)$PAGE->context->instanceid, '.generalbox.info');
    }
}
