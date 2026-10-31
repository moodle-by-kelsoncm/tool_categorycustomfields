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

namespace tool_categorycustomfields\customfield;

use local_fieldssuite\customfield\area_handler;

/**
 * Custom field handler for course categories.
 *
 * The instance id is the course category id; the values live in the category context. Settings, permissions,
 * the edit page and the web service come from local_fieldssuite.
 *
 * @package    tool_categorycustomfields
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class category_handler extends area_handler {
    /**
     * Capabilities of the area.
     *
     * @param string $type One of the CAPABILITY_* constants.
     * @return string
     */
    public function get_capability(string $type): string {
        return [
            self::CAPABILITY_CONFIGURE => 'tool/categorycustomfields:configurecustomfields',
            self::CAPABILITY_EDIT => 'tool/categorycustomfields:edit',
            self::CAPABILITY_CHANGELOCKED => 'tool/categorycustomfields:changelockedcustomfields',
        ][$type];
    }

    /**
     * Admin page that manages the fields.
     *
     * @return string
     */
    public function get_admin_section(): string {
        return 'tool_categorycustomfields';
    }

    /**
     * Context of a category.
     *
     * @param int $instanceid Category id.
     * @return \context
     */
    public function get_instance_context(int $instanceid = 0): \context {
        if ($instanceid > 0) {
            return \context_coursecat::instance($instanceid);
        }
        return \context_system::instance();
    }

    /**
     * A category the current user can see.
     *
     * @param int $instanceid Category id.
     * @return \stdClass|null
     */
    public function get_instance_info(int $instanceid): ?\stdClass {
        $category = \core_course_category::get($instanceid, IGNORE_MISSING);
        if (!$category || !$category->id) {
            return null;
        }
        return (object)[
            'name' => $category->get_formatted_name(),
            'url' => new \moodle_url('/course/index.php', ['categoryid' => $category->id]),
            'context' => $category->get_context(),
        ];
    }

    /**
     * The edit page belongs to the category: category navigation with the Custom fields tab selected.
     *
     * @param int $instanceid Category id.
     * @param \moodle_url $url
     */
    public function set_up_edit_page(int $instanceid, \moodle_url $url): void {
        global $PAGE;
        $PAGE->set_category_by_id($instanceid);
        $PAGE->set_url($url);
        $PAGE->set_pagelayout('admin');
        $PAGE->add_body_class('limitedwidth');
        $PAGE->set_primary_active_tab('home');
        $PAGE->set_secondary_active_tab('tool_categorycustomfields');
        \navigation_node::override_active_url(new \moodle_url('/course/index.php', ['categoryid' => $instanceid]));
    }
}
