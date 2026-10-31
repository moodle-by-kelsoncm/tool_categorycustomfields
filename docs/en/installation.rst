Installation
============

Requirements
------------

* Moodle 4.5 LTS or 5.3 LTS.
* PHP supported by your Moodle version.

From a ZIP file
---------------

1. Download ``tool_categorycustomfields-<version>.zip`` from the `releases <https://github.com/moodle-by-kelsoncm/tool_categorycustomfields/releases>`_.
2. Go to *Site administration > Plugins > Install plugins*, upload the ZIP and follow the steps.
3. Finish the upgrade at *Site administration > Notifications*.

From source
-----------

Copy the repository to ``admin/tool/categorycustomfields`` (``public/admin/tool/categorycustomfields`` on Moodle 5.1 or later) and visit *Site administration > Notifications*:

.. code-block:: bash

   git clone https://github.com/moodle-by-kelsoncm/tool_categorycustomfields.git public/admin/tool/categorycustomfields

Languages
---------

The package ships only the English strings. Other languages, including Brazilian Portuguese, come from the Moodle translation tool (AMOS), through the language packs.
