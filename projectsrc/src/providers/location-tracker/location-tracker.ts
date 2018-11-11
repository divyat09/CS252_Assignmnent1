import { HttpClient } from '@angular/common/http';
import { Injectable, NgZone } from '@angular/core';
import { Geolocation, Geoposition } from '@ionic-native/geolocation';
import { BackgroundGeolocation } from '@ionic-native/background-geolocation';
import 'rxjs/add/operator/filter';
import { PlacesService } from '../../services/places.services';
/*
  Generated class for the LocationTrackerProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class LocationTrackerProvider {
  public watch: any;   
  public lat: number = 0;
  public lng: number = 0;
  public train_no: string = "";
  constructor(public zone: NgZone,
  public geolocation : Geolocation,
  public backgroundGeolocation: BackgroundGeolocation,
  private placeservice: PlacesService) {
 
  }
 
  startTracking(tn:string) {
    let config = {
      desiredAccuracy: 0,
      stationaryRadius: 0,
      distanceFilter: 0,
      debug: true,
      interval: 2000
    };
    this.train_no = tn;
    this.backgroundGeolocation.configure(config).subscribe((location) => {
   
      console.log('BackgroundGeolocation:  ' + location.latitude + ',' + location.longitude);
      
      // Run update inside of Angular's zone
      this.zone.run(() => {
        this.lat = location.latitude;
        this.lng = location.longitude;
      });
      this.placeservice.addplace({train_no:this.train_no,location:{lat:this.lat,lng:this.lng},count:1});
   
    }, (err) => {
   
      console.log(err);
   
    });
   
    // Turn ON the background-geolocation system.
    this.backgroundGeolocation.start();
   
   
    //Foreground Tracking
   
    let options = {
      frequency: 3000,
      enableHighAccuracy: true
    };
   
    this.watch = this.geolocation.watchPosition(options).filter((p: any) => p.code === undefined).subscribe((position: Geoposition) => {
 
      console.log(position);
     
      // Run update inside of Angular's zone
      this.zone.run(() => {
        this.lat = position.coords.latitude;
        this.lng = position.coords.longitude;
      });
     
    });
    
    
  }
 
  stopTracking() {
    console.log('stopTracking');
 
    this.backgroundGeolocation.finish();
    this.watch.unsubscribe();
 
  }

}
