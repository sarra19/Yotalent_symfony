package com.mycompany.myapp.gui;

import com.codename1.charts.ChartComponent;
import com.codename1.charts.models.CategorySeries;
import com.codename1.charts.renderers.DefaultRenderer;
import com.codename1.charts.renderers.SimpleSeriesRenderer;
import com.codename1.charts.util.ColorUtil;
import com.codename1.charts.views.PieChart;
import com.codename1.ui.Form;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.services.Stat;
import com.mycompany.myapp.services.StatServiceA;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;
import java.util.concurrent.ThreadLocalRandom;

public class PieChartFormA extends BaseForm {

    Form current;
    ArrayList<Stat> stats;

    public PieChartFormA(Resources res, Form previous) {

        this.stats = StatServiceA.getInstance().getStats();
        //Toolbar tb = new Toolbar(true);
        current = this;
        // Generate the values
        List<Double> valuesList = new ArrayList<>();
        List<String> labelList = new ArrayList<>();
       //  int[] colors = new int[stats.size()];

        System.out.println("begin" + stats.size());
        int i = 0;
        for (Stat s : stats) {
            Double value = Double.valueOf(Integer.parseInt(s.getValue() + ""));
            valuesList.add(value);
            labelList.add(s.getLabel());
           

        }

        Double[] values = new Double[stats.size()];
        String[] labels = new String[stats.size()];
        labels = labelList.toArray(labels);
        values = valuesList.toArray(values);

        CategorySeries series = new CategorySeries("chat avion");
        int k = 0;
        for (double value : values) {
            series.add(labels[k], value);
          //  int randomNum = ThreadLocalRandom.current().nextInt(255, 255 );
          //  colors[k]=randomNum;
            k++;
        }

        // Set up the renderer
        int[] colors = new int[]{ColorUtil.BLUE, ColorUtil.GREEN, ColorUtil.MAGENTA, ColorUtil.YELLOW, ColorUtil.CYAN, ColorUtil.CYAN, ColorUtil.CYAN};
        DefaultRenderer renderer = buildCategoryRenderer(colors);
        renderer.setChartTitleTextSize(50);
        renderer.setDisplayValues(true);
        renderer.setShowLabels(true);
        renderer.setLabelsTextSize(50);

        // Create the chart ... pass the values and renderer to the chart object.
        PieChart chart = new PieChart(series, renderer);

        // Wrap the chart in a Component so we can add it to a form
        // Wrap the chart in a Component so we can add it to a form
        ChartComponent c = new ChartComponent(chart);

// Set the layout manager of the form to BorderLayout
        setLayout(new BorderLayout());

// Add the chart component to the form
        add(BorderLayout.CENTER, c);

    }

    /**
     * Creates a renderer for the specified colors.
     */
    private DefaultRenderer buildCategoryRenderer(int[] colors) {
        DefaultRenderer renderer = new DefaultRenderer();
        renderer.setLabelsTextSize(15);
        renderer.setLegendTextSize(50);
        renderer.setMargins(new int[]{20, 30, 15, 0});
        for (int color : colors) {
            SimpleSeriesRenderer r = new SimpleSeriesRenderer();
            r.setColor(color);
            renderer.addSeriesRenderer(r);
        }
        return renderer;
    }

    /**
     * Builds a category series using the provided values.
     *
     * @param title the series titles
     * @param values the values
     * @return the category series
     */
    protected CategorySeries buildCategoryDataset(String title, Double[] values) {
        CategorySeries series = new CategorySeries(title);
        int k = 0;
        for (double value : values) {
            series.add("", value);
            k++;
        }
        return series;
    }

}
