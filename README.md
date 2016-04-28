[Prestashop module "ZiZuu Clean URLs"](https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs)
=====

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0f609ac9-667f-4840-82d4-464e0f7c31ba/mini.png)](https://insight.sensiolabs.com/projects/0f609ac9-667f-4840-82d4-464e0f7c31ba)
[![GitHub issues](https://img.shields.io/github/issues/ZiZuu-store/zzCleanURLs.svg?style=plastic)](https://github.com/ZiZuu-store/zzCleanURLs/issues)

[![Packagist](https://img.shields.io/packagist/l/zizuu-store/zzcleanurls.svg?style=plastic)](https://creativecommons.org/licenses/by-nc-sa/4.0/)
[![GitHub release](https://img.shields.io/github/release/ZiZuu-store/zzCleanURLs.svg?style=plastic&label=latest)](https://github.com/ZiZuu-store/zzCleanURLs/releases/latest)

[![Packagist](https://img.shields.io/packagist/dt/zizuu-store/zzcleanurls.svg?style=plastic)](https://packagist.org/packages/zizuu-store/zzcleanurls)
[![GitHub stars](https://img.shields.io/github/stars/ZiZuu-store/zzCleanURLs.svg?style=social)](https://github.com/ZiZuu-store/zzCleanURLs/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/ZiZuu-store/zzCleanURLs.svg?style=social&label=Forks)](https://github.com/ZiZuu-store/zzCleanURLs/network)

[![Join the chat at https://gitter.im/ZiZuu-store/zzCleanURLs](https://img.shields.io/badge/Gitter-CHAT%20NOW-brightgreen.svg?style=plastic)](https://gitter.im/ZiZuu-store/zzCleanURLs)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/ZiZuu-store/zzCleanURLs.svg?style=social)](https://twitter.com/intent/tweet?text=Fantastic @PrestaShop module by @ZiZuu_Store: "ZiZuu Clean URLs"&url=https://github.com/ZiZuu-store/zzCleanURLs)

___

We are going to merge other users' contributions and ideas as soon as we note them and find the time to test.

If you fork, please make every change the way we can pull, don't reinvent the wheel .. make every custom change on a private branch, so you can merge your own changes to the community mintained branch every time a new release is out.

* For production use the **latest stable [release](https://github.com/ZiZuu-store/zzCleanURLs/releases/latest)**
* For developing or Pull Request please use only the "**[dev](https://github.com/ZiZuu-store/zzCleanURLs/tree/dev)**" branch

It has been reported to work on **PS 1.5.6 - 1.6.1.x** but will install on PS >= 1.5 too.
**If you succesfully use this module on some older version please report**

# INSTALLATION

Install the module from the Backoffice (administration panel):
- download the lastest [release](https://github.com/ZiZuu-store/zzCleanURLs/releases/latest) ***ZIP*** file (***`zzcleanurls.zip`***) as it already contains the right folder name (`zzcleanurls`, **not** `zzcleanurls-version_x.y.z` !)
- in the modules tab, click on **add a new module**
- click on "`Browse`" to open the dialogue box letting you search your computer
- select the ZIP file you downloaded and validate the dialogue box
- click on "`Upload this module`"
- once uploaded you could have to search the module among the others (tip: filter by author "`zizuu store`") and click on the `install` button

## Make sure your SEO and URL settings are as follows:

This is __MANDATORY__
 * products:         {category:/}{rewrite}              (you **can** add .html at the end)
 * categories:       {categories:/}{rewrite}**/**
 * manufacturers:    manufactures/{rewrite}
 * suppliers:        suppliers/{rewrite}
 * CMS page:         info/{rewrite}                       (you **can** add .html at the end)
 * CMS category:     info/{rewrite}**/**
 * modules:          modules/{module}{/:controller}

You can replace words such as "info", "suppliers", etc with whatever you want, given that it does not conflicts with a category name

Remember to
 * **clear the browser cache**
 * **clear PS cache** (under smarty -> cache and smarty -> compile)

# UNINSTALLATION

* Go to modules -> Find and uninstall "**zzcleanurls**"

**It should suffice!**


If something goes wrong do the following:
* Open folder /override/classes/
 * Remove "Link.php"
 * Remove "Dispatcher.php"
* Open folder /override/controllers/front/
 * Remove "CategoryController.php"
 * Remove "CmsController.php"
 * Remove "ManufacturerController.php"
 * Remove "ProductController.php"
 * Remove "SupplierController.php"
* Open folder /cache/
 * Remove "class_index.php"
* Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL off -> Save
* Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL on -> Save


If you got any other override modules, you should now go to you back office, uninstall them, and reinstall them again to work correctly.

# License

![Creative Commons BY-NC-SA License](https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png)


**[ZiZuu CleanURLs](https://github.com/ZiZuu-store/zzCleanURLs)** by [ZiZuu Store](https://github.com/ZiZuu-store) is licensed under a **Creative Commons [Attribution-NonCommercial-ShareAlike](http://creativecommons.org/licenses/by-nc-sa/4.0/) 4.0 International License**.

Permissions beyond the scope of this license may be available contacting us at info@ZiZuu.com.
