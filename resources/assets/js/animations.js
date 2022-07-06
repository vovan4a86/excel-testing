document.addEventListener('DOMContentLoaded', () => {
  fadedPageBlocks();
  animateHeroTitles();
  animateHeroCities();
  animatePageSubtitles();
  animateCategoryCards();
});

gsap.config({ nullTargetWarn: false });

const animationEase = 'expo.inOut';

// animations
function fadedPageBlocks() {
  $('section').each(function () {
    const animate = gsap.timeline({
      scrollTrigger: { trigger: $(this) }
    });

    animate.fromTo($(this), { opacity: 0 }, { opacity: 1, duration: 0.4 }, 0.3);
  });
}

function animatePageSubtitles() {
  $('.page-subtitle').each(function () {
    const animate = gsap.timeline({
      scrollTrigger: { trigger: $(this) }
    });

    animate.fromTo(
      $(this),
      { y: -10, opacity: 0 },
      { y: 0, opacity: 1.4, duration: 0.65, ease: animationEase },
      0.25
    );
  });
}

function animateHeroTitles() {
  const title = $('.hero__title');
  const subTitle = $('.hero__subtitle');
  const link = $('.hero__content > .btn');

  const animate = gsap.timeline();

  animate.fromTo(
    title,
    { y: 30, opacity: 0 },
    { y: 0, opacity: 1, duration: 1.3, ease: animationEase },
    0.3
  );

  animate.fromTo(
    subTitle,
    { y: 10, opacity: 0 },
    { y: 0, opacity: 1, duration: 1, ease: animationEase },
    0.6
  );

  animate.fromTo(
    link,
    { opacity: 0, scale: 0.95 },
    { opacity: 1, scale: 1, duration: 0.75 },
    1.3
  );
}

function animateHeroCities() {
  const citiesBlock = $('.hero__bottom');
  const cities = $('.hero__cols .hero__item');

  const animate = gsap.timeline({
    scrollTrigger: { trigger: cities }
  });

  animate.fromTo(
    citiesBlock,
    { y: 20, opacity: 0 },
    { y: 0, opacity: 1, duration: 0.75, ease: animationEase },
    2.1
  );

  animate.fromTo(
    cities,
    { y: 20, opacity: 0 },
    { y: 0, opacity: 1, duration: 1, stagger: 0.2, ease: animationEase },
    2.5
  );
}

function animateCategoryCards() {
  const categories = $('.categories__list .categories__item');

  const animate = gsap.timeline({
    scrollTrigger: { trigger: categories }
  });

  animate.fromTo(
    categories,
    { y: 20, opacity: 0 },
    { y: 0, opacity: 1, duration: 0.3, stagger: 0.1, ease: animationEase },
    1.1
  );
}
