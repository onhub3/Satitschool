$(document).ready(function() {
    // Sidebar Toggle
    $('#sidebarToggleBtn').on('click', function() {
        if ($(window).width() <= 991) {
            $('#sidebar').toggleClass('show');
        } else {
            $('#sidebar').toggleClass('toggled');
            $('.content-wrapper').toggleClass('expanded');
        }
    });

    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 991) {
            if (!$(e.target).closest('#sidebar').length && !$(e.target).closest('#sidebarToggleBtn').length && $('#sidebar').hasClass('show')) {
                $('#sidebar').removeClass('show');
            }
        }
    });

    // Submenu chevron animation
    $('.nav-link[data-bs-toggle="collapse"]').on('click', function() {
        var icon = $(this).find('.fa-chevron-down, .fa-chevron-up');
        if ($(this).attr('aria-expanded') === 'true') {
            icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        } else {
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    });
    
    // Initialize Dashboard Charts
    if ($('#attendanceChart').length) {
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์'],
                datasets: [{
                    label: 'นักเรียนที่มาเรียน (%)',
                    data: [95, 96, 92, 98, 90],
                    backgroundColor: 'rgba(254, 158, 199, 0.7)',
                    borderColor: '#FE9EC7',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    }

    if ($('#gradeChart').length) {
        var ctx2 = document.getElementById('gradeChart').getContext('2d');
        var gradeChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['เกรด 4', 'เกรด 3', 'เกรด 2', 'เกรด 1', 'เกรด 0'],
                datasets: [{
                    data: [45, 25, 15, 10, 5],
                    backgroundColor: [
                        '#4CAF50', // เกรด 4 - Green
                        '#2196F3', // เกรด 3 - Blue
                        '#FFEB3B', // เกรด 2 - Yellow
                        '#FF9800', // เกรด 1 - Orange
                        '#F44336'  // เกรด 0 - Red
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});
