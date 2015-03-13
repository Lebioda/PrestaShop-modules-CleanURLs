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
 *  @author	  ZiZuu.com <info@zizuu.com>
 *  @license	 http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  @source	  https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs
 */

class Link extends LinkCore
{
	public function __construct($protocol_link = null, $protocol_content = null)
	{
		parent::__construct($protocol_link, $protocol_content);

		/* TODO
		 * add a configuration switch to hide or show the Home category

		// Re-add Home category
		Link::$category_disable_rewrite = array_diff(Link::$category_disable_rewrite, array(Configuration::get('PS_HOME_CATEGORY')));
		*/
	}

	/**
	 * Create a link to a category
	 *
	 * @param mixed $category Category object (can be an ID category, but deprecated)
	 * @param string $alias
	 * @param int $id_lang
	 * @param string $selected_filters Url parameter to autocheck filters of the module blocklayered
	 * @return string
	 */
	public function getCategoryLink($category, $alias = null, $id_lang = null, $selected_filters = null, $id_shop = null, $relative_protocol = false)
	{
		if (!$id_lang)
			$id_lang = Context::getContext()->language->id;

		$url = $this->getBaseLink($id_shop, null, $relative_protocol).$this->getLangLink($id_lang, null, $id_shop);

		if (!is_object($category))
			$category = new Category($category, $id_lang);

		// Set available keywords
		$params = array();
		$params['id'] = $category->id;
		$params['rewrite'] = (!$alias) ? $category->link_rewrite : $alias;
		$params['meta_keywords'] = Tools::str2url($category->getFieldByLang('meta_keywords'));
		$params['meta_title'] = Tools::str2url($category->getFieldByLang('meta_title'));

		// Selected filters is used by the module blocklayered
		$selected_filters = is_null($selected_filters) ? '' : $selected_filters;

		if (empty($selected_filters))
			$rule = 'category_rule';
		else
		{
			$rule = 'layered_rule';
			$params['selected_filters'] = $selected_filters;
		}

		$dispatcher = Dispatcher::getInstance();

		// XXX: replace 'category_rule' with $rule ? 
		if ($dispatcher->hasKeyword('category_rule', $id_lang, 'parent_categories'))
		{
			// Retrieve all parent categories
			$cats = array();
			foreach ($category->getParentsCategories($id_lang) as $cat)
			{
				self::$category_disable_rewrite[] = $category->id;

				// remove root and current category from the URL
				if (!in_array($cat['id_category'], self::$category_disable_rewrite)) {
					$cats[] = $cat['link_rewrite'];
				}
			}
			// add the URL slashes among categories, in reverse order
			$params['parent_categories'] = implode('/', array_reverse($cats));
		}
		
		return $url.$dispatcher->createUrl($rule, $id_lang, $params, $this->allow, '', $id_shop);
	}


	/**
	 * Get pagination link
	 *
	 * @param string $type Controller name
	 * @param int $id_object
	 * @param boolean $nb Show nb element per page attribute
	 * @param boolean $sort Show sort attribute
	 * @param boolean $pagination Show page number attribute
	 * @param boolean $array If false return an url, if true return an array
	 */
	public function getPaginationLink($type, $id_object, $nb = false, $sort = false, $pagination = false, $array = false)
	{
		// if no parameter $type, try to get it by using the controller name
		if (!$type && !$id_object)
		{
			$method_name = 'get'.Dispatcher::getInstance()->getController().'Link';
			if (method_exists($this, $method_name) && isset($_GET['id_'.Dispatcher::getInstance()->getController()]))
			{
				$type = Dispatcher::getInstance()->getController();
				$id_object = $_GET['id_'.$type];
			}
		}

		if ($type && $id_object)
			$url = $this->{'get'.$type.'Link'}($id_object, null);
		else
		{
			if (isset(Context::getContext()->controller->php_self))
				$name = Context::getContext()->controller->php_self;
			else
				$name = Dispatcher::getInstance()->getController();
			$url = $this->getPageLink($name);
		}

		$vars = array();
		$vars_nb = array('n', 'search_query');
		$vars_sort = array('orderby', 'orderway');
		$vars_pagination = array('p');

		foreach ($_GET as $k => $value)
		{
			// strip var of the form "*_rewrite" from url
			if ($k != 'id_'.$type && $k != $type.'_rewrite' && $k != 'controller')
			{
				if (Configuration::get('PS_REWRITING_SETTINGS') && ($k == 'isolang' || $k == 'id_lang'))
					continue;

				$if_nb = (!$nb || ($nb && !in_array($k, $vars_nb)));
				$if_sort = (!$sort || ($sort && !in_array($k, $vars_sort)));
				$if_pagination = (!$pagination || ($pagination && !in_array($k, $vars_pagination)));
				if ($if_nb && $if_sort && $if_pagination)
					if (!is_array($value))
						$vars[urlencode($k)] = $value;
					else
					{
						foreach (explode('&', http_build_query(array($k => $value), '', '&')) as $key => $val)
						{
							$data = explode('=', $val);
							$vars[urldecode($data[0])] = $data[1];
						}
					}
			}
		}

		if (!$array)
			if (count($vars))
				return $url.(($this->allow == 1 || $url == $this->url) ? '?' : '&').http_build_query($vars, '', '&');
			else
				return $url;
		
		$vars['requestUrl'] = $url;

		if ($type && $id_object)
			$vars['id_'.$type] = (is_object($id_object) ? (int)$id_object->id : (int)$id_object);
			
		if (!$this->allow == 1)
			$vars['controller'] = Dispatcher::getInstance()->getController();

		return $vars;
	}
}
