jQuery( document ).ready(function() {
  jQuery('body h1, body h2, body h3, body h4, body p, body li').attr('tabindex','0');
  //jQuery('body p a, body a p, body li a').attr('tabindex','-1'); //Quitar los tabindex en caso de que dentro de algún elemento (p, li, ol, span, etc.) contenga otro elemento con tabindex "automático" por ejemplo los links (a)

  //JS para el TAB del menú con la extensión DJ-megamenu
  //menu desktop

  jQuery('ul.dj-megamenu-default li .dj-subwrap').addClass( "dj-first-level" );
  jQuery('ul.dj-submenu li .dj-subwrap').removeClass( "dj-first-level" );
  jQuery('ul.dj-submenu li .dj-subwrap').addClass( "dj-next-level" );

  jQuery('ul#dj-megamenu111').on('focus', '.dj-up', function() {
    jQuery('ul#dj-megamenu111 .dj-up').removeClass( "hover" );
    jQuery('.dj-first-level').removeClass("fadeInUp").addClass("zoomOut");
    jQuery(this).addClass( "hover" );
    jQuery(this).children(".dj-subwrap").removeClass("zoomOut").addClass( "fadeInUp" );
  });




  //menu tercer nivel hacia adelante
  jQuery('ul.dj-submenu').on('focus', 'li', function() {
    jQuery(this).addClass( "hover" );
    jQuery(this).children(".dj-subwrap").removeClass("zoomOut").addClass( "fadeInUp" );
  });

  jQuery('ul.dj-submenu').on('blur', 'li.parent:last-child', function(e) {
    jQuery('ul.dj-submenu .li').removeClass( "hover" );
    jQuery('.dj-next-level').removeClass("fadeInUp").addClass("zoomOut");
  });
  //menu tercer nivel hacia adelante

  jQuery('li.dj-up a').attr('tabindex','0');

  /////////////////////tab accordion /////////
  jQuery(".dj-up_a span.title").click(function(){
    var href_parent = jQuery(this).parent().attr("href");
    if (href_parent != "" || href_parent != null) {
      window.location.href = href_parent;
    }
  });

  //se comentó ya que genera conficto con otro cod
  // jQuery('.sppb-panel-modern').attr('tabindex','0');
  //
  // jQuery('.sppb-panel-group').on('focus', '.sppb-panel-modern', function() {
  //   jQuery(".sppb-panel-modern").children(".sppb-panel-collapse").hide();
  //   jQuery(this).children(".sppb-panel-collapse").show();
  //   jQuery('#dj-megamenu111offcanvas').removeAttr('style');
  // });

  ////////tab index menu movil///
  jQuery(".dj-mobile-open-btn").attr("tabindex", "0");
  jQuery(".dj-offcanvas-close-btn").attr("tabindex", "0");
  jQuery("#dj-megamenu111mobile").attr("tabindex", "0");

  ////////menu movil///

  //Cambiar el ID del menú.
  jQuery("#dj-megamenu111mobile").focus(function(e) {
    e.preventDefault();
    jQuery(".dj-mobile-open-btn").blur();
    jQuery("body").addClass("dj-offcanvas-anim");
    jQuery("body").addClass("dj-offcanvas-open");
    jQuery("body").addClass("even_focus");
    jQuery(".dj-offcanvas-close-btn").focus();
    return false;
  });
  //blur menu mobile
  //jQuery('ul').on('blur', '.itemid-139', function(e) {
  jQuery('ul.dj-mobile-nav').on('blur', 'li:not(.parent):not(li.parent ul li):last-child', function(e) {
    e.preventDefault();
    jQuery("body").removeClass("dj-offcanvas-anim");
    jQuery("body").removeClass("dj-offcanvas-open");

    setTimeout(function() {
      jQuery(".containerCustom").attr('tabindex','0');
      jQuery(".containerCustom").focus(); }, 100);
    });

    //close menu mobile
    jQuery('#dj-megamenu111offcanvas a.dj-offcanvas-close-btn').on('touchstart', function (e) {
      e.preventDefault();
      if(jQuery(document.body).hasClass('dj-offcanvas-open')){
        jQuery(document.body).removeClass('dj-offcanvas-open');
      }
    });

    //FIN JS para el TAB del menú con la extensión DJ-megamenu

    /*Elemento accordion*/
    jQuery('.sppb-panel-modern, .sppb-panel-custom').attr('tabindex','-1');
    jQuery('.sppb-toggle-direction').attr('tabindex','0');
    jQuery('.sppb-panel-group').on('focus', '.sppb-toggle-direction', function() {
      jQuery(".sppb-panel-modern, .sppb-panel-custom").children(".sppb-panel-collapse").hide();
      jQuery(this).parent().parent().children(".sppb-panel-collapse").show();
    });
    /*Fin Elemento accordion*/


  });
