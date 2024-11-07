function goBack() {
    window.location.href = '/'; // Redirect back to the staff list
}

const userId = new URLSearchParams(window.location.search).get('id');

fetch(`/employee_details?id=${userId}`)
    .then(response => response.json())
    .then(leaveData => {
        const labels = leaveData.map(leave => leave.start_date);
        const takenData = leaveData.map(leave => leave.used_leave);
        const remainingData = leaveData.map(leave => leave.days_remaining);

        const ctx = document.getElementById('leaveChart').getContext('2d');
        const leaveChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Leaves Taken',
                        data: takenData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Leaves Left',
                        data: remainingData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching leave data:', error));
