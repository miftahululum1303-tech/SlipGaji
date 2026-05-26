/* ========================================
   DASHBOARD MODULE
======================================== */

document.addEventListener("DOMContentLoaded", function () {
  initPayrollChart();

  initDashboardCounter();

  initDashboardHover();
});

/* ========================================
   PAYROLL CHART
======================================== */

function initPayrollChart() {
  const chartCanvas = document.getElementById("payrollChart");

  if (!chartCanvas) return;

  const labels = JSON.parse(chartCanvas.dataset.labels || "[]");

  const totals = JSON.parse(chartCanvas.dataset.totals || "[]");

  if (window.payrollChartInstance) {
    window.payrollChartInstance.destroy();
  }

  window.payrollChartInstance = new Chart(chartCanvas, {
    type: "line",

    data: {
      labels: labels,

      datasets: [
        {
          label: "Pengeluaran Payroll",

          data: totals,

          borderWidth: 4,

          tension: 0.4,

          fill: true,

          backgroundColor: "rgba(59,130,246,0.15)",

          borderColor: "#3b82f6",

          pointBackgroundColor: "#2563eb",

          pointBorderColor: "#fff",

          pointRadius: 6,

          pointHoverRadius: 8,
        },
      ],
    },

    options: {
      responsive: true,

      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: true,
        },

        tooltip: {
          callbacks: {
            label: function (context) {
              return "Rp " + new Intl.NumberFormat("id-ID").format(context.raw);
            },
          },
        },
      },

      scales: {
        y: {
          beginAtZero: true,

          ticks: {
            callback: function (value) {
              return "Rp " + new Intl.NumberFormat("id-ID").format(value);
            },
          },
        },
      },
    },
  });
}

/* ========================================
   COUNTER ANIMATION
======================================== */

function initDashboardCounter() {
  const counters = document.querySelectorAll("[data-counter]");

  counters.forEach((counter) => {
    const target = parseInt(counter.dataset.counter);

    let current = 0;

    const increment = Math.ceil(target / 50);

    const updateCounter = () => {
      current += increment;

      if (current > target) {
        current = target;
      }

      counter.innerText = new Intl.NumberFormat("id-ID").format(current);

      if (current < target) {
        requestAnimationFrame(updateCounter);
      }
    };

    updateCounter();
  });
}

/* ========================================
   CARD HOVER EFFECT
======================================== */

function initDashboardHover() {
  const cards = document.querySelectorAll(".card-dashboard");

  cards.forEach((card) => {
    card.addEventListener("mousemove", function (e) {
      const rect = card.getBoundingClientRect();

      const x = e.clientX - rect.left;

      const y = e.clientY - rect.top;

      card.style.background = `radial-gradient(
                    circle at ${x}px ${y}px,
                    rgba(13,110,253,.06),
                    #fff 70%
                )`;
    });

    card.addEventListener("mouseleave", function () {
      card.style.background = "#fff";
    });
  });
}
