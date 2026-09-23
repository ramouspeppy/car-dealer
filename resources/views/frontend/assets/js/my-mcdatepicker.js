// resources/js/components/my-mcdatepicker.js
import MCDatepicker from 'mc-datepicker';
import 'mc-datepicker/dist/mc-calendar.min.css';

export function initDatepickers(selector = '.datepicker', options = {}) {
  const inputs = document.querySelectorAll(selector);
  if (!inputs.length) return;

  inputs.forEach((input, idx) => {
    // Hindari inisialisasi ganda
    if (input.dataset.hasDatepicker) return;

    // Pastikan ada ID unik
    if (!input.id) {
      input.id = `datepicker-${Date.now()}-${idx}`;
    }

    // Baca atribut HTML atau fallback ke options global
    const bodyType   = input.getAttribute('datepicker-body') || options.bodyType || 'modal';
    const minAttr    = input.getAttribute('datepicker-min');
    const maxAttr    = input.getAttribute('datepicker-max');
    const dateFormat = input.getAttribute('datepicker-format') || options.dateFormat || 'DD-MM-YYYY';
    
    // ✅ Auto Close
    const autoCloseAttr = input.getAttribute('datepicker-autoclose');
    let autoClose = options.autoClose ?? true;
    if (autoCloseAttr !== null) {
      autoClose = autoCloseAttr === 'true';
    }

    // ✅ Close On Blur
    const closeOnBlurAttr = input.getAttribute('datepicker-closeonblur');
    let closeOnBlur = options.closeOnBlur ?? true;
    if (closeOnBlurAttr !== null) {
      closeOnBlur = closeOnBlurAttr === 'true';
    }

    // ✅ minDate
    let minDate = null;
    if (minAttr === 'today') {
    minDate = new Date();
    } else {
    const tmp = new Date(minAttr);
    if (!isNaN(tmp.getTime())) minDate = tmp;
    }
    

    // ✅ maxDate
    let maxDate = null;
    if (maxAttr) {
      const tmp = new Date(maxAttr);
      if (!isNaN(tmp.getTime())) maxDate = tmp;
    } else if (options.maxDate instanceof Date && !isNaN(options.maxDate.getTime())) {
      maxDate = options.maxDate;
    }

    // ✅ Buat instance datepicker
    const picker = MCDatepicker.create({
      el: `#${input.id}`,
      dateFormat,
      autoClose,
      closeOnBlur,
      bodyType,
      minDate,
      ...(maxDate ? { maxDate } : {})
    });

    // Tandai sudah diinisialisasi
    input.dataset.hasDatepicker = 'true';

    // Buka picker saat fokus
    input.addEventListener('focus', () => picker.open());
  });

  console.info(`✅ MCDatepicker initialized on ${inputs.length} element(s)`);
}
