Usage
=====

Editing the values
------------------

Open the category (*Courses > the category*), then *Custom fields* in the category menu (under *More* when the menu does not fit). The form lists the fields you can edit, grouped by field category. Save to go back to the category page.

.. figure:: img/edit.png
   :alt: The form that edits the custom field values of a category.
   :width: 100%

   Editing the values of a category.

On the category page
--------------------

The values visible to you appear next to the category description, as a list of names and values. Empty values are not shown.

Web service
-----------

``tool_categorycustomfields_get_values`` takes a list of category ids and returns, for each category the user can see, the fields the user can see:

* ``shortname``, ``name`` and ``type`` of the field;
* ``value``: the stored value;
* ``displayvalue``: the value formatted for display.

Categories that do not exist or that the user cannot see are reported in ``warnings``. The function is available to AJAX calls and to the Moodle app service; add it to a custom external service to use it with a token.

.. code-block:: bash

   curl "https://moodle.example/webservice/rest/server.php?wstoken=TOKEN&moodlewsrestformat=json&wsfunction=tool_categorycustomfields_get_values&categoryids[0]=2"

Deleting a category
-------------------

When a category is deleted, its values are deleted too. The fields stay.
