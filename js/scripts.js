scrollParallax();
imageLiquidAnimation();
scrollReveal();
mobile();
accordion();
setActiveState();
slidingLine();

function mobile() {
  $('[rel="js-mobile-toggle"]').on('click', function () {
    $(this).toggleClass('active');
    $('[rel="js-mobile-logo"]').toggleClass('active');
    $('[rel="js-mobile-menu"]').toggleClass('active');
    $('body').toggleClass('locked');
  });
}
function scrollParallax() {
  if ($(window).scrollTop() >= 545) {
    $('.b-hero__inner').css({ opacity: 0, 'pointer-events': 'none' });
  }
  $(window).scroll(function () {
    let scrolledHeight = $(this).scrollTop(),
      windowWidth = $(this).outerWidth(),
      contentHeight = $('.b-hero__inner').outerHeight(),
      parallaxHeight = $('.b-parallax').outerHeight(),
      percents = (scrolledHeight / contentHeight) * 100,
      percentsTop = (scrolledHeight / parallaxHeight) * 100,
      opacity = 1 - (1 / 60) * percentsTop,
      translateObj_1 = 1 + (windowWidth / 4000) * percents,
      translateObj_2 = 1 + (windowWidth / 800) * percents,
      translateObj_3 = 1 + (windowWidth / 3000) * percents;

    $('.b-hero__inner').css('opacity', opacity);
    $('.b-parallax__item--3').css(
      `transform`,
      `translateY(-${translateObj_1}px)`
    );
    $('.b-parallax__item--2').css(
      `transform`,
      `translateY(-${translateObj_2}px)`
    );
    $('.b-parallax__item--1').css(
      `transform`,
      `translateY(-${translateObj_3}px)`
    );
  });
}
function imageLiquidAnimation() {
  let steps = document.querySelectorAll('[rel="js-step"]');

  steps.forEach(function (step) {
    let preview = step.querySelector('.b-step__image');
    let standardImage = preview.dataset.standardImage;
    let hoveredImage = preview.dataset.hoveredImage;
    let hoverDistort = new hoverEffect({
      parent: preview,
      intensity: 0.2,
      image1: standardImage,
      image2: hoveredImage,
      displacementImage: 'img/pattern.jpg',
    });
  });
}
function scrollReveal() {
  let steps = document.querySelectorAll('[rel="js-step"]');

  steps.forEach(function (step) {
    ScrollReveal().reveal(step, {
      delay: 200,
      duration: 500,
      distance: '50px',
      easing: 'cubic-bezier(0.5, 0, 0, 1)',
    });
  });
}
function accordion() {
  let accordion = $('[rel="js-accordion-toggle"]');
  function accordionToggle() {
    accordion.on('click', function () {
      $(this).toggleClass('active');

      if ($(this).hasClass('active')) {
        $(this).next().slideDown();
      } else {
        $(this).next().slideUp();
      }
    });
  }

  function mobileAccordionToggle() {
    accordion.next().slideUp();
    accordionToggle();
  }
  if ($(window).innerWidth() < 576) {
    mobileAccordionToggle();
  }
}
function slidingLine() {
  let paginationList = $('[rel="js-pagination-list"]');

  paginationList.append("<li id='slidingLine'></li>");
  let slidingLine = $('#slidingLine');

  slidingLine
    .height($('.b-pagination__link.active').outerHeight())
    .css('top', $('.b-pagination__link.active').position().top)
    .data('origTop', slidingLine.position().top)
    .data('origHeight', slidingLine.height());
}
function setActiveState() {
  let sections = $('._js-watch'),
    nav = $('[rel="js-pagination"]'),
    navHeight = nav.outerHeight();

  $(window).on('scroll', function () {
    let curPos = $(this).scrollTop();
    let slidingLine = $('#slidingLine');

    slidingLine
      .height($('.b-pagination__link.active').outerHeight())
      .css('top', $('.b-pagination__link.active').position().top)
      .data('origTop', slidingLine.position().top)
      .data('origHeight', slidingLine.height());

    sections.each(function () {
      let top = $(this).offset().top - navHeight,
        bottom = top + $(this).outerHeight();

      if (curPos >= top && curPos <= bottom) {
        let $el = $(this);
        let topPos = $el.position().top;
        let newHeight = $el.outerHeight();
        slidingLine.stop().animate({
          top: topPos,
          height: newHeight,
        });
        nav
          .find($('[rel="js-pagination-item"]').children())
          .removeClass('active');
        sections.removeClass('active');

        $(this).addClass('active');
        nav.find(`a[href="#${$(this).attr('id')}"]`).addClass('active');

        slidingLine.stop().animate({
          top: $('.b-pagination__link.active').position().top,
          height: $('.b-pagination__link.active').outerHeight(),
        });
      }
    });
  });
}
