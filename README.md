# Weather-module (kmom04, ramverk1)

1. Run <code>composer require mabw/weather-module</code>. 

2. Go to <code>vendor/mabw/weather-module</code>.

3. Move <code>config/di/weather.php</code> into your own di-folder. 

4. Move the routes in <code>config/router</code> to your own router-folder.

5. Move the <code>config/keys.php</code> to your own config-folder and add your own api-keys.

6. In your <code>config/view.php</code> add the path <code>ANAX_INSTALL_PATH . "/vendor/mabw/weather-module/view"</code>.

7. Move the <code>test/validate</code> to your own test-folder. Make sure to move the folder <code>Validate</code> and not individual files for everything to work as expected. 