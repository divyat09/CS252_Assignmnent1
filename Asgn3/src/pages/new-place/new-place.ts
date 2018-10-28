import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, ModalController } from 'ionic-angular';
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
  location : any;
  constructor(private placeservice: PlacesService,
  private geolocation: Geolocation,
  private modalCtrl: ModalController) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad NewPlacePage');
  }
  AddPlace(value: {title: string}){
    this.placeservice.addplace(value);
  }
  LocateUser(){
    this.geolocation.getCurrentPosition().then((resp) => {
      console.log('Location fetched');
      this.location = resp;
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
