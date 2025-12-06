import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/style.css', 
                'resources/lib/font-awesome/css/font-awesome.css', 
                'resources/lib/Ionicons/css/ionicons.css', 
                'resources/lib/perfect-scrollbar/css/perfect-scrollbar.css', 
                'resources/lib/jquery-switchbutton/jquery.switchButton.css', 
                'resources/lib/rickshaw/rickshaw.min.css', 
                'resources/lib/chartist/chartist.css', 
                'resources/lib/jquery/jquery.js',
                'resources/lib/popper.js/popper.js',
                'resources/lib/bootstrap/bootstrap.js',
                'resources/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
                'resources/lib/moment/moment.js',
                'resources/lib/jquery-ui/jquery-ui.js',
                'resources/lib/jquery-switchbutton/jquery.switchButton.js',
                'resources/lib/peity/jquery.peity.js',
                'resources/lib/chartist/chartist.js',
                'resources/lib/jquery.sparkline.bower/jquery.sparkline.min.js',
                'resources/lib/d3/d3.js',
                'resources/lib/rickshaw/rickshaw.min.js',
                'resources/js/bracket.js',
                'resources/js/ResizeSensor.js',
                'resources/js/dashboard.js',
            ],
            refresh: true,
        }),
    ],
});
