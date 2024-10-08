<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.ecotarcoles
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

$path = JURI::base(true).'/templates/'.$app->getTemplate().'/';

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon-pinned.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#000']);

// CUSTOM
// Add template scripts
JHtml::_('script', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/custom_js/template.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/custom_js/accesibilidad.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/custom_js/switch_hear.js', array('version' => 'auto'));



// END CUSTOM

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

// Color Theme
$paramsColorName = $this->params->get('colorName', 'colors_standard');
$assetColorName  = 'theme.' . $paramsColorName;
$wa->registerAndUseStyle($assetColorName, 'media/templates/site/ecotarcoles/css/global/' . $paramsColorName . '.css');

// Use a font scheme if set in the template style options
$paramsFontScheme = $this->params->get('useFontScheme', false);
$fontStyles       = '';

if ($paramsFontScheme) {
    if (stripos($paramsFontScheme, 'https://') === 0) {
        $this->getPreloadManager()->preconnect('https://fonts.googleapis.com/', ['crossorigin' => 'anonymous']);
        $this->getPreloadManager()->preconnect('https://fonts.gstatic.com/', ['crossorigin' => 'anonymous']);
        $this->getPreloadManager()->preload($paramsFontScheme, ['as' => 'style', 'crossorigin' => 'anonymous']);
        $wa->registerAndUseStyle('fontscheme.current', $paramsFontScheme, [], ['media' => 'print', 'rel' => 'lazy-stylesheet', 'onload' => 'this.media=\'all\'', 'crossorigin' => 'anonymous']);

        if (preg_match_all('/family=([^?:]*):/i', $paramsFontScheme, $matches) > 0) {
            $fontStyles = '--ecotarcoles-font-family-body: "' . str_replace('+', ' ', $matches[1][0]) . '", sans-serif;
			--ecotarcoles-font-family-headings: "' . str_replace('+', ' ', isset($matches[1][1]) ? $matches[1][1] : $matches[1][0]) . '", sans-serif;
			--ecotarcoles-font-weight-normal: 400;
			--ecotarcoles-font-weight-headings: 700;';
        }
    } else {
        $wa->registerAndUseStyle('fontscheme.current', $paramsFontScheme, ['version' => 'auto'], ['media' => 'print', 'rel' => 'lazy-stylesheet', 'onload' => 'this.media=\'all\'']);
        $this->getPreloadManager()->preload($wa->getAsset('style', 'fontscheme.current')->getUri() . '?' . $this->getMediaVersion(), ['as' => 'style']);
    }
}

// Enable assets
$wa->usePreset('template.ecotarcoles.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'))
    ->useStyle('template.active.language')
    ->useStyle('template.user')
    ->useScript('template.user')
    ->addInlineStyle(":root {
		--hue: 214;
		--template-bg-light: #f0f4fb;
		--template-text-dark: #495057;
		--template-text-light: #ffffff;
		--template-link-color: #2a69b8;
		--template-special-color: #001B4C;
		$fontStyles
	}");

// Override 'template.active' asset to set correct ltr/rtl dependency
$wa->registerStyle('template.active', '', [], [], ['template.ecotarcoles.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr')]);

// Logo file or site title param
if ($this->params->get('logoFile')) {
  $logo = HTMLHelper::_('image', Uri::root(false) . htmlspecialchars($this->params->get('logoFile'), ENT_QUOTES), $this->params->get('siteTitle'), ['loading' => 'eager', 'decoding' => 'async'], false, 0);
} elseif ($this->params->get('siteTitle')) {
  $logo = '<span title="' . $sitename . '">' . htmlspecialchars($this->params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
} else {
  $logo = HTMLHelper::_('image', 'logo.svg', $sitename, ['class' => 'logo d-inline-block', 'loading' => 'eager', 'decoding' => 'async'], true, 0);
}

$hasClass = '';

if ($this->countModules('sidebar-left', true)) {
    $hasClass .= ' has-sidebar-left';
}

if ($this->countModules('sidebar-right', true)) {
    $hasClass .= ' has-sidebar-right';
}

// Container
$wrapper = $this->params->get('fluidContainer') ? 'wrapper-fluid' : 'wrapper-static';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$stickyHeader = $this->params->get('stickyHeader') ? 'position-sticky sticky-top' : '';

// Defer fontawesome for increased performance. Once the page is loaded javascript changes it to a stylesheet.
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/custom_css/custom.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/custom_css/accesibilidad.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/custom_css/responsive.css" />
    <!-- END CUSTOM CSS -->

</head>

<body class="site <?php echo $option
    . ' ' . $wrapper
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '')
    . ($pageclass ? ' ' . $pageclass : '')
    . $hasClass
    . ($this->direction == 'rtl' ? ' rtl' : '');
?>">
    <header class="header container-header full-width<?php echo $stickyHeader ? ' ' . $stickyHeader : ''; ?>">

        <?php if ($this->countModules('topbar')) : ?>
            <div class="container-topbar">
            <jdoc:include type="modules" name="topbar" style="none" />
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('below-top')) : ?>
            <div class="grid-child container-below-top">
                <jdoc:include type="modules" name="below-top" style="none" />
            </div>
        <?php endif; ?>

        <?php if ($this->params->get('brand', 1)) : ?>
            <div class="grid-child">
                <div class="navbar-brand">
                  <!-- <a class="brand-logo" target="_blank" href="https://pj.poder-judicial.go.cr/" style="margin-left: 10px;">
                    <img loading="eager" decoding="async" src="<?php //echo $path;?>/img/logo-poder.svg" alt="Ir a la página de inicio de:">
                  </a> -->
                    <a class="brand-logo" href="<?php echo $this->baseurl; ?>/">
                        <?php echo $logo; ?>
                    </a>
                    <?php if ($this->params->get('siteDescription')) : ?>
                        <div class="site-description"><?php echo htmlspecialchars($this->params->get('siteDescription')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('menu', true) || $this->countModules('search', true)) : ?>
            <div class="grid-child container-nav">
                <?php if ($this->countModules('menu', true)) : ?>
                    <jdoc:include type="modules" name="menu" style="none" />
                <?php endif; ?>
                <?php if ($this->countModules('search', true)) : ?>
                    <div class="container-search">
                        <jdoc:include type="modules" name="search" style="none" />
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
        $app = JFactory::getApplication();
        $path = JURI::base(true).'/templates/'.$app->getTemplate().'/';
        ?>
        <script src="https://code.responsivevoice.org/responsivevoice.js" type="text/javascript"></script>
        <div class="_switchHear" id="switchHear" title="Habilitar/deshabilitar lectura de contenido" data_url = "<?php echo $path;?>" style="background-image: url(<?php echo $path;?>/img/icon-ear-on.jpg);"></div>

    </header>

    <div class="site-grid containerCustom">
        <?php if ($this->countModules('banner', true)) : ?>
            <div class="container-banner full-width">
                <jdoc:include type="modules" name="banner" style="none" />
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('top-a', true)) : ?>
        <div class="grid-child container-top-a">
            <jdoc:include type="modules" name="top-a" style="card" />
        </div>
        <?php endif; ?>

        <?php if ($this->countModules('top-b', true)) : ?>
        <div class="grid-child container-top-b">
            <jdoc:include type="modules" name="top-b" style="card" />
        </div>
        <?php endif; ?>

        <?php if ($this->countModules('sidebar-left', true)) : ?>
        <div class="grid-child container-sidebar-left">
            <jdoc:include type="modules" name="sidebar-left" style="card" />
        </div>
        <?php endif; ?>

        <div class="grid-child container-component">
            <jdoc:include type="modules" name="breadcrumbs" style="none" />
            <jdoc:include type="modules" name="main-top" style="card" />
            <jdoc:include type="message" />
            <main>
            <jdoc:include type="component" />
            </main>
            <jdoc:include type="modules" name="main-bottom" style="card" />
        </div>

        <?php if ($this->countModules('sidebar-right', true)) : ?>
        <div class="grid-child container-sidebar-right">
            <jdoc:include type="modules" name="sidebar-right" style="card" />
        </div>
        <?php endif; ?>

        <?php if ($this->countModules('bottom-a', true)) : ?>
        <div class="grid-child container-bottom-a">
            <jdoc:include type="modules" name="bottom-a" style="card" />
        </div>
        <?php endif; ?>

        <?php if ($this->countModules('bottom-b', true)) : ?>
        <div class="grid-child container-bottom-b">
            <jdoc:include type="modules" name="bottom-b" style="card" />
        </div>
        <?php endif; ?>
    </div>

    <?php if ($this->countModules('footer', true)) : ?>
    <footer class="container-footer footer full-width">



        <div class="grid-child">
            <jdoc:include type="modules" name="footer" style="none" />
        </div>
    </footer>
    <?php endif; ?>

    <?php if ($this->params->get('backTop') == 1) : ?>
        <a href="#top" id="back-top" class="back-to-top-link" aria-label="<?php echo Text::_('TPL_ecotarcoles_BACKTOTOP'); ?>">
            <span class="icon-arrow-up icon-fw" aria-hidden="true"></span>
        </a>
    <?php endif; ?>

    <jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
