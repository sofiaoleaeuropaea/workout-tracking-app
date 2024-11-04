document.addEventListener('DOMContentLoaded', () => {
  const exerciseList = document.getElementById('exercise_list');
  let exerciseCount = 1;

  function attachRemoveEvent() {
    document.querySelectorAll('.remove_exercise').forEach((button) => {
      button.removeEventListener('click', removeExercise);
      button.addEventListener('click', removeExercise);
    });
  }

  function removeExercise() {
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

  function resetForm() {
    document.getElementById('workout_form').reset();

    while (exerciseList.children.length > 1) {
      exerciseList.removeChild(exerciseList.lastChild);
    }

    const firstExerciseItem = exerciseList.querySelector('.exercise_item');
    firstExerciseItem.querySelector('select').selectedIndex = 0;
    firstExerciseItem.querySelector('input[name="exercises[0][sets]"]').value =
      '';
    firstExerciseItem.querySelector('input[name="exercises[0][reps]"]').value =
      '';
  }

  document
    .getElementById('add_exercise')
    .addEventListener('click', function () {
      const exerciseItem = document
        .querySelector('.exercise_item')
        .cloneNode(true);

      exerciseItem.querySelector('select').selectedIndex = 0;
      exerciseItem.querySelector('input[name="exercises[0][sets]"]').value = '';
      exerciseItem.querySelector('input[name="exercises[0][reps]"]').value = '';
      exerciseItem.querySelector(
        'input[name="exercises[0][exercise_order]"]',
      ).value = `${exerciseCount}`;

      exerciseItem.querySelector(
        `select[name="exercises[0][exercise_id]"]`,
      ).name = `exercises[${exerciseCount}][exercise_id]`;

      exerciseItem.querySelector(
        `input[name="exercises[0][sets]"]`,
      ).name = `exercises[${exerciseCount}][sets]`;

      exerciseItem.querySelector(
        `input[name="exercises[0][reps]"]`,
      ).name = `exercises[${exerciseCount}][reps]`;

      exerciseItem.querySelector(
        `input[name="exercises[0][exercise_order]"]`,
      ).name = `exercises[${exerciseCount}][exercise_order]`;

      const lastExerciseItem = exerciseList.querySelector(
        '.exercise_item:last-of-type',
      );
      exerciseList.insertBefore(exerciseItem, lastExerciseItem.nextSibling);

      exerciseCount++;

      attachRemoveEvent();
      updateRemoveButtons();
    });

  updateRemoveButtons();
});
