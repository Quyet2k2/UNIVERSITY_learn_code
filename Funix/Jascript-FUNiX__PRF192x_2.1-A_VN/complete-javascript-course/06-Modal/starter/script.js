'use strict';

const modalBtns = document.querySelectorAll('.show-modal');
const modal = document.querySelector('.modal');
const closeBtn = document.querySelector('.close-modal');
const overlay = document.querySelector('.overlay');

const onOffModal = () => {
  modal.classList.toggle('hidden');
  overlay.classList.toggle('hidden');
};

for (let i = 0; i < modalBtns.length; i++)
  modalBtns[i].addEventListener('click', onOffModal);

closeBtn.addEventListener('click', onOffModal);

overlay.addEventListener('click', onOffModal);

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape' && !modal.classList.contains('hidden')) onOffModal();
});
