import { initUnitsDonutChart } from '../charts/unitsChart';

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('gpaChart').getContext('2d');
    const gpaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: semesters, // multi-line label array
            datasets: [{
                label: 'GWA per Semester',
                data: gpaData,
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
                        // Chart.js auto-wraps multi-line array labels, no callback needed
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
    initUnitsDonutChart(unitSemesters, unitsData);
});
