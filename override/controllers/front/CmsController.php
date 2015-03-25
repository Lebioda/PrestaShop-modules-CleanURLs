<?php

/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 *  @author      ZiZuu.com <info@zizuu.com>
 *  @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  @source      https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs
 */

class CmsController extends CmsControllerCore
{
	public function init()
	{
		if ($cms_rewrite = Tools::getValue('cms_rewrite'))
		{
			$sql = 'SELECT l.`id_cms`
				FROM `'._DB_PREFIX_.'cms_lang` l
				LEFT JOIN `'._DB_PREFIX_.'cms_shop` s ON (l.`id_cms` = s.`id_cms`)
				WHERE l.`link_rewrite` = \''.pSQL($cms_rewrite).'\'';

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
				$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();

			$id_cms = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
			if ($id_cms > 0)
				$_GET['id_cms'] = $id_cms;
		}
		elseif ($cms_category_rewrite = Tools::getValue('cms_category_rewrite'))
		{
			$sql = 'SELECT `id_cms_category`
				FROM `'._DB_PREFIX_.'cms_category_lang`
				WHERE `link_rewrite` = \''.pSQL($cms_category_rewrite).'\'';

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
				$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();

			$id_cms_category = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
			if ($id_cms_category > 0)
				$_GET['id_cms_category'] = $id_cms_category;
		}

		parent::init();
	}
}
