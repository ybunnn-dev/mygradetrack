import { initUnitsDonutChart } from '../charts/unitsChart';

document.addEventListener('DOMContentLoaded', function () {
    // Reverse the semester and GPA data for oldest-to-latest order
    const reversedSemesters = [...semesters].reverse();
    const reversedGpaData = [...gpaData].reverse();

    // Also reverse unit chart labels & data (if needed)
    const reversedUnitSemesters = [...unitSemesters].reverse();
    const reversedUnitsData = [...unitsData].reverse();

    const ctx = document.getElementById('gpaChart').getContext('2d');
    const gpaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: reversedSemesters,
            datasets: [{
                label: 'GWA per Semester',
                data: reversedGpaData,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false,
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    reverse: true,
                    min: 1.0,
                    max: 5.0,
                    ticks: {
                        stepSize: 0.5
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return 'GWA: ' + context.parsed.y.toFixed(4);
                        }
                    }
                }
            }
        }
    });

    // Pass reversed data to donut chart too
    initUnitsDonutChart(reversedUnitSemesters, reversedUnitsData);
});
