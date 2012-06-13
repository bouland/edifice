INSTALLATION Place the edifice folder into your mod. Enable it from tool administration and configure. Once the plugin is enabled, you will see a Manage categories submenu item in your administration links.

INTEGRATION This plugin can integrate with: 1. Blogs (core plugin v.1.7.6) 2. Bookmarks* (core plugin v.1.7.6) 3. File (core plugin v.1.7.6) 4. Izap videos (izap_videos plugin v.3.81b) 5. Pages** (core plugin v.1.7.6) 6. Tidypics (tidypics plugin v.1.6.8)

* To integrate this plugin with Bookmars, you need to comment out line 66 (//$entity->clearRelationships(); ) in mod/bookmarks/actions/add.php. For now this is the only solution. I will come up with a work around later. ** Only top level pages can be categorized. All children pages will be assigned parent's category (you can change this behavior by editing file/upload.php)

CATEGORY ICONS Sometimes it may take a few minutes for your uploaded image to appear as your category icon. Default category icon by http://sultan-design.deviantart.com/

DROPDOWN MENUS Dropdown menus included in this plugin are copyrighted to Filament Group: http://www.filamentgroup.com/lab/jquery_ipod_style_and_flyout_menus/.

To change the layout/appearance of the menus, roll out a theme using jQuery UI Theme Roller: http://jqueryui.com/themeroller/. Download the 1.7.3 package and copy the appropriate css files and images to mod/edifice/views/default/edifice/js/theme.

You can choose between the flyout and ipod style menus. Comment/uncomment the appropriate line in menulist.php and/or forms/assign.php.

 

TODO:

1. Ability to re-order categories using drag&drop (thanks to Steph aka OpenSource for the suggestion)

2. An add-on to append the search box with a category dropdown

3. Integration with Profile Manager, or an alternative user-category relationship (thanks to Mark Bridges for the suggesion)