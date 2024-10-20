document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('workout_plan_form');
  const messageElement = document.getElementById('message');
  const exerciseList = document.getElementById('exercise_list');
  let exerciseCount = 1;

  document
    .getElementById('add_exercise')
    .addEventListener('click', function () {
      const exerciseItem = document
        .querySelector('.exercise_item')
        .cloneNode(true);

      exerciseItem.querySelector('select').selectedIndex = 0;
      exerciseItem.querySelector('input[name="sets"]').value = '';
      exerciseItem.querySelector('input[name="reps"]').value = '';

      exerciseItem.querySelector('select').id =
        'exercise_name_' + exerciseCount;
      exerciseItem
        .querySelector('label[for="sets"]')
        .setAttribute('for', 'sets_' + exerciseCount);
      exerciseItem.querySelector('input[name="sets"]').id =
        'sets_' + exerciseCount;
      exerciseItem
        .querySelector('label[for="reps"]')
        .setAttribute('for', 'reps_' + exerciseCount);
      exerciseItem.querySelector('input[name="reps"]').id =
        'reps_' + exerciseCount;

      exerciseList.appendChild(exerciseItem);
      exerciseCount++;

      attachRemoveEvent();
      updateRemoveButtons();
    });

  function attachRemoveEvent() {
    document.querySelectorAll('.remove_exercise').forEach((button) => {
      button.removeEventListener('click', handleRemove);
      button.addEventListener('click', handleRemove);
    });
  }

  function handleRemove() {
    const exerciseItems = document.querySelectorAll('.exercise_item');

    if (exerciseItems.length > 1) {
      this.closest('.exercise_item').remove();
    }

    updateRemoveButtons();
  }

  function updateRemoveButtons() {
    const exerciseItems = document.querySelectorAll('.exercise_item');

    exerciseItems.forEach((item) => {
      const removeButton = item.querySelector('.remove_exercise');
      if (exerciseItems.length === 1) {
        removeButton.disabled = true;
      } else {
        removeButton.disabled = false;
      }
    });
  }

  updateRemoveButtons();

  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    const form_data = new FormData(form);

    fetch('<?= ROOT ?>/gymtracker/workoutplans', {
      method: 'POST',
      body: form_data,
    })
      .then((response) => {
        return response.json();
      })
      .then((result) => {
        if (result.success) {
          messageElement.textContent = result.message;
          messageElement.style.color = 'green';
          form.reset();
        } else {
          messageElement.textContent = result.message;
          messageElement.style.color = 'red';
        }
      })
      .catch((error) => {
        messageElement.textContent = 'An error occurred. Please try again.';
        messageElement.style.color = 'red';
        console.error('Error fetching:', error);
      });
  });
});
