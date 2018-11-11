import { Component } from '@angular/core';
import { NavController , ModalController, Platform} from 'ionic-angular';
import { PlacesService } from '../../services/places.services';
import { Place } from '../../model/place.model';
import { MapPage } from '../map/map';
import { AlertController } from 'ionic-angular';
import { Geolocation } from '@ionic-native/geolocation';
import { LocationTrackerProvider } from '../../providers/location-tracker/location-tracker';
import { BackgroundGeolocation } from '@ionic-native/background-geolocation';
import { NewPlacePage } from '../new-place/new-place';
import { LoginPage } from '../login/login';
import { RegisterPage } from '../register/register';

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
  places : Place[] = [];
  tooltipEvent: 'hover' | 'press' = 'hover';
  showArrow: boolean = true;
  duration: number = 3000;
  // location : {lat:number,lng:number} = {lat:0,lng:0};
  constructor(public navCtrl: NavController, private placeservice: PlacesService,private geolocation: Geolocation,
  private modalCtrl: ModalController, public alertCtrl: AlertController, public locationTracker: LocationTrackerProvider) {
  }
  ionViewWillEnter(){
    // this.showConfirm();
    this.placeservice.getplaces()
      .then(
        (places)=> this.places = places
      );
    // this.configureBackgroundGeolocation();
  }
  LoadNewPlace(){
    this.navCtrl.push(NewPlacePage)
  }
  Login(){
    this.navCtrl.push(LoginPage)
  }
  Register(){
    this.navCtrl.push(RegisterPage)
  }
  LocateUser(){
    return new Promise<{lat:number,lng:number}>((resolve,reject)=>{
      this.geolocation.getCurrentPosition().then((resp) => {
        console.log('Location fetched');
        // this.location.lat = resp.coords.latitude;
        // this.location.lng = resp.coords.longitude;
        console.log(resp.coords);
        resolve({lat:resp.coords.latitude,lng:resp.coords.longitude});
      }).catch((error) => {
        console.log('Error getting location', error);
        reject();
      });
    });
  }
  // start(){
  //   this.locationTracker.startTracking();
  // }
  // stop(){
  //   this.locationTracker.stopTracking();
  // }
  openmap(place: Place){
    console.log("Inopenmap",place);
    this.modalCtrl.create(MapPage,place.location).present();
  }  
}
