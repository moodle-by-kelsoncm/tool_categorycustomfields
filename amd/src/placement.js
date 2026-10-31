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
 * Moves the custom field values next to the category description.
 *
 * The values are printed after the main region by a hook; without JavaScript they stay there.
 *
 * @module     tool_categorycustomfields/placement
 * @copyright  2026 onwards Kelson da Costa Medeiros
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

export const init = () => {
    const values = document.querySelector('[data-tool-categorycustomfields="values"]');
    const main = document.querySelector('#region-main [role="main"]');
    if (!values || !main) {
        return;
    }
    const description = main.querySelector('.generalbox.info');
    if (description) {
        description.after(values);
    } else {
        main.prepend(values);
    }
};
