document.addEventListener('DOMContentLoaded', function() {
    if (typeof myStats === 'undefined') {
        console.error('myStats is not defined');
        return;
    }

    console.log('Fetching data from', myStats.ajax_url);

    fetch(myStats.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'my_stats_data'
        })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(response => {
            console.log('Response received:', response);
            if (response.success) {
                var ctx = document.getElementById('myStatsChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'Nombre de Quiz',
                            data: response.data.data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                console.error('Failed to fetch data:', response);
            }
        })
        .catch(error => console.error('Error:', error));
});
