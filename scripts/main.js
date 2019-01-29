let navigation = $('.nav-primary');
let menu = $('.main-nav');
let subMenu = $('.sub-menu');
let logo = $('.brand');
let menuLink = $('.nav-link');
let submenuLink = $('.sub-menu-link');
let toggleMenu = $('.toggle-menu');

const clippedMenu = 50;

let headerHeight = navigation.height() - clippedMenu + subMenu.height();

const resolutionSmall = 670;
let isResLarge = true;

$(window).resize(function () {

	isResLarge = window.innerWidth > resolutionSmall;

	// Change menu according to resolution
	if (isResLarge) {

		if (menu.css('display') === 'block') {
			menu.css({
				display: 'flex',
				transform: 'translateX(0)',
				opacity: '1'
			});

			hideSubmenu();
		}



	} else {

		// Hide menu and show button
		hideMainMenu();

		// Change visibility to all submenus
		subMenu.css({
			opacity: '1',
			visibility: 'visible',
			transform: 'translateY(0)'
		});

		// Deactivate all menu links
		submenuLink.each(function () {
			makeSubMenuLinkUnActive($(this));
		});
	}
});

$(window).scroll(function () {

	//Check if resolution is bigger
	if (isResLarge) {
		let wScroll = $(this).scrollTop();
		let headScroll = (-wScroll / 2);
		let faderScroll = (wScroll / 400);
		let fadeToColor = Math.min(faderScroll, 1);

		// Parallax background on Products section
		$('.products.section-header').css({
			backgroundPosition: '0' + (headScroll / 5) + 'px'
		});

		// Make navigation smaller when scroll down
		if (wScroll > 500) {
			navigation.addClass('clipped');
		} else {
			navigation.removeClass('clipped');
			// Hide submenus only on bigger monitors (not mobile)
			if (checkIfResolutionIsBigger()) {
				hideSubmenu();
			}
		}
	}
});

$(document).on('scroll', changeMenuOnScroll);

// Get all links
// Remove links that don't actually link to anything
$('a[href*="#"]')
	.not('[href="#"]')
	.not('[href="#0"]')
	.not('[href=""]')
	.on('click', function (e) {
		e.preventDefault();
		$(document).off('scroll');

		let target = $(this).attr('href'); //Get the target

		// Get menu height

		let scrollToPosition = $(target).offset().top - headerHeight;
		if (!checkIfResolutionIsBigger()) {
			scrollToPosition = $(target).offset().top - navigation.height();
		}

		// Correct menu height if no submenu
		// Check if e.target is a sub-menu link or scroll button
		if ($(e.target).parent().find('.sub-menu').length === 0
			&& $(e.target).parent().parent()[0].className !== 'sub-menu'
			&& $(e.target).parent()[0].id !== 'scroll-arrow') {
			scrollToPosition = $(target).offset().top;
		}

		//smooth scroll
		$('html, body').animate({
			'scrollTop': scrollToPosition
		}, 1000, 'swing', function () {
			window.location.hash = target;
			$('html').animate({'scrollTop': scrollToPosition + 1}, 0);

			$(document).on('scroll', changeMenuOnScroll);
		});
	});

menuLink.click(function () {
	makeMenuLinkActive(this);

	if (!checkIfResolutionIsBigger()) {
		hideMainMenu();
		enableScroll();
	}
});

submenuLink.click(function () {
	if (!checkIfResolutionIsBigger()) {
		hideMainMenu();
		enableScroll();
	}
});

toggleMenu.click(function () {
	if (menu.css('opacity') === '0') {
		showMainMenu();
		disableScroll();
	}
	else {
		hideMainMenu();
		enableScroll();
	}
});

logo.click(function () {
	if (checkIfResolutionIsBigger()) {
		menuLink.parent().removeClass('active');
		hideSubmenu();
	} else {
		hideMainMenu();
	}
});

function disableScroll () {
	$('body').css('overflow', 'hidden');
}

function enableScroll () {
	$('body').css('overflow', 'auto');
}

function changeMenuOnScroll () {

	// Check if resolution is bigger
	if (isResLarge) {
		let scrollPos = $(document).scrollTop() + headerHeight;

		// Add class 'active' to pressed menu link, remove class 'active' from current active menu link
		menuLink.each(function () {
			let currLink = $(this);
			let targetedSection = $(currLink.attr('href'));

			if (Math.floor(targetedSection.position().top) <= scrollPos
				&& targetedSection.position().top + targetedSection.height() > scrollPos) {
				makeMenuLinkActive(currLink);
			}
			else {
				currLink.parent().removeClass('active');
			}
		});

		submenuLink.each(function () {
			let currLink = $(this);
			let refElement = $(currLink.attr('href'));

			if (refElement.length !== 0
				&& refElement.position().top <= scrollPos
				&& refElement.position().top + refElement.height() > scrollPos) {
				makeSubMenuLinkActive(currLink);
			}
			else {
				makeSubMenuLinkUnActive(currLink);
			}
		});
	}
}

function showMainMenu () {
	menu.css({
		display: 'block',
		opacity: '1',
		transform: 'translateX(0)'
	});
}

function hideMainMenu () {
	menu.css({
		display: 'block',
		opacity: '0',
		transform: 'translateX(100%)'
	});
}

function makeSubMenuLinkActive (el) {
	$(el).addClass('active');
}

function makeSubMenuLinkUnActive (el) {
	$(el).removeClass('active');
}

function makeMenuLinkActive (link) {
	menuLink.parent().removeClass('active');
	$(link).parent().addClass('active');

	if (checkIfResolutionIsBigger()) {
		hideSubmenu();
		showSubMenu($(link).parent().find('.sub-menu'));
	}
}

function hideSubmenu () {
	$('.sub-menu').css({
		'opacity': '0',
		'visibility': 'hidden',
		'transform': 'translateY(-60%)',
	});
}

function showSubMenu (el) {
	$(el).css({
		'opacity': '1',
		'visibility': 'visible',
		'transform': 'translateY(0)',
		'transition': 'all .8s cubic-bezier(0.55, 0, 0.1, 1)'
	});
}

function checkIfResolutionIsBigger () {
	return window.innerWidth > resolutionSmall;
}


