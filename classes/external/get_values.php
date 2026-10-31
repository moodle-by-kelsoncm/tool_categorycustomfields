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

namespace tool_categorycustomfields\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use core_external\external_warnings;
use tool_categorycustomfields\customfield\category_handler;

/**
 * Returns the custom field values of course categories.
 *
 * Only categories the user can see are returned, and only the fields the user can see in each of them.
 *
 * @package    tool_categorycustomfields
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_values extends external_api {
    /**
     * Parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'categoryids' => new external_multiple_structure(
                new external_value(PARAM_INT, 'Course category id'),
                'Course category ids'
            ),
        ]);
    }

    /**
     * Returns the values.
     *
     * @param int[] $categoryids
     * @return array
     */
    public static function execute(array $categoryids): array {
        ['categoryids' => $categoryids] = self::validate_parameters(
            self::execute_parameters(),
            ['categoryids' => $categoryids]
        );

        $result = \local_fieldssuite\external\get_values::get_instances_values(category_handler::create(), $categoryids);
        return ['categories' => $result['instances'], 'warnings' => $result['warnings']];
    }

    /**
     * Returned structure.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'categories' => new external_multiple_structure(new external_single_structure([
                'id' => new external_value(PARAM_INT, 'Course category id'),
                'fields' => \local_fieldssuite\external\get_values::fields_structure(),
            ])),
            'warnings' => new external_warnings(),
        ]);
    }
}
