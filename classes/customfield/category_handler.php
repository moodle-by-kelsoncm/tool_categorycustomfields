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

use core_customfield\field_controller;

/**
 * Custom field handler for course categories.
 *
 * The instance id is the course category id; the values live in the category context.
 *
 * @package    tool_categorycustomfields
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class category_handler extends \core_customfield\handler {
    /** @var int Visible to everyone who can see the category. */
    const VISIBLETOALL = 2;

    /** @var int Visible to those who can edit the values of the category. */
    const VISIBLETOMANAGERS = 1;

    /** @var int Not shown on the category page. */
    const NOTVISIBLE = 0;

    /**
     * The current user can manage the fields.
     *
     * @return bool
     */
    public function can_configure(): bool {
        return has_capability('tool/categorycustomfields:configurecustomfields', $this->get_configuration_context());
    }

    /**
     * The current user can edit the value of a field in a category.
     *
     * @param field_controller $field
     * @param int $instanceid Category id.
     * @return bool
     */
    public function can_edit(field_controller $field, int $instanceid = 0): bool {
        $context = $this->get_instance_context($instanceid);
        if (!has_capability('tool/categorycustomfields:edit', $context)) {
            return false;
        }
        return !$field->get_configdata_property('locked') ||
            has_capability('tool/categorycustomfields:changelockedcustomfields', $context);
    }

    /**
     * The current user can see the value of a field in a category.
     *
     * @param field_controller $field
     * @param int $instanceid Category id.
     * @return bool
     */
    public function can_view(field_controller $field, int $instanceid): bool {
        $visibility = $field->get_configdata_property('visibility') ?? self::VISIBLETOALL;
        if ($visibility == self::NOTVISIBLE) {
            return false;
        } else if ($visibility == self::VISIBLETOMANAGERS) {
            return has_capability('tool/categorycustomfields:edit', $this->get_instance_context($instanceid));
        }
        return true;
    }

    /**
     * Context where the fields are configured.
     *
     * @return \context
     */
    public function get_configuration_context(): \context {
        return \context_system::instance();
    }

    /**
     * URL of the page that manages the fields.
     *
     * @return \moodle_url
     */
    public function get_configuration_url(): \moodle_url {
        return new \moodle_url('/admin/tool/categorycustomfields/customfield.php');
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
     * Settings of the area added to the field configuration form.
     *
     * @param \MoodleQuickForm $mform
     */
    public function config_form_definition(\MoodleQuickForm $mform) {
        $mform->addElement(
            'header',
            'category_handler_header',
            get_string('customfieldsettings', 'tool_categorycustomfields')
        );
        $mform->setExpanded('category_handler_header', true);

        $mform->addElement('selectyesno', 'configdata[locked]', get_string('customfield_islocked', 'tool_categorycustomfields'));
        $mform->addHelpButton('configdata[locked]', 'customfield_islocked', 'tool_categorycustomfields');

        $options = [
            self::VISIBLETOALL => get_string('customfield_visibletoall', 'tool_categorycustomfields'),
            self::VISIBLETOMANAGERS => get_string('customfield_visibletomanagers', 'tool_categorycustomfields'),
            self::NOTVISIBLE => get_string('customfield_notvisible', 'tool_categorycustomfields'),
        ];
        $mform->addElement(
            'select',
            'configdata[visibility]',
            get_string('customfield_visibility', 'tool_categorycustomfields'),
            $options
        );
        $mform->addHelpButton('configdata[visibility]', 'customfield_visibility', 'tool_categorycustomfields');
    }
}
