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
 * Callbacks of tool_categorycustomfields.
 *
 * @package    tool_categorycustomfields
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Adds the link to the custom field values in the category settings menu.
 *
 * @param navigation_node $navigation
 * @param context_coursecat $context
 */
function tool_categorycustomfields_extend_navigation_category_settings(
    navigation_node $navigation,
    context_coursecat $context
): void {
    if (!has_capability('tool/categorycustomfields:edit', $context)) {
        return;
    }
    $navigation->add(
        get_string('editvalues', 'tool_categorycustomfields'),
        new moodle_url('/admin/tool/categorycustomfields/edit.php', ['id' => $context->instanceid]),
        navigation_node::TYPE_SETTING,
        null,
        'tool_categorycustomfields',
        new pix_icon('i/settings', '')
    );
}
