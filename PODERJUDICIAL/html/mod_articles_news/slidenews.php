<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
if (empty($list))
{
	return;
}
?>
<!-- Slider main container -->
<div class="mod-articlesnews newsflash-horiz mod-list">
  <!-- Additional required wrapper -->
  <div class="swiper-wrapper">
    <!-- Slides -->
	<?php foreach ($list as $item) : ?>
        <div class="swiper-slide jblog">
			<?php require ModuleHelper::getLayoutPath('mod_articles_news', '_item'); ?>
		 </div>
	<?php endforeach; ?>
  </div>
  <!-- If we need pagination -->
  <div class="swiper-pagination"></div>
</div>
