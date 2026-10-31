moodle-tool_categorycustomfields
================================

**Custom fields for course categories: manage them like course custom fields, edit the values in each category and show them on the category page.**

.. figure:: img/display.png
   :alt: A category page showing the custom field values above the list of courses.
   :width: 100%

   The visible values appear on the category page, next to the description.

* **Fields where Moodle has none.** Moodle has custom fields for courses, cohorts and groups, but not for categories. This tool adds the missing area.
* **Every field type.** Text, text area, menu, checkbox, date and any other custom field type installed on the site, with the usual settings (required, unique, default value).
* **Control who sees each value.** Every field is visible to everyone, only to those who can edit the values, or to nobody.
* **Ready for integrations.** A web service returns the values the user can see.

Versão em português: `Português (Brasil) <../pt-br/index.html>`_.

.. toctree::
   :maxdepth: 2
   :caption: Contents

   installation
   configuration
   usage

Main features
-------------

* Field management at *Site administration > Courses > Category custom fields*, with the same interface as course custom fields.
* Area settings per field: *Locked* and *Visible on the category page to*.
* Value editing from the category settings menu, with capabilities in the category context.
* Visible values on the category page.
* ``tool_categorycustomfields_get_values`` web service, also available to AJAX and the Moodle app.
* Values deleted together with their category.
* **Moodle 4.5 LTS and 5.3 LTS**: tested on a CI matrix with PostgreSQL and MariaDB.

Links
-----

* Source code and issues: https://github.com/moodle-by-kelsoncm/tool_categorycustomfields
