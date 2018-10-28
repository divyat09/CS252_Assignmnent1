Start a new ionic project :<br />
ionic start 'project name' sidemenu

cd into the project
Replace the src and resources folders with the ones given in this repository <br />
Add geolocation:<br />
ionic cordova plugin add cordova-plugin-geolocation --variable GEOLOCATION_USAGE_DESCRIPTION="To locate you"<br />
npm install --save @ionic-native/geolocation<br />


Add leaflet:<br />
npm install leaflet<br />

Now type :<br />
ionic serve<br />
A tab opens in a window, click on + icon in My Places bar, click on loacte me to get your coordinates and then click on opne map
to view your location on map.<br /><br />
To run on phone<br />
ionic cordova platform add android<br /><br />

Might need this link for path setup<br />
https://stackoverflow.com/questions/10969753/android-command-not-found<br /><br />


ionic cordova run android<br />
