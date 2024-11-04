document.addEventListener('DOMContentLoaded', function () {
  const deleteUserButton = document.querySelectorAll('.remove_btn');

  for (let button of deleteUserButton) {
    button.addEventListener('click', function () {
      let confirmDelete = confirm('Are you sure you want to delete this user?');
      if (confirmDelete) {
        const tr = button.parentNode.parentNode;

        const body = {
          user_id: parseInt(button.dataset.userId),
        };

        fetch('/admin/users-delete', {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(body),
        })
          .then((response) => {
            if (response.status === 200) {
              return response.json();
            } else {
              throw new Error('Failed to delete user');
            }
          })
          .then((response) => {
            tr.remove();
            const message = document.querySelector('.alert_message');
            if (message) {
              message.innerHTML = `${response.message}`;
            }
          })
          .catch((error) => {
            console.error('Error:', error);
            alert('Error deleting the user.');
          });
      }
    });
  }
});
