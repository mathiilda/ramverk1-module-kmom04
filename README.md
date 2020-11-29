# Weather-module (kmom04, ramverk1)

1. Run <code>composer require mabw/weather-module</code>. 

4. Go to <code>vendor/mabw/weather-module</code>.

5. Move <code>config/di/weather.php</code> into your own di-folder. 

6. Move the routes in <code>config/router</code> to your own router-folder.

7. Move the <code>config/keys.php</code> to your own config-folder and add your own api-keys.

8. All the folders named <code>Validate</code> in the folders src, test and view should be moved to your own folders (with the same names). Make sure to move the folder <code>Validate</code> and not individual files for everything to work as expected. 