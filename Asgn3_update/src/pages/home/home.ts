import { Component } from '@angular/core';
import { NavController , ModalController} from 'ionic-angular';
import { NewPlacePage } from '../new-place/new-place';
import { PlacesService } from '../../services/places.services';
import { Place } from '../../model/place.model';
import { MapPage } from '../map/map';

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
  places : Place[] = [];
  constructor(public navCtrl: NavController, private placeservice: PlacesService,
  private modalCtrl: ModalController) {

  }
  ionViewWillEnter(){
    this.places = this.placeservice.getplaces();
  }
  LoadNewPlace(){
    this.navCtrl.push(NewPlacePage);
  }
  openmap(place: Place){
    this.modalCtrl.create(MapPage,place.location).present();
  }
}
