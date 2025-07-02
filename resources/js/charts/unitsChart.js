export function initUnitsDonutChart(unitSemesters, unitsData) {
    const ctx = document.getElementById('unitsDonutChart');
    if (!ctx) return;

    // Convert string data to integers
    const convertedUnitsData = unitsData.map(value => {
        // Handle both string and number inputs
        const num = parseInt(value, 10);
        return isNaN(num) ? 0 : num;
    });

    // Optional: Filter out zero values and their corresponding labels
    const validData = [];
    const validLabels = [];
    
    convertedUnitsData.forEach((value, index) => {
        if (value > 0) {
            validData.push(value);
            validLabels.push(unitSemesters[index]);
        }
    });

    // Use the filtered data or original data based on your preference
    const finalLabels = validLabels.length > 0 ? validLabels : unitSemesters;
    const finalData = validData.length > 0 ? validData : convertedUnitsData;

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
            labels: finalLabels,
            datasets: [{
                data: finalData,
                backgroundColor: backgroundColors.slice(0, finalLabels.length),
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
                            const dataset = data.datasets[0];
                            return data.labels.map((label, i) => {
                                const value = dataset.data[i];
                                // Use the backgroundColor from the dataset instead of meta
                                const backgroundColor = dataset.backgroundColor[i] || backgroundColors[i % backgroundColors.length];
                                return {
                                    text: `${label} (${value} units)`,
                                    fillStyle: backgroundColor,
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