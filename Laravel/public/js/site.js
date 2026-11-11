const menuButton = document.querySelector('[data-menu-toggle]');
const navigation = document.querySelector('[data-navigation]');

menuButton?.addEventListener('click', () => {
    const expanded = menuButton.getAttribute('aria-expanded') === 'true';
    menuButton.setAttribute('aria-expanded', String(!expanded));
    navigation?.classList.toggle('open', !expanded);
});

const chartCanvas = document.querySelector('#park-chart');

if (chartCanvas && window.Chart) {
    const labels = JSON.parse(chartCanvas.dataset.labels);
    const trailCounts = JSON.parse(chartCanvas.dataset.trails);
    const townCounts = JSON.parse(chartCanvas.dataset.towns);
    const chart = new Chart(chartCanvas, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Tanösvények',
                data: trailCounts,
                backgroundColor: '#76985e',
                borderRadius: 3,
                maxBarThickness: 34,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { maxRotation: 55, minRotation: 30 } },
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#e8ece4' } },
            },
        },
    });

    document.querySelectorAll('[data-chart-mode]').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('[data-chart-mode]').forEach((item) => item.classList.remove('active'));
            button.classList.add('active');
            const towns = button.dataset.chartMode === 'towns';
            chart.data.datasets[0].label = towns ? 'Települések' : 'Tanösvények';
            chart.data.datasets[0].data = towns ? townCounts : trailCounts;
            chart.update();
        });
    });
}