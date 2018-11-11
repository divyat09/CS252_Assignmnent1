import { Component } from '@angular/core';
import { NavController , ModalController} from 'ionic-angular';
import { PlacesService } from '../../services/places.services';
import { Place } from '../../model/place.model';
import { MapPage } from '../map/map';
import { AlertController } from 'ionic-angular';
import { Geolocation } from '@ionic-native/geolocation';

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
  places : Place[] = [];
  // location : {lat:number,lng:number} = {lat:0,lng:0};
  constructor(public navCtrl: NavController, private placeservice: PlacesService,private geolocation: Geolocation,
  private modalCtrl: ModalController, public alertCtrl: AlertController) {

  }
  ionViewWillEnter(){
    this.showConfirm();
    this.placeservice.getplaces()
      .then(
        (places)=> this.places = places
      );
    
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

  openmap(place: Place){
    console.log("Inopenmap",place);
    this.modalCtrl.create(MapPage,place.location).present();
  }
  showConfirm() {
    const confirm = this.alertCtrl.create({
      title: 'Train tracking',
      message: 'Are you on a train?',
      buttons: [
        {text: 'Yes',handler: () => {this.showPrompt();} },
        {text: 'No',handler: () => {console.log('Agree clicked');} }
      ]
    });
    confirm.present();
  }
  showPrompt() {
    const prompt = this.alertCtrl.create({
      title: 'Train tracking',
      message: "Enter the train number",
      inputs: [
        {
          name: 'title',
          placeholder: 'Title'
        },
      ],
      buttons: [
        {
          text: 'Cancel',
          handler: data => {
            console.log('Cancel clicked');
          }
        },
        {
          text: 'Submit',
          handler: data => {
            this.LocateUser().then((loc)=>{
              console.log("Location is",loc);
              console.log("Setting it now");
              this.placeservice.addplace({train_no:data['title'],location:loc,count:1});
            });
          }
        }
      ]
    });
    prompt.present();
  }
  
}
