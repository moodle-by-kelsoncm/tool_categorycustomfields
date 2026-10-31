Configuration
=============

Creating fields
---------------

Go to *Site administration > Courses > Category custom fields*. The page works like the course custom fields page:

1. *Add a new category* to group the fields (each group becomes a section of the editing form).
2. *Add a new custom field* and choose its type: text, text area, menu, checkbox, date or any other installed type.
3. Fill in the name, the short name (used by the web service), the description and the type settings.

.. figure:: img/settings.png
   :alt: The settings of a category custom field, with the Locked and Visible to options.
   :width: 100%

   The area settings at the end of the field form.

Area settings
-------------

Locked
   Only users with ``tool/categorycustomfields:changelockedcustomfields`` can edit the value.

Visible to
   * *Everyone*: everyone who can see the category, on the category page and through the web service.
   * *Users who can edit the values*: only users with ``tool/categorycustomfields:edit`` in the category.
   * *Nobody*: the value is not shown and not returned by the web service. Users who can edit the values still see it on the editing page.

Capabilities
------------

``tool/categorycustomfields:configurecustomfields`` (system)
   Manage the fields. Manager by default.

``tool/categorycustomfields:edit`` (category)
   Edit the values of a category and see the fields visible to editors. Manager by default, and copied from ``moodle/category:manage`` on install.

``tool/categorycustomfields:changelockedcustomfields`` (category)
   Edit locked fields. Manager by default.
