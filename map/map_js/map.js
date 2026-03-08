// =========================
// DRAGGING & ZOOMING
// =========================

const mapContainer = document.querySelector('.map-container');
const mapContent = document.querySelector('.map-content');
const zoomInBtn = document.getElementById('zoom-in');
const zoomOutBtn = document.getElementById('zoom-out');

let isDragging = false;
let startX, startY;
let translateX = 0;
let translateY = 0;
let scale = 1;

mapContent.addEventListener('mousedown', (e) => {
    isDragging = true;
    startX = e.clientX - translateX;
    startY = e.clientY - translateY;
    mapContainer.style.cursor = 'grabbing';
});

window.addEventListener('mouseup', () => {
    isDragging = false;
    mapContainer.style.cursor = 'grab';
});

window.addEventListener('mousemove', (e) => {
    if (!isDragging) return;

    translateX = e.clientX - startX;
    translateY = e.clientY - startY;

    clampPosition();
    updateTransform();
});

zoomInBtn.addEventListener('click', () => {
    scale *= 1.2;
    clampScale();
    clampPosition();
    updateTransform();
});

zoomOutBtn.addEventListener('click', () => {
    scale /= 1.2;
    clampScale();
    clampPosition();
    updateTransform();
});

function clampPosition() {
    const containerRect = mapContainer.getBoundingClientRect();
    const mapWidth = 2816 * scale;
    const mapHeight = 1536 * scale;

    const minX = containerRect.width - mapWidth;
    const minY = containerRect.height - mapHeight;

    if (mapWidth <= containerRect.width) {
        translateX = (containerRect.width - mapWidth) / 2;
    } else {
        translateX = Math.min(0, Math.max(translateX, minX));
    }

    if (mapHeight <= containerRect.height) {
        translateY = (containerRect.height - mapHeight) / 2;
    } else {
        translateY = Math.min(0, Math.max(translateY, minY));
    }
}

function clampScale() {
    const containerRect = mapContainer.getBoundingClientRect();
    const minScaleX = containerRect.width / 2816;
    const minScaleY = containerRect.height / 1536;
    const minScale = Math.max(minScaleX, minScaleY, 1);

    if (scale < minScale) scale = minScale;
    if (scale > 5) scale = 5;
}

function updateTransform() {
    mapContent.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;
}

// =========================
// MUSIC
// =========================

const backgroundMusic = new Audio('../assets/music/sound1.mp3');
backgroundMusic.loop = true;
backgroundMusic.volume = 0.5;

const musicToggleBtn = document.getElementById('music-toggle');
let isPlaying = false;

musicToggleBtn.addEventListener('click', () => {
    if (isPlaying) {
        backgroundMusic.pause();
        musicToggleBtn.textContent = '🎵 Music Off';
    } else {
        backgroundMusic.play();
        musicToggleBtn.textContent = '🎵 Music On';
    }
    isPlaying = !isPlaying;
});

// =========================
// POPUP
// =========================

const popup = document.querySelector('.pin-popup');
const popupTitle = document.getElementById('popup-title');
const popupDescription = document.getElementById('popup-description');
const popupImage = document.getElementById('popup-image');
const popupPrev = document.getElementById('popup-prev');
const popupNext = document.getElementById('popup-next');
const popupClose = document.getElementById('popup-close');

let currentImages = [];
let currentIndex = 0;

function showPopup(pin) {
    popupTitle.textContent = pin.title;
    popupDescription.textContent = pin.description;

    currentImages = pin.images;
    currentIndex = 0;

    popupImage.src = currentImages.length > 0 ? currentImages[0] : '';

    popup.classList.remove('hidden');
}

popupClose.addEventListener('click', () => {
    popup.classList.add('hidden');
});

popupPrev.addEventListener('click', () => {
    if (currentImages.length > 0) {
        currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
        popupImage.src = currentImages[currentIndex];
    }
});

popupNext.addEventListener('click', () => {
    if (currentImages.length > 0) {
        currentIndex = (currentIndex + 1) % currentImages.length;
        popupImage.src = currentImages[currentIndex];
    }
});

// =========================
// FETCH PINS FROM DATABASE
// =========================

fetch('../api/get_pins.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(pin => {
            const pinElement = document.createElement('div');
            pinElement.classList.add('pin');
            pinElement.style.top = pin.pos_y + 'px';
            pinElement.style.left = pin.pos_x + 'px';
            pinElement.dataset.title = pin.title;
            pinElement.dataset.description = pin.description;
            pinElement.dataset.images = JSON.stringify(pin.images);

            mapContent.appendChild(pinElement);

            pinElement.addEventListener('click', () => {
                showPopup(pin);
            });
        });
    })
    .catch(err => console.error('Error fetching pins:', err));
// ===========================
// CUSTOM PIND POPUP LOGIC
// ===========================

const pindElement = document.querySelector('.pind');
const pindPopup = document.querySelector('.pind-popup');
const pindPopupTitle = document.getElementById('pind-popup-title');
const pindPopupDescription = document.getElementById('pind-popup-description');
const pindPopupClose = document.getElementById('pind-popup-close');

pindElement.addEventListener('click', () => {
    const title = pindElement.dataset.title;
    const description = pindElement.dataset.description;

    pindPopupTitle.textContent = title;
    pindPopupDescription.textContent = description;

    // Always calculate position relative to map-content
    const pindRect = pindElement.getBoundingClientRect();
    const containerRect = document.querySelector('.map-container').getBoundingClientRect();

    const popupWidth = pindPopup.offsetWidth || 200; // fallback if hidden
    const popupHeight = pindPopup.offsetHeight || 100; // fallback if hidden

    const pindCenterX = pindRect.left + pindRect.width / 2 - containerRect.left;
    const pindTopY = pindRect.top - containerRect.top;

    // Place popup above the pind
    const top = pindTopY - popupHeight - 15 + 1;
    const left = 2500;

    pindPopup.style.top = `${top}px`;
    pindPopup.style.left = `${left}px`;

    pindPopup.classList.remove('hidden');
});

pindPopupClose.addEventListener('click', () => {
    pindPopup.classList.add('hidden');
});