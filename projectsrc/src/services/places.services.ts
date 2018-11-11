import { Place } from '../model/place.model';
import { Storage } from '@ionic/storage';
import { Injectable } from '@angular/core';
@Injectable()

export class PlacesService{
    private places : Place[] = [];
    constructor (private storage: Storage){}
    addplace(newplace: Place){
        var x: any;
        return this.storage.get('places')
            .then(
                (places)=>{
                    this.places = places
                    for(x in this.places){
                        console.log(this.places[x]);
                        if (this.places[x].train_no == newplace.train_no){
                            console.log("count is 1st ",this.places[x].count);
                            this.places[x].location.lat = newplace.location.lat
                            this.places[x].location.lng = newplace.location.lng
                            this.places[x].count = this.places[x].count+1;
                            console.log("count is 2nd",this.places[x].count);
                            this.storage.set('places',this.places);
                            console.log("this is stored",this.places);
                            return;
                        }
                    }
                    this.places.push(newplace);
                    this.storage.set('places',this.places);
                }
            );     
    }
    getplaces(){
        return this.storage.get('places')
            .then(
                (places)=> {
                    this.places = places == null ? [] : places;
                    console.log(this.places);
                    return this.places.slice();
                }
            );
        // return this.places.slice();
    }
}