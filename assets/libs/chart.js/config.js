MyColors = palette('tol-rainbow', MyData.length);                                            
MyColors = MyColors.map(function(el) { 
    return '#' + el; 
}) 

var canvas = document.getElementById(placement);
var ctx = canvas.getContext('2d');


var data = {
    labels: MyLabels,
    datasets: [
        {
            data: MyData,
            backgroundColor: MyColors,
        },
    ],        
};



var options = {

    responsive: true,   
    animation:{
        animateRotate:true,
        //easing:'easeInElastic',
    } ,

    legend: false,
    legendCallback: function(chart) {
        var legendHtml = [];
        legendHtml.push('<ul>');
        var item = chart.data.datasets[0];
        for (var i=0; i < item.data.length; i++) {
            legendHtml.push('<li rel="tooltip" title="'+ item.data[i] +' عنوان">');
            legendHtml.push('<span class="chart-legend" style="background-color:' + item.backgroundColor[i] +'"></span>');
            legendHtml.push('<span class="chart-legend-label-text">'+chart.data.labels[i]+'</span>');
            legendHtml.push('</li>');
        }

        legendHtml.push('</ul>');
        return legendHtml.join("");
    },

    tooltips: { 

        bodyFontColor: "#000000", //#000000
        bodyFontSize: 16,
        bodySpacing: 4,
        bodyFontColor: '#FFFFFF',
        bodyFontFamily: "'Droid Arabic Naskh', 'Arial', sans-serif",
        titleMarginBottom:0,
        footerMarginTop:0,
        xPadding : 12,
        yPadding : 12,
    },        

};


// Chart declaration:
var MyChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});


$('#my-legend-con').html(MyChart.generateLegend());