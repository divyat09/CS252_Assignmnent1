import { Component } from '@angular/core';
import { IonicPage, ViewController, NavParams } from 'ionic-angular';
import L from "leaflet";
/**
 * Generated class for the MapPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-map',
  templateUrl: 'map.html',
})
export class MapPage {
  lat:number = 0;
  lng:number = 0;
  map : L.map;
  center: L.PointTuple;
  constructor(private viewCtrl: ViewController, private navparams:NavParams) {
    this.lat = navparams.data.coords.latitude;
    this.lng = navparams.data.coords.longitude;
    console.log(this.lat,this.lng);
  }
  ionViewDidLoad() {
    console.log('ionViewDidLoad MapPage');
    this.center = [this.lat, this.lng];
    this.leafletMap();
  }
  leafletMap(){
    this.map = L.map('mapId', {
      center: this.center,
      zoom: 16
    });

    var position = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
      attribution: 'edupala.com © ionic LeafLet'
    }).addTo(this.map);
    var marker = new L.marker([this.lat, this.lng]).addTo(this.map)
      .bindPopup('You are here')
      .openPopup();
    // var marker = new L.Marker(this.center);
    // this.map.addLayer(marker);

    // marker.bindPopup("<p>Tashi Delek.<p>Delhi</p>");
  }
  
  Dismiss(){
    this.viewCtrl.dismiss();
  }
}
