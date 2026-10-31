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

use core_customfield\field_controller;
use local_fieldssuite\local\display;
use tool_categorycustomfields\customfield\category_handler;

/**
 * Tests for the category custom field area.
 *
 * @package    tool_categorycustomfields
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \tool_categorycustomfields\customfield\category_handler
 * @covers     \tool_categorycustomfields\hook_callbacks
 * @covers     \local_fieldssuite\local\display
 * @covers     \tool_categorycustomfields\observer
 */
final class plugin_test extends \advanced_testcase {
    /** @var int|null Custom field category of the area, created on demand. */
    private ?int $fieldcategoryid = null;

    /**
     * Creates a field of the category area.
     *
     * @param string $shortname
     * @param array $configdata
     * @return field_controller
     */
    private function create_field(string $shortname, array $configdata = []): field_controller {
        /** @var \core_customfield_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('core_customfield');
        if (!$this->fieldcategoryid) {
            $category = $generator->create_category(['component' => 'tool_categorycustomfields', 'area' => 'category']);
            $this->fieldcategoryid = (int)$category->get('id');
        }
        return $generator->create_field([
            'categoryid' => $this->fieldcategoryid,
            'shortname' => $shortname,
            'name' => ucfirst($shortname),
            'type' => 'text',
            'configdata' => $configdata,
        ]);
    }

    /**
     * Adds a value to a course category.
     *
     * @param field_controller $field
     * @param int $categoryid
     * @param string $value
     */
    private function add_value(field_controller $field, int $categoryid, string $value): void {
        /** @var \core_customfield_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('core_customfield');
        $generator->add_instance_data($field, $categoryid, $value);
    }

    /**
     * The values are kept in the category context.
     */
    public function test_values_in_category_context(): void {
        $this->resetAfterTest();
        $this->setAdminUser();
        $category = $this->getDataGenerator()->create_category();
        $field = $this->create_field('department');
        $this->add_value($field, $category->id, 'Engineering');

        $data = category_handler::create()->get_instance_data($category->id);
        $data = reset($data);
        $this->assertSame('Engineering', $data->get_value());
        $this->assertEquals(\context_coursecat::instance($category->id)->id, $data->get('contextid'));
    }

    /**
     * Only managers configure fields and edit values; locked fields need one more capability.
     */
    public function test_capabilities(): void {
        global $DB;
        $this->resetAfterTest();
        $category = $this->getDataGenerator()->create_category();
        $field = $this->create_field('department');
        $locked = $this->create_field('budget', ['locked' => 1]);
        $handler = category_handler::create();

        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $this->assertFalse($handler->can_configure());
        $this->assertFalse($handler->can_edit($field, $category->id));

        $managerrole = $DB->get_field('role', 'id', ['shortname' => 'manager']);
        $this->getDataGenerator()->role_assign($managerrole, $user->id, \context_coursecat::instance($category->id)->id);
        $this->assertFalse($handler->can_configure());
        $this->assertTrue($handler->can_edit($field, $category->id));
        $this->assertTrue($handler->can_edit($locked, $category->id));

        $role = $this->getDataGenerator()->create_role();
        assign_capability('tool/categorycustomfields:edit', CAP_ALLOW, $role, \context_system::instance()->id);
        $editor = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->role_assign($role, $editor->id, \context_coursecat::instance($category->id)->id);
        $this->setUser($editor);
        $this->assertTrue($handler->can_edit($field, $category->id));
        $this->assertFalse($handler->can_edit($locked, $category->id));

        $this->setAdminUser();
        $this->assertTrue($handler->can_configure());
    }

    /**
     * The visibility setting decides who sees the value.
     */
    public function test_visibility(): void {
        $this->resetAfterTest();
        $category = $this->getDataGenerator()->create_category();
        $all = $this->create_field('public', ['visibility' => category_handler::VISIBLETOALL]);
        $managers = $this->create_field('internal', ['visibility' => category_handler::VISIBLETOMANAGERS]);
        $nobody = $this->create_field('hidden', ['visibility' => category_handler::NOTVISIBLE]);
        $handler = category_handler::create();

        $this->setUser($this->getDataGenerator()->create_user());
        $this->assertTrue($handler->can_view($all, $category->id));
        $this->assertFalse($handler->can_view($managers, $category->id));
        $this->assertFalse($handler->can_view($nobody, $category->id));

        $this->setAdminUser();
        $this->assertTrue($handler->can_view($managers, $category->id));
        $this->assertFalse($handler->can_view($nobody, $category->id));
    }

    /**
     * The form path saves the values.
     */
    public function test_instance_form_save(): void {
        $this->resetAfterTest();
        $this->setAdminUser();
        $category = $this->getDataGenerator()->create_category();
        $this->create_field('department');
        $handler = category_handler::create();

        $handler->instance_form_save((object)['id' => $category->id, 'customfield_department' => 'Sales']);

        $data = $handler->get_instance_data($category->id);
        $this->assertSame('Sales', reset($data)->get_value());
    }

    /**
     * The category page shows only visible, non-empty values, escaped.
     */
    public function test_render_category_values(): void {
        $this->resetAfterTest();
        $category = $this->getDataGenerator()->create_category();
        $public = $this->create_field('public');
        $internal = $this->create_field('internal', ['visibility' => category_handler::VISIBLETOMANAGERS]);
        $this->create_field('empty');
        $this->add_value($public, $category->id, 'R&D "Engineering"');
        $this->add_value($internal, $category->id, 'Secret');

        $this->setUser($this->getDataGenerator()->create_user());
        $html = display::render_values(category_handler::create(), $category->id);
        $this->assertStringContainsString('R&amp;D', $html);
        $this->assertStringContainsString('Engineering', $html);
        $this->assertStringNotContainsString('Secret', $html);
        $this->assertStringNotContainsString('Empty', $html);

        $other = $this->getDataGenerator()->create_category();
        $this->assertSame('', display::render_values(category_handler::create(), $other->id));
    }

    /**
     * Deleting a category deletes its values.
     */
    public function test_category_deleted(): void {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();
        $category = $this->getDataGenerator()->create_category();
        $keep = $this->getDataGenerator()->create_category();
        $field = $this->create_field('department');
        $this->add_value($field, $category->id, 'Engineering');
        $this->add_value($field, $keep->id, 'Sales');

        \core_course_category::get($category->id)->delete_full(false);

        $this->assertFalse($DB->record_exists('customfield_data', ['fieldid' => $field->get('id'), 'instanceid' => $category->id]));
        $this->assertTrue($DB->record_exists('customfield_data', ['fieldid' => $field->get('id'), 'instanceid' => $keep->id]));
    }

    /**
     * The area uses the common pages of local_fieldssuite and its own admin page.
     */
    public function test_common_pages(): void {
        $handler = category_handler::create();
        $this->assertInstanceOf(\local_fieldssuite\customfield\area_handler::class, $handler);
        $this->assertSame('tool_categorycustomfields', $handler->get_admin_section());
        $this->assertSame('/local/fieldssuite/edit.php', strtok($handler->get_edit_url(3)->out_as_local_url(false), '?'));
        $this->assertSame(
            ['component' => 'tool_categorycustomfields', 'area' => 'category', 'id' => '3'],
            $handler->get_edit_url(3)->params()
        );
        $this->assertSame('/local/fieldssuite/manage.php', strtok($handler->get_configuration_url()->out_as_local_url(false), '?'));
    }
}
