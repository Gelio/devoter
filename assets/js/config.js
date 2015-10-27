var resizeUpdateDelay = 500,
    minPollLength = 5*60;

// Additional chart colors
var chartColors = [
    '#793B89',
    '#2F3C4F',
    '#8AC4FF',
    '#FCF8A6',
    '#B15858',
    '#FBB040',
    '#068B78',
    '#DE703C',
    '#E5A0DC',
    '#AA1111'
];

var globalColors = Chart.defaults.global.colours;
chartColors.forEach(function(color) {
    globalColors.push(color);
});


// Display httpRequest and response
var production = true;