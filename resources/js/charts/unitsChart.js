export function initUnitsDonutChart(unitSemesters, unitsData) {
    const ctx = document.getElementById('unitsDonutChart');
    if (!ctx) return;

    Chart.defaults.font.family = "'Montserrat', sans-serif";

    const backgroundColors = [
        'rgba(79, 70, 229, 0.8)',
        'rgba(99, 102, 241, 0.8)',
        'rgba(129, 140, 248, 0.8)',
        'rgba(167, 139, 250, 0.8)',
        'rgba(196, 181, 253, 0.8)',
        'rgba(221, 214, 254, 0.8)',
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: unitSemesters,
            datasets: [{
                data: unitsData,
                backgroundColor: backgroundColors.slice(0, unitSemesters.length),
                borderWidth: 0,
                cutout: '65%',
                borderRadius: 4,
                spacing: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    align: 'center',
                    labels: {
                        color: '#4B5563',
                        boxWidth: 14,
                        boxHeight: 14,
                        padding: 20,
                        font: {
                            size: 13,
                            weight: '500',
                            family: "'Montserrat', sans-serif"
                        },
                        usePointStyle: true,
                        pointStyle: 'circle',
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, i) => {
                                const value = data.datasets[0].data[i];
                                return {
                                    text: `${label} (${value} units)`,
                                    fillStyle: chart.getDatasetMeta(0).data[i].options.backgroundColor,
                                    index: i
                                };
                            });
                        }
                    },
                    onClick: function(e, legendItem, legend) {
                        const index = legendItem.index;
                        const chart = legend.chart;
                        const meta = chart.getDatasetMeta(0);

                        meta.data[index].hidden = !meta.data[index].hidden;
                        chart.update();
                    }
                },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            return `${context.label}: ${context.raw} units`;
                        }
                    }
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 15,
                    top: 10,
                    bottom: 10
                }
            }
        }
    });
}
