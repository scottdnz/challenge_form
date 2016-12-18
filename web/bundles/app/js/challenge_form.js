/* JS Doc. Requires jQuery */

var main = (function () {

    /**
     * Creates an object and configures its settings using Chart.js.
     */
    var createChart = function(respData, currentServer) {
        var ctx = $("#chartServerList");
        var currentChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: respData["dataLabels"],
                datasets: [
                    {
                        label: "Current dataset",
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: "butt",
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: "miter",
                        pointBorderColor: "rgba(75,192,192,1)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(75,192,192,1)",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: respData["dataPoints"],
                        spanGaps: false,
                    }
               ]
            },
            options: {
                responsive: true,
                title: {
                    text: "Server Statistics for " + currentServer,
                    display: true,
                    fontSize: 16
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }],
                    xAxes: [{
                        type: "time",
                        time: {
                            displayFormats: {
                                hour: "MMM D YYYY, hA"
                            }
                        },
                        ticks: {
                            autoSkip: true,
                            maxRotation: 45,
                            minRotation: 45 
                        }
                    }]
                }
            }
        });
    };           
         
                
    // jQuery "kicks off"
    $(document).ready(function() {
        /**
         * When the select Box option changes, call a web service URL and
         * fill in the chartServerList box or the messageArea box. 
         */
        $("#selServer").change(function() {
            var currentServer = this.value;
            $("#messageArea").html("");
            $("#confirmationArea").html("");    
            if (currentServer  == "placeholder") {
                $("#messageArea").html("Please choose");
                return false;        
            }        
            /* Call the little web service that gives us custom line graph
             * data labels and points from Sublime's API */ 
            $.ajax({
                url: "/server-api/stats/" + currentServer,
                timeout: 4000,
                dataType: "json",
                success: function(respData) {
                    if (respData["result"] != "ok") {
                        $("#messageArea").html(respData["errors"]);
                    }
                    createChart(respData, currentServer);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#messageArea").html("Error in Ajax call. Status: " + 
                    xhr.status + ", error type: " + thrownError);
                },
                complete: function() {
                    $("#confirmationArea").html("Called API successfully");    
                }
            });                 

        }); // End of selServer change event function
    
    }); // End of jQuery scope

}()); // End of self-exec function