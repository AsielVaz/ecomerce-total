document.addEventListener('submit', (event) => {
    const form = event.target.closest('form[data-confirm]');

    if (form && !window.confirm(form.dataset.confirm)) {
        event.preventDefault();
    }
});

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-carousel-slide]')];
    const thumbnails = [...carousel.parentElement.querySelectorAll('[data-carousel-thumbnail]')];
    const counter = carousel.querySelector('[data-carousel-counter]');
    let currentSlide = 0;

    const showSlide = (index) => {
        currentSlide = (index + slides.length) % slides.length;

        slides.forEach((slide, slideIndex) => {
            const isCurrent = slideIndex === currentSlide;

            slide.classList.toggle('hidden', !isCurrent);
            slide.setAttribute('aria-hidden', isCurrent ? 'false' : 'true');
        });

        thumbnails.forEach((thumbnail, thumbnailIndex) => {
            const isCurrent = thumbnailIndex === currentSlide;

            thumbnail.classList.toggle('border-brand', isCurrent);
            thumbnail.classList.toggle('border-transparent', !isCurrent);
            thumbnail.setAttribute('aria-current', isCurrent ? 'true' : 'false');
        });

        if (counter) {
            counter.textContent = `${currentSlide + 1} / ${slides.length}`;
        }
    };

    carousel.querySelector('[data-carousel-previous]')?.addEventListener('click', () => showSlide(currentSlide - 1));
    carousel.querySelector('[data-carousel-next]')?.addEventListener('click', () => showSlide(currentSlide + 1));

    thumbnails.forEach((thumbnail) => {
        thumbnail.addEventListener('click', () => showSlide(Number(thumbnail.dataset.carouselThumbnail)));
    });

    carousel.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            showSlide(currentSlide - 1);
        }

        if (event.key === 'ArrowRight') {
            event.preventDefault();
            showSlide(currentSlide + 1);
        }
    });
});

document.querySelectorAll('[data-add-image-url]').forEach((button) => {
    const section = button.closest('section');
    const list = section?.querySelector('[data-image-url-list]');

    button.addEventListener('click', () => {
        const rows = [...list.querySelectorAll('[data-image-url-row]')];

        if (rows.length >= 8) {
            return;
        }

        const row = rows[0].cloneNode(true);
        const input = row.querySelector('input');

        input.value = '';
        input.id = `image-url-${Date.now()}`;
        list.append(row);
        input.focus();

        if (rows.length === 7) {
            button.disabled = true;
            button.classList.add('opacity-50');
        }
    });
});

document.addEventListener('click', (event) => {
    const removeButton = event.target.closest('[data-remove-image-url]');

    if (!removeButton) {
        return;
    }

    const list = removeButton.closest('[data-image-url-list]');
    const rows = [...list.querySelectorAll('[data-image-url-row]')];

    if (rows.length === 1) {
        rows[0].querySelector('input').value = '';
        return;
    }

    removeButton.closest('[data-image-url-row]').remove();

    const addButton = list.parentElement.querySelector('[data-add-image-url]');
    addButton.disabled = false;
    addButton.classList.remove('opacity-50');
});

document.querySelectorAll('[data-image-file-input]').forEach((input) => {
    input.addEventListener('change', () => {
        const summary = input.parentElement.querySelector('[data-image-file-summary]');
        const selectedFiles = [...input.files];

        summary.textContent = selectedFiles.length === 0
            ? 'Ningún archivo seleccionado.'
            : `${selectedFiles.length} ${selectedFiles.length === 1 ? 'imagen seleccionada' : 'imágenes seleccionadas'}: ${selectedFiles.map((file) => file.name).join(', ')}`;
    });
});
