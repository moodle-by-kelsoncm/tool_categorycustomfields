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

use tool_categorycustomfields\customfield\category_handler;

/**
 * Event observers of tool_categorycustomfields.
 *
 * @package    tool_categorycustomfields
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class observer {
    /**
     * Deletes the custom field values of a deleted category.
     *
     * @param \core\event\course_category_deleted $event
     */
    public static function course_category_deleted(\core\event\course_category_deleted $event): void {
        category_handler::create()->delete_instance((int)$event->objectid);
    }
}
