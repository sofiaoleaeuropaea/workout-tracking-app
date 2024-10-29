document.addEventListener('DOMContentLoaded', () => {
  const deleteAccountBtn = document.getElementById('delete_account_btn');
  const modal = document.getElementById('delete_account_modal');
  const closeModal = document.querySelector('.close_modal');
  const deleteForm = document.getElementById('delete_account_form');
  const errorMessage = document.getElementById('delete_error_message');

  deleteAccountBtn.addEventListener('click', () => {
    modal.style.display = 'block';
    errorMessage.hidden = true;
  });

  closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  deleteForm.addEventListener('submit', (event) => {
    event.preventDefault();

    new FormData(deleteForm);
  });

  deleteForm.addEventListener('formdata', (event) => {
    const deleteFormData = event.formData;

    fetch('/gymtracker/userdelete/', {
      method: 'POST',
      body: deleteFormData,
    })
      .then((response) => response.json())
      .then((result) => {
        if (result.success) {
          window.location.href = '/';
        } else {
          errorMessage.textContent = result.message;
          errorMessage.hidden = false;
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        errorMessage.textContent = 'Something went wrong. Please try again.';
        errorMessage.hidden = false;
      });
  });
});
