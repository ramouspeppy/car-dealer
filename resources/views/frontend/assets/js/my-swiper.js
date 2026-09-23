// resources/js/components/my-swiper.js
import Swiper from 'swiper';
import { Pagination, Navigation, Autoplay, EffectCoverflow } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/effect-coverflow';

export function initSwipers() {
  const wrappers = document.querySelectorAll('.init-swiper');
  if (!wrappers.length) return;

  wrappers.forEach((wrapper, idx) => {
    const container = wrapper.classList.contains('swiper')
      ? wrapper
      : wrapper.querySelector('.swiper');

    if (!container) return;

    let config = {};
    const cfgEl = wrapper.querySelector('.swiper-config');
    if (cfgEl) {
      try { config = JSON.parse(cfgEl.textContent.trim()); }
      catch (e) { console.error('❌ JSON error', e); }
    }

    // pasang modules
    config.modules = [Pagination, Navigation, Autoplay, EffectCoverflow];

    // scope pagination & navigation
    if (config.pagination?.el)
      config.pagination.el = container.querySelector(config.pagination.el);
    if (config.navigation?.nextEl)
      config.navigation.nextEl = container.querySelector(config.navigation.nextEl);
    if (config.navigation?.prevEl)
      config.navigation.prevEl = container.querySelector(config.navigation.prevEl);

    new Swiper(container, config);
  });
}
