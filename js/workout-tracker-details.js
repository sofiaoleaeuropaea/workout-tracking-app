document.addEventListener('DOMContentLoaded', () => {
  const workoutPlanTracker = document.getElementById('get_plan_tracker');
  const planTrackerContainer = document.getElementById('plan-tracker_card');

  workoutPlanTracker.addEventListener('change', () => {
    const planTrackerId = workoutPlanTracker.value;

    planTrackerContainer.innerHTML = '';

    fetch(`/gymtracker/workout-tracker-details/`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `get_plan_tracker=${planTrackerId}`,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Error fetching workout plans: ${response.status}`);
        }
        return response.json();
      })
      .then((workoutTrackerCard) => {
        if (workoutTrackerCard.length > 0) {
          const result = document.createElement('div');

          workoutTrackerCard.forEach((trackingId) => {
            const planTrackerCard = document.createElement('div');

            planTrackerCard.innerHTML = `<h3>${trackingId.plan_name}</h3>`;

            trackingId.tracking_ids.forEach((workout) => {
              planTrackerCard.innerHTML += `<p>Date: ${workout.tracking_date}</p>
            <p>Notes: ${workout.tracking_notes}</p>`;

              workout.exercises.forEach((exercise) => {
                const exerciseCard = document.createElement('div');
                exerciseCard.innerHTML = `
                    <p><strong>Exercise:</strong> ${exercise.name}</p>
                    <div>
                    <table>
                      <tr>
                        <th>Sets</th>
                        <th>Reps</th>
                        <th>Kg</th>
                      </tr>
                      ${exercise.sets
                        .map(
                          (set) =>
                            `<tr>
                              <td>${set.set_number}</td>
                              <td>${set.reps}</td>
                              <td>${set.kg}</td>
                            </tr>`,
                        )
                        .join('')} 
                    </table>
                    </div>
                  `;
                planTrackerCard.appendChild(exerciseCard);
              });
            });
            result.appendChild(planTrackerCard);
          });

          document.getElementById('plan-tracker_card').appendChild(result);
        } else {
          planTrackerContainer.innerHTML = `<p>No workout data found for the selected plan.</p>`;
        }
      })
      .catch((error) => {
        console.error('Error loading workout tracker:', error);
        planTrackerContainer.innerHTML =
          '<p>Could not load workout tracker data. Please try again.</p>';
      });
  });
});
