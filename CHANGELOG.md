# Changelog

## 1.0.0 - 2026-10-31

First release.

### Added
- Custom field area for course categories, with every field type installed on the site; values kept in the category context.
- Field management at *Site administration > Courses > Category custom fields*, with the area settings *Locked* and *Visible on the category page to* (everyone, users who can edit the values, nobody).
- Value editing from the category settings menu (*Custom fields*).
- Visible values shown on the category page, next to the category description.
- `tool_categorycustomfields_get_values` web service (also available to AJAX and the mobile app), returning the values the user can see.
- Values deleted when their category is deleted.
- Capabilities `tool/categorycustomfields:configurecustomfields`, `tool/categorycustomfields:edit` and `tool/categorycustomfields:changelockedcustomfields`.
- Privacy API provider, PHPUnit tests, CI with moodle-plugin-ci (Moodle 4.5 and 5.3, PostgreSQL and MariaDB), documentation in English and Brazilian Portuguese, release by draft and verification.
