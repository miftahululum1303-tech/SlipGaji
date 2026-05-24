<footer class="footer mt-auto py-3 bg-white border-top">
    <div class="container-fluid px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-muted small">
            <div>
                <span class="badge bg-success border-0 me-2"><i class="fa-solid fa-circle text-white me-1"></i> Connected</span>
                <span><?= date('D, d M Y'); ?></span>
            </div>
            <div class="mt-2 mt-md-0">
                Developed by <strong>Miftahul Ulum</strong> &copy; <?= date('Y'); ?>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        // Sidebar Toggle
        $('#sidebarToggle').click(function() {
            $('#sidebar').toggleClass('collapsed');
            $('.content-wrapper').toggleClass('expanded');
        });

        // DataTable Initialization
        $('#myTable').DataTable({
            responsive: true,
            language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' }
        });

        // Chart.js Example
        const ctx = document.getElementById('myChart');
        if(ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Persediaan Barang',
                        data: [12, 19, 3, 5, 2, 3],
                        borderColor: '#3e7ccb',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(62, 124, 203, 0.1)'
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
        }
    });
</script>
</body>
</html>