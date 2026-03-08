const videoElement = document.getElementById('webcam');
const canvasElement = document.getElementById('snapshot');
const countdownElement = document.getElementById('countdown');
const captureBtn = document.getElementById('capture-btn');

const modal = document.getElementById('photo-modal');
const finalPhoto = document.getElementById('final-photo');
const downloadLink = document.getElementById('download-link');
const closeModal = document.querySelector('.close');

const ctx = canvasElement.getContext('2d');

async function setupCamera() {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    videoElement.srcObject = stream;
}

setupCamera();

captureBtn.addEventListener('click', startCountdown);

function startCountdown() {
    let count = 3;
    countdownElement.textContent = count;

    const interval = setInterval(() => {
        count--;
        countdownElement.textContent = count > 0 ? count : '';
        if (count === 0) {
            clearInterval(interval);
            takePhoto();
        }
    }, 1000);
}

function takePhoto() {
  const frame = new Image();
  frame.src = '../assets/img/frame/frame_kostibu.png';

  frame.onload = () => {
    const scaleFactor = 0.8; // adjust this as needed (0.8, 0.7, etc.)

    const originalWidth = 1025;
    const originalHeight = 1537;

    const frameWidth = originalWidth * scaleFactor;
    const frameHeight = originalHeight * scaleFactor;

    canvasElement.width = frameWidth;
    canvasElement.height = frameHeight;

    const camX = 60 * scaleFactor;
    const camY = 0;
    const camW = originalWidth * 0.87 * scaleFactor;
    const camH = originalHeight * 0.79 * scaleFactor;

    ctx.drawImage(videoElement, camX, camY, camW, camH);
    ctx.drawImage(frame, 0, 0, frameWidth, frameHeight);

    const imageDataURL = canvasElement.toDataURL('image/png');

    finalPhoto.src = imageDataURL;
    downloadLink.href = imageDataURL;

    modal.style.display = 'block';
  };

  countdownElement.textContent = '';
}



closeModal.onclick = () => {
    modal.style.display = 'none';
};

window.onclick = (e) => {
    if (e.target == modal) {
        modal.style.display = 'none';
    }
};