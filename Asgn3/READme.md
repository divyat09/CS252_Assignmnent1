Start a new ionic project :
ionic start <project name> sidemenu

cd into the project
Replace the src and resources folders with the ones given in this repository <br />
Add geolocation:
ionic cordova plugin add cordova-plugin-geolocation --variable GEOLOCATION_USAGE_DESCRIPTION="To locate you"
npm install --save @ionic-native/geolocation


Add leaflet:
npm install leaflet

Now type :
ionic serve
A tab opens in a window, click on + icon in My Places bar, click on loacte me to get your coordinates and then click on opne map
to view your location on map.
