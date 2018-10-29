import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, ModalController, Nav } from 'ionic-angular';
import { PlacesService } from '../../services/places.services';
import { Geolocation } from '@ionic-native/geolocation';
import { MapPage } from '../map/map';
// import Geolocation
/**
 * Generated class for the NewPlacePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-new-place',
  templateUrl: 'new-place.html',
})
export class NewPlacePage {
  location : {lat:number,lng:number} = {lat:0,lng:0};
  constructor(private placeservice: PlacesService,
  private geolocation: Geolocation,
  private modalCtrl: ModalController,
  private NavCtrl: NavController) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad NewPlacePage');
  }
  AddPlace(value: {title: string}){
    this.NavCtrl.pop();
    this.placeservice.addplace({title:value.title,location:this.location});
  }
  LocateUser(){
    this.geolocation.getCurrentPosition().then((resp) => {
      console.log('Location fetched');
      this.location.lat = resp.coords.latitude;
      this.location.lng = resp.coords.longitude;
      // resp.coords.latitude
      // resp.coords.longitude
    }).catch((error) => {
      console.log('Error getting location', error);
    });

  }
  openmap(){
    this.modalCtrl.create(MapPage,this.location).present();
  }

}
