var navSiteToggle, navSite, navSiteParent, navSiteChildren,
	w = window, d = document, e = d.documentElement, g = d.getElementsByTagName('body')[0], x, // y
	resolutionBreakPoint = 768, resolutionState = false, resizeTimer,
	overlayDiv, overlayFadeSpeed = 250, modalClose, modalShare,
	toggleShare, shareURL, shareTitle, urlEncoded, titleEncoded, prevFocus,
	tableElement, tableWrapperClass = 'table-wrapper',
	problemElements,
	widgetCategories, widgetsSidebar, widgetsSidebarHeader,
	widgetsToCollapse =	[	'.widget_archive',	'.widget_categories',		'.widget_pages',
							'.widget_meta', 	'.widget_recent_comments',	'.widget_recent_entries',
							'.widget_rss',		'.widget_nav_menu',			'.widget_calendar',
							'.widget_text',		'.widget_tag_cloud',		'.widget_search'	];

jQuery.noConflict();
(function($) {
	$(function() {
		navSiteToggle = $('.nav-site-toggle');
		navSite = $('nav.site');
		navSiteParent = navSite.find('.parent');
		navSiteChildren = navSite.find('.sub-menu, .children');
		overlayDiv = $('.overlay');
		modalClose = $('.modal-close, .overlay:not(.modal)');
		modalShare = $('.modal-share');
		toggleShare = $('button.share');
		tableElement = $('table:not(#wp-calendar)');
		problemElements = $('embed, iframe, object, .video-player');
		widgetCategories = $('.widget_categories');
		widgetsSidebar = $(widgetsToCollapse.join(','));
		widgetsSidebarHeader = widgetsSidebar.find('h4');
		
		resolutionCheck();
		$(window).resize(function() {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function() {
				resolutionCheck();
			}, 300);
		});
		
		navSiteToggle.click(function() {
			$(this).toggleClass('active');
			navSite.slideToggle();
		});
		navSiteParent.children('a').after('<button class="sub-menu-toggle btn btn-default pull-right"><i class="fa fa-angle-down"></i> <span class="sr-only">Toggle Subpages</span></button>');
		$('.sub-menu-toggle').on('click', function() {
			$(this).toggleClass('active').siblings('.sub-menu, .children').slideToggle();
		});
		
		modalClose.click(function(e) {
			e.preventDefault();
			$('.modal.visible').removeClass('visible');
			overlayDiv.fadeOut(overlayFadeSpeed);
			prevFocus.focus();
		});
		
		toggleShare.css({display:'inline-block'}).click(function(e) {
			prevFocus = $(this);
			e.preventDefault();
			shareURL = $(this).attr('href');
			shareTitle = $(this).attr('title');
			linkShare(shareURL, shareTitle);
		});
		
		if (tableElement.length > 0) {
			tableElement.each(function() {
				if (!$(this).parent().hasClass(tableWrapperClass)) {
					$(this).wrap('<div class="' + tableWrapperClass + ' shadowed-right"><div class="table-scroll"></div></div>');
				}
			});
			$('.table-scroll').on('scroll', function() {
				if ($(this).scrollLeft() > 0 && ! $(this).parent().hasClass('shadowed-left')) {
					$(this).parent().addClass('shadowed-left');
				} else if ($(this).scrollLeft() === 0 && $(this).parent().hasClass('shadowed-left')) {
					$(this).parent().removeClass('shadowed-left');
				}
				if ($(this).scrollLeft() < $(this).width() && ! $(this).parent().hasClass('shadowed-right')) {
					$(this).parent().addClass('shadowed-right');
				} else if ($(this).scrollLeft() >= ($(this).find('table').width() - $(this).width()) && $(this).parent().hasClass('shadowed-right')) {
					$(this).parent().removeClass('shadowed-right');
				}
			});
		}
		
		if (problemElements.length > 0) {
			problemElements.each(function() {
				if (!$(this).parent().hasClass('video-wrapper')) {
					$(this).wrap('<div class="video-wrapper"/>');
				}
			});
		}
		
		if (widgetCategories.length > 0) {
			widgetCategories.each(function() {
				var popularityBars = $(this).find('.popularity'),
					highestPopularity = 0;
				if (popularityBars.length > 0) {
					popularityBars.each(function(i) {
						var currentPopularity = parseInt($(this).data('post-count'));
						if (currentPopularity > highestPopularity) {
							highestPopularity = currentPopularity;
						}
						if (i === popularityBars.length - 1) {
							popularityBars.each(function() {
								var barWidth = (parseInt($(this).data('post-count')) / highestPopularity) * 100;
								$(this).css({width: barWidth + '%'});
							});
						}
					});
				}
			});
		}

		$('nav.site li').each(function(i) {
			var id = i + 1;
			$(this).attr('data-li', id);
			$(this).children('a').attr('data-li-p', id);
			$(this).children('.sub-menu').find('a').attr('data-li-g', id);
			$(this).children('.sub-menu').find('.sub-menu').find('a').attr('data-li-gg', id);
		});
	});
	
	function setUpMenu() {
		switch (resolutionState) {
			case 'mobile':
				$('*:not(nav.site a)').unbind('focus');
				$('nav.site a').unbind('focus');
				break;
			case 'desktop':
				$('*:not(nav.site a)').focus(function() {
					if ( $('nav.site .open').length > 0 ) {
						$('nav.site .open').removeClass('open');
					}
				});
				$('nav.site a').focus(function() {
					var p = $(this).data('li-p'),
						g = ( typeof $(this).data('li-g') !== 'undefined' ) ? $(this).data('li-g') : false,
						gg = ( typeof $(this).data('li-gg') !== 'undefined' ) ? $(this).data('li-gg') : false,
						selector = 'nav.site li[data-li=' + p + ']';
					
					if ( gg ) {					// great grandparent
						return false;
					} else if ( g && !gg ) {	// grandparent
						if ( ! $(selector).hasClass('open') ) {
							$('nav.site .sub-menu li.open').removeClass('open');
							$(selector).addClass('open');
						}
					} else {					// parent
						if ( ! $(selector).hasClass('open') ) {
							$('nav.site li.open').removeClass('open');
							$(selector).addClass('open');
						}
					}
				});
				break;
		}
	}

	function resolutionCheck() {
		x = w.innerWidth || e.clientWidth || g.clientWidth;
		// y = w.innerHeight || e.clientHeight || g.clientHeight;
		
		if (x < resolutionBreakPoint && resolutionState !== 'mobile') {
			// Navigation (Main)
			navSiteToggle.show();
			navSite.hide();
			$('.sub-menu-toggle').show();
			navSiteChildren.hide();
			
			// Navigation (Sidebar)
			if (widgetsSidebar.find('h4') > 0) {
				widgetsSidebar.children(':not(h4)').hide();
				widgetsSidebarHeader.click(function() {
					$(this).toggleClass('active');
					$(this).siblings().slideToggle();
				});
			}
			resolutionState = 'mobile';
			setUpMenu();
		} else if (x >= resolutionBreakPoint && resolutionState !== 'desktop') {
			// Navigation (Main)
			navSiteToggle.removeAttr('style').removeClass('active');
			navSite.removeAttr('style');
			$('.sub-menu-toggle').hide().removeClass('active');
			navSiteChildren.removeAttr('style');
			
			// Navigation (Sidebar)
			if (widgetsSidebar.find('h4') > 0) {
				widgetsSidebar.children(':not(h4)').removeAttr('style');
				widgetsSidebarHeader.unbind('click');
			}
			resolutionState = 'desktop';
			setUpMenu();
		}
	}
	
	function linkShare(url, title) {
		var socialMediums = [
			{ name: 'Facebook',		url: 'http://www.facebook.com/sharer.php?p[title]=<TITLE>&u=<URL>' },
			{ name: 'Twitter',		url: 'http://twitter.com/share?text=<TITLE>&url=<URL>' },
			{ name: 'Google',		url: 'https://plus.google.com/share?url=<URL>' },
			{ name: 'LinkedIn',		url: 'http://www.linkedin.com/shareArticle?mini=true&url=<URL>&title=<TITLE>' },
			{ name: 'Pinterest',	url: 'http://pinterest.com/pin/create/button/?url=<URL>&description=<TITLE>' },
			{ name: 'Tumblr',		url: 'http://www.tumblr.com/share/link?url=<URL>&amp;name=<TITLE>' },
		];
		urlEncoded = encodeURIComponent(url);
		titleEncoded = encodeURIComponent(title);
		var outputHTML = '<nav class="social-share" role="navigation"><ul>';
		for (var i = 0; i < socialMediums.length; i++) {
			var mediumClass = socialMediums[i].name.toLowerCase(),
				mediumURL = socialMediums[i].url.replace(/<URL>/, urlEncoded).replace(/<TITLE>/, titleEncoded);
			outputHTML += '<li><a class="' + mediumClass + '" href="' + mediumURL + '" target="_blank" title="Share on ' + socialMediums[i].name + '">' + socialMediums[i].name + '</a></li>';
		}
		outputHTML += '</ul>';
		if (overlayDiv.css('display') !== 'block') {
			overlayDiv.fadeIn(overlayFadeSpeed, function() {
				modalShare.addClass('visible').find('.content').html(outputHTML);
				modalShare.find('a:first').focus();
			});
		}
	}
})(jQuery);