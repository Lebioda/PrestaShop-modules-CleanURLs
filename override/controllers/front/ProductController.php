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

class ProductController extends ProductControllerCore
{
	public function init()
	{
		if ($product_rewrite = Tools::getValue('product_rewrite'))
		{
			$url_id_pattern = '/.*?([0-9]+)\-([a-zA-Z0-9-]*)(\.html)?/';

			$sql = 'SELECT `id_product`
				FROM `'._DB_PREFIX_.'product_lang`
				WHERE `link_rewrite` = \''.pSQL($product_rewrite).'\' AND `id_lang` = '.(int)Context::getContext()->language->id;
			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
				$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();

			$id_product = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
			if ($id_product > 0)
				$_GET['id_product'] = $id_product;
			elseif (preg_match($url_id_pattern, $_SERVER['REQUEST_URI'], $url_split))
			{
				$sql = 'SELECT `id_product`
					FROM `'._DB_PREFIX_.'product_lang`
					WHERE `id_product` = \''.pSQL($url_split[1]).'\' AND `id_lang` = '.(int)Context::getContext()->language->id;

				if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
					$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();
					
				$id_product = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
				if($id_product > 0)
					$_GET['id_product'] = $id_product;
			}
		}

		parent::init();
	}
}
