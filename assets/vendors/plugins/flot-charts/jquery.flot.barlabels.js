/**
* Bar Labels Plugin for flot.
* https://github.com/cleroux/flot.barlabels
*/
(function ($) {

    var positions = {
        middle: 0,
        base: 1,
        end: 2,
        outside: 3
    };

    var options = {
        series: {
            labels: {
                show: true,
                font: "flot-bar-label",
                labelFormatter: function(v) {return v;},
                position: "middle",
                padding: 4
            }
        }
    };

    function init(plot, classes) {

        var Canvas = classes.Canvas;
        var barLabels = null;

        plot.hooks.draw.push(function(plot, ctx) {

            var placeholder = plot.getPlaceholder();
            if (barLabels == null) {
                barLabels = new Canvas("flot-bar-labels", placeholder);
                console.log("Created new canvas");
            }
            $(placeholder).find(".flot-bar-labels > .flot-bar-label").remove();

            // Move the labels layer under the overlay to preserve flot interactivity

            var labelsEl = barLabels.element;
            var target = $(labelsEl.parentElement).children(".flot-overlay:first");
            $(labelsEl).insertBefore(target);

            var angle = 0;
            var halign = "center";
            var valign = "middle";
            var layer = "flot-bar-labels";
            $.each(plot.getData(), function(ii, series) {
                if (!series.bars.show || !series.labels.show) {
                    return;
                }

                for (var i = 0; i < series.data.length; i++) {
                    var text = null;
                    var x = series.datapoints.points[i*series.datapoints.pointsize];
                    var y = series.data[i][1];
                    var b = series.data[i].length > 2 ? series.data[i][2] : 0;
                    var px = null;
                    var py = null;
                    var lf = series.labels.labelFormatter;
                    var width;
                    var pos = positions[series.labels.position];

                    if (plot.getOptions().series.bars.horizontal) {
                        width = series.xaxis.p2c(x);
                        px = series.xaxis.p2c(x) + plot.getPlotOffset().left;
                        py = series.yaxis.p2c(y) + plot.getPlotOffset().top;
                        var pb = series.xaxis.p2c(b) + plot.getPlotOffset().left;
                        text = lf ? lf(x-b, series) : x-b;
                        var textInfo = barLabels.getTextInfo(layer, text, series.labels.font, angle, width);
                        if (Math.abs((series.xaxis.p2c(0) - width)) - series.labels.padding < textInfo.width) {
                            pos = positions.outside;
                        }

                        if (pos == positions.outside) {
                            if (x >= 0) {
                                halign = "left";
                                px += series.labels.padding;
                            } else {
                                halign = "right";
                                px -= series.labels.padding;
                            }
                        } else if (pos == positions.end) {
                            if (x >= 0) {
                                halign = "right";
                                px -= series.labels.padding;
                            } else {
                                halign = "left";
                                px += series.labels.padding;
                            }
                        } else if (pos == positions.base) {
                            if (x >= 0) {
                                halign = "left";
                                px = pb + series.labels.padding;
                            } else {
                                halign = "right";
                                px = pb - series.labels.padding;
                            }
                        } else {
                            halign = "center";
                            px = pb + ((px - pb) / 2);
                        }
                    } else {
                        width = series.xaxis.p2c(series.bars.barWidth);
                        px = series.xaxis.p2c(x) + plot.getPlotOffset().left;
                        py = series.yaxis.p2c(y) + plot.getPlotOffset().top;
                        var pb = series.yaxis.p2c(b) + plot.getPlotOffset().top;
                        text = series.labels.labelFormatter(y - b, series);
                        var textInfo = barLabels.getTextInfo(layer, text, series.labels.font, angle, width);
                        if (Math.abs((series.yaxis.p2c(0) - series.yaxis.p2c(y))) - series.labels.padding < textInfo.height) {
                            pos = positions.outside;
                        }

                        if (pos == positions.outside) {
                            if (y >= 0) {
                                valign = "bottom";
                                py -= series.labels.padding;
                            } else {
                                valign = "top";
                                py += series.labels.padding;
                            }
                        } else if (pos == positions.end) {
                            if (y >= 0) {
                                valign = "top";
                                py += series.labels.padding;
                            } else {
                                valign = "bottom";
                                py -= series.labels.padding;
                            }
                        } else if (pos == positions.base) {
                            if (y >= 0) {
                                valign = "bottom";
                                py = pb - series.labels.padding;
                            } else {
                                valign = "top";
                                py = pb + series.labels.padding;
                            }
                        } else {
                            valign = "middle";
                            py = pb + ((py - pb) / 2);
                        }
                    }

                    barLabels.addText(layer, px, py, text, series.labels.font, angle, width, halign, valign);
                }
            });
            barLabels.render();
        });
    }

    $.plot.plugins.push({
        init: init,
        options: options,
        name: "barlabels",
        version: "1.0"
    });
})(jQuery);
