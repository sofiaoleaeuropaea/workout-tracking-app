document.addEventListener('DOMContentLoaded', () => {
  const workoutPlanSelect = document.getElementById('workout_plan');
  const exerciseList = document.getElementById('exercise-tracker_list');
  const exerciseSetIndex = {};

  function addSetEvents() {
    document.querySelectorAll('.add_set_button').forEach((button) => {
      const exerciseId = button.getAttribute('data-exercise-id');
      if (!exerciseSetIndex[exerciseId]) {
        exerciseSetIndex[exerciseId] = 0;
      }
      button.addEventListener('click', () => {
        const exerciseTrackerTable = document.getElementById(
          `completed_${exerciseId}`,
        );

        const newSetIndex = exerciseSetIndex[exerciseId]++;

        const newSet = document.createElement('tr');
        newSet.innerHTML = `
              <td><input type="number" name="sets[${exerciseId}][${newSetIndex}][reps]" required></td>
              <td><input type="number" name="sets[${exerciseId}][${newSetIndex}][weight]" required></td>
              <td><button type="button" class="remove_set_btn btn btn_w">&times;</button></td>
            `;
        exerciseTrackerTable.appendChild(newSet);

        newSet
          .querySelector('.remove_set_btn')
          .addEventListener('click', () => {
            newSet.remove();
            exerciseSetIndex[exerciseId]--;
          });
      });
    });
  }

  workoutPlanSelect.addEventListener('change', () => {
    const planId = workoutPlanSelect.value;

    exerciseList.innerHTML = '';

    if (planId) {
      const requestData = {
        plan_id: planId,
      };

      fetch('/gymtracker/workout-tracker/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestData),
      })
        .then((response) => {
          if (!response.ok) {
            exerciseList.innerHTML =
              '<p>Could not load exercises. Please try again.</p>';
            throw new Error(`Error loading exercises: ${response.status}`);
          }
          return response.json();
        })
        .then((exercises) => {
          exercises.forEach((exercise) => {
            const exerciseDiv = document.createElement('div');
            exerciseDiv.classList.add('exercise');

            exerciseDiv.innerHTML = `
                                <div class='exercise_tracker_item'>
                                <input type="hidden" name="plan_exercise_id" value="${exercise.plan_exercise_id}">
                                    <p> <span>${exercise.exercise_order}.</span> ${exercise.exercise_name}</p>
                                    <div id='targets_${exercise.exercise_id}' >
                                        <table id='completed_${exercise.exercise_id}' class='set_list_table'>
                                            <tr>
                                                <th>Reps</th>
                                                <th>Kg</th>
                                                <th></th>
                                            </tr>
                                        </table>
                                        <button type="button" class="add_set_button btn" data-exercise-id="${exercise.exercise_id}">Add Set</button>
                                    </div>
                                    <div id='targets_${exercise.exercise_id}' >
                                        <table id='targets_${exercise.exercise_id}' class='set_list_table'>
                                            <tr>
                                            <th>Target Sets</th>
                                            <th>Target Reps</th>
                                            </tr>
                                            <tr>
                                                <td>${exercise.target_sets}</td>
                                                <td>${exercise.target_reps}</td>
                                            </tr>
                                        </table>
                                        </div>
                                    </div>
                              `;
            exerciseList.appendChild(exerciseDiv);
          });
          addSetEvents();
        })
        .catch((error) => {
          console.error('Error loading exercises:', error);
          exerciseList.innerHTML =
            '<p>Could not load exercises. Please try again.</p>';
        });
    }
  });
});
