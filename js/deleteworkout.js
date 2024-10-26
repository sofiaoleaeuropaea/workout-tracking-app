document.addEventListener('DOMContentLoaded', function () {
  const deleteButton = document.getElementById('btn_delete');

  if (deleteButton) {
    deleteButton.addEventListener('click', function () {
      let confirmDelete = confirm(
        'Are you sure you want to delete this workout plan?',
      );
      if (confirmDelete) {
        const planId = document.querySelector('[name="plan_id"]').value;

        const body = { plan_id: parseInt(planId) };

        fetch('/gymtracker/deleteworkout/', {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(body),
        })
          .then((response) => {
            if (response.status === 200) {
              window.location.href = '/gymtracker/createworkout/';
            } else {
              throw new Error('Failed to delete');
            }
          })
          .catch((error) => {
            console.error('Error:', error);
            alert('Error deleting the workout plan.');
          });
      }
    });
  }
});
