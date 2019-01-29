$(document).ready(function ({}) {
	let carouselItemsList = $('.carousel-item');
	let prevBtn = $('.carousel-control-prev');
	let nextBtn = $('.carousel-control-next');

	let intervalID;
	let intervalTime = 10000;
	let delayTime = 10000;
	let slideShowStart;

	let lastSlideIndex = carouselItemsList.length - 1;
	let numberOfSlides = carouselItemsList.length;

	let slideNavigation = generateSlideNavigation().children();

	prevBtn.click(() => {
		stopSlideShow();
		loadSlide('prev');
		startSlideShow(intervalTime, delayTime);
	});

	nextBtn.click(() => {
		stopSlideShow();
		loadSlide('next');
		startSlideShow(intervalTime, delayTime);
	});

	startSlideShow(intervalTime, 0);

	$(slideNavigation).each(function () {
		$(this).click(function () {
			stopSlideShow();
			loadSlide($(this).text());
			startSlideShow(intervalTime, delayTime);
		});
	});

	function loadSlide (selected) {
		let activeSlide = getActiveSlide();
		let activeSlideIndex = carouselItemsList.index(activeSlide);
		let elementToShow;

		$(slideNavigation[activeSlideIndex]).removeClass('nav-active');

		if (selected === 'prev') {
			if (activeSlideIndex === 0) {
				activeSlideIndex = numberOfSlides;
			}

			elementToShow = $(carouselItemsList[activeSlideIndex - 1]);
			$(slideNavigation[activeSlideIndex - 1]).addClass('nav-active');

		} else if (selected === 'next') {
			if (activeSlideIndex === lastSlideIndex) {
				activeSlideIndex = -1;
			}

			elementToShow = $(carouselItemsList[activeSlideIndex + 1]);
			$(slideNavigation[activeSlideIndex + 1]).addClass('nav-active');

		} else {
			elementToShow = $(carouselItemsList[selected - 1]);
			$(slideNavigation[selected - 1]).addClass('nav-active');
		}

		elementToShow.addClass('active');
		activeSlide.removeClass('active');
	}

	function generateSlideNavigation () {
		let slidePreviewNav = $('#slide-preview');

		for (let el of carouselItemsList) {
			let activeSlide = getActiveSlide();
			let slidePreviewIcon = $('<span>');

			$(slidePreviewIcon)
				.addClass('slide-preview')
				.append($('<p>')
					.text(carouselItemsList.index(el) + 1)
					.addClass('slide-number'))
				.appendTo(slidePreviewNav);

			if (el === activeSlide[0]) {
				slidePreviewIcon.addClass('nav-active');
			}

		}

		return slidePreviewNav;
	}

	function getActiveSlide () {
		return $('.carousel-item.active');
	}

	function startSlideShow (intervalTime, delayTime) {
		slideShowStart = setTimeout(function () {
			intervalID = setInterval(function () {
				loadSlide('next');
			}, intervalTime);
		}, delayTime);
	}

	function stopSlideShow () {
		clearTimeout(slideShowStart);
		clearInterval(intervalID);
	}
});




